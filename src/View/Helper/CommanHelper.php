<?php

namespace App\View\Helper;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\View\Helper;
use Cake\View\View;
use Firebase\JWT\JWT;

class CommanHelper extends Helper
{

    // initialize() hook is available since 3.2. For prior versions you can
    // override the constructor if required.
    public function initialize(array $config) {}



    public function checktc($id)
    {
        $articles = TableRegistry::get('DropOutStudent');
        return $articles->find('all')->where(['DropOutStudent.s_id' => $id, 'DropOutStudent.date_issue IS NULL'])->count();
    }

    public function tc_character($id)
    {
        $articles = TableRegistry::get('DropOutStudent');
        return $articles->find('all')->where(['DropOutStudent.s_id' => $id, 'DropOutStudent.date_issue_char IS NULL'])->count();
    }


    public function rte_class_get($id)
    {
        $articles = TableRegistry::get('Classes');
        return $articles->find('all')->where(['Classes.id' => $id])->first();
    }

    public function rte_section_get($id)
    {
        $articles = TableRegistry::get('Sections');
        return $articles->find('all')->where(['Sections.id' => $id])->first();
    }

    // public function getallsitesettings ()
    // {
    //     $articles = TableRegistry::get('sitesettings_details');
    //    $return = $articles->find('all')->find('list',['keyField'=>'id','valueField'=>'subtitle1'])->toarray();
    //     pr($return);die;
    // }




    public function getBoardProsFee($board_id)
    {

        $articles = TableRegistry::get('Boards');
        return $articles->find('all')->select(['pro_fees'])->where(['Boards.id' => $board_id])->first();
    }


    public function findrolemenu()
    {

        $articles = TableRegistry::get('PermissionModules');
        $ids = $this->request->session()->read('Auth.User.id');
        // pr($ids);die;

        return $articles->find('all')->where(['PermissionModules.user_id' => $ids])->group(['PermissionModules.module'])->order(['PermissionModules.sort_no' => 'asc'])->toarray();
    }

    public function findrolemenutakeattendence()
    {
        $articles = TableRegistry::get('PermissionModules');
        $ids = $this->request->session()->read('Auth.User.id');
        return $articles->find('all')->where(['PermissionModules.user_id' => $ids, 'PermissionModules.action' => 'classattendance'])->group(['PermissionModules.module'])->order(['PermissionModules.id' => 'ASC'])->first();
    }

    public function findrolemenucontent($module = null)
    {
        $articles = TableRegistry::get('PermissionModules');
        $ids = $this->request->session()->read('Auth.User.id');
        return $articles->find('all')->where(['PermissionModules.user_id' => $ids, 'PermissionModules.module' => $module])->order(['PermissionModules.id' => 'asc'])->toarray();
    }
    public function findbookperidetail($cond)
    {

        $articles = TableRegistry::get('Book');
        $data = $articles->find('all')->where(['Book.periodic_category_id' => $cond])->order(['Book.id' => 'DESC'])->toarray();
        return $data;
    }

    // public function findstatus($id = null, $date = null)
    // {
    //     $articles = TableRegistry::get('EmployeeAttendance');
    //     return $articles->find()->select(['EmployeeAttendance.employee_id'])->where(['EmployeeAttendance.employee_id' => $id, 'EmployeeAttendance.status' => 'P', 'EmployeeAttendance.date' => $date])->first();
    // }


    public function finddiscountqtr($discou = null)
    {
        $articles = TableRegistry::get('DiscountCategory');
        $calucation = $articles->find()->select(['fh_id'])->where(['name' => $discou])->first();

        $whid = unserialize($calucation['fh_id']);
        $ddf = 0;
        foreach ($whid as $h => $dd) {

            if ($h == "2" && $dd != '0') {
                $ddf = $dd . "%";
            }
        }
        return $ddf;
    }

    public function finddiscountqtr2($discou = null)
    {
        $articles = TableRegistry::get('DiscountCategory');
        $calucations = $articles->find()->select(['discount'])->where(['name' => $discou])->first();

        $swhid = unserialize($calucations['discount']);
        $ddf2 = 0;
        foreach ($swhid as $hs => $dds) {

            if ($hs == "2" && $dds != '0') {
                $ddf2 = $dds;
            }
        }
        return $ddf2;
    }


    public function find_teacher($id)
    {
        $articles = TableRegistry::get('Employees');
        if ($id == 1 || $id == 2 || $id == 3 || $id == 4 || $id == 6 || $id == 18 || $id == 19) {
            $nu = 'Primary';

            // return $articles->find('list', [
            //     'keyField' => 'id',
            //     'valueField' => array('fname', 'middlename', 'lname'),
            // ])->where(['FIND_IN_SET(\'' . $nu . '\',Employees.slab_type)'])->order(['Employees.fname' => 'ASC'])->toarray();

            return $articles->find('list', [
                'keyField' => 'id',
                'valueField' => array('fname', 'middlename', 'lname'),
            ])->order(['Employees.fname' => 'ASC'])->toarray();
        } else if ($id == 7 || $id == 8 || $id == 9) {

            $vu = 'Upper_Primary';

            // return $articles->find('list', [
            //     'keyField' => 'id',
            //     'valueField' => array('fname', 'middlename', 'lname'),
            // ])->where(['FIND_IN_SET(\'' . $vu . '\',Employees.slab_type)'])->order(['Employees.fname' => 'ASC'])->toarray();

            return $articles->find('list', [
                'keyField' => 'id',
                'valueField' => array('fname', 'middlename', 'lname'),
            ])->order(['Employees.fname' => 'ASC'])->toarray();
        } else if ($id == 10 || $id == 11) {

            $mu = 'Secondry';

            // return $articles->find('list', [
            //     'keyField' => 'id',
            //     'valueField' => array('fname', 'middlename', 'lname'),
            // ])->where(['FIND_IN_SET(\'' . $mu . '\',Employees.slab_type)'])->order(['Employees.fname' => 'ASC'])->toarray();

            return $articles->find('list', [
                'keyField' => 'id',
                'valueField' => array('fname', 'middlename', 'lname'),
            ])->order(['Employees.fname' => 'ASC'])->toarray();
        } else {

            $cu = 'Senior';

            // return $articles->find('list', [
            //     'keyField' => 'id',
            //     'valueField' => array('fname', 'middlename', 'lname'),
            // ])->where(['FIND_IN_SET(\'' . $cu . '\',Employees.slab_type)'])->order(['Employees.fname' => 'ASC'])->toarray();

            return $articles->find('list', [
                'keyField' => 'id',
                'valueField' => array('fname', 'middlename', 'lname'),
            ])->order(['Employees.fname' => 'ASC'])->toarray();
        }
    }

    public function presentclasstodayreport($classs = null, $sectionid = null, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d');
        } else {
            $date = date('Y-m-d', strtotime($date));
        }

        $connss = ConnectionManager::get('default');

        $studentrfidsd = $connss->execute("SELECT * FROM `attendreports` LEFT JOIN students ON attendreports.rfid = students.rf_id LEFT JOIN classes ON students.class_id = classes.id  WHERE students.class_id='" . $classs . "' AND students.section_id='" . $sectionid . "' AND students.rf_id !='0' AND students.status='Y' AND DATE(attendreports.resultdate)='" . $date . "' GROUP BY attendreports.rfid  ORDER BY section_id ASC");

        return $studentrfidsd->fetchAll('assoc');
    }

    public function presentclasstodayreportsdf($classs = null, $sectionid = null)
    {

        $connss = ConnectionManager::get('default');

        $studentrfidsd = $connss->execute("SELECT COUNT(*) FROM `attendreports` LEFT JOIN students ON attendreports.rfid = students.rf_id LEFT JOIN classes ON students.class_id = classes.id  WHERE students.class_id='" . $classs . "' AND students.section_id='" . $sectionid . "' AND students.rf_id !='0' AND students.status='Y' AND DATE(attendreports.resultdate)='" . date('Y-m-d') . "' GROUP BY attendreports.rfid  ORDER BY section_id ASC");

        return $studentrfidsd->fetchAll('assoc');
    }

    public function getpypattendence($stud_id = null, $stdate = null, $enddate = null)
    {
        // pr($stud_id);
        // pr($stdate);
        // pr($enddate);exit;

        $connss = ConnectionManager::get('default');
        // $getpypattendence = $connss->execute("SELECT count(*) as days FROM studattends where QUARTER(date)=$quater AND stud_id=$stud_id AND status='P'");

        $getpypattendence = $connss->execute("SELECT count(*) as days FROM studattends where date BETWEEN '$stdate' AND '$enddate' and stud_id=$stud_id AND status='P'");

        // $getpypattendence = $connss->execute("SELECT count(*) FROM studattends where stud_id=$stud_id AND status='P'");
        return $getpypattendence->fetchAll('assoc');
    }


    public function getpypattendencesssss($stud_id, $quater)
    {
        // pr($quater); die;
        $connss = ConnectionManager::get('default');
        $getpypattendence = $connss->execute("SELECT count(*) as days FROM studattends where QUARTER(date)=$quater AND stud_id= $stud_id AND status='P'");
        return $getpypattendence->fetchAll('assoc');
    }
    // sanjay pyp attendance code end

    public function getstudentattendence($stud_id = null)
    {

        $connss = ConnectionManager::get('default');
        $getpypattendence = $connss->execute("SELECT count(*) FROM studattends where stud_id=$stud_id AND status='P'");
        return $getpypattendence->fetchAll('assoc');
    }


    public function absentclasstodayreportss23($classs = null, $sectionid = null, $date = null)
    {
        // this changes by rupam 16/02/2022
        if ($date) {
            $da = date('Y-m-d', strtotime($date));
        } else {

            $da = date('Y-m-d');
        }
        // pr($da);die;
        // $da = date('Y-m-d');
        $articles = TableRegistry::get('Studattends');
        return $articles->find('all')->where(['Studattends.class_id' => $classs, 'Studattends.section_id' => $sectionid, 'Studattends.date' => $da, 'Studattends.status' => 'A'])->count();
    }
    public function absentclasstodayreportss23date($classs = null, $sectionid = null, $date = null)
    {

        $da = date('Y-m-d', strtotime($date));
        $articles = TableRegistry::get('Studattends');
        return $articles->find('all')->where(['Studattends.class_id' => $classs, 'Studattends.section_id' => $sectionid, 'Studattends.date' => $da, 'Studattends.status' => 'A'])->count();
    }
    public function classtodayreportss23($classs = null, $sectionid = null, $date = null)
    {
        // this this changes by rupam 16/02/2022
        if ($date) {
            $da = date('Y-m-d', strtotime($date));
        } else {

            $da = date('Y-m-d');
        }

        // $da = date('Y-m-d');
        $articles = TableRegistry::get('Studattends');
        return $articles->find('all')->where(['Studattends.class_id' => $classs, 'Studattends.section_id' => $sectionid, 'Studattends.date' => $da])->count();
    }
    public function classtodayreportss23date($classs = null, $sectionid = null, $date = null)
    {

        $da = date('Y-m-d', strtotime($date));
        $articles = TableRegistry::get('Studattends');
        return $articles->find('all')->where(['Studattends.class_id' => $classs, 'Studattends.section_id' => $sectionid, 'Studattends.date' => $da])->count();
    }

    public function presentclasstodayreportss24($classs = null, $sectionid = null)
    {

        $da = date('Y-m-d');
        $articles = TableRegistry::get('Studattends');
        return $articles->find('all')->where(['Studattends.class_id' => $classs, 'Studattends.section_id' => $sectionid, 'Studattends.date' => $da, 'Studattends.status' => 'P'])->count();
    }
    public function presentclasstodayreportss($classs = null, $sectionid = null)
    {

        $da = date('Y-m-d');
        $articles = TableRegistry::get('Studattends');
        return $articles->find('all')->where(['Studattends.class_id' => $classs, 'Studattends.section_id' => $sectionid, 'Studattends.date' => $da, 'Studattends.status' => 'A'])->count();
    }

    public function classtotalstudent($classs = null, $sectionid = null)
    {
        $getterm = $this->findacedemicyears('1');
        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['Students.class_id' => $classs, 'Students.acedmicyear' => $getterm['academic_year'], 'Students.section_id' => $sectionid, 'Students.status' => 'Y'])->count();
    }

    public function getthisyearstudent($id = null, $acedemic = null)
    {

        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['Students.id' => $id, 'Students.acedmicyear' => $acedemic])->first();
    }
    function checktcexist($sid)
    {
        $DropOutStudent = TableRegistry::get('DropOutStudent');
        $studentfees = TableRegistry::get('Studentfees');
        $results = $DropOutStudent->find('all')->where(['enroll' => $sid])->first();
        if ($results) {
            $student_datask = $studentfees->find()
                ->select(['quarter', 'id'])
                ->where([
                    'Studentfees.student_id' => $results['s_id'],
                    'Studentfees.status' => 'Y',
                    'Studentfees.deposite_amt !=' => '0',
                    'Studentfees.recipetno !=' => '0'
                ])
                ->order(['Studentfees.recipetno' => 'ASC'])
                ->toArray();

            foreach ($student_datask as $stu) {
                $quass = unserialize($stu['quarter']);
                foreach ($quass as $key => $valueQuater) {

                    if ("T.C." == $key) {
                        // pr($stu);exit;
                        return $stu['id'];
                    }
                }
            }
        }

        return 0;
    }


    public function getthisstudent($enroll = null, $board_id = null)
    {

        $articles = TableRegistry::get('Students');
        return $articles->find('all')->select(['enroll', 'fname', 'middlename', 'lname', 'class_id', 'section_id'])->where(['Students.enroll' => $enroll, 'Students.board_id' => $board_id, 'Students.status' => 'Y'])->first();
    }

    public function gethistoryyearstudent($id = null, $acedemic = null)
    {

        $articles = TableRegistry::get('Studentshistory');
        return $articles->find('all')->where(['Studentshistory.stud_id' => $id, 'Studentshistory.acedmicyear' => $acedemic, 'Studentshistory.status' => 'Y'])->first();
    }

    public function gethistoryyearstudents2($id = null, $acedemic = null)
    {

        $articles = TableRegistry::get('Studentshistory');
        return $articles->find('all')->where(['Studentshistory.stud_id' => $id])->first();
    }

    public function gethistoryyearstudentinfo45($id = null)
    {

        $articles = TableRegistry::get('Studentshistory');
        return $articles->find('all')->where(['Studentshistory.stud_id' => $id, 'Studentshistory.status' => 'Y', 'Studentshistory.actionhistory' => 'REPEAT'])->order(['Studentshistory.id' => 'DESC'])->first();
    }

    public function gethistoryyearstudentinfo($id = null, $acedmic = null)
    {

        $articles = TableRegistry::get('Studentshistory');
        return $articles->find('all')->where(['Studentshistory.stud_id' => $id, 'Studentshistory.acedmicyear' => $acedmic, 'Studentshistory.status' => 'Y', 'Studentshistory.actionhistory' => 'REPEAT'])->order(['Studentshistory.id' => 'DESC'])->first();
    }

    public function gethistoryyearstudentinfo2($id = null, $acedmic = null)
    {

        $articles = TableRegistry::get('Studentshistory');
        return $articles->find('all')->where(['Studentshistory.stud_id' => $id, 'Studentshistory.acedmicyear' => $acedmic, 'Studentshistory.status' => 'Y'])->order(['Studentshistory.id' => 'DESC'])->first();
    }
    public function studentreport($id = null, $classs = null, $sectionid = null)
    {

        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['Students.id' => $id, 'Students.class_id' => $classs, 'Students.section_id' => $sectionid, 'Students.status' => 'Y'])->first();
    }

    public function finndstudentreport($id = null, $acedmic = null)
    {

        $articlesstudent = TableRegistry::get('Students')->find('all')->where(['Students.id' => $id, 'Students.acedmicyear' => $acedmic])->first();
        if ($articlesstudent['class_id']) {
            $articles = TableRegistry::get('Classes');
            return $articles->find()->select(['Classes.title'])->where(['Classes.id' => $articlesstudent['class_id']])->first();
        } else {

            $articlesdrop = TableRegistry::get('DropOutStudent')->find('all')->where(['DropOutStudent.s_id' => $id, 'DropOutStudent.updateacedemic' => $acedmic])->first();
            $articles = TableRegistry::get('Classes');
            return $articles->find()->select(['Classes.title'])->where(['Classes.id' => $articlesdrop['laststudclass']])->first();
        }
    }

    public function presentalltodayreport()
    {

        $connss = ConnectionManager::get('default');

        $studentrfidsd = $connss->execute("SELECT * FROM `attendreports` LEFT JOIN students ON attendreports.rfid = students.rf_id LEFT JOIN classes ON students.class_id = classes.id  WHERE students.rf_id !='0' AND students.status='Y' AND DATE(attendreports.resultdate)='" . date('Y-m-d') . "' GROUP BY attendreports.rfid  ORDER BY section_id ASC");

        return $studentrfidsd->fetchAll('assoc');
    }

    public function findacedemicstudents($classs = null, $acedmic = null, $from = null, $to = null)
    {

        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['Students.class_id' => $classs, 'Students.admissionyear' => $acedmic, 'MONTH(Students.created) >=' => $from, 'MONTH(Students.created) <=' => $to])->count();
    }
    public function findacedemicstudents2($classs = null, $acedmic = null, $from = null, $to = null)
    {

        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['Students.class_id' => $classs, 'Students.admissionyear' => $acedmic, 'DATE(Students.created) >=' => $from, 'DATE(Students.created) <=' => $to, 'Students.id !=' => '333333'])->count();
    }

    public function findacedemicstudents2stoday($board_id)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['DATE(Students.created)' => $date, 'Students.status' => 'Y', 'Students.oldenroll' => '0', 'Students.board_id' => $board_id])->count();
    }

    public function findacedemicstudents2stodaydetail($board_id, $date)
    {

        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['DATE(Students.created)' => $date, 'Students.oldenroll' => '0', 'Students.board_id' => $board_id])->count();
    }
    public function findacedemicstudents2stodaydetailhis($board_id, $acedmic, $date)
    {

        $getterm = $this->findacedemicyears('1');
        $currentyear = $getterm['academic_year'];
        $nextyear = $getterm['next_academic_year'];

        if ($currentyear == $acedmic && $acedmic != '') {

            $stts = array('Students.board_id' => $board_id);
            $apk[] = $stts;
            $stts = array('DATE(Students.created)' => $date);
            $apk[] = $stts;
            $stts = array('Students.status' => 'Y');
            $apk[] = $stts;
            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;
            $articles = TableRegistry::get('Students');
            return $articles->find('all')->where($apk)->order(['Students.id' => 'ASC'])->count();
        } else if ($acedmic != $currentyear && $acedmic != '') {

            $stts = array('DATE(Studentshistory.created)' => $date);
            $apk[] = $stts;

            $stts = array('Studentshistory.board_id' => $board_id);
            $apk[] = $stts;
            $stts = array('Studentshistory.admissionyear' => $acedmic);
            $apk[] = $stts;
            $articles = TableRegistry::get('Studentshistory');
            return $articles->find('all')->where($apk)->order(['Studentshistory.id' => 'ASC'])->count();
        } else {

            $stts = array('Students.board_id' => $board_id);
            $apk[] = $stts;
            $stts = array('DATE(Students.created)' => $date);
            $apk[] = $stts;
            $stts = array('Students.status' => 'Y');
            $apk[] = $stts;
            if ($acedmic != '') {
                $stts = array('Students.admissionyear' => $acedmic);
                $apk[] = $stts;
            }
            $articles = TableRegistry::get('Students');
            return $articles->find('all')->where($apk)->order(['Students.id' => 'ASC'])->count();
        }
    }

    public function findacedemicstudents2stodayint($board_id)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['DATE(Students.created)' => $date, 'Students.oldenroll' => '0', 'Students.status' => 'Y', 'Students.board_id !=' => $board_id])->count();
    }

    public function findacedemicstudents2stodayintdetail($board_id, $date)
    {

        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['DATE(Students.created)' => $date, 'Students.board_id !=' => $board_id, 'Students.id !=' => '333333'])->count();
    }
    public function findacedemicstudents2stodayintdetailhis($board_id, $acedmic, $date)
    {

        $getterm = $this->findacedemicyears('1');
        $currentyear = $getterm['academic_year'];

        $nextyear = $getterm['next_academic_year'];

        if ($currentyear == $acedmic && $acedmic != '') {

            $stts = array('Students.board_id !=' => $board_id);
            $apk[] = $stts;
            $stts = array('DATE(Students.created)' => $date);
            $apk[] = $stts;
            $stts = array('Students.status' => 'Y');
            $apk[] = $stts;
            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;
            $articles = TableRegistry::get('Students');
            return $articles->find('all')->where($apk)->order(['Students.id' => 'ASC'])->count();
        } else if ($acedmic != $currentyear && $acedmic != '') {

            $stts = array('DATE(Studentshistory.created)' => $date);
            $apk[] = $stts;

            $stts = array('Studentshistory.board_id !=' => $board_id);
            $apk[] = $stts;
            $stts = array('Studentshistory.admissionyear' => $acedmic);
            $apk[] = $stts;
            $articles = TableRegistry::get('Studentshistory');
            return $articles->find('all')->where($apk)->order(['Studentshistory.id' => 'ASC'])->count();
        } else {

            $stts = array('Students.board_id !=' => $board_id);
            $apk[] = $stts;
            $stts = array('DATE(Students.created)' => $date);
            $apk[] = $stts;
            $stts = array('Students.status' => 'Y');
            $apk[] = $stts;
            if ($acedmic != '') {
                $stts = array('Students.admissionyear' => $acedmic);
                $apk[] = $stts;
            }
            $articles = TableRegistry::get('Students');
            return $articles->find('all')->where($apk)->order(['Students.id' => 'ASC'])->count();
        }
    }

    public function findacedemicstudents2stodaytotal()
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['DATE(Students.created)' => $date, 'Students.oldenroll' => '0', 'Students.status' => 'Y'])->count();
    }

    public function findcollectiontudents2stoday($mode)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode' => $mode, 'Studentfees.type !=' => 'Other'])->toarray();
    }

    public function findcollectiontudents2stodaydropp($mode)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode' => $mode, 'Studentfees.type !=' => 'Other'])->toarray();
    }
    public function findcollectiontudents2stodaydetaildroppp($mode, $date)
    {

        $articles = TableRegistry::get('Studentfees');

        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.recipetno !=' => 0, 'Studentfees.type !=' => 'Other', 'Studentfees.status' => 'Y', 'Studentfees.paydate' => $date, 'Studentfees.mode' => $mode])->order(['Studentfees.id' => 'ASC'])->toArray();
    }
    public function findcollectiontudents2stodaydetaildroppp2r($mode, $acedmic, $date)
    {

        $articles = TableRegistry::get('Studentfees');
        if ($acedmic != '') {
            return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.recipetno !=' => 0, 'Studentfees.acedmicyear' => $acedmic, 'Studentfees.type !=' => 'Other', 'Studentfees.status' => 'Y', 'Studentfees.paydate' => $date, 'Studentfees.mode' => $mode])->order(['Studentfees.id' => 'ASC'])->toArray();
        } else {
            return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.recipetno !=' => 0, 'Studentfees.type !=' => 'Other', 'Studentfees.status' => 'Y', 'Studentfees.paydate' => $date, 'Studentfees.mode' => $mode])->order(['Studentfees.id' => 'ASC'])->toArray();
        }
    }

    public function findcollectiontudents2stodaydetail($mode, $date)
    {

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode' => $mode, 'Studentfees.type !=' => 'Other'])->toarray();
    }
    public function findcollectiontudents2stodaydetail2r($mode, $acedmic, $date)
    {
        $articles = TableRegistry::get('Studentfees');

        if ($acedmic != '') {

            return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id' => '1', 'Studentfees.paydate' => $date, 'Studentfees.acedmicyear' => $acedmic, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode' => $mode, 'Studentfees.type !=' => 'Other'])->toarray();
        } else {
            return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode' => $mode, 'Studentfees.type !=' => 'Other'])->toarray();
        }
    }

    public function findcollectiontudents2stodayout($mode)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.type !=' => 'Other', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode' => $mode])->toarray();
    }

    public function findcollectiontudents2stodayoutdroppp($mode)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode' => $mode, 'Studentfees.type !=' => 'Other'])->toarray();
    }

    public function findcollectiontudents2stodayoutdetail($mode, $date)
    {

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode' => $mode, 'Studentfees.type !=' => 'Other'])->toarray();
    }
    public function findcollectiontudents2stodayoutdetail2r($mode, $acedemic, $date)
    {

        $articles = TableRegistry::get('Studentfees');

        if ($acedemic != '') {
            return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.acedmicyear' => $acedemic, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode' => $mode, 'Studentfees.type !=' => 'Other'])->toarray();
        } else {
            return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode' => $mode, 'Studentfees.type !=' => 'Other'])->toarray();
        }
    }

    public function findcollectiontudents2stodayoutdetaildropp($mode, $date)
    {

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode' => $mode])->toarray();
    }
    public function findcollectiontudents2stodayoutdetaildropp2r($mode, $acedmic, $date)
    {

        $articles = TableRegistry::get('Studentfees');
        if ($acedmic != '') {
            return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.acedmicyear' => $acedmic, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode' => $mode])->toarray();
        } else {
            return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode' => $mode])->toarray();
        }
    }

    public function findcollectiontudents2stoday2($mode)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode !=' => $mode, 'Studentfees.type !=' => 'Other'])->toarray();
    }

    public function findcollectiontudents2stoday2next($mode)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode !=' => $mode, 'Studentfees.ref_no NOT LIKE' => '%SMARTHUB%', 'Studentfees.type !=' => 'Other'])->toarray();
    }
    public function findcollectiontudents2stoday2next2($mode)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode !=' => $mode, 'Studentfees.ref_no LIKE' => '%SMARTHUB%', 'Studentfees.type !=' => 'Other'])->toarray();
    }

    public function findcollectiontudents2stoday2droppe($mode)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode !=' => $mode, 'Studentfees.type !=' => 'Other'])->toarray();
    }

    public function findcollectiontudents2stoday2droppenext($mode)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode !=' => $mode, 'Studentfees.ref_no NOT LIKE' => '%SMARTHUB%', 'Studentfees.type !=' => 'Other'])->toarray();
    }

    public function findcollectiontudents2stoday2droppenext2($mode)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode !=' => $mode, 'Studentfees.ref_no LIKE' => '%SMARTHUB%', 'Studentfees.type !=' => 'Other'])->toarray();
    }
    public function findacedmicdetailallstudents($id, $acedemic)
    {

        $articles = TableRegistry::get('Studentfees');

        return $articles->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $acedemic, 'Studentfees.status' => 'Y', 'Studentfees.deposite_amt !=' => '0', 'Studentfees.recipetno !=' => '0'])->order(['Studentfees.recipetno' => 'ASC'])->toarray();
    }

    public function findcollectiontudents2stoday2detaildropp($mode, $date)
    {

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode !=' => $mode, 'Studentfees.type !=' => 'Other'])->toarray();
    }
    public function findcollectiontudents2stoday2detaildropp2r($mode, $acedmic, $date)
    {

        $articles = TableRegistry::get('Studentfees');

        if ($acedmic != '') {
            return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.paydate' => $date, 'Studentfees.acedmicyear' => $acedmic, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode !=' => $mode, 'Studentfees.type !=' => 'Other'])->toarray();
        } else {
            return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode !=' => $mode, 'Studentfees.type !=' => 'Other'])->toarray();
        }
    }

    public function findcollectiontudents2stoday2detail($mode, $date)
    {

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.type !=' => 'Other', 'Studentfees.mode !=' => $mode])->toarray();
    }

    public function findcollectiontudents2stoday2detail2r($mode, $acedmic, $date)
    {

        $articles = TableRegistry::get('Studentfees');
        if ($acedmic != '') {
            return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id' => '1', 'Studentfees.acedmicyear' => $acedmic, 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.type !=' => 'Other', 'Studentfees.mode !=' => $mode])->toarray();
        } else {
            return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.type !=' => 'Other', 'Studentfees.mode !=' => $mode])->toarray();
        }
    }

    public function findcollectiontudents2stoday2out($mode)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode !=' => $mode])->toarray();
    }

    public function findcollectiontudents2stoday2outnext($mode)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.ref_no NOT LIKE' => '%SMARTHUB%', 'Studentfees.mode !=' => $mode])->toarray();
    }
    public function findcollectiontudents2stoday2outnext2($mode)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.ref_no LIKE' => '%SMARTHUB%', 'Studentfees.mode !=' => $mode])->toarray();
    }

    public function findcollectiontudents2stoday2outdroppe($mode)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode !=' => $mode])->toarray();
    }

    public function examname($board_id)
    {
        // echo $board_id;die;
        $articles = TableRegistry::get('Board');
        return $articles->find('all')->where(['Board.id' => $board_id])->first();
    }

    public function findcollectiontudents2stoday2outdroppenext($mode)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.ref_no NOT LIKE' => '%SMARTHUB%', 'Studentfees.mode !=' => $mode])->toarray();
    }
    public function findcollectiontudents2stoday2outdroppenext2($mode)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.ref_no LIKE' => '%SMARTHUB%', 'Studentfees.mode !=' => $mode])->toarray();
    }

    public function findcollectiontudents2stoday2outdetail($mode, $date)
    {

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.type !=' => 'Other', 'Studentfees.mode !=' => $mode])->toarray();
    }

    public function findcollectiontudents2stoday2outdetail2r($mode, $acedmic, $date)
    {

        $articles = TableRegistry::get('Studentfees');
        if ($acedmic != '') {
            return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.acedmicyear' => $acedmic, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.type !=' => 'Other', 'Studentfees.mode !=' => $mode])->toarray();
        } else {
            return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.type !=' => 'Other', 'Studentfees.mode !=' => $mode])->toarray();
        }
    }
    public function findcollectiontudents2stoday2outdetaildropp($mode, $date)
    {

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode !=' => $mode])->toarray();
    }

    public function findcollectiontudents2stoday2outdetaildropp2r($mode, $acedmic, $date)
    {

        $articles = TableRegistry::get('Studentfees');
        if ($acedmic != '') {

            return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id !=' => '1', 'Studentfees.acedmicyear' => $acedmic, 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode !=' => $mode])->toarray();
        } else {

            return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['DropOutStudent.board_id !=' => '1', 'Studentfees.paydate' => $date, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => '0', 'Studentfees.mode !=' => $mode])->toarray();
        }
    }

    public function findcollectiontudents2stodayyear($mode, $acedmic)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.acedmicyear' => $acedmic, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => 0, 'Studentfees.mode' => $mode])->toarray();
    }

    public function findcollectiontudents2stodayyear2($mode, $acedmic)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['Students'])->where(['Students.acedmicyear' => $acedmic, 'Studentfees.status' => 'Y', 'Studentfees.recipetno !=' => 0, 'Studentfees.mode !=' => $mode])->toarray();
    }

    public function findcollectiontudents2stodayyears($mode, $acedmic = null)
    {

        $articles = TableRegistry::get('Studentfees');

        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['Studentfees.recipetno !=' => 0, 'Studentfees.status' => 'Y', 'DropOutStudent.acedmicyear' => $acedmic, 'DropOutStudent.status' => 'Y', 'Studentfees.mode' => $mode])->order(['Studentfees.id' => 'ASC'])->toArray();
    }

    public function gethistoryyeardropstudent($id = null, $acedemic = null)
    {

        $articles = TableRegistry::get('DropOutStudent');
        return $articles->find('all')->where(['DropOutStudent.s_id' => $id, 'DropOutStudent.status' => 'Y'])->first();
    }

    public function gethistoryyeard()
    {

        $articles = TableRegistry::get('DropOutStudent');
        return $articles->find('all')->order(['DropOutStudent.bookno' => 'DESC'])->first();
    }

    public function findcollectiontudents2stodayyears2($mode, $acedmic = null)
    {

        $articles = TableRegistry::get('Studentfees');

        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Studentfees.deposite_amt')])->contain(['DropOutStudent'])->where(['Studentfees.recipetno !=' => 0, 'Studentfees.status' => 'Y', 'DropOutStudent.acedmicyear' => $acedmic, 'DropOutStudent.status' => 'Y', 'Studentfees.mode !=' => $mode])->order(['Studentfees.id' => 'ASC'])->toArray();
    }

    public function findstudentfeesss($recipetno)
    {

        $articles = TableRegistry::get('Studentfees');

        return $articles->find('all')->where(['Studentfees.recipetno' => $recipetno])->order(['Studentfees.id' => 'ASC'])->first();
    }

    public function findregistrationtudents2stodaytotal()
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Applicant');
        return $articles->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)' => $date, 'Applicant.status_c' => 'Y', 'Enquires.status' => 'Y', 'Applicant.recipietno !=' => '0'])->count();
    }

    public function findregistrationtudents2stoday($m)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Applicant');
        return $articles->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)' => $date, 'Applicant.status_c' => 'Y', 'Applicant.recipietno !=' => '0', 'Enquires.status' => 'Y', 'Enquires.mode1_id' => $m])->count();
    }

    public function findregistrationtudents2stodayint($m)
    {

        $date = date('Y-m-d');

        $articles = TableRegistry::get('Applicant');
        return $articles->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)' => $date, 'Applicant.recipietno !=' => '0', 'Applicant.status_c' => 'Y', 'Enquires.status' => 'Y', 'Enquires.mode1_id !=' => $m])->count();
    }

    public function findregistrationtudents2stodaydetail($m, $date)
    {

        $articles = TableRegistry::get('Applicant');
        return $articles->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)' => $date, 'Applicant.recipietno !=' => '0', 'Applicant.status_c' => 'Y', 'Enquires.status' => 'Y', 'Enquires.mode1_id' => $m])->count();
    }
    public function findregistrationtudents2stodaydetail2r($m, $academic, $date)
    {

        $articles = TableRegistry::get('Applicant');
        if ($academic != '') {

            return $articles->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)' => $date, 'Applicant.acedmicyear' => $academic, 'Enquires.status' => 'Y', 'Applicant.recipietno !=' => '0', 'Applicant.status_c' => 'Y', 'Enquires.mode1_id' => $m])->count();
        } else {

            return $articles->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)' => $date, 'Applicant.recipietno !=' => '0', 'Applicant.status_c' => 'Y', 'Enquires.status' => 'Y', 'Enquires.mode1_id' => $m])->count();
        }
    }

    public function findregistrationtudents2stodaydetailint($m, $date)
    {

        $articles = TableRegistry::get('Applicant');
        return $articles->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)' => $date, 'Applicant.status_c' => 'Y', 'Applicant.recipietno !=' => '0', 'Enquires.status' => 'Y', 'Enquires.mode1_id !=' => $m])->count();
    }

    public function findregistrationtudents2stodaydetailint2r($m, $academic, $date)
    {

        $articles = TableRegistry::get('Applicant');
        if ($academic != '') {
            return $articles->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)' => $date, 'Applicant.acedmicyear' => $academic, 'Applicant.status_c' => 'Y', 'Enquires.status' => 'Y', 'Applicant.recipietno !=' => '0', 'Enquires.mode1_id !=' => $m])->count();
        } else {
            return $articles->find('all')->contain(['Enquires'])->where(['DATE(Applicant.created)' => $date, 'Applicant.status_c' => 'Y', 'Applicant.recipietno !=' => '0', 'Enquires.status' => 'Y', 'Enquires.mode1_id !=' => $m])->count();
        }
    }

    public function findregistrationstudents2s($acedmic = null)
    {

        $articles = TableRegistry::get('Applicant');
        return $articles->find('all')->contain(['Enquires'])->where(['Applicant.acedmicyear' => $acedmic, 'Enquires.mode1_id' => '1', 'Enquires.status' => 'Y', 'Applicant.status_c' => 'Y', 'Applicant.recipietno !=' => '0'])->count();
    }

    public function findregistrationstudents2sout($acedmic = null)
    {

        $articles = TableRegistry::get('Applicant');
        return $articles->find('all')->contain(['Enquires'])->where(['Applicant.acedmicyear' => $acedmic, 'Enquires.mode1_id !=' => '1', 'Applicant.status_c' => 'Y', 'Enquires.status' => 'Y', 'Applicant.recipietno !=' => '0'])->count();
    }


    public function findacedemicstudents2s($acedmic = null)
    {

        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['Students.admissionyear' => $acedmic, 'Students.board_id' => '1', 'Students.status' => 'Y'])->count();
    }

    public function findacedemicstudents2srtr($acedmic = null, $board_id = null)
    {

        $getterm = $this->findacedemicyears('1');
        $currentyear = $getterm['academic_year'];
        $nextyear = $getterm['next_academic_year'];

        if ($currentyear == $acedmic) {

            $stts = array("Students.board_id" => $board_id);
            $apk[] = $stts;
            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;

            $stts = array('Students.status' => 'Y');
            $apk[] = $stts;

            $articles = TableRegistry::get('Students');
            return $articles->find('all')->where($apk)->order(['Students.id' => 'ASC'])->count();
        } else if ($acedmic != $currentyear) {

            $stts = array("Studentshistory.board_id" => $board_id);
            $apk[] = $stts;

            $stts = array('Studentshistory.admissionyear' => $acedmic);
            $apk[] = $stts;

            $articles = TableRegistry::get('Studentshistory');
            return $articles->find('all')->where($apk)->order(['Studentshistory.id' => 'ASC'])->count();
        } else {

            $stts = array("Students.board_id" => $board_id);
            $apk[] = $stts;
            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;

            $stts = array('Students.status' => 'Y');
            $apk[] = $stts;

            $articles = TableRegistry::get('Students');
            return $articles->find('all')->where($apk)->order(['Students.id' => 'ASC'])->count();
        }
    }

    public function findacedemicstudents2srtrout($acedmic = null, $board_id = null)
    {

        $getterm = $this->findacedemicyears('1');
        $currentyear = $getterm['academic_year'];
        $nextyear = $getterm['next_academic_year'];

        if ($currentyear == $acedmic) {

            $stts = array("Students.board_id !=" => $board_id);
            $apk[] = $stts;
            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;
            $stts = array('Students.status' => 'Y');
            $apk[] = $stts;

            $articles = TableRegistry::get('Students');
            return $articles->find('all')->where($apk)->order(['Students.id' => 'ASC'])->count();
        } else if ($acedmic != $currentyear) {

            $stts = array("Studentshistory.board_id !=" => $board_id);
            $apk[] = $stts;

            $stts = array('Studentshistory.admissionyear' => $acedmic);
            $apk[] = $stts;

            $articles = TableRegistry::get('Studentshistory');
            return $articles->find('all')->where($apk)->order(['Studentshistory.id' => 'ASC'])->count();
        } else {

            $stts = array("Students.board_id !=" => $board_id);
            $apk[] = $stts;
            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;
            $stts = array('Students.status' => 'Y');
            $apk[] = $stts;

            $articles = TableRegistry::get('Students');
            return $articles->find('all')->where($apk)->order(['Students.id' => 'ASC'])->count();
        }
    }

    public function findacedemicstudents2sout($acedmic = null)
    {

        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['Students.admissionyear' => $acedmic, 'Students.board_id !=' => '1', 'Students.status' => 'Y'])->count();
    }

    public function findacedemicstudents21s($acedmic = null)
    {

        $articles = TableRegistry::get('DropOutStudent');
        return $articles->find('all')->where(['DropOutStudent.admissionyear' => $acedmic, 'DropOutStudent.board_id' => '1', 'DropOutStudent.status' => 'Y'])->count();
    }

    public function findacedemicstudents21srtr($acedmic = null, $board_id = null)
    {

        $getterm = $this->findacedemicyears('1');
        $currentyear = $getterm['academic_year'];

        $stts = array("DropOutStudent.board_id" => $board_id);
        $apk[] = $stts;

        $stts = array('DropOutStudent.admissionyear' => $acedmic);
        $apk[] = $stts;

        if ($acedmic != $currentyear) {
            $articles = TableRegistry::get('DropOutStudent');
            $ddd = $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->toarray();

            $cnust = 0;

            foreach ($ddd as $k => $kki) {

                $articles3 = TableRegistry::get('Studentshistory')->find('all')->where(['Studentshistory.stud_id' => $kki['student_id']])->order(['Studentshistory.id' => 'ASC'])->first();
                if ($articles3['id']) {
                } else {
                    $cnust++;
                }
            }
            return $cnust;
        } else {
            $articles = TableRegistry::get('DropOutStudent');
            return $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->count();
            //pr($Classections21); die;

        }
    }

    public function findacedemicstudents21srtrout($acedmic = null, $board_id = null)
    {

        $getterm = $this->findacedemicyears('1');
        $currentyear = $getterm['academic_year'];

        $stts = array("DropOutStudent.board_id !=" => $board_id);
        $apk[] = $stts;

        $stts = array('DropOutStudent.admissionyear' => $acedmic);
        $apk[] = $stts;

        if ($acedmic != $currentyear) {
            $articles = TableRegistry::get('DropOutStudent');
            $ddd = $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->toarray();

            $cnust = 0;

            foreach ($ddd as $k => $kki) {

                $articles3 = TableRegistry::get('Studentshistory')->find('all')->where(['Studentshistory.stud_id' => $kki['student_id']])->order(['Studentshistory.id' => 'ASC'])->first();
                if ($articles3['id']) {
                } else {
                    $cnust++;
                }
            }
            return $cnust;
        } else {
            $articles = TableRegistry::get('DropOutStudent');
            return $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->count();
            //pr($Classections21); die;

        }
    }

    public function findacedemicstudents21sout($acedmic = null)
    {

        $articles = TableRegistry::get('DropOutStudent');
        return $articles->find('all')->where(['DropOutStudent.admissionyear' => $acedmic, 'DropOutStudent.board_id !=' => '1', 'DropOutStudent.status' => 'Y'])->count();
    }

    public function findacedemicstudents21($classs = null, $acedmic = null, $from = null, $to = null)
    {

        $articles = TableRegistry::get('DropOutStudent');
        return $articles->find('all')->where(['DropOutStudent.class_id' => $classs, 'DropOutStudent.admissionyear' => $acedmic, 'DropOutStudent.status' => 'Y', 'DATE(DropOutStudent.admissiondate) >=' => $from, 'DATE(DropOutStudent.admissiondate) <=' => $to])->count();
    }

    public function findacedemicstudents212($classs = null, $acedmic = null, $from = null, $to = null, $status_tc = null)
    {

        // if ($status_tc == "Y") {

        $articles = TableRegistry::get('DropOutStudent');
        return $articles->find('all')->where(['DropOutStudent.class_id' => $classs, 'DATE(DropOutStudent.dropcreated) >=' => $from, 'DATE(DropOutStudent.dropcreated) <=' => $to])->count();
        // } else {

        //     $articles = TableRegistry::get('DropOutStudent');
        //     return $articles->find('all')->where(['DropOutStudent.class_id' => $classs, 'DropOutStudent.status_tc' => $status_tc, 'DropOutStudent.updateacedemic' => $acedmic, 'DATE(DropOutStudent.dropcreated) >=' => $from, 'DATE(DropOutStudent.dropcreated) <=' => $to])->count();
        // }
    }


    public function findempname($id = null)
    {
        $articles = TableRegistry::get('Employees');
        return $articles->find()->select(['fname', 'middlename', 'lname'])->where(['Employees.id' => $id])->first();
    }

    public function findpendingsfee($id, $rid)
    {

        $articles = TableRegistry::get('Studentfeepending');
        $query = $articles->find('all');
        return $query->select(['sum' => $query->func()->sum('Studentfeepending.amt')])->where(['Studentfeepending.s_id' => $id, 'Studentfeepending.r_id' => $rid])->toarray();
    }



    public function findpendingsfeestart($rid)
    {

        $articles = TableRegistry::get('Studentfeepending');
        $query = $articles->find('all');
        return $query->select(['recipetnos'])->where(['Studentfeepending.r_id' => $rid])->toarray();
    }

    public function findpendingsfee2($id, $rid)
    {

        $articles = TableRegistry::get('Studentfeepending');
        $query = $articles->find('all');
        return $query->select([
            'sum' =>
            $query->func()->sum('Studentfeepending.amt')
        ])->where(['Studentfeepending.s_id' => $id, 'Studentfeepending.amt >=' => '0', 'Studentfeepending.r_id' => $rid])->toarray();
    }

    public function findpendingsfeess2($id, $rid)
    {

        $articles = TableRegistry::get('Studentfeepending');
        $query = $articles->find('all');
        return $query->select([
            'sum' =>
            $query->func()->sum('Studentfeepending.amt')
        ])->where(['Studentfeepending.s_id' => $id, 'Studentfeepending.amt <' => '0', 'Studentfeepending.status' => 'N', 'Studentfeepending.r_id' => $rid])->toarray();
    }

    public function findpendingssingle234fee($id, $acedmicyear)
    {

        $articles = TableRegistry::get('Studentfeepending');
        $query = $articles->find('all');
        return $query->contain(['Studentfees'])->select(['sum' => $query->func()->sum('Studentfeepending.amt')])->where(['Studentfeepending.s_id' => $id, 'Studentfeepending.status' => 'N', 'Studentfees.acedmicyear' => $acedmicyear, 'Studentfeepending.amt >' => '0'])->toarray();
    }

    public function findpendingssinglefee($id)
    {

        $articles = TableRegistry::get('Studentfeepending');
        $query = $articles->find('all');
        return $query->select(['sum' => $query->func()->sum('Studentfeepending.amt')])->where(['Studentfeepending.s_id' => $id])->toarray();
    }
    public function findpendingssinglefee2($id)
    {

        $articles = TableRegistry::get('Studentfeepending');
        $query = $articles->find('all');
        return $query->select(['sum' => $query->func()->sum('Studentfeepending.amt')])->where(['Studentfeepending.s_id' => $id, 'Studentfeepending.status' => 'N', 'Studentfeepending.amt >' => '0'])->toarray();
    }

    public function findpendingsfeetotal($datefrom, $dateto2, $rt)
    {

        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto2 = date('Y-m-d', strtotime($dateto2));
        $articles = TableRegistry::get('Studentfeepending');
        $query = $articles->find('all');
        return $query->select(['sum' => $query->func()->sum('Studentfeepending.amt')])->contain(['Studentfees'])->where(['DATE(Studentfeepending.created) >=' => $datefrom, 'DATE(Studentfeepending.created) <=' => $dateto2, 'Studentfees.mode' => $rt, 'Studentfees.status' => 'Y'])->toarray();
    }


    public function findclassteachers($id1)
    {

        $articles = TableRegistry::get('Employees');
        return $articles->find()->select(['fname', 'middlename', 'lname', 'id'])->where(['Employees.id' => $id1])->first();
    }

    public function findclassteachersorginal($id1 = null, $id2 = null)
    {

        $articles = TableRegistry::get('Classteachers');
        return $articles->find()->contain(['Employees'])->where(['Classteachers.class_id' => $id1, 'Classteachers.section_id' => $id2, 'Classteachers.teacher_type' => '1'])->first();
    }
    public function showclasstitle($id = null)
    {
        $articles = TableRegistry::get('Classes');
        return $articles->find()->select(['Classes.title'])->where(['Classes.id' => $id])->first();
    }


    public function showboardtitle($id = null)
    {
        $articles = TableRegistry::get('Boards');
        return $articles->find()->select(['Boards.name'])->where(['Boards.id' => $id])->first();
    }

    public function showestudentexamstatus($id = null, $sec_id = null, $classid = null)
    {
        $articles = TableRegistry::get('Studentexamresult');
        return $articles->find('all')->select(['Studentexamresult.id', 'Studentexamresult.status'])->where(['Studentexamresult.exam_id' => $id, 'Studentexamresult.sect_id' => $sec_id, 'Studentexamresult.class_id' => $classid])->toarray();
    }


    public function findbank($id)
    {
        $articles = TableRegistry::get('Banks');
        return $articles->find('all')->where(['Banks.id' => $id, 'Banks.status' => 'Y'])->first();
    }


    public function findlogo()
    {

        $articles = TableRegistry::get('SitesettingsDetails');

        return $articles->find('all')->first();
    }


    public function findstuduefees($id = null, $year = null)
    {
        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['Students.id' => $id, 'Students.status' => 'Y'])->select(['due_fees'])->toarray();
    }

    public function findstudentname($id = null)
    {
        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['Students.enroll' => $id, 'Students.status' => 'Y'])->first();
    }
    public function findgendercount($id = null, $element, $elements)
    {
        $articles = TableRegistry::get('Students');
        $getterm = $this->findacedemicyears('1');
        return $articles->find('all')->where(['Students.gender' => $id, 'Students.class_id' => $element, 'Students.acedmicyear' => $getterm['academic_year'], 'Students.section_id' => $elements, 'Students.status' => 'Y'])->count();
    }
    public function findgendercountaws($id = null, $element, $elements, $aced)
    {
        $articles = TableRegistry::get('Students');
        $getterm = $this->findacedemicyears('1');

        return $articles->find('all')->where(['Students.gender' => $id, 'Students.class_id' => $element, 'Students.acedmicyear' => $aced, 'Students.section_id' => $elements, 'Students.status' => 'Y'])->count();
    }

    public function findgendercountawsboth($element, $elements, $aced)
    {
        $articles = TableRegistry::get('Students');

        return $articles->find('all')->where(['Students.class_id' => $element, 'Students.acedmicyear' => $aced, 'Students.section_id' => $elements, 'Students.status' => 'Y'])->count();
    }

    public function findgendercountawsdrop($id = null, $element, $elements, $aced)
    {
        $articles = TableRegistry::get('DropOutStudent');
        $getterm = $this->findacedemicyears('1');
        return $articles->find('all')->where(['DropOutStudent.gender' => $id, 'DropOutStudent.class_id' => $element, 'DropOutStudent.updateacedemic' => $aced, 'DropOutStudent.section_id' => $elements])->count();
    }
    public function findgendercountawsdroparray($aced)
    {
        $articles = TableRegistry::get('DropOutStudent');

        return $articles->find('all')->select(['s_id'])->where(['DropOutStudent.updateacedemic' => $aced])->toarray();
    }
    public function findgendercountawshistory($id = null, $element, $elements, $aced, $rrt)
    {
        $articles = TableRegistry::get('Studentshistory');
        $getterm = $this->findacedemicyears('1');
        return $articles->find('all')->where(['Studentshistory.gender' => $id, 'Studentshistory.stud_id NOT IN' => $rrt, 'Studentshistory.class_id' => $element, 'Studentshistory.acedmicyear' => $aced, 'Studentshistory.section_id' => $elements])->count();
    }

    public function findgendercountws($id = null, $element)
    {

        $getterm = $this->findacedemicyears('1');
        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['Students.gender' => $id, 'Students.class_id' => $element, 'Students.acedmicyear' => $getterm['academic_year'], 'Students.status' => 'Y'])->count();
    }
    public function findgendercountwsaws($id = null, $element, $aced)
    {

        $getterm = $this->findacedemicyears('1');
        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['Students.gender' => $id, 'Students.class_id' => $element, 'Students.acedmicyear' => $aced, 'Students.status' => 'Y'])->count();
    }

    public function findgendercountwsawsbothh($element, $aced)
    {

        $getterm = $this->findacedemicyears('1');
        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['Students.class_id' => $element, 'Students.acedmicyear' => $aced, 'Students.status' => 'Y'])->count();
    }

    public function findgendercountwsawsdrop($id = null, $element, $aced)
    {

        $getterm = $this->findacedemicyears('1');
        $articles = TableRegistry::get('DropOutStudent');
        return $articles->find('all')->where(['DropOutStudent.gender' => $id, 'DropOutStudent.status_tc' => 'Y', 'DropOutStudent.class_id' => $element, 'DropOutStudent.updateacedemic' => $aced])->count();
    }

    public function findgendercountwsawsdhistory($id = null, $element, $aced, $rrt)
    {

        $getterm = $this->findacedemicyears('1');
        $articles = TableRegistry::get('Studentshistory');
        return $articles->find('all')->where(['Studentshistory.gender' => $id, 'Studentshistory.stud_id NOT IN' => $rrt, 'Studentshistory.class_id' => $element, 'Studentshistory.acedmicyear' => $aced])->count();
    }

    public function findgendercounthouse($id = null, $element, $elements, $hid)
    {
        $articles = TableRegistry::get('Students');
        $getterm = $this->findacedemicyears('1');
        return $articles->find('all')->where(['Students.gender' => $id, 'Students.class_id' => $element, 'Students.acedmicyear' => $getterm['academic_year'], 'Students.section_id' => $elements, 'Students.h_id' => $hid, 'Students.status' => 'Y'])->count();
    }
    public function findgendercounthouseaws($id = null, $element, $elements, $hid, $acedmic)
    {
        $articles = TableRegistry::get('Students');
        $getterm = $this->findacedemicyears('1');
        return $articles->find('all')->where(['Students.gender' => $id, 'Students.class_id' => $element, 'Students.acedmicyear' => $acedmic, 'Students.section_id' => $elements, 'Students.h_id' => $hid, 'Students.status' => 'Y'])->count();
    }
    public function findgendercounthousewc($id = null, $element, $hid)
    {
        $articles = TableRegistry::get('Students');
        $getterm = $this->findacedemicyears('1');
        return $articles->find('all')->where(['Students.gender' => $id, 'Students.class_id' => $element, 'Students.acedmicyear' => $getterm['academic_year'], 'Students.h_id' => $hid, 'Students.status' => 'Y'])->count();
    }

    public function findgendercounthousewcaws($id = null, $element, $hid, $acedmic)
    {
        $articles = TableRegistry::get('Students');
        $getterm = $this->findacedemicyears('1');
        return $articles->find('all')->where(['Students.gender' => $id, 'Students.class_id' => $element, 'Students.acedmicyear' => $acedmic, 'Students.h_id' => $hid, 'Students.status' => 'Y'])->count();
    }
    public function findgendercounthouse2($element, $elements, $hid)
    {
        $articles = TableRegistry::get('Students');
        $getterm = $this->findacedemicyears('1');
        return $articles->find('all')->where(['Students.class_id' => $element, 'Students.section_id' => $elements, 'Students.acedmicyear' => $getterm['academic_year'], 'Students.h_id' => $hid, 'Students.status' => 'Y'])->count();
    }
    public function findgendercounthouse2aws($element, $elements, $hid, $acedmic)
    {
        $articles = TableRegistry::get('Students');
        $getterm = $this->findacedemicyears('1');
        return $articles->find('all')->where(['Students.class_id' => $element, 'Students.section_id' => $elements, 'Students.acedmicyear' => $acedmic, 'Students.h_id' => $hid, 'Students.status' => 'Y'])->count();
    }

    public function findgendercounthouse2wc($element, $hid)
    {
        $articles = TableRegistry::get('Students');
        $getterm = $this->findacedemicyears('1');
        return $articles->find('all')->where(['Students.class_id' => $element, 'Students.h_id' => $hid, 'Students.acedmicyear' => $getterm['academic_year'], 'Students.status' => 'Y'])->count();
    }

    public function findgendercounthouse2wcaws($element, $hid, $acedmic)
    {
        $articles = TableRegistry::get('Students');
        $getterm = $this->findacedemicyears('1');
        return $articles->find('all')->where(['Students.class_id' => $element, 'Students.h_id' => $hid, 'Students.acedmicyear' => $acedmic, 'Students.status' => 'Y'])->count();
    }
    public function find_section($id = null)
    {
        $articles = TableRegistry::get('Classections');
        return $articles->find('list', [
            'keyField' => 'Sections.id',
            'valueField' => 'Sections.title',
        ])->contain(['Sections'])->where(['Classections.class_id' => $id, 'Classections.status' => 'Y'])->order(['Sections.title' => 'ASC'])->toArray();
    }

    public function findepbx($id = null)
    {
        $articles = TableRegistry::get('Hostelrooms');
        return $articles->find('list', ['keyField' => 'id', 'valueField' => 'epax'])->where(['Hostelrooms.h_id' => $id])->toArray();
    }

    public function findsectionddd($classid = null)
    {

        $articles = TableRegistry::get('Classections');
        return $articles->find('list', [
            'keyField' => 'Sections.id',
            'valueField' => 'Sections.title',
        ])->contain(['Sections'])->where(['Classections.class_id' => $classid])->order(['Sections.title' => 'ASC'])->toArray();
    }
    public function find_alls($id = null)
    {
        $articles = TableRegistry::get('Classections');
        return $articles->find('all')->contain(['Sections', 'Classes'])->where(['Classections.id' => $id])->order(['Sections.title' => 'ASC'])->first();
    }

    public function findcount($id = null, $month = null, $acedmicyear = null)
    {

        $articles = TableRegistry::get('Studattends');
        return $articles->find('all')->where(['Studattends.stud_id' => $id, 'MONTH(Studattends.date)' => $month, 'Studattends.status' => 'P', 'Studattends.acedemic' => $acedmicyear])->count();
    }

    public function findclasssectionid($id = null)
    {
        //return  $id; die;
        $articles = TableRegistry::get('Classections');
        return $articles->find('all')->select(['class_id', 'section_id', 'id'])->contain(['Classes', 'Sections'])->where(['Classections.id' => $id])->first();
    }

    public function findclass123($id = null)
    {
        //return  $id; die;
        $articles = TableRegistry::get('Classes');
        return $articles->find('all')->select(['title', 'id', 'wordsc'])->where(['Classes.id' => $id])->first();
    }

    public function findsection123($id = null)
    {
        //return  $id; die;
        $articles = TableRegistry::get('Sections');
        return $articles->find('all')->select(['title', 'id'])->where(['Sections.id' => $id])->first();
    }


    public function gettimetableteacher($ttid, $weekday, $classectionid)
    {


        $articles = TableRegistry::get('ClasstimeTabs');
        // Start a new query.
        return $articles->find('all')->contain(['Employees', 'Subjects'])->where(['ClasstimeTabs.weekday' => $weekday, 'ClasstimeTabs.tt_id' => $ttid, 'FIND_IN_SET(\'' . $classectionid . '\',ClasstimeTabs.employee_id)'])->toArray();
    }

    public function checksubstitute($ttid, $weekday, $classectionid)
    {
        // pr($weekday); die;

        $articles = TableRegistry::get('Substitutes');

        // Start a new query.
        $date = date('Y-m-d');

        return $articles->find('all')->where(['Substitutes.timetable_id' => $ttid, 'Substitutes.weekday' => $weekday, 'Substitutes.class_id' => $classectionid, 'Substitutes.today_date' => $date])->toArray();
    }


    public function gettimetable($ttid, $weekday, $classectionid)
    {
        $articles = TableRegistry::get('ClasstimeTabs');

        // Start a new query.

        return $articles->find('all')->contain(['Employees', 'Subjects'])->where(['ClasstimeTabs.weekday' => $weekday, 'ClasstimeTabs.tt_id' => $ttid, 'ClasstimeTabs.class_id' => $classectionid])->toArray();
    }

    public function findsubjectopt($classid = null, $sectionid = null)
    {
        $empid = $this->request->session()->read('Auth.User.tech_id');
        $articles = TableRegistry::get('ClasstimeTabs');
        $csec = $articles->find('all')->contain(['Classections'])->where(['FIND_IN_SET(\'' . $empid . '\',ClasstimeTabs.employee_id)', 'Classections.class_id' => $classid, 'Classections.section_id' => $sectionid])->toarray();
        $sb = array();
        foreach ($csec as $key => $value) {
            $empo = explode(',', $value['employee_id']);
            $subjects = explode(',', $value['subject_id']);

            foreach ($empo as $j => $t) {

                foreach ($subjects as $sj => $st) {

                    if ($j == $sj && $t == $empid) {

                        $articless = TableRegistry::get('Subjects');

                        $csec = $articless->find('all')->where(['id' => $st])->first();
                        if ($st == "66" || $st == "67" || $st == "68") {

                            $sb[] = $csec['id'];
                        } else if ($st == "65" || $st == "70" || $st == "71") {

                            $sb[] = $csec['id'];
                        }
                    }
                }
            }
        }

        $sb = array_unique($sb);
        return $sb;
    }

    public function findapass($id)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Users');

        // Start a new query.

        return $articles->find('all')->where(['Users.tech_id' => $id])->first();
    }
    public function findacedemicyears()
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Users');
        // Start a new query.
        return $articles->find('all')->where(['Users.id' => '1'])->first();
    }

    public function findcreated($en)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Users');

        // Start a new query.

        return $articles->find('all')->where(['Users.email' => $en])->first();
    }

    public function findemployee($id)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Employees');

        // Start a new query.

        return $articles->find('all')->contain(['PayrollDepartments', 'PayrollDesignations'])->where(['Employees.id' => $id])->first();
    }
    public function findfeesallocation($qua, $id)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.

        return $articles->find('all')->where(['Studentfees.student_id' => $id, 'Studentfees.status' => 'Y'])->first();
    }

    public function findfeesmonth($id)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.

        return $articles->find('all')->select(['paydate'])->where(['student_id' => $id, 'status' => 'Y'])->order(['paydate' => 'DESC'])->first();
    }

    public function findfeesmonthstudentdrop($id)
    {
        $articles = TableRegistry::get('Studentfees');
        // Start a new query.
        return $articles->find('all')->select(['paydate'])->where(['student_id' => $id, 'quarter LIKE ' => '%Quater1%', 'status' => 'Y'])->order(['paydate' => 'DESC'])->first();
    }

    public function findfeesmonthstudentdrop2($id)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.

        return $articles->find('all')->select(['paydate'])->where(['student_id' => $id, 'quarter LIKE ' => '%Quater2%', 'status' => 'Y'])->order(['paydate' => 'DESC'])->first();
    }

    public function findfeesmonthstudentdrop3($id)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.

        return $articles->find('all')->select(['paydate'])->where(['student_id' => $id, 'quarter LIKE ' => '%Quater3%', 'status' => 'Y'])->order(['paydate' => 'DESC'])->first();
    }

    public function findfeesmonthstudentdrop4($id)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.

        return $articles->find('all')->select(['paydate'])->where(['student_id' => $id, 'quarter LIKE ' => '%Quater4%', 'status' => 'Y'])->order(['paydate' => 'DESC'])->first();
    }

    public function findfeemonth($mode = null, $datedfrom = null, $datedto = null)
    {
        // pr ($mode);
        // pr ($datedfrom); 
        // pr ($datedto); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.

        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        if ($rolepresent == '5' || $rolepresent == '6' || $rolepresent == '1') {
            $sum1 = $articles->find('all')->contain(['Students'])->select(['total' => $articles->find()->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.mode' => $mode, 'Studentfees.type !=' => 'Other', 'Studentfees.paydate >=' => $datedfrom, 'Studentfees.paydate <=' => $datedto, 'Studentfees.recipetno != ' => 0, 'Studentfees.status' => 'Y'])->order(['paydate' => 'DESC'])->toArray();
            // pr($sum1);

            // $sum2 = $articles->find('all')->contain(['DropOutStudent'])->select(['total' => $articles->find()->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.mode' => $mode, 'Studentfees.type !=' => 'Other', 'Studentfees.paydate >=' => $datedfrom, 'Studentfees.paydate <=' => $datedto, 'Studentfees.recipetno != ' => 0, 'Studentfees.status' => 'Y', 'DropOutStudent.board_id IN' => ['1', '2']])->order(['paydate' => 'DESC'])->toArray();
            // if($mode=='NETBANKING'){
            //     pr($sum1[0]['total']);exit;
            // }

            return $art[0]['total'] = $sum1[0]['total'] + $sum2[0]['total'];
        }
    }

    public function findfeesmonth342($id)
    {
        // pr ($rout); die;
        $articles = TableRegistry::get('Studentfees');
        // Start a new query.
        return $articles->find('all')->select(['paydate', 'quarter'])->where(['student_id' => $id, 'quarter LIKE ' => '%Admission Fee%', 'status' => 'Y'])->order(['paydate' => 'DESC'])->first();
    }

    public function findfeesmonth34($id)
    {
        // pr ($rout); die;
        $articles = TableRegistry::get('Studentfees');
        // Start a new query.
        return $articles->find('all')->select(['paydate', 'quarter'])->where(['student_id' => $id, 'quarter LIKE ' => '%Quater%', 'status' => 'Y'])->order(['paydate' => 'DESC'])->first();
    }
    public function findclassectionsed()
    {
        // pr ($rout); die;

        $username = $this->request->session()->read('Auth.User.email');
        $articles = TableRegistry::get('Classections');

        // Start a new query.

        return $articles->find('all')->contain(['Classes', 'Sections', 'Employees'])->where(['Employees.email' => $username])->first();
    }

    public function findtransportfeesallocation($qua, $id)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('StudentTransfees');

        // Start a new query.

        return $articles->find('all')->where(['StudentTransfees.quarter' => $qua, 'StudentTransfees.student_id' => $id])->first()->toArray();
    }


    public function findhostalfeesallocation($id, $uid)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('StudentHostalfees');

        // Start a new query.

        return $articles->find('all')->where(['StudentHostalfees.student_id' => $id, 'StudentHostalfees.h_id' => $uid])->first();
    }
    public function findphonenemner($r)
    {

        $articles = TableRegistry::get('Applicant');

        return $articles->find('all')->where(['Applicant.sno' => $r])->order(['Applicant.id' => 'DESC'])->first();
    }
    public function findapplicant($recipetno, $formno)
    {

        $articles = TableRegistry::get('Applicant');

        return $articles->find('all')->select(['id', 'fname', 'middlename', 'lname', 'class_id', 'f_name'])->where(['Applicant.recipietno' => $recipetno, 'Applicant.sno' => $formno])->first();
    }

    public function findapplicantnext($recipetno, $formno, $class)
    {

        $articles = TableRegistry::get('Applicant');

        return $articles->find('all')->select(['id', 'fname', 'middlename', 'lname', 'class_id', 'f_name'])->where(['Applicant.recipietno' => $recipetno, 'Applicant.sno' => $formno, 'Applicant.class_id' => $class])->first();
    }

    public function checkregistration($datefrom, $dateto2)
    {

        $articles = TableRegistry::get('Applicant');

        // Start a new query.
        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto2 = date('Y-m-d', strtotime($dateto2));

        $rolepresent = $this->request->session()->read('Auth.User.role_id');

        if ($rolepresent == '5' || $rolepresent == '6') {

            return $articles->find('all')->select(['regfee' => $articles->find()->func()->sum('Applicant.reg_fee')])->where(['DATE(Applicant.created) >=' => $datefrom, 'Applicant.class_id IN' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '30', '31'], 'Applicant.status_c' => 'Y', 'DATE(Applicant.created) <=' => $dateto2])->toarray();
        } else if ($rolepresent == '8') {

            return $articles->find('all')->select(['regfee' => $articles->find()->func()->sum('Applicant.reg_fee')])->where(['DATE(Applicant.created) >=' => $datefrom, 'Applicant.status_c' => 'Y', 'Applicant.class_id IN' => ['23', '24', '25', '26', '27', '28', '29'], 'DATE(Applicant.created) <=' => $dateto2])->toarray();
        } else {

            return $articles->find('all')->select(['regfee' => $articles->find()->func()->sum('Applicant.reg_fee')])->where(['DATE(Applicant.created) >=' => $datefrom, 'Applicant.status_c' => 'Y', 'DATE(Applicant.created) <=' => $dateto2])->toarray();
        }
    }


    public function findregistrationsummary($class_id, $acedmicyear, $datefrom, $dateto2)
    {
        $articles = TableRegistry::get('Applicant');
        // Start a new query.
        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto2 = date('Y-m-d', strtotime($dateto2));
        return $articles->find('all')->contain(['Enquires'])->where(['Applicant.class_id' => $class_id, 'Enquires.status' => 'Y', 'Applicant.acedmicyear' => $acedmicyear, 'DATE(Applicant.created) >=' => $datefrom, 'DATE(Applicant.created) <=' => $dateto2])->count();
    }

    public function findhouse($id = null)
    {

        // Formatted data:
        $articles = TableRegistry::get('Houses');

        // Start a new query.

        return $articles->find('all')->where(['Houses.id' => $id])->first();
    }


    public function getHTML($url, $timeout)
    {
        $ch = curl_init($url); // initialize curl with given url
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]); // set  useragent
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); // max. seconds to execute
        curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
        return @curl_exec($ch);
    }


    public function find_subjectsprinttc($id = null)
    {
        //return $id; die;
        $articles = TableRegistry::get('Printtcsubjects');
        return $articles->find('all')->where(['Printtcsubjects.classid' => $id])->order(['Printtcsubjects.sort' => 'ASC'])->toArray();
    }

    public function find_subjectsprinttcprint($id = null)
    {
        //return $id; die;
        $articles = TableRegistry::get('Printtcsubjects');
        return $articles->find('all')->where(['Printtcsubjects.id' => $id])->order(['Printtcsubjects.sort' => 'ASC'])->first();
    }

    public function findibdpsubject()
    {
        //return $id; die;
        $articles = TableRegistry::get('Printtcsubjects');
        return $articles->find('all')->where(['Printtcsubjects.classid IS NULL'])->order(['Printtcsubjects.name' => 'ASC'])->toarray();
    }


    public function findeexamtsype2s($section = null, $classid = null)
    {

        $articles = TableRegistry::get('Studentexamresult');

        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.class_id' => $classid, 'Studentexamresult.sect_id' => $section])->group(['Studentexamresult.etype_id'])->order(['Studentexamresult.id' => 'asc'])->toarray();
    }

    public function findeexamtsype3s($section = null, $classid = null, $term = null)
    {

        $articles = TableRegistry::get('Studentexamresult');

        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.class_id' => $classid, 'Studentexamresult.sect_id' => $section, 'Studentexamresult.term' => $term])->group(['Studentexamresult.etype_id'])->order(['Studentexamresult.etype_id' => 'asc'])->toarray();
    }
    public function findeexamtsype3ss($section = null, $classid = null, $term = null, $etype_id = null)
    {

        $articles = TableRegistry::get('Studentexamresult');

        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.class_id' => $classid, 'Studentexamresult.sect_id' => $section, 'Studentexamresult.term' => $term, 'Studentexamresult.etype_id' => $etype_id])->group(['Studentexamresult.etype_id'])->order(['Studentexamresult.id' => 'asc'])->toarray();
    }

    public function finexamresult_if_exist($classid = null, $subject = null, $student = null)
    {

        $articles = TableRegistry::get('Studentexamresult');

        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.class_id' => $classid, 'Studentexamresult.subject_id' => $subject, 'Studentexamresult.stud_id' => $student, 'Studentexamresult.marks !=' => 0])->group(['Studentexamresult.subject_id'])->order(['Studentexamresult.id' => 'asc'])->first();
    }

    public function find_examsubjectsnnupdated($cid = null, $enroll = null)
    {


        $articles = TableRegistry::get('ExamSubjects');
        $stduents = TableRegistry::get('Students');
        $subjects = TableRegistry::get('Subjects');

        $st_details = $stduents->find('all')->where(['enroll' => $enroll])->first();
        $comsub_id = explode(",", $st_details['comp_sid']);
        // $optionsub_id = explode(",", $st_details['opt_sid']);
        $allsubject = array_merge($comsub_id);
        // // For XI and XII class subject indivisual subject     
        foreach ($allsubject as $sub_id) {
            $st_subject = $subjects->find('all')->where(['Subjects.id' => $sub_id])->first();
            $all_array[] = $st_subject['name'];
        }

        // Backup
        if ($cid >= 12) {
            return $articles->find('all')->where(['class_id' => $cid, 'theorymarks !=' => 0, 'exprint IN' => $all_array])->order(['sort' => 'ASC'])->toArray();
        }

        return $articles->find('all')->where(['class_id' => $cid, 'theorymarks !=' => 0])->order(['sort' => 'ASC'])->toArray();
    }
    public function find_nontheorysubject($cid = null, $st_id = null)
    {

        $articles = TableRegistry::get('ExamSubjects');
        $stduents = TableRegistry::get('Students');
        $subjects = TableRegistry::get('Subjects');

        $st_details = $stduents->find('all')->where(['enroll' => $st_id])->first();
        $optionsub_id = explode(",", $st_details['opt_sid']);
        // // For XI and XII class subject indivisual subject     
        foreach ($optionsub_id as $sub_id) {
            $st_subject = $subjects->find('all')->where(['Subjects.id' => $sub_id])->first();
            $all_array[] = $st_subject['name'];
        }

        // Backup
        if ($cid >= 12) {
            return $articles->find('all')->where(['class_id' => $cid, 'is_optional !=' => 0, 'exprint IN' => $all_array])->order(['sort' => 'ASC'])->toArray();
        }

        $articles = TableRegistry::get('ExamSubjects');
        return $articles->find('all')->where(['class_id' => $cid, 'is_optional =' => 1])->order(['sort' => 'ASC'])->toArray();
    }

    public function fsubjectmarks1($sid = null, $section = null, $classid = null, $rs = null, $sub = null)
    {
        $articles = TableRegistry::get('Studentexamresult');
        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.class_id' => $classid, 'Studentexamresult.stud_id' => $sid, 'Studentexamresult.etype_id' => $rs, 'Studentexamresult.subject_id' => $sub])->first();
    }

    public function fsubjectmarks2($sid = null, $section = null, $classid = null, $rs = null, $sub = null, $term = null, $accademic_year = null)
    {
        $articles = TableRegistry::get('Studentexamresult');
        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.class_id' => $classid, 'Studentexamresult.stud_id' => $sid, 'Studentexamresult.etype_id' => $rs, 'Studentexamresult.term' => $term, 'Studentexamresult.subject_id' => $sub, 'Studentexamresult.acedamic' => $accademic_year])->first();
    }


    public function find_guardianname($id)
    {

        $articles = TableRegistry::get('Guardians');

        // Start a new query.

        return $articles->find('all')->where(['Guardians.user_id' => $id, 'Guardians.relation' => 'Father'])->toArray();
    }
    public function find_guardiannames($id)
    {

        $articles = TableRegistry::get('Guardians');

        // Start a new query.

        return $articles->find('all')->where(['Guardians.user_id' => $id, 'Guardians.relation' => 'Father'])->toArray();
    }


    public function findresultuploadquater($class_id = null, $section_id = null, $quater = null, $rolepresentyear = null)
    {
        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['section_id' => $section_id, 'class_id' => $class_id, 'acedmicyear' => $rolepresentyear, 'status' => 'Y'])->count();
    }

    public function mrncheck($id)
    {
        $dbname = $this->request->session()->read('Auth.User.db');
        // echo $dbname; die;
        $connss = ConnectionManager::get($dbname);
        $studentrfidsd = $connss->execute("SELECT * FROM `st_mrn` where `purchase_order_no`=" . $id);
        // pr($studentrfidsd);
        return $studentrfidsd->fetchAll('assoc');
    }


    public function findexamresult($id, $cid, $sect)
    {

        $articles = TableRegistry::get('Studentexamresult');

        // Start a new query.

        return $articles->find('all')->where(['sect_id' => $sect, 'class_id' => $cid, 'exam_id' => $id])->first();
    }

    public function findexamresultteacherbysubject($id, $cid, $sect, $r)
    {

        $articles = TableRegistry::get('Studentexamresult');

        return $articles->find('all')->where(['sect_id' => $sect, 'class_id' => $cid, 'exam_id' => $id, 'subject_id' => $r])->first();
    }

    public function findexamresultteacher($id, $cid, $sect, $teachid)
    {

        $articles = TableRegistry::get('Studentexamresult');

        // Start a new query. 

        return $articles->find('all')->where(['sect_id' => $sect, 'class_id' => $cid, 'exam_id' => $id, 'teach_id' => $teachid])->first();
    }
    public function findcordexamresultteacher($id, $cid, $sect)
    {
        $articles = TableRegistry::get('Studentexamresult');

        return $articles->find('all')->where(['sect_id' => $sect, 'class_id' => $cid, 'exam_id' => $id])->first();
    }

    public function findexamresultcount($cid, $sect)
    {

        $articles = TableRegistry::get('Studentexamresult');

        // Start a new query.

        return $articles->find('all')->where(['sect_id' => $sect, 'class_id' => $cid])->group(['exam_id'])->count();
    }
    public function findexamresultstudentcount($cid, $sect)
    {
        $articles = TableRegistry::get('Studentexamresult');

        // Start a new query.

        return $articles->find('all')->where(['sect_id' => $sect, 'class_id' => $cid])->group(['stud_id'])->count();
    }


    public function findexamresultstudentcountkids($cid, $sect, $exam, $etype, $accademicyear)
    {

        $articles = TableRegistry::get('Studentexamresult');
        // Start a new query.
        return $articles->find('all')->where(['sect_id' => $sect, 'class_id' => $cid, 'exam_id' => $exam, 'etype_id' => $etype, 'acedamic' => $accademicyear])->count();
    }

    public function findresultstudcountsubjectwise($cid, $sect, $exam, $etype, $subject_id, $accademic_year)
    {

        $articles = TableRegistry::get('Studentexamresult');
        // Start a new query.
        return $articles->find('all')->where(['sect_id' => $sect, 'class_id' => $cid, 'exam_id' => $exam, 'etype_id' => $etype, 'subject_id' => $subject_id, 'acedamic' => $accademic_year])->count();
    }

    public function findexamresultstudentcountkidssecond($cid, $sect, $exam, $etype, $accademic_year)
    {

        $articles = TableRegistry::get('Studentexamresult');
        return $articles->find('all')->where(['sect_id' => $sect, 'class_id' => $cid, 'exam_id' => $exam, 'etype_id' => $etype, 'acedamic' => $accademic_year])->group(['stud_id'])->count();
    }


    public function findexamresultstudentcounts2($cid, $sect, $accademicyear)
    {

        $articles = TableRegistry::get('Students');
        // Start a new query.
        return $articles->find('all')->where(['section_id' => $sect, 'class_id' => $cid, 'acedmicyear' => $accademicyear, 'status' => 'Y'])->count();
    }

    public function findexamresultstudentbyteacherscount($cid, $sect, $exid)
    {

        $articles = TableRegistry::get('Studentexamresult');

        // Start a new query.
        $tech_id = $this->request->session()->read('Auth.User.tech_id');

        return $articles->find('all')->where(['sect_id' => $sect, 'class_id' => $cid, 'teach_id' => $tech_id, 'exam_id' => $exid])->group(['stud_id'])->count();
    }

    public function findsubjectvalue($subject, $cid, $examid, $stud_id, $sect, $typeid)
    {

        $articles = TableRegistry::get('Studentexamresult');

        // Start a new query.

        return $articles->find('all')->where(['sect_id' => $sect, 'class_id' => $cid, 'stud_id' => $stud_id, 'exam_id' => $examid, 'subject_id' => $subject, 'etype_id' => $typeid])->first();
    }

    public function findsubjecttoexam($exid, $classid)
    {

        $articles = TableRegistry::get('Studentexamresult');

        // Start a new query.

        return $articles->find('all')->contain(['ExamSubjects'])->where(['Studentexamresult.class_id' => $classid, 'Studentexamresult.exam_id' => $exid])->group(['Studentexamresult.subject_id'])->order(['ExamSubjects.sort' => 'ASC'])->toarray();
    }

    public function findsubjecttoexambyteachers($exid, $classid)
    {

        $articles = TableRegistry::get('Studentexamresult');

        // Start a new query.
        $tech_id = $this->request->session()->read('Auth.User.tech_id');

        return $articles->find('all')->contain(['ExamSubjects'])->where(['Studentexamresult.class_id' => $classid, 'Studentexamresult.teach_id' => $tech_id, 'Studentexamresult.exam_id' => $exid])->group(['Studentexamresult.subject_id'])->order('Studentexamresult.id ASC')->toarray();
    }
    public function findexamresultstudentabsentcount($cid, $sect, $exid)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentexamresult');

        // Start a new query.

        return $articles->find('all')->where(['sect_id' => $sect, 'class_id' => $cid, 'exam_id' => $exid, 'marks' => 'A'])->group(['stud_id'])->count();
    }
    public function findexamresultstudentgivecount($cid, $sect, $exid)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentexamresult');

        // Start a new query.

        return $articles->find('all')->select('stud_id')->where(['sect_id' => $sect, 'class_id' => $cid, 'exam_id' => $exid])->group(['stud_id'])->toarray();
    }

    public function findexamresultstudentscount($cid, $sect)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Students');
        return $articles->find('all')->select('id')->where(['section_id' => $sect, 'class_id' => $cid, 'status' => 'Y'])->toarray();
    }

    public function findexamresultstudentabsentcountbyteachers($cid, $sect, $exid)
    {
        $articles = TableRegistry::get('Studentexamresult');

        // Start a new query.

        $tech_id = $this->request->session()->read('Auth.User.tech_id');
        return $articles->find('all')->where(['sect_id' => $sect, 'class_id' => $cid, 'exam_id' => $exid, 'marks' => 'A', 'teach_id' => $tech_id])->group(['stud_id'])->count();
    }

    public function examresultfind($id, $sect)
    {
        $articles = TableRegistry::get('Studentexamresult');
        // Start a new query.
        return $articles->find('all')->where(['sect_id' => $sect, 'stud_id' => $id])->first();
    }
    public function findstudentexamresultsection($class_id)
    {
        $articles = TableRegistry::get('Studentexamresult');

        // Start a new query.

        return $articles->find('all')->where(['class_id' => $class_id])->group('Studentexamresult.sect_id')->order('Studentexamresult.sect_id ASC')->toarray();
    }

    public function findexam($cid, $class, $acedemic)
    {
        $articles = TableRegistry::get('Exams');

        // Start a new query.

        return $articles->find('all')->contain(['Examtypes', 'Examdetails'])->where(['FIND_IN_SET(\'' . $class . '\',Exams.class_id)', 'Exams.e_type_id' => $cid, 'Exams.acedamicyear' => $acedemic])->first();
    }

    public function findexamr($cid, $term)
    {
        $articles = TableRegistry::get('Exams');

        // Start a new query.

        return $articles->find('all')->where(['FIND_IN_SET(\'' . $cid . '\',Exams.class_id)', 'Exams.termf' => $term])->count();

        $this->set('examtypesterm1ss', $examtypesterm1ss);
    }


    public function findexamresultcount1($cid, $sect, $term)
    {
        $articles = TableRegistry::get('Studentexamresult');

        // Start a new query.
        return $articles->find('all')->where(['sect_id' => $sect, 'class_id' => $cid, 'term' => $term])->group(['exam_id'])->count();
    }

    public function findexamdetail($exid, $subjectid, $stud, $clid, $sect, $acedemic)
    {
        $articles = TableRegistry::get('Studentexamresult');

        // Start a new query.
        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->select(['marks' => $articles->find()->func()->sum('Studentexamresult.marks')])->where(['Studentexamresult.stud_id' => $stud, 'Studentexamresult.class_id' => $clid, 'Studentexamresult.sect_id' => $sect, 'Studentexamresult.subject_id' => $subjectid, 'Studentexamresult.exam_id' => $exid, 'Exams.acedamicyear' => $acedemic])->group('Studentexamresult.subject_id')->order('Subjects.name ASC')->toarray();
    }

    public function findexamsubjectsresult($id, $clid, $sect, $acedemic)
    {
        $articles = TableRegistry::get('Studentexamresult');
        // Start a new query.
        return $articles->find('all')->contain(['Exams', 'Subjects'])->where(['Studentexamresult.stud_id' => $id, 'Studentexamresult.sect_id' => $sect, 'Studentexamresult.class_id' => $clid, 'Exams.acedamicyear' => $acedemic])->group('Subjects.id')->order('ExamSubjects.sort  ASC')->toarray();
    }

    public function findexamcart($id, $clid, $sect, $acedemic)
    {
        $articles = TableRegistry::get('Studentexamresult');

        // Start a new query.
        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.subject_id' => $id, 'Studentexamresult.sect_id' => $sect, 'Studentexamresult.class_id' => $clid, 'Exams.acedamicyear' => $acedemic])->group('Studentexamresult.exam_id')->order('ExamSubjects.id ASC')->toarray();
    }

    public function findexamsubjectsresult2($id, $clid, $sect, $acedemic)
    {
        $articles = TableRegistry::get('Studentexamresult');

        // Start a new query.
        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.stud_id' => $id, 'Studentexamresult.sect_id' => $sect, 'Studentexamresult.class_id' => $clid, 'Exams.acedamicyear' => $acedemic])->group('Studentexamresult.exam_id')->order('Exams.id ASC')->toarray();
    }



    public function findcalssteach()
    {
        $articles = TableRegistry::get('Classteachers');

        // Start a new query.
        $empid = $this->request->session()->read('Auth.User.tech_id');

        return $articles->find('all')->contain(['Classes', 'Employees', 'Sections'])->where(['teach_id' => $empid, 'teacher_type' => '1'])->first();
    }


    public function findexamsubjecttotal($id, $stud_id, $sect, $classid)
    {
        $articles = TableRegistry::get('Studentexamresult');
        // Start a new query.
        return $articles->find('all')->where(['stud_id' => $stud_id, 'class_id' => $classid, 'sect_id' => $sect, 'exam_id' => $id])->toArray();
    }


    public function findsecti($id)
    {
        $articles = TableRegistry::get('Sections');

        // Start a new query.
        return $articles->find('all')->where(['Sections.id' => $id])->first();
    }
    public function findclass($id = null)
    {
        $articles = TableRegistry::get('Classes');

        // Start a new query.
        return $articles->find('all')->where(['Classes.id' => $id])->first();
    }
    public function findclasses($id)
    {
        $articles = TableRegistry::get('Classes');

        // Start a new query.
        return $articles->find('all')->select(['id', 'title'])->where(['id' => $id])->toArray();
    }

    public function findclassesdesc($id)
    {
        $articles = TableRegistry::get('Classections');
        // Start a new query.
        return $articles->find('all')->contain(['Classes', 'Sections'])->where(['Classes.id' => $id])->order(['Sections.title' => 'ASC'])->toArray();
    }

    public function findclassesdescrt($h)
    {

        $articles = TableRegistry::get('Classections');

        // Start a new query.
        return $articles->find('all')->contain(['Classes', 'Sections'])->where(['Classections.class_id' => $h])->order(['Classes.sort' => 'ASC'])->toArray();
    }

    public function findsections($id)
    {
        $articles = TableRegistry::get('Sections');

        // Start a new query.
        return $articles->find('all')->select(['id', 'title'])->where(['id' => $id])->order(['title' => 'Asc'])->toArray();
    }

    public function findsectionsss($id = null)
    {
        $articles = TableRegistry::get('Sections');

        // Start a new query.
        return $articles->find('all')->select(['id', 'title'])->where(['id' => $id])->order(['title' => 'Asc'])->first();
    }

    public function findstates($id)
    {
        $articles = TableRegistry::get('States');

        // Start a new query.
        return $articles->find('all')->select(['id', 'name'])->where(['id' => $id])->toArray();
    }

    public function findcountries($id)
    {
        $articles = TableRegistry::get('Country');

        // Start a new query.
        return $articles->find('all')->select(['id', 'name'])->where(['id' => $id])->toArray();
    }

    public function findmode($id)
    {
        $articles = TableRegistry::get('Modes');

        // Start a new query.
        return $articles->find('all')->where(['Modes.id' => $id])->first();
    }

    public function findstudents($id)
    {
        $articles = TableRegistry::get('Students');

        // Start a new query.
        return $articles->find('all')->where(['Students.id' => $id, 'Students.status' => 'Y'])->contain(['Classes', 'Sections'])->first()->toArray();
    }
    public function finddepartment($id)
    {
        $articles = TableRegistry::get('Departments');
        // Start a new query.
        return $articles->find('all')->where(['Departments.id' => $id])->toArray();
    }

    public function finddesignation($id)
    {
        $articles = TableRegistry::get('Designations');

        // Start a new query.
        return $articles->find('all')->where(['Designations.id' => $id])->toArray();
    }
    public function findamountmonth($id, $a_year)
    {
        $articles = TableRegistry::get('Classfee');
        $m = date('Y-m-d');
        // Start a new query.

        return $articles->find('all')->contain(['Classes'])->select(['qu4_fees' => $articles->find()->func()->sum('Classfee.qu4_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'DATE(Classfee.qu4_date) <=' => $m])->order(['Classfee.id' => 'ASC'])->first()->toArray();
    }
    public function findamount3month($id, $a_year)
    {
        $articles = TableRegistry::get('Classfee');
        $m = date('Y-m-d');
        // Start a new query.

        return $articles->find('all')->contain(['Classes'])->select(['qu3_fees' => $articles->find()->func()->sum('Classfee.qu3_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'DATE(Classfee.qu3_date) <=' => $m])->order(['Classfee.id' => 'ASC'])->first()->toArray();
    }
    public function findamount2month($id, $a_year)
    {
        $articles = TableRegistry::get('Classfee');
        $m = date('Y-m-d');
        // Start a new query.

        return $articles->find('all')->contain(['Classes'])->select(['qu2_fees' => $articles->find()->func()->sum('Classfee.qu2_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'DATE(Classfee.qu2_date) <=' => $m])->order(['Classfee.id' => 'ASC'])->first()->toArray();
    }

    public function findamount1month($id, $a_year)
    {


        $articles = TableRegistry::get('Classfee');
        $m = date('Y-m-d');
        // Start a new query.

        return $articles->find('all')->contain(['Classes'])->select(['qu1_fees' => $articles->find()->func()->sum('Classfee.qu1_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'DATE(Classfee.qu2_date) <=' => $m])->order(['Classfee.id' => 'ASC'])->first()->toArray();
    }

    public function findamountallmonth($id, $a_year)
    {
        $articles = TableRegistry::get('Classfee');
        $m = date('Y-m-d');
        // Start a new query.

        return $articles->find('all')->contain(['Classes'])->select(['qu1_fees', 'qu2_fees', 'qu3_fees', 'qu4_fees', 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'Classfee.fee_h_id' => '2'])->order(['Classfee.id' => 'ASC'])->first();
    }

    // sanjay code 23-jan-2023

    public function findamountadmission($id, $a_year)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Classfee');
        $m = date('Y-m-d');
        // Start a new query.

        return $articles->find('all')->contain(['Classes'])->select(['qu1_fees', 'qu2_fees', 'qu3_fees', 'qu4_fees', 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'Classfee.fee_h_id' => '3'])->order(['Classfee.id' => 'ASC'])->first();
    }





    public function findamount($id, $a_year)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Classfee');

        // Start a new query.

        return $articles->find('all')->contain(['Classes'])->group('Classfee.academic_year')->group('Classfee.class_id')->select([
            'qu1_fees' => $articles->find()->func()->sum('Classfee.qu1_fees'),
            'qu2_fees' => $articles->find('all')->func()->sum('Classfee.qu2_fees'),
            'qu3_fees' => $articles->find('all')->func()->sum('Classfee.qu3_fees'),
            'qu4_fees' => $articles->find('all')->func()->sum('Classfee.qu4_fees'),
            'Classes.title',
            'Classfee.academic_year',
            'Classfee.id',
            'Classfee.status',
            'Classfee.class_id',
        ])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year])->order(['Classfee.id' => 'ASC'])->toArray();
    }

    public function findamountwithoutclass($a_year)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Classfee');

        // Start a new query.

        return $articles->find('all')->contain(['Classes'])->group('Classfee.academic_year')->group('Classfee.class_id')->select([
            'qu1_fees' => $articles->find()->func()->sum('Classfee.qu1_fees'),
            'qu2_fees' => $articles->find('all')->func()->sum('Classfee.qu2_fees'),
            'qu3_fees' => $articles->find('all')->func()->sum('Classfee.qu3_fees'),
            'qu4_fees' => $articles->find('all')->func()->sum('Classfee.qu4_fees'),
            'Classes.title',
            'Classfee.academic_year',
            'Classfee.id',
            'Classfee.status',
            'Classfee.class_id',
        ])->where(['Classfee.academic_year' => $a_year])->order(['Classfee.id' => 'ASC'])->toArray();
    }

    public function findfeeheadsamountpre($acedmiclassid, $a_year, $feeheads)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Classfee');

        // Start a new query.

        return $articles->find('all')->contain(['Classes'])->where(['Classfee.academic_year' => $a_year, 'Classfee.class_id' => $acedmiclassid, 'Classfee.fee_h_id' => $feeheads])->order(['Classfee.fee_h_id' => 'DESC'])->toarray();
    }

    public function findfeeheadsamount($id, $a_year, $feeheads)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Classfee');

        // Start a new query.

        return $articles->find('all')->contain(['Classes'])->group('Classfee.academic_year')->group('Classfee.class_id')->select([
            'qu1_fees' => $articles->find()->func()->sum('Classfee.qu1_fees'),
            'qu2_fees' => $articles->find('all')->func()->sum('Classfee.qu2_fees'),
            'qu3_fees' => $articles->find('all')->func()->sum('Classfee.qu3_fees'),
            'qu4_fees' => $articles->find('all')->func()->sum('Classfee.qu4_fees'),
            'Classes.title',
            'Classfee.academic_year',
            'Classfee.id',
            'Classfee.status',
            'Classfee.class_id',
        ])->where(['Classfee.class_id' => $id, 'Classfee.fee_h_id' => $feeheads, 'Classfee.academic_year' => $a_year])->order(['Classfee.id' => 'ASC'])->toArray();
    }

    public function findfeeheadsname($id)
    {

        $articles = TableRegistry::get('Feesheads');
        return $articles->find('all')->where(['Feesheads.id' => $id])->first();
    }
    public function findfeeheadsid($name)
    {

        $articles = TableRegistry::get('Feesheads');
        return $articles->find('all')->where(['Feesheads.name' => $name])->first();
    }

    public function findpendingrefrencefee($id, $amt)
    {

        $articles = TableRegistry::get('Studentfeepending');
        return $articles->find('all')->where(['Studentfeepending.r_id' => $id, 'Studentfeepending.amt LIKE' => $amt . "%"])->first();
    }

    public function findpendingrefrencefees($id, $amt)
    {

        $articles = TableRegistry::get('Studentfeepending');
        return $articles->find('all')->where(['Studentfeepending.r_id' => $id, 'Studentfeepending.status' => 'Y', 'Studentfeepending.amt LIKE' => $amt . "%"])->first();
    }

    public function findpendingrefrencefees235($id, $amt)
    {

        $articles = TableRegistry::get('Studentfeepending');
        return $articles->find('all')->where(['Studentfeepending.r_id' => $id, 'Studentfeepending.status' => 'Y', 'Studentfeepending.amt >=' => '0', 'Studentfeepending.amt LIKE' => $amt . "%"])->first();
    }

    public function findpendingrefrencefees236($id, $amt)
    {

        $articles = TableRegistry::get('Studentfeepending');
        return $articles->find('all')->where(['Studentfeepending.r_id' => $id, 'Studentfeepending.status' => 'Y', 'Studentfeepending.amt <' => '0', 'Studentfeepending.amt LIKE' => $amt . "%"])->first();
    }

    public function findpendingrefrencefees23($id)
    {

        $articles = TableRegistry::get('Studentfeepending');
        return $articles->find('all')->where(['Studentfeepending.r_id' => $id])->first();
    }
    public function findfeeheadsnamefirst($id)
    {

        $articles = TableRegistry::get('Feesheads');
        return $articles->find('all')->where(['Feesheads.name' => $id])->first();
    }

    public function findfeeheadsaliasfirst($name)
    {

        $articles = TableRegistry::get('Feesheads');
        return $articles->find('all')->where(['Feesheads.name LIKE' => $name])->first();
    }

    public function findclassfee($id, $a_year)
    {

        $articles = TableRegistry::get('Classfee');
        return $articles->find('all')->contain(['Classes'])->group('Classfee.academic_year')->group('Classfee.class_id')->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year])->order(['Classfee.id' => 'ASC'])->first();
    }


    public function studentfeesget($student_id = null, $academic_year = null)
    {

        $studentfeesdetails = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $student_id, 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y', 'Studentfees.acedmicyear' => $academic_year])->toarray();
        $alldiscount = 0;
        $allDeposite = 0;
        foreach ($studentfeesdetails as $k => $value) {
            // pr($value);die;
            $quas[] = unserialize($value['quarter']);
            $alldiscount += $value['discount'];
            $alldiscount += $value['addtionaldiscount'];
            $quas[$k]['deposite_amt'] = $value['deposite_amt'];
        }
        foreach ($quas as $key => $val) {
            $data_keys = array_keys($val);
            // pr($data_keys);
            foreach ($data_keys as $valddd) {
                if ($valddd == 'deposite_amt') {
                    continue;
                }
                $lst_st_data[$valddd] = round($val['deposite_amt'] / (count($data_keys) - 1));
                // $lst_st_data[$valddd]   =  $val[$valddd]/(count($data_keys)-1);
            }
            $allDeposite += $val['deposite_amt'];
        }
        $lst_st_data['totalDeposite'] = $allDeposite;
        $lst_st_data['discount'] = $alldiscount;
        $discount_cat = ($value['discountcategory'] == '') ? 'Additional Discount' : $value['discountcategory'];
        $lst_st_data['discountcategory'] = preg_replace('/\s+/', '', $discount_cat);
        return $lst_st_data;
    }

    // Get student fees details 
    public function getstudentfeesdetails($studentData)
    {

        $classfee_articles = TableRegistry::get('Classfee');
        $Studentfees_articles = TableRegistry::get('Studentfees');

        $classfee = $classfee_articles->find('all')->contain(['Feesheads'])->where(['Classfee.class_id' => $studentData['class_id'], 'Classfee.academic_year' => $studentData['acedmicyear'], 'Feesheads.type IN' => [1, 2]])->order(['Feesheads.type' => 'asc'])->toarray();

        $addmissiontimehead = $classfee_articles->find('all')->contain(['Feesheads'])->where(['Classfee.class_id' => $studentData['class_id'], 'Classfee.academic_year' => $studentData['acedmicyear'], 'Feesheads.type IN' => [2]])->order(['Feesheads.type' => 'asc'])->toarray();
        // pr($addmissiontimehead);exit;



        // ******************Fees Deposite start************************
        $studentfeesdetails = $Studentfees_articles->find('all')->where(['Studentfees.student_id' => $studentData['id'], 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y', 'Studentfees.acedmicyear' => $studentData['acedmicyear']])->toarray();
        $alldiscount = 0;
        $allDeposite = 0;
        foreach ($studentfeesdetails as $k => $value) {
            $quas[] = unserialize($value['quarter']);
            $alldiscount += $value['discount'];
            $alldiscount += $value['addtionaldiscount'];
            $quas[$k]['deposite_amt'] = $value['deposite_amt'];
        }
        foreach ($quas as $key => $val) {
            $data_keys = array_keys($val);
            foreach ($data_keys as $valddd) {
                if ($valddd == 'deposite_amt') {
                    continue;
                }
                $lst_st_data[$valddd] = round($val['deposite_amt'] / (count($data_keys) - 1));
                // $lst_st_data[$valddd]   =  $val[$valddd]/(count($data_keys)-1);
            }
            $allDeposite += $val['deposite_amt'];
        }
        $lst_st_data['totalDeposite'] = $allDeposite;
        $lst_st_data['discount'] = $alldiscount;
        $discount_cat = ($value['discountcategory'] == '') ? 'Additional Discount' : $value['discountcategory'];
        $lst_st_data['discountcategory'] = preg_replace('/\s+/', '', $discount_cat);
        $student_fees_record = $lst_st_data;
        // **********************Fees Deposite end********************



        if ($studentData['batch'] > '2022-23') {

            // Minus Hostal fees and Hostal Cousation  money also 
            $totalDepositefee = $student_fees_record['totalDeposite'];
            if (array_key_exists("Hostel Caution Money", $student_fees_record)) {
                $totalDepositefee = $totalDepositefee - $student_fees_record['Hostel Charges ( 2 Beded )'];
            } else if (array_key_exists("Hostel Charges ( 2 Beded )", $student_fees_record)) {
                $totalDepositefee = $totalDepositefee - $student_fees_record['Hostel Charges ( 2 Beded )'];
            } else if (array_key_exists("Hostel Charges ( 3 Beded )", $student_fees_record)) {
                $totalDepositefee = $totalDepositefee - $student_fees_record['Hostel Charges ( 3 Beded )'];
            }

            // Admission_fees
            $admission_fees = $addmissiontimehead[0]['qu1_fees'];
            //Collage Caution Money
            $collage_caution_fees = $addmissiontimehead[1]['qu1_fees'];
            // Uniform
            $Uniform = $addmissiontimehead[2]['qu1_fees'];
            // Books Fees
            $Books = $addmissiontimehead[3]['qu1_fees'];
            // Pocket Articles
            $pocketArticles = $addmissiontimehead[4]['qu1_fees'];
            // Library Fees
            $libraryFees = $addmissiontimehead[5]['qu1_fees'];
            // Enrollment Fees
            $enrollmentFees = $addmissiontimehead[6]['qu1_fees'];
            // Enrollment Fees
            $healthInsurance = $addmissiontimehead[7]['qu1_fees'];

            $idCard = $addmissiontimehead[8]['qu1_fees'];



            if ($studentData['section_id'] == 1) {
                $tution_fees = $classfee[0]['qu1_fees'];
                $transport_fees_total = $classfee[1]['qu1_fees'];
            } else if ($studentData['section_id'] == 2) {
                $tution_fees = $classfee[0]['qu1_fees'] + $classfee[0]['qu2_fees'];
                $transport_fees_total = $classfee[1]['qu1_fees'] + $classfee[1]['qu2_fees'];
            } else if ($studentData['section_id'] == 3) {
                $tution_fees = $classfee[0]['qu1_fees'] + $classfee[0]['qu2_fees'] + $classfee[0]['qu3_fees'];
                $transport_fees_total = $classfee[1]['qu1_fees'] + $classfee[1]['qu2_fees'] + $classfee[1]['qu3_fees'];
            } else if ($studentData['section_id'] == 4) {
                $tution_fees = $classfee[0]['qu1_fees'] + $classfee[0]['qu2_fees'] + $classfee[0]['qu3_fees'] + $classfee[0]['qu4_fees'];
                $transport_fees_total = $classfee[1]['qu1_fees'] + $classfee[1]['qu2_fees'] + $classfee[1]['qu3_fees'] + $classfee[1]['qu4_fees'];
            } else {
                $tution_fees = 'N/A';
            }

            if (!empty($student_fees_record['discount'] || $student_fees_record['addtionaldiscount'])) {

                if (!empty($student_fees_record['discount'])) {
                    $student_rec['discount'] = $student_fees_record['discount'];
                } else if (!empty($student_fees_record['addtionaldiscount'])) {
                    $student_rec['discount'] = $student_fees_record['addtionaldiscount'];
                }
            } else {
                $student_rec['discount'] = 0;
            }

            if ($studentData['is_transport'] == 'Y') {
                $student_rec['totalFeesToPay'] = $tution_fees + $admission_fees + $collage_caution_fees + $Uniform + $Books + $pocketArticles + $libraryFees + $enrollmentFees + $healthInsurance + $transport_fees_total + $idCard;
            } else if ($student_fees_record['Transport1'] || $student_fees_record['Transport2'] || $student_fees_record['Transport3'] || $student_fees_record['Transport4']) {
                $transport_fees_total = 0;
                if ($student_fees_record['Transport1']) {
                    $transport_fees_total += $classfee[1]['qu1_fees'];
                } else if ($student_fees_record['Transport2']) {
                    $transport_fees_total += $classfee[1]['qu2_fees'];
                } else if ($student_fees_record['Transport3']) {
                    $transport_fees_total += $classfee[1]['qu3_fees'];
                } else if ($student_fees_record['Transport4']) {
                    $transport_fees_total += $classfee[1]['qu4_fees'];
                }

                $student_rec['totalFeesToPay'] = $tution_fees + $admission_fees + $collage_caution_fees + $Uniform + $Books + $pocketArticles + $libraryFees + $enrollmentFees + $healthInsurance + $transport_fees_total + $idCard;
            } else {
                $student_rec['totalFeesToPay'] = $tution_fees + $admission_fees + $collage_caution_fees + $Uniform + $Books + $pocketArticles + $libraryFees + $enrollmentFees + $healthInsurance + $idCard;
            }

            $student_rec['totalFeesPay'] = $totalDepositefee;
            $student_rec['totalPending'] = $student_rec['totalFeesToPay'] - $totalDepositefee - $student_rec['discount'];
        } else {

            $student_rec['totalFeesToPay'] = 'N/A';
            $student_rec['totalFeesPay'] = 'N/A';
            $student_rec['discount'] = 'N/A';
            $student_rec['totalPending'] = (empty($studentData['due_fees'])) ? 0 : $studentData['due_fees'];
        }

        return $student_rec;
    }

    public function findpaidamount($a_year)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.
        return $articles->find('all')->contain(['Students'])->where(['Studentfees.acedmicyear' => $a_year, 'Studentfees.status' => 'Y', 'Students.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
    }

    public function findpaidamounts($a_year, $datefrom, $dateto)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.

        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));

        $rolepresent = $this->request->session()->read('Auth.User.role_id');

        if ($rolepresent == '5') {

            return $articles->find('all')->contain(['Students'])->where(['Studentfees.acedmicyear' => $a_year, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.paydate <=' => $dateto, 'Students.class_id IN' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '30', '31'], 'Studentfees.status' => 'Y', 'Students.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        } else if ($rolepresent == '8') {

            return $articles->find('all')->contain(['Students'])->where(['Studentfees.acedmicyear' => $a_year, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.paydate <=' => $dateto, 'Students.class_id IN' => ['23', '24', '25', '26', '27', '28', '29'], 'Studentfees.status' => 'Y', 'Students.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        } else {

            return $articles->find('all')->contain(['Students'])->where(['Studentfees.acedmicyear' => $a_year, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.paydate <=' => $dateto, 'Studentfees.status' => 'Y', 'Students.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        }
    }

    public function findpaidamountsmode2($a_year, $datefrom, $dateto, $mode)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.

        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));

        $rolepresent = $this->request->session()->read('Auth.User.role_id');

        if ($rolepresent == '5') {

            return $articles->find('all')->contain(['DropOutStudent'])->where(['Studentfees.acedmicyear' => $a_year, 'Studentfees.mode' => $mode, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate <=' => $dateto, 'DropOutStudent.class_id IN' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '30', '31'], 'Studentfees.status' => 'Y', 'DropOutStudent.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        } else if ($rolepresent == '8') {

            return $articles->find('all')->contain(['DropOutStudent'])->where(['Studentfees.acedmicyear' => $a_year, 'Studentfees.mode' => $mode, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate <=' => $dateto, 'DropOutStudent.class_id IN' => ['23', '24', '25', '26', '27', '28', '29'], 'Studentfees.status' => 'Y', 'DropOutStudent.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        } else {

            return $articles->find('all')->contain(['DropOutStudent'])->where(['Studentfees.acedmicyear' => $a_year, 'Studentfees.mode' => $mode, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.paydate <=' => $dateto, 'Studentfees.status' => 'Y', 'DropOutStudent.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        }
    }

    public function findpaidamountsmode2y($a_year, $datefrom, $dateto, $mode)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.

        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));

        $rolepresent = $this->request->session()->read('Auth.User.role_id');

        if ($rolepresent == '5' || $rolepresent == '6') {

            return $articles->find('all')->contain(['DropOutStudent'])->where(['Studentfees.mode' => $mode, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate <=' => $dateto, 'DropOutStudent.class_id IN' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '30', '31'], 'Studentfees.status' => 'Y', 'DropOutStudent.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        } else if ($rolepresent == '8') {

            return $articles->find('all')->contain(['DropOutStudent'])->where(['Studentfees.mode' => $mode, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate <=' => $dateto, 'DropOutStudent.class_id IN' => ['23', '24', '25', '26', '27', '28', '29'], 'Studentfees.status' => 'Y', 'DropOutStudent.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        } else {

            return $articles->find('all')->contain(['DropOutStudent'])->where(['Studentfees.mode' => $mode, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.paydate <=' => $dateto, 'Studentfees.status' => 'Y', 'DropOutStudent.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        }
    }
    public function findpaidamountsmode2s($a_year, $datefrom, $dateto, $mode)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.

        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));

        $rolepresent = $this->request->session()->read('Auth.User.role_id');

        if ($rolepresent == '5') {

            return $articles->find('all')->contain(['DropOutStudent'])->where(['Studentfees.acedmicyear' => $a_year, 'Studentfees.mode' => $mode, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate <=' => $dateto, 'DropOutStudent.class_id IN' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '30', '31'], 'Studentfees.status' => 'Y', 'DropOutStudent.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        } else if ($rolepresent == '8') {

            return $articles->find('all')->contain(['DropOutStudent'])->where(['Studentfees.acedmicyear' => $a_year, 'Studentfees.mode' => $mode, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate <=' => $dateto, 'DropOutStudent.class_id IN' => ['23', '24', '25', '26', '27', '28', '29'], 'Studentfees.status' => 'Y', 'DropOutStudent.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        } else {

            return $articles->find('all')->contain(['DropOutStudent'])->where(['Studentfees.acedmicyear' => $a_year, 'Studentfees.mode' => $mode, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.paydate <=' => $dateto, 'Studentfees.status' => 'Y', 'DropOutStudent.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        }
    }

    public function findpaidamountsmode24s($a_year, $datefrom, $dateto, $mode)
    {
        // pr ($mode); 

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.

        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));

        $rolepresent = $this->request->session()->read('Auth.User.role_id');

        if ($rolepresent == '5' || $rolepresent == '6') {

            return $articles->find('all')->contain(['DropOutStudent'])->where(['Studentfees.mode' => $mode, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate <=' => $dateto, 'DropOutStudent.class_id IN' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '30', '31'], 'Studentfees.status' => 'Y', 'DropOutStudent.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        } else if ($rolepresent == '8') {

            return $articles->find('all')->contain(['DropOutStudent'])->where(['Studentfees.mode' => $mode, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate <=' => $dateto, 'DropOutStudent.class_id IN' => ['23', '24', '25', '26', '27', '28', '29'], 'Studentfees.status' => 'Y', 'DropOutStudent.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        } else {

            return $articles->find('all')->contain(['DropOutStudent'])->where(['Studentfees.mode' => $mode, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.paydate <=' => $dateto, 'Studentfees.status' => 'Y', 'DropOutStudent.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        }
    }

    public function findpaidamountsmode($a_year, $datefrom, $dateto, $mode)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.

        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));

        $rolepresent = $this->request->session()->read('Auth.User.role_id');

        if ($rolepresent == '5') {

            return $articles->find('all')->contain(['Students'])->where(['Studentfees.acedmicyear' => $a_year, 'Studentfees.mode' => $mode, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate <=' => $dateto, 'Students.class_id IN' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '30', '31'], 'Studentfees.status' => 'Y', 'Students.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        } else if ($rolepresent == '8') {

            return $articles->find('all')->contain(['Students'])->where(['Studentfees.acedmicyear' => $a_year, 'Studentfees.mode' => $mode, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate <=' => $dateto, 'Students.class_id IN' => ['23', '24', '25', '26', '27', '28', '29'], 'Studentfees.status' => 'Y', 'Students.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        } else {

            return $articles->find('all')->contain(['Students'])->where(['Studentfees.acedmicyear' => $a_year, 'Studentfees.mode' => $mode, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.paydate <=' => $dateto, 'Studentfees.status' => 'Y', 'Students.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        }
    }

    public function findpaidmode($datefrom, $dateto, $mode, $el)
    {
        // Formatted data:
        $articles = TableRegistry::get('Studentfees');

        // Start a new query.

        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));

        return $articles->find('all')->where(['Studentfees.mode' => $mode, 'Studentfees.type' => $el, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate <=' => $dateto, 'Studentfees.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
    }

    public function findpaidamountsmodety($a_year, $datefrom, $dateto, $mode)
    {

        $articles = TableRegistry::get('Studentfees');
        // Start a new query.
        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));
        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        // pr($rolepresent);exit;
        if ($rolepresent == '5' || $rolepresent == '6') {
            // echo "sanjay"; 
            return $articles->find('all')->contain(['Students'])->where(['Studentfees.mode IN' => $mode, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate <=' => $dateto, 'Students.class_id IN' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '30', '31'], 'Studentfees.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        } else if ($rolepresent == '8') {

            return $articles->find('all')->contain(['Students'])->where(['Studentfees.mode' => $mode, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate <=' => $dateto, 'Students.class_id IN' => ['23', '24', '25', '26', '27', '28', '29'], 'Studentfees.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        } else {

            return $articles->find('all')->contain(['Students'])->where(['Studentfees.mode' => $mode, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.paydate <=' => $dateto, 'Studentfees.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        }
    }

    public function findpaidamountsack($a_year, $dateto)
    {

        $articles = TableRegistry::get('Studentfees');

        $dateto = date('Y-m-d', strtotime($dateto));
        return $articles->find('all')->contain(['Students'])->where(['Studentfees.student_id' => $a_year, 'Studentfees.paydate <=' => $dateto, 'Studentfees.status' => 'Y', 'Students.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toarray();
    }

    public function findpaidamountsack23($a_year, $dateto, $acedmic)
    {

        $articles = TableRegistry::get('Studentfees');

        $dateto = date('Y-m-d', strtotime($dateto));
        return $articles->find('all')->contain(['Students'])->where(['Studentfees.student_id' => $a_year, 'Studentfees.acedmicyear' => $acedmic, 'Studentfees.paydate <=' => $dateto, 'Studentfees.status' => 'Y', 'Students.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toarray();
    }

    public function findpaidamountsackquater23($a_year, $dateto, $q, $acedmic)
    {

        $articles = TableRegistry::get('Studentfees');

        $dateto = date('Y-m-d', strtotime($dateto));
        return $articles->find('all')->select(['Studentfees.discountcategory'])->contain(['Students'])->where(['Studentfees.student_id' => $a_year, 'Studentfees.acedmicyear' => $acedmic, 'Studentfees.paydate <=' => $dateto, 'Studentfees.status' => 'Y', 'Studentfees.quarter LIKE "%' . $q . '%"', 'Studentfees.recipetno !=' => 0, 'Students.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->first();
    }

    public function finddisountstudent($stid, $a_year)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.
        return $articles->find('all')->where(['Studentfees.student_id' => $stid, 'Studentfees.acedmicyear' => $a_year, 'Studentfees.recipetno !=' => 0, 'Studentfees.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
    }

    public function finddisountany($stid)
    {

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.
        return $articles->find('all')->select(['Studentfees.discountcategory'])->where(['Studentfees.student_id' => $stid, 'Studentfees.recipetno !=' => 0, 'Studentfees.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
    }

    public function findfeemonthstudent($stid)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.
        return $articles->find('all')->select(['Studentfees.paydate'])->where(['Studentfees.student_id' => $stid, 'Studentfees.status' => 'Y'])->order(['Studentfees.id' => 'DESC'])->first();
    }

    public function findstudentcount($id, $a_year, $section_id)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Students');

        // Start a new query.
        return $articles->find('all')->where(['Students.acedmicyear' => $a_year, 'Students.status' => 'Y', 'Students.class_id' => $id, 'Students.section_id' => $section_id, 'Students.status' => 'Y'])->count();
    }

    public function findstudentcountclass($class_id, $section_id)
    {

        $articles = TableRegistry::get('Students');
        $getterm = $this->findacedemicyears('1');
        return $articles->find('all')->where(['Students.acedmicyear' => $getterm['academic_year'], 'Students.status' => 'Y', 'Students.section_id' => $section_id, 'Students.class_id' => $class_id, 'Students.status' => 'Y'])->count();
    }

    public function findstudentcrfidclass($class_id, $section_id)
    {

        $articles = TableRegistry::get('Students');
        $getterm = $this->findacedemicyears('1');
        return $articles->find('all')->where(['Students.acedmicyear' => $getterm['academic_year'], 'Students.rf_id !=' => '0', 'Students.section_id' => $section_id, 'Students.class_id' => $class_id, 'Students.status' => 'Y'])->count();
    }

    public function findstudentrfidclass($class_id, $section_id)
    {

        $articles = TableRegistry::get('Students');
        $getterm = $this->findacedemicyears('1');
        return $articles->find('all')->where(['Students.acedmicyear' => $getterm['academic_year'], 'Students.rf_id' => '0', 'Students.section_id' => $section_id, 'Students.class_id' => $class_id, 'Students.status' => 'Y'])->count();
    }

    public function findstudentcountwithoutclass($a_year, $section_id)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Students');

        // Start a new query.
        return $articles->find('all')->where(['Students.acedmicyear' => $a_year, 'Students.status' => 'Y', 'Students.section_id' => $section_id, 'Students.status' => 'Y'])->count();
    }

    public function findperticularamount($id, $a_year)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.
        return $articles->find('all')->select(['id', 'fee', 'discount', 'deposite_amt', 'lfine'])->where(['Studentfees.student_id' => $id, 'Studentfees.acedmicyear' => $a_year, 'Studentfees.status' => 'Y'])->toArray();
    }
    public function findtransportamount($id, $a_year)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Transportfees');

        // Start a new query.

        return $articles->find('all')->group('Transportfees.academic_year')->group('Transportfees.loc_id')->select(['qu1_fees' => $articles->find()->func()->sum('Transportfees.qu1_fees'), 'qu2_fees' => $articles->find('all')->func()->sum('Transportfees.qu2_fees'), 'qu3_fees' => $articles->find('all')->func()->sum('Transportfees.qu3_fees'), 'qu4_fees' => $articles->find('all')->func()->sum('Transportfees.qu4_fees')])->where(['Transportfees.loc_id' => $id, 'Transportfees.academic_year' => $a_year])->order(['Transportfees.id' => 'ASC'])->toArray();
    }
    public function findpaidtransportamount($id, $a_year)
    {
        $articles = TableRegistry::get('StudentTransfees');
        return $articles->find('all')->where(['StudentTransfees.student_id' => $id, 'StudentTransfees.acedmicyear' => $a_year])->toArray();
    }

    public function findroute($id)
    {
        $articles = TableRegistry::get('Transports');

        //  $arrayOfIds =['3'];
        return $articles->find('all')->where(['FIND_IN_SET(\'' . $id . '\',Transports.route)'])->toarray();
    }

    public function findhostalfeed($h_id)
    {
        $articles = TableRegistry::get('Hostels');

        return $articles->find('all')->where(['Hostels.id' => $h_id])->first()->toArray();
    }

    public function findexamtypename($id)
    {
        $articles = TableRegistry::get('Examtypes');
        return $articles->find('all')->where(['Examtypes.parent_id' => $id])->toarray();
    }

    public function finddisounthostal($s_id, $a_year, $h_id)
    {
        $articles = TableRegistry::get('StudentHostalfees');
        return $articles->find('all')->where(['StudentHostalfees.student_id' => $s_id, 'StudentHostalfees.acedmicyear' => $a_year, 'StudentHostalfees.h_id' => $h_id])->toArray();
    }
    public function findhostelamount($s_id, $a_year, $h_id)
    {
        $articles = TableRegistry::get('StudentHostalfees');
        return $articles->find('all')->where(['StudentHostalfees.student_id' => $s_id, 'StudentHostalfees.acedmicyear' => $a_year, 'StudentHostalfees.h_id' => $h_id])->toArray();
    }

    //------------------------------------------------------------
    public function issuedCount($book_id = null)
    {
        if (!empty($book_id)) {
            $issued_count = TableRegistry::get('BookCopyDetail');

            return $issued_count->find('all')->where([
                'BookCopyDetail.book_id' => $book_id,
                'OR' => [
                    ['BookCopyDetail.status' => 'Issued'],
                    ['BookCopyDetail.status' => 'Renew']
                ]
            ])->count();
        } else {
            return 'N/A';
        }
    }

    public function find_holder_detail($asn = null, $bid = null)
    {
        $articles = TableRegistry::get('library_issue_books');
        return $articles->find('all')->select(['holder_name', 'holder_type_id', 'holder_id'])->where(['library_issue_books.asn_no' => $asn, 'library_issue_books.status' => 'Y', 'library_issue_books.board' => $bid])->first();
    }

    public function findstudentname1($id = null, $bid = null)
    {
        $articles = TableRegistry::get('Students');
        return $articles->find('all')->contain(['Classes', 'Sections'])->where(['Students.enroll' => $id, 'Students.board_id' => $bid, 'Students.status' => 'Y'])->first();
    }

    public function findperiodicityname($id = null)
    {
        $articles = TableRegistry::get('Periodicity');
        return $articles->find()->select(['name'])->where(['Periodicity.id' => $id])->first();
    }

    public function findperiodicalmaster($id = null)
    {
        $articles = TableRegistry::get('PeriodicalMaster');
        return $articles->find()->where(['PeriodicalMaster.id' => $id])->first();
    }

    public function findperiodicalvoiume($pid)
    {
        $articles = TableRegistry::get('Book');
        return $articles->find()->where(['Book.periodic_category_id' => $pid])->count();
    }

    public function findperidetail($id = null)
    {
        $articles = TableRegistry::get('PeriodicalMasterDetails');
        return $articles->find()->contain(['PeriodicalMaster'])->where(['PeriodicalMasterDetails.periodic_id' => $id])->order(['PeriodicalMasterDetails.id' => 'DESC'])->first();
    }

    public function findcupboardname($id = null)
    {
        $articles = TableRegistry::get('CupBoard');
        return $articles->find()->select(['id', 'name'])->where(['CupBoard.id' => $id])->first();
    }

    public function findshelfname($id = null)
    {
        $articles = TableRegistry::get('CupBoardShelf');
        return $articles->find()->select(['id', 'name'])->where(['CupBoardShelf.id' => $id])->first();
    }
    public function fsubjectmarks($exid = null, $sid = null, $section = null, $classid = null, $rs = null)
    {
        $articles = TableRegistry::get('Studentexamresult');
        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.exam_id' => $exid, 'Studentexamresult.class_id' => $classid, 'Studentexamresult.stud_id' => $sid, 'Studentexamresult.etype_id' => $rs, 'Studentexamresult.sect_id' => $section])->group(['Studentexamresult.subject_id'])->order(['Studentexamresult.id' => 'asc']);
    }

    public function fsubjectonly($exid = null, $section = null, $classid = null)
    {
        $articles = TableRegistry::get('Studentexamresult');

        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.exam_id' => $exid, 'Studentexamresult.class_id' => $classid, 'Studentexamresult.sect_id' => $section])->group(['Studentexamresult.subject_id'])->order(['Studentexamresult.id' => 'asc'])->toarray();
    }

    public function fsubjectmarksteachers($exid = null, $sid = null, $section = null, $classid = null, $se = null)
    {
        $teach_id = $this->request->session()->read('Auth.User.tech_id');
        $articles = TableRegistry::get('Studentexamresult');
        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.exam_id' => $exid, 'Studentexamresult.class_id' => $classid, 'Studentexamresult.stud_id' => $sid, 'Studentexamresult.teach_id' => $teach_id, 'Studentexamresult.etype_id' => $se, 'Studentexamresult.sect_id' => $section])->group(['Studentexamresult.subject_id'])->order(['Studentexamresult.id' => 'asc'])->toarray();
    }

    public function fsubjectmarksteachers212($exid = null, $sid = null, $section = null, $classid = null, $se = null)
    {
        $teach_id = $this->request->session()->read('Auth.User.tech_id');
        $articles = TableRegistry::get('Studentexamresult');
        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.exam_id' => $exid, 'Studentexamresult.class_id' => $classid, 'Studentexamresult.stud_id' => $sid, 'Studentexamresult.etype_id' => $se, 'Studentexamresult.sect_id' => $section])->group(['Studentexamresult.subject_id'])->order(['Studentexamresult.id' => 'asc'])->toarray();
    }

    public function fsubjectmarksteachers2($exid = null, $sid = null, $section = null, $classid = null, $se = null, $subj = null)
    {
        $teach_id = $this->request->session()->read('Auth.User.tech_id');
        $articles = TableRegistry::get('Studentexamresult');
        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.exam_id' => $exid, 'Studentexamresult.class_id' => $classid, 'Studentexamresult.stud_id' => $sid, 'Studentexamresult.teach_id' => $teach_id, 'Studentexamresult.etype_id' => $se, 'ExamSubjects.exprint' => $subj, 'Studentexamresult.sect_id' => $section])->group(['Studentexamresult.subject_id'])->order(['Studentexamresult.id' => 'asc'])->toarray();
    }
    public function fsubjectmarksteachers21($exid = null, $sid = null, $section = null, $classid = null, $se = null, $subj = null)
    {
        $teach_id = $this->request->session()->read('Auth.User.tech_id');
        $articles = TableRegistry::get('Studentexamresult');
        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.exam_id' => $exid, 'Studentexamresult.class_id' => $classid, 'Studentexamresult.stud_id' => $sid, 'Studentexamresult.etype_id' => $se, 'ExamSubjects.exprint' => $subj, 'Studentexamresult.sect_id' => $section])->group(['Studentexamresult.subject_id'])->order(['Studentexamresult.id' => 'asc'])->toarray();
    }
    public function findexamwithsubject($id = null, $name = null)
    {
        $articles = TableRegistry::get('ExamSubjects');
        return $articles->find('all')->where(['subject' => $name, 'class_id' => $id])->order(['id' => 'ASC'])->first();
    }

    public function findexamwithsubject2($id = null, $name = null)
    {
        $articles = TableRegistry::get('ExamSubjects');
        return $articles->find('all')->where(['exprint' => $name, 'class_id' => $id])->order(['id' => 'ASC'])->first();
    }

    public function fsubjectmarksteachersbysubject($exid = null, $sid = null, $section = null, $classid = null, $rh = null, $se = null)
    {
        $teach_id = $this->request->session()->read('Auth.User.tech_id');
        $articles = TableRegistry::get('Studentexamresult');
        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.exam_id' => $exid, 'Studentexamresult.class_id' => $classid, 'Studentexamresult.stud_id' => $sid, 'Studentexamresult.subject_id' => $rh, 'Studentexamresult.etype_id' => $se, 'Studentexamresult.sect_id' => $section])->group(['Studentexamresult.subject_id'])->order(['Studentexamresult.id' => 'asc']);
    }

    public function fsubjectonlyteachers($exid = null, $section = null, $classid = null)
    {
        $articles = TableRegistry::get('Studentexamresult');
        $teach_id = $this->request->session()->read('Auth.User.tech_id');
        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.exam_id' => $exid, 'Studentexamresult.class_id' => $classid, 'Studentexamresult.sect_id' => $section, 'Studentexamresult.teach_id' => $teach_id])->group(['Studentexamresult.subject_id'])->order(['Studentexamresult.id' => 'asc'])->toarray();
    }

    public function fsubjectonlyteachers2($exid = null, $section = null, $classid = null, $sub = null)
    {

        $articles = TableRegistry::get('Studentexamresult');
        $teach_id = $this->request->session()->read('Auth.User.tech_id');
        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.exam_id' => $exid, 'Studentexamresult.class_id' => $classid, 'Studentexamresult.sect_id' => $section, 'Studentexamresult.teach_id' => $teach_id, 'ExamSubjects.exprint' => $sub])->group(['Studentexamresult.subject_id'])->order(['Studentexamresult.id' => 'asc'])->toarray();
    }

    public function fsubjectonlyteachersbysubject($exid = null, $section = null, $classid = null, $rh = null)
    {
        $articles = TableRegistry::get('Studentexamresult');

        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.exam_id' => $exid, 'Studentexamresult.class_id' => $classid, 'Studentexamresult.sect_id' => $section, 'Studentexamresult.subject_id' => $rh])->group(['Studentexamresult.subject_id'])->order(['Studentexamresult.id' => 'asc'])->toarray();
    }

    public function finddescription($id = null, $tid = null)
    {

        if ($tid == '1') {
            $articles = TableRegistry::get('Primarysubject');
            $exami = TableRegistry::get('ExamSubjects');
            $est = $articles->find()->select(['id', 'subject'])->where(['Primarysubject.primarycentral_id' => $id])->first();
            $vb = explode(',', $est['subject']);
            $sd = count($vb);
            if ($sd == '1') {
                $ecf = $exami->find()->select(['id', 'subject'])->where(['ExamSubjects.id' => $vb[0]])->first();
                return $ecf['subject'];
            } else {

                return "Extra";
            }
        } else {
            $articles = TableRegistry::get('Primarytheme');
            return $articles->find()->select(['id', 'transdistheme'])->where(['Primarytheme.primarycentral_id' => $id])->first();
        }
    }

    //7 August

    public function findexamner($class = null, $key = null)
    {
        // pr($class);
        // pr($key);die;
        $articles = TableRegistry::get('Examtypes');

        return $articles->find('all')->where(['id' => $key, 'FIND_IN_SET(\'' . $class . '\',class_id)'])->order(['sort' => 'ASC'])->first();
    }

    public function findexamner2($class = null, $key = null, $term = null)
    {
        $articles = TableRegistry::get('Examtypes');

        return $articles->find('all')->where(['id' => $key, 'term' => $term, 'FIND_IN_SET(\'' . $class . '\',class_id)'])->order(['sort' => 'ASC'])->first();
        // pr($articales);die;

    }
    public function findsubjectwithclass($id = null)
    {
        $teach_id = $this->request->session()->read('Auth.User.tech_id');
        $articles = TableRegistry::get('ClasstimeTabs');

        return $articles->find('all')->Contain(['Subjects'])->where(['ClasstimeTabs.class_id' => $id, 'FIND_IN_SET(\'' . $teach_id . '\',ClasstimeTabs.employee_id)'])->order(['ClasstimeTabs.id' => 'ASC'])->toarray();
    }
    public function findcordsubjectwithclass($id = null)
    {
        $articles = TableRegistry::get('ClasstimeTabs');

        return $articles->find('all')->Contain(['Subjects'])->where(['ClasstimeTabs.class_id' => $id])->order(['ClasstimeTabs.id' => 'ASC'])->toarray();
    }

    public function findexamwithclass($class = null)
    {

        $getterm = $this->findacedemicyears('1');

        $articles = TableRegistry::get('Exams');
        $empid = $this->request->session()->read('Auth.User.tech_id');
        if ($empid == "1228") {

            if ($getterm['examterm'] == '1') {
                return $articles->find('all')->where(['FIND_IN_SET(\'' . $class . '\',class_id)', 'termf' => $getterm['examterm']])->order(['sort' => 'ASC'])->toarray();
            } else {

                $gett = array('2', '3');
                return $articles->find('all')->where(['FIND_IN_SET(\'' . $class . '\',class_id)', 'termf IN' => $gett])->order(['sort' => 'ASC'])->toarray();
            }
        } else if ($empid == "1266") {

            if ($getterm['examterm'] == '2') {
                return $articles->find('all')->where(['FIND_IN_SET(\'' . $class . '\',class_id)', 'termf' => $getterm['examterm']])->order(['sort' => 'ASC'])->toarray();
            } else {
                $gett = array('3');
                return $articles->find('all')->where(['FIND_IN_SET(\'' . $class . '\',class_id)', 'termf IN' => $gett])->order(['sort' => 'ASC'])->toarray();
            }
        } else {

            return $articles->find('all')->where(['FIND_IN_SET(\'' . $class . '\',class_id)', 'termf' => $getterm['examterm']])->order(['sort' => 'ASC'])->toarray();
        }
    }


    public function findexamwithclassetype($key = null, $academic_year = null)
    {
        // pr($academic_year);die;

        // $getterm = $this->findacedemicyears('1');

        $articles = TableRegistry::get('Exams');

        // return $articles->find('all')->where(['FIND_IN_SET(\'' . $key . '\',e_type_id)', 'termf' => $getterm['examterm']])->order(['sort' => 'ASC'])->first();
        return $articles->find('all')->where(['FIND_IN_SET(\'' . $key . '\',e_type_id)', 'acedamicyear' => $academic_year])->order(['sort' => 'ASC'])->first();
    }
    public function findsubjectstotalssnames2($id = null)
    {

        $articles = TableRegistry::get('Examtypes');

        return $articles->find('all')->where(['Examtypes.id' => $id])->select(['name', 'id', 'maxnumber', 'examname'])->toarray();
    }

    public function findsubjectstotalssnames21($id = null)
    {

        $articles = TableRegistry::get('Examtypes');

        return $articles->find('all')->where(['Examtypes.id' => $id])->select(['name', 'id', 'maxnumber', 'examname', 'examprint'])->first();
    }

    public function finndclassection($id = null)
    {

        $articles = TableRegistry::get('Classections');

        return $articles->find('all')->contain(['Sections'])->where(['Classections.class_id' => $id])->order(['Sections.title' => 'ASC'])->toArray();
    }

    public function findroleexamtype($exid = null, $section = null, $classid = null)
    {

        $articles = TableRegistry::get('Studentexamresult');

        $teach_id = $this->request->session()->read('Auth.User.tech_id');
        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.exam_id' => $exid, 'Studentexamresult.class_id' => $classid, 'Studentexamresult.sect_id' => $section, 'Studentexamresult.teach_id' => $teach_id])->group(['Studentexamresult.etype_id'])->order(['Studentexamresult.id' => 'asc'])->toarray();
    }

    public function findroleexamtype2($exid = null, $section = null, $classid = null)
    {

        $articles = TableRegistry::get('Studentexamresult');

        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.exam_id' => $exid, 'Studentexamresult.class_id' => $classid, 'Studentexamresult.sect_id' => $section])->group(['Studentexamresult.etype_id'])->order(['Studentexamresult.id' => 'asc'])->toarray();
    }

    public function findeexamtsype($exid = null, $section = null, $classid = null)
    {

        $articles = TableRegistry::get('Studentexamresult');

        return $articles->find('all')->contain(['Exams', 'ExamSubjects'])->where(['Studentexamresult.exam_id' => $exid, 'Studentexamresult.class_id' => $classid, 'Studentexamresult.sect_id' => $section])->group(['Studentexamresult.etype_id'])->order(['Studentexamresult.id' => 'asc'])->toarray();
    }

    //9aug

    public function classspractical($id = null)
    {

        $articles = TableRegistry::get('Subjects');

        return $articles->find('all')->where(['id' => $id])->select(['id', 'name', 'is_practicalfee'])->where(['is_practicalfee !=' => 0])->first();
    }

    public function findprimarysubject($pid = null, $sid = null)
    {

        $articles = TableRegistry::get('Examstusubject');

        return $articles->find('all')->where(['primarycentral_id ' => $pid, 'student_id ' => $sid])->first();
    }

    public function findprimarytheme($pid = null, $sid = null)
    {

        $articles = TableRegistry::get('Examstutheme');

        return $articles->find('all')->where(['primarycentral_id ' => $pid, 'student_id ' => $sid])->first();
    }

    // 11-August-2018

    public function findstudenttheme($sid = null, $pid = null)
    {

        $articles = TableRegistry::get('Examstutheme');

        return $articles->find('all')->where(['Examstutheme.student_id' => $sid, 'Examstutheme.primarycentral_id' => $pid])->order(['Examstutheme.sort' => 'ASC'])->first();
    }

    public function findstudentsubject($sid = null, $pid = null)
    {

        $articles = TableRegistry::get('Examstusubject');

        return $articles->find('all')->where(['Examstusubject.student_id' => $sid, 'Examstusubject.primarycentral_id' => $pid])->order(['Examstusubject.sort' => 'ASC'])->first();
    }

    // 13-August-2018
    public function findvendorname($id = null)
    {

        $articles = TableRegistry::get('BookVendor');

        return $articles->find('all')->select(['name'])->where(['BookVendor.id' => $id])->first();
    }

    // 20-August-2018
    public function findabsenttheme($id = null)
    {

        $articles = TableRegistry::get('Examstutheme');

        return $articles->find('all')->where(['primarycentral_id ' => $pid, 'student_id ' => $sid, 'is_absent' => '0'])->count();
    }

    // 24-August-2018
    public function findtdtname($id = null)
    {

        $articles = TableRegistry::get('Primarytheme');

        return $articles->find('all')->select(['transdistheme'])->where(['Primarytheme.primarycentral_id ' => $id])->first();
    }

    public function findexamsubject($id = null)
    {

        $articles = TableRegistry::get('ExamSubjects');

        return $articles->find('all')->select(['subject'])->where(['ExamSubjects.id ' => $id])->first();
    }

    public function findemployeename($id = null)
    {

        $articles = TableRegistry::get('Employees');

        return $articles->find('all')->select(['fname', 'middlename', 'lname'])->where(['Employees.id ' => $id])->first();
    }

    // 5-sept-2018

    public function findprimaryextrasubject($pid = null, $sid = null, $fid = null)
    {

        $articles = TableRegistry::get('Examstusubject');

        return $articles->find('all')->where(['primarycentral_id ' => $pid, 'student_id ' => $sid, 'subject IN ' => $fid])->order(['sort' => 'ASC'])->toarray();
    }

    // 6-sept-2018

    public function findprimaryexam($cid = null)
    {

        $articles = TableRegistry::get('Exams');
        $getterm = $this->findacedemicyears('1');
        return $articles->find('all')->contain(['Examtypes'])->where(['FIND_IN_SET(\'' . $cid . '\',Exams.class_id)', 'Exams.acedamicyear' => $getterm['academic_year'], 'Exams.resultuploadlast_date >=' => date('Y-m-d')])->order(['Exams.id' => 'DESC'])->toarray();
    }

    public function findclasstime1221($emp = null)
    {

        $articles = TableRegistry::get('ClasstimeTabs');

        return $articles->find('all')->where(['FIND_IN_SET(\'' . $emp . '\',ClasstimeTabs.employee_id)'])->toarray();
    }

    public function findclasssection1221($cid = null)
    {

        $articles = TableRegistry::get('Classections');

        return $articles->find('all')->contain(['Classes', 'Sections'])->where(['Classections.id' => $cid])->order(['Classections.id' => 'ASC'])->first();
    }

    // 7-sept-2018

    public function findstudentsubject1345($sid = null, $pid = null)
    {

        $articles = TableRegistry::get('Examstusubject');

        return $articles->find('all')->where(['Examstusubject.student_id' => $sid, 'Examstusubject.primarycentral_id' => $pid])->order(['Examstusubject.sort' => 'ASC'])->toarray();
    }

    public function findprimaryteachersubject($tid = null, $cid = null, $sid = null)
    {

        $articles = TableRegistry::get('Primaryteacher');

        return $articles->find('all')->where(['Primaryteacher.teacher_id' => $tid, 'Primaryteacher.class_id' => $cid, 'Primaryteacher.section_id' => $sid])->toarray();
    }

    // 10 Sept

    public function findwordbanks($tid = null, $cid = null, $sid = null)
    {

        $articles = TableRegistry::get('Wordbank');

        return $articles->find('all')->where(['Wordbank.primarycentral_id' => $tid, 'Wordbank.attribute' => $cid, 'Wordbank.class_id' => $sid])->group('Wordbank.fields')->toarray();
    }
    public function findwordbanksfields($tid = null, $cid = null, $sid = null, $fileds = null)
    {

        $articles = TableRegistry::get('Wordbank');

        return $articles->find('all')->where(['Wordbank.primarycentral_id' => $tid, 'Wordbank.attribute' => $cid, 'Wordbank.class_id' => $sid, 'Wordbank.fields' => $fileds])->order(['Wordbank.sid' => 'ASC'])->toarray();
    }

    // 11 Sept

    public function findwordbanksfieldsvalue($srtid = null, $pid = null, $atid = null, $fileds = null)
    {

        $articles = TableRegistry::get('Wordbank');

        return $articles->find('all')->where(['Wordbank.primarycentral_id' => $pid, 'Wordbank.attribute' => $atid, 'Wordbank.sid' => $srtid, 'Wordbank.fields LIKE' => '%' . $fileds])->order(['Wordbank.sid' => 'ASC'])->first();
    }

    // 12 Sept

    public function findprimarystudentdetails($cid = null, $sid = null)
    {

        $articles = TableRegistry::get('Examstusubject');
        $thu = TableRegistry::get('Examstutheme');

        $a1 = $articles->find('all')->select(['student_id', 'primarycentral_id'])->contain(['Students'])->where(['Examstusubject.is_absent' => '1', 'Students.class_id' => $cid, 'Students.section_id' => $sid])->group(['Examstusubject.student_id'])->order(['Students.fname' => 'ASC'])->toarray();

        $a2 = $thu->find('all')->select(['student_id', 'primarycentral_id'])->contain(['Students'])->where(['Examstutheme.is_absent' => '1', 'Students.class_id' => $cid, 'Students.section_id' => $sid])->group(['Examstutheme.student_id'])->order(['Students.fname' => 'ASC'])->toarray();
        $azs = array();
        $azs = array_merge($a1, $a2);
        $fg = array_unique($azs);
        return ($fg);
    }

    // 13 Sept

    public function findpendingteachersubject($cid = null, $sid = null, $subid = null)
    {

        $ghj = unserialize($subid);

        $articles = TableRegistry::get('Examstusubject');
        $thu = TableRegistry::get('Examstutheme');

        $a1 = $articles->find('all')->select(['student_id', 'primarycentral_id', 'subject'])->contain(['Students'])->where(['Examstusubject.subject IN' => $ghj, 'Students.class_id' => $cid, 'Students.section_id' => $sid])->group(['Examstusubject.subject', 'Examstusubject.primarycentral_id'])->order(['Students.fname' => 'ASC'])->toarray();

        return $a1;
    }

    public function findpendingteachertheme($cid = null, $sid = null)
    {

        $thu = TableRegistry::get('Examstutheme');

        $a3 = $thu->find('all')->select(['student_id', 'primarycentral_id', 'transdistheme'])->contain(['Students'])->where(['Students.class_id' => $cid, 'Students.section_id' => $sid])->group(['Examstutheme.student_id', 'Examstutheme.primarycentral_id'])->order(['Students.fname' => 'ASC']);

        $py = array();
        foreach ($a3 as $bj) {
            $py[] = $bj['primarycentral_id'];
        }

        return $py;
    }

    public function findtheme($cid = null)
    {

        $thu = TableRegistry::get('Primarycentral');
        $a2 = $thu->find('all')->where(['Primarycentral.class_id' => $cid, 'Primarycentral.type' => '0'])->order(['Primarycentral.sort' => 'ASC'])->toarray();
        $ty = array();
        foreach ($a2 as $bj) {
            $ty[] = $bj['id'];
        }

        return $ty;
    }

    public function feesallocationcount($cid = null)
    {
        $connss = ConnectionManager::get('default');

        $studentrfidsd = $connss->execute("SELECT * FROM `student_feeallocations` WHERE `discountcategory` LIKE '%" . $cid . "%' and student_feeallocations.recipetno!=0 and student_feeallocations.status='Y' GROUP By student_id");

        return $studentrfidsd->fetchAll('assoc');
    }

    public function findrecipiet($sid = null, $discount = null)
    {

        $articles = TableRegistry::get('Studentfees');
        $query = $articles->find('all');
        return $query->select(['recipetno'])->where(['Studentfees.student_id' => $sid, 'Studentfees.discountcategory' => $discount, 'Studentfees.status' => 'Y'])->first();
    }

    public function feesallocationcounts($cid = null)
    {
        $connss = ConnectionManager::get('default');

        $studentrfidsd = $connss->execute("SELECT * FROM `students` WHERE `discountcategory` LIKE '" . $cid . "'  and students.status='Y'  GROUP By id");

        return $studentrfidsd->fetchAll('assoc');
    }

    // 21-Sept-2018

    public function findstudentimgdetails($cid = null, $sid = null)
    {
        // echo $cid.'<br>';

        // echo $getterm; 
        // echo WWW_ROOT.'Photos/sanskarimg/'.$df['enroll'].".JPG"; die;
        $getterm = $this->findacedemicyears('1');
        // pr($getterm); die;

        $dbname = TableRegistry::get('Users');
        $db = $dbname->find('all')->where(['role_id' => 1])->first();
        $thu = TableRegistry::get('Students');
        $a2 = $thu->find('all')->select(['id', 'file', 'board_id', 'enroll'])->where(['Students.class_id' => $cid, 'Students.acedmicyear' => $getterm['academic_year'], 'Students.section_id' => $sid, 'Students.status' => 'Y'])->order(['Students.fname' => 'ASC'])->toArray();
        // pr($a2); die;
        $imj = array();
        $noimj = array();

        foreach ($a2 as $df) {
            $hj = trim($df['enroll']);
            $path1 = WWW_ROOT . $db['db'] . 'schools/' . $hj . ".JPG";
            $path2 = WWW_ROOT . $db['db'] . 'schools/CAM' . $hj . ".JPG";

            $path3 = WWW_ROOT . $db['db'] . 'schools/IB' . $hj . ".JPG";
            if ($df['board_id'] == '1') {

                if (file_exists($path1)) {
                    $imj[] = $df['id'];
                } else {
                    $noimj[] = $df['id'];
                }
            } else if ($df['board_id'] == '2') {
                if (file_exists($path2)) {
                    $imj[] = $df['id'];
                } else {
                    $noimj[] = $df['id'];
                }
            } else {
                if (file_exists($path3)) {
                    $imj[] = $df['id'];
                } else {
                    $noimj[] = $df['id'];
                }
            }
        }
        return array($noimj, $imj);
    }

    // 4-Oct-2018

    public function findstuattendetails($studentid = null, $class_id = null, $sect_id = null, $term = null, $acedmicyear = null)
    {
        // pr($studentid);
        // pr($class_id);
        // pr($sect_id);
        // pr($term);die;        

        $thu = TableRegistry::get('Examattendence');
        // return $thu->find('all')->where(['Examattendence.enroll_id' => $enroll, 'Examattendence.class' => $class_id, 'Examattendence.section' => $sect_id, 'Examattendence.term' => $term])->first();

        return $thu->find('all')->where(['Examattendence.enroll_id' => $studentid, 'Examattendence.term' => $term, 'Examattendence.academic' => $acedmicyear])->first();
    }

    public function findoptionalsub($sid = null, $section = null, $classid = null, $sub = null)
    {
        $articles = TableRegistry::get('Studentexamresult');
        return $articles->find('all')->where(['Studentexamresult.class_id' => $classid, 'Studentexamresult.stud_id' => $sid, 'Studentexamresult.sect_id' => $section, 'Studentexamresult.subject_id' => $sub])->toarray();
    }

    // 12-Oct-2018
    public function findthemestatus($sid = null, $pid = null, $eid = null)
    {

        $thu = TableRegistry::get('Examstutheme');
        $themedet = $thu->find('all')->where(['Examstutheme.student_id' => $sid, 'Examstutheme.primarycentral_id' => $pid, 'Examstutheme.exam_id' => $eid])->first();
        //pr($themedet); die;
        if (!empty($themedet)) {
            if ($themedet['is_absent'] != '1') {
                $crit = unserialize($themedet['criteria']);
                $learn = unserialize($themedet['lernerprofile']);
                //pr($learn); die;
                $atti = unserialize($themedet['attitude']);
                $skill = unserialize($themedet['skills']);
                //pr($crit); die;
                $w = 0;
                // For criteria
                if (!empty($crit)) {
                    foreach ($crit as $gh) { //pr($gh);
                        if ($gh == '') {
                            $w++;
                        }
                    }
                } else {
                    $w++;
                }
                // For learner profile
                foreach ($learn as $lea) { //pr($gh);
                    if ($lea == '') {
                        $w++;
                    }
                }

                // For attitude
                foreach ($atti as $atu) { //pr($gh);
                    if ($atu == '') {
                        $w++;
                    }
                }

                // For skills
                foreach ($skill as $sku) {
                    if ($sku == '') {
                        $w++;
                    }
                }

                return $w;
            } else {
                return $k = "A";
            }
        } else {
            return $k = "P";
        }
    }

    public function findsubjectstatus($sid = null, $pid = null, $eid = null, $subid = null)
    {

        $thu = TableRegistry::get('Examstusubject');
        $articles = TableRegistry::get('Primarysubject');

        $est = $articles->find()->where(['Primarysubject.primarycentral_id' => $pid])->first();

        $subdet = $thu->find('all')->where(['Examstusubject.student_id' => $sid, 'Examstusubject.primarycentral_id' => $pid, 'Examstusubject.exam_id' => $eid, 'Examstusubject.subject' => $subid])->first();
        if ($subid == '128') { //pr($subdet); die;
        }

        //pr($subdet); die;
        //echo $subdet['topics']; die;
        if (!empty($subdet)) {

            if ($subdet['is_absent'] == '1') {
                return $k = "A";
            } else {

                $w = 0;
                $a = unserialize($est['topics']);
                $b = unserialize($subdet['topics']);
                //pr($a);
                $yu = array();
                foreach ($a as $val) {
                    foreach ($val as $cvb) {
                        $yu[] = $cvb;
                    }
                } //pr($yu);

                $cu = array();
                foreach ($b as $val) {
                    foreach ($val as $cvb) {
                        $cu[] = $cvb;
                    }
                }
                $des = count($yu);
                $rt = count($cu);
                if ($rt != $des) {
                    $w++;
                }

                return $w;
            }
        } else {
            return $k = "P";
        }
    }

    public function findextrasubjectstatus($sid = null, $pid = null, $eid = null, $subid = null)
    {
        //pr($subid); die;

        $thu = TableRegistry::get('Examstusubject');
        $articles = TableRegistry::get('Primarysubject');

        $est = $articles->find()->where(['Primarysubject.primarycentral_id' => $pid])->first();
        // pr($est); die;

        $subdet = $thu->find('all')->where(['Examstusubject.student_id' => $sid, 'Examstusubject.primarycentral_id' => $pid, 'Examstusubject.exam_id' => $eid, 'Examstusubject.subject IN' => $subid])->toarray();
        //pr($subdet); die;

        //pr($subdet); die;
        //echo $subdet['topics']; die;
        if (!empty($subdet)) {

            $w = 0;
            $a = unserialize($est['topics']);
            $b = unserialize($subdet['topics']);
            //pr($b);  die;
            $gj = unserialize($est['chapter']);
            $io = array_intersect($gj, $subid);
            //pr($io); die;

            $yu = array();
            foreach ($a as $k1 => $val) {
                foreach ($io as $k2 => $cvb) {
                    if ($k1 == $k2) {
                        $yu[] = $val;
                    }
                }
            } //pr($yu);
            $bv = array();
            foreach ($yu as $df) { //pr($df);
                foreach ($df as $mk) {
                    $bv[] = $mk;
                }
            } //pr($bv);die;

            $cu = array();
            foreach ($subdet as $val) { //pr($val);
                $top = unserialize($val['topics']);
                //pr($top);
                foreach ($top as $cvb) {
                    $cu[] = $cvb;
                }
            } //pr($cu); pr($bv); die;
            $des = count($bv);
            $rt = count($cu);
            //pr($des); pr($rt); die;
            if ($rt != $des) {
                $w++;
            }

            return $w;
        } else {
            return $k = "P";
        }
    }

    public function findextrasubjectstatus12($sid = null, $pid = null, $eid = null, $sui = null)
    {
        // pr($subid); die;

        $thu = TableRegistry::get('Examstusubject');
        $articles = TableRegistry::get('Primarysubject');

        $est = $articles->find()->where(['Primarysubject.primarycentral_id' => $pid])->first();
        // pr($est); die;

        $subdet = $thu->find('all')->where(['Examstusubject.student_id' => $sid, 'Examstusubject.primarycentral_id' => $pid, 'Examstusubject.exam_id' => $eid, 'Examstusubject.subject' => $sui])->first();

        //pr($subdet); die;
        //echo $subdet['topics']; die;
        if (!empty($subdet)) {

            if ($subdet['is_absent'] == '1') {
                return $k = "A";
            } else {
                $w = 0;
                $a = unserialize($est['topics']);
                $b = unserialize($subdet['topics']);
                //pr($b);  die;
                $gj = unserialize($est['chapter']);
                //pr($a);
                //pr($gj); die;

                $yu = array();
                foreach ($gj as $k1 => $val) {
                    if ($val == $sui) {

                        $yu[] = $a[$k1];
                    }
                } //pr($yu); die;
                $bv = array();
                foreach ($yu as $df) { //pr($df);
                    foreach ($df as $mk) {
                        $bv[] = $mk;
                    }
                } //pr($bv);die;

                $cu = array();

                $top = unserialize($subdet['topics']);
                //pr($top);
                foreach ($top as $cvb) {
                    $cu[] = $cvb;
                }

                $des = count($bv);
                $rt = count($cu);
                //pr($des); pr($rt); die;
                if ($rt != $des) {
                    $w++;
                }
                return $w;
            }
        } else {
            return $k = "P";
        }
    }

    public function issuedCountstudents($s_id = null)
    {
        if ($s_id) {
            $issued_count = TableRegistry::get('Classfee');
            return $issued_count->find('all')->contain(['Classes'])->where(['Classfee.slab' => $s_id])->group(['Classfee.class_id'])->order(['Classes.sort' => 'ASC'])->toarray();
        } else {
            return 'N/A';
        }
    }

    public function findfeeheadsclassfee($acedmiclassid, $a_year)
    {
        $articles = TableRegistry::get('Classfee');
        return $articles->find('all')->contain(['Classes', 'Feesheads'])->where(['Classfee.academic_year' => $a_year, 'Classfee.class_id' => $acedmiclassid])->order(['Classfee.fee_h_id' => 'ASC'])->toarray();
    }
    public function suggestifclone($acedmiclassid, $a_year)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Classfee');

        // Start a new query.

        return $articles->find('all')->contain(['Classes', 'Feesheads'])->where(['Classfee.academic_year' => $a_year, 'Classfee.class_id' => $acedmiclassid])->order(['Classfee.fee_h_id' => 'ASC'])->first();
    }

    public function studentshistory($stud_id)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentshistory');

        // Start a new query.

        return $articles->find('all')->contain(['Classes'])->select(['acedmicyear', 'stud_id'])->where(['Studentshistory.stud_id' => $stud_id])->order(['Studentshistory.id' => 'DESC'])->first();
    }

    public function studentshistoryagain($stud_id)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentshistory');

        // Start a new query.
        return $articles->find('all')->contain(['Classes'])->select(['acedmicyear', 'stud_id'])->where(['Studentshistory.stud_id' => $stud_id])->order(['Studentshistory.id' => 'DESC'])->toarray();
    }

    public function studentshistory23($stud_id)
    {
        // pr ($rout); die;


        $articles = TableRegistry::get('Studentshistory');

        // Start a new query.

        return $articles->find('all')->contain(['Classes'])->select(['acedmicyear', 'stud_id'])->where(['Studentshistory.stud_id' => $stud_id])->order(['Studentshistory.id' => 'DESC'])->first();
    }

    public function findridacademic($stud_id, $acedmic)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.

        return $articles->find('all')->select(['id'])->where(['Studentfees.id' => $stud_id, 'Studentfees.acedmicyear' => $acedmic])->order(['Studentfees.id' => 'DESC'])->first();
    }
    public function findridacademicre($stud_id, $acedmic)
    {
        $articles = TableRegistry::get('Studentfees');

        // Start a new query.

        return $articles->find('all')->select(['id'])->where(['Studentfees.student_id' => $stud_id, 'Studentfees.acedmicyear' => $acedmic])->order(['Studentfees.id' => 'DESC'])->first();
    }

    public function findri($stud_id)
    {

        if ($stud_id == "6022") {
            $articles = TableRegistry::get('Students');

            // Start a new query.

            return $articles->find('all')->select(['id'])->where(['Students.id' => $stud_id])->order(['Students.id' => 'DESC'])->first();
        } else {
            $articles = TableRegistry::get('Students');

            // Start a new query.

            return $articles->find('all')->select(['id'])->where(['Students.enroll' => $stud_id])->order(['Students.id' => 'DESC'])->first();
        }
    }

    public function findri2($stud_id, $acedmic)
    {
        $articles = TableRegistry::get('Students');

        // Start a new query.

        return $articles->find('all')->select(['id'])->where(['Students.oldenroll' => $stud_id, 'Students.status' => 'Y', 'Students.acedmicyear' => $acedmic])->order(['Students.id' => 'DESC'])->first();
    }

    public function findridacademicreert($stud_id, $acedmic)
    {
        $articles = TableRegistry::get('Students');

        // Start a new query.

        return $articles->find('all')->select(['id'])->where(['Students.id' => $stud_id, 'Students.acedmicyear' => $acedmic])->order(['Students.id' => 'DESC'])->first();
    }

    public function findridacademicreerty($stud_id, $acedmic)
    {
        $articles = TableRegistry::get('Students');

        // Start a new query.

        return $articles->find('all')->select(['id'])->where(['Students.id' => $stud_id, 'Students.status' => 'Y', 'Students.acedmicyear' => $acedmic])->order(['Students.id' => 'DESC'])->first();
    }

    public function findridacademicer($stud_id)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.

        return $articles->find('all')->select(['id'])->where(['Studentfees.id' => $stud_id])->order(['Studentfees.id' => 'DESC'])->first();
    }

    public function findbookname12($id = null)
    {
        $articles = TableRegistry::get('Book');
        return $articles->find()->select(['name'])->where(['Book.accsnno' => $id])->first();
    }

    public function findclastheme($stud_id)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Primarycentral');

        // Start a new query.

        return $articles->find('all')->contain(['Primarytheme', 'Classes'])->where(['Primarycentral.class_id' => $stud_id, 'Primarycentral.type' => '0'])->order(['Primarycentral.term' => 'ASC'])->toarray();
    }

    public function findwordbank23($pid, $atid, $fin)
    { //echo $pid; die;
        // pr ($rout); die;

        $articles = TableRegistry::get('Wordbank');

        // Start a new query.

        return $articles->find('all')->where(['Wordbank.primarycentral_id' => $pid, 'Wordbank.attribute' => $atid, 'Wordbank.fields LIKE' => $fin . '%'])->order(['Wordbank.sid' => 'ASC'])->toarray();
    }
    public function findnotassignedhouse($id = null, $element, $elements, $hid, $acedmic)
    {
        $articles = TableRegistry::get('Students');
        $getterm = $this->findacedemicyears('1');
        return $articles->find('all')->where(['Students.gender' => $id, 'Students.class_id' => $element, 'Students.acedmicyear' => $acedmic, 'Students.section_id' => $elements, 'Students.h_id IN' => ['', '0'], 'Students.status' => 'Y'])->count();
    }
    public function findofcash($mode)
    {
        $date = date('Y-m-d');

        $articles = TableRegistry::get('Otherfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Otherfees.total')])->where(['Otherfees.status' => 'Y', 'Otherfees.paydate' => $date, 'Otherfees.receipt_no !=' => '0', 'Otherfees.mode' => $mode])->toarray();
        //pr($res);die;
    }

    public function findtermexamend($cid, $class)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Exams');

        // Start a new query.

        return $articles->find('all')->where(['Exams.termf' => $cid, 'Exams.class_id' => $class])->first();
    }
    public function findofcashdate($from, $to, $mode)
    {

        $from = date('Y-m-d', strtotime($from));
        $to = date('Y-m-d', strtotime($to));

        $articles = TableRegistry::get('Otherfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Otherfees.total')])->where(['Otherfees.status' => 'Y', 'Otherfees.paydate >=' => $from, 'Otherfees.paydate <=' => $to, 'Otherfees.receipt_no !=' => '0', 'Otherfees.mode' => $mode])->toarray();
        //pr($res);die;
    }

    public function findofnotcash($mode)
    {
        $date = date('Y-m-d');

        $articles = TableRegistry::get('Otherfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Otherfees.total')])->where(['Otherfees.status' => 'Y', 'Otherfees.paydate' => $date, 'Otherfees.receipt_no !=' => '0', 'Otherfees.mode !=' => $mode])->toarray();
        //pr($res);die;
    }
    public function findofcashdaily($mode, $date)
    {

        $articles = TableRegistry::get('Otherfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Otherfees.total')])->where(['Otherfees.status' => 'Y', 'Otherfees.paydate' => $date, 'Otherfees.receipt_no !=' => '0', 'Otherfees.mode' => $mode])->toarray();
        //pr($res);die;
    }
    public function findofnotcashdaily($mode, $date)
    {

        $articles = TableRegistry::get('Otherfees');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Otherfees.total')])->where(['Otherfees.status' => 'Y', 'Otherfees.paydate' => $date, 'Otherfees.receipt_no !=' => '0', 'Otherfees.mode !=' => $mode])->toarray();
        //pr($res);die;
    }
    public function findotherfees($reciept)
    {
        //pr($reciept);

        $articles = TableRegistry::get('Otherfees');
        return $articles->find('all')->where(['Otherfees.receipt_no' => $reciept])->toarray();
    }
    public function findacedemicstudents2stodayout($board_id = null, $date)
    {

        $articles = TableRegistry::get('DropOutStudent');
        return $articles->find('all')->where(['DATE(DropOutStudent.admissiondate)' => $date, 'DropOutStudent.board_id ' => $board_id])->count();
    }
    public function findacedemicstudents2stodayoutdrop($board_id = null, $acedmic, $date)
    {

        $getterm = $this->findacedemicyears('1');
        $currentyear = $getterm['academic_year'];

        $stts = array('DATE(DropOutStudent.admissiondate)' => $date);
        $apk[] = $stts;

        $stts = array('DropOutStudent.board_id' => $board_id);
        $apk[] = $stts;

        if ($acedmic != '') {
            $stts = array('DropOutStudent.admissionyear' => $acedmic);
            $apk[] = $stts;
        }

        if ($acedmic != $currentyear && $acedmic != '') {

            $articles = TableRegistry::get('DropOutStudent');
            $ddd = $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->toarray();

            $cnust = 0;

            foreach ($ddd as $k => $kki) {

                $articles3 = TableRegistry::get('Studentshistory')->find('all')->where(['Studentshistory.stud_id' => $kki['s_id']])->order(['Studentshistory.id' => 'ASC'])->first();
                if ($articles3['id']) {
                } else {
                    $cnust++;
                }
            }
            return $cnust;
        } else {
            $articles = TableRegistry::get('DropOutStudent');
            return $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->count();
            //pr($Classections21); die;

        }
    }
    public function findacedemicstudents2stodayoutintdetail($board_id = null, $date)
    {

        $articles = TableRegistry::get('DropOutStudent');
        return $articles->find('all')->where(['DATE(DropOutStudent.admissiondate)' => $date, 'DropOutStudent.board_id !=' => $board_id])->count();
    }
    public function findacedemicstudents2stodayoutintdetaildrop($board_id = null, $acedmic, $date)
    {

        $getterm = $this->findacedemicyears('1');
        $currentyear = $getterm['academic_year'];

        $stts = array('DATE(DropOutStudent.admissiondate)' => $date);
        $apk[] = $stts;

        $stts = array('DropOutStudent.board_id !=' => $board_id);
        $apk[] = $stts;

        if ($acedmic != '') {
            $stts = array('DropOutStudent.admissionyear' => $acedmic);
            $apk[] = $stts;
        }

        if ($acedmic != $currentyear && $acedmic != '') {

            $articles = TableRegistry::get('DropOutStudent');
            $ddd = $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->toarray();

            $cnust = 0;

            foreach ($ddd as $k => $kki) {

                $articles3 = TableRegistry::get('Studentshistory')->find('all')->where(['Studentshistory.stud_id' => $kki['s_id']])->order(['Studentshistory.id' => 'ASC'])->first();
                if ($articles3['id']) {
                } else {
                    $cnust++;
                }
            }
            return $cnust;
        } else {
            $articles = TableRegistry::get('DropOutStudent');
            return $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->count();
            //pr($Classections21); die;

        }
    }
    public function findotherdetails($reciept = null)
    {
        $articles = TableRegistry::get('Otherfees');
        return $articles->find('all')->where(['Otherfees.receipt_no' => $reciept])->first();
    }
    public function find_drop_paidamountsack23($a_year, $dateto, $acedmic)
    {

        $articles = TableRegistry::get('Studentfees');

        $dateto = date('Y-m-d', strtotime($dateto));
        return $articles->find('all')->where(['Studentfees.student_id' => $a_year, 'Studentfees.acedmicyear' => $acedmic, 'Studentfees.paydate <=' => $dateto, 'Studentfees.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toarray();
    }
    public function empById($id = null, $mon = null, $year = null)
    {

        $timeTab = TableRegistry::get('Employees');
        return $timeTab->find('all')->where(['Employees.status' => 'Y', 'Employees.department_id' => $id])->order(['Employees.fname' => 'ASC'])->toarray();
    }
    public function findhol_allow($id = null, $date = null)
    {
        $articles = TableRegistry::get('Holidayallowance');
        $date = date('Y-m-d', strtotime($date));
        return $articles->find('all')->where(['employee_id' => $id, 'date' => $date])->first();
    }
    public function salExist($id = null, $mon = null, $year = null)
    {
        $articles = TableRegistry::get('Salary');
        $date = date('Y-m-d', strtotime($date));
        return $articles->exists(['Eid' => $id, 'month' => $mon, 'year' => $year]);
    }
    public function findEmp_Att_bydate($emp_id = null, $date = null)
    {
        // pr($emp_id); 57
        // pr($date);die;          2-05-2022

        $date_formate = date('Y-m-d', strtotime($date));
        $articles = TableRegistry::get('Employeeattendance');
        return $articles->find('all')->where(['employee_id' => $emp_id, 'DATE(date)' => $date_formate, 'status IN' => ['A', 'HF', 'SL']])->first();
    }
    public function findEmp_Attendance_bydate($emp_id = null, $date = null)
    {
        // pr($data);die;
        $articles = TableRegistry::get('Staffattends');
        return $articles->find('all')->where(['emp_id' => $emp_id, 'DATE(date)' => $date, 'status IN' => ['A', 'P']])->first();
        // pr($return);die;
    }
    public function leaveStatus($date = null, $id = null)
    {
        $this->autorender = false;
        $leave = TableRegistry::get('Leaves');
        $date = date('Y-m-d', strtotime($date));
        return $leave->find('all')->contain(['Leavetype'])->where(['emp_id' => $id, 'date' => $date])->first();
    }
    public function findemplobasic($id = null)
    {
        $articles = TableRegistry::get('Employeesalary');
        return $articles->find('all')->where(['Employeesalary.employee_id' => $id])->first();
    }
    public function findpaymentmode($id = null)
    {
        $articles = TableRegistry::get('Ledger');

        return $articles->find('all')->select(['name'])->where(['id' => $id])->first();
    }
    public function findAttendance($emp_id = null)
    {
        //pr($emp_id);die;
        $articles = TableRegistry::get('Employeeattendance');
        $date = date('Y-m-d');
        return $articles->find('all')->where(['employee_id' => $emp_id, 'DATE(date)' => $date, 'absent_periods !=' => ''])->first();
    }
    public function getladgername($id)
    {

        $articles = TableRegistry::get('Ledger');
        return $articles->find('all')->where(['Ledger.id' => $id])->first();
    }

    public function findacedemicstudentshisa21($classs = null, $acedmic = null, $from = null, $to = null)
    {

        $getterm = $this->findacedemicyears('1');
        $currentyear = $getterm['academic_year'];

        $stts = array('Students.created >=' => $from);
        $apk[] = $stts;

        $stts = array('Students.created <=' => $to);
        $apk[] = $stts;

        $stts = array('Students.class_id' => $classs);
        $apk[] = $stts;

        $stts = array('Students.category' => 'Migration');
        $apk[] = $stts;

        $stts = array('Students.admissionyear' => $acedmic);
        $apk[] = $stts;
        $stts = array('Students.status' => 'N');
        $apk[] = $stts;

        $articles = TableRegistry::get('Students');

        return $articles->find('all')->where($apk)->order(['Students.id' => 'ASC'])->count();
    }
    public function findacedemicstudentrte($classs = null, $acedmic = null, $from = null, $to = null)
    {

        $getterm = $this->findacedemicyears('1');
        $currentyear = $getterm['academic_year'];
        $nextyear = $getterm['next_academic_year'];

        if ($currentyear == $acedmic) {

            $stts = array('Students.created >=' => $from);
            $apk[] = $stts;

            $stts = array('Students.created <=' => $to);
            $apk[] = $stts;

            $stts = array('Students.class_id' => $classs);
            $apk[] = $stts;

            $stts = array('Students.category' => 'RTE');
            $apk[] = $stts;

            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;

            $articles = TableRegistry::get('Students');

            return $articles->find('all')->where($apk)->order(['Students.id' => 'ASC'])->count();
        } else if ($acedmic != $currentyear) {

            $stts = array('Studentshistory.created >=' => $from);
            $apk[] = $stts;

            $stts = array('Studentshistory.created <=' => $to);
            $apk[] = $stts;

            $stts = array('Studentshistory.class_id' => $classs);
            $apk[] = $stts;

            $stts = array('Studentshistory.category' => 'RTE');
            $apk[] = $stts;

            $stts = array('Studentshistory.admissionyear' => $acedmic);
            $apk[] = $stts;

            $articles = TableRegistry::get('Studentshistory');

            return $articles->find('all')->where($apk)->order(['Studentshistory.id' => 'ASC'])->count();
        } else {

            $stts = array('Students.created >=' => $from);
            $apk[] = $stts;

            $stts = array('Students.created <=' => $to);
            $apk[] = $stts;

            $stts = array('Students.class_id' => $classs);
            $apk[] = $stts;

            $stts = array('Students.category' => 'RTE');
            $apk[] = $stts;

            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;

            $articles = TableRegistry::get('Students');

            return $articles->find('all')->where($apk)->order(['Students.id' => 'ASC'])->count();
        }
    }
    public function findacedemicstudentshisa213($classs = null, $acedmic = null, $from = null, $to = null)
    {

        $getterm = $this->findacedemicyears('1');
        $currentyear = $getterm['academic_year'];

        $nextyear = $getterm['next_academic_year'];
        $rolepresent = $this->request->session()->read('Auth.User.role_id');

        if ($rolepresent == '5') {
            $stts = array('Students.board_id !=' => 1);
            $apk[] = $stts;
        } else {

            $stts = array('Students.board_id' => 1);
            $apk[] = $stts;
        }

        $stts = array('Students.created >=' => $from);
        $apk[] = $stts;

        $stts = array('Students.created <=' => $to);
        $apk[] = $stts;

        $stts = array('Students.category' => 'Migration');
        $apk[] = $stts;

        $stts = array('Students.admissionyear' => $acedmic);
        $apk[] = $stts;
        $stts = array('Students.status' => 'N');
        $apk[] = $stts;

        $articles = TableRegistry::get('Students');
        $ddd = $articles->find('all')->where($apk)->order(['Students.id' => 'ASC'])->toarray();

        $cnust = 0;
        foreach ($ddd as $k => $kki) {

            if ($currentyear == $acedmic) {

                $articles3 = TableRegistry::get('Students')->find('all')->where(['oldenroll' => $kki['enroll'], 'class_id' => $classs, 'admissionyear' => $acedmic])->order(['id' => 'ASC'])->first();
            } else if ($acedmic != $currentyear) {

                $articles3 = TableRegistry::get('Studentshistory')->find('all')->where(['oldenroll' => $kki['enroll'], 'class_id' => $classs, 'admissionyear' => $acedmic])->order(['id' => 'ASC'])->first();
            } else {
                $articles3 = TableRegistry::get('Students')->find('all')->where(['oldenroll' => $kki['enroll'], 'class_id' => $classs, 'admissionyear' => $acedmic])->order(['id' => 'ASC'])->first();
            }

            if ($articles3['id']) {
                $cnust++;
            } else {
            }
        }

        return $cnust;
    }

    public function findacedemicstudentshisa2($classs = null, $acedmic = null, $from = null, $to = null)
    {

        $getterm = $this->findacedemicyears('1');
        $currentyear = $getterm['academic_year'];
        //~ $stts=array('Studentfees.paydate >=' =>$from);
        //~ $apk[]=$stts;

        //~ $stts=array('Studentfees.paydate <=' =>$to);
        //~ $apk[]=$stts;

        //~ $stts=array("Studentfees.quarter LIKE '%Admission Fee%'");
        //~ $apk[]=$stts;

        //~ $stts=array("Studentfees.recipetno !=0");
        //~ $apk[]=$stts;
        //~ $stts=array("Studentfees.status !='N'");
        //~ $apk[]=$stts;

        $nextyear = $getterm['next_academic_year'];

        if ($currentyear == $acedmic) {

            $stts = array('Students.created >=' => $from);
            $apk[] = $stts;

            $stts = array('Students.created <=' => $to);
            $apk[] = $stts;
            $stts = array('Students.class_id' => $classs);
            $apk[] = $stts;
            $stts = array('Students.category !=' => 'RTE');
            $apk[] = $stts;

            $stts = array('Students.oldenroll' => '0');
            $apk[] = $stts;
            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;

            $articles = TableRegistry::get('Students');
            return $articles->find('all')->where($apk)->order(['Students.id' => 'ASC'])->count();
        } else if ($acedmic != $currentyear) {

            $stts = array('Studentshistory.created >=' => $from);
            $apk[] = $stts;

            $stts = array('Studentshistory.created <=' => $to);
            $apk[] = $stts;

            $stts = array('Studentshistory.class_id' => $classs);
            $apk[] = $stts;

            $stts = array('Studentshistory.admissionyear' => $acedmic);
            $apk[] = $stts;

            $stts = array('Studentshistory.category !=' => 'RTE');
            $apk[] = $stts;

            $stts = array('Studentshistory.oldenroll' => '0');
            $apk[] = $stts;

            $articles = TableRegistry::get('Studentshistory');
            return $articles->find('all')->where($apk)->order(['Studentshistory.id' => 'ASC'])->count();
        } else {

            $stts = array('Students.created >=' => $from);
            $apk[] = $stts;

            $stts = array('Students.created <=' => $to);
            $apk[] = $stts;
            $stts = array('Students.class_id' => $classs);
            $apk[] = $stts;
            $stts = array('Students.category !=' => 'RTE');
            $apk[] = $stts;

            $stts = array('Students.oldenroll' => '0');
            $apk[] = $stts;
            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;

            $articles = TableRegistry::get('Students');
            return $articles->find('all')->where($apk)->order(['Students.id' => 'ASC'])->count();
        }
    }

    public function findacedemicstudentshis2($classs = null, $acedmic = null, $from = null, $to = null)
    {

        $getterm = $this->findacedemicyears('1');
        $currentyear = $getterm['academic_year'];
        $stts = array('Studentfees.paydate >=' => $from);
        $apk[] = $stts;

        $stts = array('Studentfees.paydate <=' => $to);
        $apk[] = $stts;

        $stts = array("Studentfees.quarter LIKE '%Admission Fee%'");
        $apk[] = $stts;

        $stts = array("Studentfees.recipetno !=0");
        $apk[] = $stts;
        $stts = array("Studentfees.status !='N'");
        $apk[] = $stts;

        $nextyear = $getterm['next_academic_year'];

        if ($currentyear == $acedmic) {

            $stts = array('Students.class_id' => $classs);
            $apk[] = $stts;

            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;
            $stts = array('Students.status' => 'Y');
            $apk[] = $stts;

            $articles = TableRegistry::get('Studentfees');
            return $articles->find('all')->contain(['Students'])->where($apk)->order(['Studentfees.id' => 'ASC'])->count();
        } else if ($acedmic != $currentyear) {

            $stts = array('Studentshistory.class_id' => $classs);
            $apk[] = $stts;

            $stts = array('Studentshistory.admissionyear' => $acedmic);
            $apk[] = $stts;

            $articles = TableRegistry::get('Studentfees');
            return $articles->find('all')->contain(['Studentshistory'])->where($apk)->order(['Studentfees.id' => 'ASC'])->count();
        } else {

            $stts = array('Students.class_id' => $classs);
            $apk[] = $stts;

            $stts = array('Students.admissionyear' => $acedmic);
            $apk[] = $stts;
            $stts = array('Students.status' => 'Y');
            $apk[] = $stts;

            $articles = TableRegistry::get('Studentfees');
            return $articles->find('all')->contain(['Students'])->where($apk)->order(['Studentfees.id' => 'ASC'])->count();
        }
    }

    public function findacedemicstudentsdrop2($classs = null, $acedmic = null, $from = null, $to = null)
    {

        $getterm = $this->findacedemicyears('1');
        $currentyear = $getterm['academic_year'];

        $stts = array('DropOutStudent.admissiondate >=' => $from);
        $apk[] = $stts;

        $stts = array('DropOutStudent.admissiondate <=' => $to);
        $apk[] = $stts;

        $stts = array('DropOutStudent.laststudclass' => $classs);
        $apk[] = $stts;

        $stts = array('DropOutStudent.admissionyear' => $acedmic);
        $apk[] = $stts;

        if ($acedmic != $currentyear) {
            $articles = TableRegistry::get('DropOutStudent');
            $ddd = $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->toarray();

            $cnust = 0;

            foreach ($ddd as $k => $kki) {

                $articles3 = TableRegistry::get('Studentshistory')->find('all')->where(['Studentshistory.stud_id' => $kki['s_id']])->order(['Studentshistory.id' => 'ASC'])->first();
                if ($articles3['id']) {
                } else {
                    $cnust++;
                }
            }
            return $cnust;
        } else {
            $articles = TableRegistry::get('DropOutStudent');
            return $articles->find('all')->where($apk)->order(['DropOutStudent.id' => 'ASC'])->count();
            //pr($Classections21); die;

        }
    }
    public function findstudentnameid($id = null)
    {
        //pr($id); die;
        $articles = TableRegistry::get('Students');
        return $articles->find('all')->where(['Students.id' => $id, 'Students.status' => 'Y'])->first();
    }
    public function payrolldesgination($id = null)
    {
        $articles = TableRegistry::get('PayrollDesignations');

        return $articles->find('all')->where(['id' => $id])->first();
    }
    public function payrolldepartment($id = null)
    {
        $articles = TableRegistry::get('PayrollDepartments');

        return $articles->find('all')->where(['id' => $id])->first();
    }
    public function empByPId($id = null, $mon = '', $year = '')
    {
        // pr($id);die;
        $timeTab = TableRegistry::get('Employees');
        return $timeTab->find('all')->where(['Employees.status' => 'Y'])->where(['OR' => ['Employees.is_drop' => 'N', ['Employees.is_drop' => 'Y', 'MONTH(Employees.drop_date) >=' => $mon, 'YEAR(Employees.drop_date) >=' => $year]], 'Employees.P_department' => $id])->order(['Employees.fname' => 'ASC'])->toarray();
    }
    public function findemployeesal($id = null)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('Employees');

        // Start a new query.

        return $articles->find('all')->contain(['Employeesalary'])->where(['Employees.id' => $id])->first();
    }
    public function finddropemployeesal($id = null)
    {
        // pr ($rout); die;

        $articles = TableRegistry::get('DropOutEmployee');

        // Start a new query.

        return $articles->find('all')->contain(['Employeesalary'])->where(['DropOutEmployee.id' => $id])->first();
    }
    public function saldetails($id = null)
    {
        $articles = TableRegistry::get('Salary');
        return $articles->find('all')->where(['id' => $id])->first();
    }
    public function salarydate($mon = null, $year = null)
    {
        $articles = TableRegistry::get('Salary');
        return $articles->find('all')->where(['month' => $mon, 'year' => $year])->group(['created'])->first();
    }
    public function findholidaymonth($date)
    {
        $articles = TableRegistry::get('Events');
        return $articles->find('all')->where(['DATE(Events.starttime) <=' => $date, 'DATE(Events.endtime) >=' => $date, 'Events.eventt' => '8'])->count();
    }
    public function LWP($id, $mon, $year)
    {

        $articles = TableRegistry::get('Leaves');
        return $articles->find('all')->where(['emp_id' => $id, 'MONTH(date)' => $mon, 'YEAR(date)' => $year, 'LWP' => 'Y'])->count();
    }
    public function leavecount($id, $acdfrom, $to)
    {
        $articles = TableRegistry::get('Leaves');
        return $articles->find('all')->where(['emp_id' => $id, 'date >=' => $acdfrom, 'date <=' => $to, 'status' => 'Y'])->count();
    }

    // Store

    public function indentdetail($id)
    {

        $articles = TableRegistry::get('Indent');
        return $articles->find('all')->contain(['Additem'])->where(['Indent.indent_id' => $id])->toarray();
    }
    public function indentdetails($id, $item)
    {

        $articles = TableRegistry::get('Indent');
        return $articles->find('all')->contain(['Additem', 'Sizemanager'])->where(['Indent.indent_id' => $id, 'Indent.item_id' => $item])->first();
    }
    public function indentitemquantity($id)
    {

        $articles = TableRegistry::get('Indent');
        return $articles->find('all')->select(['quantity' => $articles->find('all')->func()->sum('Indent.quantity')])->where(['Indent.indent_id' => $id])->order(['Indent.id' => 'DESC'])->toarray();
    }

    public function indentitemquantity1($id)
    {

        $articles = TableRegistry::get('Indent');
        return $articles->find('all')->select(['quantity' => $articles->find('all')->func()->sum('Indent.quantity')])->where(['Indent.indent_id' => $id])->order(['Indent.id' => 'DESC'])->first();
    }

    public function getindentw($id, $status)
    {

        $articles = TableRegistry::get('Indent');
        return $articles->find('all')->contain(['Additem'])->where(['Indent.indent_id' => $id, 'Indent.status' => $status])->toarray();
    }
    public function getindent($id, $status)
    {

        $articles = TableRegistry::get('Indenttemp');
        return $articles->find('all')->contain(['Additem'])->where(['Indenttemp.indent_id' => $id, 'Indenttemp.status' => $status])->toarray();
    }
    public function getitemcatcom($id)
    {

        $articles = TableRegistry::get('Additem');
        return $articles->find('all')->contain(['Itemcategory', 'Measurementunit'])->where(['Additem.id' => $id])->first();
    }
    public function getsizename($id)
    {

        $articles = TableRegistry::get('Sizemanager');
        return $articles->find('all')->where(['Sizemanager.id' => $id])->first();
    }
    public function poitemquantity($poid, $isrevise, $id)
    {

        $articles = TableRegistry::get('Stockregister');
        return $articles->find('all')->contain(['Additem'])->where(['Stockregister.po_id' => $poid, 'Stockregister.purchaseorder_id' => $id, 'Stockregister.is_revised' => $isrevise])->toarray();
    }
    public function podetail($poid, $isrevise, $id)
    {

        $articles = TableRegistry::get('Stockregister');
        return $articles->find('all')->contain(['Additem'])->where(['Stockregister.po_id' => $poid, 'Stockregister.purchaseorder_id' => $id, 'Stockregister.store_type' => 0, 'Stockregister.is_revised' => $isrevise])->toarray();
    }

    public function podetailupdated($poid, $isrevise)
    {

        $articles = TableRegistry::get('Stockregister');
        return $articles->find('all')->contain(['Additem'])->where(['Stockregister.purchaseorder_id' => $poid, 'Stockregister.store_type' => 1, 'Stockregister.is_revised' => $isrevise])->toarray();
    }
    public function findvendornames($vendorid)
    {

        $articles = TableRegistry::get('Vendor');
        return $articles->find('all')->where(['Vendor.id' => $vendorid])->first();
    }
    //old lpr price show function
    // public function lprcost($item_id)
    // {

    //     $articles = TableRegistry::get('Stockregister');
    //     $rsull = $articles->find('all')->select(['rate' => 'MIN(Stockregister.rate)'])->where(['Stockregister.item_id' => $item_id])->order(['Stockregister.rate' => 'ASC'])->toarray();
    //     return $rsull[0]['rate'];
    // }


    public function lprcost($item_id)
    {

        $articles = TableRegistry::get('Stockregister');
        $rsull = $articles->find('all')->select(['rate'])->where(['Stockregister.item_id' => $item_id, 'Stockregister.store_type' => '1'])->order(['Stockregister.rate' => 'DESC'])->toarray();
        return $rsull[0]['rate'];
    }



    public function getunitnamepoview($id)
    {

        $articles = TableRegistry::get('Measurementunit');
        return $articles->find('all')->where(['Measurementunit.id' => $id])->order(['Measurementunit.id' => 'ASC'])->first();
    }
    public function vendorbilltodetail($id)
    {

        $articles = TableRegistry::get('Vendorbillto');
        return $articles->find('all')->contain(['States', 'Cities'])->where(['Vendorbillto.vendor_id' => $id])->order(['Vendorbillto.id' => 'ASC'])->toarray();
    }
    public function vendorshipfromdetail($id)
    {

        $articles = TableRegistry::get('Vendorshipfrom');
        return $articles->find('all')->contain(['States', 'Cities'])->where(['Vendorshipfrom.vendor_id' => $id])->order(['Vendorshipfrom.id' => 'ASC'])->toarray();
    }
    public function getbeforerevisedpo($id)
    {

        $articles = TableRegistry::get('Purchaseorder');
        return $articles->find('all')->where(['Purchaseorder.purchaseorder_id' => $id, 'Purchaseorder.status' => 'R'])->order(['Purchaseorder.id' => 'DESC'])->first();
    }

    public function pogett($id)
    {

        $articles = TableRegistry::get('Purchaseorder');
        return $articles->find('all')->where(['Purchaseorder.id' => $id])->order(['Purchaseorder.id' => 'DESC'])->first();
    }
    public function gettaxnameparent($id)
    {

        $articles = TableRegistry::get('Taxmaster');
        return $articles->find('all')->where(['Taxmaster.id' => $id, 'Taxmaster.parent' => '0'])->order(['Taxmaster.id' => 'DESC'])->toarray();
    }
    public function gettaxname($id)
    {

        $articles = TableRegistry::get('Taxmaster');
        return $articles->find('all')->where(['Taxmaster.id' => $id])->order(['Taxmaster.id' => 'DESC'])->first();
    }
    public function gettaxname2($id)
    {

        $articles = TableRegistry::get('Taxmaster');
        return $articles->find('all')->where(['Taxmaster.id' => $id])->order(['Taxmaster.id' => 'DESC'])->toarray();
    }
    public function paymenttermsdetail()
    {

        $articles = TableRegistry::get('Paymentterms');
        return $articles->find('all')->where(['Paymentterms.status' => 'Y'])->order(['Paymentterms.id' => 'ASC'])->toarray();
    }
    public function getpoqty($id)
    {

        $articles = TableRegistry::get('Purchaseorder');
        return $articles->find('all')->where(['Purchaseorder.purchaseorder_id' => $id, 'Purchaseorder.status !=' => 'N'])->order(['Purchaseorder.id' => 'DESC'])->first();
    }

    public function getpypstumarks($stud_id = null, $clasid = null, $sec_id = null, $quater = null, $sub_skill = null)
    {
        // pr($stud_id.',');
        // pr($clasid.',');
        // pr($sec_id.',');
        // pr($quater.',');
        // pr($sub_skill.',');die;


        $articles = TableRegistry::get('Pypstudentexamresult');
        return $articles->find('all')->where(['Pypstudentexamresult.st_id' => $stud_id, 'Pypstudentexamresult.class_id' => $clasid, 'Pypstudentexamresult.section_id' => $sec_id, 'Pypstudentexamresult.quarter' => $quater, 'Pypstudentexamresult.sub_skill_id' => $sub_skill])->order(['Pypstudentexamresult.id' => 'DESC'])->toArray();
    }

    public function getpypextra($stud_id = null, $clasid = null, $sec_id = null, $quater = null)
    {

        $articles = TableRegistry::get('Pypstudentexamresult');
        return $articles->find('all')->where(['Pypstudentexamresult.st_id' => $stud_id, 'Pypstudentexamresult.class_id' => $clasid, 'Pypstudentexamresult.section_id' => $sec_id, 'Pypstudentexamresult.quarter' => $quater, 'Pypstudentexamresult.sub_skill_id' => 'E', 'Pypstudentexamresult.subject_id' => 'EXTRA'])->order(['Pypstudentexamresult.id' => 'DESC'])->toArray();
    }

    public function getmarks($stud_id = null, $subject_id = null, $clasid = null, $sec_id = null, $term = null, $examtype = null, $exid = null, $accademicyear = null)
    {
        // pr($stud_id);
        // pr($subject_id);
        // pr($clasid);
        // pr($sec_id);
        // pr($term);
        // pr($examtype);
        // pr($accademicyear);die;

        $articles = TableRegistry::get('Studentexamresult');
        return $articles->find('all')->where(['Studentexamresult.stud_id' => $stud_id, 'Studentexamresult.class_id' => $clasid, 'Studentexamresult.sect_id' => $sec_id, 'Studentexamresult.term' => $term, 'Studentexamresult.exam_id' => $exid, 'Studentexamresult.etype_id' => $examtype, 'Studentexamresult.subject_id' => $subject_id, 'Studentexamresult.acedamic' => $accademicyear,])->order(['Studentexamresult.id' => 'DESC'])->first();
    }

    public function getpostockitem($id, $item_id)
    {

        $articles = TableRegistry::get('Stockregister');
        return $articles->find('all')->where(['Stockregister.po_id' => $id, 'Stockregister.item_id' => $item_id, 'Stockregister.status !=' => 'N', 'Stockregister.store_type' => '0'])->order(['Stockregister.id' => 'DESC'])->first();
    }

    public function goodsrecivied($id, $sst)
    {

        $articles = TableRegistry::get('Goodsreceived');
        return $articles->find('all')->select(['quantity' => $articles->find('all')->func()->sum('Goodsreceived.total_qty')])->where(['Goodsreceived.purchaseorder_id' => $id, 'Goodsreceived.id <=' => $sst])->order(['Goodsreceived.id' => 'DESC'])->toarray();
    }

    public function findtemplate($id, $term, $board_name)
    {
        // pr($board_name);die;

        $articles = TableRegistry::get('Examtemplates');
        return $articles->find('list', ['keyField' => 'id', 'valueField' => 'title'])->where(['Examtemplates.group_name' => $id, 'term' => $term, 'board' => $board_name])->toArray();
    }


    public function stockregisteropening($date, $item_id)
    {

        $articles = TableRegistry::get('Stockregister');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Stockregister.quantity')])->where(['DATE(Stockregister.created) <=' => $date, 'Stockregister.status !=' => 'N', 'Stockregister.item_id' => $item_id, 'Stockregister.store_type' => '1'])->order(['Stockregister.id' => 'DESC'])->toarray();
    }

    public function stockregisteritems($po_id, $pid, $item_id)
    {

        $articles = TableRegistry::get('Stockregister');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Stockregister.quantity')])->where(['Stockregister.po_id' => $po_id, 'Stockregister.purchaseorder_id' => $pid, 'Stockregister.status !=' => 'N', 'Stockregister.item_id' => $item_id, 'Stockregister.store_type' => '1'])->order(['Stockregister.id' => 'DESC'])->toarray();
    }

    public function stockregisteropeningrecivied($date, $item_id)
    {

        $articles = TableRegistry::get('Stockregister');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Stockregister.quantity')])->where(['DATE(Stockregister.created)' => $date, 'Stockregister.status !=' => 'N', 'Stockregister.item_id' => $item_id, 'Stockregister.store_type' => '1'])->order(['Stockregister.id' => 'DESC'])->toarray();
    }

    public function stockregisteropeningdispatched($date, $item_id)
    {

        $articles = TableRegistry::get('Stockregister');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Stockregister.quantity')])->where(['Stockregister.item_id' => $item_id, 'DATE(Stockregister.created)' => $date, 'Stockregister.status !=' => 'N', 'Stockregister.store_type' => '2'])->order(['Stockregister.id' => 'DESC'])->toarray();
    }

    public function stockregisteropeningdispatchedall($date, $item_id)
    {

        $articles = TableRegistry::get('Stockregister');
        return $articles->find('all')->select(['quantity' => $articles->find('all')->func()->sum('Stockregister.quantity')])->where(['DATE(Stockregister.created) <' => $date, 'Stockregister.item_id' => $item_id, 'Stockregister.status !=' => 'N', 'Stockregister.store_type' => '2'])->order(['Stockregister.id' => 'DESC'])->toarray();
    }

    public function totalstockregisteropeningrecivied($item_id)
    {

        $articles = TableRegistry::get('Stockregister');
        return $articles->find('all')->select(['quantity' => $articles->find('all')->func()->sum('Stockregister.quantity')])->where(['Stockregister.status !=' => 'N', 'Stockregister.item_id' => $item_id, 'Stockregister.store_type' => '4'])->order(['Stockregister.id' => 'DESC'])->toarray();
    }

    public function totalstockregisteropeningrecivied1($item_id)
    {

        $articles = TableRegistry::get('Stockregister');
        return $articles->find('all')->select(['quantity' => $articles->find('all')->func()->sum('Stockregister.quantity')])->where(['Stockregister.status !=' => 'N', 'Stockregister.item_id' => $item_id, 'Stockregister.store_type' => '4'])->order(['Stockregister.id' => 'DESC'])->first();
    }

    public function totalstockregisteropeningdispatched($item_id)
    {

        $articles = TableRegistry::get('Stockregister');
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('Stockregister.quantity')])->where(['Stockregister.item_id' => $item_id, 'Stockregister.status !=' => 'N', 'Stockregister.store_type' => '2'])->order(['Stockregister.id' => 'DESC'])->toarray();
    }

    public function findheadermenu()
    {
        $articles = TableRegistry::get('PermissionModules');
        $ids = $this->request->session()->read('Auth.User.id');
        $data = $articles->find('all')->where(['PermissionModules.user_id' => $ids, 'PermissionModules.featured' => '1'])->order(['PermissionModules.id' => 'ASC'])->toarray();
        foreach ($data as $key => $value) {
            $article = TableRegistry::get('Permissions');
            $short_name = $article->find('all')->select(['short_name'])->where(['Permissions.module' => $value['module'], 'Permissions.controller' => $value['controller'], 'Permissions.action' => $value['action'], 'Permissions.menu' => $value['menu']])->first();
            $data[$key]['short_name'] = $short_name['short_name'];
        }
        return $data;
    }

    public function findstatuspermission($user = null, $menu = null, $controller = null, $action = null)
    {
        $articles = TableRegistry::get('PermissionModules');

        return $articles->find('all')->select(['PermissionModules.featured'])->where(['PermissionModules.user_id' => $user, 'PermissionModules.menu' => $menu, 'PermissionModules.controller' => $controller, 'PermissionModules.action' => $action])->order(['PermissionModules.id' => 'ASC'])->first();
    }

    public function co_class_teacherfind($class_id = null, $section_id = null, $type = null)
    {
        $articles = TableRegistry::get('Classteachers');
        return $articles->find('all')->where(['Classteachers.class_id' => $class_id, 'Classteachers.section_id' => $section_id, 'Classteachers.teacher_type' => $type])->first();
    }
    public function co_class_teachername($teach_id = null)
    {
        $articles = TableRegistry::get('Employees');
        return $articles->find('all')->where(['Employees.id' => $teach_id])->first();
    }
    public function branchcity($dbname = null)
    {
        $this->connection(DB_NAME);
        $connss = ConnectionManager::get(DB_NAME);
        $studentrfidsd = $connss->execute("SELECT * FROM `schools` where `school_database`='" . $dbname . "'");


        // $studentrfidsd = $connss->execute("SELECT * FROM `school_erp.school` LEFT JOIN students ON attendreports.rfid = students.rf_id LEFT JOIN classes ON students.class_id = classes.id  WHERE students.class_id='" . $classs . "' AND students.section_id='" . $sectionid . "' AND students.rf_id !='0' AND students.status='Y' AND DATE(attendreports.resultdate)='" . $date . "' GROUP BY attendreports.rfid  ORDER BY section_id ASC");
        return $studentrfidsd->fetchAll('assoc');
    }



    public function billtaxdatanew($tax, $id)
    {
        //$this->connection('canvas');
        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        if ($dbname != $branch[0]) {
        }

        $connss = ConnectionManager::get($branch[0]);
        if ($tax == 0) {
            $studentrfidsd = $connss->execute("SELECT * FROM `branchrequestdetail` where `branchrequest_id`='" . $id . "' and item_tax ='" . $tax . "' ");
        } else {
            $studentrfidsd = $connss->execute("SELECT * FROM `branchrequestdetail` where `branchrequest_id`='" . $id . "' and `item_tax`='" . $tax . "' ");
        }
        $data = $studentrfidsd->fetchAll('assoc');

        foreach ($data as $value) {
            $total_amount = $value['item_qty'] * $value['item_amount'];
            $total_discount = $value['item_qty'] * $value['discount'];
            $taxable_amount += $total_amount - $total_discount;
        }
        return $taxable_amount;
    }

    public function billgst($tax, $id)
    {
        //$this->connection('canvas');
        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        if ($dbname != $branch[0]) {
        }

        $connss = ConnectionManager::get($branch[0]);
        if ($tax == 0) {
            $studentrfidsd = $connss->execute("SELECT * FROM `branchrequestdetail` where `branchrequest_id`='" . $id . "'and item_tax ='" . $tax . "'");
        } else {
            $studentrfidsd = $connss->execute("SELECT * FROM `branchrequestdetail` where `branchrequest_id`='" . $id . "' and `item_tax`='" . $tax . "' ");
        }
        $data = $studentrfidsd->fetchAll('assoc');

        foreach ($data as $value) {
            $total_amount = $value['item_qty'] * $value['item_amount'];
            $total_discount = $value['item_qty'] * $value['discount'];
            $taxable_amount = $total_amount - $total_discount;

            $taxable_amountdata += $total_amount - $total_discount;
            $tax_amountdata += $taxable_amount * $value['item_tax'] / 100;
            $totalamount_data += $taxable_amount + $tax_amount;
        }

        return $tax_amountdata;
    }


    public function billtotalamount($tax, $id)
    {
        //$this->connection('canvas');
        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        if ($dbname != $branch[0]) {
        }

        $connss = ConnectionManager::get($branch[0]);

        if ($tax == 0) {
            $studentrfidsd = $connss->execute("SELECT * FROM `branchrequestdetail` where `branchrequest_id`='" . $id . "' and item_tax ='" . $tax . "' ");
        } else {
            $studentrfidsd = $connss->execute("SELECT * FROM `branchrequestdetail` where `branchrequest_id`='" . $id . "' and `item_tax`='" . $tax . "' ");
        }
        $data = $studentrfidsd->fetchAll('assoc');

        foreach ($data as $value) {
            $total_amount = $value['item_qty'] * $value['item_amount'];
            $total_discount = $value['item_qty'] * $value['discount'];
            $taxable_amount = $total_amount - $total_discount;
            $tax_amount = $taxable_amount * $value['item_tax'] / 100;
            $totalamount += $taxable_amount + $tax_amount;
        }

        return $totalamount;
    }


    public function soldtaxdatanew($tax, $id)
    {
        //$this->connection('canvas');
        $dbname = $this->request->session()->read('Auth.User.db');
        $connss = ConnectionManager::get($dbname);
        if ($tax == 0) {
            $studentrfidsd = $connss->execute("SELECT * FROM `solditemsdetail` where `sold_id`='" . $id . "' and item_tax ='" . $tax . "' ");
        } else {
            $studentrfidsd = $connss->execute("SELECT * FROM `solditemsdetail` where `sold_id`='" . $id . "' and `item_tax`='" . $tax . "' ");
        }
        $data = $studentrfidsd->fetchAll('assoc');

        foreach ($data as $value) {
            $total_amount = $value['item_qty'] * $value['item_amount'];
            $total_discount = $value['item_qty'] * $value['discount'];
            $taxable_amount += $total_amount - $total_discount;
        }

        return $taxable_amount;
    }


    public function soldgst($tax, $id)
    {
        //$this->connection('canvas');
        $dbname = $this->request->session()->read('Auth.User.db');
        $connss = ConnectionManager::get($dbname);
        if ($tax == 0) {
            $studentrfidsd = $connss->execute("SELECT * FROM `solditemsdetail` where `sold_id`='" . $id . "' and item_tax ='" . $tax . "' ");
        } else {
            $studentrfidsd = $connss->execute("SELECT * FROM `solditemsdetail` where `sold_id`='" . $id . "' and `item_tax`='" . $tax . "' ");
        }
        $data = $studentrfidsd->fetchAll('assoc');

        foreach ($data as $value) {
            $total_amount = $value['item_qty'] * $value['item_amount'];
            $total_discount = $value['item_qty'] * $value['discount'];
            $taxable_amount = $total_amount - $total_discount;

            $taxable_amountdata += $total_amount - $total_discount;
            $tax_amountdata += $taxable_amount * $value['item_tax'] / 100;
            $totalamount_data += $taxable_amount + $tax_amount;
        }

        return $tax_amountdata;
    }


    public function soldtotalamount($tax, $id)
    {
        //$this->connection('canvas');
        $dbname = $this->request->session()->read('Auth.User.db');
        $connss = ConnectionManager::get($dbname);
        if ($tax == 0) {
            $studentrfidsd = $connss->execute("SELECT * FROM `solditemsdetail` where `sold_id`='" . $id . "' and item_tax ='" . $tax . "' ");
        } else {
            $studentrfidsd = $connss->execute("SELECT * FROM `solditemsdetail` where `sold_id`='" . $id . "' and `item_tax`='" . $tax . "' ");
        }
        $data = $studentrfidsd->fetchAll('assoc');

        foreach ($data as $value) {
            $total_amount = $value['item_qty'] * $value['item_amount'];
            $total_discount = $value['item_qty'] * $value['discount'];
            $taxable_amount = $total_amount - $total_discount;
            $tax_amount = $taxable_amount * $value['item_tax'] / 100;
            $totalamount += $taxable_amount + $tax_amount;
        }

        return $totalamount;
    }

    // Find School Information 
    public function findschoolinformation($school_name)
    {
        // pr($school_name);die;
        $connss = ConnectionManager::get(DB_NAME);
        $school_information = $connss->execute("SELECT * FROM `schools` where `school_database`='" . $school_name . "' ");
        // pr($school_information);die;
        return $school_information->fetchAll('assoc');
    }

    public function schoollogo($school_name)
    {
        // pr($school_name);die;
        $connss = ConnectionManager::get($school_name);
        $school_information = $connss->execute("SELECT * FROM `sitesettings_details`");
        // pr($school_information);die;
        return $school_information->fetchAll('assoc');
    }



    public function finditems($id)
    {
        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        if ($dbname != $branch[0]) {
        }

        $connss = ConnectionManager::get($branch[0]);
        $studentrfidsd = $connss->execute("SELECT stadd.*,taxmaster.id as tax_id,taxmaster.tax as tax_name  FROM `st_additem` stadd LEFT JOIN `st_taxmaster` taxmaster ON stadd.tax = taxmaster.id WHERE stadd.id ='" . $id . "'");
        return $studentrfidsd->fetchAll('assoc');
    }
    public function connection_query($dbs)
    {
        //echo $dbs; die;
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

    public function connection($dbname)
    {
        ConnectionManager::config($dbname, [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => MYSQLHOST,
            'username' => MYSQLUESRNAME,
            'password' => MYSQLPASSWORD,
            'database' => $dbname,
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
        ]);
    }

    public function findexamtemplate($classid, $accademicyear)
    {
        // pr($classid);
        // pr($term);die;
        $articles = TableRegistry::get('Examresulttemplate');
        if ($classid <= 6) {
            // echo '1-5';die;
            return $articles->find('all')->where(['groupid' => '1', 'acedmicyear' => $accademicyear])->first();
        } else if ($classid == 7 || $classid == 8 || $classid == 9) {
            // echo '6-8';die;
            return $articles->find('all')->where(['groupid' => '2', 'acedmicyear' => $accademicyear])->first();
        } else if ($classid == 10 || $classid == 11) {
            // echo '9-10';die;
            return $articles->find('all')->where(['groupid' => '3', 'acedmicyear' => $accademicyear])->first();
        } else if ($classid == 12 || $classid == 13 || $classid == 15) {
            // echo '11';die;
            return $articles->find('all')->where(['groupid' => '4', 'acedmicyear' => $accademicyear])->first();
        } else {
            // echo '12';die;
            return $articles->find('all')->where(['groupid' => '5', 'acedmicyear' => $accademicyear])->first();
        }
    }


    public function findtemplatename($template_id, $groupid)
    {

        $connss = $this->connection(DB_NAME);
        $connss = ConnectionManager::get(DB_NAME);
        $studentrfidsd = $connss->execute("SELECT * FROM `examtemplates` where `id`='" . $template_id . "' and `group_name`='" . $groupid . "' ");
        // pr($studentrfidsd);die;
        return $studentrfidsd->fetchAll('assoc');
    }

    public function checkresultupload($classid, $term)
    {
        $articles = TableRegistry::get('Studentexamresult');

        return $articles->find('all')->where(['Studentexamresult.class_id' => $classid, 'Studentexamresult.term' => $term])->first();
    }
    public function findgroupitemstore($category_id, $group_type, $branch_name)
    {

        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        if ($dbname != $branch[0]) {
        }

        $connss = ConnectionManager::get($branch[0]);

        $studentrfidsd = $connss->execute("SELECT * FROM `tempbranchrequest` where `category_id`='" . $category_id . "' and `group_type`='" . $group_type . "' and `branch_name`='" . $branch_name . "' ");
        return $studentrfidsd->fetchAll('assoc');
    }

    public function branchdataget($dbnamese = null)
    {
        //echo $dbname; die;
        if ($this->request->session()->read('Auth.User.db') == $dbnamese) {
        } else {

            $connss = $this->connection($dbnamese);
        }
        $connss = ConnectionManager::get($dbnamese);
        $studentrfidsd = $connss->execute("SELECT * FROM `sitesettings`");
        return $studentrfidsd->fetchAll('assoc');
    }

    public function branchdataget_detail($dbnamese = null)
    {

        $connss = ConnectionManager::get($dbnamese);
        $studentrfidsd = $connss->execute("SELECT * FROM `sitesettings_details`");
        return $studentrfidsd->fetchAll('assoc');
    }

    // public function findbranchname()
    // {
    //     $connss = $this->connection('canvas');
    //     $connss = ConnectionManager::get('canvas');
    //     $branch_name= $connss->execute("SELECT  * FROM  `users` where `db`='canvas'");
    //     return $branch_name->fetchAll('assoc');
    // }


    public function checkUserEmail($email)
    {
        $token = array(
            "iss" => API_KEY,
            "exp" => time() + 3600 //60 seconds as suggested
        );
        $getJWTKey = JWT::encode($token, API_SECRET);
        $curl = curl_init();
        // $email = "yogesh@doomshell.com";
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.zoom.us/v2/users/email?email=' . $email,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $getJWTKey,
                ),
            )
        );

        $json = curl_exec($curl);

        $jp = (string) json_encode($json);
        $acc = explode(":", $jp);
        return substr($acc[1], 0, 4);
    }


    public function cashstore($date)
    {
        $this->loadModel('Branchrequest');
        $articles = TableRegistry::get('branchrequest');
        $mode = "Cash";
        $date_refine = date('Y-m-d', strtotime($date));
        //   echo $date_refine; //die;
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('branchrequest.payamount')])->where(['branchrequest.mode_payment' => $mode, 'DATE(branchrequest.approved_date)' => $date_refine])->first();
    }

    public function chequestore($date)
    {
        $this->loadModel('Studentfees');
        $articles = TableRegistry::get('branchrequest');
        $mode = "Cheque";
        $date_refine = date('Y-m-d', strtotime($date));
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('branchrequest.payamount')])->where(['branchrequest.mode_payment' => $mode, 'DATE(branchrequest.approved_date)' => $date_refine])->first();
    }

    public function onlinestore($date)
    {
        $this->loadModel('Studentfees');
        $articles = TableRegistry::get('branchrequest');
        $mode = "Online";
        $date_refine = date('Y-m-d', strtotime($date));
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('branchrequest.payamount')])->where(['branchrequest.mode_payment' => $mode, 'DATE(branchrequest.approved_date)' => $date_refine])->first();
    }


    public function cashfee($date)
    {
        $this->loadModel('Studentfees');
        $articles = TableRegistry::get('student_feeallocations');
        $mode = "CASH";
        $date_refine = date('Y-m-d', strtotime($date));
        //   echo $date_refine; //die;
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('student_feeallocations.deposite_amt')])->where(['student_feeallocations.mode' => $mode, 'DATE(student_feeallocations.created)' => $date_refine])->first();
    }

    public function chequefee($date)
    {
        $this->loadModel('Studentfees');
        $articles = TableRegistry::get('student_feeallocations');
        $mode = "CHEQUE";
        $date_refine = date('Y-m-d', strtotime($date));
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('student_feeallocations.deposite_amt')])->where(['student_feeallocations.mode' => $mode, 'DATE(student_feeallocations.created)' => $date_refine])->first();
    }

    public function ddfee($date)
    {
        $this->loadModel('Studentfees');
        $articles = TableRegistry::get('student_feeallocations');
        $mode = "DD";
        $date_refine = date('Y-m-d', strtotime($date));
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('student_feeallocations.deposite_amt')])->where(['student_feeallocations.mode' => $mode, 'DATE(student_feeallocations.created)' => $date_refine])->first();
    }

    public function netbankingfee($date)
    {
        $this->loadModel('Studentfees');
        $articles = TableRegistry::get('student_feeallocations');
        $mode = "NETBANKING";
        $date_refine = date('Y-m-d', strtotime($date));
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('student_feeallocations.deposite_amt')])->where(['student_feeallocations.mode' => $mode, 'DATE(student_feeallocations.created)' => $date_refine])->first();
    }

    public function ccdcfee($date)
    {
        $this->loadModel('Studentfees');
        $articles = TableRegistry::get('student_feeallocations');
        $mode = "Credit Card/Debit Card/UPI";
        $date_refine = date('Y-m-d', strtotime($date));
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('student_feeallocations.deposite_amt')])->where(['student_feeallocations.mode' => $mode, 'DATE(student_feeallocations.created)' => $date_refine])->first();
    }


    public function getsection($id)
    {
        $articles = TableRegistry::get('Sections');
        return $articles->find('all')->where(['Sections.id IN' => $id])->toarray();
    }


    public function vendorgst($id)
    {

        $articles = TableRegistry::get('Companymaster');
        return $articles->find('all')->where(['Companymaster.id' => $id])->order(['Companymaster.id' => 'ASC'])->toarray();
    }

    public function cash_store($id)
    {

        $articles = TableRegistry::get('branchrequest');
        return $articles->find('all')->where(['branchrequest.id' => $id])->order(['branchrequest.id' => 'ASC'])->toarray();
    }



    //sold item daily collection 
    public function cashsolditems($date)
    {

        $articles = TableRegistry::get('solditems');
        $mode = "Cash";
        $date_refine = date('Y-m-d', strtotime($date));
        //   echo $date_refine; //die;
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('solditems.payamount')])->where(['solditems.mode_payment' => $mode, 'solditems.status' => 'Approved', 'DATE(solditems.pay_date)' => $date_refine])->first();
    }

    public function chequesolditems($date)
    {

        $articles = TableRegistry::get('solditems');
        $mode = "Cheque";
        $date_refine = date('Y-m-d', strtotime($date));
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('solditems.payamount')])->where(['solditems.mode_payment' => $mode, 'solditems.status' => 'Approved', 'DATE(solditems.pay_date)' => $date_refine])->first();
    }
    public function discountsolditems($date)
    {

        $articles = TableRegistry::get('solditems');
        $mode = "Online";
        $date_refine = date('Y-m-d', strtotime($date));
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('solditems.discount')])->where(['solditems.status' => 'Approved', 'DATE(solditems.pay_date)' => $date_refine])->first();
    }

    public function onlinesolditems($date)
    {

        $articles = TableRegistry::get('solditems');
        $mode = "Online";
        $date_refine = date('Y-m-d', strtotime($date));
        return $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('solditems.payamount')])->where(['solditems.mode_payment' => $mode, 'solditems.status' => 'Approved', 'DATE(solditems.pay_date)' => $date_refine])->first();
    }

    public function findcompanyname($id, $branch_name)
    {

        $branch_name[0] == 'canvas';
        $dbname = 'canvas_' . $id;
        $connss = $this->connection($dbname);
        $connss = ConnectionManager::get($dbname);
        $studentrfidsd = $connss->execute("SELECT * FROM `sitesettings_details`");
        return $studentrfidsd->fetchAll('assoc');
    }

    public function branchsales($dbnamese = null)
    {
        //echo $dbname; die;
        if ($this->request->session()->read('Auth.User.db') == $dbnamese) {
        } else {

            $connss = $this->connection($dbnamese);
        }
        $connss = ConnectionManager::get($dbnamese);
        $studentrfidsd = $connss->execute("SELECT * FROM `sitesettings`");
        return $studentrfidsd->fetchAll('assoc');
    }

    public function branchsales_detail($dbnamese = null)
    {

        $connss = ConnectionManager::get($dbnamese);
        $studentrfidsd = $connss->execute("SELECT * FROM `sitesettings_details`");
        return $studentrfidsd->fetchAll('assoc');
    }



    public function billtaxdatasale($tax, $id)
    {
        //$this->connection('canvas');
        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        if ($dbname != $branch[0]) {
        }

        $connss = ConnectionManager::get($branch[0]);
        if ($tax == 0) {
            $studentrfidsd = $connss->execute("SELECT * FROM `salesreturndetails` where `salereturn_id`='" . $id . "' and item_tax ='" . $tax . "' ");
        } else {
            $studentrfidsd = $connss->execute("SELECT * FROM `salesreturndetails` where `salereturn_id`='" . $id . "' and `item_tax`='" . $tax . "' ");
        }
        $data = $studentrfidsd->fetchAll('assoc');

        foreach ($data as $value) {
            $total_amount = $value['item_qty'] * $value['item_amount'];
            $total_discount = $value['item_qty'] * $value['discount'];
            $taxable_amount += $total_amount - $total_discount;
        }

        return $taxable_amount;
    }


    public function billgstsale($tax, $id)
    {
        //$this->connection('canvas');
        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        if ($dbname != $branch[0]) {
        }

        $connss = ConnectionManager::get($branch[0]);
        if ($tax == 0) {
            $studentrfidsd = $connss->execute("SELECT * FROM `salesreturndetails` where `salereturn_id`='" . $id . "'and item_tax ='" . $tax . "'");
        } else {
            $studentrfidsd = $connss->execute("SELECT * FROM `salesreturndetails` where `salereturn_id`='" . $id . "' and `item_tax`='" . $tax . "' ");
        }
        $data = $studentrfidsd->fetchAll('assoc');

        foreach ($data as $value) {
            $total_amount = $value['item_qty'] * $value['item_amount'];
            $total_discount = $value['item_qty'] * $value['discount'];
            $taxable_amount = $total_amount - $total_discount;

            $taxable_amountdata += $total_amount - $total_discount;
            $tax_amountdata += $taxable_amount * $value['item_tax'] / 100;
            $totalamount_data += $taxable_amount + $tax_amount;
        }

        return $tax_amountdata;
    }


    public function billtotalamountsale($tax, $id)
    {
        //$this->connection('canvas');
        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        if ($dbname != $branch[0]) {
        }

        $connss = ConnectionManager::get($branch[0]);

        if ($tax == 0) {
            $studentrfidsd = $connss->execute("SELECT * FROM `salesreturndetails` where `salereturn_id`='" . $id . "' and item_tax ='" . $tax . "' ");
        } else {
            $studentrfidsd = $connss->execute("SELECT * FROM `salesreturndetails` where `salereturn_id`='" . $id . "' and `item_tax`='" . $tax . "' ");
        }
        $data = $studentrfidsd->fetchAll('assoc');

        foreach ($data as $value) {
            $total_amount = $value['item_qty'] * $value['item_amount'];
            $total_discount = $value['item_qty'] * $value['discount'];
            $taxable_amount = $total_amount - $total_discount;
            $tax_amount = $taxable_amount * $value['item_tax'] / 100;
            $totalamount += $taxable_amount + $tax_amount;
        }

        return $totalamount;
    }

    public function getfranchise()
    {

        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        $dbnames = $branch[0];
        $connss = ConnectionManager::get('default');
        if ($dbname == DB_NAME) {
            $studentrfidsd = $connss->execute("SELECT * FROM $dbname.`users` where `role_id`= 101");
            return $studentrfidsd->fetchAll('assoc');
        } else {
            $studentrfidsd = $connss->execute("SELECT * FROM $dbnames.`users` where `role_id`= 105");
            return $studentrfidsd->fetchAll('assoc');
        }

        // $studentrfidsd =  "SELECT * FROM $dbname.`users` where `role_id`= 105"; 



    }
    public function followupenquires($id)
    {
        $articles = TableRegistry::get('Followup');
        // $datefrom = date('Y-m-d', strtotime($datefrom));
        return $articles->find('all')->where(['Followup.enq_id' => $id])->contain(['Enquires'])->order(['Followup.f_date' => 'ASC'])->first();
    }


    // mis report comman helper start

    public function findcoldenqcount($id)
    {
        $articles = TableRegistry::get('Enquires');

        if ($id == 'NULL') {
            return $articles->find('all')->where(['Enquires.status' => 'Y', 'Enquires.lead_type IN' => ['Cold Lead', 'Cold'], 'Enquires.state IS NULL'])->count();
        } else {
            return $articles->find('all')->where(['Enquires.status' => 'Y', 'Enquires.lead_type IN' => ['Cold Lead', 'Cold'], 'Enquires.state' => $id])->count();
        }
    }
    public function findfollowupenqcount($id)
    {
        $articles = TableRegistry::get('Enquires');
        if ($id == 'NULL') {
            return $articles->find('all')->where(['Enquires.status' => 'Y', 'Enquires.lead_type IN' => ['Follow Up Lead', 'Follow Up'], 'Enquires.state IS NULL'])->count();
        } else {
            return $articles->find('all')->where(['Enquires.status' => 'Y', 'Enquires.lead_type IN' => ['Follow Up Lead', 'Follow Up'], 'Enquires.state' => $id])->count();
        }
    }
    public function findnotinterstedenqcount($id)
    {
        $articles = TableRegistry::get('Enquires');

        if ($id == 'NULL') {
            return $articles->find('all')->where(['Enquires.status' => 'Y', 'Enquires.lead_type ' => 'Not Interested', 'Enquires.state IS NULL'])->count();
        } else {
            return $articles->find('all')->where(['Enquires.status' => 'Y', 'Enquires.lead_type ' => 'Not Interested', 'Enquires.state' => $id])->count();
        }
    }
    public function findinterstedenqcount($id)
    {
        $articles = TableRegistry::get('Enquires');

        if ($id == 'NULL') {

            return $articles->find('all')->where(['Enquires.status' => 'Y', 'Enquires.lead_type ' => 'Interested', 'Enquires.state IS NULL'])->count();
        } else {

            return $articles->find('all')->where(['Enquires.status' => 'Y', 'Enquires.lead_type ' => 'Interested', 'Enquires.state' => $id])->count();
        }
    }

    public function findhotenqcount($id)
    {
        $articles = TableRegistry::get('Enquires');

        if ($id == 'NULL') {
            return $articles->find('all')->where(['Enquires.status' => 'Y', 'Enquires.lead_type' => 'Hot Lead', 'Enquires.state IS NULL'])->count();
        } else {
            return $articles->find('all')->where(['Enquires.status' => 'Y', 'Enquires.lead_type' => 'Hot Lead', 'Enquires.state' => $id])->count();
        }
    }
    // converted lead count
    public function findconvertedenqcount($id)
    {
        $articles = TableRegistry::get('Enquires');

        if ($id == 'NULL') {
            return $articles->find('all')->where(['Enquires.status' => 'Y', 'Enquires.lead_type' => 'Converted', 'Enquires.state IS NULL'])->count();
        } else {
            return $articles->find('all')->where(['Enquires.status' => 'Y', 'Enquires.lead_type' => 'Converted', 'Enquires.state' => $id])->count();
        }
    }

    // new lead count
    public function findnewleadenqcount($id)
    {
        $articles = TableRegistry::get('Enquires');

        if ($id == 'NULL') {
            return $articles->find('all')->where(['Enquires.status' => 'Y', 'Enquires.lead_type' => 'New lead', 'Enquires.state IS NULL'])->count();
        } else {
            return $articles->find('all')->where(['Enquires.status' => 'Y', 'Enquires.lead_type' => 'New lead', 'Enquires.state' => $id])->count();
        }
    }

    // closed count
    public function findclosedenqcount($id)
    {
        $articles = TableRegistry::get('Enquires');

        if ($id == 'NULL') {
            return $articles->find('all')->where(['Enquires.status' => 'N', 'Enquires.state IS NULL'])->count();
        } else {
            return $articles->find('all')->where(['Enquires.status' => 'N', 'Enquires.state' => $id])->count();
        }
    }


    //prm report
    public function getprmcountreport($value)
    {
        $this->connection($value);
        $connss = ConnectionManager::get($value);


        $get_cold_count = $connss->execute("SELECT count(*) as get_cold_count FROM enquires where lead_type IN('Cold','Cold Lead') AND status='Y'");
        $get_followup_count = $connss->execute("SELECT count(*) as get_followup_count  FROM enquires where lead_type IN('Follow Up Lead','Follow Up') AND status='Y'");

        $get_notinterstesd_count = $connss->execute("SELECT count(*) as get_notinterstesd_count FROM enquires where lead_type = 'Not Interested' AND status='Y'");

        $get_interstesd_count = $connss->execute("SELECT count(*) as get_interstesd_count FROM  enquires where lead_type = 'Interested' AND status='Y'");

        $get_hot_count = $connss->execute("SELECT count(*) as get_hot_count FROM enquires where lead_type = 'Hot Lead' AND status='Y'");

        $get_converted_count = $connss->execute("SELECT count(*) as get_converted_count FROM enquires where lead_type = 'Converted' AND status='Y'");

        $get_newlead_count = $connss->execute("SELECT count(*) as get_newlead_count FROM enquires where lead_type = 'New Lead' AND status='Y'");

        $get_closed_count = $connss->execute("SELECT count(*) as get_colsed_count FROM enquires where  status='N'");

        $total_count['cold_count'] = $get_cold_count->fetch('assoc');
        $total_count['followup_count'] = $get_followup_count->fetch('assoc');
        $total_count['notinterested_count'] = $get_notinterstesd_count->fetch('assoc');
        $total_count['interested_count'] = $get_interstesd_count->fetch('assoc');
        $total_count['hot_count'] = $get_hot_count->fetch('assoc');
        $total_count['converted_count'] = $get_converted_count->fetch('assoc');
        $total_count['newlead_count'] = $get_newlead_count->fetch('assoc');
        $total_count['closed_count'] = $get_closed_count->fetch('assoc');


        return $total_count;
    }

    // admission mis report
    public function admissionmiscount($value, $fromdata = null, $todates = null)
    {
        $this->connection($value);
        $connss = ConnectionManager::get($value);
        // today
        $current_date = date('Y-m-d');
        $get_ftd_count = $connss->execute("SELECT count(*) as get_ftd_count FROM students where DATE(students.created) = '$current_date' AND status='Y'");



        // mont wise//
        // commented by ramesh( 11.7.23)
        // $get_mtd_count = $connss->execute("SELECT count(*) as get_mtd_count FROM students  WHERE YEAR(created) = YEAR(CURRENT_DATE()) AND  MONTH(created) = MONTH(CURRENT_DATE()) ");


        // month wise 
        if (!empty($fromdata) && !empty($todates)) {
            $get_mtd_count = $connss->execute("SELECT count(*) as get_mtd_count FROM students  WHERE  DATE(students.created) >= '$fromdata' AND DATE(students.created) <= '$todates'");
        } else {
            $get_mtd_count = $connss->execute("SELECT count(*) as get_mtd_count FROM students  WHERE YEAR(created) = YEAR(CURRENT_DATE()) AND  MONTH(created) = MONTH(CURRENT_DATE()) ");
        }



        // session wise dropout student

        $strat_date = date('Y-04-01');
        $end_year = date('Y') + 1;
        $end_session_date = date($end_year . -'03' . -'31');
        // Query Commented by ramesh
        // $get_dropout_count = $connss->execute("SELECT count(*) as get_dropout_count FROM drop_out_students where DATE(drop_out_students.created) >= '$strat_date' AND DATE(drop_out_students.created) <='$end_session_date'");


        // $get_dropout_count = $connss->execute("SELECT count(*) as get_dropout_count FROM drop_out_students where  acedmicyear='2023-24'");



        // dropout student search based
        if (!empty($fromdata) && !empty($todates)) {
            $get_dropout_count = $connss->execute("SELECT count(*) as get_dropout_count FROM drop_out_students where  DATE(drop_out_students.created) >= '$fromdata' AND DATE(drop_out_students.created) <= '$todates'");
        } else {
            $get_dropout_count = $connss->execute("SELECT count(*) as get_dropout_count FROM drop_out_students where DATE(drop_out_students.created) >= '$strat_date' AND DATE(drop_out_students.created) <='$end_session_date'");
        }






        // ytd wise report
        $strat_date = date('Y-04-01');
        $end_year = date('Y') + 1;
        $end_session_date = date($end_year . -'03' . -'31');

        // $get_ytd_count = $connss->execute("SELECT count(*) as get_ytd_count FROM students where DATE(students.created) >= '$strat_date' AND DATE(students.created) <='$end_session_date'");


        // commented code ramesh(10-7-2023)
        // $get_ytd_count = $connss->execute("SELECT count(*) as get_ytd_count FROM students where acedmicyear in ('2023-24') and `status` ='Y'");

        // commented by ramesh (11-07-2023)
        // $get_is_promote_count = $connss->execute("SELECT count(*) as get_is_promote_count FROM students where acedmicyear in ('2022-23') and `is_promote` ='0' and  `status` ='Y'");

        if (!empty($fromdata) && !empty($todates)) {
            $get_is_promote_count = $connss->execute("SELECT count(*) as get_is_promote_count FROM students where DATE(students.created) >= '$fromdata' AND DATE(students.created) <= '$todates' and `is_promote` ='0' and  `status` ='Y'");
        } else {
            $get_is_promote_count = $connss->execute("SELECT count(*) as get_is_promote_count FROM students where acedmicyear in ('2022-23') and `is_promote` ='0' and  `status` ='Y'");
        }


        // code ramesh ( 10-7-2023)
        if (!empty($fromdata) && !empty($todates)) {
            $get_ytd_count = $connss->execute("SELECT count(*) as get_ytd_count FROM students where DATE(students.created) >= '$fromdata' AND DATE(students.created) <= '$todates' AND status='Y'");
        } else {
            $get_ytd_count = $connss->execute("SELECT count(*) as get_ytd_count FROM students where acedmicyear in ('2023-24') and `status` ='Y'");
        }


        $total_counts['ftd_count'] = $get_ftd_count->fetch('assoc');
        $total_counts['mtd_count'] = $get_mtd_count->fetch('assoc');
        $total_counts['dropout_count'] = $get_dropout_count->fetch('assoc');
        $total_counts['ytd_count'] = $get_ytd_count->fetch('assoc');
        $total_counts['is_promote_count'] = $get_is_promote_count->fetch('assoc');
        return $total_counts;
    }

    // due fees mis report 

    public function duefeesmisreport($value, $fromdata = null, $todates = null)
    {
        $this->connection($value);
        $connss = ConnectionManager::get($value);
        $strat_date = date('Y-04-01');
        $end_year = date('Y') + 1;
        $end_session_date = date($end_year . -'03' . -'31');
        $get_student_count = $connss->execute("SELECT count(*) as get_student_count FROM students where acedmicyear='2022-23' and `status` ='Y' ");
        $get_student_info = $connss->execute("SELECT *  FROM students where acedmicyear='2022-23' and `status` ='Y'");

        foreach ($get_student_info as $value) {
            $class_id = $value['class_id'];
            $stu_id = $value['id'];
            $date = date('Y-m-d');

            $class_feeallocation = $connss->execute("SELECT * FROM class_fee_allocations where class_id = '$class_id' and academic_year ='2022-23'");
            $class_tot = $class_feeallocation->fetch('assoc');


            if ($class_tot['qu1_date'] <= $date) {
                $total_q1q2 += $class_tot['qu1_fees'];

                $get_studentfeeallocation = $connss->execute("SELECT * FROM student_feeallocations  where student_id='$stu_id'  AND  status = 'Y' AND acedmicyear='2022-23'");
                $studentfeesdetails = $get_studentfeeallocation->fetchAll('assoc');
                foreach ($studentfeesdetails as $value) {
                    $quas = unserialize($value['quarter']);
                    $total_deposit_amt += $value['deposite_amt'];

                    $firstquarter_amt += $total_deposit_amt - $quas['Quater1'];
                    if ($firstquarter_amt < 0) {
                        $firstpending_amt += $firstquarter_amt;
                    }

                    $total_collection_first += $quas['Quater1'];
                }
                $second_qtr = 1;
            }

            if ($class_tot['qu2_date'] <= $date) {
                $total_q1q2 += $class_tot['qu2_fees'];

                $get_studentfeeallocation = $connss->execute("SELECT * FROM student_feeallocations  where student_id='$stu_id'  AND  status = 'Y' AND acedmicyear='2022-23'");
                $studentfeesdetails = $get_studentfeeallocation->fetchAll('assoc');
                foreach ($studentfeesdetails as $value) {
                    $quas = unserialize($value['quarter']);
                    if ($firstpending_amt < 0) {
                        $secondquarter_amt_pending += $firstpending_amt + $quas['Quater2'];
                    } else {
                        $secondquarter_amt += $firstquarter_amt - $quas['Quater2'];
                    }

                    $total_collection_second += $quas['Quater2'];
                }
                $thirdqtr = 1;
            } else if ($second_qtr == 1) {
                $total_q1q2 += $class_tot['qu2_fees'];
                $get_studentfeeallocation = $connss->execute("SELECT * FROM student_feeallocations  where student_id='$stu_id'  AND  status = 'Y' AND acedmicyear='2022-23'");
                $studentfeesdetails = $get_studentfeeallocation->fetchAll('assoc');
                foreach ($studentfeesdetails as $value) {
                    $quas = unserialize($value['quarter']);
                    if ($pending_amt < 0) {
                        $secondquarter_amt_pending += $pending_amt + $quas['Quater2'];
                    } else {
                        $secondquarter_amt += $firstquarter_amt - $quas['Quater2'];
                    }

                    $total_collection_second += $quas['Quater2'];
                }
                $thirdqtr = 0;
            } else {
                $total_q1q2 += 0;
                $thirdqtr = 0;
            }

            if ($class_tot['qu3_date'] <= $date) {
                $total_q1q2 += $class_tot['qu3_fees'];
                $get_studentfeeallocation = $connss->execute("SELECT * FROM student_feeallocations  where student_id='$stu_id'  AND  status = 'Y' AND acedmicyear='2022-23'");
                $studentfeesdetails = $get_studentfeeallocation->fetchAll('assoc');
                foreach ($studentfeesdetails as $value) {
                    $quas = unserialize($value['quarter']);

                    if ($secondquarter_amt_pending < 0) {
                        $thirdquarter_amt_pending += $secondquarter_amt_pending + $quas['Quater3'];
                    } else {
                        $thirdquarter_amt += $secondquarter_amt - $quas['Quater3'];
                    }
                    $total_collection_third += $quas['Quater3'];
                }

                $fourthqtr = 1;
            } else if ($thirdqtr == 1) {
                $total_q1q2 += $class_tot['qu3_fees'];
                $get_studentfeeallocation = $connss->execute("SELECT * FROM student_feeallocations  where student_id='$stu_id'  AND  status = 'Y' AND acedmicyear='2022-23'");
                $studentfeesdetails = $get_studentfeeallocation->fetchAll('assoc');
                foreach ($studentfeesdetails as $value) {
                    $quas = unserialize($value['quarter']);
                    if ($secondquarter_amt_pending < 0) {
                        $thirdquarter_amt_pending += $secondquarter_amt_pending + $quas['Quater3'];
                    } else {
                        $thirdquarter_amt += $secondquarter_amt - $quas['Quater3'];
                    }

                    $total_collection_third += $quas['Quater3'];
                }
                $fourthqtr = 0;
            } else {
                $total_q1q2 += 0;
                $fourthqtr = 0;
            }

            if ($class_tot['qu4_date'] <= $date || $fourthqtr == 1) {

                $total_q1q2 += $class_tot['qu4_fees'];
                $get_studentfeeallocation = $connss->execute("SELECT * FROM student_feeallocations  where student_id='$stu_id'  AND  status = 'Y' AND acedmicyear='2022-23'");
                $studentfeesdetails = $get_studentfeeallocation->fetchAll('assoc');
                foreach ($studentfeesdetails as $value) {
                    $quas = unserialize($value['quarter']);
                    if ($thirdquarter_amt_pending < 0) {
                        $fourthquarter_amt_pending += $thirdquarter_amt_pending + $quas['Quater4'];
                    } else {
                        $fourthquarter_amt += $thirdquarter_amt - $quas['Quater4'];
                    }

                    $total_collection_fourth += $quas['Quater4'];
                }
            }
        }
        //  echo $total_collection_first; die;
        $total_collection = $total_collection_first + $total_collection_second + $total_collection_third + $total_collection_fourth;
        $total_pending_amt = $firstpending_amt + $secondquarter_amt_pending + $thirdquarter_amt_pending + $fourthquarter_amt_pending;

        $total_counts['student_count'] = $get_student_count->fetch('assoc');
        $total_counts['que_due_collection'] = $total_pending_amt;
        $total_counts['total_collection'] = $total_collection;
        $total_counts['total_collection_quarters'] = $total_q1q2;
        return $total_counts;
    }

    // public function duefeesmisreport($value)
    // {

    //     $this->connection($value);
    //     $connss = ConnectionManager::get($value);
    //     $strat_date = date('Y-04-01');
    //     $end_year = date('Y') + 1;
    //     $end_session_date = date($end_year . -'03' . -'31');

    //     //total student count
    //     $get_student_count = $connss->execute("SELECT count(*) as get_student_count FROM students where acedmicyear='2022-23' and `status` ='Y' ");

    //     //total collection
    //     $get_total_collection = $connss->execute("SELECT sum(deposite_amt) as total_collection_count FROM student_feeallocations ");

    //     //quter wise due fees 
    //     $get_student_info = $connss->execute("SELECT *  FROM students where acedmicyear='2022-23' and `status` ='Y' LIMIT 0,5");
    //     $total_discount = 0;
    //     $total_que_fees = 0;
    //     $alldiscount = 0;
    //     $fee = 0;
    //     $total_dueq1q2=0;
    //     $deposite_amt = 0;
    //     foreach ($get_student_info as $value) {
    //         $class_id = $value['class_id'];
    //         $stu_id = $value['id'];
    //       //  pr($stu_id);
    //         //find Que wise student total fees structure
    //         $class_feeallocation = $connss->execute("SELECT * FROM class_fee_allocations where class_id = '$class_id' and academic_year ='2022-23'");

    //         $que_data =  $class_feeallocation->fetchAll('assoc');
    //         // pr($que_data);exit;
    //         // get student que fees deposite details
    //         $get_studentfeeallocation = $connss->execute("SELECT * FROM student_feeallocations  where student_id='$stu_id'  AND  status = 'Y' AND acedmicyear='2022-23' ");

    //         $studentfeesdetails =  $get_studentfeeallocation->fetchAll('assoc');

    //         foreach ($studentfeesdetails as  $value) {
    //             // pr($value);
    //             $alldiscount += $value['addtionaldiscount'] + $value['discount'] ;
    //             $deposite_amt += $value['deposite_amt'];
    //             $fee += $value['fee'];
    //             $quas[] = unserialize($value['quarter']);
    //         // pr('total_discount..'.$alldiscount);
    //         // pr('total_deposite..'.$deposite_amt); 
    //         // pr('total_fees..'.$fee); 
    //         }

    //         foreach ($quas as $key => $val) {
    //             $data_keys =  array_keys($val);
    //             foreach ($data_keys as $valddd) {
    //                 $lst_st_data[$valddd]   =  $val[$valddd];
    //             }
    //             //pr($lst_st_data); 
    //         }//die;

    //         if (array_key_exists("Quater1", $lst_st_data) || array_key_exists("Quater2", $lst_st_data)) {

    //             if (array_key_exists("Quater1", $lst_st_data) && array_key_exists("Quater2", $lst_st_data)) {
    //                 // pr('if');exit;
    //                 $total_dueq1q2 += $fee - $alldiscount-$deposite_amt;


    //             } else if (array_key_exists("Quater1", $lst_st_data)) {
    //                 $total_dueq1q2 += $que_data[0]['qu2_fees'];
    //             } else {
    //                 // pr('q1q2');exit;
    //                 $total_dueq1q2 += $que_data[0]['qu1_fees'] + $que_data[0]['qu2_fees'];
    //             }

    //             // pr($total_dueq1q2);exit;
    //         }
    //     }//die;

    //     // pr('total_collection..'.$deposite_amt);
    //     // pr('Dueq1q2..'.$total_dueq1q2);
    //     // pr('Disc..'.$alldiscount);
    //     //  $finel_due=$deposite_amt-$deposite_amt;
    //     // pr('test____'.$finel_due);
    //     // die;

    //     $total_counts['student_count'] = $get_student_count->fetch('assoc');
    //     $total_counts['total_collection'] = $deposite_amt;
    //     $total_counts['que_due_collection'] = $total_dueq1q2;
    //     $total_counts['finel_due_fees'] = $finel_due;
    //     return $total_counts;
    // }


    public function studentdropreport($value, $fromdata = null, $todates = null)
    {
        $this->connection($value);
        $connss = ConnectionManager::get($value);
        $strat_date = date('Y-04-01');
        $end_session_date = date('Y-m-d');


        $drop_mtd_count = $connss->execute("SELECT count(*) as get_mtd_count FROM drop_out_students  WHERE YEAR(created) = YEAR(CURRENT_DATE()) AND  MONTH(created) = MONTH(CURRENT_DATE()) ");

        // $get_ytd_count = $connss->execute("SELECT count(*) as get_ytd_count FROM drop_out_students where DATE(drop_out_students.created) >= '$strat_date' AND DATE(drop_out_students.created) <='$end_session_date'");
        $get_ytd_count = $connss->execute("SELECT count(*) as get_ytd_count FROM drop_out_students where  acedmicyear='2023-24'");

        if (!empty($fromdata) && !empty($todates)) {
            $get_ytd_count = $connss->execute("SELECT count(*) as get_ytd_count FROM drop_out_students  where DATE(drop_out_students.created) >= '$fromdata' AND DATE(drop_out_students.created) <= '$todates' ");
        } else {
            $get_ytd_count = $connss->execute("SELECT count(*) as get_ytd_count FROM drop_out_students where  acedmicyear='2023-24'");
        }

        $total_counts['get_mtd_count'] = $drop_mtd_count->fetch('assoc');
        $total_counts['get_ytd_count'] = $get_ytd_count->fetch('assoc');
        return $total_counts;
    }

    //find school address for student pdf id card
    public function schooladdress($school_name)
    {
        // pr($school_name);die;
        $connss = ConnectionManager::get($school_name);
        $school_information = $connss->execute("SELECT * FROM `sitesettings_details`");
        // pr($school_information);die;
        return $school_information->fetchAll('assoc');
    }

    public function findtopitems($id)
    {
        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        if ($dbname != $branch[0]) {
        }

        $connss = ConnectionManager::get($branch[0]);
        $studentrfidsd = $connss->execute("SELECT stadd.*,taxmaster.id as tax_id,taxmaster.tax as tax_name  FROM `st_additem` stadd LEFT JOIN `st_taxmaster` taxmaster ON stadd.tax = taxmaster.id WHERE stadd.id ='" . $id . "'");
        return $studentrfidsd->fetchAll('assoc');
    }

    public function findbottomitems($id)
    {
        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        if ($dbname != $branch[0]) {
        }

        $connss = ConnectionManager::get($branch[0]);
        $studentrfidsd = $connss->execute("SELECT stadd.*,taxmaster.id as tax_id,taxmaster.tax as tax_name  FROM `st_additem` stadd LEFT JOIN `st_taxmaster` taxmaster ON stadd.tax = taxmaster.id WHERE stadd.id ='" . $id . "'");
        return $studentrfidsd->fetchAll('assoc');
    }

    public function findsocksitems($id)
    {
        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        if ($dbname != $branch[0]) {
        }

        $connss = ConnectionManager::get($branch[0]);
        $studentrfidsd = $connss->execute("SELECT stadd.*,taxmaster.id as tax_id,taxmaster.tax as tax_name  FROM `st_additem` stadd LEFT JOIN `st_taxmaster` taxmaster ON stadd.tax = taxmaster.id WHERE stadd.id ='" . $id . "'");
        return $studentrfidsd->fetchAll('assoc');
    }

    public function finditeamnames($id)
    {
        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        if ($dbname != $branch[0]) {
        }

        $connss = ConnectionManager::get($branch[0]);
        $studentrfidsd = $connss->execute("SELECT stadd.*,taxmaster.id as tax_id,taxmaster.tax as tax_name  FROM `st_additem` stadd LEFT JOIN `st_taxmaster` taxmaster ON stadd.tax = taxmaster.id WHERE stadd.id ='" . $id . "'");
        // pr($studentrfidsd); die;
        return $studentrfidsd->fetchAll('assoc');
    }

    public function findbillitemname($id)
    {
        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        if ($dbname != $branch[0]) {
        }

        $connss = ConnectionManager::get($branch[0]);
        $studentrfidsd = $connss->execute("SELECT stadd.*,taxmaster.id as tax_id,taxmaster.tax as tax_name  FROM `st_additem` stadd LEFT JOIN `st_taxmaster` taxmaster ON stadd.tax = taxmaster.id WHERE stadd.id ='" . $id . "'");
        // pr($studentrfidsd); die;
        return $studentrfidsd->fetchAll('assoc');
    }

    public function findbilltax($id)
    {
        $dbname = $this->request->session()->read('Auth.User.db');
        $branch = explode("_", $dbname);
        if ($dbname != $branch[0]) {
        }

        $connss = ConnectionManager::get($branch[0]);
        $studentrfidsd = $connss->execute("SELECT stadd.*,taxmaster.id as tax_id,taxmaster.tax as tax_name  FROM `st_additem` stadd LEFT JOIN `st_taxmaster` taxmaster ON stadd.tax = taxmaster.id WHERE stadd.id ='" . $id . "'");
        // pr($studentrfidsd); die;
        return $studentrfidsd->fetchAll('assoc');
    }


    public function getpurchasereturncount($item_id)
    {

        $articles = TableRegistry::get('Stockregister');
        return $articles->find('all')->select(['sum' => 'SUM(Stockregister.quantity)'])->where(['Stockregister.store_type' => '5', 'Stockregister.item_id' => $item_id])->first();
        //  ->find('all')->where(['Stockregister.item_id'=$item_id,'Stockregister.store_type'=>5])->count();


    }
    //sanjay code 28-12-2022
    public function helpcount($slug)
    {
        $conns = ConnectionManager::get('default');
        $dbname = DB_NAME;
        $query1 = "SELECT count(*) as count FROM $dbname.help where help.slug='$slug' ";
        return $resultall = $conns->execute($query1)->fetchAll('assoc');
    }


    public function feedbackdata($value)
    {
        $this->connection($value);
        $connss = ConnectionManager::get($value);


        //$feedback_data = $connss->execute("SELECT *  FROM  feedbacks");
        $feedback_data = $connss->execute("SELECT  feedbacks.*, feedback_categories.name
        FROM feedbacks  INNER JOIN feedback_categories  ON  feedbacks.feedback_cat_id = feedback_categories.id and feedbacks.status='N'");
        return $feedback_data->fetchAll('assoc');
    }



    public function searchfeedbackdata($branch_name, $status)
    {
        $this->connection($branch_name);
        $connss = ConnectionManager::get($branch_name);

        $feedback_data = $connss->execute("SELECT  feedbacks.*, feedback_categories.name
        FROM feedbacks  INNER JOIN feedback_categories  ON  feedbacks.feedback_cat_id = feedback_categories.id and feedbacks.status='$status'");

        return $feedback_data->fetchAll('assoc');
    }


    public function getapplogincount($value)
    {
        if ($value == $this->request->session()->read('Auth.User.db')) {
            $connss = ConnectionManager::get('default');

            $app_login_data = $connss->execute("SELECT  students.fname,students.middlename,students.lname,students.fathername,students.enroll,users.db,classes.title,sections.title as sections_name,users.install_date,users.last_login  FROM students  Left JOIN users  ON  students.id = users.student_id 
            INNER JOIN classes ON classes.id = students.class_id INNER JOIN sections ON sections.id = students.section_id   Where students.status = 'Y' and users.role_id=2 order by classes.title asc ");
            return $app_login_data->fetchAll('assoc');
        } else {
            $this->connection($value);
            $connss = ConnectionManager::get($value);

            $app_login_data = $connss->execute("SELECT  students.fname,students.middlename,students.lname,students.fathername,students.enroll,users.db,classes.title,sections.title as sections_name,users.install_date,users.last_login  FROM students  Left JOIN users  ON  students.id = users.student_id INNER JOIN classes ON classes.id = students.class_id INNER JOIN sections ON sections.id = students.section_id   Where students.status = 'Y' and users.role_id=2 order by classes.title asc");

            return $app_login_data->fetchAll('assoc');
        }
    }

    //staff app login details function
    public function getstaffapplogincount($id)
    {

        if ($id == $this->request->session()->read('Auth.User.db')) {
            $connss = ConnectionManager::get('default');

            $staff_app_login_data = $connss->execute("SELECT  employees.fname,employees.middlename,employees.lname,employees.mobile,users.db,users.install_date,users.last_login  FROM employees  left JOIN users  ON  employees.id = users.tech_id Where users.role_id in(3,21) and employees.status='Y' order by employees.fname asc");
            return $staff_app_login_data->fetchAll('assoc');
        } else {
            $this->connection($id);
            $connss = ConnectionManager::get($id);
            $staff_app_login_data = $connss->execute("SELECT  employees.fname,employees.middlename,employees.lname,employees.mobile,users.db,users.install_date,users.last_login  FROM employees  left JOIN users  ON  employees.id = users.tech_id Where users.role_id in(3,21) and employees.status='Y' order by employees.fname asc ");
            return $staff_app_login_data->fetchAll('assoc');
        }
    }


    public function findschoolname($id)
    {
        // pr($id); die;//
        $connss = ConnectionManager::get('default');
        $query2 = "SELECT * FROM `schools` where id = $id";
        return $connss->execute($query2)->fetchAll('assoc');
    }


    public function findsubjname($id)
    {

        $articles = TableRegistry::get('ExamSubjects');
        $find_subj_name = $articles->find('all')->where(['ExamSubjects.id IN' => $id])->toarray();
        foreach ($find_subj_name as $val) {
            $sub_name[] = $val['subject'];
        }
        $dssds = implode(',', $sub_name);
        return $dssds;
    }

    public function finddesignationname($id = null)
    {
        $articles = TableRegistry::get('PayrollDesignations');

        return $articles->find('all')->where(['id' => $id])->first();
    }

    //Gajanand Code Start
    public function getProfileCompletion($students, $doc_img, $address, $classessss, $employees)
    {
        //This condition is old code condition this is not mine
        if ($students['comp_sid']) {
            return 100;
        } elseif (count($doc_img) > 0) {
            return 80;
        } else if (!empty($students['file'])) {
            return 60;
        } else if ($address['c_address']) {
            return 40;
        } elseif ($classessss['fullname']) {
            return 30;
        } elseif ($employees['fname']) {
            return 10;
        } else {
            return 0;
        }
    }
    //Gajanand Code End
    // Rakesh code start
    public function findexambatch($id = null)
    {
        $articles = TableRegistry::get('academic_year');
        $batch = $articles->find('all')->where(['id' => $id])->first();
        return $batch;
    }

    public function findstudentid($student_id = null, $subject_id = Null, $exam_id = null)
    {
        $articles = TableRegistry::get('Exam_result');
        $AllExamResult = $articles->find('all')->where(['Exam_result.student_id' => $student_id, 'Exam_result.subject_id' => $subject_id, 'Exam_result.exam_id IN' => [$exam_id, 0]])->first();
        if (!empty($AllExamResult)) {
            $result = ($AllExamResult['result'] == null) ? 'P' : $AllExamResult['result'];
        } else {
            $result = 'NA';
        }
        return $result;
    }

    public function backstudent($student_id = null, $subject_id = null)
    {
        // find backstudent subject
        $articles = TableRegistry::get('Exam_result');
        $exam_result = $articles->find('all')->where(['Exam_result.exam_id' => 0, 'Exam_result.student_id' => $student_id, 'Exam_result.subject_id NOT IN' => $subject_id])->first();
        if ($student_id == $exam_result['student_id']) {
            return 'NA';
        } else {
            return '';
        }
    }

    public function findsubjectmarks($student_id = Null, $subject_id = Null, $exam_id = null)
    {
        // find Subject Total Marks for student 
        $articles = TableRegistry::get('SubjectMarks');
        $exam_result = TableRegistry::get('ExamResult');
        $AllExamResult = $exam_result->find('all')->where(['ExamResult.student_id' => $student_id, 'ExamResult.subject_id' => $subject_id, 'ExamResult.exam_id IN' => [$exam_id, 0]])->first();
        if (!empty($AllExamResult)) {
            $subject_marks = $articles->find('all')->where(['SubjectMarks.subject_id' => $subject_id, 'SubjectMarks.exam_id' => $exam_id])->first();
            $subject_marks = $subject_marks['marks'];
        } else {
            $subject_marks = 0;
        }
        return $subject_marks;

        // find total obtain marks for student
        // $articles = TableRegistry::get('StudentFinalResult');
        // $findOptainMarks = $articles->find('all')->where(['StudentFinalResult.student_id' => $student_id,'StudentFinalResult.exam_id' => $exam_id])->first();
        // return $findOptainMarks['total_marks'];
    }

    public function findEligibleForStudent($student_id = null, $course_id = null, $section_id = null)
    {
        // find eligible student find use in pdf exam result
        $eligibleFind = TableRegistry::get('ExamResult');
        $articles = TableRegistry::get('Students');
        $classSection = TableRegistry::get('Classections');

        $sections = $classSection->find('list', [
            'keyField' => 'Sections.id',
            'valueField' => 'Sections.title',
        ])->contain(['Sections'])->where(['Classections.class_id' => $course_id])->order(['Sections.id' => 'DESC'])->first();

        $findEligible = $eligibleFind->find('all')->where(['ExamResult.student_id' => $student_id, 'ExamResult.result NOT IN' => 'P'])->toarray();
        if (count($findEligible) == 0) {
            return 'Yes';
        }

        foreach ($findEligible as $eligible) {
            $findStudents = $articles->find('all')->select(['id', 'fname', 'lname', 'class_id', 'section_id'])->where(['Students.id' => $eligible['student_id'], 'Students.class_id NOT IN' => $sections])->toarray();
            if (count($findStudents) > 0) {
                return 'Yes';
            } else {
                return 'No';
            }
        }
    }

    public function findTotalOptainMarks($student_id = null, $course_id = null, $exam_id = null)
    {
        // find total obtain marks for student
        $articles = TableRegistry::get('StudentFinalResult');
        $findOptainMarks = $articles->find('all')->where(['StudentFinalResult.student_id' => $student_id, 'StudentFinalResult.course_id' => $course_id, 'StudentFinalResult.exam_id' => $exam_id])->first();

        return $findOptainMarks['obtained_marks'] = ($findOptainMarks['obtained_marks'] > 0) ? $findOptainMarks['obtained_marks'] : 0;
    }

    public function findBackStudentSubject($student_id = null)
    {
        $articles = TableRegistry::get('ExamResult');
        $CourseSubject = TableRegistry::get('CourseSubjects');
        // find Back Student
        $backStudentSubject = $articles->find('all')->where(['ExamResult.student_id' => $student_id, 'ExamResult.exam_id' => 0])->distinct('subject_id')->toarray();
        $subjectId = [];
        foreach ($backStudentSubject as $backSubject) {
            $subjectId[] = $backSubject['subject_id'];
        }
        // Find Back Student Subject Name
        $SubjectName = $CourseSubject->find('all')->where(['CourseSubjects.id IN' => $subjectId])->toarray();
        $subName = [];
        foreach ($SubjectName as $subjectTitle) {
            $subName[] = $subjectTitle['subject'];
        }
        $StudentSubjectName = implode(', ', $subName);
        return $StudentSubjectName;
    }

    public function findExamResultIsNotNull($exam_id = null)
    {
        $articles = TableRegistry::get('ExamResult');
        $result = $articles->find('all')->where(['ExamResult.exam_id' => $exam_id])->count();
        return $result;
    }

    // Rakesh code end
    public function findpaidamountsmodetyaaaaa($a_year, $datefrom, $dateto, $mode, $key)
    {
        //    echo $datefrom;
        //    echo $key;  

        $articles = TableRegistry::get('Studentfees');
        // Start a new query.
        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));
        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        // pr($rolepresent);exit;
        if ($rolepresent == '5' || $rolepresent == '6' || $rolepresent == '1') {
            // echo "sanjay"; 
            return $articles->find('all')->contain(['Students'])->select(['total' => $articles->find()->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.mode' => $mode, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.recipetno !=' => '0', 'Studentfees.paydate <=' => $dateto, 'Students.class_id IN' => $key, 'Studentfees.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        } else if ($rolepresent == '8') {

            return $articles->find('all')->contain(['Students'])->where(['Studentfees.mode' => $mode, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate <=' => $dateto, 'Students.class_id IN' => ['23', '24', '25', '26', '27', '28', '29'], 'Studentfees.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        } else {

            return $articles->find('all')->contain(['Students'])->where(['Studentfees.mode' => $mode, 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate >=' => $datefrom, 'Studentfees.paydate <=' => $dateto, 'Studentfees.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
        }
    }

    // sanjay

    public function findfeemonth_classwise($mode = null, $datedfrom = null, $datedto = null, $key)
    {
        // pr ($mode);
        // pr ($datedfrom); 
        // pr ($datedto); die;

        $articles = TableRegistry::get('Studentfees');

        // Start a new query.

        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        // pr($rolepresent); die;
        if ($rolepresent == '5' || $rolepresent == '6' || $rolepresent == 1) {
            // $sum1 = $articles->find('all')->contain(['Students'])->select(['total' => $articles->find()->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.mode' => $mode, 'Studentfees.type !=' => 'Other','Students.class_id IN'=>$key ,'Studentfees.paydate >=' => $datedfrom, 'Studentfees.paydate <=' => $datedto, 'Studentfees.recipetno != ' => 0, 'Studentfees.status' => 'Y'])->order(['paydate' => 'DESC'])->toArray();

            $sum1 = $articles->find('all')->contain(['Students'])->select(['total' => $articles->find()->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.mode' => $mode, 'Studentfees.paydate >=' => $datedfrom, 'Studentfees.type !=' => 'Other', 'Studentfees.recipetno !=' => 0, 'Studentfees.paydate <=' => $datedto, 'Students.class_id IN' => $key, 'Studentfees.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();

            // foreach($sum1 as $value){
            //     pr($value);

            // }

            // $sum2 = $articles->find('all')->contain(['DropOutStudent'])->select(['total' => $articles->find()->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.mode' => $mode, 'Studentfees.type !=' => 'Other', 'Studentfees.paydate >=' => $datedfrom, 'Studentfees.paydate <=' => $datedto, 'Studentfees.recipetno != ' => 0, 'Studentfees.status' => 'Y', 'DropOutStudent.board_id IN' => ['1', '2']])->order(['paydate' => 'DESC'])->toArray();
            // if($mode=='NETBANKING'){
            // pr($sum1);
            // }

            return $art[0]['total'] = $sum1[0]['total'] + $sum2[0]['total'];
        }
    }
    public function findexpansediscription($id1)
    {
        $articles = TableRegistry::get('Expense');
        return $articles->find()->select(['title', 'id'])->where(['Expense.id' => $id1])->first();
    }
    public function findexpansename($id1)
    {

        $articles = TableRegistry::get('ExpenseCategory');
        return $articles->find()->select(['category_name', 'id'])->where(['ExpenseCategory.id' => $id1])->first();
        // pr($return);die;
    }
    public function getMonthTotal($ex_cat_id, $month, $year = null)
    {
        if (empty($year)) {
            $year = date('Y');
        }

        if (date('m') > 3) {
            $cond['Date(ExpenseDetail.add_date) >='] = date($year . '-04-01');
            $cond['Date(ExpenseDetail.add_date) <='] = date(($year + 1) . '-03-31');
        } else {
            $cond['Date(ExpenseDetail.add_date) >='] = date(($year - 1) . '-04-01');
            $cond['Date(ExpenseDetail.add_date) <='] = date($year . '-03-31');
        }

        $articles = TableRegistry::get('ExpenseDetail');
        $sum = $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('amount')])->where(['MONTH(add_date)' => $month, $cond, 'exp_cat_id' => $ex_cat_id])->first();
        return ($sum);
    }



    public function getMonthTotalSum($month, $year = null)
    {
        if (empty($year)) {
            $year = date('Y');
        }
        if (date('m') > 3) {
            $cond['Date(ExpenseDetail.add_date) >='] = date($year . '-04-01');
            $cond['Date(ExpenseDetail.add_date) <='] = date(($year + 1) . '-03-31');
        } else {
            $cond['Date(ExpenseDetail.add_date) >='] = date(($year - 1) . '-04-01');
            $cond['Date(ExpenseDetail.add_date) <='] = date($year . '-03-31');
        }

        $articles = TableRegistry::get('ExpenseDetail');
        $sum = $articles->find('all')->select(['sum' => $articles->find('all')->func()->sum('amount')])->where(['MONTH(add_date)' => $month, $cond])->first();
        return ($sum);
    }

    // for get pending fee datails by rajesh kumar 26-06-2024
    public function getstudenttotalfeesdetails($students_details)
    {
        $classfee_articles = TableRegistry::get('Classfee');
        $Studentfees_articles = TableRegistry::get('Studentfees');

        // ******************Fees Deposite start************************
        //other all fees 
        $studentfeesother = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.status' => 'Y'])->andWhere(['OR' => ['Studentfees.quarter_name IS' => null, 'Studentfees.quarter_name' => '']])->first();
        $studentfeescaution = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Collage Caution Money (Refundable)', 'Studentfees.status' => 'Y'])->first();
        $studentfeesother['total'] = $studentfeesother['sum'] + $studentfeescaution['sum'];
        // for quarter1 deposite fees
        $studentfeesquarter1 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Quater1', 'Studentfees.status' => 'Y'])->first();
        // for quarter2 deposite fees
        $studentfeesquarter2 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Quater2', 'Studentfees.status' => 'Y'])->first();
        // for quarter3 deposite fees
        $studentfeesquarter3 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Quater3', 'Studentfees.status' => 'Y'])->first();
        // for quarter4 deposite fees
        $studentfeesquarter4 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Quater4', 'Studentfees.status' => 'Y'])->first();
        // for transport1 deposite fees
        $studentfeestransport1 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Transport1', 'Studentfees.status' => 'Y'])->first();
        // for transport2 deposite fees
        $studentfeestransport2 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Transport2', 'Studentfees.status' => 'Y'])->first();
        // for transport3 deposite fees
        $studentfeestransport3 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Transport3', 'Studentfees.status' => 'Y'])->first();
        // for transport4 deposite fees
        $studentfeestransport4 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Transport4', 'Studentfees.status' => 'Y'])->first();
        // for previous year due deposite
        $studentfeesprevious = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.deposite_amt')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter_name' => 'Previous Year Due', 'Studentfees.status' => 'Y'])->first();


        // total fess of each quarter
        //quarter1
        $student_rec['1st_year_students_fee_deposite'] = $studentfeesquarter1['sum'] + $studentfeesother['total'];
        $student_rec['1st_year_students_fee_deposite'] = $student_rec['1st_year_students_fee_deposite'] > 0 ? $student_rec['1st_year_students_fee_deposite'] : 0;
        //quarter2
        $student_rec['2nd_year_students_fee_deposite'] = $studentfeesquarter2['sum'] > 0 ? $studentfeesquarter2['sum'] : 0;
        //quarter3
        $student_rec['3rd_year_students_fee_deposite'] = $studentfeesquarter3['sum'] > 0 ? $studentfeesquarter3['sum'] : 0;
        //quarter4
        $student_rec['4th_year_students_fee_deposite'] = $studentfeesquarter4['sum'] > 0 ? $studentfeesquarter4['sum'] : 0;


        if ($students_details['is_transport'] == 'Y') {
            //transport1
            $student_rec['1st_year_students_transport_deposite'] = $studentfeestransport1['sum'] > 0 ? $studentfeestransport1['sum'] : 0;
            //transport2
            $student_rec['2nd_year_students_transport_deposite'] = $studentfeestransport2['sum'] > 0 ? $studentfeestransport2['sum'] : 0;
            //transport3
            $student_rec['3rd_year_students_transport_deposite'] = $studentfeestransport3['sum'] > 0 ? $studentfeestransport3['sum'] : 0;
            //transport4
            $student_rec['4th_year_students_transport_deposite'] = $studentfeestransport4['sum'] > 0 ? $studentfeestransport4['sum'] : 0;
        } else {
            $student_rec['1st_year_students_transport_deposite'] = 'NA';
            $student_rec['2nd_year_students_transport_deposite'] = 'NA';
            $student_rec['3rd_year_students_transport_deposite'] = 'NA';
            $student_rec['4th_year_students_transport_deposite'] = 'NA';
        }
        //previous_year
        $student_rec['previous_year_students_fee_deposite'] = $studentfeesprevious['sum'] > 0 ? $studentfeesprevious['sum'] : 0;

        // for discount
        // quarter1 discount
        $studentDiscountQuarter1 = $Studentfees_articles->find('all')->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.addtionaldiscount')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y'])->andWhere(['Studentfees.quarter_name IN' => ['', 'Collage Caution Money (Refundable)', 'Previous Year Due', 'Quater1', 'Transport1']])->first();
        $student_rec['1st_year_students_discount'] = $studentDiscountQuarter1['sum'] > 0 ? $studentDiscountQuarter1['sum'] : 0;
        // quarter2 discount
        $studentDiscountQuarter2 = $Studentfees_articles->find('all')
            ->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.addtionaldiscount')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y'])->andWhere(['Studentfees.quarter_name IN' => ['Quater2', 'Transport2']])->first();
        $student_rec['2nd_year_students_discount'] = $studentDiscountQuarter2['sum'] > 0 ? $studentDiscountQuarter2['sum'] : 0;
        // quarter3 discount
        $studentDiscountQuarter3 = $Studentfees_articles->find('all')
            ->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.addtionaldiscount')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y'])->andWhere(['Studentfees.quarter_name IN' => ['Quater3', 'Transport3']])->first();
        $student_rec['3rd_year_students_discount'] = $studentDiscountQuarter3['sum'] > 0 ? $studentDiscountQuarter3['sum'] : 0;
        // quarter4 discount
        $studentDiscountQuarter4 = $Studentfees_articles->find('all')
            ->select(['sum' => $Studentfees_articles->find('all')->func()->sum('Studentfees.addtionaldiscount')])->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y'])->andWhere(['Studentfees.quarter_name IN' => ['Quater4', 'Transport4']])->first();
        $student_rec['4th_year_students_discount'] = $studentDiscountQuarter4['sum'] > 0 ? $studentDiscountQuarter4['sum'] : 0;
        // pr($student_rec);die;


        $studentfeesdetails = $Studentfees_articles->find('all')->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.refrencepending' => '0', 'Studentfees.status' => 'Y'])->andWhere(['Studentfees.quarter_name NOT IN' => ['Hostel Charges ( 2 Beded )', 'Hostel Charges ( 3 Beded )']])->toarray();
        $student_rec['discount'] = 0;
        foreach ($studentfeesdetails as $k => $value) {
            $student_rec['discount'] += $value['discount'];
            $student_rec['discount'] += $value['addtionaldiscount'];
        }
        // **********************Fees Deposite end********************


        // **********************Total of  Course Fees Start ********************

        // for tution fee
        $classfee = $classfee_articles->find('all')->contain(['Feesheads'])->where(['Classfee.class_id' => $students_details['class_id'], 'Classfee.academic_year' => $students_details['batch'], 'Feesheads.type IN' => [1]])->order(['Feesheads.type' => 'asc'])->toarray();
        // total of head which include in quarter1
        $addmissiontimehead = $classfee_articles->find('all')->contain(['Feesheads'])->where(['Classfee.class_id' => $students_details['class_id'], 'Classfee.academic_year' => $students_details['batch'], 'Feesheads.type IN' => [2]])->order(['Feesheads.type' => 'asc'])->toarray();
        //for transport fee
        $transporthead = $classfee_articles->find('all')->contain(['Feesheads'])->where(['Classfee.class_id' => $students_details['class_id'], 'Classfee.academic_year' => $students_details['batch'], 'Feesheads.type IN' => [3]])->order(['Feesheads.type' => 'asc'])->toarray();

        // to check special case
        if ($students_details['is_special'] == 'Y') {
            $studentfeesdetails = $Studentfees_articles->find('all')->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.recipetno' => '0', 'Studentfees.status' => 'Y'])->toarray();
            $fessHeads = [];
            foreach ($studentfeesdetails as $k => $value) {
                $quas = unserialize($value['quarter']);
                foreach ($quas as $key => $val) {
                    if (!empty($key) && !in_array($key, $fessHeads)) {
                        $fessHeads[] = $key;
                    }
                }
            }
        }


        //quarter1
        if (!in_array('Quater1', $fessHeads)) {
            $tution_fees = $classfee[0]['qu1_fees'];
        }
        // all fee head which incude in quarter1
        if (!in_array($addmissiontimehead['0']['feeshead']['name'], $fessHeads)) {
            $admission_fees = $addmissiontimehead[0]['qu1_fees'];
        }
        if (!in_array($addmissiontimehead['1']['feeshead']['name'], $fessHeads)) {
            $collage_caution_fees = $addmissiontimehead[1]['qu1_fees'];
        }
        if (!in_array($addmissiontimehead['2']['feeshead']['name'], $fessHeads)) {
            $Uniform = $addmissiontimehead[2]['qu1_fees'];
        }
        if (!in_array($addmissiontimehead['3']['feeshead']['name'], $fessHeads)) {
            $Books = $addmissiontimehead[3]['qu1_fees'];
        }
        if (!in_array($addmissiontimehead['4']['feeshead']['name'], $fessHeads)) {
            $pocketArticles = $addmissiontimehead[4]['qu1_fees'];
        }
        if (!in_array($addmissiontimehead['5']['feeshead']['name'], $fessHeads)) {
            $libraryFees = $addmissiontimehead[5]['qu1_fees'];
        }
        if (!in_array($addmissiontimehead['6']['feeshead']['name'], $fessHeads)) {
            $enrollmentFees = $addmissiontimehead[6]['qu1_fees'];
        }
        if (!in_array($addmissiontimehead['7']['feeshead']['name'], $fessHeads)) {
            $healthInsurance = $addmissiontimehead[7]['qu1_fees'];
        }
        if (!in_array($addmissiontimehead['8']['feeshead']['name'], $fessHeads)) {
            $idCard = $addmissiontimehead[8]['qu1_fees'];
        }

        // quarter1 courese total fee
        $student_rec['1st_year_total_fees'] = $tution_fees + $admission_fees + $collage_caution_fees + $Uniform + $Books + $pocketArticles + $libraryFees + $enrollmentFees + $healthInsurance + $idCard;
        $student_rec['1st_year_total_fees'] = $student_rec['1st_year_total_fees'] > 0 ? $student_rec['1st_year_total_fees'] : 'NA';

        // quarter2 courese total fee
        if (!in_array('Quater2', $fessHeads)) {
            $student_rec['2nd_year_total_fees'] = $classfee[0]['qu2_fees'] > 0 ? $classfee[0]['qu2_fees'] : 'NA';
        } else {
            $student_rec['2nd_year_total_fees'] = 'NA';
        }
        // quarter3 courese total fee
        if (!in_array('Quater3', $fessHeads)) {
            $student_rec['3rd_year_total_fees'] = $classfee[0]['qu3_fees'] > 0 ? $classfee[0]['qu3_fees'] : 'NA';
        } else {
            $student_rec['3rd_year_total_fees'] = 'NA';
        }
        // quarter4 courese total fee
        if (!in_array('Quater4', $fessHeads)) {
            $student_rec['4th_year_total_fees'] = $classfee[0]['qu4_fees'] > 0 ? $classfee[0]['qu4_fees'] : 'NA';
        } else {
            $student_rec['4th_year_total_fees'] = 'NA';
        }

        //for transport
        if ($students_details['is_transport'] == 'Y') {
            //transport1 total course fee
            if (!in_array('Transport1', $fessHeads)) {
                $transport_fees1 = $transporthead[0]['qu1_fees'];
                $student_rec['1st_year_transport_fees'] = $transport_fees1 > 0 ? $transport_fees1 : 'NA';
            } else {
                $student_rec['1st_year_transport_fees'] = 'NA';
            }
            //transport2 total course fee
            if (!in_array('Transport2', $fessHeads)) {
                $transport_fees2 = $transporthead[0]['qu2_fees'];
                $student_rec['2nd_year_transport_fees'] = $transport_fees2 > 0 ? $transport_fees2 : 'NA';
            } else {
                $student_rec['2nd_year_transport_fees'] = 'NA';
            }
            //transport3 total course fee
            if (!in_array('Transport3', $fessHeads)) {
                $transport_fees3 = $transporthead[0]['qu3_fees'];
                $student_rec['3rd_year_transport_fees'] = $transport_fees3 > 0 ? $transport_fees3 : 'NA';
            } else {
                $student_rec['3rd_year_transport_fees'] = 'NA';
            }
            //transport4 total course fee
            if (!in_array('Transport4', $fessHeads)) {
                $transport_fees4 = $transporthead[0]['qu4_fees'];
                $student_rec['4th_year_transport_fees'] = $transport_fees4 > 0 ? $transport_fees4 : 'NA';
            } else {
                $student_rec['4th_year_transport_fees'] = 'NA';
            }
        } else {
            $student_rec['1st_year_transport_fees'] = 'NA';
            $student_rec['2nd_year_transport_fees'] = 'NA';
            $student_rec['3rd_year_transport_fees'] = 'NA';
            $student_rec['4th_year_transport_fees'] = 'NA';
        }

        // for total courese previous year fee
        $studentfeesprevioustot = $Studentfees_articles->find('all')->where(['Studentfees.student_id' => $students_details['id'], 'Studentfees.quarter LIKE' => '%Previous Year Due%', 'Studentfees.status' => 'Y'])->first();
        $quas = unserialize($studentfeesprevioustot['quarter']);
        $student_rec['previous_year'] = $quas['Previous Year Due'] + $students_details['due_fees'];
        $student_rec['previous_year'] = $student_rec['previous_year'] > 0 ? $student_rec['previous_year'] : 0;
        return $student_rec;
    }




    // this function use for check depositor name print in recipte
    public function get_depositor_name($id)
    {
        $articles = TableRegistry::get('Users');
        return $articles->find('all')->where(['Users.id' => $id])->first();
    }

    public function findfees_exist_students($id)
    {
        $articles = TableRegistry::get('Studentfees');
        return $articles->exists(['Studentfees.student_id' => $id, 'Studentfees.status' => 'Y']);
    }

    public function findLastCheckOutDate($id)
    {
        $articles = TableRegistry::get('HostelFeesManagement');
        return $articles->find('all')
            ->where(['student_id' => $id])
            ->order(['HostelFeesManagement.id' => 'DESC'])
            ->first();
    }

    // for to check is last recept of quarter 17-07-24
    public function checkpendingreceipt($receiptId, $studentId, $qaurteName)
    {
        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')
            ->where([
                'Studentfees.student_id' => $studentId,
                'Studentfees.quarter_name LIKE' => '%' . $qaurteName . '%',
                'Studentfees.quarter LIKE' => '%' . $receiptId . '%',
                'Studentfees.status' => 'Y'
            ])
            ->first();
    }



    public function find_enroll_batch($s_id)
    {
        $articles = TableRegistry::get('Students');
        return $articles->find('all')->select(['batch', 'enroll'])->where(['Students.id' => $s_id])->order(['id' => 'ASC'])->first();
    }


    // this code for show the result in students view page
    public function findexam_id($stu_id)
    {
        $articles = TableRegistry::get('ExamResult');
        $exam = TableRegistry::get('Exam');

        $exam_data = $articles->find('all')->where(['ExamResult.student_id' => $stu_id])->group(['ExamResult.exam_id'])->toarray();

        $data = [];
        foreach ($exam_data as $val) {
            $exam_name = $exam->find('all')->where(['id' => $val['exam_id']])->first();

            if (empty($exam_name)) {
                continue;
            }

            $data[] = [
                'id' => $exam_name['id'],
                'exam_name' => $exam_name['exam_name'],
                'exam_year' => $exam_name['exam_year'],
                'exam_date' => $exam_name['exam_date'],
                'result_date' => $exam_name['result_date']
            ];
        }
        return $data;
    }

    public function findStudentsResult($studentId, $exam_id)
    {
        $ExamResult = TableRegistry::get('ExamResult');

        return $ExamResult->find('all', ['conditions' => ['ExamResult.student_id' => $studentId, 'exam_id' => $exam_id, 'is_backlog' => 0]])->toarray();
    }

    public function findStudentsBacklogResult($studentId)
    {
        $find_studnet_result = TableRegistry::get('ExamResult');

        return $find_studnet_result->find('all', ['conditions' => ['ExamResult.student_id' => $studentId, 'exam_id !=' => 0, 'is_backlog' => 1]])->toarray();
    }


    public function findsubjnames($subject_id = null)
    {
        $getsubj = TableRegistry::get('CourseSubjects');

        return $getsubj->find('all')->where(['CourseSubjects.id' => $subject_id])->first();
    }


    public function findsubjbacklog($subject_id)
    {
        $getsubj = TableRegistry::get('CourseSubjects');

        return $getsubj->find('all')->where(['CourseSubjects.id' => $subject_id])->first();
    }





    // for show finel result 
    public function student_finel_result($stu_id)
    {


        $articles = TableRegistry::get('StudentFinalResult');
        $exam = TableRegistry::get('Exam');

        $exam_data = $articles->find('all')->where(['StudentFinalResult.student_id' => $stu_id])->toarray();

        $data = [];
        foreach ($exam_data as $val) {
            // pr($val);
            // die;
            $exam_name = $exam->find('all')->where(['id' => $val['exam_id']])->first();

            if (empty($exam_name)) {
                continue;
            }

            $data[] = [
                'id' => $exam_name['id'],
                'exam_name' => $exam_name['exam_name'],
                'exam_year' => $val['exam_year'],
                'exam_date' => $exam_name['exam_date'],
                'result_date' => $exam_name['result_date'],
                'total_marks' => $val['total_marks'],
                'obtained_marks' => $val['obtained_marks'],
                'result' => $val['result'],

            ];
        }
        return $data;
    }
}
