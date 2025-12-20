<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class ClassectionsController extends AppController
{
	//initialize component
	public function initialize()
	{
		parent::initialize();
		$this->loadModel('Classections');
		$this->loadModel('Classes');
		$this->loadModel('Sections');
		$this->loadModel('Designations');
		$this->loadModel('Employees');
		$this->loadModel('Timetables');
		$this->loadModel('ClasstimeTabs');
		$this->loadModel('Classteachers');
	}

	public function index()
	{
		$this->viewBuilder()->layout('admin');
		$username = $this->request->session()->read('Auth.User.email');
		//show data in listing
		$classes_data = $this->Classections->find('all')->contain(['Classes', 'Sections', 'Employees'])->where(['Classes.status' => '1', 'Sections.status' => '1'])->order(['Classes.sort' => 'ASC'])->toarray();
		$this->set('classes', $classes_data);
		// pr($classes_data);exit;

		$username = $this->request->session()->read('Auth.User.email');
		$timetable_data = $this->ClasstimeTabs->find('all')->contain(['Timetables', 'Employees', 'Subjects'])->where(['Employees.email' => $username])->order(['ClasstimeTabs.id' => 'ASC'])->toarray();
		$this->set('classesdata', $timetable_data);
	}


	public function classteacher()
	{
		$this->loadModel('Classteachers');
		$this->loadModel('Classections');
		$this->loadModel('Classes');
		$this->loadModel('Employees');
		$this->loadModel('Sections');
		$classes = $this->Classections->find('list', [
			'keyField' => 'Classes.id',
			'valueField' => 'Classes.title'
		])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'asc'])->toArray();
		$this->set('classes', $classes);

		$this->viewBuilder()->layout('admin');
		//show data in listing
		//for Class teachers only

		//$classteachers = $this->Classteachers->find('all')->contain(['Classes','Employees','Sections'])->where(['Classteachers.teacher_type' =>1])->group(['Classteachers.teach_id'])->order(['Classes.sort' => 'ASC'])->toarray();


		$classteachers = $this->Classteachers->find('all')->contain(['Classes', 'Employees', 'Sections'])->order(['Classes.sort' => 'ASC'])->toarray();
		$this->paginate($service_data);
		$this->set('classts', $classteachers);
		$this->request->session()->delete('condition');
		$this->request->session()->write('condition', $classteachers);

		//	pr($classteacher); die;
		$this->set('ids', $id);
	}

	public function classteacher_add($id = null)
	{
		$this->loadModel('Classteachers');
		$this->loadModel('Classections');
		$this->loadModel('Classes');
		$this->loadModel('Employees');
		$this->loadModel('Sections');

		$employees = $this->Employees->find('list', [
			'keyField' => 'id',
			'valueField' => array('fname', 'middlename', 'lname')
		])->order(['fname' => 'ASC'])->toArray();
		//pr($employees); die;
		$this->set('employee', $employees);
		$this->viewBuilder()->layout('admin');

		$classes = $this->Classections->find('list', [
			'keyField' => 'Classes.id',
			'valueField' => 'Classes.title'
		])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'asc'])->toArray();
		$this->set('classes', $classes);
		$sectionslist = $this->Sections->find('list', [
			'keyField' => 'id',
			'valueField' => 'title'
		])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sectionslist', $sectionslist);
		//show data in listing

		$this->set('ids', $id);

		//	pr($classteacher); die;
		if (isset($id) && !empty($id)) {
			$classteacher = $this->Classteachers->get($id);
		} else {
			$classteacher = $this->Classteachers->newEntity();
		}
		if ($this->request->is(['post', 'put'])) {
			// pr($this->request->data); die;

			$classteacher = $this->Classteachers->patchEntity($classteacher, $this->request->data);
			//pr($locations); die;
			if ($this->Classteachers->save($classteacher)) {
				$this->Flash->success(__('Class Teacher added successfully.'));
				return $this->redirect(['action' => 'classteacher']);
			}
		}
		$this->set('classt', $classteacher);
	}

	public function classteachersearch()
	{
		$this->loadModel('Classteachers');
		$this->loadModel('Classections');
		$this->loadModel('Classes');
		$this->loadModel('Employees');
		$this->loadModel('Sections');
		//pr($this->request->data); die;
		$type = $this->request->data['teacher_type'];
		$fname = $this->request->data['fname'];
		//pr($cls); die;
		$class_id = $this->request->data['class_id'];
		$section_id = $this->request->data['section_id'];

		$apk = array();

		if (!empty($type)) {
			$st1 = array('Classteachers.teacher_type' => $type);
			$apk[] = $st1;
		}
		if (!empty($fname)) {
			$st1s = array('Employees.fname LIKE' => trim($fname));
			$apk[] = $st1s;
		}
		if (!empty($class_id)) {
			$st1s = array('Classteachers.class_id' => $class_id);
			$apk[] = $st1s;
		}
		if (!empty($section_id)) {
			$st1s = array('Classteachers.section_id' => $section_id);
			$apk[] = $st1s;
		}



		$clas_teac = $this->Classteachers->find('all')->order(['Classes.sort' => 'ASC', 'Sections.id' => 'ASC'])->contain(['Classes', 'Employees', 'Sections'])->where($apk)->toarray();

		$this->set('classts', $clas_teac);
		$this->request->session()->delete('condition');
		$this->request->session()->write('condition', $clas_teac);
	}

	public function classteacherpdf()
	{
		$this->loadModel('Classteachers');
		$this->loadModel('Classections');
		$this->loadModel('Classes');
		$this->loadModel('Employees');
		$this->loadModel('Sections');
		//pr($this->request->data); die;
		$session = $this->request->session();
		$condition = $session->read('condition');
		$this->sitesetting('general');

		$this->set('t_enquiry', $condition);
	}



	public function find_section($id = null)
	{
		$this->loadModel('Classteachers');
		$this->loadModel('Classections');
		$this->loadModel('Sections');


		$classid = $this->request->data['id'];
		$this->viewBuilder()->layout('admin');
		$sections = $this->Classections->find('list', [
			'keyField' => 'Sections.id',
			'valueField' => 'Sections.title'
		])->contain(['Sections'])->where(['Classections.class_id' => $classid])->order(['Sections.title' => 'ASC'])->toArray();



		echo "<option value=''>---Select Section---</option>";

		foreach ($sections as $sections => $value) {
			echo "<option value=" . $sections . ">" . $value . "</option>";
		}
		die;
	}


	public function classsection_excel()
	{
		$this->autoRender = false;
		$this->loadModel('Sections');
		$this->loadModel('Classections');
		$this->loadModel('Employees');
		$this->loadModel('Classes');
		$this->loadModel('Timetables');

		ini_set('max_execution_time', 1600);
		$headerRow = array("ID", "Class", "Section.", "Teachers");
		$output = implode("\t", $headerRow) . "\n";
		$t_enquiry = $this->Classections->find('all')->order(['Classections.id' => 'ASC'])->toarray();
		//pr($t_enquiry); die;

		foreach ($t_enquiry as $people) { //pr($people); die;
			$cid = $people['class_id'];
			$sid = $people['section_id'];
			$tid = explode(',', $people['teacher_id']);

			$clsname = $this->Classes->find('all')->where(['Classes.id' => $cid])->first();
			$secname = $this->Sections->find('all')->where(['Sections.id' => $sid])->first();
			$nam = array();
			foreach ($tid as $t) {
				$empname = $this->Employees->find('all')->select(['fname', 'middlename', 'lname'])->where(['Employees.id' => $t])->first();
				//pr($empname);
				$nam[] = ucwords(strtolower($empname['fname'])) . ' ' . ucwords(strtolower($empname['middlename'])) . ' ' . ucwords(strtolower($empname['lname']));
			}

			$s = implode("\r\t\t\t", $nam);
			$result = array();
			$str = "";
			$result[] = $people['id'];
			$result[] = $clsname['title'];
			$result[] = $secname['title'];
			$result[] = $s;
			$output .=  implode("\t", $result) . "\n";
		}
		//echo $output; die;
		$filename = "classsection.xls";
		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		die;
	}

	public function classbyteacher($id = null)
	{

		$id = $this->request->data['id'];

		if ($id == 1 || $id == 2 || $id == 3 || $id == 4 || $id == 6 || $id == 18 || $id == 19) {
			$nu = 'Primary';

			$emp = $this->Employees->find('list', [
				'keyField' => 'id',
				'valueField' => array('fname', 'middlename', 'lname')
			])->where(['FIND_IN_SET(\'' . $nu . '\',Employees.slab_type)'])->order(['Employees.fname' => 'ASC'])->toarray();
			$this->set('designations', $emp);
		} else if ($id == 7 || $id == 8 || $id == 9 || $id == 23 || $id == 24 || $id == 6) {

			$vu = 'Upper_Primary';
			$emp = $this->Employees->find('list', [
				'keyField' => 'id',
				'valueField' => array('fname', 'middlename', 'lname')
			])->where(['FIND_IN_SET(\'' . $vu . '\',Employees.slab_type)'])->order(['Employees.fname' => 'ASC'])->toarray();
			$this->set('designations', $emp);
		} else if ($id == 10 || $id == 11 || $id == 25 || $id == 6) {

			$mu = 'Secondry';
			$emp = $this->Employees->find('list', [
				'keyField' => 'id',
				'valueField' => array('fname', 'middlename', 'lname')
			])->where(['FIND_IN_SET(\'' . $mu . '\',Employees.slab_type)'])->order(['Employees.fname' => 'ASC'])->toarray();
			$this->set('designations', $emp);
		} else {

			$cu = 'Senior';
			$emp = $this->Employees->find('list', [
				'keyField' => 'id',
				'valueField' => array('fname', 'middlename', 'lname')
			])->where(['FIND_IN_SET(\'' . $cu . '\',Employees.slab_type)'])->order(['Employees.fname' => 'ASC'])->toarray();
			$this->set('designations', $emp);
		}

		$emp = $this->Employees->find('list', [
			'keyField' => 'id',
			'valueField' => array('fname', 'middlename', 'lname')
		])->order(['Employees.fname' => 'ASC'])->toarray();

		// pr($emp);die;
		$this->set('designations', $emp);
	}


	public function add($id = null)
	{
		$this->viewBuilder()->layout('admin');

		$designations = $this->Employees->find('list', [
			'keyField' => 'id',
			'valueField' => array('fname', 'middlename', 'lname')
		])->contain(['Designations'])->where(['Designations.name' => 'Teacher'])->toarray();

		$this->set('designations', $designations);

		$classeslist = $this->Classes->find('list', [
			'keyField' => 'id',
			'valueField' => 'title'
		])->where(['status' => '1'])->order(['sort' => 'ASC'])->toArray();
		$this->set('classeslist', $classeslist);

		$sectionslist = $this->Sections->find('list', [
			'keyField' => 'id',
			'valueField' => 'title'
		])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sectionslist', $sectionslist);

		// $classes_data = $this->Classections->find('all')->contain(['Classes', 'Sections', 'Employees'])->where(['Classes.status' => '1', 'Sections.status' => '1'])->order(['Classes.sort' => 'ASC'])->toarray();

		if (isset($id) && !empty($id)) {
			$classes = $this->Classections->get($id);
			$class_id = $classes->class_id;
			$section_id = $classes->section_id;
			$teacher_id = $classes->teacher_id;
			$this->set('classid', $class_id);
		} else {
			//using for new entry
			$classes1 = $this->Classections->newEntity();
			$this->request->data['status'] = '1';
		}
		if ($this->request->is(['post', 'put'])) {

			$tid = implode(',', $this->request->data['teacher_id']);
			$this->request->data['teacher_id'] = $tid;

			if ($this->request->data['self_strength'] <= $this->request->data['capacity']) {
				$userTable = TableRegistry::get('Classections');
				$exists = $userTable->exists(['class_id' => $this->request->data['class_id'], 'section_id' => $this->request->data['section_id']]);

				$teacher_exists = $this->Classections->find('all')->where(['Classections.teacher_id' => $this->request->data['teacher_id']])->count();

				if ($class_id == $this->request->data['class_id'] && $section_id == $this->request->data['section_id']) {

					$classes = $this->Classections->patchEntity($classes1, $this->request->data);

					if ($this->Classections->save($classes)) {
						if ($this->request->data['teacher_id']) {
							$conn = ConnectionManager::get('default');
							$employe = $this->Employees->find('all')->where(['Employees.id' => $this->request->data['teacher_id']])->first()->toarray();
							$email = $employe['email'];
							$detail = 'UPDATE `users` SET `role_id` ="3" WHERE `users`.`email` = "' . $email . '"';
							$results = $conn->execute($detail);
						}

						$this->Flash->success(__('Your Class sections has been saved.'));
						return $this->redirect(['action' => 'index']);
					} else { //pr($classes->errors());
						//validation error


						if ($classes->errors()) {
							$error_msg = [];
							foreach ($classes->errors() as $errors) {
								if (is_array($errors)) {
									foreach ($errors as $error) {
										$error_msg[]    =   $error;
									}
								} else {
									$error_msg[]    =   $errors;
								}
							}
							if (!empty($error_msg)) {
								$this->Flash->error(
									__("Please fix the following error(s): " . implode("\n \r", $error_msg))
								);
							}
						}
					}
				} else {

					//	pr($this->request->data); die;

					// save all data in database
					$classes = $this->Classections->patchEntity($classes1, $this->request->data);
					//pr($classes1); die;
					if ($this->Classections->save($classes)) {
						$this->Flash->success(__('Your Class sections has been saved.'));
						return $this->redirect(['action' => 'index']);
					} else { //pr($classes->errors());
						//validation error
						if ($classes->errors()) {
							$error_msg = [];
							foreach ($classes->errors() as $errors) {
								if (is_array($errors)) {
									foreach ($errors as $error) {
										$error_msg[]    =   $error;
									}
								} else {
									$error_msg[]    =   $errors;
								}
							}
							if (!empty($error_msg)) {
								$this->Flash->error(
									__("Please fix the following error(s): " . implode("\n \r", $error_msg))
								);
							}
						}
					}
				}
			} else {

				$this->Flash->error(__('Capacity Should Be Grater than Strength'));
				return $this->redirect(['action' => 'add']);
			}
		}
		$this->set('classes', $classes);
	}


	public function sort()
	{
		$this->viewBuilder()->layout('admin');
		$id = $this->request->data[id];
		if (isset($id) && !empty($id)) {
			//using for edit
			$classes = $this->Classections->get($id);
		} else {
			//using for new entry
			$classes = $this->Classections->newEntity();
		}

		if ($this->request->is(['post', 'put'])) {

			//$this->request->data = $this->request->data['sort']; 
			$classes->sort = $this->request->data['sort'];

			if ($this->Classections->save($classes)) {
				echo $classes['sort'];
			} else {
				echo 'wrong';
			}
		}
		die;
	}
	//view functionality
	public function view($id)
	{
		$this->viewBuilder()->layout('admin');
		//get data from paricular id
		$classes_data = $this->Classections->find('all')->where(['Classections.id' => $id])->contain(['Classes', 'Sections', 'Employees'])->order(['Classections.id' => 'ASC'])->toarray();
		//$this->paginate($service_data);
		$this->set('classes', $classes_data);
	}
	//delete functionality
	public function delete($id)
	{
		//$this->request->allowMethod(['post', 'delete']);
		$classes = $this->Classections->get($id);
		$tid = $classes['teacher_id'];
		$conn = ConnectionManager::get('default');


		$employe = $this->Employees->find('all')->where(['Employees.id' => $tid])->first()->toarray();
		$email = $employe['email'];

		$detail = 'UPDATE `users` SET `role_id` ="0" WHERE `users`.`email` = "' . $email . '"';

		$results = $conn->execute($detail);
		try {

			//delete pariticular entry
			if ($this->Classections->delete($classes)) {
				$this->Flash->success(__('The class sections with id: {0} has been deleted.', h($id)));
				return $this->redirect(['action' => 'index']);
			}
		} catch (\PDOException $e) {
			//  $error = 'The item you are trying to delete is associated with other records';
			$this->Flash->error(__('You can not delete this record because it is used in another table.'));
			$this->set('error', $error);
			//$this->Session->setFlash(__(' Lader all ready exists), 'flash/Error');
			return $this->redirect(['action' => 'index']);
		}
	}
	//status update functionality
	public function status($id, $status)
	{
		$statusquery = $this->Classections->find('all')->where(['Classections.status' => 'Y'])->count();
		if (isset($id) && !empty($id)) {
			if ($status == 'Y') {

				$status = 'N';
				//status update
				$classes = $this->Classections->get($id);
				$classes->status = $status;
				if ($this->Classections->save($classes)) {
					$this->Flash->success(__('Your class sections has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			} else {

				$status = 'Y';
				//status update
				$classes = $this->Classections->get($id);
				$classes->status = $status;
				if ($this->Classections->save($classes)) {
					$this->Flash->success(__('Your class sections has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			}
		}
	}

	//--------------------------------------------------------------------------------------------
	public function addcsv()
	{
		$this->viewBuilder()->layout('admin');

		if ($this->request->is('post') || $this->request->is('put')) {
			//pr($this->request->data);

			if (
				($this->request->data['file']['type'] == 'application/csv') ||
				($this->request->data['file']['type'] == 'application/vnd.ms-excel') ||
				($this->request->data['file']['type'] == 'text/csv')
			) {
				$filenam = $this->request->data['file']['name'];
				$tmp_file = $this->request->data['file']['tmp_name'];
				$mkr1 = rand(1, 13000000);
				//   $imagename1=$filename1.'.'.;
				$filename = $mkr1 . $filenam;
				if (move_uploaded_file($tmp_file, "excel_file/" . $filename)) {
					$this->csv($filename);
					$this->Flash->success(__('File has been uploaded successfully!'));
				}
				$directory = WWW_ROOT . 'excel_file/' . $filename;

				unlink($directory);

				$directory2 = WWW_ROOT . 'excel_file/' . $mkr1;
				unlink($directory2);

				$this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('File type must be csv only'));
			}
		}
	}

	//delete functionality
	public function deleteclassteacher($id)
	{
		$classes = $this->Classteachers->get($id);
		try {
			//delete pariticular entry
			if ($this->Classteachers->delete($classes)) {
				$this->Flash->success(__('The Class teacher with id: {0} has been modified.', h($id)));
				return $this->redirect(['action' => 'classteacher']);
			}
		} catch (\PDOException $e) {
			//  $error = 'The item you are trying to delete is associated with other records';
			$this->Flash->error(__('You can not delete this record because it is used in another table.'));
			$this->set('error', $error);
			//$this->Session->setFlash(__(' Lader all ready exists), 'flash/Error');
			return $this->redirect(['action' => 'classteacher']);
		}
	}
	//--------------------------------------------------------------------------------------------
	public function csv($filename)
	{
		$file = SITE_URL . 'excel_file/' . $filename;
		// open the file
		$handle = fopen($file, "r");
		$header = fgetcsv($handle);
		// Remove any invalid or hidden characters
		if (sizeof($header) == 1) {
			$field = preg_replace('/[\x00-\x1F\x80-\xFF]/', ',', $header[0]);
			$header = explode(",", $field);
		}
		// pr($header);die;

		// create a message container
		$return = array(
			'messages' => array(),
			'errors' => array(),
		);
		// read each data row in the file
		while (($row = fgetcsv($handle)) != FALSE) {
			// Remove any invalid or hidden characters
			if (sizeof($row) == 1) {
				$row = preg_replace('/[\x00-\x1F\x80-\xFF]/', ',', $row[0]);
				$row = explode(",", $row);
			}
			$class_id = $this->Classes->find()->select('id')->where(['Classes.title' => $row[0], 'Classes.status' => '1'])->first()->id;
			$row[0] = $class_id;
			$section_id = $this->Sections->find()->select('id')->where(['Sections.title' => $row[1], 'Sections.status' => '1'])->first()->id;
			$row[1] = $section_id;
			$data = array();
			// for each header field
			foreach ($header as $k => $head) {
				$data[$head] = isset($row[$k]) ? $row[$k] : ',';
			}
			$documents = $this->Classections->newEntity();
			$documents = $this->Classections->patchEntity($documents, $data);
			$this->Classections->save($documents);
		}

		//close the file
		fclose($handle);
		//return the messages
		return $return;
	}
}
