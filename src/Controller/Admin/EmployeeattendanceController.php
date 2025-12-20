<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper;

include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';

/**
 * Creating Attendance module for School Employees
 */
class EmployeeattendanceController extends AppController
{
    //----------------------------------------
    public $helpers = ['CakeJs.Js'];

    //----------------------------------------
    public function initialize()
    {
        parent::initialize();

        //Loading Models
        $this->loadModel('Shift');
        $this->loadModel('Departments');
        $this->loadModel('Designations');
        $this->loadModel('Employees');
        $this->loadModel('EmployeeAttendance');
        $this->loadModel('Students');
        $this->loadModel('Classes');
        $this->loadModel('Timetables');

        $this->loadModel('Subjects');
        $this->loadModel('Subjectclass');
        $this->loadModel('ClasstimeTabs');
        $this->loadModel('Classections');
        $this->loadModel('Sections');
    }

    //----------------------------------------
    public function index($designation_id = null, $current_date = null)
    {
        $this->viewBuilder()->layout('admin');
        if ($current_date == '') {
            $current_date = date('Y-m-d');
            $this->set('date', $current_date);
        } else {

            $this->set('date', $current_date);
        }



        $designations = $this->Designations->find('list')->where(['Designations.status' => 'Y'])->order(['Designations.name' => 'Asc'])->toarray();

        $this->set(compact('departments'));


        if (!empty($designation_id)) {

            $cond = [];
            if (!empty($designation_id)) {
                $cond['Designations.id'] = $designation_id;
            }
            $cond['Employees.status'] = 'Y';
            $current_date = date('Y-m-d', strtotime($current_date));
            $emp_attendance = $this->EmployeeAttendance->find()->select('employee_id')->where(['date' => $current_date])->order(['id' => 'ASC'])->toArray();
            if (!empty($emp_attendance)) {
                $arr = [];
                foreach ($emp_attendance as $value) {
                    $arr[] = $value['employee_id'];
                }
                $cond['Employees.id IN'] = $arr;
            }
            $employees = $this->Employees->find()->select(['id', 'fname', 'middlename', 'lname', 'Designations.id', 'Designations.name'])->contain(['Designations'])->where($cond)->order(['Employees.id' => 'ASC'])->toArray();
            if (!empty($employees)) {
                $shifts = $this->Shift->find('all')->where(['Shift.id' => 1])->first()->toArray();
                $this->set(compact('employees', 'shifts', 'current_date'));
            } else {
                echo '<div class="alert alert-warning alert-dismissable auto-hide">
					<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
					<i class="fa fa-exclamation-triangle"></i> 
					No employee found with above criteria.
				</div>';
                exit;
            }
        } else {
            $current_date = date('Y-m-d', strtotime($current_date));
            $employees = $this->Employees->find()->select(['id', 'fname', 'middlename', 'lname', 'Designations.id', 'Designations.name'])
                ->contain(['Designations'])->where($cond)->order(['Employees.id' => 'ASC'])->toArray();
            if (!empty($employees)) {
                $shifts = $this->Shift->find('all')->where(['Shift.id' => 1])->first()->toArray();

                $this->set(compact('employees', 'shifts', 'current_date'));
            } else {
                echo '<div class="alert alert-warning alert-dismissable auto-hide">
					<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
					<i class="fa fa-exclamation-triangle"></i> 
					No employee found with above criteria.
				</div>';

                exit;
            }
        }
    }

    public function find_section($id = null)
    {

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


    public function teacheroccupy()
    {
        $this->loadModel('Substitutes');
        $this->loadModel('ClasstimeTabs');
        $empid = $this->request->data['empid'];
        $tid = $this->request->data['tid'];
        $week = $this->request->data['week'];
        $userTable = TableRegistry::get('ClasstimeTabs');
        $exists = $userTable->exists(['employee_id' => $empid, 'tt_id' => $tid, 'weekday' => $week]);
        $date = date('Y-m-d');
        $userTable1 = TableRegistry::get('Substitutes');
        $exists1 = $userTable1->exists(['new_empid' => $empid, 'timetable_id' => $tid, 'weekday' => $week, 'today_date' => $date]);
        if ($exists) {
            echo "Teacher Already Assigned period in another section";
            die;
        } else if ($exists1) {
            echo "Teacher Already Assigned in another class Today";
            die;
        } else {
            echo 0;
            die;
        }
    }


    public function checkallsubstitute()
    {
        $this->loadModel('Substitutes');
        $this->loadModel('ClasstimeTabs');
        $empid = $this->request->data['empid'];
        $tid = $this->request->data['tid'];
        $week = $this->request->data['week'];
        //echo $empid; die;
        //echo $tid.','.$week.','.$empid; die;
        $userTable = TableRegistry::get('ClasstimeTabs');
        $exists = $userTable->exists(['employee_id' => $empid, 'tt_id' => $tid, 'weekday' => $week]);

        $date = date('Y-m-d');
        $userTable1 = TableRegistry::get('Substitutes');
        $exists1 = $userTable1->exists(['new_empid' => $empid, 'timetable_id' => $tid, 'weekday' => $week, 'today_date' => $date]);
        //pr($exists1); die;
        if ($exists) {
            echo "Teacher Already Assigned period in another section";
            die;
        } else if ($exists1) {
            echo "Teacher Already Assigned in another class Today";
            die;
        } else {
            echo 0;
            die;
        }
    }


    public function substitute_excel()
    {
        $this->autoRender = false;
        $this->loadModel('Substitutes');
        $this->loadModel('Leaves');
        $this->loadModel('Employees');
        $this->loadModel('Classes');
        $this->loadModel('Timetables');


        $date = date('Y-m-d');

        $rolepresent = $this->request->session()->read('Auth.User.id');
        $roleid = $this->request->session()->read('Auth.User.role_id');

        if ($roleid == 1) {
            $t_enquiry = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date])->toarray();

            //----------------------Excel For Rashmi--------------------//

        } else if ($rolepresent == '4') {

            $Lea = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date])->select(['emp_id'])->order(['Leaves.id' => 'DESC'])->toarray();
            $e1 = array();
            foreach ($Lea as $key => $value) {
                $e1[] = $value['emp_id'];
            }
            //pr($e1); die;
            $nu = 'Primary';
            $emp1 = $this->Employees->find('all')->where(['FIND_IN_SET(\'' . $nu . '\',Employees.slab_type)', 'Employees.id IN' => $e1])->select(['id'])->order(['Employees.id' => 'DESC'])->toarray();

            $e2 = array();
            foreach ($emp1 as $key => $val) {
                $e2[] = $val['id'];
            }
            if (!empty($e2)) {
                $t_enquiry = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date, 'Leaves.emp_id IN' => $e2])->toarray();
            } else {
                $t_enquiry = array();
            }
            //----------------------Excel For Deepika--------------------//
        } else if ($rolepresent == '5') {
            $Lea = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date])->select(['emp_id'])->order(['Leaves.id' => 'DESC'])->toarray();
            $e1 = array();
            foreach ($Lea as $key => $value) {
                $e1[] = $value['emp_id'];
            }
            //pr($e1); die;
            $vu = 'Upper_Primary';
            $emp1 = $this->Employees->find('all')->where(['FIND_IN_SET(\'' . $vu . '\',Employees.slab_type)', 'Employees.id IN' => $e1])->select(['id'])->order(['Employees.id' => 'DESC'])->toarray();
            $e2 = array();
            foreach ($emp1 as $key => $val) {
                $e2[] = $val['id'];
            }
            if (!empty($e2)) {
             $t_enquiry = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date, 'Leaves.emp_id IN' => $e2])->toarray();
            } else {
                $t_enquiry = array();
            }
            //----------------------Excel For Manisha--------------------//
        } else if ($rolepresent == '6') {
            $Lea = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date])->select(['emp_id'])->order(['Leaves.id' => 'DESC'])->toarray();
            $e1 = array();
            foreach ($Lea as $key => $value) {
                $e1[] = $value['emp_id'];
            }
            //pr($e1); die;
            $mu = 'Secondry';
            $emp1 = $this->Employees->find('all')->where(['FIND_IN_SET(\'' . $mu . '\',Employees.slab_type)', 'Employees.id IN' => $e1])->select(['id'])->order(['Employees.id' => 'DESC'])->toarray();
            $e2 = array();
            foreach ($emp1 as $key => $val) {
                $e2[] = $val['id'];
            }
            if (!empty($e2)) {
                $t_enquiry = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date, 'Leaves.emp_id IN' => $e2])->toarray();
            } else {
                $t_enquiry = array();
            }
            //----------------------Excel For Sheetal--------------------//
        } else {
            $Lea = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date])->select(['emp_id'])->order(['Leaves.id' => 'DESC'])->toarray();
            $e1 = array();
            foreach ($Lea as $key => $value) {
                $e1[] = $value['emp_id'];
            }
            //pr($e1); die;
            $cu = 'Senior';
            $emp1 = $this->Employees->find('all')->where(['FIND_IN_SET(\'' . $cu . '\',Employees.slab_type)', 'Employees.id IN' => $e1])->select(['id'])->order(['Employees.id' => 'DESC'])->toarray();
            $e2 = array();
            foreach ($emp1 as $key => $val) {
                $e2[] = $val['id'];
            }
            if (!empty($e2)) {

                $t_enquiry = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date, 'Leaves.emp_id IN' => $e2])->toarray();
            } else {
                $t_enquiry = array();
            }
        }
        //pr($t_enquiry); die;
        ini_set('max_execution_time', 1600);
        $headerRow = array("TeacherNname", "0", "1st", "2nd.", "Break", "3rd.", "4th", "5th", "6th", "7th");
        $output = implode("\t", $headerRow) . "\n";
        foreach ($t_enquiry as $people) {  //pr($people); die;
            $date = date('Y-m-d');
            $tid = $people['emp_id'];
            $tname = $this->Employees->find('all')->where(['Employees.id >=' => $tid])->select(['fname', 'middlename', 'lname'])->first();
            $subdetail = $this->Substitutes->find('all')->where(['Substitutes.old_empid' => $tid, 'Substitutes.today_date' => $date])->order(['Substitutes.timetable_id' => 'ASC'])->toarray();
            $timetid = $this->Timetables->find('all')->order(['Timetables.id' => 'ASC'])->select(['id'])->toarray();
            $sub = array();
            foreach ($timetid as $subd) {
                $timid = $subd['id'];
                $subdetail = $this->Substitutes->find('all')->where(['Substitutes.timetable_id' => $timid, 'Substitutes.today_date' => $date, 'Substitutes.old_empid' => $tid])->first();
                //pr($subdetail); die;
                if (!empty($subdetail)) {
                    $nwempid = $subdetail['new_empid'];
                    $clsid = $subdetail['class_id'];
                    $sectionid = $subdetail['sec_id'];
                    $newempname = $this->Employees->find('all')->where(['Employees.id >=' => $nwempid])->select(['fname', 'middlename', 'lname'])->first();
                    $clsname = $this->Classes->find('all')->where(['Classes.id >=' => $clsid])->select(['title'])->first();
                    $clsname = $this->Classes->find('all')->where(['Classes.id >=' => $clsid])->select(['title'])->first();
                    $sub[] = $clsname['title'] . ' (' . $newempname['fname'] . ' ' . $newempname['middlename'] . ' ' . $newempname['lname'] . ' )';
                } else {
                    $sub[] = "-";
                }
            }
            $result = array();
            $str = "";
            $result[] = $tname["fname"] . ' ' . $tname["middlename"] . ' ' . $tname["lname"];
            $result[] = $sub[0];
            $result[] = $sub[1];
            $result[] = $sub[2];
            $result[] = "Break";
            $result[] = $sub[4];
            $result[] = $sub[5];
            $result[] = $sub[6];
            $result[] = $sub[7];

            $output .=  implode("\t", $result) . "\n";
        }
        //echo $output; die;
        $filename = "Substitute.xls";
        header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename=' . $filename);
        echo $output;
        die;

        $this->redirect(array('action' => 'substitute'));
    }




    public function add($id = null, $classid = null, $weekname = null, $emp = null, $sectid = null)
    {
        //echo $sectid; die;
        $this->loadModel('Leaves');
        $this->loadModel('Timetables');
        $this->loadModel('Classections');
        $this->loadModel('Employees');
        $this->loadModel('Subjectclass');
        $this->loadModel('ClasstimeTabs');
        $this->loadModel('Classes');
        $this->loadModel('Substitutes');
        $this->set('classsec_id', $classectionid);
        $this->set('a', $id);
        $this->set('b', $classid);
        $this->set('c', $weekname);

        $timetables = $this->Timetables->find('all')->where(['Timetables.id' => $id])->toArray();


        $namew = $timetables[0]['name'];

        $this->set('name1', $namew);


        $classname = $this->Classes->find('all')->select(['title'])->where(['Classes.id' => $classid])->first();
        $this->set('classtitle', $classname['title']);
        $teacher = $this->Classections->find('all')->select(['teacher_id'])->toArray();
        //pr($teacher); die;
        $tn = array();
        foreach ($teacher as $key => $value) {
            $tid = explode(',', $value['teacher_id']);


            foreach ($tid as $key => $val) { //pr($val);


                $tn[] = $val;
            }
        }
        //pr($tn); die;
        foreach ($tn as $k => $v) { //pr($v); 
            $date = date('Y-m-d');
            //pr($date);
            $userTable = TableRegistry::get('Leaves');
            $exists1 = $userTable->exists(['emp_id' => $v, 'date_to >=' => $date]);
            $userTable12 = TableRegistry::get('ClasstimeTabs');
            $exists2 = $userTable12->exists(['employee_id' => $v, 'tt_id' => $id, 'weekday' => $weekname]);
            $userTable1 = TableRegistry::get('Substitutes');
            $exists3 = $userTable1->exists(['new_empid' => $v, 'timetable_id' => $id, 'weekday' => $weekname, 'today_date' => $date]);
            if ($v == $emp  || $exists1 == 1   || $exists2 == 1  || $exists3 == 1) {
                unset($tn[$k]);
            }
        }
        if ($classid == 1 || $classid == 2 || $classid == 3 || $classid == 4 || $classid == 6 || $classid == 18 || $classid == 19) {
            $nu = 'Primary';
            $employees = $this->Employees->find('list', [
                'keyField' => 'id',
                'valueField' => array('fname', 'middlename', 'lname')
            ])->where(['Employees.id IN' => $tn, 'FIND_IN_SET(\'' . $nu . '\',Employees.slab_type)'])->order(['fname' => 'ASC'])->toArray();
            //pr($employees); die;
            $this->set('employee', $employees);
        } else if ($classid == 7 || $classid == 8 || $classid == 9) {
            $vu = 'Upper_Primary';
            $employees = $this->Employees->find('list', [
                'keyField' => 'id',
                'valueField' => array('fname', 'middlename', 'lname')
            ])->where(['Employees.id IN' => $tn, 'FIND_IN_SET(\'' . $vu . '\',Employees.slab_type)'])->order(['fname' => 'ASC'])->toArray();
            //pr($employees); die;
            $this->set('employee', $employees);
        } else if ($classid == 10 || $classid == 11) {
            $mu = 'Secondry';

            $employees = $this->Employees->find('list', [
                'keyField' => 'id',
                'valueField' => array('fname', 'middlename', 'lname')
            ])->where(['Employees.id IN' => $tn, 'FIND_IN_SET(\'' . $mu . '\',Employees.slab_type)'])->order(['fname' => 'ASC'])->toArray();
            //pr($employees); die;
            $this->set('employee', $employees);
        } else {
            $cu = 'Senior';

            $employees = $this->Employees->find('list', [
                'keyField' => 'id',
                'valueField' => array('fname', 'middlename', 'lname')
            ])->where(['Employees.id IN' => $tn, 'FIND_IN_SET(\'' . $cu . '\',Employees.slab_type)'])->order(['fname' => 'ASC'])->toArray();
            //pr($employees); die;
            $this->set('employee', $employees);
        }

        $com = $this->Subjectclass->find('list', ['keyField' => 'Subjects.id', 'valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' => $classid, 'Subjects.status' => '1'])->contain(['Subjects'])->order(['Subjects.name' => 'ASC'])->toArray();

        $this->set('tt_id', $id);
        $this->set('subject', $com);
        $this->set('weekname', $weekname);
        $timetable = $this->Substitutes->newEntity();
        $this->set('timestable', $sections);
        if ($this->request->is(['post', 'put'])) {
            $tid = $this->request->data['timetable_id'];

            // save all data in database
            $timetable_datas = $this->Timetables->find('all')->where(['Timetables.id' => $tid])->select(['time_from', 'time_to'])->first();
            $this->request->data['timetable_id'] = $tid;
            $this->request->data['old_empid'] = $emp;
            $this->request->data['sec_id'] = $sectid;
            $this->request->data['class_id'] = $classid;
            $this->request->data['weekday'] = $weekname;
            $this->request->data['today_date'] = date('Y-m-d');
            $timetable = $this->Substitutes->patchEntity($timetable, $this->request->data);
            //pr($timetable); die;
            if ($this->Substitutes->save($timetable)) {
                $this->Flash->success(__('Teacher has successfully substituted.'));
                return $this->redirect(['action' => 'timetableshow' . "/" . $emp]);
            }
        }
    }

    public function edit($id = null, $mainempid = null)
    {
        $this->loadModel('Leaves');
        $this->loadModel('Timetables');
        $this->loadModel('Classections');
        $this->loadModel('Employees');
        $this->loadModel('Subjectclass');
        $this->loadModel('ClasstimeTabs');
        $this->loadModel('Classes');
        $this->loadModel('Substitutes');
        if (isset($id) && !empty($id)) {
            //using for edit
            $SubstitutesTabs = $this->Substitutes->get($id);
            $classid = $SubstitutesTabs->class_id;
            $tid = $SubstitutesTabs->timetable_id;
            $weekname = $SubstitutesTabs->weekday;
            $classectionid = $SubstitutesTabs->sec_id;
            $employee_id = $SubstitutesTabs->new_empid;
        }
        $this->set('classsec_id', $classectionid);
        $this->set('a', $tid);
        $this->set('b', $classid);
        $this->set('c', $weekname);
        $this->set('e', $subject_id);
        $this->set('f', $employee_id);
        $timetables = $this->Timetables->find('all')->where(['Timetables.id' => $tid])->toArray();
        $namew = $timetables[0]['name'];
        $this->set('name1', $namew);
        $classname = $this->Classes->find('all')->select(['title'])->where(['Classes.id' => $classid])->first();
        $this->set('classtitle', $classname['title']);
        $teacher = $this->Classections->find('all')->select(['teacher_id'])->toArray();
        $tn = array();
        foreach ($teacher as $key => $value) {
            $tid1 = explode(',', $value['teacher_id']);
            foreach ($tid1 as $key => $val) { //pr($val);

                $tn[] = $val;
            }
        }
        foreach ($tn as $k => $v) { //pr($v); 
            $date = date('Y-m-d');
            $userTable = TableRegistry::get('Leaves');
            $exists1 = $userTable->exists(['emp_id' => $v, 'date_to >=' => $date]);
            $userTable12 = TableRegistry::get('ClasstimeTabs');
            $exists2 = $userTable12->exists(['employee_id' => $v, 'tt_id' => $tid, 'weekday' => $weekname]);

            $userTable1 = TableRegistry::get('Substitutes');
            $exists3 = $userTable1->exists(['new_empid' => $v, 'timetable_id' => $tid, 'weekday' => $weekname, 'today_date' => $date]);
            if (($v == $emp  || $exists1 == 1   || $exists2 == 1  || $exists3 == 1) && $v != $employee_id) {
                unset($tn[$k]);
            }
        }
        if ($classid == 1 || $classid == 2 || $classid == 3 || $classid == 4 || $classid == 6 || $classid == 18 || $classid == 19) {
            $nu = 'Primary';
            $employees = $this->Employees->find('list', [
                'keyField' => 'id',
                'valueField' => array('fname', 'middlename', 'lname')
            ])->where(['Employees.id IN' => $tn, 'FIND_IN_SET(\'' . $nu . '\',Employees.slab_type)'])->order(['fname' => 'ASC'])->toArray();
            //pr($employees); die;
            $this->set('employee', $employees);
        } else if ($classid == 7 || $classid == 8 || $classid == 9) {
            $vu = 'Upper_Primary';
            $employees = $this->Employees->find('list', [
                'keyField' => 'id',
                'valueField' => array('fname', 'middlename', 'lname')
            ])->where(['Employees.id IN' => $tn, 'FIND_IN_SET(\'' . $vu . '\',Employees.slab_type)'])->order(['fname' => 'ASC'])->toArray();
            //pr($employees); die;
            $this->set('employee', $employees);
        } else if ($classid == 10 || $classid == 11) {
            $mu = 'Secondry';
            $employees = $this->Employees->find('list', [
                'keyField' => 'id',
                'valueField' => array('fname', 'middlename', 'lname')
            ])->where(['Employees.id IN' => $tn, 'FIND_IN_SET(\'' . $mu . '\',Employees.slab_type)'])->order(['fname' => 'ASC'])->toArray();
            //pr($employees); die;
            $this->set('employee', $employees);
        } else {
            $cu = 'Senior';
            $employees = $this->Employees->find('list', [
                'keyField' => 'id',
                'valueField' => array('fname', 'middlename', 'lname')
            ])->where(['Employees.id IN' => $tn, 'FIND_IN_SET(\'' . $cu . '\',Employees.slab_type)'])->order(['fname' => 'ASC'])->toArray();
            //pr($employees); die;
            $this->set('employee', $employees);
        }
        $com = $this->Subjectclass->find('list', ['keyField' => 'Subjects.id', 'valueField' => 'Subjects.name'])->where(['Subjectclass.class_id' => $classid, 'Subjects.status' => '1'])->contain(['Subjects'])->order(['Subjects.name' => 'ASC'])->toArray();
        $this->set('tt_id', $id);
        $this->set('subject', $com);
        $this->set('weekname', $weekname);
        $timetable = $this->Substitutes->newEntity();
        $this->set('timestable', $sections);
        if ($this->request->is(['post', 'put'])) {
            $tid = $this->request->data['timetable_id'];
            // save all data in database
            $timetable_datas = $this->Timetables->find('all')->where(['Timetables.id' => $tid])->select(['time_from', 'time_to'])->first();
            $new_emp = $this->request->data['new_empid'];
            $date = date('Y-m-d');
            //pr($this->request->data); die;
            $conn = ConnectionManager::get('default');

            $detail1 = 'UPDATE `substitutes` SET `new_empid` ="' . $new_emp . '" WHERE `substitutes`.`id` = "' . $id . '"';
            //echo $detail1; die;
            $results2 = $conn->execute($detail1);
            //pr($timetable); die;
            if ($results2) {
                $this->Flash->success(__('Teacher has successfully substituted.'));
                return $this->redirect(['action' => 'timetableshow' . "/" . $mainempid]);
            }
        }
    }

    public function substitute()
    {
        $this->loadModel('Employees');
        $this->loadModel('Leavetype');
        $this->loadModel('Leaves');
        $this->viewBuilder()->layout('admin');
        $date = date('Y-m-d');
        //pr($date); die;
        $Leave = $this->Leaves->find('all')->where(['Leaves.date >=' => $date])->contain(['Leavetype', 'Employees'])->order(['Leaves.id' => 'DESC'])->toarray();
        //pr($Leave); die;
        $this->set('Leave', $Leave);
    }


    public function rolesubstitute()
    {
        $this->loadModel('Employees');
        $this->loadModel('Leavetype');
        $this->loadModel('Leaves');
        $this->loadModel('Employeeattendance');
        $this->viewBuilder()->layout('admin');
        $date = date('Y-m-d');
        $rolepresent = $this->request->session()->read('Auth.User.id');
        //pr($rolepresent);die;
        if ($rolepresent == '6824') {
            $Lea = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.absent_periods !=' => ''])->select(['employee_id'])->toarray();
            $e1 = array();
            //pr($Lea);die;
            if (!empty($Lea)) {
                foreach ($Lea as $key => $value) {
                    $e1[] = $value['employee_id'];
                }
                //pr($e1);die;
                $nu = 'Primary';
                $emp1 = $this->Employees->find('all')->where(['Employees.id IN' => $e1])->select(['id'])->order(['Employees.id' => 'DESC'])->toarray();
                //pr($emp1);die;
                $e2 = array();
                foreach ($emp1 as $key => $val) {
                    $e2[] = $val['id'];
                }
                //pr($e2);die;
                if (!empty($e2)) {

                    $Leave = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.employee_id IN' => $e2])->contain(['Employees'])->toarray();
                } else {
                    $Leave = array();
                    $this->set('Leave', $Leave);
                }
                //pr($Leave);die;

                $this->set('Leave', $Leave);
            } else {
                $Leave = array();
                $this->set('Leave', $Leave);
            }
        }
        //pr($date); die;

        //-----------------------Substitute for Rashmi----------------------//

        else if ($rolepresent == '4') {
            $Lea = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.absent_periods !=' => ''])->select(['employee_id'])->toarray();
            //pr($Lea);die;
            // $Lea = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date])->select(['emp_id'])->order(['Leaves.id' => 'DESC'])->toarray();
            $e1 = array();
            if (!empty($Lea)) {
                foreach ($Lea as $key => $value) {
                    $e1[] = $value['employee_id'];
                }
                //pr($e1);die;
                $nu = 'Primary';
                $emp1 = $this->Employees->find('all')->where(['FIND_IN_SET(\'' . $nu . '\',Employees.slab_type)', 'Employees.id IN' => $e1])->select(['id'])->order(['Employees.id' => 'DESC'])->toarray();
                $e2 = array();
                foreach ($emp1 as $key => $val) {
                    $e2[] = $val['id'];
                }
                if (!empty($e2)) {
                    $Leave = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.employee_id IN' => $e2])->contain('Employees')->toarray();
                } else {
                    $Leave = array();
                    $this->set('Leave', $Leave);
                }
                $this->set('Leave', $Leave);
            } else {
                $Leave = array();
                $this->set('Leave', $Leave);
            }
        }

        //-----------------------Substitute for deepika----------------------//

        else if ($rolepresent == '5') {
            $Lea = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.absent_periods !=' => ''])->select(['employee_id'])->toarray();

            // $Lea = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date])->select(['emp_id'])->order(['Leaves.id' => 'DESC'])->toarray();
            if (!empty($Lea)) {
                $e1 = array();
                foreach ($Lea as $key => $value) {
                    $e1[] = $value['employee_id'];
                }
                //pr($e1); die;
                $vu = 'Upper_Primary';
                $emp1 = $this->Employees->find('all')->where(['FIND_IN_SET(\'' . $vu . '\',Employees.slab_type)', 'Employees.id IN' => $e1])->select(['id'])->order(['Employees.id' => 'DESC'])->toarray();

                $e2 = array();
                foreach ($emp1 as $key => $val) {
                    $e2[] = $val['id'];
                }

                if (!empty($e2)) {
                    //$Leave = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date, 'Leaves.emp_id IN' => $e2])->contain(['Leavetype', 'Employees'])->order(['Leaves.id' => 'DESC'])->toarray();

                    $Leave = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.employee_id IN' => $e2])->contain('Employees')->toarray();
                } else {
                    $Leave = array();
                    $this->set('Leave', $Leave);
                }
                //pr($Leave); die;

                $this->set('Leave', $Leave);
            } else {
                $Leave = array();
                $this->set('Leave', $Leave);
            }
        }

        //-----------------------Substitute for manisha----------------------//

        else if ($rolepresent == '6') {
            $Lea = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.absent_periods !=' => ''])->select(['employee_id'])->toarray();

            // $Lea = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date])->select(['emp_id'])->order(['Leaves.id' => 'DESC'])->toarray();
            //pr($Lea); die;
            if (!empty($Lea)) {
                $e1 = array();
                foreach ($Lea as $key => $value) {
                    $e1[] = $value['employee_id'];
                }
                //pr($e1); die;
                $mu = 'Secondry';

                $emp1 = $this->Employees->find('all')->where(['FIND_IN_SET(\'' . $mu . '\',Employees.slab_type)', 'Employees.id IN' => $e1])->select(['id'])->order(['Employees.id' => 'DESC'])->toarray();

                $e2 = array();
                foreach ($emp1 as $key => $val) {
                    $e2[] = $val['id'];
                }
                //pr($e2); die;

                if (!empty($e2)) {
                    // $Leave = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date, 'Leaves.emp_id IN' => $e2])->contain(['Leavetype', 'Employees'])->order(['Leaves.id' => 'DESC'])->toarray();
                    $Leave = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.employee_id IN' => $e2])->contain('Employees')->toarray();
                } else {
                    $Leave = array();
                    $this->set('Leave', $Leave);
                }
                //pr($Leave); die;

                $this->set('Leave', $Leave);
            } else {
                $Leave = array();
                $this->set('Leave', $Leave);
            }
        }

        //-----------------------Substitute for sheetal----------------------//

        else if ($rolepresent == '7') {
            $Lea = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.absent_periods !=' => ''])->select(['employee_id'])->toarray();

            // $Lea = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date])->select(['emp_id'])->order(['Leaves.id' => 'DESC'])->toarray();
            //pr($Lea); die;
            if (!empty($Lea)) {
                $e1 = array();
                foreach ($Lea as $key => $value) {
                    $e1[] = $value['employee_id'];
                }
                //pr($e1); die;
                $tu = 'Upper_Primary';
                $pu = 'Secondry';
                $emps1[] = $this->Employees->find('all')->where(['FIND_IN_SET(\'' . $tu . '\',Employees.slab_type)', 'Employees.id IN' => $e1])->select(['id'])->order(['Employees.id' => 'DESC'])->toarray();
                $emps1[] = $this->Employees->find('all')->where(['FIND_IN_SET(\'' . $pu . '\',Employees.slab_type)', 'Employees.id IN' => $e1])->select(['id'])->order(['Employees.id' => 'DESC'])->toarray();

                $asd = array();
                foreach ($emps1 as $k => $v) {
                    $asd += $v;
                }

                $e2 = array();
                foreach ($asd as $key => $val) {
                    $e2[] = $val['id'];
                }

                if (!empty($e2)) {

                    // $Leave = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date, 'Leaves.emp_id IN' => $e2])->contain(['Leavetype', 'Employees'])->order(['Leaves.id' => 'DESC'])->toarray();
                    //pr($Leave); die;
                    $Leave = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.employee_id IN' => $e2])->contain('Employees')->toarray();

                    $this->set('Leave', $Leave);
                } else {
                    $Leave = array();
                    $this->set('Leave', $Leave);
                }
            } else {
                $Leave = array();
                $this->set('Leave', $Leave);
            }
        } else {

            // $Lea = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date])->select(['emp_id'])->order(['Leaves.id' => 'DESC'])->toarray();
            $Lea = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.absent_periods !=' => ''])->select(['employee_id'])->toarray();

            if (!empty($Lea)) {
                $e1 = array();
                foreach ($Lea as $key => $value) {
                    $e1[] = $value['employee_id'];
                }
                //pr($e1); die;
                $cu = 'Senior';
                $emp1 = $this->Employees->find('all')->where(['FIND_IN_SET(\'' . $cu . '\',Employees.slab_type)', 'Employees.id IN' => $e1])->select(['id'])->order(['Employees.id' => 'DESC'])->toarray();

                $e2 = array();
                foreach ($emp1 as $key => $val) {
                    $e2[] = $val['id'];
                }

                if (!empty($e2)) {
                    // $Leave = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date, 'Leaves.emp_id IN' => $e2])->contain(['Leavetype', 'Employees'])->order(['Leaves.id' => 'DESC'])->toarray();
                    //pr($Leave); die;
                    $Leave = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.employee_id IN' => $e2])->contain('Employees')->toarray();
                } else {
                    $Leave = array();
                    $this->set('Leave', $Leave);
                }
                $this->set('Leave', $Leave);
            } else {
                $Leave = array();
                $this->set('Leave', $Leave);
            }
        }
    }

    public function findclassectionsed($id = null)
    {
        $this->loadModel('Classes');
        $this->loadModel('Sections');
        $this->loadModel('Employees');
        return    $this->Classections->find('all')->contain(['Classes', 'Sections', 'Employees'])->where(['Employees.id' => $id])->first();
    }

    public function timetableshow($id = null)
    {
        //echo $id; die;
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Timetables');
        $this->loadModel('Classections');
        $this->loadModel('Subjects');
        $this->loadModel('Employees');
        $this->loadModel('Employeeattendance');
        $this->set('emp1', $id);
        $date = date('Y-m-d');
        $absnt_report = $this->Employeeattendance->find('all')->where(['Employeeattendance.employee_id' => $id, 'Employeeattendance.date' => $date])->first();
        $this->set(compact('absnt_report'));
        $email = $this->Employees->find('all')->where(['Employees.id' => $id])->first()->toArray();
        $findclasssection = $this->findclassectionsed($id);
        $classid = $findclasssection['class_id'];
        $sectionid = $findclasssection['section_id'];
        $fname = $email['fname'];
        $this->set('fname', $fname);
        $middlename = $email['middlename'];
        $this->set('middlename', $middlename);
        $lname = $email['lname'];
        $this->set('lname', $lname);
        $sectionclassselectlist = $this->Classections->find('all')->contain(['Classes', 'Sections'])->where(['FIND_IN_SET(\'' . $id . '\',Classections.teacher_id)'])->order(['Sections.title' => 'ASC'])->first();
        $this->set('classsss', $sectionclassselectlist['Classes']['title']);
        $this->set('sectionsss', $sectionclassselectlist['Sections']['title']);
        $this->set('section_id', $sectionclassselectlist['Sections']['id']);
        $this->set('classid', $sectionclassselectlist['Classes']['id']);
        $subjectslist = $this->Subjects->find('list', [
            'keyField' => 'alias',
            'valueField' => 'name',
        ])->where(['status' => '1'])->order(['name' => 'ASC'])->toArray();
        $this->set('subjectslist', $subjectslist);
        $sectionselectlist = $this->Classections->find('list', [
            'keyField' => 'Sections.id',
            'valueField' => 'Sections.title',
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
        $this->set('classectionid', $id);
        $timetable_data = $this->Timetables->find('all')->where(['Timetables.status' => '1'])->order(['Timetables.id' => 'ASC'])->toarray();
        $this->set('timetabledata', $timetable_data);
    }




    //----------------------------------------------------------------------------------------
    public function take_attendance_search()
    {
        $req_data = $this->request->data;
        $designation = $req_data['designation'];
        $e_name = $req_data['e_name'];
        $e_id = $req_data['e_id'];
        //pr($department); die;
        $cond = [];
        if (!empty($designation)) {
            $cond['Designations.id'] = $designation;
        }
        if (!empty($e_name)) {
            $cond['Employees.fname'] = $e_name;
        }
        if (!empty($e_id)) {
            $cond['Employees.id'] = $e_id;
        }
        $cond['Employees.status'] = 'Y';
        $current_date = date('Y-m-d', strtotime($req_data['current_date']));
        $this->set('date', $current_date);
        $employees = $this->Employees->find()->select(['id', 'fname', 'middlename', 'lname', 'Departments.name', 'Departments.id', 'Designations.id', 'Designations.name'])
            ->contain(['Departments', 'Designations'])->where($cond)->order(['Employees.id' => 'ASC'])->toArray();
        if (!empty($employees)) {
            $shifts = $this->Shift->find('all')->where(['Shift.id' => 1])->first()->toArray();
            $this->set(compact('employees', 'shifts', 'current_date'));
        } else {
            echo '<div class="alert alert-warning alert-dismissable auto-hide">
					<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
					<i class="fa fa-exclamation-triangle"></i> 
					No employee found with above criteria.
				</div>';

            exit;
        }
    }
    //----------------------------------------------------------------------------------------
    public function take_attendance()
    {
        if ($this->request->is(['post', 'put'])) {
            //pr($this->request->data); die;

            $req_param = $this->request->data;
            $date = $req_param['date'];
            $emp_table = TableRegistry::get('EmployeeAttendance');
            $oQuery = $emp_table->query();
            $count = sizeof($req_param['emp_id']);
            for ($i = 0; $i < $count; $i++) {
                $time_in = date('H:i:s', strtotime($req_param['time_in'][$i]));
                $time_out = date('H:i:s', strtotime($req_param['time_out'][$i]));
                $conn = ConnectionManager::get('default');
                $conn->execute("DELETE FROM  `employee_attendance` where employee_id='" . $req_param['emp_id'][$i] . "' AND date='" . $date . "'");
                $oQuery->insert(['employee_id', 'shift_id', 'time_in', 'status', 'time_out', 'date'])->values([
                    'employee_id' => $req_param['emp_id'][$i],
                    'shift_id' => $req_param['shift_id'], 'time_in' => $time_in, 'time_out' => $time_out, 'date' => $date, 'status' => 'P'
                ]);
            }
            $result = $oQuery->execute();
            $remark = $this->request->data['remark'];
            if ($remark) {
                $leav = TableRegistry::get('Leaves');
                $oquerys =     $emp_table->query();
                $leb1 = $leav->query();
                foreach ($remark as $key => $iteam) {
                    $conn = ConnectionManager::get('default');
                    $conn->execute("DELETE FROM  `employee_attendance` where employee_id='" . $key . "' AND date='" . $date . "'");
                    $oquerys->insert(['employee_id', 'shift_id', 'date', 'remark'])->values([
                        'employee_id' => $key,
                        'shift_id' => $req_param['shift_id'], 'date' => $date, 'status' => 'A', 'remark' => $iteam
                    ]);
                    $leb1->insert(['emp_id', 'leave_type_id', 'date_from', 'date_to', 't_days', 'narration'])->values(['emp_id' => $key, 'leave_type_id' => 3, 'date_from' => $date, 'date_to' => $date, 't_days' => 1, 'narration' => $iteam]);
                }
                $oquerys->execute();
                $leb1->execute();
            }

            if ($result) {
                $this->Flash->success(__('Employees attendance taken successfully.'));
                return $this->redirect(['action' => 'index' . "/" . $req_param['designation_id'] . "/" . $date]);
            }
        }
    }

    //----------------------------------------------------------------------------------------
    public function manage()
    {
        $this->viewBuilder()->layout('admin');
        $departments = $this->Departments->find('list')->where(['Departments.status' => 'Y'])->order(['Departments.name' => 'Asc'])->toarray();
        $designations = $this->Designations->find('list')->where(['Designations.status' => 'Y'])->order(['Designations.name' => 'Asc'])->toarray();
        $this->set(compact('departments', 'designations'));
    }

    //----------------------------------------------------------------------------------------
    public function manage_attendance_search()
    {
        $req_data = $this->request->data;
        $current_date = date('Y-m-d', strtotime($req_data['current_date']));

        $department = $req_data['department'];
        $designation = $req_data['designation'];
        $e_name = $req_data['e_name'];
        $e_id = $req_data['e_id'];
        $cond = [];
        if (!empty($department)) {
            $cond['Departments.id'] = $department;
        }
        if (!empty($designation)) {
            $cond['Designations.id'] = $designation;
        }
        if (!empty($e_name)) {
            $cond['Employees.fname'] = $e_name;
        }
        if (!empty($e_id)) {
            $cond['Employees.id'] = $e_id;
        }
        $cond['EmployeeAttendance.date'] = $current_date;
        $employees = $this->EmployeeAttendance->find()->select([
            'id', 'time_in', 'time_out',
            'Employees.id', 'Employees.fname', 'Employees.middlename', 'Employees.lname',
            'Departments.name', 'Designations.name'
        ])->contain(['Employees' => ['Departments', 'Designations']])->where($cond)->order(['EmployeeAttendance.id' => 'ASC'])->toArray();
        $shifts = $this->Shift->find('all')->where(['Shift.id' => 1])->first()->toArray();
        $this->set(compact('employees', 'shifts'));
    }

    //-------------------------------------------------------------------------------------------
    public function update_time($id = null)
    {
        $employees = $this->EmployeeAttendance->find()->select(['id', 'Employees.fname', 'Employees.middlename', 'Employees.lname'])->contain(['Employees'])->where(['EmployeeAttendance.id' => $id])->first()->toArray();
        $shifts = $this->Shift->find('all')->where(['Shift.id' => 1])->first()->toArray();

        if (!empty($id)) {
            $emp_attendance = $this->EmployeeAttendance->get($id);
            $emp_attendance['in_time'] = date('h:i a', strtotime($emp_attendance['time_in']));
            $emp_attendance['out_time'] = date('h:i a', strtotime($emp_attendance['time_out']));
        }

        $this->set(compact('employees', 'shifts', 'emp_attendance'));

        if ($this->request->is(['post', 'put'])) {
            $req_data = $this->request->data;

            $req_data['time_in'] = date('H:i', strtotime($req_data['in_time']));
            $req_data['time_out'] = date('H:i', strtotime($req_data['out_time']));
            unset($req_data['in_time']);
            unset($req_data['out_time']);

            $emp_attendance = $this->EmployeeAttendance->patchEntity($emp_attendance, $req_data);

            if ($this->EmployeeAttendance->save($emp_attendance)) {
                echo "form_success";
                exit;
            } else {
                //check validation error
                if ($emp_attendance->errors()) {
                    $error_msg = [];

                    foreach ($emp_attendance->errors() as $errors) {
                        if (is_array($errors)) {
                            foreach ($errors as $error) {
                                $error_msg[] = $error;
                            }
                        } else {
                            $error_msg[]    =   $errors;
                        }
                    }
                    if (!empty($error_msg)) {
                        $this->Flash->error(__("Please fix the following error(s): " . implode("\n \r", $error_msg)));
                    }
                }
            }
        }
    }

    public function substitute_pdf($date = null)
    {

        $this->loadModel('Substitutes');
        $this->loadModel('Leaves');
        $this->loadModel('Employees');
        $this->loadModel('Classes');
        $this->loadModel('Timetables');
        $this->loadModel('Employeeattendance');
        $this->loadModel('Sections');

        $rolepresent = $this->request->session()->read('Auth.User.id');

        $roleid = $this->request->session()->read('Auth.User.role_id');
        //pr($roleid);die;
        if ($roleid == 1 || ($roleid == 6 && $rolepresent != 4)) {
            $t_enquiry = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.absent_periods !=' => ''])->select(['employee_id', 'present_periods', 'absent_periods'])->toarray();

            //----------------------Excel For Rashmi--------------------//

        } else if ($rolepresent == '4') {
            //pr($rolepresent);die;

            //$Lea = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date])->select(['emp_id'])->order(['Leaves.id' => 'DESC'])->toarray();
            $Lea = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.absent_periods !=' => ''])->select(['employee_id'])->toarray();
            //pr($Lea);die;
            $e1 = array();
            foreach ($Lea as $key => $value) {
                $e1[] = $value['employee_id'];
            }
            //pr($e1);die;
            $nu = 'Primary';
            $emp1 = $this->Employees->find('all')->where(['FIND_IN_SET(\'' . $nu . '\',Employees.slab_type)', 'Employees.id IN' => $e1])->select(['id'])->order(['Employees.id' => 'DESC'])->toarray();

            $e2 = array();
            foreach ($emp1 as $key => $val) {
                $e2[] = $val['id'];
            }

            if (!empty($e2)) {

                $t_enquiry = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.employee_id IN' => $e2])->toarray();
            } else {
                $t_enquiry = array();
            }
            //pr($t_enquiry); die;

            //----------------------Excel For Deepika--------------------//
        } else if ($rolepresent == '5') {

            //$Lea = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date])->select(['emp_id'])->order(['Leaves.id' => 'DESC'])->toarray();
            $Lea = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.absent_periods !=' => ''])->select(['employee_id'])->toarray();

            $e1 = array();
            foreach ($Lea as $key => $value) {
                $e1[] = $value['employee_id'];
            }
            //pr($e1); die;
            $vu = 'Upper_Primary';
            $emp1 = $this->Employees->find('all')->where(['FIND_IN_SET(\'' . $vu . '\',Employees.slab_type)', 'Employees.id IN' => $e1])->select(['id'])->order(['Employees.id' => 'DESC'])->toarray();

            $e2 = array();
            foreach ($emp1 as $key => $val) {
                $e2[] = $val['id'];
            }

            if (!empty($e2)) {

                // $t_enquiry = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date, 'Leaves.emp_id IN' => $e2])->toarray();
                $t_enquiry = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.employee_id IN' => $e2])->toarray();
            } else {
                $t_enquiry = array();
            }

            //----------------------Excel For Manisha--------------------//
        } else if ($rolepresent == '6') {

            // $Lea = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date])->select(['emp_id'])->order(['Leaves.id' => 'DESC'])->toarray();
            $Lea = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.absent_periods !=' => ''])->select(['employee_id'])->toarray();

            $e1 = array();
            foreach ($Lea as $key => $value) {
                $e1[] = $value['employee_id'];
            }
            //pr($e1); die;
            $mu = 'Secondry';
            $emp1 = $this->Employees->find('all')->where(['FIND_IN_SET(\'' . $mu . '\',Employees.slab_type)', 'Employees.id IN' => $e1])->select(['id'])->order(['Employees.id' => 'DESC'])->toarray();

            $e2 = array();
            foreach ($emp1 as $key => $val) {
                $e2[] = $val['id'];
            }

            if (!empty($e2)) {

                // $t_enquiry = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date, 'Leaves.emp_id IN' => $e2])->toarray();
                $t_enquiry = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.employee_id IN' => $e2])->toarray();
            } else {
                $t_enquiry = array();
            }

            //----------------------Excel For Sheetal--------------------//

        } else {

            // $Lea = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date])->select(['emp_id'])->order(['Leaves.id' => 'DESC'])->toarray();

            $Lea = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.absent_periods !=' => ''])->select(['employee_id'])->toarray();
            //pr($Lea);die;
            $e1 = array();
            foreach ($Lea as $key => $value) {
                $e1[] = $value['employee_id'];
            }
            //pr($e1); die;
            $cu = 'Senior';
            $emp1 = $this->Employees->find('all')->where(['FIND_IN_SET(\'' . $cu . '\',Employees.slab_type)', 'Employees.id IN' => $e1])->select(['id'])->order(['Employees.id' => 'DESC'])->toarray();

            $e2 = array();
            foreach ($emp1 as $key => $val) {
                $e2[] = $val['id'];
            }

            if (!empty($e2)) {

                // $t_enquiry = $this->Leaves->find('all')->where(['Leaves.date_to >=' => $date, 'Leaves.emp_id IN' => $e2])->toarray();
                $t_enquiry = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.employee_id IN' => $e2])->toarray();
            } else {
                $t_enquiry = array();
            }
        }
        //pr($t_enquiry);die;
        $this->set(compact('t_enquiry'));
        $this->set(compact('date'));
        $day = date('l', strtotime($date));
        //pr($day);die;
        $absnt_emp = array();
        foreach ($t_enquiry as $values) {
            $absnt_emp[] = $values['employee_id'];
        }
        //pr($absnt_emp);
        //pr($date); die;;
        $this->loadModel('Substitutes');
        $sub_det = $this->Substitutes->find('all')->where(['old_empid IN' => $absnt_emp, 'today_date' => $date])->order(['class_id' => 'ASC', 'sec_id' => 'DESC'])->toarray();
        //pr($sub_det);die;
        $this->set(compact('sub_det'));
    }
    public function substitution_report()
    {
        $this->viewBuilder()->Layout('admin');
    }
    public function substitution_report_search()
    {
        $this->loadModel('Substitutes');
        $this->loadModel('Employeeattendance');
        //$this->viewBuilder()->Layout('admin');
        if ($this->request->is('post')) {
            $date = $this->request->data['date'];
            //pr($date);die;
            $this->set(compact('date'));
            $emp_det = $this->Employeeattendance->find('all')->where(['Employeeattendance.absent_periods != ' => '', 'Employeeattendance.date' => $date])->toarray();
            //pr($emp_det);die;
            $this->set(compact('emp_det'));
            $periods = $this->Timetables->find('all')->toarray();
            $this->set(compact('periods'));
            //pr($periods);
            //die;
            foreach ($emp_det as $value) {
                $sub_det[$value['employee_id']] = $this->Substitutes->find('all')->where(['old_empid' => $value['employee_id'], 'today_date' => $date])->toarray();
            }
            $this->set(compact('sub_det'));
            $this->request->session()->delete('sub_chk_date');
            $this->request->session()->write('sub_chk_date', $date);
            $this->request->session()->delete('sub_chk_date1');
            $this->request->session()->write('sub_chk_date1', $date);
        }
    }
    public function substitute_report_excel()
    {
        $this->autoRender = false;
        $this->loadModel('Substitutes');
        $this->loadModel('Leaves');
        $this->loadModel('Employees');
        $this->loadModel('Classes');
        $this->loadModel('Timetables');
        $this->loadModel('Employeeattendance');
        $this->loadModel('Sections');

        $date = $this->request->session()->read('sub_chk_date');
        //pr($date);die;
        $rolepresent = $this->request->session()->read('Auth.User.id');

        $roleid = $this->request->session()->read('Auth.User.role_id');
        //pr($roleid);die;

        $t_enquiry = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.absent_periods !=' => ''])->select(['employee_id', 'present_periods', 'absent_periods'])->toarray();

        //pr($t_enquiry);die;

        ini_set('max_execution_time', 1600);
        $headerRow = array("TEACHER'S NAME", "0", "1st", "2nd.", "Break", "3rd.", "4th", "5th", "6th", "7th");
        $output = implode("\t", $headerRow) . "\n";

        foreach ($t_enquiry as $people) { //pr($people);die;
            if (empty($people['present_periods'])) {
                $time = "ALL";
            } else {
                $time = str_replace(",", "/", $people['absent_periods']);
            }

            $tid = $people['employee_id'];
            $tname = $this->Employees->find('all')->where(['Employees.id >=' => $tid])->select(['fname', 'middlename', 'lname'])->first();
            $subdetail = $this->Substitutes->find('all')->where(['Substitutes.old_empid' => $tid, 'Substitutes.today_date' => $date])->order(['Substitutes.timetable_id' => 'ASC'])->toarray();
            $timetid = $this->Timetables->find('all')->order(['Timetables.id' => 'ASC'])->select(['id'])->toarray();
            $sub = array();

            foreach ($timetid as $subd) {

                $timid = $subd['id'];
                $subdetail = $this->Substitutes->find('all')->where(['Substitutes.timetable_id' => $timid, 'Substitutes.today_date' => $date, 'Substitutes.old_empid' => $tid])->first();
                if (!empty($subdetail)) {
                    $nwempid = $subdetail['new_empid'];
                    $clsid = $subdetail['class_id'];
                    $sectionid = $subdetail['sec_id'];
                    $newempname = $this->Employees->find('all')->where(['Employees.id >=' => $nwempid])->select(['fname', 'middlename', 'lname'])->first();
                    $clsname = $this->Classes->find('all')->where(['Classes.id >=' => $clsid])->select(['title'])->first();
                    $secname = $this->Sections->find('all')->where(['Sections.id ' => $sectionid])->select(['title'])->first();
                    $sub[] = $clsname['title'] . "\x20" . $secname['title'] . ' (' . $newempname['fname'] . ' ' . $newempname['middlename'] . ' ' . $newempname['lname'] . ' )';
                } else {
                    $sub[] = "-";
                }
            }
            $result = array();
            $str = "";
            $result[] = strtoupper($tname["fname"]) . ' ' . strtoupper($tname["middlename"]) . ' ' . strtoupper($tname["lname"]) . '(' . $time . ')';
            $result[] = $sub[0];
            $result[] = $sub[1];
            $result[] = $sub[2];
            $result[] = "Break";
            $result[] = $sub[4];
            $result[] = $sub[5];
            $result[] = $sub[6];
            $result[] = $sub[7];
            $output .= implode("\t", $result) . "\n";
        }

        //echo $output; die;
        $filename = "Substitute.xls";
        header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename=' . $filename);
        echo $output;
        die;

        $this->redirect(array('action' => 'substitute'));
    }
    public function report()
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Employees');

        $this->loadModel('Employeeattendance');
        $date = date('Y-m-d');
        //pr($classes_data2);die;
        $classes_data2 = $this->Employeeattendance->find('all')->where(['Employeeattendance.date' => $date, 'Employeeattendance.absent_periods !=' => ''])->order(['Employeeattendance.absent_periods' => 'DESC'])->toarray();
        //pr($classes_data2);die;
        foreach ($classes_data2 as $key => $iteam) {

            $eid[] = $iteam['employee_id'];
        }
        if (!empty($eid)) {
            $classes_data3 = $this->Employees->find('all')->where(['Employees.status' => 'Y', 'Employees.id IN' => $eid])->order(['Employees.fname' => 'ASC'])->toarray();
            $classes_data = $this->Employees->find('all')->where(['Employees.status' => 'Y', 'Employees.id NOT IN' => $eid])->order(['Employees.fname' => 'ASC'])->toarray();
            $students = array_merge($classes_data3, $classes_data);
        } else {
            $students = $this->Employees->find('all')->where(['Employees.status' => 'Y'])->order(['Employees.fname' => 'ASC'])->toarray();
        }

        //$this->paginate($service_data);
        $this->set('students', $students);
        $this->set('employees', $students);
        $this->request->session()->delete('emp_atn');
        $this->request->session()->write('emp_atn', $students);
    }
    public function report_search()
    {
        $this->loadModel('Employeeattendance');
        if ($this->request->is('post')) {
            $status = $this->request->data['status'];
            $date = $this->request->data['date'];
            if ($status == 'P') {
                $employees = $this->Employeeattendance->find('all')->contain(['Employees'])->where(['Employeeattendance.date' => $date, 'Employeeattendance.present_periods !=' => ''])->toarray();
            } elseif ($status == 'A') {
                $employees = $this->Employeeattendance->find('all')->contain(['Employees'])->where(['Employeeattendance.date' => $date, 'Employeeattendance.absent_periods !=' => ''])->toarray();
            } else {
                $employees1 = $this->Employeeattendance->find('all')->contain(['Employees'])->where(['Employeeattendance.date' => $date, 'Employeeattendance.absent_periods !=' => ''])->toarray();
                $employees2 = $this->Employeeattendance->find('all')->contain(['Employees'])->where(['Employeeattendance.date' => $date, 'Employeeattendance.present_periods !=' => ''])->toarray();
                $employees = array_merge($employees1, $employees2);
            }
            $this->set(compact('employees'));
            $this->request->session()->delete('src_emp_atn');
            $this->request->session()->write('src_emp_atn', $employees);
            $date1 = date('d-m-Y', strtotime($date));
            $this->set(compact('date1'));
            $this->set(compact('date'));
        }
    }
    public function atn_report_excel($date)
    {
        $this->loadModel('Employees');
        $src_search = $this->request->session()->read('src_emp_atn');
        $this->request->session()->delete('src_emp_atn');
        $employees = array();
        if (isset($src_search) && !empty($src_search)) {
            foreach ($src_search as $value) {
                $employees[] = $this->Employees->find('all')->where(['Employees.status' => 'Y', 'Employees.id' => $value['employee_id']])->first();
            }
        } else {
            $employees = $this->request->session()->read('emp_atn');
        }
        $this->set(compact('employees'));
        $this->set(compact('date'));
        //pr($employees);die;
    }

    public function attendance_csv()
    {
        $this->viewBuilder()->Layout('admin');
        $this->loadModel('Holidayallowance');
        $this->loadModel('Events');
        $this->loadModel('Salary');
        $this->loadModel('Leaves');
        if ($this->request->is(['post'])) {
            $fl = $_FILES;
            $date = date("m-Y", strtotime("-1 months"));
            $exp_date = explode('-', $date);
            $mon = $exp_date[0];
            $year = $exp_date[1];
            $d = cal_days_in_month(CAL_GREGORIAN, $mon, $year);
            $col_size = $d + 3;
            $data = array();
            $inputfilename = $fl['file']['tmp_name'];
            try {
                $objPHPExcel = \PHPExcel_IOFactory::load($inputfilename);
                //  Get worksheet dimensions
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestDataRow();
                $highestColumn = $sheet->getHighestDataColumn();
                $col = \PHPExcel_Cell::columnIndexFromString($highestColumn);
                if ($col != $col_size) {
                    $this->Flash->error(__('Days Not matching with month'));
                    return $this->redirect(['action' => 'attendance_csv']);
                    die;
                }
                for ($row = 1; $row <= $highestRow; $row++) {
                    //  Read a row of data into an array
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
                    //  Insert row data array into your database of choice here
                    array_push($data, $rowData[0]);
                }

                foreach ($data as $key => $value) {
                    if ($key == 0) {
                        continue;
                    } else {

                        $emp_id = $value[1];
                        $emp_name = ucwords(strtolower($value[2]));
                        $day = 1;

                        $sal_exist = $this->Salary->exists(['Eid' => $emp_id, 'month' => $mon, 'year' => $year, 'status' => 'Y']);
                        if ($sal_exist == 1) {
                            continue;
                        }
                        for ($i = 3; $i < $col; $i++) {
                            //pr($value[$i]);die;
                            $p_date = $day . '-' . $date;
                            $p_date = date('Y-m-d', strtotime($p_date));
                            $event_exist = $this->Events->exists(['DATE(Events.starttime) <=' => $p_date, 'DATE(Events.endtime) >=' => $p_date, 'Events.eventt' => '8']);
                            $dayOfWeek = date("l", strtotime($p_date));
                            if ($event_exist == 1 || $dayOfWeek == "Sunday") {
                                $conn1 = ConnectionManager::get('default');
                                $conn1->execute("DELETE FROM `holidayallowance` WHERE `employee_id`='  $emp_id ' AND `date`='$p_date'");
                                if ($value[$i] != 'H' && $value[$i] != "") {
                                    if ($value[$i] == 'P') {
                                        $hol_data['type'] = "full";
                                    } else if ($value[$i] == 'PH') {
                                        $hol_data['type'] = "half";
                                    } else if ($value[$i] == '-') {
                                        $day++;
                                        continue;
                                    } else {
                                        $this->Flash->error(__('Error in uploading attendancce for' . "\x20" . $emp_name . "\x20" . 'on' . "\x20" . date('d-m-Y', strtotime($p_date))));
                                        return $this->redirect(['action' => 'attendance_csv']);
                                        die;
                                    }
                                    $hol = $this->Holidayallowance->newEntity();
                                    $hol_data['employee_id'] = $emp_id;
                                    $hol_data['date'] = $p_date;
                                    $hol_patch = $this->Holidayallowance->patchEntity($hol, $hol_data);
                                    $this->Holidayallowance->save($hol_patch);
                                } else {
                                    if ($value[$i] == "") {
                                        $this->Flash->error(__('Error in uploading attendancce for' . "\x20" . $emp_name . "\x20" . 'on' . "\x20" . date('d-m-Y', strtotime($p_date))));
                                        return $this->redirect(['action' => 'attendance_csv']);
                                        die;
                                    } else {
                                        $day++;
                                        continue;
                                    }
                                }
                            } else {

                                $conn = ConnectionManager::get('default');
                                $conn->execute("DELETE FROM `employee_attendance` WHERE `employee_id`='  $emp_id  ' AND `date`='$p_date'");
                                $conn2 = ConnectionManager::get('default');
                                $conn2->execute("DELETE FROM `leaves` WHERE `emp_id`='  $emp_id  ' AND `date`='$p_date'");
                                if ($value[$i] == 'A' || $value[$i] == 'PH' || $value[$i] == 'LUF' || $value[$i] == 'LUH' || $value[$i] == 'LPH' || $value[$i] == 'LPF' || $value[$i] == 'PR' || $value[$i] == 'PL') {
                                 if ($value[$i] == 'PH' || $value[$i] == 'LPH' || $value[$i] == 'LUH' || $value[$i] == 'PR' || $value[$i] == 'PL') {
                                     $attn_status = 'PR';
                                    } else {
                                        $attn_status = 'A';
                                    }
                                if ($value[$i] == 'LUF' || $value[$i] == 'LUH' || $value[$i] == 'LPH' || $value[$i] == 'LPF') {
                                        $lev = $this->Leaves->newEntity();
                                        $lev_data['emp_id'] = $emp_id;
                                        $lev_data['date'] = $p_date;
                                        if ($value[$i] == 'LUF' || $value[$i] == 'LUH') {
                                            $lev_data['leave_type'] = "unpaid";
                                        } else {
                                            $lev_data['leave_type'] = "paid";
                                        }
                                        $lev_patch = $this->Leaves->patchEntity($lev, $lev_data);
                                        $this->Leaves->save($lev_patch);
                                    }
                                    
                                    $attn = $this->EmployeeAttendance->newEntity();
                                    $attn_data['employee_id'] = $emp_id;
                                    $attn_data['date'] = $p_date;
                                    $attn_data['status'] = $attn_status;

                                    $attn_patch = $this->EmployeeAttendance->patchEntity($attn, $attn_data);
                                    $this->EmployeeAttendance->save($attn_patch);
                                } else {
                                    if ($value[$i] == 'P' || $value[$i] == '-') {
                                        //pr($p_date);die;
                                        $day++;
                                        continue;
                                    } else {
                                        $this->Flash->error(__('Error in uploading attendancce for' . "\x20" . $emp_name . "\x20" . 'on' . "\x20" . date('d-m-Y', strtotime($p_date))));
                                        return $this->redirect(['action' => 'attendance_csv']);
                                        die;
                                    }
                                }
                            }
                            $day++;
                        }
                    }
                }
                $this->Flash->success(__('Attendance Updated Successfully'));
                return $this->redirect(['controller' => 'report', 'action' => 'employee_monthly_attn_report']);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
        }
    }

    public function employee_excel()
    {
        $this->viewBuilder()->Layout('admin');
        $this->loadModel('Employees');
        $emp = $this->Employees->find('all')->where(['Employees.status' => 'Y'])->order(['Employees.fname' => 'ASC'])->toarray();
        $this->set(compact('emp'));
    }
}
