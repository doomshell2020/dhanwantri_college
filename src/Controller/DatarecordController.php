<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper;

include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';
class DatarecordController extends AppController
{

  public function index()
  {
    $this->viewBuilder()->layout('admin');
    $this->loadModel('Students');
    $this->loadModel('Employees');
  }

  public function importemployee()
  {
    $this->viewBuilder()->layout('admin');
    $this->loadModel('Employees');
    if ($this->request->is('post') || $this->request->is('put')) {
      //pr($_FILES); die;
      $inputfilename = $_FILES['file']['tmp_name'];
      try {
        $objPHPExcel = \PHPExcel_IOFactory::load($inputfilename);
      } catch (Exception $e) {
        die('Error loading file "' . pathinfo($inputfilename, PATHINFO_BASENAME) . '": ' . $e->getMessage());
      }
      $sheet = $objPHPExcel->getSheet(0);
      $highestRow = $sheet->getHighestRow();
      $highestColumn = $sheet->getHighestColumn();
      $c = 0;
      for ($row = 2; $row <= $highestRow; $row++) {
        //  Read a row of data into an array
        $filesop = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);

        $fname = $filesop[0][1];
        $email = $filesop[0][2];
        $mobile = $filesop[0][3];
        $husbandname = $filesop[0][4];
        $dob =  date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($filesop[0][5]));
        $dojoing =  date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($filesop[0][6]));
        $conn = ConnectionManager::get('default');

        $db = $this->request->session()->read('Auth.User.db');
        $employee   = "INSERT INTO `$db`.`employees`(`fname`,`email`,`mobile`,`f_h_name`,`dob`,`joiningdate`) VALUES ('$fname','$email','$mobile','$husbandname','$dob','$dojoing')";
        // pr($employee); die;
        $exicute = $conn->execute($employee);
        $semployee   = "INSERT INTO `school_erp`.`employees`(`fname`,`email`,`mobile`,`f_h_name`,`dob`,`joiningdate`) VALUES ('$fname','$email','$mobile','$husbandname','$dob','$dojoing')";
        pr($semployee);
        die;
        $exicute = $conn->execute($semployee);
      }
    }
  }


  public function importstudents()
  {
    $this->viewBuilder()->layout('admin');
    $this->loadModel('Students');
    $this->loadModel('Houses');
    $this->loadModel('Classes');
    $this->loadModel('Sections');
    if ($this->request->is('post') || $this->request->is('put')) {
      //pr($_FILES); die;
      $inputfilename = $_FILES['file']['tmp_name'];
      try {
        $objPHPExcel = \PHPExcel_IOFactory::load($inputfilename);
      } catch (Exception $e) {
        die('Error loading file "' . pathinfo($inputfilename, PATHINFO_BASENAME) . '": ' . $e->getMessage());
      }

      $sheet = $objPHPExcel->getSheet(0);
      $highestRow = $sheet->getHighestRow();
      $highestColumn = $sheet->getHighestColumn();

      $c = 0;
      for ($row = 2; $row <= $highestRow; $row++) {
        //  Read a row of data into an array
        $filesop = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
        // pr($filesop); die;
        $fname = $filesop[0][1];
        $mname = $filesop[0][2];
        $lname = $filesop[0][3];
        $fee_submittedby = $filesop[0][4];
        $fathername = $filesop[0][5];
        $mothername = $filesop[0][6];
        $username = $filesop[0][7];
        $dob =  date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($filesop[0][8]));
        $enroll = $filesop[0][9];
        $mobile = $filesop[0][10];
        $sms_mobile = $filesop[0][11];
        $adaharnumber = $filesop[0][13];
        $cast = $filesop[0][14];
        $house = $filesop[0][15];

        $class = $filesop[0][16];
        $category = $filesop[0][17];
        $section = $filesop[0][18];
        $gender = $filesop[0][19];
        $stu_img = $enroll . ".JPG";
        $religion = $filesop[0][22];
        $address = $filesop[0][23];
        $father_no = $filesop[0][45];
        $mother_no = $filesop[0][46];
        $created = date('Y-m-d H:i:s', \PHPExcel_Shared_Date::ExcelToPHP($lang22));

        $address = $filesop[0][23];
        $academic_year = "2021-22";
        $comp_sid = '';

        $opt_sid = '';
        $rfidd = '0';
        $student = $this->Students->find('all')->where(['enroll' => $enroll])->first();



        $classes = $this->Classes->find('all')->where(['title' => $class])->first();
        //pr($classes); die;
        $house = $this->Houses->find('all')->where(['name' => $house])->first();
        $section = $this->Sections->find('all')->where(['title' => $section])->first();
        $classid = $classes['id'];
        if ($classid) {
          $classid = $classid;
        } else {
          $classid = 0;
        }
        $house_id = $house['id'];
        if ($house_id) {
          $house_id = $house_id;
        } else {
          $house_id = 0;
        }
        $section_id =  $section['id'];
        if ($section_id) {
          $section_id = $section_id;
        } else {
          $section_id = 0;
        }
        $ad_date = date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($filesop[0][26]));
        $ad_dateext = date('Y', strtotime($ad_date));

        $newEndingDate = date("y", strtotime(date("Y-m-d", strtotime($ad_date)) . " + 1 year"));

        $admissionyear = $ad_dateext . "-" . $newEndingDate;

        $conn = ConnectionManager::get('default');
        if ($student) {

          // $student_data =  "UPDATE `students` SET `fname`='$fname',`middlename`='$mname',`lname`='$lname',`fee_submittedby`='$fathername',`fathername`='$fathername',`mothername`='$mothername',`username`='$username',`dob`='$dob',`mobile`='$mobile',`sms_mobile`='$sms_mobile',`adaharnumber`='$adaharnumber',`cast`='$cast',`house_id`='$house_id',`class_id`='$classid',`category`='$category',`section_id`='$section_id',`gender`='$gender',`photo`='$stu_img',`religion`='$religion',`address`='$address',`admissionyear`='$admissionyear',`acedmicyear`='$academic_year',`h_id`='$house_id',`f_phone`='$father_no',`m_phone`='$mother_no' WHERE enroll =".$enroll;
          // $exicute=$conn->execute($student_data);

        } else {
          $db = $this->request->session()->read('Auth.User.db');
          $student_data = "INSERT INTO `$db`.`students`(`fname`, `middlename`, `lname`,`fee_submittedby`, `board_id`, `fathername`, `mothername`, `username`, `password`, `dob`, `enroll`, `mobile`,`sms_mobile`, `formno`, `adaharnumber`, `cast`, `parent_id`, `house_id`, `class_id`, `category`, `section_id`, `gender`, `photo`, `bloodgroup`, `religion`, `address`, `city`, `nationality`, `created`, `admissionyear`, `acedmicyear`, `status`, `file`, `comp_sid`, `opt_sid`, `h_id`, `room_no`, `is_transport`, `transportloc_id`, `v_num`, `dis_fees`,  `dis_transport`, `is_discount`, `due_fees`, `token`,`rf_id`,`f_phone`,`m_phone`) VALUES ('$fname','$mname','$lname','$fathername','1','$fathername','$mothername','$username','12345','$dob','$enroll','$mobile','$sms_mobile','43534','$adaharnumber','$cast','0','$house_id','$classid','$category','$section_id','$gender','$stu_img','O','$religion','$address','Jaipur','INDIAN','$created','$admissionyear','$academic_year','Y','','$comp_sid','$opt_sid','$house_id','','1','9','RJ-3456','0','0','0','0','d19zotIWXww:APA91bHsDcEda1obUeddDumwRF0BhrwbccFskQ','$rfidd','$father_no','$mother_no')";
          $exicute = $conn->execute($student_data);
          $last_insert_id = $this->Students->find()->select(['id'])->last();
          $last_insert_id = $last_insert_id['id'];
          $current_date = date('Y-m-d H:i:s');


          $school_data = "INSERT INTO `school_erp`.`users` (`user_name`,`c_id`,`academic_year`, `email`,`student_id`, `password`, `confirm_pass`, `created`, `modified`, `role_id`, `db`,`board`,`mobile`) VALUES
            ('$fname','2','2021-22','$enroll', '$last_insert_id','$2y$10$.vwir1Fyl5EkpHbNfEYFl.vU7raO0gFMuM.QnwVqpLM77Mjlot1Zm','12345', '2021-07-14 10:35:39', '0000-00-00 00:00:00', 2,'$db','1','$mobile')";
          $conn->execute($school_data);


          $NTSQL = "SELECT * FROM `school_erp`.`users` WHERE `student_id`= '$last_insert_id'";
          $user_data = $conn->execute($NTSQL)->fetchAll('assoc');
          $rec_data = $user_data[0]['id'];

          $school_data_user = "INSERT INTO `$db`.`users` (`id`,`user_name`,`c_id`,`academic_year`, `email`,`student_id`, `password`, `confirm_pass`, `created`, `modified`, `role_id`, `db`,`board`,`mobile`) VALUES
            ('$rec_data','$fname','2','2021-22','$enroll', '$last_insert_id','$2y$10$.vwir1Fyl5EkpHbNfEYFl.vU7raO0gFMuM.QnwVqpLM77Mjlot1Zm','12345', '$current_date', '0000-00-00 00:00:00', 2,'$db','1','$mobile')";
          $conn->execute($school_data_user);
          // echo "upload"; die;
        }
      }
    }
    // pr($student); die;
  }

  public function  importlibrarydata()
  {

    $this->viewBuilder()->layout('admin');
    $this->loadModel('Students');
    $this->loadModel('Book');

    if ($this->request->is('post') || $this->request->is('put')) {
      //pr($_FILES); die;
      $inputfilename = $_FILES['file']['tmp_name'];
      try {
        $objPHPExcel = \PHPExcel_IOFactory::load($inputfilename);
      } catch (Exception $e) {
        die('Error loading file "' . pathinfo($inputfilename, PATHINFO_BASENAME) . '": ' . $e->getMessage());
      }

      $sheet = $objPHPExcel->getSheet(0);
      $highestRow = $sheet->getHighestRow();
      $highestColumn = $sheet->getHighestColumn();

      $c = 0;
      for ($row = 2; $row <= $highestRow; $row++) {
        $filesop = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
        $booktype = $filesop[0][1];
        $bcat = $filesop[0][2];
        if ($bcat = 'English') {
          $bcat = 1;
        }
        $accsnno = $filesop[0][3];
        $isbnno = $filesop[0][4];
        $languge = $filesop[0][5];
        $bookname = $filesop[0][6];
        $subtitle = $filesop[0][7];
        $auther = $filesop[0][8];
        $publisher = $filesop[0][9];
        $publishyear = $filesop[0][10];
        $edition = $filesop[0][11];
        $vol = $filesop[0][12];
        $copy = $filesop[0][13];
        $bookcost = $filesop[0][14];
        $remarks = $filesop[0][15];
        $cupboard = $filesop[0][16];
        if ($cupboard = 'Right Side') {
          $cupboard = 1;
        }
        $cupboardshelf_id = $filesop[0][17];

        if ($cupboardshelf_id = 'Shelf_2') {
          $cupboardshelf_id = 1;
        }
        $bilno = $filesop[0][18];
        $bildate =  date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($filesop[0][19]));
        $vendor = $filesop[0][20];
        $addeddate = date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($filesop[0][21]));
        //$bookcategrie=$this->Book->find('all')->Where(['id' => $bcat])->first();
        // pr($bookcategrie); die;

        // $library_update= "UPDATE `library_books` SET `book_type`='$booktype',`book_category_id`='$bcat',`accsnno`='$accsnno',`lang`='$languge',`name`='$bookname',`sub_title`='$subtitle',`author`='$auther',`publisher`='$publisher',`pbyr`='$publishyear',`edition`='$edition',`vol`='$vol',`copy`='$copy',`book_cost`='$bookcost',`remarks`='$remarks',`cup_board_id`='$cupboard',`cup_board_shelf_id`='$cupboardshelf_id',`bilno`='$bilno',`bildt`='$bildate',`vndr`='$vendor',
        // `created`='$addeddate'"



        $conn = ConnectionManager::get('default');
        $db = $this->request->session()->read('Auth.User.db');
        //pr($db); die;
        $librarydata = "INSERT INTO $db.library_books (`book_type`,`book_category_id`,`accsnno`,`ISBN_NO`,`lang`,`name`,`sub_title`,`author`,`publisher`,`pbyr`,`edition`,`vol`,`copy`,`book_cost`,`remarks`,`cup_board_id`,`cup_board_shelf_id`,`bilno`,`bildt`,`vndr`,`created`) VALUES ('$booktype','$bcat','$accsnno','$isbnno','$languge','$bookname','$subtitle','$auther',
        '$publisher','$publishyear','$edition','$vol','$copy','$bookcost','$remarks','$cupboard','$cupboardshelf_id','$bilno','$bildate','$vendor','$addeddate')";
        //  pr($librarydata); die;
        $conn->execute($librarydata);
      }
    }
  }
  
  public function exportstudents()
  {

    $this->viewBuilder()->layout('admin');
    $session = $this->request->session();
    $conn = ConnectionManager::get('default');
    $personal = $session->read('personal');
    $s_data = $session->read('alldata');

    $datefrom = $session->read('datefrom');
    $dateto = $session->read('dateto');
    $category = $session->read('category');
    $is_special = $session->read('is_special');

    $detail = "SELECT " . `echo $personal` . ", s.middlename,s.lname FROM `students` s, classes c ,sections sec  WHERE s.class_id=c.id AND s.section_id=sec.id";
    $cond = ' ';

    $acedmicyear = $session->read('acedmicyear');
    $admissionyear = $session->read('admissionyear');

    if (!empty($acedmicyear)) {

      $cond .= " AND s.acedmicyear ='" . $acedmicyear . "'";
    }

    if (!empty($category)) {

      $cond .= " AND s.category ='" . $category . "'";
    }

    if (!empty($is_special)) {

      $cond .= " AND s.is_special ='" . $is_special . "'";
    }
    if (!empty($admissionyear)) {

      $cond .= " AND s.admissionyear ='" . $admissionyear . "'";
    }

    if (!empty($datefrom) && $datefrom != '1970-01-01') {

      $cond .= " AND DATE(s.created) >='" . $datefrom . "'";
    }

    if (!empty($dateto) && $dateto != '1970-01-01') {

      $cond .= " AND DATE(s.created) <='" . $dateto . "'";
    }

    $class_id = $session->read('class_id');
    $section_id = $session->read('section_id');
    $h_id = $session->read('h_id');
    $discountcategory = $session->read('discountcategory');

    if (!empty($discountcategory)) {

      foreach ($discountcategory as $sggs => $srts) {
        $condssj[] = "'" . $srts . "'";
      }
      $stucskh = implode(',', $condssj);
      $cond .= " AND s.discountcategory IN(" . $stucskh . ")";
    }

    if (!empty($h_id)) {

      foreach ($h_id as $ggs => $rts) {
        $condss[] = "'" . $rts . "'";
      }
      $stucs = implode(',', $condss);
      $cond .= " AND s.h_id IN(" . $stucs . ")";
    }

    if (!empty($class_id)) {

      foreach ($class_id as $gg => $rt) {
        $conds[] = "'" . $rt . "'";
      }
      $stuc = implode(',', $conds);
      $cond .= " AND s.class_id IN(" . $stuc . ")";
    }
    if (!empty($section_id)) {

      foreach ($section_id as $gg => $rts) {
        $condss[] = "'" . $rts . "'";
      }
      $stusc = implode(',', $condss);
      $cond .= " AND s.section_id IN(" . $stusc . ")";
    }
    $name = $session->read('name');
    if (!empty($name)) {

      $cond .= " AND  (s.fname  LIKE  '" . trim($name) . "%' OR s.lname  LIKE  '" . trim($name) . "%' OR s.username  LIKE '" . trim($name) . "%' OR s.mobile  LIKE '" . trim($name) . "' OR s.sms_mobile  LIKE '" . trim($name) . "' OR s.f_phone  LIKE '" . trim($name) . "' OR s.m_phone  LIKE '" . trim($name) . "')";
    }

    $ids = $session->read('ids');
    if (!empty($ids)) {

      $cond .= " AND s.enroll ='" . $ids . "' ";
    }
    $cond .= " AND s.status ='Y'";

    $rolepresent = $this->request->session()->read('Auth.User.role_id');

    if ($rolepresent == '5') {

      $cond .= " AND s.board_id IN ('1')";
    } elseif ($rolepresent == '8') {

      $cond .= " AND s.board_id IN ('2','3')";
    }

    $detail = $detail . $cond;
    $SQL = $detail . " ORDER BY c.sort ASC, sec.title ASC, s.fname ASC ,s.middlename ASC ,s.lname";
    $resul = $conn->execute($SQL)->fetchAll('assoc');

    $this->set('resul', $resul);
  }

  public function exportemployee()
  {


    $this->loadModel('Employeesalary');
    $this->loadModel('Employees');
    $employee = $this->Employees->find('all')->where(['Employees.status' => 'Y'])->order(['Employees.id' => 'ASC'])->toarray();
    $this->set('employee', $employee);
  }


  public function exportlibrarydata()
  {
    $this->autoRender = false;
    $this->loadModel('PeriodicalMaster');
    $this->loadModel('PeriodicalMasterDetails');
    $this->loadModel('Periodicity');
    $this->loadModel('Language');
    $this->loadModel('Book');
    $this->viewBuilder()->layout('admin');
    $connssss = ConnectionManager::get('default');

    $resultsucessssss = $connssss->execute("SELECT *
FROM `library_periodical_details`
WHERE subs_end_date IN(
  SELECT MAX(subs_end_date)
  FROM `library_periodical_details`
  GROUP BY `periodic_id`


) AND id IN(
  SELECT MAX(id)
  FROM `library_periodical_details`
  GROUP BY `periodic_id`


) ");

    $ghj = $resultsucessssss->fetchAll('assoc');

    ini_set('max_execution_time', 1600);
    $headerRow = array("SNo", "Periodical Name", "Periodicity", "Language", "Subscription Start", "Subscription End", "Price", "Author", "Volume");
    $output = implode("\t", $headerRow) . "\n";
    $counter = '1';
    foreach ($ghj as $service) {
      //pr($service); die;
      $perdet = $this->PeriodicalMaster->find()->where(['PeriodicalMaster.id' => $service['periodic_id']])->first();
      $result = array();
      $result[] = $counter;
      $result[] = $perdet['name'];
      $prty = $this->Periodicity->find()->select(['name'])->where(['Periodicity.id' => $perdet['periodicity']])->first();
      $result[] = $prty['name'];

      $lasd = $this->Language->find()->select(['language'])->where(['Language.id' => $perdet['lang']])->first();
      $result[] = $lasd['language'];
      $result[] = date('d-m-Y', strtotime($service['subs_start_date']));
      $result[] = date('d-m-Y', strtotime($service['subs_end_date']));
      $result[] = $service['per_volume_cost'];
      $result[] = $perdet['author'];
      $pcount = $this->Book->find('all')->where(['Book.periodic_category_id' => $service['periodic_id']])->count();
      $result[] = $pcount;

      $counter++;

      $output .= implode("\t", $result) . "\n";
    }

    $filename = "Periodical-list.xls";
    header('Content-type: application/ms-excel');
    header('Content-Disposition: attachment; filename=' . $filename);
    echo $output;
    die;
  }
}
