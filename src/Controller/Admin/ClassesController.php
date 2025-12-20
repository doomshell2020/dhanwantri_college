<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\ORM\TableRegistry;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';


class ClassesController extends AppController
{
	//initialize component
	public function initialize()
	{
		parent::initialize();
		$this->loadModel('Classes');
	}

	public function index()
	{
		$this->viewBuilder()->layout('admin');
		//show data in listing
		$classes_data = $this->Classes->find('all')->order(['sort' => 'ASC']);
		//$this->paginate($service_data);
		$this->set('classes', $classes_data);
	}


	public function add($id = null)
	{
		$this->viewBuilder()->layout('admin');
		if (isset($id) && !empty($id)) {
			$classes = $this->Classes->get($id);
		} else {
			//using for new entry
			$classes = $this->Classes->newEntity();
			$statusquery = $this->Classes->find('all')->where(['Classes.status' => 1])->count();
			if ($statusquery < 8) {
				$this->request->data['status'] = '1';
			} else {
				$this->request->data['status'] = '0';
			}
		}
		if ($this->request->is(['post', 'put'])) {

			$peopleTablsen = TableRegistry::get('Classes');
			$peopleTablsen->query();
			$exi = $peopleTablsen->exists(['title' => $this->request->data['title'], 'type' => $this->request->data['type']]);
			if ($exi) {
				$this->Flash->error(__('Duplicate Entry not Allowed.'));
				return $this->redirect(['action' => 'index']);
			}
			// save all data in database
			$classes = $this->Classes->patchEntity($classes, $this->request->data);
			if ($this->Classes->save($classes)) {
				$this->Flash->success(__('Your class has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
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
		$this->set('classes', $classes);
	}
	/// this is use to sort class name
	public function sort()
	{
		$this->viewBuilder()->layout('admin');
		$id = $this->request->data[id];
		if (isset($id) && !empty($id)) {
			//using for edit
			$classes = $this->Classes->get($id);
		} else {
			//using for new entry
			$classes = $this->Classes->newEntity();
		}

		if ($this->request->is(['post', 'put'])) {
			$classes->sort = $this->request->data['sort'];
			if ($this->Classes->save($classes)) {
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
		$classes = $this->Classes->get($id);
		$this->set(compact('classes'));
	}

	//delete functionality
	public function delete($id)
	{
		$classes = $this->Classes->get($id);
		try {
			if ($this->Classes->delete($classes)) {
				$this->Flash->success(__(' Class with id: {0} has been deleted.', h($id)));
				return $this->redirect(['action' => 'index']);
			}
		} catch (\PDOException $e) {
			//  $error = 'The item you are trying to delete is associated with other records';
			$this->Flash->error(__(' You can not delete this record because it is used in another table.'));
			$this->set('error', $error);
			return $this->redirect(['action' => 'index']);
		}
	}
	//status update functionality
	public function status($id, $status)
	{

		$statusquery = $this->Classes->find('all')->where(['Classes.status' => 1])->count();
		if (isset($id) && !empty($id)) {
			if ($status == 1) {

				$status = 0;
				//status update
				$classes = $this->Classes->get($id);
				$classes->status = $status;
				if ($this->Classes->save($classes)) {
					$this->Flash->success(__('Your class status has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			} else {
				$status = 1;
				$classes = $this->Classes->get($id);
				$classes->status = $status;
				if ($this->Classes->save($classes)) {
					$this->Flash->success(__('Your class status has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			}
		}
	}

	public function classTeacherImport()
	{
		$this->viewBuilder()->layout('admin');
	}
	public function import()
	{

		$this->loadModel('Classteachers');

		if ($this->request->is(['post'])) {

			try {

				//pr($this->request->data); die;

				if ($this->request->data['file']['tmp_name']) {

					$empexcel = $this->request->data['file'];
					$excel_array = $this->get_excel_data($empexcel['tmp_name']);
					if ($excel_array == "null") {

						$this->Flash->error(__('Please Fill Mandatory Fields'));
						$this->set('error', $error);
						return $this->redirect(['action' => 'import']);
					}
					if (!empty($excel_array['message'])) {

						$this->Flash->error(__($excel_array['message']));
						$this->set('error', $error);
						return $this->redirect(['action' => 'import']);
					}
					foreach ($excel_array as $refer_data) {
						//  pr($refer_data); die;
						// echo date('m',strtotime($refer_data['joiningdate'])); die;
						$classTeacher['teach_id'] = $refer_data['class_teacher'];
						$classTeacher['teacher_type'] = 1;
						$classTeacher1['class_id'] = $classTeacher['class_id'] = $refer_data['class_id'];
						$classTeacher1['section_id'] = $classTeacher['section_id'] = $refer_data['section_id'];
						$classTeacher1['teacher_type'] = 2;
						$classTeacher1['teach_id'] = $refer_data['co_class_teacher'];
						$emp = $this->Classteachers->newEntity();
						$emp = $this->Classteachers->patchEntity($emp, $classTeacher);
						$emp = $this->Classteachers->save($emp);
						$emp1 = $this->Classteachers->newEntity();
						$emp1 = $this->Classteachers->patchEntity($emp1, $classTeacher1);
						$emp1 = $this->Classteachers->save($emp1);
					}

					$this->Flash->success(__('Class TEacjer list  has been saved.'));
					return $this->redirect(['controller' => 'Classections', 'action' => 'classteacher']);
				}
				$this->Flash->error(__('Employeesalary  has not been saved.'));
				return $this->redirect(['controller' => 'Classections', 'action' => 'classteacher']);
			} catch (\PDOException $e) {

				$this->Flash->error(__('Employeesalary updation Failed' . $error));
				$this->set('error', $error);
				return $this->redirect(['controller' => 'Classections', 'action' => 'classteacher']);
			}
		}
	}
	public function get_excel_data($inputfilename)
	{
		if ($_POST) {
			try {
				$objPHPExcel = \PHPExcel_IOFactory::load($inputfilename);
			} catch (Exception $e) {
				die('Error loading file "' . pathinfo($inputfilename, PATHINFO_BASENAME) . '": ' . $e->getMessage());
			}
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestDataRow();
			$highestColumn = $sheet->getHighestDataColumn();
			$c = 0;
			$firstrow = 1;
			$firstsop = $sheet->rangeToArray('A' . $firstrow . ':' . $highestColumn . $firstrow, null, true, false);
			for ($row = 2; $row <= $highestRow; $row++) {
				$exceldata = array();
				$filesop = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
				$val = $exceldata['class_id'] = $this->Classes->find('all')->select(['id'])->where(['title' => $filesop[0][1]])->first()->id;
				$val = $exceldata['section_id'] = $this->Sections->find('all')->select(['id'])->where(['title' => $filesop[0][2]])->first()->id;
				$val = $exceldata['class_teacher'] = explode('-', $filesop[0][3])[1];
				$val = $exceldata['co_class_teacher'] = explode('-', $filesop[0][4])[1];

				if (in_array('', array_map('trim', $val))) {
					$ret = "null";
					return $ret;
				}
				$csv_data[] = $exceldata;
			}
			return $csv_data;
		}
	}
	// export employees execel data
	public function export()
	{
		$this->loadModel('Employees');
		$this->loadModel('Sections');

		$emp = $this->Employees->find('all')->select(['fname', 'middlename', 'lname', 'Employees.id'])->contain(['PayrollDesignations'])->where(['PayrollDesignations.is_teacher' => 'Y', 'Employees.status' => 'Y'])->order(['Employees.fname' => 'ASC'])->toarray();
		$employees = array_map(function ($employee) {
			$temp = $employee['fname'] . ' ' . $employee['middlename'] . ' ' . $employee['lname'] . '-' . $employee['id'];
			return $temp;
		}, $emp);
		$this->loadModel('Classections');
		$classec = $this->Classections->find('all')->where(['status' => 'Y'])->toarray();
		$classes = $this->Classes->find('list', ['keyField' => 'id', 'valueField' => 'title'])->toarray();
		$sections = $this->Sections->find('list', ['keyField' => 'id', 'valueField' => 'title'])->toarray();
		$this->set(compact('employees', 'classec', 'sections', 'classes'));
	}



	function find_section()
	{
		$this->loadModel('Classes');
		$this->loadModel('Sections');
		$this->autorender = false;
		$classId = $this->request->data['classId'];

		$classes = $this->Classes->find('all')->where(['Classes.id' => $classId])->first();
		$sections = $this->Sections->find('all')->where(['Sections.status' => $classes['type']])->toArray();
		echo json_encode($sections);
		die;
	}
}
