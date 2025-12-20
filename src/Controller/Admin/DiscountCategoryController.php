<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;


class DiscountCategoryController extends AppController
{
	//initialize component
	public function initialize()
	{
		parent::initialize();
		$this->loadModel('DiscountCategory');
		$this->loadModel('Feesheads');
		$this->loadModel('Studentfees');
		$this->loadModel('Students');
		$this->loadModel('Classections');
	}

	public function index($id)
	{
		$this->viewBuilder()->layout('admin');



		$studentcount = $this->Students->find('all')->order(['id' => 'ASC'])->count();
		$connss = ConnectionManager::get('default');
		$studentrfidsd = $connss->execute("SELECT students.id  FROM `students` Where students.discountcategory!=''  GROUP By id order by id DESC");
		$this->set('totalstudent', $studentcount);
		$recourds = $studentrfidsd->fetchAll('assoc');
		$this->set('count', count($recourds));
		$this->set('student', $studentcount);
		$fid = ['1', '2', '3'];
		$feeheads = $this->Feesheads->find('list', [
			'keyField' => 'id',
			'valueField' => 'name'
		])->where(['Feesheads.type IN' => $fid])->order(['Feesheads.id' => 'ASC'])->toarray();
		$this->set('feeheads', $feeheads);
		$classes_data = $this->DiscountCategory->find('all')->order(['id' => 'ASC'])->toarray();
		$this->set('classes', $classes_data);
		if (isset($id) && !empty($id)) {
			//using for edit
			$department = $this->DiscountCategory->get($id);
			// echo $classes; die;

			$this->set('department', $department);
		} else {
			$department = $this->DiscountCategory->newEntity();
		}
		if ($this->request->is(['post', 'put'])) {
			$arr = array();
			$arr2 = array();
			$arr3 = array();
			$deop = 0;
			if (!empty($this->request->data['discountamt'])) {
				foreach ($this->request->data['fh_id'] as $k => $try) {
					foreach ($this->request->data['discount'] as $ks => $trys) {
						if ($k == $ks) {
							$arr[$try] = $trys;
						}
					}
					foreach ($this->request->data['discountamt'] as $khs => $thrys) {
						if ($k == $khs) {
							$arr2[$try] = $thrys;
						}
					}
				}

				$str = serialize($arr);
				$str3 = serialize($arr2);
				$this->request->data['discount'] = $str3;
			} else {

				foreach ($this->request->data['fh_id'] as $k => $try) {

					foreach ($this->request->data['discount'] as $ks => $trys) {
						if ($k == $ks) {

							$arr[$try] = $trys;
						}
					}
				}
				$str = serialize($arr);
				$this->request->data['discount'] = '0';
			}
			$this->request->data['fh_id'] = $str;
			$this->request->data['type'] = '0';
			$department = $this->DiscountCategory->patchEntity($department, $this->request->data);
			if ($this->DiscountCategory->save($department)) {
				$this->Flash->success(__('Your Discount Category has been saved.'));
				return $this->redirect(['action' => 'index']);
			}
		}
		//show data in listing
	}

	public function add($id = null)
	{
		
		$this->viewBuilder()->layout('admin');
		if (isset($id) && !empty($id)) {
			//using for edit
			$department = $this->DiscountCategory->get($id);
			// echo $classes; die;
		} else {
			$department = $this->DiscountCategory->newEntity();
		}
		$this->set('department', $department);
		//show data in listing
		if ($this->request->is(['post', 'put'])){

			$arr = array();
			$arr2 = array();
			$arr3 = array();
			$deop = 0;
			foreach ($this->request->data['fh_id'] as $k => $try) {
				foreach ($this->request->data['discount'] as $ks => $trys) {
					if ($k == $ks) {
						$arr[$try] = $trys;
					}
				}
				foreach ($this->request->data['discountamt'] as $khs => $thrys) {
					if ($k == $khs) {
						$arr2[$try] = $thrys;
					}
				}
			}
			$str = serialize($arr);
			$str3 = serialize($arr2);
			$this->request->data['discount'] = $str3;
			$this->request->data['fh_id'] = $str;
			$this->request->data['type'] = '0';
			$department = $this->DiscountCategory->patchEntity($department, $this->request->data);
			if ($this->DiscountCategory->save($department)) {
				$this->Flash->success(__('Your Discount Category has been saved.'));
				return $this->redirect(['action' => 'index']);
			}
		}
	}


	public function delete($id)
	{
		//$this->request->allowMethod(['post', 'delete']);
		$classes = $this->DiscountCategory->get($id);
		//delete pariticular entry
		if ($this->DiscountCategory->delete($classes)) {
			$this->Flash->success(__('The Discount with id: {0} has been deleted.', h($id)));
			return $this->redirect(['action' => 'index']);
		}
	}

	public function view($id)
	{
		$this->viewBuilder()->layout('admin');
		//get data from paricular id
		$classes = $this->Documentcategory->get($id);
		$this->set(compact('classes'));
	}

	public function getdetails($cid = null)
	{
		$this->viewBuilder()->layout('admin');
		$this->set('cid', $cid);
		unset($_SESSION['searchdata']);
		$classes = $this->Classections->find('list', [
			'keyField' => 'Classes.id',
			'valueField' => 'Classes.title'
		])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classections.id' => 'ASC'])->toArray();
		$this->set('classes', $classes);


		$connss = ConnectionManager::get('default');
		if ($cid) {
			$this->set('cisd', '1');
			$studentrfidsd = $connss->execute("SELECT students.enroll,students.acedmicyear,students.id,students.fname,students.middlename,students.lname,students.fathername,students.fathername,students.sms_mobile,classes.title as classname,sections.title as sectionname,students.discountcategory  FROM students LEFT JOIN  classes ON students.class_id = classes.id LEFT JOIN  sections ON students.section_id =   sections.id  WHERE students.`discountcategory` LIKE '" . $cid . "%' and students.status='Y' order by classes.sort ASC, students.fname ASC,sections.title ASC");
		} else {
			$this->set('cisd', '0');
			$studentrfidsd = $connss->execute("SELECT 
			students.enroll,students.acedmicyear,students.id,students.fname,students.middlename,students.lname,students.fathername,students.fathername,students.sms_mobile,classes.title as classname,sections.title as sectionname,students.discountcategory  FROM students LEFT JOIN  classes ON students.class_id = classes.id LEFT JOIN  sections ON students.section_id =   sections.id  WHERE students.`discountcategory` !='' and students.status='Y' order by classes.sort ASC, students.fname ASC,sections.title ASC");
		}
		$recourds = $studentrfidsd->fetchAll('assoc');
		$this->set('data', $recourds);
	}


	public function classsection_excel($cid)
	{
		//echo $cid;
		$this->autoRender = false;
		$connss = ConnectionManager::get('default');
		if ($_SESSION['searchdata']['class_id']) {
			$class = $_SESSION['searchdata']['class_id'];
			$cond .= " AND students.class_id = '" . $class . "'";
		}
		if ($_SESSION['searchdata']['section-id']) {
			$section = $_SESSION['searchdata']['section-id'];
			$cond .= " AND students.section_id = '" . $section . "'";
		}
		if ($_SESSION['searchdata']['dis']) {
			$name = $_SESSION['searchdata']['dis'];
			$cond .= "AND students.discountcategory LIKE '" . $name . "%'";
		} else if ($cid) {
			$cond .= "AND students.discountcategory LIKE '" . $cid . "%'";
		} else {
		}
		$cond .= "AND students.status='Y'";
		$cond .= " AND students.discountcategory!=''";
		$studentrfidsd = $connss->execute("SELECT students.enroll,students.acedmicyear,students.id,students.fname,students.middlename,students.lname,students.fathername,students.fathername,students.sms_mobile,classes.title as classname,sections.title as sectionname,students.discountcategory  FROM students LEFT JOIN  classes ON students.class_id = classes.id LEFT JOIN  sections ON students.section_id =   sections.id  WHERE 1=1 " . $cond . " order by classes.sort ASC, students.fname ASC,sectionname ASC ");

		$recourds = $studentrfidsd->fetchAll('assoc');

		ini_set('max_execution_time', 1600);
		$headerRow = array("S.No.", "Sr.No.", "Receipt Number", "Name", "Class", "Section", "Father name", "Mobile", "Discount");
		$output = implode("\t", $headerRow) . "\n";
		$s = 1;
		foreach ($recourds as $people) {
			$result = array();
			$str = "";
			$result[] = $s++;
			$result[] = $people['enroll'];
			$wrecipiet = $this->findrecipiet($people['id'], $people['discountcategory']);
			if ($wrecipiet['recipetno']) {
				$result[] = $wrecipiet['recipetno'];
			} else {
				$result[] = '-';
			}
			$result[] = ucfirst(strtolower($people['fname'])) . " " . ucfirst(strtolower($people['middlename'])) . " " . ucfirst(strtolower($people['lname']));
			$result[] = $people['classname'];
			$result[] = $people['sectionname'];
			$result[] = ucfirst(strtolower($people['fathername']));
			$result[] = $people['sms_mobile'];
			$result[] = $people['discountcategory'];
			$output .= implode("\t", $result) . "\n";
		}
		if ($cid == "") {
			$cid = "All";
		}
		$filename = "Discounted_." . $cid . "_students_" . date('d-m-Y') . ".xls";
		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		die;
	}

	public function findrecipiet($sid = null, $discount = null)
	{
		$articles = TableRegistry::get('Studentfees');
		$query = $articles->find('all');
		return $query->select(['recipetno'])->where(['Studentfees.student_id' => $sid, 'Studentfees.discountcategory' => $discount, 'Studentfees.status' => 'Y'])->first();
	}

	public function search()
	{
		//show all data in listing page
		$conn = ConnectionManager::get('default');

		$class = $this->request->data['class_id'];
		$section = $this->request->data['section-id'];
		$name = $this->request->data['dis'];


		$session = $this->request->session();
		$session->write('searchdata', $this->request->data);

		//pr($this->request->data); die;
		$detail = "SELECT 
		students.enroll,students.acedmicyear,students.id,students.fname,students.middlename,students.lname,students.fathername,students.fathername,students.sms_mobile,classes.title as classname,sections.title as sectionname,students.discountcategory  FROM students LEFT JOIN  classes ON students.class_id = classes.id LEFT JOIN  sections ON students.section_id =   sections.id  WHERE 1=1 ";
		$cond = ' ';

		if (!empty($class)) {
			$cond .= " AND students.class_id = '" . $class . "'";
		}
		if (!empty($name)) {
			$cond .= "AND students.`discountcategory` LIKE '%" . $name . "%'";
		}
		if (!empty($section)) {
			$cond .= " AND students.section_id = '" . $section . "'";
		}
		$cond .= " AND students.discountcategory!=''";

		$detail = $detail . $cond;
		$SQL = $detail . "and
		students.status='Y' order by classes.sort ASC, students.fname 
		ASC,sectionname ASC";
		$results = $conn->execute($SQL)->fetchAll('assoc');
		$this->set('students', $results);
	}
}
