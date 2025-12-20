<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email;
use Cake\Datasource\ConnectionManager;
use ZipArchive;

include '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
include '../vendor/phpmailer/phpmailer/src/Exception.php';
include '../vendor/phpmailer/phpmailer/src/SMTP.php';
include '../vendor/phpmailer/phpmailer/src/OAuth.php';
include '../vendor/autoload.php';

class CronController extends AppController
{
  public function initialize()
  {
    parent::initialize();
  }

  public function beforeFilter(Event $event)
  {
    $this->loadModel('Users');
    parent::beforeFilter($event);
    $this->loadComponent('Cookie');
    $this->Auth->allow(['dataBaseBackup', 'sendDatabaseBackup', 'sendresultdeclar_notification', 'gettotalpendingfeescron', 'getstudenttotalfeesdetails', 'gettotalpendingfees']);
  }


  public function sendDatabaseBackup()
  {
    $host = MYSQLHOST;
    $user = MYSQLUESRNAME;
    $pass = MYSQLPASSWORD;

    $backupDirectory = ROOT . '/webroot/DbBackup/';
    $mysqli = new \mysqli($host, $user, $pass);
    if ($mysqli->connect_error) {
      die('Connection failed: ' . $mysqli->connect_error);
    }

    $databases = $mysqli->query("SHOW DATABASES");
    if (!$databases) {
      die('Error: ' . $mysqli->error);
    }

    $message = "Please find the attached database backup.";
    $subject = 'Dhanwantri ERP DB backup downloaded successfully: ' . date("d-m-Y");
    // $to = 'vikas@doomshell.com';
    $to = 'rajesh@doomshell.com';
    // $to = 'rahulbishnoi0789@gmail.com';

    Email::configTransport('gmail', [
      'host' => 'smtp.gmail.com',
      'port' => 587,
      'username' => 'sanjay@doomshell.com',
      'password' => 'Sanjay@1223',
      'className' => 'Smtp',
      'timeout' => 120,
      'tls' => true

    ]);
    $email = new Email();
    $email->transport('gmail');

    // Assuming $to, $subject, and $message are defined elsewhere in your code

    $zipFiles = [];

    while ($row = $databases->fetch_assoc()) {
      $dbname = $row['Database'];

      if ($dbname == 'information_schema' || $dbname == 'mysql' || $dbname == 'performance_schema') {
        continue;
      }

      if ($dbname == "dhanwantri" || $dbname == "school_erp") {
        $zipFileName = $backupDirectory . $dbname . '_backup_' . date("d_m_Y") . '.zip';

        $zipFiles[] = [
          'file' => $zipFileName,
          'mimetype' => 'application/zip',
          'contentId' => 'backup_' . $dbname . '_' . date("d_m_Y"),
        ];
      }
    }

    if (!empty($zipFiles)) {
      $email->attachments($zipFiles);
      $email->addCc('sanjay@doomshell.com');
        // ->addCc('rajesh@doomshell.com');

      $res = $email->from(['sanjay@doomshell.com' => 'DhanwantriErp'])
        ->to($to)
        ->subject($subject)
        ->emailFormat('html')
        ->send($message);

      if ($res) {
        // If email sent successfully, remove the zip files
        foreach ($zipFiles as $file) {
          if (file_exists($file['file']) && unlink($file['file'])) {
            echo "File deleted successfully.<br>";
          } else {
            echo "Failed to delete file.<br>";
          }
        }
        echo "Email sent successfully.";
      } else {
        echo "Failed to send email.";
      }
    } else {
      echo "No database backups found to send.";
    }
  }

  public function dataBaseBackup()
  {
    $host = MYSQLHOST;
    $user = MYSQLUESRNAME;
    $pass = MYSQLPASSWORD;
    $dbname = DB_NAME;

    $backupDirectory = ROOT . '/webroot/DbBackup/';

    $mysqli = new \mysqli($host, $user, $pass);
    if ($mysqli->connect_error) {
      die('Connection failed: ' . $mysqli->connect_error);
    }

    $databases = $mysqli->query("SHOW DATABASES");
    if (!$databases) {
      die('Error: ' . $mysqli->error);
    }

    while ($row = $databases->fetch_assoc()) {
      $dbname = $row['Database'];

      // Skip system databases if needed
      if ($dbname === 'information_schema' || $dbname === 'mysql' || $dbname === 'performance_schema') {
        continue;
      }


      if ($dbname == "dhanwantri" || $dbname == "school_erp") {

        $mysqli->select_db($dbname);
        $tables = $mysqli->query("SHOW TABLES");

        if (!$tables) {
          die('Error: ' . $mysqli->error);
        }


        $backupContent = '';

        while ($tableRow = $tables->fetch_row()) {
          $table = $tableRow[0];

          $structure = $mysqli->query("SHOW CREATE TABLE `$table`");
          if (!$structure) {
            die('Error: ' . $mysqli->error);
          }
          $createTableSQL = $structure->fetch_row()[1];

          $data = $mysqli->query("SELECT * FROM `$table`");
          if (!$data) {
            die('Error: ' . $mysqli->error);
          }
          $insertDataSQL = '';

          while ($rowData = $data->fetch_assoc()) {
            $values = array_map([$mysqli, 'real_escape_string'], array_values($rowData));
            $insertDataSQL .= "INSERT INTO `$table` VALUES ('" . implode("', '", $values) . "');\n";
          }

          $backupContent .= "DROP TABLE IF EXISTS `$table`;\n" . $createTableSQL . ";\n\n" . $insertDataSQL . "\n\n\n";
        }
        $mysqli->next_result(); // Move to the next result set

        // $backupFileName = $backupDirectory . $dbname . '_backup_' . date("d_m_Y") . '.sql';
        // file_put_contents($backupFileName, $backupContent);
        // @chmod($backupFileName, 0777);

        $zipFileName = $backupDirectory . $dbname . '_backup_' . date("d_m_Y") . '.zip';

        $zip = new \ZipArchive();

        if ($zip->open($zipFileName, \ZipArchive::CREATE) === true) {
          $zip->addFromString($dbname . '_backup_' . date("d_m_Y") . '.sql', $backupContent);
          $zip->close();
          @chmod($zipFileName, 0777);
          echo 'File compressed successfully for database ' . $dbname . '.';
        } else {
          echo 'Failed to create zip archive for database ' . $dbname . '.';
        }
        echo 'Backup completed successfully for database ' . $dbname . '!';
      }
    }
    // exit;

    $mysqli->close();
    $this->sendDatabaseBackup();
    echo 'Mail Send';
    die;
  }



  /// for  students pending fee cron function
  public function gettotalpendingfeescron()
  {


    $this->loadModel('Students');
    $this->loadModel('Classes');
    $this->loadModel('Sections');

    $this->autoRender = false;

    $students_details = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.status' => "Y"])->toArray();
    // pr($students_details); die;
    $total_balance = 0;

    foreach ($students_details as $value) {
      $getFeesDetails = $this->getstudenttotalfeesdetails($value);
      // pr($getFeesDetails); die;
      $section1 = $value['section_id'];

      if ($section1 == 1) {
        $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'];
        $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'];
        $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'];
      } elseif ($section1 == 2) {
        $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'];
        $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'];
        $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'];
      } elseif ($section1 == 3) {
        $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'];
        $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'];
        $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'];
      } else {
        $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['4th_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'] + $getFeesDetails['4th_year_transport_fees'];
        $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['4th_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'] + $getFeesDetails['4th_year_students_transport_deposite'];
        $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'] + $getFeesDetails['4th_year_students_discount'];
      }


      $total_balance += $total_batch_fee - $total_batch_paid_fee - $getFeesDetails['discount'];
    }

    $conn = ConnectionManager::get('default');
    $role_id = 1;
    $detail1 = 'UPDATE `users` SET `pending_fees` ="' . $total_balance . '" WHERE `users`.`role_id` = "' . $role_id . '"';
    // pr($detail1); die;
    $conn->execute($detail1);
  
  }


  //for dashboard fees update

  public function gettotalpendingfees()
  {


    $this->loadModel('Students');
    $this->loadModel('Classes');
    $this->loadModel('Sections');

    $this->autoRender = false;

    $students_details = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.status' => "Y"])->toArray();
    // pr($students_details); die;
    $total_balance = 0;

    foreach ($students_details as $value) {
      $getFeesDetails = $this->getstudenttotalfeesdetails($value);
      // pr($getFeesDetails); die;
      $section1 = $value['section_id'];

      if ($section1 == 1) {
        $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'];
        $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'];
        $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'];
      } elseif ($section1 == 2) {
        $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'];
        $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'];
        $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'];
      } elseif ($section1 == 3) {
        $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'];
        $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'];
        $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'];
      } else {
        $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['4th_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'] + $getFeesDetails['4th_year_transport_fees'];
        $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['4th_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'] + $getFeesDetails['4th_year_students_transport_deposite'];
        $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'] + $getFeesDetails['4th_year_students_discount'];
      }


      $total_balance += $total_batch_fee - $total_batch_paid_fee - $getFeesDetails['discount'];
    }

    $conn = ConnectionManager::get('default');
    $role_id = 1;
    $detail1 = 'UPDATE `users` SET `pending_fees` ="' . $total_balance . '" WHERE `users`.`role_id` = "' . $role_id . '"';
    // pr($detail1); die;
    $conn->execute($detail1);
    return $this->redirect(['controller' => 'admin/dashboards', 'action' => 'adminbranch']);
  }




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
}
