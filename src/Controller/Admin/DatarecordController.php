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

  public function connection($dbs)
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


  public function index()
  {
    $this->viewBuilder()->layout('admin');
    $this->loadModel('Students');
    $this->loadModel('Employees');
    // $dbname = $this->request->session()->read('Auth.User.id'); 
    //pr( $dbname ); die;
  }
  public function studentcheck()
  {
    //   $this->autoRender = false;

    //   $this->loadModel('Students');
    //   $this->loadModel('Users');
    //   $student = $this->Students->find('all')->where(['status'=>'Y','acedmicyear'=>'2022-23'])->toarray();
    //   $connss = ConnectionManager::get('default');
    //   foreach($student as $val){ 
    //     $user_exists = $this->Users->find('all')->where(['student_id' =>$val['id']])->first();
    //     $student_id = $val['id'];
    //     $user_id = $user_exists['id'];
    //     $username = $val['fname'];
    //     $cid = '2';
    //     $acedmicyear = $val['acedmicyear'];
    //     $email = "C".$val['enroll'];
    //     $tech_id = '';
    //     $password = '$2y$10$.vwir1Fyl5EkpHbNfEYFl.vU7raO0gFMuM.QnwVqpLM77Mjlot1Zm';
    //     $cpassword = '12345';
    //     $created = date('Y-m-d H:i:s', strtotime($val['created']));
    //     $modified = date('Y-m-d H:i:s');
    //     $role_id = '2';
    //     $dbname = $this->request->session()->read('Auth.User.db'); 
    //     $board = $val['board_id'];
    //     $mobile = $val['mobile'];
    //     // if($user_id){


    //     // //   $student_scchol_erp_data =  "UPDATE `school_erp`.`users` SET `user_name`='$username', `c_id`='$cid',`academic_year`='$acedmicyear',`email`='$email',`tech_id`='$tech_id',`password`='$password',`confirm_pass`='$cpassword',`created`='$created',`modified`='$modified',`role_id`='$role_id',`db`='$dbname',`board`='$board',`mobile`='$mobile',`student_id`='$student_id' WHERE mobile ='" . $mobile . "' and db ='" .      $dbname . "'";
    //     // //   echo  $student_scchol_erp_data; die; 
    //     // //    $exicute=$conn->execute($student_scchol_erp_data);

    //     // }else{
    //       $employee_data = "INSERT INTO `school_erp`.`users` (`user_name`,`c_id`,`academic_year`, `email`,`tech_id`, `password`, `confirm_pass`, `created`, `modified`, `role_id`, `db`,`board`,`mobile`,`student_id`) VALUES('$username','$cid','$acedmicyear','$email','$tech_id', '$password','$cpassword','$created','$modified', $role_id,'$dbname','$board','$mobile','$student_id')";
    //      // echo $employee_data; die;
    //       $exicute = $connss->execute($employee_data);

    //     // }


    //     $connssddd = ConnectionManager::get('default');

    //     $NTSQL = "SELECT * FROM `school_erp`.`users` order by id desc";
    //     $user_data = $connssddd->execute($NTSQL)->fetchAll('assoc');
    //     $user_new_id = $user_data[0]['id'];
    //   //  echo $user_new_id['id']; die;
    //     $connffsss = ConnectionManager::get('default');
    //     $student_user_data =  "UPDATE `$dbname`.`users` SET `id`='$user_new_id ' WHERE student_id =".$student_id;
    //     //echo  $student_scchol_erp_data; die; 
    //     $exicute=$connffsss->execute($student_user_data);


    //  }
  }

  public function checkdropoutstudent()
  {

    $this->viewBuilder()->layout('admin');
    $this->loadModel('Students');

    if ($this->request->is('post') || $this->request->is('put')) {
      //pr($_FILES); die;
      $inputfilename = $_FILES['file']['tmp_name'];
      try {
        $objPHPExcel = \PHPExcel_IOFactory::load($inputfilename);
      } catch (Exception $e) {
        die('Error loading file "' . pathinfo($inputfilename, PATHINFO_BASENAME) . '": ' . $e->getMessage());
      }

      $sheet = $objPHPExcel->getSheet(0);
      $highestRow = $sheet->getHighestDataRow();

      $highestColumn = $sheet->getHighestColumn();
      $c = 0;
      $student = $this->Students->find('all')->toarray();
      foreach ($student as $value) {
        $st_enroll[]  = $value['enroll'];
      }
      pr($st_enroll);
      die;
      for ($row = 2; $row <= $highestRow; $row++) {

        $filesop = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
        // pr($filesop);
        $s_no = $filesop[0][0];
        $enroll = $filesop[0][9];

        if (in_array($enroll, $st_enroll)) {
        } else {
          $droup_out_student[]  = 'fdsf';
        }
        // $student = $this->Students->find('all')->where(['enroll' => $enroll])->first();
        // if($student){
        //   $student_already[] = $student['enroll'];
        // }
        // else{
        //   $student_not[] = $enroll;
        // }

      }

      //pr($student_already);

      pr($droup_out_student);
      die;
    }
  }

  public function stockregister()
  {
    $this->viewBuilder()->layout('admin');

    $dbname = $this->request->session()->read('Auth.User.db');
    $branch = explode("_", $dbname);
    if ($dbname != $branch[0]) {

      $this->connection(trim($branch[0]));
    }



    $this->loadModel('Additem');
    $this->loadModel('Taxmaster');
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
      // die;
      for ($row = 2; $row <= $highestRow; $row++) {

        $filesop = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);


        $item_name = $filesop[0][0];
        $opening_stock = $filesop[0][1];
        $issue_stock = $filesop[0][2];
        $sold_stock = $filesop[0][3];
        $available_stock = $filesop[0][4];

        $item_data = $this->Additem->find('all')->where(['Additem.item_name LIKE' => '%' . trim($item_name) . '%'])->first();

        $item_id = $item_data['id'];
        $rate = $item_data['sale_price'];
        $cost_price = $opening_stock * $rate;

        $tax_id = $item_data['tax'];
        $tax_data = $this->Taxmaster->find('all')->where(['Taxmaster.id' => $tax_id])->order(['Taxmaster.id' => 'Asc'])->first();
        //pr($tax_data); die;
        $tax = $cost_price * $tax_data['tax'] / 100;
        $amount = $cost_price + $tax;
        $conn = ConnectionManager::get('default');
        $db = $this->request->session()->read('Auth.User.db');

        //if($item_data){



        // $created = date('Y-m-d H:i:s', \PHPExcel_Shared_Date::ExcelToPHP());

        //   $db = $this->request->session()->read('Auth.User.db');
        //   $stock_register_update =  "UPDATE $db.`st_stock_register` SET `po_id`='1001',`purchaseorder_id`='1',`indent_id`='1001',`item_id`='$item_id',`issue_date`='$created',`delivery_date`='$created',`quantity`='$opening_stock',`rate`='$rate',`cost_price`='$cost_price',`tax_id`='$tax_id',`tax`='$tax',`amount`='$amount',`store_id`='0',`store_type`='0',`store_quantity`='0',`student_id`='0',`is_revised`='0'  WHERE item_id =".$item_id;

        // pr($stock_register_update); die;
        //   $exicute=$conn->execute($stock_register_update);

        // }else{

        $created = date('Y-m-d H:i:s', \PHPExcel_Shared_Date::ExcelToPHP());
        $connss = ConnectionManager::get('default');
        $db = $this->request->session()->read('Auth.User.db');
        $employee_stock  = "INSERT INTO `$db`.`st_stock_register`(`po_id`, `purchaseorder_id`, `indent_id`, `item_id`,`issue_date`, `delivery_date`, `quantity`, `rate`, `cost_price`,  `tax_id`, `tax`, `amount`,`store_id`,`store_type`,`store_quantity`,`student_id`,`is_revised`) VALUES ('1001','1','1001','$item_id','$created','$created','$opening_stock','$rate','$cost_price','$tax_id','$tax','$amount','0','0','0','0','0')";
        //pr($employee_stock); die;
        $exicute = $connss->execute($employee_stock);
        //}

      }
    }
  }

  public function importemployee()
  {
    $this->viewBuilder()->layout('admin');
    $this->loadModel('Employees');
    if ($this->request->is('post') || $this->request->is('put')) {

      // pr($this->request->data);exit;

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

        $employee_name = $filesop[0][1];
        $husbandname = $filesop[0][2];
        $dob =  date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($filesop[0][3]));
        if ($filesop[0][4]) {
          $department =  $filesop[0][4];
        } else {
          $department = 1;
        }
        if ($filesop[0][5]) {
          $designation = $filesop[0][5];
          // pr($designation);exit;
        } else {
          // echo "else"; die;
          $designation = 1;
        }

        $contactno = $filesop[0][6];
        $emp_status = $filesop[0][7];
        $dojoing =  date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($filesop[0][8]));
        $email = $filesop[0][9];
        $experience = $filesop[0][10];
        $martial_status = $filesop[0][11];
        $fixed_salary = $filesop[0][12];
        $basic_salary = $filesop[0][13];
        $gradepay = $filesop[0][14];
        $da_amount = $filesop[0][15];
        $hra = $filesop[0][16];
        $cca = $filesop[0][17];
        $allowance = $filesop[0][18];
        $lta = $filesop[0][19];
        $bnonus = $filesop[0][20];
        $total = $filesop[0][21];
        $pf_deduction = $filesop[0][22];
        $esi_deduction = $filesop[0][23];
        $netpay = $filesop[0][24];
        $paymentmode = $filesop[0][25];
        $bank_name = $filesop[0][26];
        $bankmp_ifsc = $filesop[0][27];
        $bank_acc = $filesop[0][28];
        $uan_no = $filesop[0][29];
        $pf_no = $filesop[0][30];
        $esi_no = $filesop[0][31];
        $tds_amt = $filesop[0][32];

        // ---  \\
        $passing_year = $filesop[0][33];
        $university_name = $filesop[0][34];
        $aadhar_number = $filesop[0][35];
        $description = $filesop[0][36];
        $registration = $filesop[0][37];

        // pr( $filesop);exit;


        $conn = ConnectionManager::get('default');
        $db = $this->request->session()->read('Auth.User.db');


        $employee   = "INSERT INTO `$db`.`employees`(`fname`,`username`,`email`,`mobile`,`f_h_name`,`dob`,`joiningdate`,`p_department`,`p_designation`, `department_id`, `designation_id`) VALUES ('$employee_name','$email','$email','$contactno','$husbandname','$dob','$dojoing','$department','$designation' ,'$department', '$designation')";

        $exicute = $conn->execute($employee);

        $last_insert_id = $this->Employees->find()->select(['id'])->last();
        $last_insert_id = $last_insert_id['id'];
        $current_date = date('Y-m-d H:i:s');

        $employee_data = "INSERT INTO `school_erp`.`users` (`user_name`,`c_id`,`academic_year`, `email`,`tech_id`, `password`, `confirm_pass`, `created`, `modified`, `role_id`, `db`,`board`,`mobile`) VALUES('$employee_name','0','2021-22','$email', '$last_insert_id','$2y$10$.vwir1Fyl5EkpHbNfEYFl.vU7raO0gFMuM.QnwVqpLM77Mjlot1Zm','12345', '$current_date', '$current_date', 3,'$db','1','$contactno')";
        $conn->execute($employee_data);

        $NTSQL = "SELECT * FROM `school_erp`.`users` WHERE `tech_id`= '$last_insert_id'";
        $user_data = $conn->execute($NTSQL)->fetchAll('assoc');
        $rec_data = $user_data[0]['id'];

        $employee_data_user = "INSERT INTO `$db`.`users` (`id`,`user_name`,`c_id`,`academic_year`, `email`,`tech_id`, `password`, `confirm_pass`, `created`, `modified`, `role_id`, `db`,`board`,`mobile`) VALUES
          ('$rec_data','$employee_name','0','2021-22','$email', '$last_insert_id','$2y$10$.vwir1Fyl5EkpHbNfEYFl.vU7raO0gFMuM.QnwVqpLM77Mjlot1Zm','12345', '$current_date', '$current_date', 3,'$db','1','$contactno')";
        $conn->execute($employee_data_user);
      }


      $this->Flash->success(__('Employee Uploaded successfully'));
      return $this->redirect(['controller' => 'employees', 'action' => 'index']);
    }
  }


  // public function importemployee()
  // {
  //   $this->viewBuilder()->layout('admin');
  //   $this->loadModel('Students');
  //   $this->loadModel('Employees');
  //   $this->loadModel('Classes');
  //   $this->loadModel('Sections');
  //   $this->loadModel('Users');
  //   $adminData = $this->Users->find('all')->where(['Users.role_id' => 1])->first();

  //   if ($this->request->is('post') || $this->request->is('put')) {

  //     if (!empty($_FILES['file']['tmp_name'])) {
  //       $inputFileName = $_FILES['file']['tmp_name'];
  //       try {

  //         $objPHPExcel = \PHPExcel_IOFactory::load($inputFileName);
  //         $worksheet = $objPHPExcel->getActiveSheet();
  //         $data = [];
  //         foreach ($worksheet->getRowIterator() as $row) {
  //           $rowData = [];
  //           foreach ($row->getCellIterator() as $cell) {
  //             $rowData[] = $cell->getValue();
  //           }
  //           $data[] = $rowData;
  //         }
  //         // $headers = array_shift($data);
  //         // pr($data);exit;

  //         $formattedData = [];
  //         $error = [];
  //         foreach ($data as $key => $row) {
  //           if ($key == 0) {
  //             continue;
  //           }
  //           // $exist =  $this->Students->find('all')->where(['formno' => $row[15]])->select(['id','fname'])->first();
  //           // pr($exist);exit;
  //           // if (!empty($exist)) {
  //           //   continue;
  //           // }

  //           // $formattedRow = [];
  //           // $formattedRow['fname'] = trim($row[1]); // First Name
  //           // $formattedRow['ruhs_id'] = trim($row[2]); // RUHS Id
  //           // $formattedRow['f_h_name'] =  $row[3]; 
  //           // $formattedRow['emp_designation'] = trim($row[4]); 
  //           // $formattedRow['address'] =  trim($row[5]); 
  //           // $formattedRow['gender'] = trim($row[6]); 
  //           // $formattedRow['dob'] = date('Y-m-d', strtotime($row[7])); // DOB
  //           // $formattedRow['social_category'] = $row[8];  
  //           // $formattedRow['religious_community'] = trim($row[9]); 
  //           // $formattedRow['doj_institution'] = date('Y-m-d', strtotime($row[10])); 
  //           // $formattedRow['doj_teaching_profession'] = date('Y-m-d', strtotime($row[11])); 
  //           // $formattedRow['course_name'] = trim($row[12]); 
  //           // $formattedRow['teaching_exp_years'] = trim($row[13]); 
  //           // $formattedRow['aadhar_number'] = trim($row[14]); 
  //           // $formattedRow['mobile'] = trim($row[15]); 
  //           // $formattedRow['alternate_mobile'] = $row[16]; 
  //           // $formattedRow['email'] = $row[17]; 
  //           // $formattedRow['martial_status'] = $row[18]; 
  //           // $formattedRow['bsc_nursing_institution_year'] = $row[19]; 
  //           // $formattedRow['pbbsc_nursing_institution_year'] = trim($row[20]);
  //           // $formattedRow['phd_nursing_institution_year'] = trim($row[21]); 
  //           // $formattedRow['qualification'] = trim($row[22]);
  //           // $formattedRow['nuid_no'] = trim($row[23]); 
  //           // $formattedRow['reg_RN'] = $row[24]; 
  //           // $formattedRow['reg_RM'] = $row[25];
  //           // $formattedRow['exp_after_msc_nursing'] = $row[26]; 
  //           // $formattedRow['exp_after_bsc_pbbsc_nursing'] = $row[27]; 
  //           // $formattedRow['clinical_exp'] = $row[28]; 
  //           // $formattedRow['total_experience'] = $row[29]; 
  //           // $formattedRow['inspectors_remarks'] = $row[30]; 
  //           // $formattedRow['serutiny_committee_remarks'] = $row[31];
  //           // $formattedRow['pan_number'] = $row[32]; 
  //           // $formattedRow['account_holder_name'] = $row[33]; 
  //           // $formattedRow['branch_name'] = $row[34]; 
  //           // $formattedRow['account_number'] = $row[35];
  //           // $formattedRow['ifsc_code'] = $row[36];






  //           $formattedRow = [];
  //           $formattedRow['fname'] = trim($row[1]); // First Name
  //           $formattedRow['f_h_name'] =  $row[2]; 
  //           $formattedRow['dob'] = date('Y-m-d', strtotime($row[3])); // DOB
  //           $formattedRow['emp_department'] = trim($row[4]); 
  //           $formattedRow['emp_designation'] = trim($row[5]); 
  //           $formattedRow['mobile'] = trim($row[6]); 
  //           $formattedRow['emp_status'] = trim($row[7]); 
  //           $formattedRow['gender'] = trim($row[8]); 
  //           $formattedRow['joiningdate'] = trim($row[9]); 
  //           $formattedRow['email'] = trim($row[10]); 
  //           $formattedRow['total_experience'] = trim($row[11]); 
  //           $formattedRow['qualification'] = trim($row[12]); 
  //           $formattedRow['aadhar_number'] = trim($row[13]); 
  //           $formattedRow['alternate_mobile'] = trim($row[14]); 
  //           $formattedRow['registration'] = trim($row[15]); 
  //           $formattedRow['address'] = trim($row[16]); 
  //           $formattedRow['remarks'] = trim($row[17]); 
  //           $formattedRow['martial_status'] = trim($row[18]); 
  //           $formattedRow['pan_number'] = trim($row[19]); 


  //           if ($this->validateRequiredFieldsemployee($formattedRow)) {
  //             $formattedData[] = $formattedRow;
  //           } else {
  //             // $error[] = $formattedRow['fname'] . ' ' . $formattedRow['lname'];
  //             $error[] = $formattedRow['fname'];
  //           }
  //         }

  //         // Start the transaction.
  //         $connection = ConnectionManager::get('default');
  //         $connection->begin();

  //         try {
  //           foreach ($formattedData as $studentDetails) {
  //             $newApplicant = $this->Employees->newEntity();
  //             $setData = $this->Employees->patchEntity($newApplicant, $studentDetails);
  //             $this->Employees->save($setData);
  //           }

  //           // Commit the transaction if everything is successful.
  //           $connection->commit();

  //           if (!empty($error[0])) {
  //             $errorMessage = 'Please fill required fields for the following employees: ' . implode(', ', $error);
  //             $this->Flash->error($errorMessage);
  //           }

  //           $this->Flash->success(__('Employee Uploaded successfully'));
  //           return $this->redirect(['controller'=>'Employees','action' => 'index']);
  //           return $this->redirect($this->referer());


  //           // return $formattedData;
  //         } catch (\Exception $e) {
  //           // Rollback the transaction on any exception.
  //           $connection->rollback();
  //           throw $e;
  //         }
  //       } catch (PHPExcel_Exception $e) {
  //         die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
  //       }
  //     }
  //   }
  // }



  // 
  // public function importstudents()
  // {
  //   $this->viewBuilder()->layout('admin');
  //   $this->loadModel('Students');
  //   $this->loadModel('Houses');
  //   $this->loadModel('Classes');
  //   $this->loadModel('Sections');
  //   if ($this->request->is('post') || $this->request->is('put')) {
  //     //pr($_FILES); die;
  //     $inputfilename = $_FILES['file']['tmp_name'];
  //     try {
  //       $objPHPExcel = \PHPExcel_IOFactory::load($inputfilename);
  //     } catch (Exception $e) {
  //       die('Error loading file "' . pathinfo($inputfilename, PATHINFO_BASENAME) . '": ' . $e->getMessage());
  //     }

  //     $sheet = $objPHPExcel->getSheet(0);
  //     $highestRow = $sheet->getHighestRow();
  //     $highestColumn = $sheet->getHighestColumn();

  //     $c = 0;
  //     for ($row = 2; $row <= $highestRow; $row++) {
  //       //  Read a row of data into an array
  //       $filesop = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
  //      // pr($filesop); //die;
  //       $fname = $filesop[0][1];
  //       $mname = $filesop[0][2];
  //       $lname = $filesop[0][3];
  //       if($fname){


  //       $fee_submittedby = $filesop[0][4];
  //       $fathername = $filesop[0][5];
  //       $mothername = $filesop[0][6];
  //       $username = $filesop[0][7];
  //       $dob =  date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($filesop[0][8]));
  //       // if($enroll == 0){
  //       //   $enroll = rand(1111, 9999);
  //       // }else{

  //       // }
  //       $enroll = $filesop[0][9];
  //       $mobile = $filesop[0][10];
  //       $sms_mobile = $filesop[0][11];
  //       $adaharnumber = $filesop[0][13];
  //       $cast = $filesop[0][14];
  //       $house = $filesop[0][15];

  //       $class = $filesop[0][16];
  //       $category = $filesop[0][17];
  //       $section = $filesop[0][18];
  //       $gender = $filesop[0][19];
  //       $stu_img = $enroll . ".JPG";
  //       $religion = $filesop[0][22];
  //       $address = $filesop[0][23];

  //        //$test = explode('.',$filesop[0][26]);
  //       //$date_format = $test[2]."-".$test[1]."-".$test[0];
  //      //$admission_date = $date_format;

  //     $admission_date = date('Y-m-d H:i:s', \PHPExcel_Shared_Date::ExcelToPHP($filesop[0][26]));
  //      //pr($admission_date); die;
  //      $father_ocu = $filesop[0][42];
  //      $mother_ocu = $filesop[0][44];
  //       $father_no = $filesop[0][45];
  //       $mother_no = $filesop[0][46];

  //       if($father_no){
  //       // $mobile = $father_no;
  //       // $sms_mobile = $father_no;
  //       }else {
  //       // $mobile = $mother_no;
  //       // $sms_mobile = $mother_no;
  //       }

  //      // $created = date('Y-m-d H:i:s', \PHPExcel_Shared_Date::ExcelToPHP($lang22));

  //       $address = $filesop[0][23];
  //       $academic_year = "2022-23";
  //       $comp_sid = '';

  //       $opt_sid = '';
  //       $rfidd = '0';
  //       $student = $this->Students->find('all')->where(['enroll' => $enroll])->first();



  //       $classes = $this->Classes->find('all')->where(['title' => $class])->first();
  //       //pr($classes); die;
  //       $house = $this->Houses->find('all')->where(['name' => $house])->first();
  //       $section = $this->Sections->find('all')->where(['title' => $section])->first();
  //       $classid = $classes['id'];
  //       if ($classid) {
  //         $classid = $classid;
  //       } else {
  //         $classid = 0;
  //       }
  //       $house_id = $house['id'];
  //       if ($house_id) {       $conn = ConnectionManager::get('default');
  //         $db = $this->request->session()->read('Auth.User.db');
  //         $house_id = $house_id;
  //       } else {
  //         $house_id = 0;
  //       }
  //       $section_id =  $section['id'];
  //       if ($section_id) {
  //         $section_id = $section_id;
  //       } else {
  //         $section_id = 0;
  //       }
  //       $ad_date = $filesop[0][27];

  //       $ad_dateext = date('Y', strtotime($ad_date));

  //       $newEndingDate = date("y", strtotime(date("Y-m-d", strtotime($ad_date)) . " + 1 year"));

  //       $admissionyear = $ad_dateext . "-" . $newEndingDate;

  //       $conn = ConnectionManager::get('default');
  //       $db = $this->request->session()->read('Auth.User.db');
  //        if ($student) {

  //          $student_data =  "UPDATE `students` SET `fname`='$fname',`middlename`='$mname',`lname`='$lname',`fee_submittedby`='$fathername',`fathername`='$fathername',`mothername`='$mothername',`username`='$username',`dob`='$dob',`mobile`='$mobile',`sms_mobile`='$sms_mobile',`adaharnumber`='$adaharnumber',`cast`='$cast',`house_id`='$house_id',`class_id`='$classid',`category`='$category',`section_id`='$section_id',`gender`='$gender',`photo`='$stu_img',`religion`='$religion',`address`='$address',`admissionyear`='$admissionyear',`acedmicyear`='$academic_year',`h_id`='$house_id',`f_phone`='$father_no',`created`='$admission_date',`m_phone`='$mother_no',`m_occupation`='$mother_ocu',`f_occupation`='$father_ocu' WHERE enroll =".$enroll;
  //          //pr($student_data); die;
  //          $exicute=$conn->execute($student_data);

  //         $student_scchol_erp_data =  "UPDATE `school_erp`.`users` SET `user_name`='$fname',`email`='$enroll',`mobile`='$mobile',`academic_year`='2022-23',`c_id`='2',`modified`='0000-00-00 00:00:00',`role_id`='2',`board`='1',`mobile`='$mobile' WHERE email ='" . $enroll . "' and db ='" . $db . "'";
  //         //echo  $student_scchol_erp_data; die; 
  //         $exicute=$conn->execute($student_scchol_erp_data);
  //         $current_date = date('Y-m-d H:i:s');

  //         $student_user_data =  "UPDATE `$db`.`users` SET `user_name`='$fname',`email`='$enroll',`mobile`='$mobile',`academic_year`='2021-22',`c_id`='2',`modified`='$current_date',`role_id`='2',`board`='1',`mobile`='$mobile' WHERE email ='" . $enroll . "' and db ='" . $db . "'";
  //         //echo  $student_scchol_erp_data; die; 
  //         $exicute=$conn->execute($student_user_data);
  //        //echo "test"; die;
  //       } else {
  //        $board_id  = "1";
  //        $student_data = "INSERT INTO `$db`.`students`(`fname`, `middlename`, `lname`,`fee_submittedby`, `board_id`, `fathername`, `mothername`, `username`, `password`, `dob`, `enroll`, `mobile`,`sms_mobile`, `formno`, `adaharnumber`, `cast`, `parent_id`, `house_id`, `class_id`, `category`, `section_id`, `gender`, `photo`, `bloodgroup`, `religion`, `address`, `city`, `nationality`, `created`, `admissionyear`, `acedmicyear`, `status`, `file`, `comp_sid`, `opt_sid`, `h_id`, `room_no`, `is_transport`, `transportloc_id`, `v_num`, `dis_fees`,  `dis_transport`, `is_discount`, `due_fees`, `token`,`rf_id`,`f_phone`,`m_phone`,`m_occupation`,`f_occupation`) VALUES ('$fname','$mname','$lname','$fathername','$board_id','$fathername','$mothername','$username','12345','$dob','$enroll','$mobile','$sms_mobile','43534','$adaharnumber','$cast','0','$house_id','$classid','$category','$section_id','$gender','$stu_img','O','$religion','$address','Jaipur','INDIAN','$admission_date','$admissionyear','$academic_year','Y','','$comp_sid','$opt_sid','$house_id','','1','9','RJ-3456','0','0','0','0','d19zotIWXww:APA91bHsDcEda1obUeddDumwRF0BhrwbccFskQ','$rfidd','$father_no','$mother_no','$mother_ocu','$father_ocu')";



  //         $exicute = $conn->execute($student_data);
  //         $last_insert_id = $this->Students->find()->select(['id'])->last();
  //         $last_insert_id = $last_insert_id['id'];
  //         $current_date = date('Y-m-d H:i:s');


  //         $school_data = "INSERT INTO `school_erp`.`users` (`user_name`,`c_id`,`academic_year`, `email`,`student_id`, `password`, `confirm_pass`, `created`, `modified`, `role_id`, `db`,`board`,`mobile`) VALUES
  //           ('$fname','2','2022-23','$enroll', '$last_insert_id','$2y$10$.vwir1Fyl5EkpHbNfEYFl.vU7raO0gFMuM.QnwVqpLM77Mjlot1Zm','12345', '2022-04-30 10:35:39', '0000-00-00 00:00:00','2','$db','5','$mobile')";
  //         $conn->execute($school_data);


  //         $NTSQL = "SELECT * FROM `school_erp`.`users` WHERE `student_id`= '$last_insert_id'";
  //         $user_data = $conn->execute($NTSQL)->fetchAll('assoc');
  //         $rec_data = $user_data[0]['id'];

  //         $school_data_user = "INSERT INTO `$db`.`users` (`id`,`user_name`,`c_id`,`academic_year`, `email`,`student_id`, `password`, `confirm_pass`, `created`, `modified`, `role_id`, `db`,`board`,`mobile`) VALUES
  //           ('$rec_data','$fname','2','2022-23','$enroll', '$last_insert_id','$2y$10$.vwir1Fyl5EkpHbNfEYFl.vU7raO0gFMuM.QnwVqpLM77Mjlot1Zm','12345', '$current_date', '0000-00-00 00:00:00','2','$db','$board_id','$mobile')";
  //         $conn->execute($school_data_user);
  //         // echo "upload"; die;
  //       }

  //     }
  //     //die;
  //   }
  //   $this->Flash->success(__('Student Uploaded successfully'));
  //   return $this->redirect(['action' => 'index']);
  //   }

  // }

  // Import Student 
  public function importstudents()
  {
    $this->viewBuilder()->layout('admin');
    $this->loadModel('Students');
    $this->loadModel('Houses');
    $this->loadModel('Classes');
    $this->loadModel('Sections');
    $this->loadModel('Users');
    $adminData = $this->Users->find('all')->where(['Users.role_id' => 1])->first();

    if ($this->request->is('post') || $this->request->is('put')) {

      if (!empty($_FILES['file']['tmp_name'])) {
        $inputFileName = $_FILES['file']['tmp_name'];
        try {

          $objPHPExcel = \PHPExcel_IOFactory::load($inputFileName);
          $sheet = $objPHPExcel->getActiveSheet();
          $dataArr = array();
          $highestRow = $sheet->getHighestDataRow();
          $highestColumn = $sheet->getHighestDataColumn();
          $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);

          // Loop through rows and columns to extract data
          for ($row = 2; $row <= $highestRow; ++$row) {
            $rowData = array();
            for ($col = 0; $col < $highestColumnIndex; ++$col) {
              $val = $sheet->getCellByColumnAndRow($col, $row)->getValue();
              $rowData[] = $val;
            }
            // Check if the row data contains only empty values (empty strings)
            // Remove blank arrays from $dataArr
            if (!empty(array_filter($rowData))) {
              $dataArr[] = $rowData;
            }
          }
          pr($dataArr);
          exit;

          $formattedData = [];
          $error = [];
          $lastEnroll =  $this->Students->find('all')->select(['id', 'enroll'])->order(['enroll' => 'DESC'])->first();
          $enroll = $lastEnroll['enroll'] + 1;
          foreach ($dataArr as $key => $row) {
            // pr($row);exit;
            // if (!empty($row[15]) && $row[15] != '-') {
            //   $exist =  $this->Students->find('all')->where(['formno' => $row[15]])->select(['id', 'fname'])->first();
            //   if (!empty($exist)) {
            //     pr($row[15]);
            //     continue;
            //   }
            // }

            $formattedRow = [];
            $formattedRow['enroll'] = $enroll++; // Enroll
            $formattedRow['fname'] = trim($row[1]); // First Name
            $formattedRow['middlename'] = trim($row[2]); // Middle Name
            $formattedRow['lname'] = trim($row[3]); // Last Name
            $formattedRow['username'] = trim($row[4]); // Email
            $formattedRow['dob'] = date('Y-m-d', strtotime($row[5])); // DOB
            $formattedRow['gender'] = trim($row[6]); // Gender
            $formattedRow['cast'] = trim($row[7]); // Cart
            $formattedRow['category'] = trim($row[7]); // Cart
            $formattedRow['class_id'] = $row[8]; // Course
            $formattedRow['section_id'] = $row[9]; // Year / Semester
            $formattedRow['address'] = trim($row[10]); // Full Address
            $formattedRow['percentage_in_12th'] = $row[11]; // Percentage in 12th
            $formattedRow['board'] = $row[12]; // 12th Board 
            $formattedRow['original_document'] = trim($row[13]); // Original Document
            $formattedRow['required_document'] = trim($row[14]); // Require Document
            $formattedRow['formno'] = $row[15]; // Form Number
            $formattedRow['application_date'] = isset($row[16]) && date('Y-m-d', strtotime($row[16])) !== '1970-01-01' ? date('Y-m-d', strtotime($row[16])) : date('Y-m-d'); // Date of Application
            $formattedRow['admission_date'] = date('Y-m-d', strtotime($row[17])); // Admision Date
            $formattedRow['batch'] = trim($row[18]); // Batch
            $formattedRow['admissionyear'] = trim($row[18]); // Addmission Year*
            $formattedRow['acedmicyear'] = trim($adminData['academic_year']); // Addmission Year* 
            $formattedRow['session'] = trim($row[19]); // Session
            $formattedRow['mode'] = trim($row[20]); // Mode
            $formattedRow['board_id'] = $row[21]; // organisation
            $formattedRow['adaharnumber'] = $row[22]; // Aadhar Number
            $formattedRow['mobile'] = $row[23]; // Student Mobile
            $formattedRow['fathername'] = trim($row[24]); // Father Name
            $formattedRow['father_mobile'] = $row[25]; // Father Mobile
            $formattedRow['f_occupation'] = trim($row[26]); // Father Occupation
            $formattedRow['mother_mobile'] = $row[27]; // Mother Mobile
            $formattedRow['remarks'] = trim($row[28]); // Remarks
            $formattedRow['due_fees'] = $row[29]; // Total Due
            $formattedRow['status'] = $row[30]; // Status*

            if ($this->validateRequiredFields($formattedRow)) {
              $formattedData[] = $formattedRow;
            } else {
              $error[] = $formattedRow['fname'] . ' ' . $formattedRow['lname'];
            }
          }
          // pr($formattedData);
          // exit;

          // Start the transaction.
          $connection = ConnectionManager::get('default');
          $connection->begin();

          try {
            foreach ($formattedData as $studentDetails) {

              $newApplicant = $this->Students->newEntity();
              $setData = $this->Students->patchEntity($newApplicant, $studentDetails);
              $this->Students->save($setData);
            }

            // Commit the transaction if everything is successful.
            $connection->commit();

            if (!empty($error)) {
              $errorMessage = 'Please fill required fields for the following students: ' . implode(', ', $error);
              $this->Flash->error($errorMessage);
            }

            $this->Flash->success(__('Student Uploaded successfully'));
            // return $this->redirect(['action' => 'index']);
            return $this->redirect($this->referer());


            // return $formattedData;
          } catch (\Exception $e) {
            // Rollback the transaction on any exception.
            $connection->rollback();
            throw $e;
          }
        } catch (PHPExcel_Exception $e) {
          die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }
      }
    }
  }


  // function validateRequiredFieldsemployee(array $data): bool
  // {
  //   $requiredFields = ['fname','f_h_name','address','dob','emp_designation','gender','qualification','mobile','joiningdate'];

  //   // $requiredFields = ['fname','f_h_name', 'emp_designation','address','gender','dob','social_category','religious_community','teaching_exp_years','pan_number','account_holder_name','branch_name','account_number','ifsc_code','aadhar_number','email','mobile','doj_institution'];

  //   foreach ($requiredFields as $field) {
  //     if (empty(trim($data[$field]))) {
  //       return false;
  //     }
  //   }

  //   return true;
  // }




  function validateRequiredFields(array $data): bool
  {
    $requiredFields = ['fname', 'dob', 'class_id', 'section_id', 'address', 'formno', 'admission_date', 'batch', 'session'];

    foreach ($requiredFields as $field) {
      if (empty(trim($data[$field]))) {
        return false;
      }
    }

    return true;
  }


  public function  importlibrarydata()
  {

    $this->viewBuilder()->layout('admin');
    $this->loadModel('Students');
    $this->loadModel('Book');
    $this->loadModel('BookCategory');
    $this->loadModel('Language');

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

        $bookcategory = $this->BookCategory->find('all')->where(['name' => $bcat])->first();
        $language = $this->Language->find('all')->where(['language' => $languge])->first();

        $bookcategory_id =  $bookcategory['id'];
        if ($bookcategory_id) {
          $bcat = $bookcategory_id;
        } else {
          $bcat = 0;
        }
        $language_id =  $language['id'];
        if ($language_id) {
          $languge = $language_id;
        } else {
          $languge = 0;
        }


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

        $bookcategrie = $this->BookCategory->find('all')->Where(['name' => $bcat])->first();
        $conn = ConnectionManager::get('default');

        $db = $this->request->session()->read('Auth.User.db');
        // if($bookcategrie){

        //   $library_update= "UPDATE `library_books` SET `book_type`='$booktype',`accsnno`='$accsnno',`lang`='$languge',`name`='$bookname',`sub_title`='$subtitle',`author`='$auther',`publisher`='$publisher',`pbyr`='$publishyear',`edition`='$edition',`vol`='$vol',`copy`='$copy',`book_cost`='$bookcost',`remarks`='$remarks',`cup_board_id`='$cupboard',`cup_board_shelf_id`='$cupboardshelf_id',`bilno`='$bilno',`bildt`='$bildate',`vndr`='$vendor',
        //    `created`='$addeddate' WHERE `book_category_id`='$bookcategrie[id]'";
        //   // pr($library_update); die;

        // }else{

        $librarydata = "INSERT INTO $db.library_books (`book_type`,`book_category_id`,`accsnno`,`ISBN_NO`,`lang`,`name`,`sub_title`,`author`,`publisher`,`pbyr`,`edition`,`vol`,`copy`,`book_cost`,`remarks`,`cup_board_id`,`cup_board_shelf_id`,`bilno`,`bildt`,`vndr`,`created`) VALUES ('$booktype','$bcat','$accsnno','$isbnno','$languge','$bookname','$subtitle','$auther',
        '$publisher','$publishyear','$edition','$vol','$copy','$bookcost','$remarks','$cupboard','$cupboardshelf_id','$bilno','$bildate','$vendor','$addeddate')";
        $conn->execute($librarydata);
        // }

      }
      $this->Flash->success(__('Library- Uploaded successfully'));
      return $this->redirect(['action' => 'index']);
    }
  }

  public function exportstudents()
  {

    $this->viewBuilder()->layout('admin');
    $this->loadmodel('Students');
    $resul = $this->Students->find('all')->order(['Students.id' => 'ASC'])->toarray();
    $this->set('resul', $resul);
  }

  public function exportemployee()
  {
    $this->loadModel('Employeesalary');
    $this->loadModel('Employees');
    $employee = $this->Employees->find('all')->contain(['Employeesalary'])->toarray();
    $this->set('employee', $employee);
    // pr($employee); die;

  }
  public function exportlibrarydata()
  {
    $this->loadModel('Book');
    $employee = $this->Book->find('all')->order(['id' => 'ASC'])->toarray();
    $this->set('employee', $employee);
    //pr($employee); die;

  }
  public function exportclass_coclass_teacher()
  {
    $this->loadModel('Classes');
    $this->loadModel('Sections');
    $this->loadModel('Employees');
    $this->loadModel('Classteachers');
    $Class = $this->Classteachers->find('all')->contain(['Classes', 'Sections', 'Employees'])->where(['teacher_type' => 1])->group(['section_id', 'class_id'])->toarray();
    $this->set('class', $Class);
    // pr($Class); die;

  }

  public function exportclass_section_relations()
  {
    $this->loadModel('Classes');
    $this->loadModel('Sections');
    $this->loadModel('Classteachers');
    $Class = $this->Classteachers->find('all')->contain(['Sections', 'Classes'])->toarray();
    $this->set('class', $Class);
  }

  public function exportschool_calender()
  {

    $this->loadModel('Eventtypes');
    $this->loadModel('Events');
    $school =  $this->Events->find('all')->contain(['Eventtypes'])->toarray();
    $this->set('school', $school);
  }
  public function exportdiscountscheme()
  {
    $this->loadModel('DiscountCategory');
    $this->loadModel('Feesheads');

    $discount =  $this->DiscountCategory->find('all')->toarray();
    $fees =  $this->Feesheads->find('all')->toarray();
    pr($discount);
    die;
  }
  // class and co class teacher Import
  public function importclass_coclass_teacher()
  {

    $this->viewBuilder()->layout('admin');
    $this->loadModel('Classes');
    $this->loadModel('Sections');
    $this->loadModel('Employees');
    $this->loadModel('Classteachers');


    if ($this->request->is('post') || $this->request->is('put')) {
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
        // pr($filesop); die;
        $class = $filesop[0][1];
        $section = $filesop[0][2];
        $classtecher = $filesop[0][3];
        $coclasstecher = $filesop[0][4];
        $conn = ConnectionManager::get('default');

        $db = $this->request->session()->read('Auth.User.db');

        $classes = $this->Classes->find('all')->where(['title' => $class])->first();
        $section = $this->Sections->find('all')->where(['title' => $section])->first();
        // pr($section);

        $co_class   = "INSERT INTO `$db`.`classteachers`(`class_id`,`section_id`,`teacher_type`,`teacher_type`) VALUES ('$class','$section[id]','$classtecher','$coclasstecher')";
        pr($co_class);
        die;
        $conn->execute($co_class);
      }
      $this->Flash->success(__('Class/Co-Class Teacher Uploaded successfully'));
      return $this->redirect(['action' => 'index']);
    }
  }

  // Import item Category function
  public function importitem_category()
  {
    $this->viewBuilder()->layout('admin');
    $this->loadModel('Classes');
    if ($this->request->is('post') || $this->request->is('put')) {
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
        $category = $filesop[0][0];
        $conn = ConnectionManager::get('default');
        $db = $this->request->session()->read('Auth.User.db');
        $item_category   = "INSERT INTO `$db`.`st_categorymaster`(`category_name`) VALUES ('$category')";
        //  pr($co_class); die;
        $conn->execute($item_category);
      }
      $this->Flash->success(__('Item categroy Uploaded successfully'));
      return $this->redirect(['action' => 'index']);
    }
  }


  public function import_items()
  {
    $this->viewBuilder()->layout('admin');
    $this->loadModel('Itemcategory');
    $this->loadModel('Measurementunit');
    $this->loadModel('Companymaster');
    $this->loadModel('Itemlocation');
    $this->loadModel('Taxmaster');

    if ($this->request->is('post') || $this->request->is('put')) {

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

        $cat_name = trim($filesop[0][0]);
        $item_name = $filesop[0][1];
        $hsn_code = $filesop[0][2];
        $tax = $filesop[0][3];
        $cost_price = $filesop[0][4];
        $sale_price = $filesop[0][5];
        $discount = $filesop[0][6];
        $company = $filesop[0][7];
        $qty_in_hand = $filesop[0][8];


        $cat = $this->Itemcategory->find('all')->where(['category_name' => $cat_name])->first();
        $units = $this->Measurementunit->find('all')->where(['unit_name' => $unit])->first();

        $Companys = $this->Companymaster->find('all')->where(['cname' => $company])->first();
        $taxs = $this->Taxmaster->find('all')->where(['tax' => $tax])->first();


        $category = $cat['id'];
        $unit = $units['id'];
        $company = $Companys['id'];
        $tax = $taxs['id'];


        $conn = ConnectionManager::get('default');
        $db = $this->request->session()->read('Auth.User.db');

        $items = "INSERT INTO `$db`.`st_additem`(`category_id`,`item_name`,`item_isbn`,`tax`,`cost_price`,`sale_price`,`discount`,`cname`,`qty_in_hand`) VALUES ('$category','$item_name','$hsn_code','$tax','$cost_price','$sale_price','$discount','$company','$qty_in_hand')";
        // pr($items); die;
        $conn->execute($items);
      }
      $this->Flash->success(__('Items Uploaded successfully'));
      return $this->redirect(['action' => 'index']);
    }
  }
  // import_outstanding_fees

  public function import_due_fees()
  {
    $this->viewBuilder()->layout('admin');
    $this->loadModel('Students');
    $this->loadModel('Classes');
    $this->loadModel('Sections');
    $this->loadModel('Studentsfees');
    $this->loadModel('Studentfeepending');

    if ($this->request->is('post') || $this->request->is('put')) {

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
        $cnt = +1;
        $enroll = $filesop[0][0];
        $dues_fee = $filesop[0][1] + $filesop[0][2];
        // $stu_enroll=$student_enroll['enroll'];
        // $dues_fee = $filesop[0][11]+$filesop[0][12];
        $conn = ConnectionManager::get('default');
        $db = $this->request->session()->read('Auth.User.db');
        $student_data =  "UPDATE $db.`students` SET `due_fees`='$dues_fee' WHERE enroll =" . $enroll;
        // pr($student_data); die;
        $conn->execute($student_data);
      }
      $this->Flash->success(__('Outstanding Fees Uploaded successfully'));
      return $this->redirect(['action' => 'index']);
      $cnt++;
    }
  }

  public function import_outstanding_fees()
  {
    $this->viewBuilder()->layout('admin');
    $this->loadModel('Students');
    $this->loadModel('Classes');
    $this->loadModel('Sections');
    $this->loadModel('Studentfees');
    $this->loadModel('Studentfeepending');

    if ($this->request->is('post') || $this->request->is('put')) {

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
      $cnt = 8;
      for ($row = 2; $row <= $highestRow; $row++) {
        $filesop = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);

        $enroll = $filesop[0][1];
        $total_fees = $filesop[0][8];
        $fee_received = $filesop[0][9];
        $due_fees = $filesop[0][10];

        $student_enroll = $this->Students->find('all')->where(['enroll' => $enroll])->first();
        if ($student_enroll) {
          $stu_id = $student_enroll['id'];
        } else {
          $stu_id = 0;
        }


        $recipetno = $cnt;
        $form_no = 0;
        $type = "Fee";
        $current_date = date('Y-m-d');
        $paydate = date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($current_date));
        $quarter = 0;
        $mode = "CASH";
        $bank = "";
        $cheque_no = "0";
        $is_discount = "0";
        $fee = $total_fees;
        $discountcategory = 0;
        $discount = 0;
        $addtionaldiscount = 0;
        $deposite_amt = $fee_received;
        $ref = 0;
        $refrencepending = 0;
        $status = 'Y';
        $remarks = "Fee Deposited";
        $acedmicyear = "2021-22";
        $lfine = 0;
        $token = '';

        $conn = ConnectionManager::get('default');
        $db = $this->request->session()->read('Auth.User.db');
        $fees = "INSERT INTO `$db`.`student_feeallocations`(`student_id`,`recipetno`,`formno`,`type`,`paydate`,`quarter`,`mode`,`bank`,`cheque_no`,`is_discount`,`fee`,`discountcategory`,`discount`,`addtionaldiscount`,`deposite_amt`,`ref_no`,`refrencepending`,`status`,`remarks`,`acedmicyear`,`lfine`,`token`) VALUES ('$stu_id','$recipetno','$form_no','$type','$paydate','$quarter','$mode','$bank','$cheque_no','$is_discount','$fee',$discountcategory,'$discount','$addtionaldiscount','$deposite_amt','$ref','$refrencepending','$status','$remarks','$acedmicyear','$lfine','$token')";
        $conn->execute($fees);

        $last_insert_id = $this->Studentfees->find()->select(['id'])->last();
        $last_insert_id = $last_insert_id['id'];

        $conns = ConnectionManager::get('default');
        $pendingfees = "INSERT INTO `$db`.`studentfee_pending`(`s_id`,`r_id`,`recipetnos`,`amt`,`status`) VALUES ('$stu_id','$last_insert_id','$recipetno','$due_fees','N')";
        $conns->execute($pendingfees);



        $cnt++;
      }
      $this->Flash->success(__('Outstanding Fees Uploaded successfully'));
      return $this->redirect(['action' => 'index']);
    }
  }

  public function impot_enquiry()
  {
    $this->viewBuilder()->layout('admin');
    $this->loadModel('Classes');
    $this->loadModel('Modes');


    if ($this->request->is('post') || $this->request->is('put')) {
      $inputfilename = $_FILES['file']['tmp_name'];
      try {
        $objPHPExcel = \PHPExcel_IOFactory::load($inputfilename);
      } catch (Exception $e) {
        die('Error loading file "' . pathinfo($inputfilename, PATHINFO_BASENAME) . '": ' . $e->getMessage());
      }
      $sheet = $objPHPExcel->getSheet(0);
      $highestRow = $sheet->getHighestRow();
      //pr($highestRow); die;
      $highestColumn = $sheet->getHighestColumn();
      $c = 0;
      for ($row = 2; $row <= $highestRow; $row++) {
        $filesop = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
        $stu_name = $filesop[0][0];
        $gender = $filesop[0][1];
        $email = $filesop[0][2];
        $bday_date = date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($filesop[0][3]));
        $class = $filesop[0][4];
        $inquiry_date = date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($filesop[0][5]));
        //pr($inquiry_date);
        $status = $filesop[0][6];
        $f_name = $filesop[0][7];
        $m_name = $filesop[0][8];
        $mobile = $filesop[0][9];
        $address = $filesop[0][10];
        $mode = $filesop[0][11];
        $lead_type = $filesop[0][12];
        $enquiry = $filesop[0][13];
        $follo_date =  date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($filesop[0][14]));


        $classes = $this->Classes->find('all')->where(['title' => $class])->first();
        $modes = $this->Modes->find('all')->where(['name' => $mode])->first();

        $conn = ConnectionManager::get('default');
        $db = $this->request->session()->read('Auth.User.db');

        $class = $classes['id'];
        $mode  = $modes['id'];
        $enquiry_mode = 1;


        $enquires = "INSERT INTO `$db`.`enquires`(`s_name`,`gender`,`email`,`bday_date`,`class_id`,`created`,`status`,`f_name`,`m_name`,`mobile`,`address`,`mode_id`,`lead_type`,`enquiry`,`enquiry_mode`,`next_followup_date`) VALUES ('$stu_name','$gender','$email','$bday_date','$class','$inquiry_date','$status','$f_name','$m_name','$mobile','$address','$mode','$lead_type','$enquiry','$enquiry_mode','$follo_date')";


        $conn->execute($enquires);


        $NTSQL = "SELECT * FROM `$db`.`enquires` ORDER BY id DESC LIMIT 1";

        $user_data = $conn->execute($NTSQL)->fetchAll('assoc');
        $last_insert_id = $user_data[0]['id'];


        $conn = ConnectionManager::get('default');
        $db = $this->request->session()->read('Auth.User.db');


        $followup = "INSERT INTO `$db`.`followup`(`enq_id`,`f_date`,`f_responce`,`l_follow_date`) VALUES ('$last_insert_id','$inquiry_date','$enquiry','$follo_date')";


        $conn->execute($followup);
      }
      $this->Flash->success(__('impot enquiry Uploaded successfully'));
      return $this->redirect(['action' => 'index']);
    }
  }

  public function import_drop_students()
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

        $fname = $filesop[0][1];
        $mname = $filesop[0][2];
        $lname = $filesop[0][3];
        if ($fname) {


          $fee_submittedby = $filesop[0][4];
          $fathername = $filesop[0][5];
          $mothername = $filesop[0][6];
          $username = $filesop[0][7];
          $dob =  date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($filesop[0][8]));
          if ($enroll == 0) {
            $enroll = rand(1111, 9999);
          } else {
            $enroll = $filesop[0][9];
          }


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

          if ($father_no) {
            $mobile = $father_no;
            $sms_mobile = $father_no;
          } else {
            $mobile = $mother_no;
            $sms_mobile = $mother_no;
          }

          $created = date('Y-m-d H:i:s', \PHPExcel_Shared_Date::ExcelToPHP($lang22));

          $address = $filesop[0][23];
          $academic_year = "2021-22";
          $comp_sid = '';

          $opt_sid = '';
          $rfidd = '0';
          $student = $this->Students->find('all')->where(['enroll' => $enroll])->first();
          $classes = $this->Classes->find('all')->where(['title' => $class])->first();

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
          $db = $this->request->session()->read('Auth.User.db');

          $board_id  = "1";
          $student_data = "INSERT INTO `$db`.`drop_out_students`(`fname`, `middlename`, `lname`,`fee_submittedby`, `board_id`, `fathername`, `mothername`, `username`, `password`, `dob`, `enroll`, `mobile`,`sms_mobile`, `formno`, `adaharnumber`, `cast`, `parent_id`, `house_id`, `class_id`, `category`, `section_id`, `gender`, `photo`, `bloodgroup`, `religion`, `address`, `city`, `nationality`, `created`, `admissionyear`, `acedmicyear`, `status`, `file`, `comp_sid`, `opt_sid`, `h_id`, `room_no`, `is_transport`, `transportloc_id`, `v_num`, `dis_fees`,  `dis_transport`, `is_discount`, `due_fees`, `token`,`rf_id`,`f_phone`,`m_phone`) VALUES ('$fname','$mname','$lname','$fathername','$board_id','$fathername','$mothername','$username','12345','$dob','$enroll','$mobile','$sms_mobile','43534','$adaharnumber','$cast','0','$house_id','$classid','$category','$section_id','$gender','$stu_img','O','$religion','$address','Jaipur','INDIAN','$created','$admissionyear','$academic_year','Y','','$comp_sid','$opt_sid','$house_id','','1','9','RJ-3456','0','0','0','0','d19zotIWXww:APA91bHsDcEda1obUeddDumwRF0BhrwbccFskQ','$rfidd','$father_no','$mother_no')";
          // echo $student_data; die;
          $exicute = $conn->execute($student_data);
        }
      }
      $this->Flash->success(__('Dropout Student Uploaded successfully'));
      return $this->redirect(['action' => 'index']);
    }
  }


  // Import Vendors  function
  public function importvendors()
  {
    $this->viewBuilder()->layout('admin');
    $this->loadModel('Vendors');
    $this->loadModel('States');

    if ($this->request->is('post') || $this->request->is('put')) {
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

        $supplier_name = $filesop[0][0];
        $mobile = $filesop[0][1];
        $contact_person_name = $filesop[0][2];
        $email = $filesop[0][3];
        $pan_no = $filesop[0][4];
        $tin_no = $filesop[0][5];
        $tin_date = $filesop[0][6];
        $state = $filesop[0][7];
        //pr($state); die;
        $gst_no = $filesop[0][8];
        $address = $filesop[0][9];
        $discription = $filesop[0][10];
        $type = $filesop[0][11];

        $states = $this->States->find('all')->where(['States.name' => $state])->first();
        //pr($states); die;

        $state = $states['id'];

        $conn = ConnectionManager::get('default');
        $db = $this->request->session()->read('Auth.User.db');
        $vendors  = "INSERT INTO `$db`.`vendors`(`name`,`contact_no`,`contact_person`,`email`,`pancard_number`,`tin_no`,`tin_date`,`state_id`,`gst_number`,`address`,`description`,`type`) VALUES ('$supplier_name','$mobile','$contact_person_name','$email','$pan_no','$tin_no','$tin_date','$state','$gst_no','$address','$discription','$type')";
        // pr($vendors); die;
        $conn->execute($vendors);
      }
      $this->Flash->success(__('Vendors Uploaded successfully'));
      return $this->redirect(['action' => 'index']);
    }
  }

  public function database_name()
  {
    $connection = ConnectionManager::get('default');
    $results = $connection->execute("SHOW DATABASES LIKE '" . $this->request->data['school_database'] . "'")->fetchAll('assoc');
  }
  // check employee 
  // public function employeecheck()
  //   {
  //     $this->autoRender = false;

  //      $this->loadModel('Employees');
  //      $this->loadModel('Users');
  //      $employees = $this->Employees->find('all')->toarray();
  //      $connss = ConnectionManager::get('default');
  //      foreach($employees as $val){ 

  //       $email_exists = $this->Users->find('all')->where(['tech_id' =>$val['id']])->first();
  //          $username = $val['fname'];
  //          $cid = '0';
  //          $acedmicyear = "2022-23";
  //          $email = $val['email'];
  //          $tech_id = $val['id'];
  //          $password = '$2y$10$.vwir1Fyl5EkpHbNfEYFl.vU7raO0gFMuM.QnwVqpLM77Mjlot1Zm';
  //          $cpassword = '12345';
  //          $created = date('Y-m-d H:i:s', strtotime($val['created']));
  //          $modified = date('Y-m-d H:i:s');
  //          $role_id = '3';
  //          $mobile = $val['mobile'];
  //          $dbname = $this->request->session()->read('Auth.User.db'); 

  //       $employee_data = "INSERT INTO `school_erp`.`users` (`user_name`,`c_id`,`academic_year`, `email`,`tech_id`, `password`, `confirm_pass`, `created`, `modified`, `role_id`, `mobile`,`db`) VALUES('$username','$cid','$acedmicyear','$email','$tech_id', '$password','$cpassword','$created','$modified', $role_id,'$mobile','$dbname')";

  //       pr($employee_data); 
  //      // $exicute = $connss->execute($employee_data);

  //       $connssddd = ConnectionManager::get('default');
  //       $NTSQL = "SELECT * FROM `school_erp`.`users` order by id desc";
  //       $user_data = $connssddd->execute($NTSQL)->fetchAll('assoc');
  //       $user_new_id = $user_data[0]['id'];
  //       $connffsss = ConnectionManager::get('default');
  //       $employee_user_data =  "UPDATE `$dbname`.`users` SET `id`='$user_new_id ' WHERE tech_id =".$tech_id;
  //       pr($employee_user_data); die;

  //       $exicute=$connffsss->execute($employee_user_data);


  //     }
  //   }



  public function updtenrollandrollno()
  {

    $this->viewBuilder()->layout('admin');
    $this->loadModel('Students');

    if ($this->request->is('post') || $this->request->is('put')) {
      //pr($_FILES); die;
      $inputfilename = $_FILES['file']['tmp_name'];
      try {
        $objPHPExcel = \PHPExcel_IOFactory::load($inputfilename);
      } catch (Exception $e) {
        die('Error loading file "' . pathinfo($inputfilename, PATHINFO_BASENAME) . '": ' . $e->getMessage());
      }

      $sheet = $objPHPExcel->getSheet(0);
      $highestRow = $sheet->getHighestDataRow();

      $highestColumn = $sheet->getHighestColumn();
      $c = 0;

      for ($row = 2; $row <= $highestRow; $row++) {

        $filesop = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);

        $enroll = $filesop[0][0];
        $Enrollment_no = $filesop[0][1];
        $rollNo = $filesop[0][2];
        // pr($enroll);

        $student = $this->Students->find('all')->where(['enroll' => $enroll])->first();


        $connffsss = ConnectionManager::get('default');
        $employee_user_data =  "UPDATE `students` SET `enrolment_no`='$Enrollment_no ',`roll_no`='$rollNo' WHERE enroll =" . $student['enroll'];
        $connffsss->execute($employee_user_data);
       
      }
      $this->Flash->success(__('Students Enrollment & Roll No Updated Successfully!!!'));
      return $this->redirect(['action' => 'index']);
    }
  }
}
