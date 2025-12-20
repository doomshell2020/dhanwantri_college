<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\View\Helper;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class StudattendsController extends AppController
{

	public $helpers = ['CakeJs.Js'];

	//initialize component
	public function initialize()
	{

		parent::initialize();
		$this->loadModel('ClasstimeTabs');
		$this->loadModel('Studattends');
		$this->loadModel('Classes');
		$this->loadModel('Sections');
		$this->loadModel('Classections');
		$this->loadModel('Subjects');
		$this->loadModel('Students');
		$this->loadModel('Users');
		$this->loadModel('Classteachers');
	}

	public function index()
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('Studattends');

		$country = $this->Country->find('list')->where(['Country.status' => 'Y'])->order(['Country.name' => 'Asc'])->toarray();
		$this->set('country', $country);
		$State = $this->States->find('list')->where(['States.status' => 'Y'])->order(['States.name' => 'Asc'])->toarray();
		//pr($State);die;
		$this->set('State', $State);
		//show data in listing
		$classes_data = $this->Cities->find('all')->contain(['States', 'Country'])->toarray();
		//pr($classes_data); die;
		//$this->paginate($service_data);
		$this->set('classes', $classes_data);
	}
	public function export($id = null, $sid = null, $acedmic = null)
	{
		//show data in listing
		$classes_data = $this->Classes->find('all')->where(['Classes.id' => $id])->first()->toarray();
		$name = $classes_data['title'];
		$classid = $id;
		$sid = $sid;
		$acedmic = $acedmic;
		$this->response->download($name . 'classattendence.csv');
		$data =  $this->Students->find()->select([
			'Students.id', 'Students.fname', 'Students.lname'
		])->contain(['Sections', 'Classes'])->where(['Students.class_id' => $classid, 'Students.section_id' => $sid, 'Students.acedmicyear' => $acedmic])->toarray();


		$_serialize = 'data';
		$this->set(compact('data', '_serialize'));
		$_header = ['Enroll', 'Name', 'Lastname', 'Date(YY-mm-dd)', 'P/A', 'Remarks'];

		//$_header = array_merge($_headers);

		$this->set(compact('data', '_serialize', '_header'));
		$this->viewBuilder()->className('CsvView.Csv');
		return;
	}

	public function import($id = null, $sid = null, $acedmic = null)
	{


		$this->viewBuilder()->layout('admin');


		$this->set('class_id', $id);
		$this->set('acedmic', $acedmic);

		$this->set('sectionid', $sid);

		$classes = $this->Studattends->newEntity();
		$this->set('classes', $classes);
		if ($this->request->is('post') || $this->request->is('put')) {


			if ($this->data['file']['type'] == 'application/csv' || 'application/vnd.ms-excel' || 'text/csv') {

				$filename = $this->request->data['file']['name'];



				$item = $this->request->data['file']['tmp_name'];
				$class_id = $this->request->data['class_id'];
				$section_id = $this->request->data['section_id'];
				$acedemic = $this->request->data['acedemic'];

				if ($this->request->data['query'] == '1') {
					$query = $this->request->data['query'];
				} else {
					$query = '0';
				}

				if (move_uploaded_file($item, "excel_file/" . $filename)) {

					$this->csv($filename, $class_id, $section_id, $acedemic);
					$this->Flash->success(__('Upload Csv Done'), 'flash/sucess');
				}

				return $this->redirect(['action' => 'attendence/' . $class_id . '/' . $section_id . '/' . $acedemic]);
			} else {
				$this->Session->setFlash(__('File type must be csv only'), 'flash/Error');
			}
		}
	}




	public function csv($filename, $class_id, $section_id, $acedemic, $query)
	{

		$documents = $this->Studattends->newEntity();
		//$filename = TMP . 'uploads' . DS . $filename;
		$filename = SITE_URL . 'excel_file/' . $filename;

		// open the file
		$handle = fopen($filename, "r");

		// read the 1st row as headings
		$header = fgetcsv($handle);


		// create a message container
		$return = array(
			'messages' => array(),
			'errors' => array(),
		);





		if (sizeof($header) == 1) {
			$field = preg_replace('/[\x00-\x1F\x80-\xFF]/', ',', $header[0]);

			$header = explode(",", $field);
		}


		$this->request->data = 0;

		// read each data row in the file
		while (($row = fgetcsv($handle)) !== FALSE) {

			$data = array();
			if (sizeof($row) == 1) {
				$row = preg_replace('/[\x00-\x1F\x80-\xFF]/', ',', $row[0]);
				$row = explode(",", $row);
			}
			// for each header field

			foreach ($header as $k => $head) {

				if (strpos($head, '.') !== false) {
					$h = explode('.', $head);

					$data[$h[0]][$h[1]] = (isset($row[$k])) ? $row[$k] : ',';
				} else {
					$data[$head] = (isset($row[$k])) ? $row[$k] : ',';


					$this->request->data[$head] = (isset($row[$k])) ? $row[$k] : ',';
				}
			}


			// $class_id    	 $section_id   $acedemic


			$remark = 0;
			if ($data['Remarks']) {

				$remark = $data['Remarks'];
			} else {

				$remark = '';
			}
			$da = 0;
			$status = 0;
			$attedenceall = 0;
			$status = $data['P/A'];
			$da = date('Y-m-d', strtotime($data['Date(YY-mm-dd)']));
			$timestamp = strtotime($data['Date(YY-mm-dd)']);
			$weekofday = date("l", $timestamp);
			$attedenceall = $this->Studattends->find('all')->where(['Studattends.class_id' => $class_id, 'Studattends.section_id' => $section_id, 'Studattends.date' => $da, 'Studattends.acedemic' => $acedemic])->toArray();


			if ($attedenceall != '0') {


				$conns = ConnectionManager::get('default');


				$conns->execute("DELETE FROM studattends WHERE acedemic='" . $acedemic . "' AND class_id='" . $class_id . "' AND section_id='" . $section_id . "' AND date='" . $da . "' AND stud_id='" . $data['Enroll'] . "'");
			}

			$conn = ConnectionManager::get('default');
			$peopleTable = TableRegistry::get('Studattends');
			$oquery = $peopleTable->query();
			$oquery->insert(['stud_id', 'day', 'date', 'status', 'acedemic', 'class_id', 'section_id', 'remark'])
				->values([
					'stud_id' => $data['Enroll'], 'day' => $weekofday, 'date' => $da, 'status' => $status, 'acedemic' => $acedemic, 'class_id' => $class_id, 'section_id' => $section_id, 'remark' => $remark
				]);

			$d = $oquery->execute();
		}


		// close the file
		fclose($handle);

		// return the messages
		return $return;
	}


	public function takeattendence()
	{

		$this->viewBuilder()->layout('admin');
		$this->loadmodel('Classteachers');
		$this->loadmodel('Classes');
		$this->loadmodel('Sections');

		$tid = $this->request->session()->read('Auth.User.tech_id');
		$class_teac = $this->Classteachers->find('all')->where(['teach_id' => $tid])->order(['teacher_type ASC'])->toarray();
		$output['success'] = 1;
		$output['classes'] = array();
		$atime = $this->Users->find('all')->select(['attendenceupdate'])->where(['role_id' => '1'])->first();
		foreach ($class_teac as $class_teacher) {

			//pr($class_teacher);

			$class = $this->Classes->find('all')->select(['title', 'id', 'wordsc'])->where(['Classes.id' => $class_teacher['class_id']])->first();
			$cid = $class_teacher['class_id'];
			$sections = $this->Sections->find('all')->select(['title', 'id'])->where(['Sections.id' => $class_teacher['section_id']])->first();
			$sid = $class_teacher['section_id'];
			//pr($class_teacher);die;
			//pr($class);
			//pr($sections);die;
			$type = $class_teacher['teacher_type'];

			$response = [];
			$response['classId'] = $cid;
			$response['sectionId'] = $sid;
			$response['className'] = $class['title'];
			$response['sectionName'] = $sections['title'];

			//pr($class_section); die;
			if (!empty($class_teacher)) {
				if ($type == '2') {
					$response['role'] = 'Co-Class Teacher';
				} else {
					$response['role'] = 'Class Teacher';
				}

				$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
				$acedmic = $users['academic_year'];
				$this->set('acedmic', $acedmic);
				$total_stu = $this->Students->find('all')->where(['Students.class_id' => $cid, 'Students.section_id' => $sid, 'Students.acedmicyear' => $acedmic, 'Students.status' => 'Y'])->count();
				$dat = date('Y-m-d');

				$present_stu = $this->Studattends->find('all')->where(['Studattends.class_id' => $cid, 'Studattends.section_id' => $sid, 'Studattends.status' => 'P', 'Studattends.date' => $dat])->count();

				$absent_stu = $this->Studattends->find('all')->where(['Studattends.class_id' => $cid, 'Studattends.section_id' => $sid, 'Studattends.status' => 'A', 'Studattends.date' => $dat])->count();

				$response['totalstudent'] = $total_stu;
				$response['present'] = $present_stu;
				$response['absent'] = $absent_stu;
			} else {

				$response['role'] = 'Teacher';
				$response['totalstudent'] = 0;
				$response['present'] = 0;
				$response['absent'] = 0;
				//$response['attendance_time'] = $atime['attendenceupdate'];

			}
			array_push($output['classes'], $response);
		}
		$current_time = date("H.i", time());
		//pr($current_time);die;

		if ($current_time >= $atime['attendenceupdate']) {
			$output['canTakeAttendance'] = 0;
		} else {
			$output['canTakeAttendance'] = 1;
		}
		//$output['attendance_time'] = $atime['attendenceupdate'];

		$this->set('output', $output);
	}

	public function totalabsent($class = null, $section = null, $acedmi = null)
	{
		$currentdate = date('Y-m-d');
		$this->viewBuilder()->layout('admin');
		$details = $this->Studattends->find('all')->contain(['Students', 'Classes', 'Sections'])->where(['Students.class_id' => $class, 'Students.section_id' => $section, 'Students.acedmicyear' => $acedmi, 'Studattends.status' => 'A', 'Studattends.date' => $currentdate, 'Students.status' => 'Y'])->toarray();
		$this->set('absentoday', $details);
	}

	// view functionality particular id
	public function attendence($mid = null)
	{
		// pr($this->request->data);die;
		$s = explode("/", base64_decode(base64_decode($mid)));
		// pr($s);die;
		$class = $s[0];
		$section = $s[1];
		$acedmi = $s[2];
		$selecteddate = $s[3];
		// pr($selecteddate);die;
		if(!empty($selecteddate)){
			$dates = $selecteddate;
		}else{
			$curedate = date('Y-m-d');
			$dates='';
		}
		// pr($dates);die;
		$atime = $this->Users->find('all')->select(['attendenceupdate'])->where(['role_id' => '1'])->first();
		$current_time = date("H.i", time());
		//pr($current_time);die;

		if ($current_time >= $atime['attendenceupdate']) {
			$this->Flash->error(__("Your Attendence Module Can't Access After 11:00 AM !"));
			return $this->redirect(['action' => 'admin']);
		}
		// Start a new query.
		//~ $empid = $this->request->session()->read('Auth.User.tech_id');
		//~ $classteacherss=$this->Classteachers->find('all')->contain(['Classes', 'Employees', 'Sections'])->where(['teach_id' => $empid])->first();

		//~ $class=$classteacherss['class']['id'];
		//~ $section=$classteacherss['section']['id'];

		$users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
		$acedmi = $users['academic_year'];
		$this->set('seletedclassid', $class);
		$this->set('seletedsectioid', $section);
		$this->set('seletedclassid', $classid);
		$this->set('seletedsectionid', $sectionid);
		$this->set('selectdadte', $dates);


		if ($section) {
			$sectionslit = $this->Sections->find('list', [
				'keyField' => 'id',
				'valueField' => 'title'
			])->where(['id' => $section])->order(['title' => 'ASC'])->toArray();
			$this->set('sectionsg', $sectionslit);

			if ($acedmi) {

				$studentsarry = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Classes.id' => $class, 'Sections.id' => $section, 'Students.acedmicyear' => $acedmi, 'Students.status' => 'Y'])->order(['Students.fname' => 'ASC'])->order(['Students.lname' => 'ASC'])->toarray();
				$this->set(compact('studentsarry'));
				$sectionselectlist  = $this->Classections->find('list', [
					'keyField' => 'Sections.id',
					'valueField' => 'Sections.title'
				])->contain(['Sections'])->where(['Classections.class_id' => $class])->order(['Sections.title' => 'ASC'])->toArray();
				$this->set('sectionselectlist', $sectionselectlist);
				$this->set('seletedclassid', $class);
				$this->set('seletedsectionid', $section);
				$this->set('academic', $acedmi);
				$this->set('academics', $acedmi);
				// if()
				if(!empty($selecteddate)){
					$rt = $selecteddate;
				}else{
					$rt = $curedate;
				}
				
				$timestamp = strtotime($rt);
				$weekofday = date("l", $timestamp);
				// pr($weekofday);die;
				$this->set('weekofday', $weekofday);
				// pr($class);
				// pr($rt);
				// pr($section);die;
				$attedenceall = $this->Studattends->find('all')->where(['Studattends.class_id' => $class, 'Studattends.section_id' => $section, 'Studattends.date' => $rt, 'Studattends.acedemic' => $acedmi])->order(['Studattends.id' => 'ASC'])->toArray();
				// pr($attedenceall);die;

				$this->set('attedenceall', $attedenceall);
				$sectionclassid = $this->Classections->find('all')->contain(['Classes', 'Sections'])->where(['Classections.class_id' => $class, 'Classections.section_id' => $section])->toArray();
				$this->set('classectionid', $sectionclassid[0]['id']);
				$sectiontitle = $sectionclassid[0]['Sections']['title'];
				$classtitle = $sectionclassid[0]['Classes']['title'];
				$this->set('sectiontitle', $sectiontitle);
				$this->set('classtitle', $classtitle);
			}
		}



		$this->viewBuilder()->layout('admin');
		$classes = $this->Classections->find('list', [
			'keyField' => 'Classes.id',
			'valueField' => 'Classes.title'
		])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.id' => 'asc'])->toArray();
		$this->set('classes', $classes);


		$sectionslist = $this->Sections->find('list', [
			'keyField' => 'id',
			'valueField' => 'title'
		])->where(['status' => '1'])->order(['title' => 'ASC'])->toArray();
		$this->set('sectionslist', $sectionslist);
	}
	public function add($id = null)
	{
		$this->viewBuilder()->layout('admin');
		//~ if($_GET['ids']){
		//~ $this->set('ids', $_GET['ids']);
		//~ $this->set('dates', $_GET['date']);
		//~ $rt= $_GET['date'];

		//~ $timestamp = strtotime($rt);
		//~ $weekofday= date("l", $timestamp);
		//~ $this->set('weekofday', $weekofday);

		//~ $timetable_data = $this->ClasstimeTabs->find('all')->contain(['Subjects'])->where(['ClasstimeTabs.id' =>$_GET['ids']])->order(['ClasstimeTabs.id' => 'ASC'])->toarray();
		//~ $classectionid=$timetable_data[0]['class_id']; 
		//~ $subjectsname=$timetable_data[0]['Subjects']['name']; 
		//~ $ttid=$timetable_data[0]['tt_id']; 
		//~ $this->set('ttid', $ttid);


		//~ $sectionclassid = $this->Classections->find('all')->contain(['Classes','Sections'])->where(['Classections.id' =>$classectionid])->toArray();
		//~ $sectiontitle=$sectionclassid[0]['Sections']['title'];
		//~ $classtitle=$sectionclassid[0]['Classes']['title'];
		//~ $this->set('sectiontitle',$sectiontitle);
		//~ $this->set('classtitle',$classtitle);
		//~ $this->set('subjectsname',$subjectsname);
		//~ $returnclass_id=$sectionclassid[0]['class_id'];
		//~ $returnsection_id=$sectionclassid[0]['section_id'];
		//~ $students = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Classes.id' =>$returnclass_id,'Sections.id' =>$returnsection_id])->toarray();
		//~ $this->set(compact('students'));
		//~ }
		if (isset($id) && !empty($id)) {
			//using for edit
			$classes = $this->Studattends->get($id);
		} else {
			//using for new entry
			$classes = $this->Studattends->newEntity();
		}
		if ($this->request->is(['post', 'put'])) {

			// pr($this->request->data);die;
			$timestamp = strtotime($this->request->data['date']);
			$date = $this->request->data['date'];
			$weekofday = date("l", $timestamp);
			$this->request->data['day'] = $weekofday;
			$conn = ConnectionManager::get('default');
			$peopleTable = TableRegistry::get('Studattends');
			$oquery = $peopleTable->query();
			$class_id = $this->request->data['class_id'];
			$section_id = $this->request->data['section_id'];
			$academic = $this->request->data['academic'];
			$attedenceall = $this->Studattends->find('all')->where(['Studattends.class_id' => $class_id, 'Studattends.section_id' => $section_id, 'Studattends.date' => $this->request->data['date'], 'Studattends.acedemic' => $academic])->toArray();

			if (!empty($attedenceall)) {
				$dater = $this->request->data['date'];
				$conn = ConnectionManager::get('default');
				$conn->execute("DELETE FROM studattends WHERE acedemic='" . $academic . "' AND class_id='" . $class_id . "' AND section_id='" . $section_id . "' AND date='" . $dater . "'");
			}
			$stud_id = sizeof($this->request->data['stud_id']);

			// $remark=$this->request->data['remark'];

			$arrstudentfind = array();
			$coordinator = $this->request->session()->read('Auth.User.id');
			// pr($coordinator);die;
			for ($i = 0; $i < $stud_id; $i++) {
				$arrstudentfind[] = $this->request->data['stud_id'][$i];
				$statusm = $this->getMachineStatus($class_id, $section_id, $this->request->data['stud_id'][$i]);
				$oquery->insert(['stud_id', 'day', 'date', 'status', 'status_m', 'acedemic', 'class_id', 'section_id', 'coordinator_id'])
					->values([
						'stud_id' => $this->request->data['stud_id'][$i], 'day' => $weekofday, 'date' => $date, 'status' => 'A', 'status_m' => $statusm, 'acedemic' => $academic, 'class_id' => $class_id, 'section_id' => $section_id, 'coordinator_id' => $coordinator
					]);
				}
				
				$d = $oquery->execute();
				// pr($d);die;

			if (empty($arrstudentfind)) {
				$studentsarry = $this->Students->find('all')->select(['id'])->contain(['Classes', 'Sections'])->where(['Classes.id' => $class_id, 'Sections.id' => $section_id, 'Students.acedmicyear' => $academic, 'Students.status' => 'Y'])->order(['Students.fname' => 'ASC'])->order(['Students.lname' => 'ASC'])->toarray();
			} else {

				$studentsarry = $this->Students->find('all')->select(['id'])->contain(['Classes', 'Sections'])->where(['Classes.id' => $class_id, 'Sections.id' => $section_id, 'Students.acedmicyear' => $academic, 'Students.id NOT IN' => $arrstudentfind, 'Students.status' => 'Y'])->order(['Students.fname' => 'ASC'])->order(['Students.lname' => 'ASC'])->toarray();
			}

			if (isset($studentsarry)) {
				$conns = ConnectionManager::get('default');
				$peopleTables = TableRegistry::get('Studattends');
				$oquerys = $peopleTables->query();
				foreach ($studentsarry as $jkey => $item) {
					$statusm = $this->getMachineStatus($class_id, $section_id, $item['id']);
					$oquerys->insert(['stud_id', 'day', 'remark', 'date', 'status', 'status_m', 'acedemic', 'class_id', 'section_id', 'coordinator_id'])
						->values([
							'stud_id' => $item['id'], 'day' => $weekofday, 'remark' => '', 'date' => $this->request->data['date'], 'status' => 'P', 'status_m' => $statusm, 'acedemic' => $academic, 'class_id' => $class_id, 'section_id' => $section_id, 'coordinator_id' => $coordinator
						]);
						// pr($oquerys);die;
				}
				$ds = $oquerys->execute();
			}

			$this->Flash->success(__('Your Attendence procedure for selected class has been Updated.'));
			return $this->redirect(['controller' => 'students', 'action' => 'classattendance']);

			//validation error
		}
	}
	public function getMachineStatus($class_id, $section_id, $student_id)
	{
		$connss = ConnectionManager::get('default');

		$studentrfids = $connss->execute("SELECT * FROM `students` WHERE class_id='" . $class_id . "' AND section_id='" . $section_id . "' AND id='" . $student_id . "' AND status='Y' AND rf_id IN (SELECT rfid FROM `attendreports` WHERE DATE(resultdate)='" . date('Y-m-d') . "')");

		$studentrfids = $studentrfids->fetchAll('assoc');
		if ($studentrfids[0]['id']) {

			$statush = "P";
		} else {

			$statush = "A";
		}
		return $statush;
	}

	public function sort()
	{
		$this->viewBuilder()->layout('admin');
		$id = $this->request->data['id'];
		if (isset($id) && !empty($id)) {
			//using for edit
			$classes = $this->Cities->get($id);
		} else {
			//using for new entry
			$classes = $this->Cities->newEntity();
		}

		if ($this->request->is(['post', 'put'])) {

			//$this->request->data = $this->request->data['sort']; 
			$classes->sort = $this->request->data['sort'];

			if ($this->Cities->save($classes)) {
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
		//  echo $id;
		$classes = $this->Cities->find()->where(['Cities.id' => $id])->contain(['States', 'Country'])->first()->toarray();
		//pr($classes); die;
		$this->set(compact('classes'));
	}
	//delete functionality
	public function delete($id)
	{
		//$this->request->allowMethod(['post', 'delete']);
		$classes = $this->Cities->get($id);
		//delete pariticular entry
		if ($this->Cities->delete($classes)) {
			$this->Flash->success(__('The City with id: {0} has been deleted.', h($id)));
			return $this->redirect(['action' => 'index']);
		}
	}
	//status update functionality
	public function status($id, $status)
	{

		$statusquery = $this->Cities->find('all')->where(['Cities.status' => 'Y'])->count();
		if (isset($id) && !empty($id)) {
			if ($status == 'Y') {

				$status = 'N';
				//status update
				$classes = $this->Cities->get($id);
				$classes->status = $status;
				if ($this->Cities->save($classes)) {
					$this->Flash->success(__('Your City status has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			} else {

				$status = 'Y';
				//status update
				$classes = $this->Cities->get($id);
				$classes->status = $status;
				if ($this->Cities->save($classes)) {
					$this->Flash->success(__('Your City status has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			}
		}
	}
	public function find_state()
	{
		$this->viewBuilder()->layout('admin');
		$id = $this->request->data['id'];
		$statelist = $this->States->find('list')->where(['States.c_id' => $id, 'States.status' => 'Y'])->toArray();
		//pr($statelist);die;
		echo "<option value=''>Select State</option>";
		foreach ($statelist as $state => $value) {
			echo "<option value=" . $state . ">" . $value . "</option>";
		}
		die;
	}


	public function find_cities()
	{
		$this->viewBuilder()->layout('admin');
		$id = $this->request->data['id'];
		$statelist = $this->Cities->find('list')->where(['Cities.s_id' => $id, 'Cities.status' => 'Y'])->toArray();
		//pr($statelist);die;
		echo "<option value=''>Select City</option>";

		foreach ($statelist as $state => $value) {
			echo "<option value=" . $state . ">" . $value . "</option>";
		}
		die;
	}
}
