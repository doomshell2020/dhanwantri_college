<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Cake\Http\Client;

use Cake\Utility\Security;

include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';

class DashboardsController extends AppController
{
	public function initialize()
	{
		//load all models

		parent::initialize();


		$this->loadModel('Classes');
		$this->loadModel('Classections');
		$this->loadModel('Book');
		$this->loadModel('Events');
		$this->loadModel('Timetables');
		$this->loadModel('Subjects');
		$this->Auth->allow(['vishnupo']);
	}

	//-----------------------------------------------------------------------------------------------------
	public function vishnupo()
	{

		$this->viewBuilder()->layout('ajax');
		$this->response->type('pdf');
	}
	public function index()
	{
		$this->loadModel('Users');
		$this->viewBuilder()->layout('admin');

		$user_id =  $this->Auth->user('role_id');

		$roleid = $user_id;

		if ($roleid == '105') {
			return $this->redirect(['controller' => 'dashboards', 'action' => 'headbranch']);
		} else {
			return $this->redirect(['controller' => 'dashboards', 'action' => 'adminbranch']);
		}


		if ($roleid == '18' || $roleid == '19') {
			return $this->redirect(['controller' => 'indent', 'action' => 'index']);
		}

		if ($roleid == '0') {
			return $this->redirect(['controller' => 'logins', 'action' => 'logout']);
			$this->Flash->success(__('Employee can not have defined role'));
		}

		//------------------

		$data_count = [];

		$data_count['student_count'] = $this->Students->find('all')->where(['Students.status' => 'Y'])->count();
		$data_count['faculty_count'] = $this->Employees->find('all')->where(['Employees.status' => 'Y', 'Employees.designation_id' => '4'])->count();

		$total_staff = $this->Employees->find('all')->where(['Employees.status' => 'Y'])->count();
		$data_count['non_teaching_staff_count'] = $total_staff - $data_count['faculty_count'];

		$data_count['class_count'] = $this->Classes->find('all')->where(['Classes.status' => '1'])->count();
		$data_count['section_count'] = $this->Classections->find('all')->where(['Classections.status' => 'Y'])->count();
		$data_count['book_count'] = $this->Book->find('all')->where(['Book.status' => 'Y'])->count();
		$data_count['event_count'] = $this->Events->find('all')->where(['Events.eventt' => '11'])->count();
		$data_count['new_admission_count'] = $this->Students->find('all')
			->where(['Students.admissionyear' => date("Y") . '-' . (date("y") + 1), 'Students.status' => 'Y'])->count();

		$this->set(compact('data_count'));

		//------------------

		$report_data = $this->sessionFeesReport();
		// pr($report_data);exit;

		$this->set(compact('report_data'));
		// pr($report_data);die;

		//  For time table //

		$role = $this->request->session()->read('Auth.User.role_id');
		$username = $this->request->session()->read('Auth.User.tech_id');
		//pr($username); die;
		$emailgg = $this->Users->find('all')->where(['Users.role_id' => $role, 'Users.tech_id' => $username])->first();

		$email = $this->Employees->find('all')->where(['Employees.id' => $emailgg['tech_id']])->first();
		if ($role == '3') {
			$findclasssection = $this->findclassectionsed();
			$classid = $findclasssection['class_id'];
			$sectionid = $findclasssection['section_id'];
		}
		$fname = $email['fname'];
		$this->set('fname', $fname);
		$middlename = $email['middlename'];
		$this->set('middlename', $middlename);
		$lname = $email['lname'];
		$this->set('lname', $lname);


		$sectionclassselectlist  = $this->Classections->find('all')->contain(['Classes', 'Sections'])->where(['Classections.teacher_id' => $email['id']])->order(['Sections.title' => 'ASC'])->first();

		$this->set('classsss', $sectionclassselectlist['Classes']['title']);

		$this->set('sectionsss', $sectionclassselectlist['Sections']['title']);

		$this->viewBuilder()->layout('admin');


		$subjectslist = $this->Subjects->find('list', [
			'keyField' => 'alias',
			'valueField' => 'name'
		])->where(['status' => '1'])->order(['name' => 'ASC'])->toArray();
		$this->set('subjectslist', $subjectslist);


		$sectionselectlist  = $this->Classections->find('list', [
			'keyField' => 'Sections.id',
			'valueField' => 'Sections.title'
		])->contain(['Sections'])->where(['Classections.class_id' => $classid])->order(['Sections.title' => 'ASC'])->toArray();
		$this->set('sectionselectlist', $sectionselectlist);
		$this->set('seletedclassid', $classid);
		$this->set('seletedsectionid', $sectionid);
		$this->set('class', $classid);
		$this->set('section', $sectionid);

		$m = date('m');

		if ($m < 03) {
			$d = date('y');
			$current = $d - 1;
			$dsa = '20' . $current;
			$yeard = $dsa . '-' . $d;
			$acedimc = $yeard;
		} else {

			$date = date('Y');
			$date1 = date('y');
			$d = $date1 + 1;
			$acedimc = $date . "-" . $d;
		}
		$this->set('acedimc', $acedimc);

		$sections = $this->Classections->find('all')->where(['Classections.class_id' => $classid, 'Classections.section_id' => $sectionid])->toArray();

		$this->set('classectionid', $email['id']);

		$timetable_data = $this->Timetables->find('all')->where(['Timetables.status' => '1'])->order(['Timetables.id' => 'ASC'])->toarray();
		//pr($timetable_data); die;
		$this->set('timetabledata', $timetable_data);
	}



	public function findclassectionsed()
	{
		$username = $this->request->session()->read('Auth.User.email');
		return	$this->Classections->find('all')->contain(['Classes', 'Sections', 'Employees'])->where(['Employees.email' => $username])->first();
	}



	//-----------------------------------------------------------------------------------------------------
	public function sessionFeesReport()
	{
		//$current_year = date("Y");
		$current_year = '2017';
		//$post_year = date("y")+1;
		$post_year = '18';
		$acedmicyear = $current_year . '-' . $post_year;

		$classes = $this->Classections->find('list', ['keyField' => 'Classes.id', 'valueField' => 'Classes.title'])->contain(['Classes'])->where(['Classections.status' => 'Y'])->order(['Classes.title' => 'ASC'])->toArray();

		$array_of_grand_totals = [

			'total_fees' => 0,
			'paid_fees' => 0,
			'due_fees' => 0,
			'discount_given' => 0,
			'outstanding_fees' => 0
		];

		foreach ($classes as $key => $value) {
			$s_id = $key;
			$Classections = $this->Classections->find('list', ['keyField' => 'id', 'valueField' => 'section_id'])->where(['class_id' => $s_id])->toArray();

			if (!empty($Classections)) {
				$total = 0;
				$totalpaidfee = 0;
				$total_due_balance = 0;
				$out = 0;

				foreach ($Classections as $service) {
					$section = $this->findsections($service);

					$amount = $this->findamount($s_id, $acedmicyear);

					$totalstudentcount = $this->findstudentcount($s_id, $acedmicyear, $section[0]['id']);

					$total += (($amount[0]['qu1_fees'] + $amount[0]['qu2_fees'] + $amount[0]['qu3_fees'] + $amount[0]['qu4_fees']) * $totalstudentcount);


					$paidamount = $this->findpaidamount($acedmicyear);

					foreach ($paidamount as $key => $value) {
						//pr($value);
						if ($value['student']['class_id'] == $s_id && $value['student']['section_id'] == $section[0]['id'] && $value['student']['acedmicyear'] == $acedmicyear) {
							$totalpaidfee += $value['fee'];
						}
					}

					//--------------------------------------------------------------------------------------------------
					$total2 = 0;

					foreach ($paidamount as $key => $value) {
						if ($value['student']['class_id'] == $s_id && $value['student']['section_id'] == $section[0]['id']) {
							if ($value['discount']) {
								$total2 += $value['amount'] - $value['fee'];
							}
						}
					}

					$total_discount += $total2;
					//----------------------------------------------------------------------------------------------------

					$out += (($amount[0]['qu1_fees'] + $amount[0]['qu2_fees'] + $amount[0]['qu3_fees'] + $amount[0]['qu4_fees']) * $totalstudentcount) - ($totalpaidfee + $total_discount);

					//Due fees calculation
					$total_due_balance += $this->sessionDueAmount($s_id, $section[0]['id'], $acedmicyear);
				}

				/*
				echo 'Total Fees= '.$total.'<br>';
				echo 'Paid Fees= '.$totalpaidfee.'<br>';       
				echo 'Due Fees= '.$total_due_balance.'<br>';
				echo 'Outstanding Fees= '.$out.'<br>'.'------------------------------------ <br>';
				*/

				$array_of_grand_totals['total_fees']        +=  $total;
				$array_of_grand_totals['paid_fees']         +=  $totalpaidfee;
				$array_of_grand_totals['due_fees']          +=  $total_due_balance;
				$array_of_grand_totals['discount_given']    +=  $total_discount;
				$array_of_grand_totals['outstanding_fees']  +=  $out - $total_due_balance;
			}
		}

		return $array_of_grand_totals;
	}

	//-----------------------------------------------------------------------------------------------------
	public function findsections($id)
	{
		$articles = TableRegistry::get('Sections');
		return  $articles->find('all')->select(['id', 'title'])->where(['id' => $id])->order(['title' => 'Asc'])->toArray();
	}

	//-----------------------------------------------------------------------------------------------------
	public function findamount($id, $a_year)
	{
		$articles = TableRegistry::get('Classfee');

		return  $articles->find('all')->contain(['Classes'])->group('Classfee.academic_year')->group('Classfee.class_id')->select([
			'qu1_fees' =>  $articles->find()->func()->sum('Classfee.qu1_fees'), 'qu2_fees' =>  $articles->find('all')->func()->sum('Classfee.qu2_fees'), 'qu3_fees' =>  $articles->find('all')->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $articles->find('all')->func()->sum('Classfee.qu4_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id'
		])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year])->order(['Classfee.id' => 'ASC'])->toArray();
	}

	//-----------------------------------------------------------------------------------------------------
	public function findstudentcount($id, $a_year, $section_id)
	{
		$articles = TableRegistry::get('Students');

		return  $articles->find('all')->where(['Students.acedmicyear' => $a_year, 'Students.status' => 'Y', 'Students.class_id' => $id, 'Students.section_id' => $section_id])->count();
	}

	//-----------------------------------------------------------------------------------------------------
	public function findpaidamount($a_year)
	{
		$articles = TableRegistry::get('Studentfees');

		return  $articles->find('all')->contain(['Students'])->where(['Studentfees.acedmicyear' => $a_year, 'Studentfees.acedmicyear' => $a_year])->order(['Studentfees.id' => 'ASC'])->toArray();
	}

	//-----------------------------------------------------------------------------------------------------------------------------------------------
	public function sessionDueAmount($class_id, $section_id, $academicyear)
	{
		$student = $this->Students->find('all')
			->where(['Students.acedmicyear' => $academicyear, 'Students.status' => 'Y', 'Students.class_id' => $class_id, 'Students.section_id' => $section_id])
			->toArray();

		$total_dues_amount = 0;

		if (!empty($student)) {
			foreach ($student as $service) {
				$findamountmonth = $this->findamountmonth($service['class_id'], $academicyear);
				$findamount3month = $this->findamount3month($service['class_id'], $academicyear);
				$findamount2month = $this->findamount2month($service['class_id'], $academicyear);
				$findamount1month = $this->findamount1month($service['class_id'], $academicyear);
				$perticularamounts = $this->findperticularamount($service['id'], $academicyear);

				$findsum = $findamountmonth['qu4_fees'] + $findamount3month['qu3_fees'] + $findamount2month['qu2_fees'] + $findamount1month['qu1_fees'];

				$paidfeestotal = 0;

				foreach ($perticularamounts as $values) {

					$paidfeestotal += $values['fee'];
				}

				if ($findsum > $paidfeestotal) {

					$dueamt = $findsum - $paidfeestotal;
					$total_dues_amount += $dueamt;
				}
			}

			return $total_dues_amount;
		}
	}

	//-----------------------------------------------------------------
	public function findamountmonth($id, $a_year)
	{
		$articles = TableRegistry::get('Classfee');
		$m = date('Y-m-d');

		return	 $articles->find('all')->contain(['Classes'])->select(['qu4_fees' =>  $articles->find()->func()->sum('Classfee.qu4_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'Classfee.qu4_date <=' => $m])->order(['Classfee.id' => 'ASC'])->first()->toArray();
	}

	//-----------------------------------------------------------------
	public function findamount3month($id, $a_year)
	{
		$articles = TableRegistry::get('Classfee');
		$m = date('Y-m-d');

		return	 $articles->find('all')->contain(['Classes'])->select(['qu3_fees' =>  $articles->find()->func()->sum('Classfee.qu3_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'Classfee.qu3_date <=' => $m])->order(['Classfee.id' => 'ASC'])->first()->toArray();
	}

	//-----------------------------------------------------------------  
	public function findamount2month($id, $a_year)
	{
		$articles = TableRegistry::get('Classfee');
		$m = date('Y-m-d');

		return	 $articles->find('all')->contain(['Classes'])->select(['qu2_fees' =>  $articles->find()->func()->sum('Classfee.qu2_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'Classfee.qu2_date <=' => $m])->order(['Classfee.id' => 'ASC'])->first()->toArray();
	}

	//-----------------------------------------------------------------
	public function findamount1month($id, $a_year)
	{
		$articles = TableRegistry::get('Classfee');
		$m = date('Y-m-d');

		return	 $articles->find('all')->contain(['Classes'])->select(['qu1_fees' =>  $articles->find()->func()->sum('Classfee.qu1_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'Classfee.qu1_date <=' => $m])->order(['Classfee.id' => 'ASC'])->first()->toArray();
	}

	//-----------------------------------------------------------------
	public function findperticularamount($id, $a_year)
	{
		$articles = TableRegistry::get('Studentfees');

		return $articles->find('all')->select(['id', 'fee', 'discount', 'amount'])->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $a_year])->toArray();
	}

	public function connection($dbs)
	{
		//    echo $dbs; //die;
		ConnectionManager::config($dbs, [
			'className' => 'Cake\Database\Connection',
			'driver' => 'Cake\Database\Driver\Mysql',
			'persistent' => false,
			'host' => MYSQLHOST,
			'username' => MYSQLUESRNAME,
			'password' => MYSQLPASSWORD,		
			'database' => $dbs,
			'encoding' => 'utf8mb4',
			'timezone' => 'UTC',
			'cacheMetadata' => true,
		]);
		ConnectionManager::drop('default');
		ConnectionManager::get($dbs);
		\Cake\Datasource\ConnectionManager::alias($dbs, 'default');
	}



	public function headbranch()
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('Users');
		$this->loadModel('Students');

		//branch count admin dashboard
		$branch = $this->Users->find('all')->select(['franchise_db', 'academic_year'])->toarray();
		$result = count(explode(',', $branch[0]['franchise_db']));
		$academic = $branch[0]['academic_year'];
		$this->set('branch_count', $result);

		$branch_name = explode(',', $branch[0]['franchise_db']);
		$this->set('branch_name', $branch_name);


		$latest_student = $this->Students->find('all')->contain(['Classes'])->where(['Students.status' => 'Y'])->order(['Students.id' => 'DESC'])->limit(5)->toarray();
		$this->set('latest_student', $latest_student);

		$stu_count  = array();
		$stu_drop = array();
		$total_emplyoees = array();
		$dropout_emplyoees = array();
		$total_fess = array();
		$current_day_fess = array();
		$month_fess = array();
		$year_fess = array();
		$admission_count = array();
		$stu_present_count = array();
		$stu_absent_count = array();



		$i = 1;

		$total_fess_count_april = 0;
		$total_fess_count_may = 0;
		$total_fess_count_june = 0;
		foreach ($branch_name as $value) {
			$this->connection($value);
			$conect_new = ConnectionManager::get($value);
			$this->loadModel('Students');
			$this->loadModel('DropOutStudent');
			$this->loadModel('Employees');
			$this->loadModel('Studentfees');
			$this->loadModel('Studattends');

			$current_year_array =  (date('Y'));
			$next_year_array = (date('Y') + 1);

			$date =  date('Y-m-d');
			$financial_year = array('4' => $current_year_array, '5' => $current_year_array, '6' => $current_year_array, '7' => $current_year_array, '8' => $current_year_array, '9' => $current_year_array, '10' => $current_year_array, '11' => $current_year_array, '12' => $current_year_array, '1' => $next_year_array, '2' => $next_year_array, '3' => $next_year_array);
			$credit_this_month = array();

			//Apr
			$sintall = "SELECT SUM(deposite_amt) AS deposite_amt FROM student_feeallocations WHERE YEAR(created) = {$financial_year[4]} AND MONTH(created) = 4 AND DATE(created) <= '{$date}'";
			$fees_count_month_april = $conect_new->execute($sintall)->fetch('assoc');
			$total_fess_count_april += $fees_count_month_april['deposite_amt'];
			// pr($total_fess_count_april);

			//May
			$sintall = "SELECT SUM(deposite_amt) AS deposite_amt FROM student_feeallocations WHERE YEAR(created) = {$financial_year[5]} AND MONTH(created) = 5 AND DATE(created) <= '{$date}'";
			$fees_count_month_may = $conect_new->execute($sintall)->fetch('assoc');
			$total_fess_count_may += $fees_count_month_may['deposite_amt'];

			//June  
			$sintall = "SELECT SUM(deposite_amt) AS deposite_amt FROM student_feeallocations WHERE YEAR(created) = {$financial_year[6]} AND MONTH(created) = 6 AND DATE(created) <= '{$date}'";
			$fees_count_month_june = $conect_new->execute($sintall)->fetch('assoc');
			$total_fess_count_june += $fees_count_month_june['deposite_amt'];


			//july
			$sintall = "SELECT SUM(deposite_amt) AS deposite_amt FROM student_feeallocations WHERE YEAR(created) = {$financial_year[7]} AND MONTH(created) = 7 AND DATE(created) <= '{$date}'";
			$fees_count_month_july = $conect_new->execute($sintall)->fetch('assoc');
			$total_fess_count_july += $fees_count_month_july['deposite_amt'];


			//August
			$sintall = "SELECT SUM(deposite_amt) AS deposite_amt FROM student_feeallocations WHERE YEAR(created) = {$financial_year[8]} AND MONTH(created) = 8 AND DATE(created) <= '{$date}'";
			$fees_count_month_aug = $conect_new->execute($sintall)->fetch('assoc');
			$total_fess_count_aug += $fees_count_month_aug['deposite_amt'];


			//September
			$sintall = "SELECT SUM(deposite_amt) AS deposite_amt FROM student_feeallocations WHERE YEAR(created) = {$financial_year[9]} AND MONTH(created) = 9 AND DATE(created) <= '{$date}'";
			$fees_count_month_sep = $conect_new->execute($sintall)->fetch('assoc');
			$total_fess_count_sep += $fees_count_month_sep['deposite_amt'];

			//October
			$sintall = "SELECT SUM(deposite_amt) AS deposite_amt FROM student_feeallocations WHERE YEAR(created) = {$financial_year[10]} AND MONTH(created) = 10 AND DATE(created) <= '{$date}'";
			$fees_count_month_oct = $conect_new->execute($sintall)->fetch('assoc');
			$total_fess_count_oct += $fees_count_month_oct['deposite_amt'];


			//November
			$sintall = "SELECT SUM(deposite_amt) AS deposite_amt FROM student_feeallocations WHERE YEAR(created) = {$financial_year[11]} AND MONTH(created) = 11 AND DATE(created) <= '{$date}'";
			$fees_count_month_nov = $conect_new->execute($sintall)->fetch('assoc');
			$total_fess_count_nov += $fees_count_month_nov['deposite_amt'];

			//December
			$sintall = "SELECT SUM(deposite_amt) AS deposite_amt FROM student_feeallocations WHERE YEAR(created) = {$financial_year[12]} AND MONTH(created) = 12 AND DATE(created) <= '{$date}'";
			$fees_count_month_dec = $conect_new->execute($sintall)->fetch('assoc');
			$total_fess_count_dec += $fees_count_month_dec['deposite_amt'];


			//January
			$sintall = "SELECT SUM(deposite_amt) AS deposite_amt FROM student_feeallocations WHERE YEAR(created) = {$financial_year[1]} AND MONTH(created) = 1 AND DATE(created) <= '{$date}'";
			$fees_count_month_jan = $conect_new->execute($sintall)->fetch('assoc');
			$total_fess_count_jan += $fees_count_month_jan['deposite_amt'];


			//February
			$sintall = "SELECT SUM(deposite_amt) AS deposite_amt FROM student_feeallocations WHERE YEAR(created) = {$financial_year[2]} AND MONTH(created) = 2 AND DATE(created) <= '{$date}'";
			$fees_count_month_feb = $conect_new->execute($sintall)->fetch('assoc');
			$total_fess_count_feb += $fees_count_month_feb['deposite_amt'];


			//March 
			$sintall = "SELECT SUM(deposite_amt) AS deposite_amt FROM student_feeallocations WHERE YEAR(created) = {$financial_year[3]} AND MONTH(created) = 3 AND DATE(created) <= '{$date}'";
			$fees_count_month_march = $conect_new->execute($sintall)->fetch('assoc');
			$total_fess_count_march += $fees_count_month_march['deposite_amt'];

			//	pr($total_fess_count_march);

			$current_dateee = date('Y-m-d');
			$sintall = "SELECT count(*) as stu_present_count FROM studattends where `status`='P' AND DATE(studattends.created) ='$current_dateee'";
			$rinstall = $conect_new->execute($sintall)->fetch('assoc');
			$stu_present_count[] = $rinstall['stu_present_count'];


			$sintall = "SELECT count(*) as stu_absent_count FROM studattends where `status`='A' AND DATE(studattends.created) ='$current_dateee'";
			$rinstall = $conect_new->execute($sintall)->fetch('assoc');
			$stu_absent_count[] = $rinstall['stu_absent_count'];



			$sintall = "SELECT count(*) as student_count FROM students where acedmicyear in('2022-23','2023-24','2024-25')   and `status` ='Y'";
			$rinstall = $conect_new->execute($sintall)->fetch('assoc');
			$stu_count[] = $rinstall['student_count'];

			$sintall = "SELECT count(*) as stu_drop FROM drop_out_students";
			$rinstall = $conect_new->execute($sintall)->fetch('assoc');
			$stu_drop[] = $rinstall['stu_drop'];


			$sintall = "SELECT count(*) as total_emplyoees FROM employees";
			$rinstall = $conect_new->execute($sintall)->fetch('assoc');
			$total_emplyoees[] = $rinstall['total_emplyoees'];

			$sintall = "SELECT count(*) as dropout_emplyoees FROM drop_out_employees";
			$rinstall = $conect_new->execute($sintall)->fetch('assoc');
			$dropout_emplyoees[] = $rinstall['dropout_emplyoees'];

			// headbranch page fees total
			// current acedmic year calculate
			$period = date('Y-m');
			$expDate = explode('-', $period);
			$month = $expDate[1];
			$year = $expDate[0];
			$startSessionDate = $year . "-04-01";
			$endsessionDate = $year + 1 . "-03-31";

			$sintall = "SELECT sum(deposite_amt) as total_fess FROM student_feeallocations  where created >= '$startSessionDate'AND created <= '$endsessionDate'";
			$rinstall = $conect_new->execute($sintall)->fetch('assoc');
			$total_fess[] = $rinstall['total_fess'];


			$sintall = "SELECT SUM(deposite_amt)  FROM student_feeallocations where created=curdate()";
			$rinstall = $conect_new->execute($sintall)->fetch('assoc');
			$current_day_fess[] = $rinstall['current_day_fess'];


			$sintall = "SELECT SUM(deposite_amt) as month_fess FROM student_feeallocations GROUP BY MONTH(created)";
			$rinstall = $conect_new->execute($sintall)->fetch('assoc');
			$month_fess[] = $rinstall['month_fess'];

			// current acedmic year calculate
			$period = date('Y-m');
			$expDate = explode('-', $period);
			$month = $expDate[1];
			$year = $expDate[0];
			$startSessionDate = $year . "-04-01";
			$endsessionDate = $year + 1 . "-03-31";

			$sintall = "SELECT SUM(deposite_amt) as year_fess FROM student_feeallocations where created >= '$startSessionDate'AND created <= '$endsessionDate'";
			$rinstall = $conect_new->execute($sintall)->fetch('assoc');
			$year_fess[] = $rinstall['year_fess'];



			$sintall = "SELECT SUM(deposite_amt) as week_fess FROM student_feeallocations GROUP BY WEEK(created)";
			$rinstall = $conect_new->execute($sintall)->fetch('assoc');
			$week_fess[] = $rinstall['week_fess'];

			$sintall = "SELECT count(*) as admission_count FROM students GROUP BY YEAR(admissionyear)";
			$rinstall = $conect_new->execute($sintall)->fetch('assoc');
			$admission_count[] = $rinstall['admission_count'];
		}


		$this->set('fees_count_month_april', $total_fess_count_april);
		$this->set('fees_count_month_may', $total_fess_count_may);
		$this->set('fees_count_month_june', $total_fess_count_june);
		$this->set('fees_count_month_july', $total_fess_count_july);
		$this->set('fees_count_month_aug', $total_fess_count_aug);
		$this->set('fees_count_month_sep', $total_fess_count_sep);
		$this->set('fees_count_month_oct', $total_fess_count_oct);
		$this->set('fees_count_month_nov', $total_fess_count_nov);
		$this->set('fees_count_month_dec', $total_fess_count_dec);
		$this->set('fees_count_month_jan', $total_fess_count_jan);
		$this->set('fees_count_month_feb', $total_fess_count_feb);
		$this->set('fees_count_month_march', $total_fess_count_march);

		$this->set('stu_count', array_sum($stu_count));
		$this->set('stu_drop', array_sum($stu_drop));
		$this->set('total_emplyoees', array_sum($total_emplyoees));
		$this->set('dropout_emplyoees', array_sum($dropout_emplyoees));
		$this->set('total_fess', array_sum($total_fess));
		$this->set('current_day_fess', array_sum($current_day_fess));
		$this->set('month_fess', array_sum($month_fess));
		$this->set('year_fess', array_sum($year_fess));
		$this->set('week_fess', array_sum($week_fess));
		$this->set('admission_count', array_sum($admission_count));
		$this->set('stu_present_count', array_sum($stu_present_count));
		$this->set('stu_absent_count', array_sum($stu_absent_count));
	}


	// public function adminbranch()
	// {
	// 	$this->viewBuilder()->layout('admin');
	// 	$this->loadModel('Students');
	// 	$this->loadModel('DropOutStudent');
	// 	$this->loadModel('Studattends');
	// 	$this->loadModel('Staffattends');
	// 	$this->loadModel('Classes');
	// 	$this->loadModel('Studentfees');
	// 	$this->loadModel('Employees');
	// 	$this->loadModel('DropOutEmployee');

	// 	//fincial year base calculate
	// 	$period = date('Y-m');
	// 	$expDate = explode('-', $period);
	// 	$month = $expDate[1];
	// 	$year = $expDate[0];
	// 	$current_year_array = $year . "-04-01";
	// 	$next_year_array = $year + 1 . "-03-31";
	// 	// total fees current date headra
	// 	$date = date('m');
	// 	$fees_count = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['created >=' => $current_year_array, 'created <=' => $next_year_array,'status'=>'Y'])->first();
	// 	$this->set('fees_count', $fees_count);

	// 	//Days wise fees
	// 	$fees_count_days = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['DAY(created)' => date('d'), 'MONTH(created)' => $date,'status'=>'Y','YEAR(created)' => date('Y')])->first();
	// 	$this->set('fees_count_days', $fees_count_days);

	// 	$fees_count_week = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['DATE(created) >=' => date('Y-m-d', strtotime('monday this week')),'status'=>'Y'])->first();
	// 	$this->set('fees_count_week', $fees_count_week['deposite_amt']);

	// 	$fees_count_month = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['MONTH(created)' => $date, 'YEAR(created)' => date('Y'),'status'=>'Y'])->first();
	// 	$this->set('fees_count_month', $fees_count_month);

	// 	$current_date = date('Y-m-d');
	// 	$staff_absent = $this->Employees->find()->where(['Employees.is_drop' => 'Y', 'Employees.status' => 'N'])->count();
	// 	$this->set('staff_drop', $staff_absent);


	// 	//total year fees
	// 	$fees_current_year = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['created >=' => $current_year_array, 'created <=' => $next_year_array,'status'=>'Y'])->first();
	// 	$this->set('fees_current_year', $fees_current_year);
	// 	$academic_year  = $this->financialyear();
	// 	// pr($academic_year);die;

	// 	// $data_count = $this->Students->find('all')->where(['Students.status' => 'Y', 'Students.acedmicyear' => '2023-24'])->count();
	// 	$data_count = $this->Students->find('all')->where(['Students.status' => 'Y'])->count();
	// 	$this->set('stu_count', $data_count);

	// 	// $stu_drop = $this->DropOutStudent->find('all')->where(['acedmicyear' => "2023-24"])->count();
	// 	$stu_drop = $this->DropOutStudent->find('all')->count();

	// 	$this->set('stu_drop', $stu_drop);

	// 	$tech_count = $this->Employees->find('all')->where(['Employees.status' => 'Y'])->count();
	// 	$this->set('teacher_count', $tech_count);

	// 	$current_date = date('Y-m-d');
	// 	$stu_present = $this->Studattends->find('all')->where(['Studattends.status' => 'P', 'DATE(Studattends.date)' => $current_date])->count();
	// 	$this->set('stu_present', $stu_present);

	// 	$stu_absent = $this->Studattends->find('all')->where(['Studattends.status' => 'A', 'DATE(Studattends.date)' => $current_date])->count();
	// 	$this->set('stu_absent', $stu_absent);



	// 	//Latest Admissions
	// 	$latest_student = $this->Students->find('all')->contain(['Classes','Sections'])->where(['Students.status' => 'Y'])->order(['Students.id' => 'DESC'])->select(['Students.fname','Students.st_full_name','Students.middlename','Students.lname','Students.fathername','Students.mobile','Students.enroll','Students.created','Classes.title','Sections.title'])->limit(10)->toarray();
	// 	// pr($latest_student);exit;
	// 	$this->set('latest_student', $latest_student);

	// 	// $new_admission = $this->Students->find('all')->where(['Students.admissionyear' => date("Y") . '-' . (date("y") + 1), 'Students.status' => 'Y'])->count();
	// 	// $this->set('new_admission', $new_admission);

	// 	$current_year_array =  (date('Y'));
	// 	$next_year_array = (date('Y') + 1);
	// 	$date =  date('Y-m-d');
	// 	$financial_year = array('4' => $current_year_array, '5' => $current_year_array, '6' => $current_year_array, '7' => $current_year_array, '8' => $current_year_array, '9' => $current_year_array, '10' => $current_year_array, '11' => $current_year_array, '12' => $current_year_array, '1' => $next_year_array, '2' => $next_year_array, '3' => $next_year_array);
	// 	//pr($financial_year);
	// 	$credit_this_month = array();

	// 	//pr($cars);
	// 	$fees_count_month_april = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[4], 'MONTH(created)' => 4, 'DATE(created) <=' => $date,'status'=>'Y'])->first();


	// 	$fees_count_month_may = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[5], 'MONTH(created)' => 5, 'DATE(created) <=' => $date,'status'=>'Y'])->first();

	// 	$fees_count_month_june = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[6], 'MONTH(created)' => 6, 'DATE(created) <=' => $date,'status'=>'Y'])->first();


	// 	$fees_count_month_july = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[7], 'MONTH(created)' => 7, 'DATE(created) <=' => $date,'status'=>'Y'])->first();


	// 	$fees_count_month_aug = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[8], 'MONTH(created)' => 8, 'DATE(created) <=' => $date,'status'=>'Y'])->first();


	// 	$fees_count_month_sep = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[9], 'MONTH(created)' => 9, 'DATE(created) <=' => $date,'status'=>'Y'])->first();


	// 	$fees_count_month_oct = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[10], 'MONTH(created)' => 10, 'DATE(created) <=' => $date,'status'=>'Y'])->first();


	// 	$fees_count_month_nov = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[11], 'MONTH(created)' => 11, 'DATE(created) <=' => $date,'status'=>'Y'])->first();


	// 	$fees_count_month_dec = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[12], 'MONTH(created)' => 12, 'DATE(created) <=' => $date,'status'=>'Y'])->first();

	// 	$fees_count_month_jan = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[1], 'MONTH(created)' => 1, 'DATE(created) <=' => $date,'status'=>'Y'])->first();

	// 	$fees_count_month_feb = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[2], 'MONTH(created)' => 2, 'DATE(created) <=' => $date,'status'=>'Y'])->first();

	// 	$fees_count_month_march = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[3], 'MONTH(created)' => 3, 'DATE(created) <=' => $date,'status'=>'Y'])->first();



	// 	$this->set('fees_count_month_april', $fees_count_month_april['deposite_amt']);
	// 	$this->set('fees_count_month_may', $fees_count_month_may['deposite_amt']);
	// 	$this->set('fees_count_month_june', $fees_count_month_june['deposite_amt']);
	// 	$this->set('fees_count_month_july', $fees_count_month_july['deposite_amt']);
	// 	$this->set('fees_count_month_aug', $fees_count_month_aug['deposite_amt']);
	// 	$this->set('fees_count_month_sep', $fees_count_month_sep['deposite_amt']);
	// 	$this->set('fees_count_month_oct', $fees_count_month_oct['deposite_amt']);
	// 	$this->set('fees_count_month_nov', $fees_count_month_nov['deposite_amt']);
	// 	$this->set('fees_count_month_dec', $fees_count_month_dec['deposite_amt']);
	// 	$this->set('fees_count_month_jan', $fees_count_month_jan['deposite_amt']);
	// 	$this->set('fees_count_month_feb', $fees_count_month_feb['deposite_amt']);
	// 	$this->set('fees_count_month_march', $fees_count_month_march['deposite_amt']);


	// 	// foreach($financial_year as $key_month=>$value_year)	{
	// 	// 	$dt = \DateTime::createFromFormat('!m', $key_month);
	// 	// 	$month_name=$dt->format('M');

	// 	// 	//echo $value_year;
	// 	// 	//echo $key_month;
	// 	// 	//echo $date;
	// 	// 	$fees_count_month=$this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)'=> $value_year,'MONTH(created)'=>$key_month,'DATE(created) <'=>$date])->first();
	// 	// 	//pr($fees_count_month); //die;


	// 	// 	if($fees_count_month['deposite_amt']){
	// 	// 		$fee_amt =  $fees_count_month['deposite_amt'];
	// 	// 	}else{
	// 	// 		$fee_amt =  0;
	// 	// 	}
	// 	// 	$fee = $fee_amt;
	// 	// 	$fees_amount[] = array($month_name,$fee);
	// 	// }
	// 	$allfees = json_encode($fees_amount);
	// }

	// code update by rupam 02-01-2024 
	public function adminbranch()
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('Students');
		$this->loadModel('DropOutStudent');
		$this->loadModel('Studattends');
		$this->loadModel('Staffattends');
		$this->loadModel('Classes');
		$this->loadModel('Studentfees');
		$this->loadModel('Employees');
		$this->loadModel('DropOutEmployee');
		$this->loadModel('DropOutEmployee');
		$this->loadModel('Users');

		//fincial year base calculate
		$period = date('Y-m');
		$expDate = explode('-', $period);
		$month = $expDate[1];
		$year = $expDate[0];

		$acdmic = $this->Users->find('all')->where(['id' => 1])->first();
		$year = explode('-',$acdmic['academic_year']);

		$current_year_array = $year[0] . "-04-01";
		$next_year_array = '20'.$year[1] . "-03-31";
		
		// total fees current date headra
		$date = date('m');
		$fees_count = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['paydate >=' => $current_year_array, 'paydate <=' => $next_year_array, 'recipetno !=' => 0, 'status' => 'Y'])->first();
		$this->set('fees_count', $fees_count);

		//day wise fees
		$currentDate = date('Y-m-d');
		$fees_count_days = $this->Studentfees->find()
			->select(['deposite_amt' => 'SUM(deposite_amt)'])
			->where([
				'DATE(paydate)' => $currentDate, // Compare with today's date
				'status' => 'Y',
				'recipetno !=' => 0
			])
			->first();
		$this->set('fees_count_days', $fees_count_days);

		$fees_count_week = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['DATE(paydate) >=' => date('Y-m-d', strtotime('monday this week')), 'recipetno !=' => 0, 'status' => 'Y'])->first();
		$this->set('fees_count_week', $fees_count_week['deposite_amt']);

		$fees_count_month = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['MONTH(paydate)' => $date, 'YEAR(paydate)' => date('Y'), 'recipetno !=' => 0, 'status' => 'Y'])->first();
		$this->set('fees_count_month', $fees_count_month);

		$current_date = date('Y-m-d');
		$staff_absent = $this->Employees->find()->where(['Employees.is_drop' => 'Y', 'Employees.status' => 'N'])->count();
		$this->set('staff_drop', $staff_absent);


		//total year fees
		$fees_current_year = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['paydate >=' => $current_year_array, 'paydate <=' => $next_year_array, 'recipetno !=' => 0, 'status' => 'Y'])->first();
		$this->set('fees_current_year', $fees_current_year);

		$data_count = $this->Students->find('all')->where(['Students.status' => 'Y'])->count();
		$this->set('stu_count', $data_count);
		$stu_drop = $this->DropOutStudent->find('all')->count();
		$this->set('stu_drop', $stu_drop);

		$tech_count = $this->Employees->find('all')->where(['Employees.status' => 'Y'])->count();
		$this->set('teacher_count', $tech_count);

		$current_date = date('Y-m-d');
		$stu_present = $this->Studattends->find('all')->where(['Studattends.status' => 'P', 'DATE(Studattends.date)' => $current_date])->count();
		$this->set('stu_present', $stu_present);

		$stu_absent = $this->Studattends->find('all')->where(['Studattends.status' => 'A', 'DATE(Studattends.date)' => $current_date])->count();
		$this->set('stu_absent', $stu_absent);

		//Latest Admissions
		$latest_student = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.status' => 'Y'])->order(['Students.id' => 'DESC'])->select(['Students.fname', 'Students.st_full_name', 'Students.middlename', 'Students.lname', 'Students.fathername', 'Students.mobile', 'Students.enroll', 'Students.created', 'Classes.title', 'Sections.title'])->limit(10)->toarray();
		$this->set('latest_student', $latest_student);

		$acdmic = $this->Users->find('all')->where(['id' => 1])->first();
		$year = explode('-',$acdmic['academic_year']);
// pr($year);die;
		// $current_year_array =  (date('Y') - 1);
		// $next_year_array = (date('Y') );
		$current_year_array =  $year[0];
		$next_year_array = '20'.$year[1];
		// pr($next_year_array);exit;
		$date =  date('Y-m-d');
		$financial_year = array('4' => $current_year_array, '5' => $current_year_array, '6' => $current_year_array, '7' => $current_year_array, '8' => $current_year_array, '9' => $current_year_array, '10' => $current_year_array, '11' => $current_year_array, '12' => $current_year_array, '1' => $next_year_array, '2' => $next_year_array, '3' => $next_year_array);
		// pr($financial_year);die;
		$credit_this_month = array();

		//pr($cars);
		$fees_count_month_april = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(paydate)' => $financial_year[4], 'MONTH(paydate)' => 4, 'DATE(paydate) <=' => $date, 'recipetno !=' => 0, 'status' => 'Y'])->first();
		// pr($fees_count_month_april); die;


		$fees_count_month_may = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(paydate)' => $financial_year[5], 'MONTH(paydate)' => 5, 'DATE(paydate) <=' => $date, 'recipetno !=' => 0, 'status' => 'Y'])->first();

		$fees_count_month_june = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(paydate)' => $financial_year[6], 'MONTH(paydate)' => 6, 'DATE(paydate) <=' => $date, 'recipetno !=' => 0, 'status' => 'Y'])->first();


		$fees_count_month_july = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(paydate)' => $financial_year[7], 'MONTH(paydate)' => 7, 'DATE(paydate) <=' => $date, 'recipetno !=' => 0, 'status' => 'Y'])->first();


		$fees_count_month_aug = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(paydate)' => $financial_year[8], 'MONTH(paydate)' => 8, 'DATE(paydate) <=' => $date, 'recipetno !=' => 0, 'status' => 'Y'])->first();


		$fees_count_month_sep = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(paydate)' => $financial_year[9], 'MONTH(paydate)' => 9, 'DATE(paydate) <=' => $date, 'recipetno !=' => 0, 'status' => 'Y'])->first();


		$fees_count_month_oct = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(paydate)' => $financial_year[10], 'MONTH(paydate)' => 10, 'DATE(paydate) <=' => $date, 'recipetno !=' => 0, 'status' => 'Y'])->first();


		$fees_count_month_nov = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(paydate)' => $financial_year[11], 'MONTH(paydate)' => 11, 'DATE(paydate) <=' => $date, 'recipetno !=' => 0, 'status' => 'Y'])->first();


		$fees_count_month_dec = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(paydate)' => $financial_year[12], 'MONTH(paydate)' => 12, 'DATE(paydate) <=' => $date, 'recipetno !=' => 0, 'status' => 'Y'])->first();

		$fees_count_month_jan = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(paydate)' => $financial_year[1], 'MONTH(paydate)' => 1, 'DATE(paydate) <=' => $date, 'recipetno !=' => 0, 'status' => 'Y'])->first();

		$fees_count_month_feb = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(paydate)' => $financial_year[2], 'MONTH(paydate)' => 2, 'DATE(paydate) <=' => $date, 'recipetno !=' => 0, 'status' => 'Y'])->first();

		$fees_count_month_march = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(paydate)' => $financial_year[3], 'MONTH(paydate)' => 3, 'DATE(paydate) <=' => $date, 'recipetno !=' => 0, 'status' => 'Y'])->first();



		$this->set('fees_count_month_april', $fees_count_month_april['deposite_amt']);
		$this->set('fees_count_month_may', $fees_count_month_may['deposite_amt']);
		$this->set('fees_count_month_june', $fees_count_month_june['deposite_amt']);
		$this->set('fees_count_month_july', $fees_count_month_july['deposite_amt']);
		$this->set('fees_count_month_aug', $fees_count_month_aug['deposite_amt']);
		$this->set('fees_count_month_sep', $fees_count_month_sep['deposite_amt']);
		$this->set('fees_count_month_oct', $fees_count_month_oct['deposite_amt']);
		$this->set('fees_count_month_nov', $fees_count_month_nov['deposite_amt']);
		$this->set('fees_count_month_dec', $fees_count_month_dec['deposite_amt']);
		$this->set('fees_count_month_jan', $fees_count_month_jan['deposite_amt']);
		$this->set('fees_count_month_feb', $fees_count_month_feb['deposite_amt']);
		$this->set('fees_count_month_march', $fees_count_month_march['deposite_amt']);



		// this code for calculte all students pending fees
		$total_balance = $this->Users->find('all')->select(['pending_fees'])->where(['role_id' => 1])->first();
		$this->set('total_pending', $total_balance);
	}

	// this function use for show data in chart
	public function getfeesdata()
	{
		$branch_data = $this->request->data(['options']);
		$this->set('branch_data', $branch_data);
		$this->connection($branch_data);
		$conect_new = ConnectionManager::get($branch_data);
		$stu_count = array();
		$stu_drop = array();
		$this->loadModel('Students');
		$this->loadModel('DropOutStudent');
		$this->loadModel('Studentfees');

		$current_year_array =  (date('Y'));
		$next_year_array = (date('Y') + 1);
		$date =  date('Y-m-d');
		$financial_year = array('4' => $current_year_array, '5' => $current_year_array, '6' => $current_year_array, '7' => $current_year_array, '8' => $current_year_array, '9' => $current_year_array, '10' => $current_year_array, '11' => $current_year_array, '12' => $current_year_array, '1' => $next_year_array, '2' => $next_year_array, '3' => $next_year_array);
		//pr($financial_year);
		$credit_this_month = array();



		//pr($cars);
		$fees_count_month_april = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[4], 'MONTH(created)' => 4, 'DATE(created) <=' => $date])->first();


		$fees_count_month_may = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[5], 'MONTH(created)' => 5, 'DATE(created) <=' => $date])->first();

		$fees_count_month_june = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[6], 'MONTH(created)' => 6, 'DATE(created) <=' => $date])->first();


		$fees_count_month_july = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[7], 'MONTH(created)' => 7, 'DATE(created) <=' => $date])->first();


		$fees_count_month_aug = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[8], 'MONTH(created)' => 8, 'DATE(created) <=' => $date])->first();


		$fees_count_month_sep = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[9], 'MONTH(created)' => 9, 'DATE(created) <=' => $date])->first();


		$fees_count_month_oct = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[10], 'MONTH(created)' => 10, 'DATE(created) <=' => $date])->first();


		$fees_count_month_nov = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[11], 'MONTH(created)' => 11, 'DATE(created) <=' => $date])->first();


		$fees_count_month_dec = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[12], 'MONTH(created)' => 12, 'DATE(created) <=' => $date])->first();

		$fees_count_month_jan = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[1], 'MONTH(created)' => 1, 'DATE(created) <=' => $date])->first();

		$fees_count_month_feb = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[2], 'MONTH(created)' => 2, 'DATE(created) <=' => $date])->first();

		$fees_count_month_march = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => $financial_year[3], 'MONTH(created)' => 3, 'DATE(created) <=' => $date])->first();



		$this->set('fees_count_month_april', $fees_count_month_april['deposite_amt']);
		$this->set('fees_count_month_may', $fees_count_month_may['deposite_amt']);
		$this->set('fees_count_month_june', $fees_count_month_june['deposite_amt']);
		$this->set('fees_count_month_july', $fees_count_month_july['deposite_amt']);
		$this->set('fees_count_month_aug', $fees_count_month_aug['deposite_amt']);
		$this->set('fees_count_month_sep', $fees_count_month_sep['deposite_amt']);
		$this->set('fees_count_month_oct', $fees_count_month_oct['deposite_amt']);
		$this->set('fees_count_month_nov', $fees_count_month_nov['deposite_amt']);
		$this->set('fees_count_month_dec', $fees_count_month_dec['deposite_amt']);
		$this->set('fees_count_month_jan', $fees_count_month_jan['deposite_amt']);
		$this->set('fees_count_month_feb', $fees_count_month_feb['deposite_amt']);
		$this->set('fees_count_month_march', $fees_count_month_march['deposite_amt']);
	}

	// this function is use to headbranch show data click on dropdown
	public function getbranchdata()
	{
		$this->loadModel('Users');
		$branch = $this->Users->find('all')->select(['franchise_db', 'academic_year'])->toarray();
		$academic = $branch[0]['academic_year'];

		$branch_data = $this->request->data(['options']);
		$this->set('branch_data', $branch_data);
		$this->connection($branch_data);
		$conect_new = ConnectionManager::get($branch_data);
		$stu_count = array();
		$stu_drop = array();
		$this->loadModel('Students');
		$this->loadModel('DropOutStudent');
		$this->loadModel('Studentfees');

		// acedmic year dynamic
		$student_count = "SELECT count(*) as student_count FROM students where acedmicyear= '$academic' and `status` ='Y'";
		$rinstall = $conect_new->execute($student_count)->fetch('assoc');
		$stu_count[] = $rinstall['student_count'];
		$this->set('stu_count', array_sum($stu_count));

		// acedmic year dynamic
		$sintall = "SELECT count(*) as stu_drop FROM drop_out_students where acedmicyear= '$academic'";
		$rinstall = $conect_new->execute($sintall)->fetch('assoc');
		$stu_drop[] = $rinstall['stu_drop'];
		$this->set('stu_drop', array_sum($stu_drop));

		$date = date('m');
		// //Days wise fees
		$fees_today = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['DATE(created)' => date('Y-m-d')])->first();
		$this->set('fees_today', $fees_today);

		// current acedmic year calculate
		$period = date('Y-m');
		$expDate = explode('-', $period);
		$month = $expDate[1];
		$year = $expDate[0];
		$startSessionDate = $year . "-04-01";
		$endsessionDate = $year + 1 . "-03-31";
		// acedmic year dynamic
		$fees_count_totalyear = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['created >=' => $startSessionDate, 'created <=' => $endsessionDate])->first();
		$this->set('fees_count_totalyear', $fees_count_totalyear);

		$fees_count_week = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['DATE(created) >=' => date('Y-m-d', strtotime('monday this week'))])->first();
		$this->set('fees_count_week', $fees_count_week);

		$fees_count_month = $this->Studentfees->find('all')->select(['deposite_amt' => 'SUM(deposite_amt)'])->where(['MONTH(created)' => $date, 'acedmicyear' => $academic])->first();
		//pr($fees_count_month); die;
		$this->set('fees_count_month', $fees_count_month);

		$new_admission = $this->Students->find('all')->where(['Students.admissionyear' => date("Y") . '-' . (date("y") + 1), 'Students.status' => 'Y'])->count();
		$this->set('new_admission', $new_admission);
	}

	public function applogindata()
	{
		$this->loadModel('Users');
		$db = $this->request->session()->read('Auth.User.db');
		if ($db == "canvas") {
			$branch_namesss = $this->Users->find('all')->where(['role_id' => '105'])->toarray();
			$branch_list = $branch_namesss[0]['franchise_db'];
			$expload_branch_name = explode(',', $branch_list);
		} else {
			$expload_branch_name[] = $db;
		}
		sort($expload_branch_name);
		// pr($expload_branch_name); die;
		$this->set(compact('expload_branch_name'));
	}
}
