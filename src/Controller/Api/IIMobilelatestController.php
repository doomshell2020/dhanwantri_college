<?php

namespace App\Controller\Api;

use App\Controller\Api\AppController;
use App\Controller\App;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Cake\Http\Client;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;
use Cake\Validation\Validator;
use Firebase\JWT\JWT;
use RNCryptor\RNCryptor\Decryptor;
use RNCryptor\RNCryptor\Encryptor;
use TCPDF;

//GuzzleHttp\Client;
//use guzzlehttp\guzzle\Client;

//include '../vendor/rncryptor/rncryptor/src/RNCryptor/Decryptor.php';
//  include '../vendor/autoload.php';
//  require_once 'php-jwt-master/src/BeforeValidException.php';
// require_once 'php-jwt-master/src/ExpiredException.php';
// require_once 'php-jwt-master/src/SignatureInvalidException.php';
// require_once 'php-jwt-master/src/JWT.php';

class IIMobilelatestController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        // $this->request->addDetector([
        //     'json' => ['accept' => ['application/json'], 'param' => '_ext', 'value' => 'json', 'getClassSubjects'],

        // ]);
    }
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['userLogin', 'verifyOtp', 'prepareRequestBody', 'dPayload_encrypt', 'passwordLogin', 'forgotPasswordAll', 'test', 'downloadPdf']);
    }

    public $helpers = ['CakeJs.Js'];

    public function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }
    //Database conection 
    public function db($dbs)
    {
        ConnectionManager::config($dbs, [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            'username' => 'dhanwantari',
            'password' => 'dhanwantari@23~',
            'database' => $dbs,
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
        ]);
        ConnectionManager::drop('default');
        ConnectionManager::get($dbs);
        \Cake\Datasource\ConnectionManager::alias($dbs, 'default');

        $this->loadModel('Users');
        $this->loadmodel('Leaves');
        $this->loadmodel('Contacts');
        $this->loadmodel('Studentfeepending');
        $this->loadmodel('Students');
        $this->loadmodel('Classes');
        $this->loadmodel('Sections');
        $this->loadmodel('Classections');
        $this->loadmodel('Guardians');
        $this->loadmodel('Studentfees');
        $this->loadmodel('Classfee');
        $this->loadmodel('ClasstimeTabs');
        $this->loadmodel('Employees');
        $this->loadmodel('Employeeattendance');
        $this->loadmodel('Subjects');
        $this->loadmodel('Timetables');
        $this->loadmodel('Locations');
        $this->loadmodel('Transports');
        $this->loadmodel('Transportfees');
        $this->loadmodel('StudentTransfees');
        $this->loadmodel('Hostels');
        $this->loadmodel('StudentHostalfees');
        $this->loadmodel('IssueBook');
        $this->loadmodel('BookCopyDetail');
        $this->loadmodel('Book');
        $this->loadmodel('BookCategory');
        $this->loadmodel('CupBoard');
        $this->loadmodel('CupBoardShelf');
        $this->loadmodel('Fine');
        $this->loadmodel('Events');
        $this->loadmodel('Addresses');
        $this->loadmodel('Cities');
        $this->loadmodel('States');
        $this->loadmodel('Country');
        $this->loadmodel('Contacts');
        $this->loadmodel('Eventtypes');
        $this->loadmodel('Studattends');
        $this->loadmodel('Assignments');
        $this->loadmodel('Classteachers');
        $this->loadmodel('Feesheads');
        $this->loadmodel('Smsmanager');
        $this->loadmodel('Smsdelivery');
        $this->loadmodel('Album');
        $this->loadmodel('Exams');
        $this->loadmodel('Studentexamresult');
        $this->loadmodel('DropOutStudent');
        $this->loadmodel('Examtypes');
        $this->loadModel('Schools');
        $this->loadmodel('gatepass');
        $this->loadComponent('Cookie');
        $this->loadmodel('ZoomLiveClasses');
        $this->loadmodel('ZoomUsers');
        $this->loadmodel('Subjectclass');
        $this->loadmodel('Classes');
        $this->loadmodel('Subjects');
        $this->loadmodel('Notification');
        $this->loadmodel('ZoomLiveClassesDetail');
    }



    /******************************************************** Basic  API's Start *********************************************/
    /*
1. passwordLogin
2. slider
3. getNotificationCount
4. prepareRequestBody
5. dPayload_encrypt
6. viewevents
7. eventtype
8. notifications
9. photoGallery
10. firebaseNotification
11. dPayload
12. uploadToken
*/

    /****************************************** For Student,Staff and admin app login api*****************************************/

    public function update_login_time($studenid, $dbname)
    {
        $this->db($dbname);
        $connss = ConnectionManager::get($dbname);
        $this->loadModel('Users');
        $detail = $connss->execute("SELECT * FROM users where student_id=$studenid and role_id=2");
        return $detail->fetchAll('assoc');
    }

    public function updatestafflogintime($user_mobile, $db)
    {
        $this->db($db);
        $connss = ConnectionManager::get($db);
        $this->loadModel('Users');
        $detail = $connss->execute("SELECT * FROM users where mobile=$user_mobile ");
        return $detail->fetchAll('assoc');
    }

    public function passwordLogin()
    {
        $this->autoRender = false;

        $this->loadModel('Schools');
        $this->loadModel('SitesettingsDetails');
        $this->loadModel('Users');


        $login_type = $this->request->data['login_type'];
        $mobile = $this->request->data['mobile'];
        $otp = $this->request->data['password'];

        if (empty($mobile) || empty($login_type) || empty($otp)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Paramenters";
            echo json_encode($response);
            return;
        }

        $user = $this->Auth->identify();

        if ($user) {
            if ($login_type == 'Student') {
                $students = $this->Users->find('all')->where(['Users.role_id' => '2', 'Users.mobile' => $mobile])->group(['Users.db'])->toarray();
                //sanjay code 09-01-2023
                $studenid = $students[0]['student_id'];
                $dbname = $students[0]['db'];
                $app_date_add = $this->update_login_time($studenid, $dbname);

                if (empty($app_date_add[0]['install_date'])) {

                    $conn = ConnectionManager::get('default');
                    $date = date('Y-m-d H:i:s');
                    $stu_id = $studenid;
                    $details = 'UPDATE ' . $dbname . '.`users` SET `install_date` ="' . $date . '" WHERE `student_id` = "' . $stu_id . '"';
                    $conn->execute($details);
                }

                $conn = ConnectionManager::get('default');
                $date = date('Y-m-d H:i:s');
                $stu_id = $studenid;
                $detail = 'UPDATE ' . $dbname . '.`users` SET `last_login` ="' . $date . '" WHERE `student_id` = "' . $stu_id . '"';
                $conn->execute($detail);



                if (empty($students)) {
                    $response['success'] = 0;
                    $response['message'] = "Invalid username and password !!";
                    $this->response->type('application/json');
                    $this->response->body(json_encode($response));
                    return $this->response;
                }
                $result = 1;
                $response["success"] = 1;
                $data['userInfo']["roleId"] = 'STUDENT';
                $data['userInfo']["mobile"] = $mobile;


                $data['userInfo']['detail'] = array();

                foreach ($students as $student) {
                    $school = $this->Schools->find('all')->where(['Schools.school_database' => $student['db']])->first();
                    $school_name = $school['school_name'];
                    $enroll["idsprimeID"] = $student['db'];
                    $enroll['school_name'] = $school_name;
                    // $filename2 = 'https://idsprime.com/images/' . $student['db'] . 'logo.png';
                    $filename2 =  SITE_URL . 'images/' . $student['db'] . 'logo.png';
                    if ($filename2) {
                        // $enroll["logo"] = 'https://idsprime.com/images/' . $student['db'] . 'logo.png';
                        $enroll["logo"] = SITE_URL . 'images/' . $student['db'] . 'logo.png';
                    } else {
                        $enroll["logo"] = null;
                    }
                    $enroll['school_name'] = $school_name;
                    $studentsdetail = $this->Users->find('all')->where(['Users.role_id' => '2', 'Users.mobile' => $mobile, 'Users.db' => $student['db']])->toarray();
                    $enroll["userdetail"] = array();
                    foreach ($studentsdetail as $studentsde) {
                        $studentinfo['id'] = $studentsde['student_id'];
                        $studentinfo['enrollNo'] = $studentsde['email'];
                        $enroll["userdetail"][] = $studentinfo;
                        // array_push($data["userInfo"]['detail'], $enroll["details"]);
                    }
                    array_push($data["userInfo"]['detail'], $enroll);
                }
                $issuedAt = time();
                $expirationTime = $issuedAt + 60 * 60 * 24 * 60;

                $data['userInfo']['authToken'] = JWT::encode(
                    [
                        'sub' => $students[0]['id'],
                        'exp' => $expirationTime,
                    ],
                    Security::salt()
                );
                $cryptor = new Encryptor;

                $response['output'] = $cryptor->encrypt(json_encode($data), DECRYPT);

                echo json_encode($response);
                return;
            } else if ($login_type == 'Staff') {
                $user = $this->Users->find('all')->where(['Users.mobile' => $mobile, 'role_id IN' => [3, 21]])->first();

                if (empty($user)) {
                    $response['success'] = 0;
                    $response['message'] = "Invalid username and password !!";
                    $this->response->type('application/json');
                    $this->response->body(json_encode($response));
                    return $this->response;
                }
                $response["success"] = 1;
                if ($user['role_id'] == '3') {
                    $data['userInfo']['roleId'] = 'TEACHER';
                } else if ($user['role_id'] == '21') {
                    $data['userInfo']['roleId'] = 'GUARD';
                } else {
                    $response["success"] = 0;
                    $response["message"] = "Invalid User Type";
                    echo json_encode($response);
                    return;
                }


                //Sanjay 09-01-2023
                $user_mobile = $user['mobile'];
                $db = $user['db'];
                $staff_date_add = $this->updatestafflogintime($user_mobile, $db);

                if (empty($staff_date_add[0]['install_date'])) {

                    $conn = ConnectionManager::get('default');
                    $date = date('Y-m-d H:i:s');
                    $stu_id = $studenid;

                    $details = 'UPDATE' . $dbname . '`users` SET `install_date` ="' . $date . '" WHERE `mobile` = "' . $user_mobile . '"';
                    $conn->execute($details);
                }

                $conn = ConnectionManager::get('default');
                $date = date('Y-m-d H:i:s');
                $detail = 'UPDATE ' . $dbname . '`users` SET `last_login` ="' . $date . '" WHERE `mobile` = "' . $user_mobile . '"';
                $conn->execute($detail);

                $data['userInfo']['mobile'] = $mobile;
                $school = $this->Schools->find('all')->where(['Schools.id' => $user['c_id']])->first();

                $school_name = $school['school_name'];
                $data['userInfo']['schoolInfo']["idsprimeID"] = $user['db'];
                $data['userInfo']['schoolInfo']['school_name'] = $school_name;
                // $filename2 = 'https://idsprime.com/images/' . $user['db'] . 'logo.png';
                $filename2 = SITE_URL . '.images/' . $user['db'] . 'logo.png';

                if ($filename2) {
                    // $data['userInfo']['schoolInfo']["logo"] = 'https://idsprime.com/images/' . $user['db'] . 'logo.png';
                    $data['userInfo']['schoolInfo']["logo"] = SITE_URL . 'images/' . $user['db'] . 'logo.png';
                } else {
                    $data['userInfo']['schoolInfo']["logo"] = null;
                }
                $data['userInfo']['empId'] = $user['tech_id'];
                $data['userInfo']['authToken'] = JWT::encode(
                    [
                        'sub' => $user['id'],
                        'exp' => $expirationTime,
                    ],
                    Security::salt()
                );
                $cryptor = new Encryptor;
                $response['output'] = $cryptor->encrypt(json_encode($data), DECRYPT);
                echo json_encode($response);
                return;
            } else if ($login_type == 'Admin') {
                $user = $this->Users->find('all')->where(['Users.mobile' => $mobile])->first();
                $response["success"] = 1;
                $data['userInfo']['empId'] = $user['id'];
                if ($user['role_id'] == '6') {
                    $data['userInfo']['roleId'] = 'ADMIN';
                } else {
                    $response["success"] = 0;
                    $response["message"] = "Invalid User Type";
                    echo json_encode($response);
                    return;
                }
                $data['userInfo']["mobile"] = $mobile;

                $school = $this->Schools->find('all')->where(['Schools.id' => $user['c_id']])->first();

                $school_name = $school['school_name'];
                $data['userInfo']['schoolInfo']["idsprimeID"] = $user['db'];
                $data['userInfo']['schoolInfo']['school_name'] = $school_name;

                $filename2 = 'https://idsprime.com/images/' . $user['db'] . 'logo.png';
                // print_r($filename2); die;
                // $filename2 = SITE_URL . 'images/' . $user['db'] . 'logo.png';

                if ($filename2) {
                    // $data['userInfo']['schoolInfo']["logo"] = SITE_URL . 'images/' . $user['db'] . 'logo.png';

                    $data['userInfo']['schoolInfo']["logo"] = 'https://idsprime.com/images/' . $user['db'] . 'logo.png';
                } else {
                    $data['userInfo']['schoolInfo']["logo"] = null;
                }
                $data['userInfo']['authToken'] = JWT::encode(
                    [
                        'sub' => $user['id'],
                        'exp' => time() + 604800,
                    ],
                    Security::salt()
                );
                $cryptor = new Encryptor;
                $response['output'] = $cryptor->encrypt(json_encode($data), DECRYPT);
                echo json_encode($response);
                return;
            } else {
                $response["success"] = 0;
                $response["message"] = "Invalid User Type";
                echo json_encode($response);
                return;
            }
        } else {
            $response['success'] = 0;
            $response['message'] = "Invalid mobile and password !!";
            $this->response->type('application/json');
            $this->response->body(json_encode($response));
            return $this->response;
        }
    }
    /******************************************************** use to show the slider in app *********************************************/
    // public function slider()
    // {

    //     $this->autoRender = false;
    //     $response = array();
    //     $jsonData = $this->request->input('json_decode');
    //     if (empty($jsonData)) {
    //         $response["success"] = 0;

    //         $response["message"] = "Invalid Json Data";
    //         echo json_encode($response);
    //         return;
    //     } else {
    //         $postData = $this->dPayload($jsonData);
    //         $idsprimeID = $postData->idsprimeID;
    //         $this->db($idsprimeID);
    //         $this->loadmodel('Slider');
    //         $sliders = $this->Slider->find('all')->where(['status' => 'Y'])->toarray();
    //         if (!empty($sliders)) {
    //             $response['success'] = 1;
    //             $response['slider'] = array();
    //             foreach ($sliders as $slider) {
    //                 $output = array();
    //                 // $filename2 = 'sliderimages/' . $slider['image'];
    //                 $filename2  = SITE_URL . 'sliderimages/' . $slider['image'];
    //                 // pr($filename2);exit;

    //                 // if ($this->is_url_exist($filename2)) {
    //                 $output['title'] = $slider['title'];
    //                 $output['image'] =  $filename2;
    //                 // $output['image'] = 'sliderimages/' . $slider['image'];
    //                 // }else{
    //                 // pr('else');exit;
    //                 // }
    //                 if (!empty($output)) {
    //                     array_push($response['slider'], $output);
    //                 }
    //             }
    //             if (empty($response['slider'])) {
    //                 $response['success'] = 0;
    //                 $response['message'] = "No Slider Available";
    //                 $response['slider'] = null;
    //             }
    //         } else {
    //             $response['success'] = 0;
    //             $response['message'] = "No Slider Available";
    //             $response['slider'] = null;
    //         }

    //         echo json_encode($response);
    //     }
    // }

    public function slider()
    {
        $this->autoRender = false;
        $response = [];
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        }

        $postData = $this->dPayload($jsonData);
        $idsprimeID = $postData->idsprimeID;
        $this->db($idsprimeID);
        $this->loadModel('Slider');
        $sliders = $this->Slider->find()
            ->where(['status' => 'Y'])
            ->toArray();

        if (empty($sliders)) {
            $response['success'] = 0;
            $response['message'] = "No Slider Available";
            $response['slider'] = null;
            echo json_encode($response);
            return;
        }

        $response['success'] = 1;
        $response['slider'] = [];

        foreach ($sliders as $slider) {
            $sliderData = [];
            $sliderData['title'] = $slider['title'];
            $sliderData['image'] = SITE_URL . 'sliderimages/' . $slider['image'];

            if (!empty($sliderData)) {
                array_push($response['slider'], $sliderData);
            }
        }

        if (empty($response['slider'])) {
            $response['success'] = 0;
            $response['message'] = "No Slider Available";
            $response['slider'] = null;
        }

        echo json_encode($response);
    }

    /******************************************************** getNotificationCount *********************************************/

    public function getNotificationCount()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $userid = $postData->userId;
            $login_type = $postData->login_type;
            $idsprimeID = $postData->idsprimeID;
            if (empty($idsprimeID) || empty($userid) || empty($login_type)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);

            $this->loadmodel('Students');
            $this->loadmodel('Notication');
            $this->autoRender = false;
            $response = array();

            $mon = date('m');
            $year = date('Y');

            if ($login_type == 'Student') {
                // 27-04-2023 code 
                $stExists = $this->Students->find('all')->where(['Students.id' => $userid, 'Students.status' => 'Y'])->first();

                if (!empty($stExists)) {
                    $classId = $stExists['class_id'];
                    $sectionId = $stExists['section_id'];

                    $result = $this->Notication->find('all')->where(['MONTH(Notication.create_date)' => $mon, 'YEAR(Notication.create_date)' => $year, 'type' => 'Student', 'class_id' => $classId, 'section_id' => $sectionId])->order(['id' => 'DESC'])->count();
                }
            } else if ($login_type == 'Teacher') {

                $result = $this->Notication->find('all')->where(['MONTH(Notication.create_date)' => $mon, 'YEAR(Notication.create_date)' => $year, 'type' => 'Teacher'])->order(['id' => 'DESC'])->count();
                // $result = $this->Notication->find('all')->where(['type' => 'Teacher'])->count();

            } else {
                $response["success"] = 1;
                $response["notificationCount"] = 1;
                echo json_encode(($response));
                die;
            }


            if (count($result) > 0) {
                $response["success"] = 1;
                $response["notificationCount"] = (int) $result;
                echo json_encode(($response));
            } else {
                $response["success"] = 0;
                $response["message"] = "This user doesn't exists";
                echo json_encode(($response));
            }
        }
    }

    /******************************************************** Use To Create Payload  *********************************************/
    public function prepareRequestBody()
    {
        $data = json_encode($this->request->data);
        $cryptor = new Encryptor;
        $base64Encrypted = $cryptor->encrypt($data, DECRYPT);
        $response['payload'] = $base64Encrypted;
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
    }


    /******************************************************** Data increption  *********************************************/
    public function dPayload_encrypt()
    {
        $data = $this->request->data['encode'];
        $cryptor = new Decryptor;
        $plaintext = $cryptor->decrypt($data, DECRYPT);
        print_r($plaintext);
        die;
    }

    /******************************************************** Create a payload for website security  *********************************************/

    public function dPayload($data)
    {

        $base64Encrypted = $data->payload;
        $cryptor = new Decryptor;
        $plaintext = $cryptor->decrypt($base64Encrypted, DECRYPT);
        $postData = json_decode($plaintext);
        return $postData;
    }

    /******************************************************** Create a payload for upload Token  *********************************************/

    public function uploadToken()
    {
        $response = array();
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');

        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $jsonData = $this->request->input('json_decode');
            $postData = $this->dPayload($jsonData);


            $userid = $postData->userId;
            $token = $postData->token;
            $roleId = $postData->roleId;
            $idsprimeID = $postData->idsprimeID;
            if (empty($userid) || empty($idsprimeID) || empty($token) || empty($roleId)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $this->loadmodel('Students');
            $rttr = 0;
            if ($roleId == "STUDENT") {
                $uid = explode(',', $userid);
                $student_status = $this->Students->find('all')->where(['Students.id IN' => $uid])->count();
                if ($student_status > 0) {

                    foreach ($uid as $kk => $rrt) {

                        $Students = $this->Students->get($rrt);
                        $Students->token = $token;
                        if ($this->Students->save($Students)) {
                            $rttr++;
                        }
                    }

                    if ($rttr > 0) {
                        $response["success"] = 1;
                        $response["message"] = "Token upload success";
                    } else {
                        $response["success"] = 0;
                        $response["message"] = "Token upload failed";
                    }
                } else {
                    $response["success"] = 0;
                    $response["message"] = "Token upload failed";
                }
            } elseif ($roleId == "TEACHER") {

                $emp_status = $this->Employees->find('all')->where(['Employees.id' => $userid])->count();
                if ($emp_status > 0) {
                    $Employees = $this->Employees->get($userid);

                    $Employees->token = $token;

                    if ($this->Employees->save($Employees)) {
                        $response["success"] = 1;
                        $response["message"] = "Token upload success";
                    } else {
                        $response["success"] = 0;
                        $response["message"] = "Token upload failed";
                    }
                } else {

                    $response["success"] = 0;
                    $response["message"] = "Token upload failed";
                }
            } else {

                $response["success"] = 0;
                $response["message"] = "Token upload failed";
            }

            echo json_encode($response);
            die;
        }
    }

    /*****************************************************************Basic API's End*********************************************************************/

    /**************************************************************this api use to view events in student / Staff calender***********************************/
    public function viewevents()
    {

        $response = array();
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $period = $postData->date;
            $idsprimeID = $postData->idsprimeID;
            if (empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            //head branch database connections
            $db_name = explode("_", $idsprimeID);
            if ($db_name[0] == "canvas") {
                $this->db($db_name[0]);
            } else {
                $this->db($idsprimeID);
            }

            if (empty($period)) {
                $period = date('m-Y');
            }
            $expDate = explode('-', $period);
            $month = $expDate[0];
            $year = $expDate[1];

            $response = array();
            $product = array();
            $event_exist = 0;
            $d = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $colorcode = '';
            $response["success"] = 1;
            $response["output"] = array();
            for ($i = 1; $i <= $d; $i++) {
                $date_src = $year . '-' . $month . '-' . $i;
                $date_src = date('Y-m-d', strtotime($date_src));

                $iteam = $this->Events->find('all')->where(['Events.eventt !=' => '13', 'DATE(starttime) <=' => $date_src, 'DATE(endtime) >= ' => $date_src])->contain(['Eventtypes'])->first();

                if (!empty($iteam)) {
                    $event_exist = 1;
                    $id = $iteam['id'];
                    $title = $iteam['title'];
                    $desc = $iteam['detail'];
                    $starttime = date('Y-m-d', strtotime($date_src));
                    $endtime = date('Y-m-d', strtotime($date_src));
                    $colorcode = $iteam['eventtype']['colorcode'];
                    $eventypename = $iteam['eventtype']['name'];

                    $product["id"] = $id;
                    $product["title"] = $title;
                    $product["description"] = $desc;
                    $product["event_type"] = $eventypename;
                    $product["start"] = $starttime;
                    $product["end"] = $endtime;
                    $product["color"] = $colorcode;
                    array_push($response["output"], $product);
                }
            }

            //$event=$this->Events->find('all')->contain(['Eventtypes'])->toArray();
            if ($event_exist == 0) {
                $response["success"] = 1;
                $response["output"] = array();
                $response['message'] = "No Events in this Month";
            }

            echo json_encode($response);
        }
    }

    /*************************************************************this api show event type in student side app****************************************/
    public function eventtype()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $idsprimeID = $postData->idsprimeID;
            if (empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            //head branch database connections
            $db_name = explode("_", $idsprimeID);
            if ($db_name[0] == "canvas") {
                $this->db($db_name[0]);
            } else {
                $this->db($idsprimeID);
            }
            $response = array();
            $product = array();
            //    $event=$this->Events->find('all')->where(['Events.eventt NOT IN'=>array('8','10')])->contain(['Eventtypes'])->toArray();
            //$events=$this->Eventtypes->find('all')->toArray();
            $events = $this->Eventtypes->find('all')->where(['Eventtypes.id !=' => '13'])->toArray();
            $response["success"] = 1;
            $response["output"] = array();
            foreach ($events as $key => $iteam) {

                $product["id"] = $iteam['id'];
                $product["name"] = $iteam['name'];
                $product["colorcode"] = $iteam['colorcode'];
                array_push($response["output"], $product);
            }
            echo json_encode($response);
        }
    }
    /*************************************************************this api is used for notifiations****************************************/

    public function notifications()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $userid = $postData->userId;
            $type = $postData->login_type;
            $idsprimeID = $postData->idsprimeID;
            if (empty($idsprimeID) || empty($userid) || empty($type)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);

            $mon = date('m');
            $year = date('Y');
            $this->loadModel('Smsdeliverydetails');
            $this->loadModel('Employees');
            $this->loadModel('Students');
            $this->loadModel('Notication');

            if ($type == "Teacher") {
                $sms_del = $this->Smsdeliverydetails->find('all')->select(['Smsdeliverydetails.created', 'Smsdelivery.message'])->where(['Smsdeliverydetails.stud_id' => $userid, 'Smsdeliverydetails.type' => 'E', 'MONTH(Smsdeliverydetails.created)' => $mon, 'YEAR(Smsdeliverydetails.created)' => $year])->contain(['Smsdelivery'])->order(['Smsdeliverydetails.id' => 'DESC'])->toarray();

                //sanjay code 
                $sms_notification = $this->Notication->find('all')->where(['type' => $type, 'MONTH(Notication.create_date)' => $mon, 'YEAR(Notication.create_date)' => $year])->order(['id' => 'DESC'])->toarray();
            } else if ($type == "Student") {
                $sms_del = $this->Smsdeliverydetails->find('all')->select(['Smsdeliverydetails.created', 'Smsdelivery.message'])->where(['Smsdeliverydetails.stud_id' => $userid, 'Smsdeliverydetails.type' => 'S', 'MONTH(Smsdeliverydetails.created)' => $mon, 'YEAR(Smsdeliverydetails.created)' => $year])->contain(['Smsdelivery'])->order(['Smsdeliverydetails.id' => 'DESC'])->toarray();
            } else if ($type == "Admin") {

                $sms_del = $this->Smsdelivery->find('all')->where(['MONTH(Smsdelivery.created)' => $mon, 'YEAR(Smsdelivery.created)' => $year])->order(['id' => 'DESC'])->toarray();
            }
            if ($type == "Admin") {
                $sms_notification = $this->Notication->find('all')->where(['MONTH(Notication.create_date)' => $mon, 'YEAR(Notication.create_date)' => $year])->order(['id' => 'DESC'])->toarray();
            } else {
                //27-04-2023
                $stExists = $this->Students->find('all')->where(['Students.id' => $userid, 'Students.status' => 'Y'])->first();
                if (!empty($stExists)) {
                    $classId = $stExists['class_id'];
                    $sectionId = $stExists['section_id'];

                    $sms_notification = $this->Notication->find('all')->where(['type' => $type, 'MONTH(Notication.create_date)' => $mon, 'YEAR(Notication.create_date)' => $year, 'class_id' => $classId, 'section_id' => $sectionId])->order(['id' => 'DESC'])->toarray();
                }
            }

            $response['success'] = 1;
            $notification_data = '';
            $smsdelivery_data = '';
            foreach ($sms_notification as $notificadata) {
                // $noti_data = array();
                $noti_data['message'] = $notificadata['message'];
                $noti_data['sendto'] = $notificadata['type'];
                $noti_data['messageDate'] = date('d-m-Y', strtotime($notificadata['create_date']));

                $expload_image = explode(',', $notificadata['image']);
                $image_view = [];
                foreach ($expload_image as $val) {
                    $image_view[] =  SITE_URL . $idsprimeID . "_image/" . $val;
                }
                if ($notificadata['image']) {

                    $noti_data['image'] = $image_view;
                } else {

                    $noti_data['image'] = null;
                }
                $notification_data[] = $noti_data;
            }

            foreach ($sms_del as $value) {

                $sms_data['message'] = $value['message'];
                $sms_data['messageDate'] = date('d-m-Y', strtotime($value['created']));
                $smsdelivery_data[] = $sms_data;
            }

            if ($smsdelivery_data) {
                array_push($notification_data, $smsdelivery_data);
            } else {
                $notification_data = $notification_data;
            }

            if ($notification_data || $smsdelivery_data) {
                $response['output'] = $notification_data;
            } else {
                $response['success'] = 0;
                $response['message'] = "No Notifications Available";
            }
            //pr($response);
            echo json_encode($response);
            die;
        }
    }
    /*****************************************this api is used for photo Gallery****************************************/

    public function photoGallery()
    {

        $idsprimeID = $this->request->data['idsprimeID'];
        $roleId = $this->request->data['roleId'];
        $userId = $this->request->data['userId'];

        $this->db($idsprimeID);
        $this->loadModel('Gallery');
        $this->loadModel('Gallerydetails');
        $this->loadModel('Students');
        $this->autoRender = false;
        $response = array();

        if ($roleId == 'STUDENT') {
            $stExists = $this->Students->find('all')->where(['Students.id' => $userId, 'Students.status' => 'Y'])->first();


            if (!empty($stExists)) {
                $classId = $stExists['class_id'];
                $sectionId = $stExists['section_id'];

                $gallery = $this->Gallery->find('all')->where(['Gallery.class_id' => $classId, 'Gallery.section_id' => $sectionId])->order(['Gallery.id' => 'desc'])->toarray();

                if (empty($gallery)) {
                    $gallery = $this->Gallery->find('all')->where(['Gallery.class_id' => '0'])->order(['Gallery.id' => 'desc'])->toarray();
                }

                foreach ($gallery as $value) {
                    $data['id'] = $value['id'];
                    $data['name'] = ucwords(strtolower($value['name']));
                    $gallery_details = $this->Gallerydetails->find('all')->where(['Gallerydetails.gallerydetails_group_images' => $value['group_images']])->order(['Gallerydetails.id' => 'DESC'])->toarray();


                    $images_data = array();
                    foreach ($gallery_details as $value_details) {

                        $image_data['image'] =  SITE_URL . "images/gallery/" . $idsprimeID . "_image/" . $value_details['image'];



                        $image_data['caption'] =  null;
                        $images_data[] = $image_data;
                    }

                    $data['images'] = $images_data;
                    $gallery_data[] = $data;
                }

                $response['success'] = true;
                $response['gallery'] = $gallery_data;
            }
        } else {
            // $gallery = $this->Gallery->find('all')->where(['Gallery.status' => 'Y'])->order(['Gallery.id' => 'DESC'])->toarray();

            $gallery = $this->Gallery->find('all')->group('Gallery.group_images')->contain(['Gallerydetails'])->where(['Gallery.status' => 'Y'])->order(['Gallery.id' => 'desc'])->toarray();

            foreach ($gallery as $value) {
                $data['id'] = $value['id'];
                $data['name'] =  ucwords(strtolower($value['name']));
                $gallery_details = $this->Gallerydetails->find('all')->where(['Gallerydetails.gallerydetails_group_images' => $value['group_images']])->order(['Gallerydetails.id' => 'DESC'])->toarray();


                $images_data = array();
                foreach ($gallery_details as $value_details) {

                    $image_data['image'] =  SITE_URL . "images/gallery/" . $idsprimeID . "_image/" . $value_details['image'];
                    $image_data['caption'] =  null;
                    $images_data[] = $image_data;
                }

                $data['images'] = $images_data;
                $gallery_data[] = $data;
            }

            $response['success'] = true;
            $response['gallery'] = $gallery_data;
        }

        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
        die;
    }

    public function firebaseNotification()
    {
        $this->autoRender = false;
        require_once 'Firebase.php';
        require_once 'Push.php';

        $postData  = $this->request->data();

        $userid = $postData['userId'];
        $roleId = $postData['roleId']; //Student ,Teacher , Both
        $message = $postData['message'];
        $idsprimeID = $postData['idsprimeID'];

        $image = $postData['image'];


        if (empty($userid) || empty($idsprimeID) || empty($message) || empty($roleId)) {

            $response["success"] = 0;
            $response["message"] = "Invalid Parameter";
            echo json_encode($response);
            return;
        }

        $this->db($idsprimeID);
        $this->loadModel('Notification');
        if ($this->request->is('post')) {

            if ($roleId == "Student") {

                $this->loadModel('Students');
                $devicetoken =   $this->getAllTokens($roleId);
            } else if ($roleId == "Teacher") {
                $devicetoken =   $this->getAllTokens($roleId);
                $roleId = 'Staff';
            } else {
                $devicetoken =   $this->getAllTokens($roleId);
                $roleId = 'Both';
            }


            $image  = $this->request->data['image'];
            $data['image'] = SITE_URL .  'images/idsprimelogo.png';
            // $data['image'] = 'https://www.idsprime.com/images/idsprimelogo.png';


            $new = $this->Notification->newEntity();
            $notification_data['type'] = $roleId;
            $notification_data['message'] = $message;

            if ($image) {
                foreach ($image  as $val) {
                    $imagefilename = $val['name'];
                    $imagefiletype = $val['type'];
                    $item = $val['tmp_name'];
                    $ext =  end(explode('.', $imagefilename));
                    $name = md5(uniqid($filename));
                    $imagename = $name . '.' . $ext;
                    $path  = '/var/www/html/idsprime/webroot/' . $idsprimeID . "_image/" . $imagename;

                    if (move_uploaded_file($item, $path)) {
                        $image  =  $imagename;
                        $image_array[] = $image;
                        $impload_image = implode(',', $image_array);
                    }
                }
                $notification_data['image'] = $impload_image;
            }

            $notification_update = $this->Notification->patchEntity($new, $notification_data);

            $result = $this->Notification->save($notification_update);

            $image_expload = explode(',', $result['image']);

            $first_image  = SITE_URL . $idsprimeID . "_image/" . $image_expload[0];

            $push = new \Push(
                $idsprimeID,
                $message,
                $first_image,
                1
            );

            $firebase = new \Firebase();
            $mPushNotification = $push->getPush();

            $test = $firebase->send($devicetoken, $mPushNotification, $data);
            $response["success"] = 1;
            $response["message"] = "Notification Sent";
            echo json_encode($response);
            return;
        }
    }

    /******************************************************** Basic  API's End *********************************************/

    /************************************************************************************
     ******************Student Api's Start***********************************************/
    /*
1. passwordLogin
2. slider
3. getStudentInfo
4. getNotificationCount
5. studentAttendance
6. singleStudentFees
7. classTimeTable
8. fetchassignmentsstudents
9. resultsearch //exam
10. library
11. bookRequest
11. booksCategories
12. booksearch
13. bookRequestList
14. viewevents
15. eventtype
16. datesheet
17. notifications/ firebaseNotification
18. gatepass
19. viewgatepass
20. feedback
21. viewfeedback
22. feedbackcategories
23. photoGallery
24. receipt
25. changePasswordNew
26. updateEmail 
27. changePassword
*/


    /*****************************************************  Get Student Information in app **********************************************************/

    public function updateEmail()
    {
        $response = array();
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $id = $postData->id;
            $email = $postData->email;
            $idsprimeID = $postData->idsprimeID;
            if (empty($email) || empty($idsprimeID) || empty($id)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);

            if (!empty($id) && !empty($email)) {
                $stu = $this->Students->get($id);
                $students = $this->Students->find('all')->where(['Students.status' => 'Y', 'Students.sms_mobile' => $stu['sms_mobile']])->toarray();
                foreach ($students as $student) {
                    $stu_det = $this->Students->get($student['id']);
                    $data['username'] = $email;
                    $patch = $this->Students->patchEntity($stu_det, $data);
                    $this->Students->save($patch);
                }
                $response['success'] = 1;
                $response['message'] = "Email updated Successfully";
                echo json_encode($response);
            } else {
                $response["message"] = "Invalid Post parameters.";
                echo json_encode($response);
            }
        }
    }


    public function changePasswordNew()
    {
        $this->autoRender = false;

        $mobile = $this->request->data['mobileno'];
        $login_type = $this->request->data['login_type'];
        $password =  $this->request->data['password'];
        $new_password =   $this->request->data['newPassword'];
        $idsprimeID  =   $this->request->data['idsprimeID'];
        $this->db($idsprimeID);
        if ($login_type == "STUDENT") {
            $role_id = "2";
        } else if ($login_type == "ADMIN") {
            $role_id = "1";
        } else {
            $role_id = "3";
        }
        $user_details = $this->Users->find('all')->where(['mobile' => $mobile, 'role_id' => $role_id])->first();
        if ($user_details) {

            $hasher = new DefaultPasswordHasher();
            $newpassword = $hasher->hash($password);


            $conn = ConnectionManager::get('default');
            $detail = 'UPDATE `users` SET `password` ="' . $newpassword . '",`confirm_pass` ="' . $password . '" WHERE `mobile` = "' . $mobile . '" and `role_id` = "' . $role_id . '"';
            $conn->execute($detail);
            $newidsprimeID = "school_erp";

            $this->db($newidsprimeID);
            $conn = ConnectionManager::get('default');
            $detail = 'UPDATE `users` SET `password` ="' . $newpassword . '",`confirm_pass` ="' . $password . '" WHERE `mobile` = "' . $mobile . '" and `role_id` = "' . $role_id . '"';
            $conn->execute($detail);

            $response["success"] = 1;
            $response["message"] = "Password changed successfully";
            echo json_encode($response);
        } else {
            $response["success"] = 0;
            $response["message"] = "Not a registered employee";
            echo json_encode($response);
        }
    }

    public function changePassword()
    {
        $this->autoRender = false;
        $response = array();
        if (isset($_POST) && !empty($_POST)) {
            $student_id = $_POST["id"];

            $password = $_POST["newPassword"];

            $student = $this->Students->find('all')->where(['Students.id' => $student_id, 'Students.status' => 'Y'])->first();


            $mobile = "8233172526";
            $hasher = new DefaultPasswordHasher();
            $newpassword = $hasher->hash($password);
            //$oldhashpass = $hasher->hash($oldPass);
            $board_id = $student['board_id'];
            $enroll = $student['enroll'];
            if ($board_id == '1') {
                $enroll = "C" . $enroll;
            } else if ($board_id == '2') {
                $enroll = "CAM" . $enroll;
            } else if ($board_id == '3') {
                $enroll = "IB" . $enroll;
            }
            $this->request->data['email'] = $enroll;
            $this->request->data['password'] = $_POST["password"];
            $exist = $this->Auth->identify($this->request->data);

            if ($exist) {
                $email = $this->Users->find('all')->where(['email' => $enroll, 'role_id' => '2'])->toarray();

                if (!empty($email)) {
                    $conn = ConnectionManager::get('default');
                    $detail = 'UPDATE `users` SET `password` ="' . $newpassword . '",`confirm_pass` ="' . $password . '" WHERE `email` = "' . $enroll . '"';
                    $conn->execute($detail);
                    $mesg = "Thanks for Register on School Erp.Your New Password is " . $password . " Call :9829732221 for Support";
                    $result = $this->file_get_contents_curl('http://alerts.prioritysms.com/api/web2sms.php?workingkey=Afb7ede974e22367003ac66f8514bd152&to=' . $mobile . '&sender=SNSKAR&message=' . urlencode($mesg));
                    $response["success"] = 1;
                    echo json_encode($response);
                } else {

                    $response["success"] = 0;
                    $response["message"] = "You Are Not A Registered Student";
                    echo json_encode($response);
                }
            } else {
                $response["success"] = 0;
                $response["message"] = "Wrong Existing Password";
                echo json_encode($response);
            }
        } else {
            $response["message"] = "No Value Assign in Post";
            echo json_encode($response);
        }
    }

    public function updateToken()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $jsonData = $this->request->input('json_decode');
            $postData = $this->dPayload($jsonData);
            $roll = $postData->roll;
            $student_id = $postData->enroll;
            $token = $postData->token;
            $idsprimeID = $postData->idsprimeID;
            if (empty($roll) || empty($student_id) || empty($token) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $response = array();
            if ($roll == "Student") {

                $enroll = ltrim($student_id, 'S');
                $detail = 'UPDATE `students` SET `token` ="' . $token . '" WHERE `id` = "' . $enroll . '"';
                $conn = ConnectionManager::get('default');
                $conn->execute($detail);
                $response["success"] = 1;
            } else if ($roll == "Teacher") {
                $this->Employees->query("update employee set token='" . $token . "' where email=" . $student_id);
                $response["success"] = 1;
            } else {
                $response["success"] = 0;
            }
            echo json_encode($response);
        }
    }


    public function receipt()
    {
        $this->loadmodel('Banks');
        $response = array();
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $jsonData = $this->request->input('json_decode');
            $postData = $this->dPayload($jsonData);
            $str = $postData->id;
            $idsprimeID = $postData->idsprimeID;
            if (empty($str) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $student = $this->Students->find('all')->where(['Students.id' => $str, 'Students.status' => 'Y'])->first();
            $acedamicyeard = $student['acedmicyear'];
            $student_datas = $this->Studentfees->find('all')->where(['Studentfees.student_id' => $student['id'], 'Studentfees.acedmicyear' => $acedamicyeard, 'Studentfees.status' => 'Y'])->toarray();

            $fees = $student_datas[0]['fee'];
            if (!empty($fees) && isset($fees)) {
                $response["success"] = 1;
                $response["output"] = array();
                $quas = array();
                foreach ($student_datas as $value) {

                    if ($value['recipetno'] != '0') {

                        $product["receipt_no"] = $value['recipetno'];

                        $product["paydate"] = date('d-m-Y', strtotime($value['paydate']));
                        $quas = unserialize($value['quarter']);
                        $quter = array();

                        $muy = 0;
                        foreach ($quas as $iteam['quarter'] => $iteam['amount']) {
                            if ($iteam['quarter'] == 'Quater1') {

                                $muy++;
                                $quter[] = "First Quarter(April-June)" . ": Paid";
                            } else if ($iteam['quarter'] == 'Quater2') {

                                $muy++;
                                $quter[] = "Second Quarter (July-Sept)" . ": Paid";
                            } else if ($iteam['quarter'] == 'Quater3') {

                                $muy++;
                                $quter[] = "Third Quarter  (Oct-Dec)" . ": Paid";
                            } else if ($iteam['quarter'] == 'Quater4') {
                                $muy++;
                                $quter[] = "Fourth Quarter  (Jan-March)" . ": Paid";
                            } else if ($iteam['quarter'] == 'Admission Fee') {
                                $muy++;
                                $quter[] = "Admission Fee" . ": Paid";
                            } else if ($iteam['quarter'] == 'Development Fee') {
                                $muy++;
                                $quter[] = "Development Fee" . ": Paid";
                            } else if ($iteam['quarter'] == 'Development Fee') {
                                $muy++;
                                $quter[] = "Development Fee" . ": Paid";
                            } else if ($iteam['quarter'] == 'Caution Money') {
                                $muy++;
                                $quter[] = "Caution Money" . ": Paid";
                            } else if ($iteam['quarter'] == 'Miscellaneous Fee') {
                                $muy++;
                                $quter[] = "Miscellaneous Fee" . ": Paid";
                            }
                        }

                        $product["description"] = implode(", ", $quter);
                        $product["fee"] = number_format($value['deposite_amt'], 0, ',', '');

                        $product["mode"] = $value['mode'];

                        if ($value['cheque_no'] != '0') {

                            $product["cheque_no"] = $value['cheque_no'];
                        } else {

                            $product["cheque_no"] = null;
                        }

                        if ($value['bank'] != '') {

                            $product["bank"] = $value['bank'];
                        } else {
                            $product["bank"] = null;
                        }
                        array_push($response["output"], $product);
                    }
                }
                echo json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "You have not submitted any fees";
                echo json_encode($response);
            }
        }
    }



    public function getStudentInfo()
    {

        $this->loadmodel('Users');
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $ids = $postData->id;
            $idsprimeID = $postData->idsprimeID;

            if (empty($ids) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                die;
            }
            $this->db($idsprimeID);

            $id = explode(',', $postData->id);

            $response["success"] = 1;
            $response["students"] = array();
            foreach ($id as $s_id) {

                $student = $this->Students->find('all')->where(['Students.id' => $s_id, 'Students.status' => 'Y'])->first();

                $section_id = $this->findsections($student['section_id']);
                $class_id = $this->findclass($student['class_id']);
                $teacher = $this->findclasstecher($student['class_id'], $student['section_id']);

                if (!empty($student['fathername'])) {
                    $fatername = ucwords(strtolower($student['fathername']));
                }

                $current_address = $student['address'];
                $p_address = $student['address'];

                $city_name = "Jaipur";

                $state_name = "Rajasthan";

                $country_name = "India";

                $p_city_name = "Jaipur";

                $p_state = "Rajasthan";

                $p_country = "India";
                $product["id"] = $student['id'];
                $product["fname"] = ucwords(strtolower($student['fname']));
                $product["middlename"] = ucwords(strtolower($student['middlename']));
                $product["lname"] = ucwords(strtolower($student['lname']));
                $product["email"] = $student['username'];
                if ($student['dob'] == "01-01-1970") {
                    $product["dob"] = " ";
                } else {
                    $product["dob"] = date('d-m-Y', strtotime($student['dob']));
                }

                $product["gender"] = $student['gender'];
                $product["admission_no"] = $student['formno'];
                $product["roll_no"] = $student['enroll'];

                if ($student['board_id'] == '1') {
                    $bordds = "C";
                } else if ($student['board_id'] == '2') {
                    $bordds = "CAM";
                } else if ($student['board_id'] == '3') {

                    $bordds = "IB";
                }

                $product["enroll_no"] = $bordds . $student['enroll'];
                $product["class_id"] = $student['class_id'];
                $product["section_id"] = $student['section_id'];
                $product["mobile"] = $student['sms_mobile'];
                $product["class"] = $class_id['title'];
                $product["stclass"] = $class_id['title'];
                $product["section"] = $section_id['title'];
                $product["teacher_name"] = ucwords(strtolower($teacher[0]['employee']['fname'])) . " " . ucwords(strtolower($teacher[0]['employee']['lname']));
                $product["acedamicyear"] = $student['acedmicyear'];
                $product["current_address"] = ucwords(strtolower($student['address']));
                $product["current_city"] = ucwords(strtolower($student['city']));
                $product["current_state"] = $state_name;
                $product["current_country"] = $country_name;
                $product["current_address_pincode"] = $address['c_pincode'];
                $product["permanant_address"] = $p_address;
                $product["permanant_city"] = $p_city_name;
                $product["permanant_state"] = $p_state;
                $product["permanant_country"] = $p_country;
                $product["permanant_address_pincode"] = $address['p_pincode'];
                $product["fathername"] = $fatername;
                $product["mothername"] = ucwords(strtolower($student['mothername']));
                $product["guardian_mobileno"] = $guardian['mobileno'];
                if ($student['board_id'] == '1') {
                    $bordd = "";
                } else if ($student['board_id'] == '2') {
                    $bordd = "CAM";
                } else if ($student['board_id'] == '3') {

                    $bordd = "IB";
                }

                if ($student['file']) {
                    // $product["image"] = 'http://sanskar.idsprime.com/webroot/stu/' . $bordd . $student['enroll'] . '.JPG';


                    $bordd = "";
                    $directory = SITE_URL . $idsprimeID . '_image/student/' . $bordd . $student['file'];

                    $product["image"] = $directory;
                } else {
                    $product["image"] = null;
                }
                array_push($response["students"], $product);
            }

            echo json_encode($response, JSON_UNESCAPED_SLASHES);
        }
    }




    /**********************************************Show student attendance in app student side  ********************************************************/

    public function studentAttendance()
    {
        //$this->db($idsprimeID);
        $idsprimeID = $this->request->data['idsprimeID'];
        $response = array();
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $studentId = $postData->studentId;
            $period = $postData->date;
            $idsprimeID = $postData->idsprimeID;
            if (empty($studentId) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            // pr($this->request->data);die;
            if (empty($period)) {
                $period = date('Y-m');
            }

            $expDate = explode('-', $period);
            $month = $expDate[1];
            $year = $expDate[0];
            $currentSessionDate = "";
            if ($month >= 04) {
                $year1 = $year + 1;
                $academicYear = $year . "-" . substr($year1, 2, 3);
                $currentSessionDate = $year . "-04-01";
            } else {
                $year1 = $year - 1;
                $academicYear = $year1 . "-" . substr($year, 2, 3);
                $currentSessionDate = $year1 . "-04-01";
            }

            $studentDetail = $this->Students->find('all')->where(['id' => $studentId, 'acedmicyear' => $academicYear])->first();
            //  print_r($academicYear);die;
            // $stu_created = date("Y-m-d",$studentDetail['created']);
            $stu_created = date('Y-m-d', strtotime($studentDetail['created']));

            if (!empty($studentDetail['fname'])) {
                $expDiff = explode('-', $academicYear);
                $earlierYear = $expDiff[0];
                //$earlier = date('Y-m-d', strtotime($earlierYear . "-04-01"));
                $earlier = date_create($earlierYear . "-04-01");
                $laterYear = date('Y-m-d');
                //$later = date('Y-m-d', strtotime($laterYear . "-03-31"));
                $later = date_create($laterYear);
                $diff = date_diff($earlier, $later);
                $years['totalDays'] = (int) $diff->format("%a");
                //pr($years['totalDays']); die;
                $years['workingDays'] = $this->Studattends->find('all')->where(['class_id' => $studentDetail['class_id'], 'section_id' => $studentDetail['section_id'], 'acedemic' => $academicYear])->group(['date'])->count();
                //pr($yearTotalDays);
                $years['present'] = $this->Studattends->find('all')->where(['stud_id' => $studentId, 'status' => 'P', 'acedemic' => $academicYear])->count();
                //pr($yearPresent);
                $years['absent'] = $this->Studattends->find('all')->where(['stud_id' => $studentId, 'status' => 'A', 'acedemic' => $academicYear])->count();

                //pr($yearAbsent);
                $dateRange = $this->Studattends->find('all')->select(['date'])->where(['class_id' => $studentDetail['class_id'], 'section_id' => $studentDetail['section_id'], 'MONTH(date)' => $month, 'acedemic' => $academicYear, 'stud_id' => $studentId])->group(['date'])->toarray();
                //print_r($dateRange); die;

                $daysMon = date('d');
                $currMon = date('m');
                if ($month != $currMon) {
                    $mon['totalDays'] = (int) cal_days_in_month(CAL_GREGORIAN, $month, $year);
                } else {
                    $mon['totalDays'] = (int) date('d');
                }
                $mon['workingDays'] = count($dateRange);

                //pr($monTotalDays);
                $mon['present'] = $this->Studattends->find('all')->where(['stud_id' => $studentId, 'status' => 'P', 'MONTH(date)' => $month, 'acedemic' => $academicYear])->count();
                // pr($monPresent);
                $mon['absent'] = $this->Studattends->find('all')->where(['stud_id' => $studentId, 'status' => 'A', 'MONTH(date)' => $month, 'acedemic' => $academicYear])->count();


                //$mon['holidays'] = $mon['totalDays'] - $mon['workingDays'];

                $year_hol = 0;
                $e_start = date('Y-m-d', strtotime($currentSessionDate));
                for ($k = 1; $k <= $years['totalDays']; $k++) {
                    $event = $this->Events->exists(['Events.eventt' => '8', 'DATE(starttime) <=' => $e_start, 'DATE(endtime) >=' => $e_start]);
                    if ($event == 1) {
                        $year_hol++;
                    }

                    $e_start = date('Y-m-d', strtotime("+1 day", strtotime($e_start)));
                }
                $years['holidays'] = $year_hol;

                $status = array();
                $presentstatus = array();
                $absentstatus = array();

                foreach ($dateRange as $values) {
                    $date = date('Y-m-d', strtotime($values['date']));


                    $studentStatus = $this->Studattends->find('all')->select(['status'])->where(['stud_id' => $studentId, 'DATE(date)' => $date, 'acedemic' => $academicYear])->first();
                    if ($studentStatus['status'] == 'P') {
                        $presentstatus[] = $date;
                    } else {
                        $absentstatus[] = $date;
                    }
                    $date1 = date('d-m-Y', strtotime($date));
                    $status[$date1] = $studentStatus['status'];
                }
                $t_days = (int) cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $holiday = array();
                $mon_hol = 0;
                for ($e = 1; $e <= $t_days; $e++) {
                    $e_days = $year . '-' . $month . '-' . $e;
                    $e_date = date('Y-m-d', strtotime($e_days));
                    //pr($e_date);
                    $event = $this->Events->exists(['Events.eventt' => '8', 'DATE(starttime) <=' => $e_date, 'DATE(endtime) >=' => $e_date]);
                    if ($event == 1) {
                        $holiday[] = $e_date;
                        $mon_hol++;
                    }
                }

                $mon['holidays'] = $mon_hol;
                //$event = $this->Events->find('all')->where(['Events.eventt' => '8', 'MONTH(starttime)'])->toarray();

                $output['P'] = $presentstatus;
                $output['A'] = $absentstatus;
                $output['month'] = $mon;
                $output['year'] = $years;

                $response['success'] = 1;
                $response['holidays'] = $holiday;
                $response['attendanceStatus'] = $output;
                $response['currentDate'] = date('Y-m-d');
                $response['sessionStartDate'] = $currentSessionDate;
                $response['stucreated'] = $stu_created;





                // $response['yearTotalDays'] = $yearTotalDays;
                // $response['yearHolidays'] = $yearHolidays;
                // $response['yearWorkingDays'] = $yearWoDays;
                // $response['yearPresent'] = $yearPresent;
                // $response['yearAbsent'] = $yearAbsent;
                // $response['monTotalDays'] = $daysMon1;
                // $response['monHolidays'] = $monHolidays;
                // $response['monWorkingDays'] = $monWoDays;
                // $response['monPresent'] = $monPresent;
                // $response['monAbsent'] = $monAbsent;
                echo json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "You are Not Registered";
                echo json_encode($response);
            }
        }
    }

    /******************************************************Show student fees in the app student side*************************************************/

    public function singleStudentFees()
    {

        $response = array();
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $jsonData = $this->request->input('json_decode');
            $postData = $this->dPayload($jsonData);
            $str = $postData->id;
            $idsprimeID = $postData->idsprimeID;
            if (empty($str) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $conn = ConnectionManager::get('default');

            $student = $this->Students->find('all')->where(['Students.id' => $str, 'Students.status' => 'Y'])->first();
            if ($student['category'] == 'RTE') {

                $response["success"] = 0;
                $response["output"] = null;
                $response["message"] = "You are RTE student in our Record.";
                echo json_encode($response);
                die;
            }
            $acedamicyear = $student["acedmicyear"];
            $class_id = $student["class_id"];


            $fees = $this->Studentfees->find('all')->select(['id', 'deposite_amt', 'fee', 'discount', 'quarter', 'recipetno', 'discountcategory', 'paydate'])->where(['Studentfees.student_id' => $student['id'], 'Studentfees.acedmicyear' => $acedamicyear, 'Studentfees.status' => 'Y'])->toArray();

            $paidfeestotal = 0;

            $discount = 0;
            foreach ($fees as $values) {
                $quater[] = unserialize($values['quarter']);
                $discount += $values['discount'];
                if ($values['recipetno'] != '0') {

                    $deposit += $values['deposite_amt'];
                }
                $fees = $this->Studentfeepending->find('all')->select(['amt'])->where(['Studentfeepending.r_id' => $values['id'], 'Studentfeepending.status' => 'N'])->first();
                $pendingamt += $fees['amt'];
            }

            $asd = array();
            foreach ($quater as $j => $l) {

                $asd += $l;
            }

            foreach ($asd as $j => $yu) {
                $paidfeestotals += $yu;
            }

            $paidfeestotal = $deposit;

            $amount = $this->findamount($class_id, $acedamicyear);
            $amount2 = $this->findamount($class_id, $acedamicyear);

            $newarray = array();

            foreach ($quater as $key => $value) {
                if ($value == 'Quater1') {
                    $newarray[] = 'qu1_fees';
                } else if ($value == 'Quater2') {
                    $newarray[] = 'qu2_fees';
                } else if ($value == 'Quater3') {
                    $newarray[] = 'qu3_fees';
                } else if ($value == 'Quater4') {
                    $newarray[] = 'qu4_fees';
                }
            }

            foreach ($newarray as $key => $iteam) {
                if (!in_array($iteam, $amount2[0])) {
                    $amount2[0][$iteam] = '';
                }
            }

            $findamount4month = $this->findamount4month($class_id, $acedamicyear);
            $findamount3month = $this->findamount3month($class_id, $acedamicyear);
            $findamount2month = $this->findamount2month($class_id, $acedamicyear);
            $findamount1month = $this->findamount1month($class_id, $acedamicyear);

            $student = $this->Students->find('all')->where(['Students.id' => $str, 'Students.status' => 'Y'])->first();
            $disfees = $student['dis_fees'];

            $findamount1month['qu1_fees'] = $findamount1month['qu1_fees'];

            $total_class_fees = ($amount[0]['qu1_fees'] + $amount[0]['qu2_fees'] + $amount[0]['qu3_fees'] + $amount[0]['qu4_fees']);

            // echo  $total_class_fees; die;

            $findsum = $findamount4month['qu4_fees'] + $findamount3month['qu3_fees'] + $findamount2month['qu2_fees'] + $findamount1month['qu1_fees'];

            if ($findsum > $paidfeestotals) {
                $total_due = $total_class_fees - $paidfeestotals;
            } else {
                $total_due = 0;
            }
            if ($findsum > $paidfeestotals) {
                $dueamt = $findsum - $paidfeestotals;
            } else {
                $dueamt = 0;
            }

            $output["success"] = 1;
            //$response["output"] = array();

            $product["discount"] = number_format($discount, 0, ',', '');
            //$dueamt= $dueamt-$discount;
            //$product["due_amount"]=number_format($dueamt,0,',','');
            $product["pending_fee"] = number_format($pendingamt, 0, ',', '');
            //$total_due=$total_due-$discount;

            //array_push($response["output"], $product);
            $response["totalfees"] = array();

            $t = array();
            $response["outstanding"] = array();
            //$response["outstanding"]= $total_due;
            $s = array();
            $response["duefee"] = array();

            if ($id > '5974' && $student['board_id'] == '1') {

                //  $quaterd[]="Admission Fee";
                $quaterd[] = "Development Fee";
                $quaterd[] = "Caution Money";
            } else {

                // $quaterd[]="Admission Fee";
                $quaterd[] = "Development Fee";
                $quaterd[] = "Caution Money";
            }

            if ($findamount1month['qu1_fees']) {
                $quaterd[] = "Miscellaneous Fee";
                $quaterd[] = "Quater1";
            }

            if ($findamount2month['qu2_fees']) {

                $quaterd[] = "Quater2";
            }

            if ($findamount3month['qu3_fees']) {

                $quaterd[] = "Quater3";
            }

            if ($findamount4month['qu4_fees']) {

                $quaterd[] = "Quater4";
            }

            if ($id > '5974' && $student['board_id'] == '1') {
                // $quateroutstand[]="Admission Fee";
                $quateroutstand[] = "Development Fee";
                $quateroutstand[] = "Caution Money";
            } else {

                //$quateroutstand[]="Admission Fee";
                $quateroutstand[] = "Development Fee";
                $quateroutstand[] = "Caution Money";
            }
            $quateroutstand[] = "Miscellaneous Fee";
            $quateroutstand[] = "Quater1";
            $quateroutstand[] = "Quater2";
            $quateroutstand[] = "Quater3";
            $quateroutstand[] = "Quater4";

            $dueamts = 0;

            $studentfees = $this->finddisountstudent($student['id'], $acedamicyear);

            $studentfeeshistory = $this->finddisountstudenthistory($student['id']);

            $quas33 = array();
            $praticale = 0;
            if (
                $student['class_id'] == 12 || $student['class_id'] == 13
                || $student['class_id'] == 15 || $student['class_id'] == 17 ||
                $student['class_id'] == 20 || $student['class_id'] == 22 ||
                $student['class_id'] == 26 || $student['class_id'] == 27
            ) {

                $compsid = explode(',', $student['comp_sid']);
                $opt_sid = explode(',', $student['opt_sid']);
                foreach ($compsid as $k => $g) {

                    $subjectpracticals = $this->classspractical($g);
                    if ($subjectpracticals) {

                        $praticale += $subjectpracticals['is_practicalfee'];
                    }
                }

                foreach ($opt_sid as $ks => $gs) {

                    $subjectpracticalss = $this->classspractical($gs);
                    if ($subjectpracticalss) {

                        $praticale += $subjectpracticalss['is_practicalfee'];
                    }
                }
            }

            foreach ($studentfeeshistory as $ks => $values) {
                $quas33[] = unserialize($values['quarter']);
            }

            $quaf33 = array();

            foreach ($quas33 as $fhs => $vales) {

                $quaf33 = array_merge($quaf33, $vales);
            }
            $rt33 = array();
            foreach ($quaf33 as $js => $ts) {
                if ($js == "Admission Fee" || $js == "Development Fee" || $js == "Caution Money") {
                    $qua33[] = $js;
                }
            }

            // if (!in_array("Admission Fee", $qua33)) {

            // $response["success"] = 0;
            // $response["output"] = null;
            // $response["message"] = "Kindly Contact to Fee Adminstrator.";
            // echo json_encode($response);
            //     die;
            // }

            $quas = array();

            foreach ($studentfees as $k => $value) {
                $quas[] = unserialize($value['quarter']);
            }

            $quaf = array();

            foreach ($quas as $fh => $vale) {

                $quaf = array_merge($quaf, $vale);
            }

            $rt = array();
            foreach ($quaf as $j => $t) {
                if ($j != "Admission Fee" && $j != "Development Fee" && $j != "Caution Money") {
                    $qua[] = $j;
                }
            }

            $quahh = array();

            if (isset($qua)) {
                $quahh = array_merge($qua, $qua33);
            } else {
                $quahh = $qua33;
            }

            $h = array();

            foreach ($quaterd as $hj => $ty) {

                $dff = 0;

                if (!empty($quahh)) {

                    foreach ($quahh as $tj => $hy) {

                        if ($hy == $ty) {

                            $dff++;
                        } else {
                        }
                    }
                }

                if ($dff == '0') {

                    if ($ty == "Quater1") {

                        $tys = "Tution Fee";
                    } else if ($ty == "Quater2") {
                        $tys = "Tution Fee";
                    } else if ($ty == "Quater3") {

                        $tys = "Tution Fee";
                    } else if ($ty == "Quater4") {

                        $tys = "Tution Fee";
                    } else if ($ty == "Miscellaneous Fee") {

                        $tys = "Miscellaneous Fee";
                    } else if ($ty == "Development Fee") {

                        $tys = "Development Fee";
                    } else if ($ty == "Caution Money") {

                        $tys = "Caution Money";
                    }

                    $feeshead = $this->findfeeheadsid($tys);

                    $err = $this->findfeeheadsamount($student['class_id'], $acedamicyear, $feeshead['id']);

                    if ($ty == "Quater4") {
                        if (!in_array($ty, $quahh)) {
                            $qu_fee_name = "qu4_fees";
                            $final_fees = $this->CalculateDiscount($student['id'], $class_id, $acedamicyear, $qu_fee_name);

                            if ($praticale != 0) {
                                $newfinal = $final_fees + $praticale;
                                $h['description'] = "Tution Fee (Jan-March) :Practical Fee";
                                $date = "qu4_date";
                                $due_total += $newfinal;
                                $h['lastdate'] = date('d-m-Y', strtotime($findamount4month[$date]));
                                $h['fee'] = number_format($newfinal, 0, ',', '');
                                $dueamts += $h['fee'];
                            } else {

                                $h['description'] = "Tution Fee (Jan-March)";
                                $date = "qu4_date";
                                $due_total += $final_fees;
                                $h['lastdate'] = date('d-m-Y', strtotime($findamount4month[$date]));
                                $h['fee'] = number_format($final_fees, 0, ',', '');
                                $dueamts += $h['fee'];
                            }
                            array_push($response["duefee"], $h);
                        }
                    } else if ($ty == "Quater3") {

                        if (!in_array($ty, $quahh)) {
                            $qu_fee_name = "qu3_fees";
                            $final_fees = $this->CalculateDiscount($student['id'], $class_id, $acedamicyear, $qu_fee_name);
                            if ($praticale != 0) {
                                $newfinal = $final_fees + $praticale;
                                $h['description'] = "Tution Fee (Oct-Dec) :Practical Fee";
                                $date = "qu3_date";
                                $due_total += $newfinal;
                                $h['lastdate'] = date('d-m-Y', strtotime($findamount3month[$date]));
                                $h['fee'] = number_format($newfinal, 0, ',', '');
                                $dueamts += $h['fee'];
                            } else {

                                $h['description'] = "Tution Fee (Oct-Dec)";
                                $date = "qu3_date";
                                $h['lastdate'] = date('d-m-Y', strtotime($findamount3month[$date]));
                                $h['fee'] = number_format($final_fees, 0, ',', '');
                                $due_total += $final_fees;
                                $dueamts += $h['fee'];
                            }
                            array_push($response["duefee"], $h);
                        }
                    } else if ($ty == "Quater2") {
                        if (!in_array($ty, $quahh)) {
                            $qu_fee_name = "qu2_fees";
                            $final_fees = $this->CalculateDiscount($student['id'], $class_id, $acedamicyear, $qu_fee_name);
                            if ($praticale != 0) {
                                $newfinal = $final_fees + $praticale;
                                $h['description'] = "Tution Fee (July-Sept) :Practical Fee";
                                $date = "qu2_date";
                                $due_total += $newfinal;
                                $h['lastdate'] = date('d-m-Y', strtotime($findamount2month[$date]));
                                $h['fee'] = number_format($newfinal, 0, ',', '');
                                $dueamts += $h['fee'];
                            } else {

                                $h['description'] = "Tution Fee (July-Sept)";
                                $date = "qu2_date";
                                $h['lastdate'] = date('d-m-Y', strtotime($findamount2month[$date]));
                                $h['fee'] = number_format($final_fees, 0, ',', '');
                                $due_total += $final_fees;
                                $dueamts += $h['fee'];
                            }
                            array_push($response["duefee"], $h);
                        }
                    } elseif ($ty == "Quater1") {

                        if (!in_array($ty, $quahh)) {
                            $qu_fee_name = "qu1_fees";
                            $final_fees = $this->CalculateDiscount($student['id'], $class_id, $acedamicyear, $qu_fee_name);
                            if ($praticale != 0) {
                                $newfinal = $final_fees + $praticale;
                                $h['description'] = "Tution Fee (April-June) :Practical Fee";
                                $date = "qu1_date";
                                $due_total += $newfinal;
                                $h['lastdate'] = date('d-m-Y', strtotime($findamount1month[$date]));
                                $h['fee'] = number_format($newfinal, 0, ',', '');
                                $dueamts += $h['fee'];
                            } else {
                                $h['description'] = "Tution Fee (April-June)";
                                $date = "qu1_date";
                                $h['lastdate'] = date('d-m-Y', strtotime($findamount1month[$date]));
                                $h['fee'] = number_format($final_fees, 0, ',', '');
                                $due_total += $final_fees;
                                $dueamts += $h['fee'];
                            }
                            array_push($response["duefee"], $h);
                        }
                    } elseif ($ty == "Miscellaneous Fee") {

                        if (!in_array($ty, $quahh)) {
                            $h['description'] = "Miscellaneous Fee";
                            $date = "qu1_date";
                            $h['lastdate'] = date('d-m-Y', strtotime($findamount1month[$date]));

                            $feesheadmisc = $this->findfeeheadsid("Miscellaneous Fee");

                            $errmisg = $this->findfeeheadsamount($student['class_id'], $acedamicyear, $feesheadmisc['id']);

                            $h['fee'] = number_format($errmisg[0]['qu1_fees'], 0, ',', '');
                            $due_total += $errmisg[0]['qu1_fees'];
                            $dueamts += $h['fee'];
                            if ($h['fee'] != 0) {
                                array_push($response["duefee"], $h);
                            }
                        }
                    } elseif ($ty == "Caution Money") {
                        if (!in_array($ty, $quahh)) {
                            $h['description'] = "Caution Money";
                            $date = "qu1_date";
                            $h['lastdate'] = date('d-m-Y', strtotime($findamount1month[$date]));

                            $feesheadmiscaut = $this->findfeeheadsid("Caution Money");

                            $errmis4 = $this->findfeeheadsamount($student['class_id'], $acedamicyear, $feesheadmiscaut['id']);

                            $h['fee'] = number_format($errmis4[0]['qu1_fees'], 0, ',', '');
                            $due_total += $errmis4[0]['qu1_fees'];
                            $dueamts += $h['fee'];
                            if ($h['fee'] != 0) {
                                array_push($response["duefee"], $h);
                            }
                        }
                    } elseif ($ty == "Development Fee") {
                        if (!in_array($ty, $quahh)) {
                            $h['description'] = "Development Fee";
                            $date = "qu1_date";
                            $h['lastdate'] = date('d-m-Y', strtotime($findamount1month[$date]));

                            $feesheadmisdev = $this->findfeeheadsid("Development Fee");

                            $errmis4dev = $this->findfeeheadsamount($student['class_id'], $acedamicyear, $feesheadmisdev['id']);

                            $h['fee'] = number_format($errmis4dev[0]['qu1_fees'], 0, ',', '');
                            $due_total += $errmis4dev[0]['qu1_fees'];
                            $dueamts += $h['fee'];
                            if ($h['fee'] != 0) {
                                array_push($response["duefee"], $h);
                            }
                        }
                    }
                }
            }

            foreach ($quateroutstand as $hjd => $tyd) {

                $dffd = 0;
                if (!empty($quahh)) {

                    foreach ($quahh as $tjd => $hyd) {
                        if ($hyd == $tyd) {

                            $dffd++;
                        } else {
                        }
                    }
                }

                if ($dffd == '0') {

                    $rg = $this->findclassfee($student['class_id'], $acedamicyear);

                    if ($tyd == "Caution Money") {
                        if (!in_array($tyd, $quahh)) {

                            $feesheadcaut = $this->findfeeheadsid("Caution Money");

                            $errmiscaution = $this->findfeeheadsamount($student['class_id'], $acedamicyear, $feesheadcaut['id']);

                            $sd['description'] = "Caution Money";
                            $dated = "qu1_date";
                            $sd['lastdate'] = date('d-m-Y', strtotime($rg['qu1_date']));
                            $sd['fee'] = number_format($errmiscaution[0]['qu1_fees'], 0, ',', '');
                            $outstanding_total += $errmiscaution[0]['qu1_fees'];
                            $total_dueout += $errmiscaution[0]['qu1_fees'];
                            if ($sd['fee'] != 0) {
                                array_push($response["outstanding"], $sd);
                            }
                        }
                    } else if ($tyd == "Development Fee") {
                        if (!in_array($tyd, $quahh)) {

                            $feesheaddev = $this->findfeeheadsid("Development Fee");

                            $errmisdev = $this->findfeeheadsamount($student['class_id'], $acedamicyear, $feesheaddev['id']);

                            $sd['description'] = "Development Fee";
                            $dated = "qu1_date";
                            $sd['lastdate'] = date('d-m-Y', strtotime($rg['qu1_date']));
                            $sd['fee'] = number_format($errmisdev[0]['qu1_fees'], 0, ',', '');
                            $outstanding_total += $errmisdev[0]['qu1_fees'];
                            $total_dueout += $errmisdev[0]['qu1_fees'];
                            if ($sd['fee'] != 0) {
                                array_push($response["outstanding"], $sd);
                            }
                        }
                    } elseif ($tyd == "Miscellaneous Fee") {
                        if (!in_array($tyd, $quahh)) {

                            $feesheadmis = $this->findfeeheadsid("Miscellaneous Fee");

                            $errmis = $this->findfeeheadsamount($student['class_id'], $acedamicyear, $feesheadmis['id']);

                            $sd['description'] = "Miscellaneous Fees";
                            $dated = "qu1_date";
                            $sd['lastdate'] = date('d-m-Y', strtotime($rg['qu1_date']));
                            $sd['fee'] = number_format($errmis[0]['qu1_fees'], 0, ',', '');
                            $outstanding_total += $errmis[0]['qu1_fees'];
                            $total_dueout += $errmis[0]['qu1_fees'];
                            if ($sd['fee'] != 0) {
                                array_push($response["outstanding"], $sd);
                            }
                        }
                    } else if ($tyd == "Quater4") {
                        if (!in_array($tyd, $quahh)) {
                            $qu_fee_name = "qu4_fees";
                            $final_fees = $this->CalculateDiscount($student['id'], $class_id, $acedamicyear, $qu_fee_name);
                            if ($praticale != 0) {
                                $newfinal = $final_fees + $praticale;
                                $sd['description'] = "Tution Fee (Jan-March) :Practical Fee";
                                $dated = "qu4_date";
                                $sd['lastdate'] = date('d-m-Y', strtotime($rg['qu4_date']));
                                $sd['fee'] = number_format($newfinal, 0, ',', '');
                                $outstanding_total += $newfinal;
                                $total_dueout += $sd['fee'];
                            } else {

                                $sd['description'] = "Tution Fee (Jan-March)";
                                $dated = "qu4_date";
                                $sd['lastdate'] = date('d-m-Y', strtotime($rg['qu4_date']));
                                $sd['fee'] = number_format($final_fees, 0, ',', '');
                                $outstanding_total += $final_fees;
                                $total_dueout += $sd['fee'];
                            }

                            array_push($response["outstanding"], $sd);
                        }
                    } else if ($tyd == "Quater3") {
                        $qu_fee_name = "qu3_fees";
                        $final_fees = $this->CalculateDiscount($student['id'], $class_id, $acedamicyear, $qu_fee_name);
                        if (!in_array($tyd, $quahh)) {

                            if ($praticale != 0) {
                                $newfinal = $final_fees + $praticale;
                                $sd['description'] = "Tution Fee (Oct-Dec) :Practical Fee";
                                $dated = "qu3_date";
                                $sd['lastdate'] = date('d-m-Y', strtotime($rg['qu3_date']));
                                $sd['fee'] = number_format($newfinal, 0, ',', '');
                                $outstanding_total += $newfinal;
                                $total_dueout += $sd['fee'];
                            } else {

                                $sd['description'] = "Tution Fee (Oct-Dec)";
                                $dated = "qu3_date";
                                $sd['lastdate'] = date('d-m-Y', strtotime($rg['qu3_date']));

                                $sd['fee'] = number_format($final_fees, 0, ',', '');
                                $outstanding_total += $final_fees;
                                $total_dueout += $sd['fee'];
                            }
                            array_push($response["outstanding"], $sd);
                        }
                    } else if ($tyd == "Quater2") {
                        $qu_fee_name = "qu2_fees";
                        $final_fees = $this->CalculateDiscount($student['id'], $class_id, $acedamicyear, $qu_fee_name);
                        if (!in_array($tyd, $quahh)) {

                            if ($praticale != 0) {
                                $newfinal = $final_fees + $praticale;
                                $sd['description'] = "Tution Fee (July-Sept) :Practical Fee";
                                $dated = "qu2_date";
                                $sd['lastdate'] = date('d-m-Y', strtotime($rg['qu2_date']));
                                $sd['fee'] = number_format($newfinal, 0, ',', '');
                                $outstanding_total += $newfinal;
                                $total_dueout += $sd['fee'];
                            } else {

                                $sd['description'] = "Tution Fee (July-Sept)";
                                $dated = "qu2_date";
                                $sd['lastdate'] = date('d-m-Y', strtotime($rg['qu2_date']));

                                $sd['fee'] = number_format($final_fees, 0, ',', '');
                                $outstanding_total += $final_fees;

                                $total_dueout += $sd['fee'];
                            }
                            array_push($response["outstanding"], $sd);
                        }
                    } elseif ($tyd == "Quater1") {
                        $qu_fee_name = "qu1_fees";
                        $final_fees = $this->CalculateDiscount($student['id'], $class_id, $acedamicyear, $qu_fee_name);
                        if (!in_array($tyd, $quahh)) {

                            if ($praticale != 0) {
                                $newfinal = $final_fees + $praticale;
                                $sd['description'] = "Tution Fee (April-June) :Practical Fee";
                                $dated = "qu1_date";
                                $sd['lastdate'] = date('d-m-Y', strtotime($rg['qu1_date']));
                                $sd['fee'] = number_format($newfinal, 0, ',', '');
                                $outstanding_total += $newfinal;
                                $total_dueout += $sd['fee'];
                            } else {

                                $sd['description'] = "Tution Fee (April-June)";
                                $dated = "qu1_date";
                                $sd['lastdate'] = date('d-m-Y', strtotime($rg['qu1_date']));
                                $outstanding_total += $final_fees;
                                $sd['fee'] = number_format($final_fees, 0, ',', '');

                                $total_dueout += $sd['fee'];
                            }
                            array_push($response["outstanding"], $sd);
                        }
                    }
                }
            }

            //Pending Fees
            $pending = $this->Studentfeepending->find('all')->select(['id', 'recipetnos', 'amt', 'created'])->where(['Studentfeepending.s_id' => $student['id'], 'Studentfeepending.status' => 'N'])->toArray();

            foreach ($pending as $values) {
                $sd['description'] = "Previous Due Ref. : " . $values['recipetnos'];
                $sd['lastdate'] = date('d-m-Y', strtotime($values['created']));

                $sd['fee'] = number_format($values['amt'], 0, ',', '');
                $outstanding_total += $values['amt'];
                array_push($response["outstanding"], $sd);
            }

            //Pending Fees

            $product["due_amount"] = number_format($due_total, 0, ',', '');

            if ($due_total > 0) {
                // $product['payOnlineUrl'] = 'https://www.sanskarjaipur.com/online-fees/';
                $product['payOnlineUrl'] = null;
            } else {
                $product['payOnlineUrl'] = null;
            }
            $product["outstanding_amount"] = number_format($outstanding_total, 0, ',', '');
            $product["paidfees"] = number_format($paidfeestotal, 0, ',', '');
            $totaltopay = $outstanding_total + $paidfeestotal;
            $product["totalfees"] = number_format($totaltopay, 0, ',', '');
            $response["overall"] = $product;
            $output["output"] = $response;

            echo json_encode($output);
            die;
        }
    }


    /**************************************************************Show the class time table student app****************************************/
    public function classTimeTable()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $id = $postData->id;
            $classId = $postData->classId;
            $sectionId = $postData->sectionId;
            $idsprimeID = $postData->idsprimeID;
            if ((empty($id) && empty($classId) && empty($sectionId)) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);

            if (!empty($id)) {
                $student = $this->Students->find('all')->where(['id' => $id])->first();

                $classId = $student['class_id'];
                $sectionId = $student['section_id'];
            }
            $time_tab = $this->Timetables->find('all')->order(['sort_no' => 'asc'])->toarray();
            $class_section = $this->Classections->find('all')->where(['class_id' => $classId, 'section_id' => $sectionId])->first();

            $weekdays = explode(',', $time_tab[0]['weekday']);
            $response = array();
            $response['success'] = 1;
            $response['timeTable'] = '';
            $output = array();

            foreach ($weekdays as $day) {
                $break = '';
                $key = strtolower($day);
                $output[$key] = '';
                $periods = array();
                $i = 1;
                foreach ($time_tab as $time_value) {



                    if ($time_value['is_break'] != 1) {
                        $per_details = $this->ClasstimeTabs->find('all')->where(['class_id' => $class_section['id'], 'weekday' => $day, 'tt_id' => $time_value['id'], 'status' => '1'])->first();
                        //pr($per_details);

                        // pr($subj_name);
                        // pr($teach_name);
                        if (!empty($per_details)) {
                            $per_det = explode(',', $per_details['subject_id']);
                            $emp_det_val = explode(',', $per_details['employee_id']);
                            $temp_p = array();
                            foreach ($per_det as $keys => $per_det_val) {

                                $subj_name = $this->Subjects->find('all')->select(['alias'])->where(['id' => $per_det_val])->first();
                                $teach_name = $this->Employees->find('all')->select(['fname', 'middlename', 'lname'])->where(['id' => $emp_det_val[$keys]])->first();

                                if ($teach_name['middlename'] != '') {
                                    $temp_p[] = $subj_name['alias'] . "(" . strtoupper($teach_name['fname']) . "\x20" . strtoupper(substr($teach_name['middlename'], 0, 2)) . ")";
                                } else {
                                    $temp_p[] = $subj_name['alias'] . "(" . strtoupper($teach_name['fname']) . "\x20" . strtoupper(substr($teach_name['lname'], 0, 2)) . ")";
                                }
                            }
                            $periods[] = implode("\n", $temp_p);
                        } else {
                            $periods[] = "-";
                        }
                    } else {
                        $break = $i;
                    }
                    $i++;
                }


                $output[$key] = $periods;
            }
            $output['break'] = $break;
            $response['timeTable'] = $output;
            echo json_encode($response);
        }
    }

    /************************************************this api used for student homework***********************************************************/

    public function fetchassignmentsstudents()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $id = $postData->id;
            $idsprimeID = $postData->idsprimeID;
            $date = $postData->date;

            if (empty($id) || empty($id)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $this->loadmodel('Assignments');
            $this->loadmodel('Students');
            $this->loadmodel('Videos');
            $this->loadmodel('Users');
            $this->loadmodel('Employees');
            $response = [];
            $req_data = $this->request->data;


            // $output['createDate'] = date('d-m-Y', strtotime($value['created']));
            //         $output['teacherName'] = ucwords(strtolower($teacher['fname'].' '.$teacher['middlename'].' '.$teacher['lname']));

            $students = $this->Students->find('all')->where(['Students.id' => $id, 'Students.status' => 'Y'])->first();

            $class_id = $students['class_id'];
            $section_id = $students['section_id'];

            //$subject_id =$req_data['subject_id'];
            $academic_year = $students['acedmicyear'];
            $db = explode("_", $idsprimeID);
            if ($db[0] == "canvas") {
                $employee_id_existss = $this->Assignments->find('all')->where(['Assignments.class_id' => $class_id, 'Assignments.section_id' => $section_id, 'Assignments.academic_year' => $academic_year])->count();
            } else {

                $employee_id_existss = $this->Assignments->find('all')->where(['Assignments.class_id' => $class_id, 'Assignments.section_id' => $section_id, 'Assignments.academic_year' => $academic_year, 'Assignments.allocate_date' => date('Y-m-d', strtotime($date))])->count();
                // pr($employee_id_exists);exit;
            }

            $videos = $this->Videos->find('all')->where(['Videos.class_id' => $class_id, 'Videos.section_id' => $section_id, 'Videos.academic_year' => $academic_year])->toarray();
            if ($employee_id_existss > 0) {
                $response["success"] = 1;
                $response["output"] = [];
                if ($employee_id_existss > 0) {
                    if (empty($date)) {
                        $employee_id_exists = $this->Assignments->find('all')->where(['Assignments.class_id' => $class_id, 'Assignments.section_id' => $section_id, 'Assignments.academic_year' => $academic_year, 'Assignments.allocate_date' => date("Y-m-d")])->order(['Assignments.id' => 'DESC'])->toarray();
                    } else {
                        $employee_id_exists = $this->Assignments->find('all')->where(['Assignments.class_id' => $class_id, 'Assignments.section_id' => $section_id, 'Assignments.academic_year' => $academic_year, 'Assignments.allocate_date' => date('Y-m-d', strtotime($date))])->order(['Assignments.id' => 'DESC'])->toarray();
                    }

                    $c = 0;
                    foreach ($employee_id_exists as $value) {

                        $teacher = $this->Employees->find('all')->where(['Employees.id' => $value['teacher_id']])->first();

                        $class_id = $this->findclass($value['class_id']);
                        $section_id = $this->findsections($value['section_id']);
                        $subject_id = $this->findsubject($value['subject_id']);

                        $output['assignment_id'] = $value['id'];
                        $output['created'] = date('d-m-Y', strtotime($value['allocate_date']));
                        $output['classname'] = $class_id['title'];
                        $output['sectionname'] = $section_id['title'];
                        $output['subject'] = $subject_id['name'];
                        $output['classid'] = $value['class_id'];
                        $output['sectionid'] = $value['section_id'];
                        $output['subid'] = $value['subject_id'];
                        $output['description'] = $value['description'];
                        $output['end_date'] = date('d-m-Y', strtotime($value['due_date']));
                        $output['teacherName'] = ucwords(strtolower($teacher['fname'] . ' ' . $teacher['middlename'] . ' ' . $teacher['lname']));

                        if (!empty($value['file'])) {
                            $db = $this->Users->find()->where(['role_id' => 1])->first();

                            ///$filename = IMAGE_URL .$idsprimeID. '_image/' . $value['file'];
                            $filePath = WWW_ROOT . $idsprimeID . '_image/' . $value['file'];


                            $file_headers = @get_headers($filename);

                            if ($file_headers && strpos($file_headers[0], '200 OK')) {
                                $output['file'] = $filename;
                            } else {
                                $output['file'] = SITE_URL . $idsprimeID . "_image/" . $value['file'];
                            }
                        } else {
                            $output['file'] = null;
                        }
                        array_push($response["output"], $output);
                    }
                }
                if (!empty($videos)) {
                    foreach ($videos as $value) {
                        $output = [];
                        $class_id = $this->findclass($value['class_id']);
                        $section_id = $this->findsections($value['section_id']);
                        $subject_id = $this->findsubject($value['subject_id']);

                        $output['assignment_id'] = $value['id'];
                        $output['created'] = date('d-m-Y', strtotime($value['created']));
                        $output['classname'] = $class_id['title'];
                        $output['sectionname'] = $section_id['title'];
                        $output['subject'] = $subject_id['name'];
                        $output['classid'] = $value['class_id'];
                        $output['sectionid'] = $value['section_id'];
                        $output['subid'] = $value['subject_id'];
                        $output['description'] = $value['description'];
                        $output['end_date'] = date('d-m-Y', strtotime($value['due_date']));
                        if (!empty($value['video'])) {
                            $data['userId'] = $id;
                            $data['key'] = $value['video'];
                            $http = new Client();
                            $httpResponse = $http->post('http://13.235.154.210/awsvideo/Pages/videos', $data);
                            $url = $httpResponse->json;
                            $output['file'] = $url['url'];
                        } else {
                            $output['file'] = null;
                        }
                        $response["output"][] = $output;
                    }
                }
                echo json_encode($response, JSON_UNESCAPED_SLASHES);
            } else {

                $response["success"] = 0;
                $response["message"] = "Class have not assigned any assignment";
                echo json_encode($response, JSON_UNESCAPED_SLASHES);
            }
        }
    }

    /*****************************************this api used to show student result in app*********************************************************/
    public function resultsearch()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else if (1 == 1) {
            $jsonData = $this->request->input('json_decode');
            $postData = $this->dPayload($jsonData);
            $student_id = $postData->id;
            $idsprimeID = $postData->idsprimeID;
            if (empty($student_id) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $response = array();

            $response["success"] = 1;
            $response["output"] = array();
            $this->db($idsprimeID);

            // $product["examname"] = "term1";
            // $product["class"] = "IX";
            // $product["resultdeclare"] = date('d-m-Y');
            // // $prms = base64_encode($student['class_id'] . '/' . $student['section_id'] . '/' . $student['id'] . '/' . $exam_id['id']);
            // $product["link"] = SITE_URL . 'IXClassResultterm1.pdf';


            // $product["examname"] = "term1";
            // $product["class"] = "IX";
            // $product["resultdeclare"] = date('d-m-Y');
            // // $prms = base64_encode($student['class_id'] . '/' . $student['section_id'] . '/' . $student['id'] . '/' . $exam_id['id']);
            // $product["link"] = SITE_URL . 'IXClassResultterm1.pdf';


            $result_data['examname'] = "Term 1";
            $result_data["class"] = "I";
            $result_data['resultdeclare'] = date('d-m-Y');
            $result_data['link'] = SITE_URL . 'vatsal_canvas.pdf';

            $result_data_2['examname'] = "Term 2";
            $result_data_2["class"] = "I";
            $result_data_2['resultdeclare'] = date('d-m-Y');
            $result_data_2['link'] = SITE_URL . 'vatsal_canvas.pdf';

            $result_alldata = array(
                $result_data,
                $result_data_2
            );
            $response["output"] = "";
            echo json_encode($response);
        }
    }

    /******************************************************this api used to show libaray index in student app****************************************/
    public function library()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $jsonData = $this->request->input('json_decode');
            $postData = $this->dPayload($jsonData);
            //pr($postData); 
            $student_id = $postData->id;
            $idsprimeID = $postData->idsprimeID;
            $login_type = $postData->login_type;
            if (empty($student_id) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $response = array();
            $product = array();
            //$student_id="S12048";
            //$enroll = ltrim($student_id, 'S');

            if ($login_type == "Student") {
                //echo "testdd";
                $student = $this->Students->find('all')->where(['Students.id' => $student_id, 'Students.status' => 'Y'])->order(['Students.id' => 'DESC'])->first();
            } else {

                $student = $this->Employees->find('all')->where(['Employees.id' => $student_id])->order(['Employees.id' => 'DESC'])->first();
            }

            //$counts = $this->Students->find('all')->where(['Students.id' => $student_id, 'Students.status' => 'Y'])->count();
            //pr($counts);
            if (!empty($student)) {


                $b = $student['board_id'];
                if (empty($student['middlename'])) {
                    $name = $student['fname'] . " " . $student['lname'];
                } else {
                    $name = $student['fname'] . " " . $student['middlename'] . " " . $student['lname'];
                }

                //echo $name; 
                if ($login_type == "Student") {
                    $enroll = $student['enroll'];
                } else {
                    $enroll = $student['id'];
                }
                //echo $enroll;

                $count = $this->IssueBook->find('all')->where(['IssueBook.holder_id' => $enroll, 'IssueBook.status' => 'Y'])->count();

                if ($count > 0) {
                    $student_issus_book = $this->IssueBook->find('all')->where(['IssueBook.holder_id' => $enroll, 'IssueBook.status' => 'Y'])->order(['IssueBook.id' => 'DESC'])->toArray();
                    $response["success"] = 1;
                    $response["output"] = array();

                    foreach ($student_issus_book as $value) {

                        $issue_date = strftime('%d-%b-%Y', strtotime($value['issue_date']));
                        $due_date = strftime('%d-%b-%Y', strtotime($value['due_date']));
                        $assn_no = $this->findbookid($value['asn_no2']);

                        //$fine = $this->findfine($value['asn_no2'], $enroll);
                        foreach ($assn_no as $valued) {
                            $book_id = $valued['book_id'];
                            $book = $this->findbook($book_id);

                            //echo $book[0]['name'];
                            $product["issue_date"] = $issue_date;
                            $product["due_date"] = $due_date;
                            $product["book_name"] = $book[0]['name'];

                            array_push($response["output"], $product);
                        }
                    }
                    echo json_encode($response);
                } else {
                    $response["success"] = 1;
                    $response["output"] = null;
                    $response["message"] = "Not Issued Any Book From Library";
                    echo json_encode($response);
                }
            } else {
                $response["success"] = 0;
                $response["message"] = "Invalid Post Parameter";
                echo json_encode($response);
            }
        }
    }

    /*************************************************************this api is used for book request **********************************/

    public function bookRequest()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $userId = $postData->userId;
            $bookId = $postData->bookId;
            $idsprimeID = $postData->idsprimeID;
            $this->db($idsprimeID);
            if (empty($idsprimeID) || empty($userId) || empty($bookId)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }
            $this->loadModel('BookRequest');
            $this->loadModel('Book');
            $this->loadModel('BookCopyDetail');
            if (empty($userId) || empty($bookId)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }
            $data['stud_id'] = $userId;
            $data['book_id'] = $bookId;
            $book = $this->Book->find('all')->where(['id' => $data['book_id']])->first();
            if (empty($book)) {
                $response['success'] = 0;
                $response["message"] = "Invalid Book";
                echo json_encode($response);
                return;
            }
            $exists = $this->BookRequest->exists(['stud_id' => $data['stud_id'], 'book_id' => $data['book_id'], 'status' => 'pending']);
            if ($exists) {
                $response['success'] = 0;
                $response["message"] = "You already have a request for this book in process";
                echo json_encode($response);
                return;
            }
            $issuedCheck = $this->IssueBook->exists(['holder_type_id' => 'Student', 'holder_id' => $data['stud_id'], 'status' => 'Y']);
            if ($issuedCheck) {
                $response['success'] = 0;
                $response["message"] = "Book already Issued to You";
                echo json_encode($response);
                return;
            }
            $availCheck = $this->BookCopyDetail->exists(['book_id' => $data['book_id'], 'status' => 'Available']);
            if (!$availCheck) {
                $response['success'] = 0;
                $response["message"] = "Book Not Available";
                echo json_encode($response);
                return;
            }
            $patch = $this->BookRequest->patchEntity($this->BookRequest->newEntity(), $data);
            if ($this->BookRequest->save($patch)) {
                $response['success'] = 1;
                $response["message"] = "Your Request has been saved Successfully";
                echo json_encode($response);
                return;
            }
        }
    }


    /*************************************************************this api use to select category in student side**********************************/
    public function booksCategories()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $idsprimeID = $postData->idsprimeID;
            $this->db($idsprimeID);
            if (empty($idsprimeID)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }
            $this->loadModel('BookCategory');
            $bookcat = $this->BookCategory->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toarray();
            $response['success'] = 1;
            $response['category'] = [];
            foreach ($bookcat as $id => $name) {
                $data = [];
                $data['value'] = $id;
                $data['name'] = $name;
                $response['category'][] = $data;
            }
            if (empty($bookcat)) {
                $response['category'] = null;
            }
            echo json_encode($response);
            return;
        }
    }

    /*********************************************************************this api use to book search in student side********************************/
    public function bookSearch()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $category = $postData->category;
            $bookName = $postData->bookName;
            $author = $postData->author;
            $subTitle = $postData->subTitle;
            $idsprimeID = $postData->idsprimeID;
            $this->db($idsprimeID);
            if (empty($idsprimeID) || empty($category)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }
            $this->loadModel('Book');
            if (!empty($category)) {
                $con[] = ['Book.book_category_id' => $category];
            }
            if (!empty($bookName)) {
                $con[] = ['Book.name LIKE' => '%' . $bookName . '%'];
            }
            if (!empty($author)) {
                $con[] = ['Book.author LIKE' => '%' . $author . '%'];
            }
            if (!empty($subTitle)) {
                $con[] = ['Book.sub_title LIKE' => '%' . $subTitle . '%'];
            }
            $books = $this->Book->find('all')->contain(['BookCategory'])->where($con)->toarray();
            $response['success'] = 1;
            foreach ($books as $book) {
                $data = array();
                $data['id'] = $book['id'];
                $data['category'] = $book['book_category']['name'];
                $data['name'] = $book['name'];
                $data['author'] = $book['author'];
                $bookAvailable = $this->BookCopyDetail->exists(['book_id' => $book['id'], 'status' => 'Available']);
                if ($bookAvailable) {
                    $data['status'] = 'Available';
                } else {
                    $data['status'] = 'Not Available';
                }
                $response['books'][] = $data;
            }
            if (empty($books)) {
                $response['success'] = 0;
                $response['books'] = null;
                $response['message'] = "No matching Books";
            }
            echo json_encode($response);
            return;
        }
    }

    /**************************************this api view datesheet in student side app****************************************/

    public function datesheet()
    {

        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $sid = $postData->id;
            $idsprimeID = $postData->idsprimeID;
            if (empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }

            $this->db($idsprimeID);
            $this->loadModel('Datesheet');
            $this->loadModel('Students');
            $this->loadModel('Users');


            //pr($this->request->data);
            if (!empty($sid)) {
                $student_det = $this->Students->find('all')->where(['id' => $sid])->first();
                $class_id = $student_det['class_id'];
                $date = date('Y-m-d');
                $sheet = $this->Datesheet->find('all')->where(['end_date >=' => $date])->order(['Datesheet.id' => 'DESC'])->toarray();
                //pr($sheet);
                $response = array();
                if (!empty($sheet)) {
                    $cond['success'] = 0;
                    foreach ($sheet as $values) {



                        $output = array();
                        $classes = explode(',', $values['class_id']);
                        if (in_array($class_id, $classes)) {
                            $cond['success'] = 1;
                            $output['title'] = ucwords($values['title']);
                            $output['start_date'] = date('d-m-Y', strtotime($values['start_date']));
                            $output['end_date'] = date('d-m-Y', strtotime($values['end_date']));
                            $db = $this->Users->find()->where(['role_id' => 1])->first();
                            $filename = SITE_URL  . 'img/' . $values['sheet_name'];


                            $file_headers = @get_headers($filename);

                            if ($file_headers && strpos($file_headers[0], '200 OK')) {
                                $output['url'] = $filename;
                            } else {
                                $output['url'] = SITE_URL  . 'img/' . $values['sheet_name'];
                                //  $output['url'] = '/var/www/html/idsprime/webroot/img/'. $values['sheet_name'];

                            }
                        }
                        if (!empty($output['title'])) {
                            $response['success'] = 1;
                            $response['dateSheet'][] = $output;
                        }
                    }
                    if ($cond['success'] != 1) {
                        $response['success'] = 1;
                        $response['dateSheet'] = null;
                        $response['message'] = "No Data Available";
                    }
                    echo json_encode($response);
                } else {
                    $response['success'] = 1;
                    $response['dateSheet'] = null;
                    $response['message'] = "No Data Available";
                    echo json_encode($response);
                }
            } else {
                $response['success'] = 0;
                $response['message'] = "Invalid Post Parameter";
                echo json_encode($response);
            }
        }
    }



    /**************************************this api add gatepass in student side app****************************************/
    public function gatepass()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $userId = $postData->userId;
            $time = $postData->time;
            $pickedBy = $postData->pickedBy;
            $reason = $postData->reason;
            $mobile = $postData->mobile;
            $idsprimeID = $postData->idsprimeID;
            $this->db($idsprimeID);
            if (empty($userId) || empty($idsprimeID) || empty($time) || empty($pickedBy) || empty($reason) || empty($mobile)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }
            $this->loadModel('gatepass');
            $passExist = $this->gatepass->exists(['stud_id' => $userId, 'DATE(created)' => date('Y-m-d')]);
            if ($passExist) {
                $response['success'] = 0;
                $response["message"] = "We have already received your request for today";
                echo json_encode($response);
                return;
            }
            $data['stud_id'] = $userId;
            $data['time'] = $time;
            $data['pickedBy'] = $pickedBy;
            $data['reason'] = $reason;
            $data['mobile'] = $mobile;
            $patch = $this->gatepass->patchEntity($this->gatepass->newEntity(), $data);
            if ($visitor = $this->gatepass->save($patch)) {
                $response['success'] = 1;
                $response["message"] = "We have receieved You request for gatepass. Thank You";
                echo json_encode($response);
                return;
            }
        }
    }

    /**************************************this api view gatepass in student side app****************************************/
    public function viewGatePass()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $userId = $postData->userId;
            $idsprimeID = $postData->idsprimeID;
            $this->db($idsprimeID);
            if (empty($userId) || empty($idsprimeID)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }
            $date = date('y-m-d');
            $date = date('Y-m-d', strtotime($date . '-30 days'));
            $gatepasses = $this->gatepass->find('all')->where(['stud_id' => $userId, 'DATE(created) >=' => $date])->order(['id' => 'DESC'])->toarray();
            $response = array();
            $response['intime'] = "07:00:00 AM";
            //Code Ramesh (change outtime (22:00:00 PM to 10:00:00 PM))
            $response['outtime'] = "22:00:00 PM";

            // $response['outtime'] = "10:00:00 PM";
            $response['success'] = 1;
            if (!empty($gatepasses)) {
                foreach ($gatepasses as $gatepass) {
                    $output['pickTime'] = date('h:i A', strtotime($gatepass['time']));
                    $output['pickedBy'] = $gatepass['pickedBy'];
                    $output['reason'] = $gatepass['reason'];
                    $output['pickerMobile'] = $gatepass['mobile'];
                    $output['createdDate'] = date('d-m-Y', strtotime($gatepass['created']));
                    $response['output'][] = $output;
                }
            } else {
                $response['success'] = 0;
                $response['output'] = null;
                $response['message'] = "No Gatepasses to dispaly";
            }
        }
        echo json_encode($response);
        return;
    }

    /**************************************this api add feedback in student side app****************************************/
    public function feedback()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $userId = $postData->userId;
            $feedbackCat = $postData->feedbackCat;
            $feedback = $postData->feedback;
            $idsprimeID = $postData->idsprimeID;
            if (empty($userId) || empty($feedbackCat) || empty($feedback) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            try {
                $this->loadModel('Feedbacks');
                $this->loadModel('Students');
                $this->loadModel('Users');

                $students = explode(',', $userId);
                foreach ($students as $id) {
                    $new = $this->Feedbacks->newEntity();
                    $new['stud_id'] = $id;
                    $new['feedback_cat_id'] = $feedbackCat;
                    $new['feedback'] = $feedback;
                    if (empty($new['stud_id']) || empty($new['feedback_cat_id']) || empty($new['feedback'])) {
                        $response['success'] = 0;
                        $response['message'] = "Fields cant be blank";
                        echo json_encode($response);
                        throw new Exception('Fields cant be blank');
                    }
                    $stu = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $new['stud_id']])->first();
                    $mobile_no = $this->Users->find()->where(['role_id' => 1, 'db' => $idsprimeID])->first();



                    if ($stu['fname']) {
                        $new['student_name'] = $stu['fname'] . ' ' . $stu['middlename'] . ' ' . $stu['lname'];
                    } else {
                        $new['student_name'] = "Admin";
                    }

                    $new['class'] = $stu['class']['title'];
                    $new['section'] = $stu['section']['title'];

                    if ($stu['sms_mobile']) {

                        $new['phone'] = $stu['sms_mobile'];
                    } else {

                        $new['phone'] = $mobile_no['mobile'];
                    }


                    $this->Feedbacks->save($new);
                }
                $response['success'] = 1;
                $response['message'] = "Thank you for your valuable feedback";
                echo json_encode($response);
            } catch (\PDOException $e) {
                $response['success'] = 0;
                $response['message'] = "Error in saving data please try later";
                echo json_encode($response);
            }
            return;
        }
    }

    /**************************************this api show view feedback in student side app****************************************/
    public function viewFeedback()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $userId = $postData->userId;
            $idsprimeID = $postData->idsprimeID;
            if (empty($idsprimeID) || empty($userId)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $this->loadModel('Feedbacks');
            $this->loadModel('Users');

            $users = $this->Users->find('all')->where(['role_id' => '1', 'db' => $idsprimeID])->first();


            $acedmicyear = $users['academic_year'];
            $acd = explode('-', $acedmicyear);
            $fromyear = $acd[0] . "-04-01";

            $toyear = ($acd[0] + 1) . "-03-31";
            $stts = array('Feedbacks.created >=' => $fromyear);
            $apk[] = $stts;

            $stts = array('Feedbacks.created <=' => $toyear);
            $apk[] = $stts;

            $stts = array('Feedbacks.stud_id' => $userId);
            $apk[] = $stts;


            $feedbacks = $this->Feedbacks->find('all')->where([$userId])->order(['Feedbacks.id' => 'DESC'])->toarray();

            $response['success'] = 1;
            if (!empty($feedbacks)) {

                foreach ($feedbacks as $feedback) {
                    $data = array();
                    $data['date'] = date('d-m-Y', strtotime($feedback['created']));
                    $data['feedback'] = $feedback['feedback'];
                    if ($feedback['status'] == 'N') {
                        $data['status'] = 'open';
                    } else {
                        $data['status'] = 'Closed';
                        $data['reply']['message'] = ucfirst(strtolower($feedback['remarks']));
                        $data['reply']['date'] = date('d-m-Y', strtotime($feedback['closing_date']));
                    }
                    $response['output'][] = $data;
                }
            } else {
                $response['success'] = 0;
                $response['output'] = null;
                $response['message'] = "You have no Suggestions";
            }

            echo json_encode($response);
            return;
        }
    }



    /**************************************this api show feedback categories in student side app****************************************/
    public function feedbackcategories()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $idsprimeID = $postData->idsprimeID;
            if (empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $this->loadModel('FeedbackCat');
            $cat = $this->FeedbackCat->find('list', array(['keyField' => 'id', 'valueField' => 'name']))->toarray();
            $response['success'] = 1;
            $response['category'] = array();
            foreach ($cat as $key => $value) {
                $data['id'] = $key;
                $data['name'] = $value;
                $response['category'][] = $data;
            }
            if (empty($cat)) {
                $response['success'] = 0;
                $response['category'] = null;
            }
            echo json_encode($response);
            die;
            return;
        }
    }

    /************************************************************************************
     ******************Student Api's End***********************************************/




    /************************************************************************************
     ******************Staff Api's Start***********************************************/
    /*
1. passwordLogin
2. slider
3. getTeacherInfo
4. getNotificationCount
5. teacherAttendance
6. studentAttendanceList
7. updateStudentAttendance
8. studentList
9. studentuploadimage
10. teacherTimeTable
11. fetchassignment
12. classsections
13. addassignment
14. viewevents
15. eventtype
16. notifications/ firebaseNotification
17. library
18. bookRequest
18. booksCategories
19. booksearch
18. bookRequestList
19. teacher_datesheet
20. photoGallery
21. teacheruploadimage
22. staffupdateEmail
23. resetNotificationCount
24. classassign
25. fetchSubjectAssign
26. getTeacherClassDetail
27. fetchClassection
28. assigntoanother
29. assignmentdelete
*/




    /************************************************************************************
     ******************Staff Api's End***********************************************/

    /*****************************************************  Get Teacher/Staff Information in app *****************************************************/

    public function assignmentdelete()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $jsonData = $this->request->input('json_decode');
            $postData = $this->dPayload($jsonData);
            $assignment_id = $postData->assignment_id;
            $idsprimeID = $postData->idsprimeID;
            if (empty($assignment_id) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $response = [];
            $assignment = $this->Assignments->get($assignment_id);
            if ($this->Assignments->delete($assignment)) {
                $response["success"] = 1;
                $response["message"] = " Assignment has been successfully deleted";
                echo json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "Assignment cannot delete, Try again";
                echo json_encode($response);
            }
        }
    }

    public function assigntoanother()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $jsonData = $this->request->input('json_decode');
            $postData = $this->dPayload($jsonData);
            $teacher_id = $postData->teacher_id;
            $assignment_id = $postData->assignment_id;
            $class_id = $postData->class_id;
            $section_id = $postData->section_id;
            $due_date = $postData->due_date;
            $idsprimeID = $postData->idsprimeID;
            if (empty($teacher_id) || empty($idsprimeID) || empty($class_id) || empty($section_id) || empty($due_date)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $due_date = date('Y-m-d', strtotime($due_date));
            $allocate_date = date('Y-m-d');
            $current_year = date('Y');
            $next_year = date('y') + 1;
            $academic_year = $current_year . "-" . $next_year;
            $total_assignments = $this->Assignments->find('all')->where(['Assignments.id' => $assignment_id])->count();
            if ($total_assignments > 0) {
                $total_assignments = $this->Assignments->get($assignment_id);
                $name = $total_assignments['name'];
                $description = $total_assignments['description'];
                $subject_id = $total_assignments['subject_id'];
                $files = $total_assignments['file'];
                $peopleTable = TableRegistry::get('Assignments');
                $oquery = $peopleTable->query();
                $oquery->insert(['name', 'description', 'academic_year', 'teacher_id', 'class_id', 'section_id', 'subject_id', 'allocate_date', 'due_date', 'file'])->values([
                    'name' => $name,
                    'description' => $description,
                    'academic_year' => $academic_year,
                    'teacher_id' => $teacher_id,
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'allocate_date' => $allocate_date,
                    'due_date' => $due_date,
                    'file' => $files,
                ]);
                $query_status = $oquery->execute();
                if ($query_status) {
                    $response["success"] = 1;
                    $response["message"] = "Assignment assign successfully.";

                    echo json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "Assignment cannot assign.";

                    echo json_encode($response);
                }
            } else {

                $response["message"] = "No Assignment found in database.";
                echo json_encode($response);
            }
        }
    }


    public function fetchClassection()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $jsonData = $this->request->input('json_decode');
            $postData = $this->dPayload($jsonData);
            $cid = $postData->class_id;
            $idsprimeID = $postData->idsprimeID;
            if (empty($cid) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $response = [];
            $response['success'] = '';
            $response['section'] = [];

            $sections = $this->Classections->find('list', [
                'keyField' => 'Sections.id',
                'valueField' => 'Sections.title',
            ])->contain(['Sections'])->where(['Classections.class_id' => $cid])->order(['Sections.title' => 'ASC'])->toArray();
            if (!empty($sections)) {
                $response['success'] = 1;
                foreach ($sections as $key => $value) {
                    $response['section'][] = [
                        'sectionname' => $value,
                        "sectionid" => $key,
                    ];
                }
            } else {
                $response['success'] = 0;
            }
            echo json_encode($response);
        }
    }


    public function getTeacherClassDetail()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $teacher_id = $postData->teacherId;
            $idsprimeID = $postData->idsprimeID;
            if (empty($teacher_id) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);

            if (!empty($teacher_id)) {
                $teacher_exists = $this->Employees->find('all')->where(['id' => $teacher_id])->count();

                if ($teacher_exists == 1) {
                    $class_section_list = $this->ClasstimeTabs->find('all')->where(['FIND_IN_SET(\'' . $teacher_id . '\',ClasstimeTabs.employee_id)'])->contain(['Classections'])->toArray();
                    if (!empty($class_section_list)) {
                        $response = [];
                        $response["success"] = 1;
                        $response['classes'] = [];
                        $asd = array();
                        foreach ($class_section_list as $value) {
                            if (!in_array($value['classection']['class_id'], $asd)) {
                                $asd[] = $value['classection']['class_id'];
                            }
                        }
                        foreach ($asd as $k => $val) {
                            $clas = $this->Classes->find('all')->select(['title'])->where(['id' => $val])->first();
                            $response['classes'][] = [
                                'id' => $val,
                                "name" => $clas['title'],
                            ];
                        }

                        echo json_encode($response);
                    } else {
                        $response["success"] = 0;
                        $response["message"] = "No Classes assigned.";
                        echo json_encode($response);
                    }
                } else {

                    $response["success"] = 0;
                    $response["message"] = "You Are Not a Registered Employee";
                    echo json_encode($response);
                }
            } else {
                $response["message"] = "Invalid Post parameters.";
                echo json_encode($response);
            }
        }
    }



    public function fetchSubjectAssign()
    {


        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $jsonData = $this->request->input('json_decode');
            $postData = $this->dPayload($jsonData);
            $cls = $postData->clas_id;
            $sls = $postData->sec_id;
            $tid = $postData->teach_id;
            $idsprimeID = $postData->idsprimeID;
            if (empty($cls) || empty($idsprimeID) || empty($sls) || empty($tid)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $this->loadmodel('Subjectclass');
            //pr($req_data); die;

            if (!empty($tid)) {
                $teacher_exists = $this->Employees->find('all')->where(['id' => $tid])->count();
                if ($teacher_exists == 1) {
                    // $subjectlist = $this->ClasstimeTabs->find('all')->select(['ClasstimeTabs.subject_id', 'ClasstimeTabs.employee_id'])->where(['FIND_IN_SET(\'' . $tid . '\',ClasstimeTabs.employee_id)', 'Classections.class_id' => $cls, 'Classections.section_id' => $sls])->contain(['Classections', 'Subjects'])->toArray();
                    // //pr($subjectlist); die;
                    // $fgh = array();
                    // foreach ($subjectlist as $val) {
                    //     $subid = explode(',', $val['subject_id']);
                    //     $empid = explode(',', $val['employee_id']);
                    //     //pr($subid);  pr($empid);

                    //     foreach ($empid as $k1 => $em) {
                    //         foreach ($subid as $k2 => $sb) {
                    //             if ($k1 == $k2 && $em == $tid) {
                    //                 //pr($em); pr($sb);
                    //                 $fgh[] = $em . '-' . $sb;
                    //             }
                    //         }
                    //     }
                    // }

                    // $b = array_unique($fgh); //pr($b); die;
                    $response = [];

                    $response["success"] = 1;
                    $response['subject'] = [];

                    $subject_class_relations = $this->Subjectclass->find('all')->contain(['Classes', 'Subjects'])->where(['Subjectclass.class_id' => $cls])->toarray();


                    foreach ($subject_class_relations as  $value) {

                        $response['subject'][] = [
                            'sub_id' => $value['subject_id'],
                            "subname" => $value['Subjects']['name'],
                            "subalias" => $value['Subjects']['alias'],
                        ];
                    }


                    // foreach ($b as $key => $value) {

                    //     $nm = explode('-', $value);
                    //     $subn = $this->Subjects->find('all')->where(['id' => $nm[1]])->first();
                    //     //pr($subn);
                    //     $response['subject'][] = [
                    //         'sub_id' => $nm[1],
                    //         "subname" => $subn['name'],
                    //         "subalias" => $subn['alias'],
                    //     ];
                    // }
                    echo json_encode($response);
                }
            }
        }
    }




    public function classassign()
    {

        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        $postData = $this->dPayload($jsonData);
        $req_data = (array)$postData;

        $idsprimeID = $req_data['idsprimeID'];

        $this->db($idsprimeID);
        $this->loadmodel('Employees');
        $this->loadmodel('ClasstimeTabs');
        $this->loadmodel('Classections');
        $this->loadmodel('Classes');
        $this->loadmodel('Sections');
        if ($this->request->is(['post', 'put'])) {
            //pr($req_data); die;
            $teacher_id = $req_data['t_id'];

            if (!empty($teacher_id)) {
                $teacher_exists = $this->Employees->find('all')->where(['id' => $teacher_id])->count();

                if ($teacher_exists == 1) {

                    $Classections = $this->Classections->find('all')->contain(['Classes', 'Sections'])->order(['Classections.class_id' => 'ASC'])->toarray();

                    if (!empty($Classections)) {
                        $response = [];
                        $asd = array();
                        foreach ($Classections as $va) {

                            $response['classsec'][] = [
                                'class_id' => $va['class_id'],
                                "section_id" => $va['section_id'],
                                "name" => $va['Classes']['title'] . ' - ' . $va['Sections']['title'],
                            ];
                        }

                        $cryptor = new Encryptor;
                        $data['success'] = 1;

                        $data['classsec'] = $response['classsec'];
                        echo json_encode($data);
                    } else {
                        $response["success"] = 0;
                        $response["message"] = "No lecture assigned.";
                        echo json_encode($response);
                    }
                } else {

                    $response["success"] = 0;
                    $response["message"] = "You Are Not a Registered Employee";
                    echo json_encode($response);
                }
            } else {
                $response["message"] = "Invalid Post parameters.";
                echo json_encode($response);
            }
        } else {
            $response["message"] = "No Value Assigned in Post";
            echo json_encode($response);
        }
    }




    public function staffupdateEmail()
    {
        $response = array();
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $id = $postData->id;
            $email = $postData->email;
            $idsprimeID = $postData->idsprimeID;
            if (empty($email) || empty($idsprimeID) || empty($id)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $this->loadModel('Users');
            if (!empty($id) && !empty($email)) {
                $stu = $this->Employees->get($id);
                //pr($stu);
                $employees_users = $this->Users->find('all')->where(['Users.mobile' => $stu['mobile']])->first();

                $employees = $this->Employees->find('all')->where(['Employees.status' => 'Y', 'Employees.mobile' => $stu['mobile']])->first();
                //echo $stu['mobile'];

                $stu_det = $this->Employees->get($employees['id']);
                $data['email'] = $email;
                $patch = $this->Employees->patchEntity($stu_det, $data);
                $this->Employees->save($patch);

                $conn = ConnectionManager::get('default');
                $sintall = "select * FROM users WHERE mobile=" . $stu['mobile'];
                $rinstall = $conn->execute($sintall)->fetch('assoc');
                $connsssksg = ConnectionManager::get('default');
                $school_user_id = $rinstall['id'];
                $connsssksg->execute("UPDATE `users` set `email`='" . $email . "' WHERE `id`='" . $school_user_id . "'");

                $stu_det_user = $this->Users->get($employees_users['id']);
                $user_data['email'] = $email;
                $patch = $this->Users->patchEntity($stu_det_user, $user_data);
                $this->Users->save($patch);

                $response['success'] = 1;
                $response['message'] = "Email updated Successfully";
                echo json_encode($response);
            } else {
                $response["message"] = "Invalid Post parameters.";
                echo json_encode($response);
            }
        }
    }




    public function teacheruploadimage()
    {
        $this->autoRender = false;
        $teacher_id = $this->request->data['teacherId'];
        $idsprimeID = $this->request->data['idsprimeID'];

        if (empty($teacher_id) || empty($idsprimeID)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Parameter";
            echo json_encode($response);
            return;
        }

        $this->db($idsprimeID);
        $this->loadModel('Employees');
        $response = [];
        $filename = $this->request->data['photo']['name'];
        $tmp =  $this->request->data['photo']['tmp_name'];
        $ext = end(explode('.', $filename));
        $teacher = $this->Employees->find('all')->where(['Employees.id' => $teacher_id])->first();
        if ($teacher) {
            $imagename = $teacher['id'] . strtotime("now") . "." . $ext;
            $filePath = WWW_ROOT . $idsprimeID . '_image/employees/' . $imagename;
            if ($filename != '') {
                unlink(WWW_ROOT . $idsprimeID . '_image/employees/' . $teacher['file']);
                move_uploaded_file($tmp, $filePath);
                $this->request->data['file'] = $imagename;
            } else {
                $this->request->data['file'] = $teacher['file'];
            }
            $teacher_update = $this->Employees->patchEntity($teacher, $this->request->data);
            $this->Employees->save($teacher_update);
            $response["success"] = 1;
            $response["message"] = "image uploaded successfully";
            echo json_encode($response);
            die;
        } else {
            $response["success"] = 0;
            $response["message"] = "Student record not avialabel";
            echo json_encode($response);
            die;
        }
    }


    public function resetNotificationCount()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $user_id = $postData->userId;
            $login_type = $postData->login_type;
            $idsprimeID = $postData->idsprimeID;
            if (empty($idsprimeID) || empty($user_id) || empty($login_type)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $this->loadmodel('Users');
            $this->loadmodel('Students');
            $this->loadmodel('Employees');
            if ($login_type == 'Student') {
                $user_reg = $this->Students->get($user_id);
                $data['notification_counter'] = '0';
                $user_reg_add = $this->Students->patchEntity($user_reg, $data);
                $results = $this->Students->save($user_reg_add);
            } else if ($login_type == 'Teacher') {
                $user_reg = $this->Employees->get($user_id);
                $data['notification_counter'] = '0';
                $user_reg_add = $this->Employees->patchEntity($user_reg, $data);
                $results = $this->Employees->save($user_reg_add);
            } else {
                $response["success"] = 0;
                $response["message"] = "Ivalid User Type";
                echo json_encode($response);
                return;
            }

            if ($results) {
                $body['success'] = 1;
                $body['message'] = "Notification count reseted successfully";
            } else {
                $body['success'] = 0;
                $body['message'] = "This user doesn't exist";
            }
        }
        echo json_encode($body);
        die;
    }



    public function getTeacherInfo()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $jsonData = $this->request->input('json_decode');
            $postData = $this->dPayload($jsonData);
            //pr($this->request->data['empId']);
            $empid = $postData->empId;
            $idsprimeID = $postData->idsprimeID;
            if (empty($empid) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Paameters";
                return;
            }
            $this->db($idsprimeID);

            $employee = $this->Employees->find('all')->where(['id' => $empid])->first();

            $emp_id = $employee['id'];

            $class_section1 = $this->Classteachers->find('all')->where(['teach_id' => $emp_id])->contain(['Classes', 'Sections'])->order(['teacher_type ASC'])->first();

            if (empty($class_section1)) {
                $class_section2 = $this->Classections->find('all')->where(['FIND_IN_SET(\'' . $emp_id . '\',Classections.teacher_id)'])->contain(['Classes', 'Sections'])->first();
            }

            if (!empty($class_section1)) {
                $asd = 1;
                $class_section = $class_section1->toArray();
            } else if (!empty($class_section2)) {
                $asd = 2;
                $class_section = $class_section2->toArray();
            }

            //pr($class_section);

            $address = $this->Addresses->find('all')->where(['Addresses.user_id' => $emp_id, 'Addresses.type' => '1'])->first();

            $current_address = $address['c_address'];
            $p_address = $address['p_address'];
            $current_city = $this->cities($address['c_city_id']);
            $city_name = $current_city[0]['name'];
            $current_state = $this->states($address['c_s_id']);
            $state_name = $current_state[0]['name'];
            $current_country = $this->countries($address['c_c_id']);
            $country_name = $current_country[0]['name'];

            $p_current_city = $this->cities($address['p_city_id']);
            $p_city_name = $current_city[0]['name'];
            $p_current_state = $this->states($address['p_s_id']);
            $p_state = $p_current_state[0]['name'];
            $p_current_country = $this->countries($address['p_c_id']);
            $p_country = $p_current_country[0]['name'];

            $response["success"] = 1;
            //$response["details"] = [];

            $product["employee_id"] = $emp_id;
            $product["fname"] = ucwords(strtolower($employee['fname']));
            $product["middlename"] = ucwords(strtolower($employee['middlename']));
            $product["lname"] = ucwords(strtolower($employee['lname']));
            $product["email"] = $employee['email'];
            if ($class_section['class_id']) {
                $product["class_id"] = $class_section['class_id'];
                $product["class"] = $class_section['class']['title'];
            } else {
                $product["class_id"] = '0';
                $product["class"] = 'N/A';
            }

            // $product["dob"] = ($employee['dob'] = '') ? '' : date('d-m-Y', strtotime($employee['dob']));

            if (empty($employee['dob'])) {
                $product["dob"] = "";
            } else {

                $product["dob"] = date('d-m-Y', strtotime($employee['dob']));
            }

            $product["f_h_name"] = ucwords(strtolower($employee['f_h_name']));
            if ($class_section['section_id']) {
                $product["section_id"] = $class_section['section_id'];

                $product["section"] = $class_section['section']['title'];
            } else {
                $product["section_id"] = '0';
                $product["section"] = 'N/A';
            }

            $product["mobile"] = $employee['mobile'];


            if (empty($employee['joiningdate'])) {
                $product["joiningdate"] = "";
            } else {

                $product["joiningdate"] = date('d-m-Y', strtotime($employee['joiningdate']));
            }



            $product["department_id"] = $employee['department_id'];
            $product["designation_id"] = $employee['designation_id'];
            $product["department"] = $employee['department']['name'];
            if ($asd == '1') {
                if ($class_section['teacher_type'] == '2') {
                    $product["designation"] = "Co-Class Teacher";
                } else {
                    $product["designation"] = "Class Teacher";
                }
            } else {
                $product["designation"] = "Teacher";
            }
            $product["current_address"] = $current_address;
            $product["current_city"] = $city_name;
            $product["current_state"] = $state_name;
            $product["current_country"] = $country_name;
            $product["current_address_pincode"] = $address['c_pincode'];
            $product["permanant_address"] = $p_address;
            $product["permanant_city"] = $p_city_name;
            $product["permanant_state"] = $p_state;
            $product["permanant_country"] = $p_country;
            $product["permanant_address_pincode"] = $address['p_pincode'];

            if (!empty($employee['file'])) {
                $product["image"] = SITE_URL . $idsprimeID . '_image/employees/' . $employee['file'];
            } else {
                $product["image"] = null;
            }
            $response["details"] = $product;

            echo json_encode($response, JSON_UNESCAPED_SLASHES);
        }
    }

    /****************************************  This api used for Teacher/Staff attendance in app *******************************************/

    public function teacherAttendnce()
    {

        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            // echo "test";die;
            $jsonData = $this->request->input('json_decode');
            $postData = $this->dPayload($jsonData);
            $tid = $postData->teacher_id;
            $idsprimeID = $postData->idsprimeID;
            if (empty($tid) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $this->loadmodel('Classteachers');
            $this->loadmodel('Classes');
            $this->loadmodel('Sections');
            $this->loadmodel('Users');
            $this->loadmodel('Students');
            $this->loadmodel('Studattends');
            $this->autoRender = false;

            $class_teac = $this->Classteachers->find('all')->where(['teach_id' => $tid])->order(['teacher_type ASC'])->toarray();
            $output['success'] = 1;
            $output['classes'] = array();
            $atime = $this->Users->find('all')->select(['attendenceupdate'])->where(['role_id' => '1'])->first();
            // pr($atime);
            foreach ($class_teac as $class_teacher) {

                //pr($class_teacher);

                $class = $this->Classes->find('all')->select(['title', 'id', 'wordsc'])->where(['Classes.id' => $class_teacher['class_id']])->first();
                $cid = $class_teacher['class_id'];
                $sections = $this->Sections->find('all')->select(['title', 'id'])->where(['Sections.id' => $class_teacher['section_id']])->first();
                $sid = $class_teacher['section_id'];

                //pr($class);

                $type = $class_teacher['teacher_type'];

                $response = [];
                $response['classId'] = $cid;
                $response['sectionId'] = $sid;
                $response['className'] = $class['title'];
                $response['sectionName'] = $sections['title'];

                if (!empty($class_teacher)) {
                    if ($type == '2') {
                        $response['role'] = 'Co-Class Teacher';
                    } else {
                        $response['role'] = 'Class Teacher';
                    }

                    $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
                    $acedmic = $users['academic_year'];
                    $total_stu = $this->Students->find('all')->where(['Students.class_id' => $cid, 'Students.section_id' => $sid, 'Students.acedmicyear' => '2022-23', 'Students.status' => 'Y'])->count();

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

            if ($current_time >= $atime['attendenceupdate']) {
                $output['canTakeAttendance'] = false;
            } else {
                $output['canTakeAttendance'] = true;
            }
            //$output['attendance_time'] = $atime['attendenceupdate'];

            echo json_encode($output);
        }
    }


    /***************************************************** All Student List in After login Teacher => Attendence Menu  ***************************/
    public function studentAttendanceList()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $employee_id = $postData->teacher_id;
            $class_id = $postData->class_id;
            $section_id = $postData->section_id;
            $idsprimeID = $postData->idsprimeID;
            if (empty($employee_id) || empty($class_id) || empty($section_id) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $this->loadModel('Users');
            $atime = $this->Users->find('all')->select(['attendenceupdate'])->where(['role_id' => '1'])->first();
            $current_time = date("H.i", time());
            if ($current_time <= $atime['attendenceupdate']) {

                $response = [];
                $req_data = $this->request->data;
                $dat = date('Y-m-d');
                $stu_atn_status = $this->Studattends->find('all')->where(['Studattends.class_id' => $class_id, 'Studattends.section_id' => $section_id, 'Studattends.date' => $dat])->count();
                if ($stu_atn_status > 0) {

                    $attn_taken = true;
                } else {
                    $attn_taken = false;
                }

                $current_month = date('m');
                $current_date = date('Y-m-d');

                if ($current_month >= '04') {
                    $academic_year = date('Y') . '-' . (date('y') + 1);
                } else {
                    $academic_year = (date('Y') - 1) . '-' . date('y');
                }

                if (
                    !empty($employee_id) && !empty($class_id) && !empty($section_id)
                    && !empty($academic_year)
                ) {

                    $employee_id_exists = $this->Employees->find('all')->where(['Employees.id' => $employee_id])->count();
                    if ($employee_id_exists == 1) {
                        $students = $this->Students->find()->select(['id', 'enroll', 'fname', 'middlename', 'lname', 'acedmicyear', 'rf_id'])
                            ->where(['class_id' => $class_id, 'section_id' => $section_id, 'acedmicyear' => $academic_year, 'Students.status' => 'Y'])->order(['fname' => 'ASC'])->toArray();
                        for ($i = 0; $i <= count($students); $i++) {

                            $student_id = $students[$i]['id'];
                            $attendence_status[] = $this->Studattends->find()->select(['status', 'status_m'])
                                ->where(['Studattends.stud_id' => $student_id, 'Studattends.date' => $current_date])->toArray();
                        }
                        $response["success"] = 1;
                        $response['is_attendance_updatable'] = true;
                        $response['isAttendanceTaken'] = $attn_taken;
                        $response["students"] = [];
                        $c = 0;
                        foreach ($students as $value) {
                            $connss = ConnectionManager::get('default');

                            $studentrfidsd = $connss->execute("SELECT * FROM `attendreports` WHERE rfid='" . $value['rf_id'] . "' AND DATE(resultdate)='" . date('Y-m-d') . "'");

                            $studentrfidsd = $studentrfidsd->fetchAll('assoc');
                            if ($studentrfidsd[0]['id']) {

                                $statushd = "P";
                            } else {

                                $statushd = "A";
                            }
                            // $output['class_id'] = $class_id;
                            // $output['section_id'] = $section_id;
                            $output['student_id'] = $value['id'];
                            $output['enroll'] = $value['enroll'];
                            $output['name'] = ucwords(strtolower($value['fname'])) . ' ' . ucwords(strtolower($value['middlename'])) . ' ' . ucwords(strtolower($value['lname']));

                            $output['academic_year'] = $value['acedmicyear'];
                            $output['attendence_status'] = $attendence_status[$c][0]['status'];
                            $output['attendence_statusmachine'] = $statushd;
                            array_push($response["students"], $output);
                            $c++;
                        }

                        echo json_encode($response);
                    } else {
                        $response["success"] = 0;
                        $response["message"] = "You Are Not A Registered Employee";
                        echo json_encode($response);
                    }
                } else {
                    $response["employee_id"] = $employee_id;
                    $response["class_id"] = $class_id;

                    $response["section_id"] = $section_id;
                    $response["academic"] = $academic_year;
                    $response["message"] = "Invalid Post parameters.";
                    echo json_encode($response);
                }
            } else {
                $response["success"] = 1;
                $response['is_attendance_updatable'] = false;
                if ($this->request->is(['post', 'put'])) {
                    $req_data = $this->request->data;
                    $cid = $postData->class_id;
                    $sid = $postData->section_id;
                    $tid = $postData->teacher_id;
                    $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
                    $acedmic = $users['academic_year'];
                    $dat = date('Y-m-d');
                    $stu_atn_status = $this->Studattends->find('all')->select(['stud_id', 'remark'])->where(['Studattends.class_id' => $cid, 'Studattends.section_id' => $sid, 'Studattends.date' => $dat])->count();
                    if ($stu_atn_status > 0) {

                        $response['isAttendanceTaken'] = true;
                        $response['absentStudents'] = [];
                        $absent_stu_details = $this->Studattends->find('all')->select(['stud_id', 'remark'])->where(['Studattends.class_id' => $cid, 'Studattends.section_id' => $sid, 'Studattends.status' => 'A', 'Studattends.date' => $dat])->toArray();
                        if (!empty($absent_stu_details)) {

                            foreach ($absent_stu_details as $key => $value) {
                                $stu_details = $this->Students->find('all')->select(['fname', 'middlename', 'lname', 'enroll'])->where(['Students.id' => $value['stud_id'], 'Students.status' => 'Y', 'Students.acedmicyear' => $acedmic])->first();
                                if (empty($stu_details)) {
                                    $stu_details = $this->DropOutStudent->find('all')->select(['fname', 'middlename', 'lname', 'enroll'])->where(['DropOutStudent.s_id' => $value['stud_id'], 'DropOutStudent.status' => 'Y', 'DropOutStudent.acedmicyear' => $acedmic])->first();
                                }
                                $response['absentStudents'][] = [
                                    'studentname' => $stu_details['fname'] . ' ' . $stu_details['middlename'] . ' ' . $stu_details['lname'],
                                    "rollno" => $stu_details['enroll'],
                                    "reason" => $value['remark'],
                                ];
                            }
                            echo json_encode($response);
                        } else {
                            $response["success"] = 0;
                            $response["message"] = "No Absent Students.";
                            echo json_encode($response);
                        }
                    } else {
                        $response["success"] = 1;
                        $response['isAttendanceTaken'] = false;
                        $response["message"] = "Attendance not taken!";
                        echo json_encode($response);
                    }
                }
            }
        }
    }

    /***************************************************** This api is used for Update Student Attendence   ***************************/
    public function updateStudentAttendance()
    {
        // echo "Rupam";die;
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {

            $postData = $this->dPayload($jsonData);
            $employee_id = $postData->employee_id;
            $class_id = $postData->class_id;
            $section_id = $postData->section_id;
            $idsprimeID = $postData->idsprimeID;
            if (empty($employee_id) || empty($class_id) || empty($section_id) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $response = [];

            $absent_students = $postData->absent_students; //$req_data['absent_students'];
            $present_students = $postData->present_students; //$req_data['present_students'];

            // ------------------------------------------------- //

            $current_month = date('m');
            $current_date = date('Y-m-d');

            if ($current_month >= '04') {
                $academic_year = date('Y') . '-' . (date('y') + 1);
            } else {
                $academic_year = (date('Y') - 1) . '-' . date('y');
            }
            if (!empty($absent_students || $present_students) && !empty($employee_id) && !empty($class_id) && !empty($section_id) && !empty($academic_year)) {

                $conn = ConnectionManager::get('default');

                $conn->execute("DELETE FROM studattends WHERE  class_id='" . $class_id . "' AND section_id='" . $section_id . "' AND date='" . date('Y-m-d') . "'");

                //---------------------------------------------------

                $peopleTable = TableRegistry::get('Studattends');
                $oquery = $peopleTable->query();

                $current_day = date('l');
                $current_date = date('Y-m-d');

                // Save Present

                if (!empty($present_students)) {

                    $present_students = explode(',', $present_students);
                    $statush = "";
                    $myid = "";
                    foreach ($present_students as $student_id) {

                        //$myid = $this->getId(trim($class_id), trim($section_id), trim($student_id));
                        $statush = $this->getMachineStatus($class_id, $section_id, $student_id);

                        $oquery->insert(['stud_id', 'day', 'date', 'status', 'status_m', 'acedemic', 'class_id', 'section_id'])->values([
                            'stud_id' => $student_id,
                            'day' => $current_day,
                            'date' => $current_date,
                            'status' => 'P',
                            'status_m' => $statush,
                            'acedemic' => $academic_year,
                            'class_id' => $class_id,
                            'section_id' => $section_id,
                        ]);
                    }
                }
                // Save Absent
                if (!empty($absent_students)) {
                    $absent_students = explode(',', $absent_students);
                    $status = "";
                    foreach ($absent_students as $student_id) {

                        //$myid = $this->getId(trim($class_id), trim($section_id), trim($student_id));
                        $status = $this->getMachineStatus($class_id, $section_id, $student_id);
                        $oquery->insert(['stud_id', 'day', 'remark', 'date', 'status', 'status_m', 'acedemic', 'class_id', 'section_id'])->values([
                            'stud_id' => $student_id,
                            'day' => $current_day,
                            'remark' => $iteam,
                            'date' => $current_date,
                            'status' => 'A',
                            'status_m' => $status,
                            'acedemic' => $academic_year,
                            'class_id' => $class_id,
                            'section_id' => $section_id,
                        ]);
                    }
                }
                $query_status = $oquery->execute();

                //--------------------------------------------

                if ($query_status) {
                    $response["success"] = 1;
                    $response["message"] = "Attendance updated successfully";

                    echo json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "Attendance update failed.";

                    echo json_encode($response);
                }
            } else {
                $response["message"] = "Invalid Post parameters.";
                echo json_encode($response);
            }
        }
    }

    /***************************************************** This api is used for view StudentList*******************************/

    public function studentList()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $employee_id = $postData->teacher_id;
            $class_id = $postData->class_id;
            $section_id = $postData->section_id;
            $idsprimeID = $postData->idsprimeID;
            if (empty($class_id) || empty($section_id) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $this->loadModel('Users');
            $atime = $this->Users->find('all')->select(['attendenceupdate'])->where(['role_id' => '1'])->first();
            $current_time = date("H.i", time());
            $response = [];
            $req_data = $this->request->data;
            $dat = date('Y-m-d');

            $current_month = date('m');
            $current_date = date('Y-m-d');

            if ($current_month >= '04') {
                $academic_year = date('Y') . '-' . (date('y') + 1);
            } else {
                $academic_year = (date('Y') - 1) . '-' . date('y');
            }

            if (
                !empty($employee_id) && !empty($class_id) && !empty($section_id)
                && !empty($academic_year)
            ) {

                // $employee_id_exists = $this->Employees->find('all')->where(['Employees.id' => $employee_id])->count();
                // if ($employee_id_exists == 1) {
                $students = $this->Students->find('all')->where(['class_id' => $class_id, 'section_id' => $section_id, 'acedmicyear' => $academic_year, 'Students.status' => 'Y'])->order(['fname' => 'ASC'])->toArray();

                $response["success"] = 1;
                $response["students"] = [];
                $c = 0;
                foreach ($students as $value) {
                    $connss = ConnectionManager::get('default');
                    $output['student_id'] = $value['id'];
                    $output['enroll'] = $value['enroll'];
                    $output['name'] = ucwords(strtolower($value['fname'])) . ' ' . ucwords(strtolower($value['middlename'])) . ' ' . ucwords(strtolower($value['lname']));
                    $output['academic_year'] = $value['acedmicyear'];
                    if ($value['file']) {
                        $bordd = "";
                        $directory = SITE_URL . $idsprimeID . '_image/student/' . $bordd . $value['file'];

                        $output['studentimage'] = $directory;
                    } else {
                        $output['studentimage'] = SITE_URL . 'uploads/no-images.png';
                    }


                    array_push($response["students"], $output);
                    $c++;
                }

                echo json_encode($response);
            } else {
                $response["employee_id"] = $employee_id;
                $response["class_id"] = $class_id;

                $response["section_id"] = $section_id;
                $response["academic"] = $academic_year;
                $response["message"] = "Invalid Post parameters.";
                echo json_encode($response);
            }
        }
    }

    /***************************************************** This api is used for student upload image******************************/

    public function studentuploadimage()
    {
        $this->autoRender = false;
        $student_id = $this->request->data['student_id'];
        $idsprimeID = $this->request->data['idsprimeID'];
        if (empty($student_id) || empty($idsprimeID)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Parameter";
            echo json_encode($response);
            return;
        }
        $this->db($idsprimeID);
        $this->loadModel('Students');
        $response = [];
        $filename = $_FILES['file']['name'];
        $tmp =  $_FILES['file']['tmp_name'];
        $ext = end(explode('.', $filename));
        $bordd = '';

        // $students = $this->Students->find('all')->where(['Students.id' => $student_id, 'Students.status' => 'Y'])->first();


        // if ($students) {

        //     $imagename = $bordd . $students['enroll'] . strtotime("now") . "." . $ext;
        //     $filePath_normal = WWW_ROOT . $idsprimeID . '_image/student/' . $imagename;
        //      $filePathh_thumbnail = WWW_ROOT . $idsprimeID . '_image/thumbnailstudent/';
        //     if ($filename = $_FILES['file']['name'] != '') {
        //          unlink(WWW_ROOT . $idsprimeID . '_image/student/' . $students['file']);
        //     //     if(move_uploaded_file($tmp, $filePath_normal)){
        //     //         $this->request->data['file'] = $imagename;
        //     //         //copy($filePath_normal, $another_new_dest);
        //     // }
        //     $galls = $this->move_images($_FILES['file'],$filePath_normal);
        //      // pr($galls); die;
        //     // $this->upload_images($galls[0],array(400,400),$filePathh_thumbnail);
        //     // $this->unlink_images($galls[0]);

        //     } else {
        //         $this->request->data['file'] = $students['file'];
        //     }
        //     $student_update = $this->Students->patchEntity($students, $this->request->data);
        //     $this->Students->save($student_update);
        /// image upload time validation 

        $created_datesss   = date('Y-m-d', strtotime($students['created'] . ' + 365 days'));
        $created_date   = date('Y-m-d', strtotime($students['created']));
        if ($created_datesss <= $created_date) {

            $students = $this->Students->find('all')->where(['Students.id' => $student_id, 'Students.status' => 'Y'])->first();
            if ($students) {
                $imagename = $bordd . $students['enroll'] . strtotime("now") . "." . $ext;
                $filePath = WWW_ROOT . $idsprimeID . '_image/student/' . $imagename;
                if ($filename = $_FILES['file']['name'] != '') {
                    unlink(WWW_ROOT . $idsprimeID . '_image/student/' . $students['file']);
                    move_uploaded_file($tmp, $filePath);
                    $this->request->data['file'] = $imagename;
                } else {
                    $this->request->data['file'] = $students['file'];
                }
                $student_update = $this->Students->patchEntity($students, $this->request->data);
                $this->Students->save($student_update);


                $response["success"] = 1;
                $response["message"] = "image uploaded successfully";
                echo json_encode($response);
                die;
            } else {
                $response["success"] = 0;
                $response["message"] = "Student record not available";
                echo json_encode($response);
                die;
            }
        } else {

            $response["success"] = 0;
            $response["message"] = "Contact to administrator";
            echo json_encode($response);
            die;
        }
    }

    /*****************************************************  This api is used for view assignment *****************************************************/
    public function fetchassignment()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $jsonData = $this->request->input('json_decode');
            $postData = $this->dPayload($jsonData);
            //pr($this->request->data['empId']); die;
            $employee_id = $postData->employee_id;
            $idsprimeID = $postData->idsprimeID;
            $date = $postData->date;

            if (empty($employee_id) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Paameters";
                return;
            }
            $this->db($idsprimeID);
            $this->loadmodel('Assignments');
            $this->loadmodel('Users');
            $this->loadmodel('Employees');


            $this->autoRender = false;
            $response = [];
            if ($date) {
                $teacher = $this->Employees->find('all')->where(['Employees.id' => $employee_id])->first();
                $employee_id_exists = $this->Assignments->find('all')->where(['Assignments.teacher_id' => $employee_id, 'Assignments.allocate_date' => date('Y-m-d', strtotime($date))])->count();
            } else {
                $teacher = $this->Employees->find('all')->where(['Employees.id' => $employee_id])->first();
                $employee_id_exists = $this->Assignments->find('all')->where(['Assignments.teacher_id' => $employee_id])->count();
            }

            if ($employee_id_exists > 0) {
                if ($date) {
                    $employee_id_exists = $this->Assignments->find('all')->where(['Assignments.teacher_id' => $employee_id, 'Assignments.allocate_date' => date('Y-m-d', strtotime($date))])->order(['Assignments.id' => 'DESC'])->toarray();
                } else {
                    $employee_id_exists = $this->Assignments->find('all')->where(['Assignments.teacher_id' => $employee_id])->order(['Assignments.id' => 'DESC'])->toarray();
                }
                $response["success"] = 1;
                $response["output"] = [];
                $c = 0;
                foreach ($employee_id_exists as $value) {
                    $class_id = $this->findclass($value['class_id']);
                    $section_id = $this->findsections($value['section_id']);
                    $subject_id = $this->findsubject($value['subject_id']);

                    $output['assignment_id'] = $value['id'];
                    $output['classname'] = $class_id['title'];
                    $output['sectionname'] = $section_id['title'];
                    $output['subject'] = $subject_id['name'];
                    $output['classid'] = $value['class_id'];
                    $output['sectionid'] = $value['section_id'];
                    $output['subid'] = $value['subject_id'];
                    $output['description'] = trim($value['description']);
                    $output['end_date'] = date('d-m-Y', strtotime($value['due_date']));
                    $output['createDate'] = date('d-m-Y', strtotime($value['created']));
                    $output['teacherName'] = ucwords(strtolower($teacher['fname'] . ' ' . $teacher['middlename'] . ' ' . $teacher['lname']));

                    if (!empty($value['file'])) {
                        $db = $this->Users->find()->where(['role_id' => 1])->first();
                        //$filename = IMAGE_URL . $db['db'] . 'img/' . $value['file'];
                        $filename = WWW_ROOT . $idsprimeID . '_image/' . $value['file'];

                        $file_headers = @get_headers($filename);

                        if ($file_headers && strpos($file_headers[0], '200 OK')) {
                            $output['file'] = $filename;
                        } else {
                            $output['file'] = SITE_URL . $idsprimeID . "_image/" . $value['file'];
                        }

                        $output['file_exist'] = '1';
                    } else {
                        $output['file'] = null;
                        $output['file_exist'] = '0';
                    }
                    array_push($response["output"], $output);
                }
                echo json_encode($response, JSON_UNESCAPED_SLASHES);
            } else {

                $response["success"] = 1;
                $response["output"] = null;
                $response["message"] = "You have not assigned any assignment";
                echo json_encode($response, JSON_UNESCAPED_SLASHES);
            }
        }
    }
    /*****************************************************  This api used add assignment *****************************************************/

    public function classsections()
    {

        $this->autoRender = false;
        $response = array();
        $idsprimeID = $this->request->data['idsprimeID'];
        //pr($idsprimeID); die;
        $this->db($idsprimeID);
        $class = $this->Classes->find('all')->order(['sort' => 'Asc'])->toArray();
        $section = $this->Sections->find('all')->order(['title' => 'Asc'])->toArray();

        foreach ($class as $value) { //pr($value);
            $class_data['id'] = $value['id'];
            $class_data['name'] = $value['title'];
            $classall_data[] = $class_data;
        }
        foreach ($section as $secvalue) {  //pr($secvalue);
            $section_data['id'] = $secvalue['id'];
            $section_data['name'] = $secvalue['title'];
            $sectionall_data[] = $section_data;
        }

        if ($class && $section) {
            $response["success"] = 1;
            $response["classes"] = $classall_data;
            $response["sections"] = $sectionall_data;
            echo json_encode($response);
            die;
        } else {
            $response["success"] = 0;
            $response["message"] = "No Data Available";
            echo json_encode($response);
            die;
        }
    }

    /*****************************************************  This api used add assignment *****************************************************/

    // this API used for add assignment ( Staff Side )
    public function addassignment()
    {

        $this->autoRender = false;
        $response = [];
        $current_month = date('m');
        if ($current_month >= 03) {
            $current_year = date('Y');
            $next_year = date('y') + 1;
        } else {
            $current_year = date('Y') - 1;
            $next_year = date('y');
        }

        $jsonData = $this->request->input('json_decode');
        $postData = $this->dPayload($jsonData);
        // pr($this->request->data);
        // exit;
        $req_data = $this->request->data();
        $idsprimeID = $req_data['idsprimeID'];
        $this->db($idsprimeID);

        if ($this->request->is(['post', 'put'])) {
            // Ramesh code 28-03-2023
            if ($this->request->data['file']['size'] >= 2097152) {
                $response["success"] = 0;
                $response["message"] = "Please upload file less then 2 MB";
                echo json_encode($response);
                return;
            }

            $req_data = $req_data;
            $name = $req_data["name"];
            $description = $req_data["description"];
            $academic_year = $current_year . "-" . $next_year;
            $teacher_id = $req_data["teacher_id"];
            $class_id = $req_data["class_id"];
            $section_id = $req_data["section_id"];
            $subject_id = $req_data["subject_id"];
            $allocate_date = date('Y-m-d');
            $due_date = date('Y-m-d', strtotime($req_data["due_date"]));

            if (($req_data['file']['name'])) {
                $filename = $req_data['file']['name'];
                $item = $req_data['file']['tmp_name'];
                $ext = end(explode('.', $filename));
                $names = md5(time($filename));
                $imagename = $names . '.' . $ext;

                //  $filePath = WWW_URL .$idsprimeID.'_image/' . $imagename;
                $filePath = WWW_ROOT . $idsprimeID . '_image/' . $imagename;

                if (move_uploaded_file($item, $filePath)) {
                }
                //         $data = array();
                //         $data['type'] = "sanskarimg";
                //         $data['file'] = $imagename;
                //         $data['types'] = $_FILES['file']['type'];
                //         $ext = pathinfo($data['file'], PATHINFO_EXTENSION);
                //         $data['ext'] = $ext;
                //         $http = new Client();

                //         $responser = $http->post('https://bucket.idsprime.com/Pages/uploadidsprimeassignment', $data);

                //         if (strpos($responser->body, '<!DOCTYPE html>') === false && strpos($responser->body, 'Invalid') === false) {
                //             $files = $responser->body;
                //             unlink($filePath);
                //         } else {

                //             $files = "";
                //         }
                //     } else {
                //         $files = "";
                //     }
                // } else {

                //     $files = "";


                $peopleTable = TableRegistry::get('Assignments');
                $oquery = $peopleTable->query();
                $oquery->insert(['name', 'description', 'academic_year', 'teacher_id', 'class_id', 'section_id', 'subject_id', 'allocate_date', 'due_date', 'file'])->values([
                    'name' => $name,
                    'description' => $description,
                    'academic_year' => $academic_year,
                    'teacher_id' => $teacher_id,
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    'allocate_date' => $allocate_date,
                    'due_date' => $due_date,
                    'file' => $imagename,
                ]);
                $query_status = $oquery->execute();
                if ($query_status) {
                    $response["success"] = 1;
                    $response["message"] = "Assignment added successfully.";

                    echo json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "Assignment not added.";

                    echo json_encode($response);
                }
            } else {
                $response["message"] = "No Value Assign in Post";
                echo json_encode($response);
            }
            die;
        }
    }

    /*****************************************************  This api used for book request in library *****************************************************/

    public function findbookid($id)
    {
        $articles = TableRegistry::get('BookCopyDetail');
        return $articles->find('all')->select(['book_id'])->where(['BookCopyDetail.id' => $id])->toArray();
    }


    public function findbook($id)
    {
        $articles = TableRegistry::get('Book');
        return $articles->find('all')->select(['name'])->where(['Book.id' => $id])->toArray();
    }

    // this is used for show data in Library request
    public function bookRequestList()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);

            $userId = $postData->userId;
            $idsprimeID = $postData->idsprimeID;
            $this->db($idsprimeID);
            if (empty($idsprimeID) || empty($userId)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }
            $this->loadModel('BookRequest');
            $this->loadModel('Book');
            $stud_id = $userId;
            $users = $this->Users->find('all')->where(['Users.role_id' => '1', 'db' => $idsprimeID])->first();

            $acedmicyear = $users['academic_year'];

            $acd = explode('-', $acedmicyear);

            $fromyear = $acd[0] . "-04-01";
            $toyear = ($acd[0] + 1) . "-03-31";

            $books = $this->BookRequest->find('all')->where(['BookRequest.stud_id' => $stud_id, 'DATE(created) >=' => $fromyear, 'DATE(created) <=' => $toyear, 'status <>' => 'approved'])->order(['created' => 'DESC'])->toarray();

            if (!empty($books)) {

                $response = array();
                $response['success'] = 1;
                $response['output'] = array();
                foreach ($books as $book) {
                    $data = array();
                    $data['bookRequestId'] = $book['id'];
                    $bookDet = $this->Book->find('all')->contain(['BookCategory'])->where(['Book.id' => $book['book_id']])->first();
                    $data['bookCategory'] = ucwords(strtolower($bookDet['book_category']['name']));
                    $data['bookName'] = ucwords(strtolower($bookDet['name']));
                    $data['AuthorName'] = ucwords(strtolower($bookDet['author']));
                    $data['status'] = ucwords($book['status']);
                    $data['requestDate'] = date('d-m-Y', strtotime($book['created']));
                    $response['output'][] = $data;
                }
                echo json_encode($response);
                return;
            } else {
                $response['success'] = 0;
                $response["output"] = null;
                $response['message'] = "No Book Request Found";
                echo json_encode($response);
                return;
            }
        }
    }

    /*****************************************************  This api used for view teacher date sheet ***********************************/

    public function teacher_datesheet()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $id = $postData->teacherId;
            $idsprimeID = $postData->idsprimeID;

            if (empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $this->loadModel('Datesheet');
            $this->loadModel('classections');

            $emp_det = $this->classections->find('all')->where(['FIND_IN_SET(\'' . $id . '\',classections.teacher_id)'])->group(['class_id'])->toarray();

            if (!empty($emp_det)) {
                $cond['success'] = 0;
                $response = array();

                $date = date('Y-m-d');
                $sheet = $this->Datesheet->find('all')->where(['end_date >=' => $date])->toarray();

                if (!empty($sheet)) {
                    foreach ($sheet as $values) {
                        foreach ($emp_det as $det) {

                            $class_id = $det['class_id'];
                            $output = array();
                            $classes = explode(',', $values['class_id']);
                            if (in_array($class_id, $classes)) {
                                $cond['success'] = 1;
                                $output['title'] = ucwords($values['title']);
                                $output['start_date'] = date('d-m-Y', strtotime($values['start_date']));
                                $output['end_date'] = date('d-m-Y', strtotime($values['end_date']));

                                $db = $this->Users->find()->where(['role_id' => 1])->first();
                                // $filename = IMAGE_URL . $db['db'] . 'img/' . $values['sheet_name'];
                                $filename = SITE_URL  . 'img/' . $values['sheet_name'];

                                $file_headers = @get_headers($filename);

                                if ($file_headers && strpos($file_headers[0], '200 OK')) {
                                    $output['url'] = $filename;
                                } else {
                                    // $output['url'] = SITE_URL . "datesheets/" . $values['sheet_name'];
                                    $output['url'] = SITE_URL  . 'img/' . $values['sheet_name'];
                                }
                                $response['success'] = 1;
                                $response['dateSheet'][] = $output;
                                break;
                            }
                        }
                    }
                }
                if ($cond['success'] == 0) {
                    $response['success'] = 1;
                    $response['dateSheet'] = null;
                    $response['message'] = "No Data Available";
                    echo json_encode($response);
                } else {
                    echo json_encode($response);
                }
            } else {
                $response['success'] = 0;
                $response['message'] = "Your are not a registered user";
                echo json_encode($response);
            }
        }
    }
    /************************************************************************************
     ******************Staff Api's End***********************************************/


    /************************************************************************************
     ******************Admin Api's Start***********************************************/
    /*
1. passwordLogin
2. slider
3. schooldetails
4. classsections //Student Summary
5. classsectionsWiseStudent //Student Summary
4. getStudentInfo
5. reportStudentDetails
6. attendanceStudentDetails
7. adminTeacherAttendnce
8. adminStudentAttendance
9. allfetchassignments
10.teacherDetails 
11.adminFeesCollection
12.adminClassTimetableList
13.teacherTimeTable
14.notifications 
15.firebaseNotification
16. adminLibraryData
17. viewevents
18. eventtype 
19. adminDatesheet
20. visitors
21. feedback
22. viewfeedback
23. feedbackcategories
24. photoGallery
25. leadManagment
26. getfollowupDetails
27. getprospectusDetails
28. getadmissionDetails
*/


    /**********************************************  This api is used for get all school details (School Profile) ****************************/

    public function schooldetails()
    {

        $idsprimeID = $this->request->data['idsprimeID'];
        $this->db($idsprimeID);

        $this->loadmodel('Students');
        $this->loadmodel('DropOutStudent');
        $this->loadmodel('DropOutEmployee');
        $this->loadmodel('Employees');
        $this->loadmodel('Studattends');
        $this->loadmodel('Sitesettings');
        $this->loadmodel('SitesettingsDetails');
        $this->autoRender = false;
        $sitesettings = $this->Sitesettings->find()->order(['id' => 'DESC'])->first();
        $sitesettings_details = $this->SitesettingsDetails->find()->order(['id' => 'DESC'])->first();
        $studentboys = $this->Students->find()->Where(['Students.gender IN' => ['M', 'Male'], 'status' => 'Y', 'acedmicyear' => '2023-24'])->order(['id' => 'DESC'])->count();
        $studentgirls = $this->Students->find()->Where(['Students.gender IN' => ['female', 'F', 'Female'], 'status' => 'Y', 'acedmicyear' => '2023-24'])->order(['id' => 'DESC'])->count();
        //sanjay code
        $emptech = $this->Employees->find()->Where(['Employees.p_department' => 2, 'Employees.status' => 'Y'])->count();

        $empcount = $this->Employees->find()->Where(['Employees.status' => 'Y'])->count();


        $empnontech = $this->Employees->find()->Where(['Employees.p_department' => 1, 'Employees.status' => 'Y'])->count();

        $current_date = date('Y-m-d');

        $attendence_status = $this->Studattends->find()->where(['Studattends.status' => 'P', 'Studattends.date' => $current_date])->count();

        $students_active = $this->Studattends->find()->where(['Studattends.status' => 'A', 'Studattends.date' => $current_date])->count();

        $empactive = $this->Employeeattendance->find()->Where(['Employeeattendance.status' => 'A', 'Employeeattendance.date' => $current_date])->count();

        $empinactive = $this->Employeeattendance->find()->Where(['Employeeattendance.status' => 'P', 'Employeeattendance.date' => $current_date])->count();


        //Active
        $student = $this->Students->find()->where(['status' => 'Y', 'acedmicyear' => '2023-24'])->count();
        $empcount_teaching = $this->Employees->find()->Where(['Employees.p_department' => '1', 'Employees.status' => 'Y'])->count();
        $empcount_nonteaching = $this->Employees->find()->Where(['Employees.p_department !=' => '1', 'Employees.status' => 'Y'])->count();

        //Inactive
        $dropoutstudent = $this->DropOutStudent->find('all')->count();

        // $dropoutemployee_teaching = $this->DropOutEmployee->find('all')->Where(['DropOutEmployee.p_department' => '1','DropOutEmployee.status' =>'Y'])->count();

        // $dropoutemployee_nonteaching = $this->DropOutEmployee->find('all')->Where(['DropOutEmployee.p_department !=' => '1','DropOutEmployee.status' =>'Y'])->count();

        $dropoutemployee_teaching = $this->Employees->find()->Where(['Employees.p_department' => 1, 'Employees.status' => 'N'])->count();

        $dropoutemployee_nonteaching = $this->Employees->find()->Where(['Employees.p_department' => 2, 'Employees.status' => 'N'])->count();

        if ($empcount) {
            $school_details['totalStaff'] = $empcount;
        } else {
            $school_details['totalStaff'] = '0';
        }

        if ($emptech) {
            $school_details['totalTeaching'] = $emptech;
        } else {
            $school_details['totalTeaching'] = '0';
        }


        if ($empnontech) {
            $school_details['totalNonTeaching'] = $empnontech;
        } else {

            $school_details['totalNonTeaching'] = '0';
        }


        if ($student) {
            $school_details['totalStudents'] = $student;
        } else {
            $school_details['totalStudents'] = '0';
        }

        if ($studentboys) {

            $school_details['totalBoys'] = $studentboys;
        } else {

            $school_details['totalBoys'] = '0';
        }

        if ($studentgirls) {

            $school_details['totalGirls'] = $studentgirls;
        } else {

            $school_details['totalGirls'] = '0';
        }

        if ($student) {

            $school_details['totalActiveStudents'] = $student;
        } else {

            $school_details['totalActiveStudents'] = '0';
        }

        if ($empcount_teaching) {
            $school_details['totalActiveTeaching'] = $empcount_teaching;
        } else {
            $school_details['totalActiveTeaching'] = '0';
        }

        if ($empcount_nonteaching) {
            $school_details['totalActiveNonteaching'] = $empcount_nonteaching;
        } else {
            $school_details['totalActiveNonteaching'] = '0';
        }

        if ($dropoutstudent) {
            $school_details['totalInactiveStudents'] = $dropoutstudent;
        } else {
            $school_details['totalInactiveStudents'] = '0';
        }


        if ($dropoutemployee_teaching) {

            $school_details['totalInactiveTeaching'] = $dropoutemployee_teaching;
        } else {
            $school_details['totalInactiveTeaching'] = '0';
        }

        if ($dropoutemployee_nonteaching) {
            $school_details['totalInactiveNonTeaching'] = $dropoutemployee_nonteaching;
        } else {

            $school_details['totalInactiveNonTeaching'] = '0';
        }


        if ($sitesettings_details['email']) {
            $school_details['contactEmail'] = $sitesettings_details['email'];
        } else {
            $school_details['contactEmail'] = 'N/A';
        }

        if ($sitesettings_details['phone']) {

            $school_details['contactphone'] = $sitesettings_details['phone'];
        } else {

            $school_details['contactphone'] = 'N/A';
        }


        if ($sitesettings_details['school_code']) {

            $school_details['schoolCode'] = $sitesettings_details['school_code'];
        } else {

            $school_details['schoolCode'] = 'N/A';
        }

        if ($sitesettings_details['address1']) {

            $school_details['address'] = $sitesettings_details['address1'];
        } else {

            $school_details['address'] = 'N/A';
        }


        if ($sitesettings_details['address2']) {

            $school_details['address2'] = $sitesettings_details['address2'];
        } else {

            $school_details['address2'] = 'N/A';
        }


        // if($student){
        $response["success"] = 1;
        $response["schooldetails"] =  $school_details;
        // }else{
        //     $response["success"] = 0;
        //     $response["message"] = "Invalid Data";
        // }


        echo json_encode($response);
    }


    /*****************************************************  This api is used for student summary **********************************************************/

    public function classsectionsWiseStudent()
    {
        $this->autoRender = false;
        $response = array();
        $classID = $this->request->data['classID'];
        $sectionID = $this->request->data['sectionID'];
        $idsprimeID = $this->request->data['idsprimeID'];
        $this->db($idsprimeID);
        $this->loadmodel('Students');
        $students = $this->Students->find('all')->where(['Students.class_id' => $classID, 'Students.section_id' => $sectionID])->toarray();

        foreach ($students as $value) {
            $studentdata['id'] = $value['id'];
            $studentdata['name'] = $value['fname'] . " " . $value['lname'];
            $studentall_data[] = $studentdata;
        }
        if ($studentall_data) {
            $response["success"] = 1;
            $response["students"] = $studentall_data;

            echo json_encode($response);
            die;
        } else {
            $response["success"] = 0;
            $response["message"] = "No Students";
            echo json_encode($response);
            die;
        }
    }


    /*****************************************************  This api used for report card result in admin side *****************************************************/
    public function reportStudentDetails()
    {
        $this->autoRender = false;
        $response = array();
        $studentID = $this->request->data['studentID'];
        $idsprimeID = $this->request->data['idsprimeID'];
        $this->db($idsprimeID);
        $this->loadmodel('Students');
        $this->loadmodel('Studentexamresult');


        $student_exam_result = $this->Studentexamresult->find('all')->contain(['Exams'])->where(['Studentexamresult.stud_id' => $studentID])->first();
        $examfind = $this->Exams->find('all')->where(['Exams.id' => $student_exam_result['exam_id'], 'Exams.acedamicyear' => $student['acedmicyear']])->order(['Exams.id' => 'DESC'])->first();


        $result_data['name'] = "term1";
        $result_data['reslut_upload_date'] = date('d-m-Y');
        $result_data['result_link'] = SITE_URL . 'vatsal_canvas.pdf';

        $result_data_2['name'] = "term2";
        $result_data_2['reslut_upload_date'] = date('d-m-Y');
        $result_data_2['result_link'] = SITE_URL . 'vatsal_canvas.pdf';

        $result_alldata = array(
            $result_data,
            $result_data_2
        );

        // pr($examfind); 
        // pr($student_exam_result);
        if ($result_alldata) {
            $response["success"] = 1;
            $response["results"] = $result_alldata;

            echo json_encode($response);
            die;
        } else {
            $response["success"] = 0;
            $response["message"] = "No Results";
            echo json_encode($response);
            die;
        }
    }


    /***************************************************** This api used for student attendance result in admin side *****************************************************/

    public function attendanceStudentDetails()
    {
        $this->autoRender = false;
        $response = array();
        $studentID = $this->request->data['studentID'];
        $idsprimeID = $this->request->data['idsprimeID'];
        $this->db($idsprimeID);
        $this->loadmodel('Students');
        $this->loadmodel('Studattends');

        $year = date('Y');
        $month = date('m');
        $students = $this->Students->find('all')->where(['Students.id' => $studentID])->first();
        for ($x = 1; $x <= 12; $x++) {
            $month_num = $x;
            $month_name = date("F", mktime(0, 0, 0, $month_num, 10));

            $student_attendance_jan = $this->Studattends->find('all')->where(['Studattends.stud_id' => $studentID, 'Studattends.status' => 'P', 'MONTH(Studattends.date)' => $x, 'YEAR(Studattends.date)' => $year])->Count();

            $absent_attendance_jan = $this->Studattends->find('all')->where(['Studattends.stud_id' => $studentID, 'Studattends.status' => 'A', 'MONTH(Studattends.date)' => $x, 'YEAR(Studattends.date)' => $year])->Count();

            $attendance_data['month'] = $month_name;
            $attendance_data['present'] = $student_attendance_jan;
            $attendance_data['absent'] = $absent_attendance_jan;
            $attendanceall_data[] =  $attendance_data;
        }

        if ($students) {
            $response["success"] = 1;
            $response["attendancedetails"] = $attendanceall_data;
            echo json_encode($response);
            die;
        } else {
            $response["success"] = 0;
            $response["message"] = "No Students";
            echo json_encode($response);
            die;
        }
    }


    /*****************************************************  This api used add staff attendance *****************************************************/
    public function adminTeacherAttendnce()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $userId = $postData->userId;
            $idsprimeID = $postData->idsprimeID;
            $this->db($idsprimeID);
            $this->loadModel('Staffattends');
            $this->loadModel('Users');
            if (empty($idsprimeID) || empty($userId)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }
            //$users=$this->Users->find('all')->where(['Users.role_id' => '1'])->first();

            $users = $this->Users->find()->where(['id' => $userId, 'is_admin' => 'Y'])->first();
            //pr($users);
            if (empty($users)) {
                $response['success'] = 0;
                $response['message'] = "Invalid UserId";
                echo json_encode($response);
                die;
            }
            $today = date('Y-m-d');
            $rt = date('Y-m-d');
            $acedmi = $users['academic_year'];
            //$today = "2019-10-01";  
            //$absentees = $this->Employeeattendance->find('list', ['keyField' => 'id', 'valueField' => 'employee_id'])->where(['DATE(date)' => $today, 'status <>' => 'SL'])->toarray();
            $absentees = $this->Staffattends->find('all')->contain(['Employees'])->where(['Staffattends.date' => $rt, 'Staffattends.acedemic' => $acedmi, 'Staffattends.status' => 'A'])->order(['Staffattends.id' => 'ASC'])->toArray();
            if (empty($absentees)) {
                $response['success'] = 0;
                $response['message'] = "No Absent Today";
                echo json_encode($response);
                die;
            }
            //pr($absentees);
            //$teachers = $this->Employees->find()->contain(['PayrollDesignations'])->where(['Employees.is_drop' => 'N', 'PayrollDesignations.is_teacher' => 'Y', 'Employees.id IN' => $absentees])->toarray();

            $response['success'] = 1;
            $response['output']['attendanceTime'] = $users['attendenceupdate'];
            $response['output']['teacherInfo'] = [];
            foreach ($absentees as $teacher) { //pr($teacher);
                $data = [];
                $data['name'] = $teacher['employee']['fname'] . " " . $teacher['employee']['lname'];
                $data['mobile'] = $teacher['employee']['mobile'];;
                $response['output']['teacherInfo'][] = $data;
            }
            echo json_encode($response);
            die;
        }
    }

    /*****************************************************  This api used add student attendance *****************************************************/

    public function adminStudentAttendance()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        // pr($jsonData);
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $userId = $postData->userId;
            $idsprimeID = $postData->idsprimeID;
            $this->db($idsprimeID);
            if (empty($idsprimeID) || empty($userId)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }
            $this->loadModel('Datesheet');
            $this->loadModel('classections');
            $user = $this->Users->find()->where(['id' => $userId, 'is_admin' => 'Y'])->first();
            if (empty($user)) {
                $response['success'] = 0;
                $response['message'] = "Invalid UserId";
                echo json_encode($response);
                die;
            }
            $acedmic = $user['academic_year'];
            $classess = $this->Classections->find('all')->contain(['Classes', 'Sections'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
            $classlist = $this->Classes->find('list')->toarray();
            $sectionlist = $this->Sections->find('list')->toarray();
            if (!empty($classess)) {
                $today = date('Y-m-d');
                // $today = "2019-04-03";
                $response['success'] = 1;
                $response['output'] = [];
                $response['output']['totalStudent'] = "";
                $response['output']['totalAbsent'] = "";
                $totalStudent = 0;
                $totalAbsent = 0;
                foreach ($classess as $class) {
                    $data = [];
                    $data['class_id'] = $class['class_id'];
                    $data['section_id'] = $class['section_id'];
                    $data['class'] = $classlist[$class['class_id']] . '-' . $sectionlist[$class['section_id']];
                    $data['totalStudent'] = $this->Students->find('all')->where(['Students.status' => 'Y', 'Students.acedmicyear' => $acedmic, 'class_id' => $class['class_id'], 'section_id' => $class['section_id']])->count();

                    $data['totalPresent'] = $this->Studattends->find()->where(['status' => 'P', 'class_id' => $class['class_id'], 'section_id' => $class['section_id'], 'date' => $today])->count();
                    $data['totalAbsent'] = $this->Studattends->find()->where(['status' => 'A', 'class_id' => $class['class_id'], 'section_id' => $class['section_id'], 'date' => $today])->count();
                    $totalStudent += $data['totalStudent'];
                    $totalAbsent += $data['totalAbsent'];
                    $response['output']['classInfo'][] = $data;
                }
                $response['output']['totalStudents'] = $totalStudent;
                $response['output']['totalAbsentStudents'] = $totalAbsent;
                echo json_encode($response);
                die;
            } else {
                $response['success'] = 0;
                $response['message'] = null;
                $response['output'] = "No record found";
                echo json_encode($response);
                die;
            }
        }
    }

    public function studentattendancedetails()
    {
        $this->autoRender = false;
        $class_id = $this->request->data['classID'];
        $section_id = $this->request->data['sectionID'];
        $idsprimeID = $this->request->data['idsprimeID'];
        $teacher_id = $this->request->data['teacherID'];
        $today = date('Y-m-d');
        $this->db($idsprimeID);
        if (empty($class_id) || empty($section_id)  || empty($teacher_id)  || empty($idsprimeID)) {
            $response['success'] = 0;
            $response["message"] = "Missing parameter(s)";
            echo json_encode($response);
            return;
        }
        $student_rec = $this->Studattends->find()->where(['status' => 'A', 'class_id' => $class_id, 'section_id' => $section_id, 'date' => $today])->toarray();
        if ($student_rec) {

            foreach ($student_rec as $value) {
                $student = $this->Students->find()->Where(['Students.id' => $value['stud_id']])->order(['id' => 'DESC'])->first();
                $student_data['name'] =  $student['fname'] . " " . $student['lname'];
                $student_data['fatherName'] =  $student['fathername'];
                $student_data['fatherMobile'] =  $student['mobile'];
                $student_attendance_details[] = $student_data;
            }
            $response["success"] = 1;
            $response['attendanceDetails'] = $student_attendance_details;
            echo json_encode($response);
        } else {

            $response["success"] = 0;
            $response["message"] = "No Details";
        }
    }
    public function adminAttendanceList()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $employee_id = $postData->teacher_id;
            $class_id = $postData->class_id;
            $section_id = $postData->section_id;
            $idsprimeID = $postData->idsprimeID;
            if (empty($employee_id) || empty($class_id) || empty($section_id) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $this->loadModel('Users');
            $atime = $this->Users->find('all')->select(['attendenceupdate'])->where(['role_id' => '1'])->first();
            $current_time = date("H.i", time());
            if ($current_time <= $atime['attendenceupdate']) {

                $response = [];
                $req_data = $this->request->data;
                $dat = date('Y-m-d');
                $stu_atn_status = $this->Studattends->find('all')->where(['Studattends.class_id' => $class_id, 'Studattends.section_id' => $section_id, 'Studattends.date' => $dat])->count();
                if ($stu_atn_status > 0) {

                    $attn_taken = true;
                } else {
                    $attn_taken = false;
                }

                $current_month = date('m');
                $current_date = date('Y-m-d');

                if ($current_month >= '04') {
                    $academic_year = date('Y') . '-' . (date('y') + 1);
                } else {
                    $academic_year = (date('Y') - 1) . '-' . date('y');
                }

                if (
                    !empty($employee_id) && !empty($class_id) && !empty($section_id)
                    && !empty($academic_year)
                ) {


                    $students = $this->Students->find()->select(['id', 'enroll', 'fname', 'middlename', 'lname', 'acedmicyear', 'rf_id'])
                        ->where(['class_id' => $class_id, 'section_id' => $section_id, 'acedmicyear' => $academic_year, 'Students.status' => 'Y'])->order(['fname' => 'ASC'])->toArray();
                    for ($i = 0; $i <= count($students); $i++) {

                        $student_id = $students[$i]['id'];
                        $attendence_status[] = $this->Studattends->find()->select(['status', 'status_m'])
                            ->where(['Studattends.stud_id' => $student_id, 'Studattends.date' => $current_date])->toArray();
                    }
                    $response["success"] = 1;
                    $response['is_attendance_updatable'] = true;
                    $response['isAttendanceTaken'] = $attn_taken;
                    $response["students"] = [];
                    $c = 0;
                    foreach ($students as $value) {
                        $connss = ConnectionManager::get('default');

                        $studentrfidsd = $connss->execute("SELECT * FROM `attendreports` WHERE rfid='" . $value['rf_id'] . "' AND DATE(resultdate)='" . date('Y-m-d') . "'");

                        $studentrfidsd = $studentrfidsd->fetchAll('assoc');
                        if ($studentrfidsd[0]['id']) {

                            $statushd = "P";
                        } else {

                            $statushd = "A";
                        }
                        // $output['class_id'] = $class_id;
                        // $output['section_id'] = $section_id;
                        $output['student_id'] = $value['id'];
                        $output['enroll'] = $value['enroll'];
                        $output['name'] = ucwords(strtolower($value['fname'])) . ' ' . ucwords(strtolower($value['middlename'])) . ' ' . ucwords(strtolower($value['lname']));

                        $output['academic_year'] = $value['acedmicyear'];
                        $output['attendence_status'] = $attendence_status[$c][0]['status'];
                        $output['attendence_statusmachine'] = $statushd;
                        array_push($response["students"], $output);
                        $c++;
                    }

                    echo json_encode($response);
                } else {
                    $response["employee_id"] = $employee_id;
                    $response["class_id"] = $class_id;

                    $response["section_id"] = $section_id;
                    $response["academic"] = $academic_year;
                    $response["message"] = "Invalid Post parameters.";
                    echo json_encode($response);
                }
            } else {
                $response["success"] = 1;
                $response['is_attendance_updatable'] = false;
                if ($this->request->is(['post', 'put'])) {
                    $req_data = $this->request->data;
                    $cid = $postData->class_id;
                    $sid = $postData->section_id;
                    $tid = $postData->teacher_id;
                    $users = $this->Users->find('all')->where(['Users.id' => '1'])->first();
                    $acedmic = $users['academic_year'];
                    $dat = date('Y-m-d');
                    $stu_atn_status = $this->Studattends->find('all')->select(['stud_id', 'remark'])->where(['Studattends.class_id' => $cid, 'Studattends.section_id' => $sid, 'Studattends.date' => $dat])->count();
                    if ($stu_atn_status > 0) {

                        $response['isAttendanceTaken'] = true;
                        $response['absentStudents'] = [];
                        $absent_stu_details = $this->Studattends->find('all')->select(['stud_id', 'remark'])->where(['Studattends.class_id' => $cid, 'Studattends.section_id' => $sid, 'Studattends.status' => 'A', 'Studattends.date' => $dat])->toArray();
                        if (!empty($absent_stu_details)) {

                            foreach ($absent_stu_details as $key => $value) {
                                $stu_details = $this->Students->find('all')->select(['fname', 'middlename', 'lname', 'enroll'])->where(['Students.id' => $value['stud_id'], 'Students.status' => 'Y', 'Students.acedmicyear' => $acedmic])->first();
                                if (empty($stu_details)) {
                                    $stu_details = $this->DropOutStudent->find('all')->select(['fname', 'middlename', 'lname', 'enroll'])->where(['DropOutStudent.s_id' => $value['stud_id'], 'DropOutStudent.status' => 'Y', 'DropOutStudent.acedmicyear' => $acedmic])->first();
                                }
                                $response['absentStudents'][] = [
                                    'studentname' => $stu_details['fname'] . ' ' . $stu_details['middlename'] . ' ' . $stu_details['lname'],
                                    "rollno" => $stu_details['enroll'],
                                    "reason" => $value['remark'],
                                ];
                            }
                            echo json_encode($response);
                        } else {
                            $response["success"] = 0;
                            $response["message"] = "No Absent Students.";
                            echo json_encode($response);
                        }
                    } else {
                        $response["success"] = 1;
                        $response['isAttendanceTaken'] = false;
                        $response["message"] = "Attendance not taken!";
                        echo json_encode($response);
                    }
                }
            }
        }
    }

    // public function allfetchassignments()
    // {
    //     $this->autoRender = false;
    //     $jsonData = $this->request->input('json_decode');
    //     if (empty($jsonData)) {
    //         $response["success"] = 0;
    //         $response["message"] = "Invalid Json Data";
    //         echo json_encode($response);
    //         return;
    //     } else {
    //         $postData = $this->dPayload($jsonData);
    //         $id = $postData->id;
    //         $idsprimeID = $postData->idsprimeID;
    //         //sanjay code
    //         $classes_id = $postData->classes_id;
    //         if (empty($id) || empty($id)) {
    //             $response["success"] = 0;
    //             $response["message"] = "Invalid Parameter";
    //             echo json_encode($response);
    //             return;
    //         }
    //         $this->db($idsprimeID);
    //         $db_name = $idsprimeID;
    //         $this->loadmodel('Assignments');
    //         $this->loadmodel('Students');
    //         $this->loadmodel('Videos');
    //         $this->loadmodel('Users');
    //         $response = [];
    //         $req_data = $this->request->data;
    //         //$user = $this->Users->find()->where(['role_id' => 1])->first();
    //         $user = $this->Users->find()->where(['id' => $userId, 'is_admin' => 'Y'])->first();
    //         $academic_year = '2023-24'; //$user['academic_year']; // date('Y')."-".date('y', strtotime('+1 year'));

    //         //sanjay code
    //         $classlist = $this->Classes->find('list', ['keyField' => 'id', 'valueField' => 'title'])->where(['status' => '1'])->order(['Classes.sort' => 'Asc'])->toarray();

    //         foreach ($classlist as $key => $value) {
    //             $class['Id'] = $key;
    //             $class['Value'] = $value;
    //             $class['Name'] = $value;
    //             $classes[] = $class;
    //         }



    //         $employee_id_exists = $this->Assignments->find('all')->where(['Assignments.academic_year' => $academic_year])->count();
    //         // echo $employee_id_exists; die;
    //         $videos = $this->Videos->find('all')->where(['Videos.academic_year' => $academic_year])->toarray();
    //         if ($employee_id_exists > 0) {
    //             $response["success"] = 1;
    //             $response["output"] = [];
    //             if ($employee_id_exists > 0) {
    //                 $current_date = date("Y-m-d");
    //                 if ($classes_id) {
    //                     $employee_id_existss = $this->Assignments->find('all')->where(['Assignments.academic_year' => $academic_year, 'Assignments.allocate_date' => $current_date, 'Assignments.class_id' => $classes_id])->order(['Assignments.class_id' => 'desc'])->toarray();
    //                 } else {
    //                     $employee_id_existss = $this->Assignments->find('all')->where(['Assignments.academic_year' => $academic_year, 'Assignments.allocate_date' => $current_date])->order(['Assignments.class_id' => 'desc'])->toarray();
    //                 }
    //                 $c = 0;
    //                 foreach ($employee_id_exists as $value) {
    //                     $class_id = $this->findclass($value['class_id']);
    //                     $section_id = $this->findsections($value['section_id']);
    //                     $subject_id = $this->findsubject($value['subject_id']);

    //                     $teacher_id = $this->findteacher($value['teacher_id']);
    //                     $output['assignment_id'] = $value['id'];
    //                     $output['created'] = date('d-m-Y', strtotime($value['allocate_date']));
    //                     $output['classname'] = $class_id['title'];
    //                     $output['sectionname'] = $section_id['title'];
    //                     if ($teacher_id) {
    //                         $output['givenby'] = $teacher_id['fname'] . " " . $teacher_id['lname'];
    //                     } else {
    //                         $output['givenby'] = "Admin";
    //                     }
    //                     $output['subject'] = $subject_id['name'];
    //                     $output['classid'] = $value['class_id'];
    //                     $output['sectionid'] = $value['section_id'];
    //                     $output['subid'] = $value['subject_id'];
    //                     $output['description'] = $value['description'];
    //                     $output['end_date'] = date('d-m-Y', strtotime($value['due_date']));
    //                     if (!empty($value['file'])) {
    //                         $db = $this->Users->find()->where(['role_id' => 1])->first();
    //                         $filename = IMAGE_URL . $db . '_image/' . $value['file'];

    //                         $file_headers = @get_headers($filename);

    //                         if ($file_headers && strpos($file_headers[0], '200 OK')) {
    //                             $output['file'] = $filename;
    //                         } else {
    //                             $output['file'] = SITE_URL . $db_name . "_image/" . $value['file'];
    //                         }
    //                     } else {
    //                         $output['file'] = null;
    //                     }
    //                     array_push($response["output"], $output);
    //                 }
    //                 $response["classes"] = $classes;
    //             }
    //             if (!empty($videos)) {
    //                 foreach ($videos as $value) {
    //                     $output = [];
    //                     $class_id = $this->findclass($value['class_id']);
    //                     $section_id = $this->findsections($value['section_id']);
    //                     $subject_id = $this->findsubject($value['subject_id']);
    //                     $output['assignment_id'] = $value['id'];
    //                     $output['created'] = date('d-m-Y', strtotime($value['created']));
    //                     $output['classname'] = $class_id['title'];
    //                     $output['sectionname'] = $section_id['title'];
    //                     $output['subject'] = $subject_id['name'];
    //                     $output['classid'] = $value['class_id'];
    //                     $output['sectionid'] = $value['section_id'];
    //                     $output['subid'] = $value['subject_id'];
    //                     $output['description'] = $value['description'];
    //                     $output['end_date'] = date('d-m-Y', strtotime($value['due_date']));
    //                     if (!empty($value['video'])) {
    //                         $data['userId'] = $id;
    //                         $data['key'] = $value['video'];
    //                         $http = new Client();
    //                         $httpResponse = $http->post('http://13.235.154.210/awsvideo/Pages/videos', $data);
    //                         $url = $httpResponse->json;
    //                         $output['file'] = $url['url'];
    //                     } else {
    //                         $output['file'] = null;
    //                     }

    //                     $response["output"][] = $output;
    //                 }
    //             }
    //             echo json_encode($response, JSON_UNESCAPED_SLASHES);
    //         } else {

    //             $response["success"] = 0;
    //             $response["message"] = "Class have not assigned any assignment";
    //             echo json_encode($response, JSON_UNESCAPED_SLASHES);
    //         }
    //     }
    // }
    public function allfetchassignments()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $id = $postData->id;
            $idsprimeID = $postData->idsprimeID;
            //sanjay code
            $classes_id = $postData->classes_id;

            if (empty($id) || empty($id)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $db_name = $idsprimeID;
            $this->loadmodel('Assignments');
            $this->loadmodel('Students');
            $this->loadmodel('Videos');
            $this->loadmodel('Users');
            $response = [];
            $req_data = $this->request->data;
            $user = $this->Users->find()->where(['id' => $id, 'is_admin' => 'Y'])->first();
            $academic_year = $user['academic_year'];
            //sanjay code
            $classlist = $this->Classes->find('list', ['keyField' => 'id', 'valueField' => 'title'])->where(['status' => '1'])->order(['Classes.sort' => 'Asc'])->toarray();

            foreach ($classlist as $key => $value) {
                $class['Id'] = $key;
                $class['Value'] = $value;
                $class['Name'] = $value;
                $classes[] = $class;
            }
            //  pr($classes); die;

            $employee_id_exists = $this->Assignments->find('all')->where(['Assignments.academic_year' => $academic_year])->count();
            // echo $employee_id_exists; die;
            $videos = $this->Videos->find('all')->where(['Videos.academic_year' => $academic_year])->toarray();
            if ($employee_id_exists > 0) {
                $response["success"] = 1;
                $response["output"] = [];
                if ($employee_id_exists > 0) {

                    $current_date = date("Y-m-d");
                    if ($classes_id) {
                        $employee_id_existss = $this->Assignments->find('all')->where(['Assignments.academic_year' => $academic_year, 'Assignments.allocate_date' => $current_date, 'Assignments.class_id' => $classes_id])->order(['Assignments.class_id' => 'ASC'])->toarray();
                        // pr($employee_id_existss);exit;
                    } else {
                        $employee_id_existss = $this->Assignments->find('all')->where(['Assignments.academic_year' => $academic_year, 'Assignments.allocate_date' => $current_date])->order(['Assignments.class_id' => 'ASC'])->toarray();
                    }

                    if (empty($employee_id_existss)) {
                        $response["success"] = 0;
                        $response["message"] = "Class have not assigned any assignment";
                    }

                    $c = 0;
                    foreach ($employee_id_existss as $value) {
                        $class_id = $this->findclass($value['class_id']);
                        $section_id = $this->findsections($value['section_id']);
                        $subject_id = $this->findsubject($value['subject_id']);

                        $teacher_id = $this->findteacher($value['teacher_id']);
                        $output['assignment_id'] = $value['id'];
                        $output['created'] = date('d-m-Y', strtotime($value['allocate_date']));
                        $output['classname'] = $class_id['title'];
                        $output['sectionname'] = $section_id['title'];
                        if ($teacher_id) {
                            $output['givenby'] = $teacher_id['fname'] . " " . $teacher_id['lname'];
                        } else {
                            $output['givenby'] = "Admin";
                        }
                        $output['subject'] = $subject_id['name'];
                        $output['classid'] = $value['class_id'];
                        $output['sectionid'] = $value['section_id'];
                        $output['subid'] = $value['subject_id'];
                        $output['description'] = $value['description'];
                        $output['end_date'] = date('d-m-Y', strtotime($value['due_date']));
                        if (!empty($value['file'])) {
                            $db = $this->Users->find()->where(['role_id' => 1])->first();
                            $filename = IMAGE_URL . $db . '_image/' . $value['file'];

                            $file_headers = @get_headers($filename);

                            if ($file_headers && strpos($file_headers[0], '200 OK')) {
                                $output['file'] = $filename;
                            } else {
                                $output['file'] = SITE_URL . $db_name . "_image/" . $value['file'];
                            }
                        } else {
                            $output['file'] = null;
                        }
                        array_push($response["output"], $output);
                    }
                    $response["classes"] = $classes;
                }
                if (!empty($videos)) {
                    foreach ($videos as $value) {
                        $output = [];
                        $class_id = $this->findclass($value['class_id']);
                        $section_id = $this->findsections($value['section_id']);
                        $subject_id = $this->findsubject($value['subject_id']);
                        $output['assignment_id'] = $value['id'];
                        $output['created'] = date('d-m-Y', strtotime($value['created']));
                        $output['classname'] = $class_id['title'];
                        $output['sectionname'] = $section_id['title'];
                        $output['subject'] = $subject_id['name'];
                        $output['classid'] = $value['class_id'];
                        $output['sectionid'] = $value['section_id'];
                        $output['subid'] = $value['subject_id'];
                        $output['description'] = $value['description'];
                        $output['end_date'] = date('d-m-Y', strtotime($value['due_date']));
                        if (!empty($value['video'])) {
                            $data['userId'] = $id;
                            $data['key'] = $value['video'];
                            $http = new Client();
                            $httpResponse = $http->post('http://13.235.154.210/awsvideo/Pages/videos', $data);
                            $url = $httpResponse->json;
                            $output['file'] = $url['url'];
                        } else {
                            $output['file'] = null;
                        }

                        $response["output"][] = $output;
                    }
                }
                echo json_encode($response, JSON_UNESCAPED_SLASHES);
            } else {

                $response["success"] = 0;
                // $response["classes"][] = $classes;
                $response["message"] = "Class have not assigned any assignment";
                echo json_encode($response, JSON_UNESCAPED_SLASHES);
            }
        }
    }


    /****************************************  This api used for Teacher/Staff detail in admin side  *******************************************/


    public function teacherDetails()
    {
        $idsprimeID = $this->request->data['idsprimeID'];
        $this->db($idsprimeID);
        //$this->db('demoschool');
        $this->autoRender = false;
        $response = array();
        $this->loadmodel('Students');

        $this->loadmodel('Employees');
        $this->loadmodel('Studattends');
        $this->loadmodel('Sitesettings');
        $this->loadmodel('SitesettingsDetails');
        $this->loadmodel('Designations');
        $this->loadmodel('Departments');
        $this->loadmodel('Employeesalary');



        $emptech = $this->Employees->find('all')->contain(['Departments', 'Designations', 'Employeesalary'])->Where(['Employees.p_department' => 1])->order(['Employees.id' => 'asc'])->group('Employees.id')->toarray();


        $empnontech = $this->Employees->find('all')->contain(['Departments', 'Designations', 'Employeesalary'])->Where(['Employees.p_department' => 2])->toarray();

        foreach ($emptech as $value) {

            $emp_data['id'] = $value['id'];
            $emp_data['name'] = $value['fname'] . " " . $value['middlename'] . " " . $value['lname'];
            $emp_data['username'] = $value['username'];
            $emp_data['dob'] = date('d-m-Y', strtotime($value['dob']));
            $emp_data['gender'] = $value['gender'];
            $emp_data['mobile'] = $value['mobile'];
            $emp_data['status'] = $value['status'];
            $emp_data['joiningdate'] = date('d-m-Y', strtotime($value['joiningdate']));
            $emp_data['email'] = $value['email'];
            if ($value['experience']) {
                $emp_data['experience'] = $value['experience'];
            } else {
                $emp_data['experience'] = null;
            }

            if ($value['qualification']) {
                $emp_data['qualification'] = $value['qualification'];
            } else {
                $emp_data['qualification'] = null;
            }



            $emp_data['martial_status'] = $value['martial_status'];
            $emp_data['nationality'] = $value['nationality'];
            $emp_data['f_h_name'] = $value['f_h_name'];
            $emp_data['emp_status'] = $value['emp_status'];
            //$emp_data['file'] =  SITE_URL."images/".$idsprimeID."_image/".$value['file'];

            if ($value['file']) {

                $emp_data["file"] = SITE_URL . $idsprimeID . '_image/' . 'employees/' . $value['file'];
            } else {
                $emp_data["file"] = SITE_URL . 'images/NOIMAGE.JPG';
            }



            $emp_data['basic_salary'] = $value['employeesalary']['basic_salary'];

            if ($value['designation']['name']) {
                $emp_data['designation'] = $value['designation']['name'];
            } else {
                $emp_data['designation'] = null;
            }
            if ($value['department']['name']) {
                $emp_data['department'] = $value['department']['name'];
            } else {
                $emp_data['department'] = null;
            }

            $empdata_data[] = $emp_data;
        }



        foreach ($empnontech as $value) {
            $nonemp_data['id'] = $value['id'];
            $nonemp_data['name'] = $value['fname'] . " " . $value['middlename'] . " " . $value['lname'];
            $nonemp_data['dob'] = date('d-m-Y', strtotime($value['dob']));
            $nonemp_data['gender'] = $value['gender'];
            $nonemp_data['mobile'] = $value['mobile'];
            $nonemp_data['status'] = $value['status'];
            $nonemp_data['joiningdate'] = date('d-m-Y', strtotime($value['joiningdate']));
            $nonemp_data['email'] = $value['email'];
            if ($value['experience']) {
                $nonemp_data['experience'] = $value['experience'];
            } else {
                $nonemp_data['experience'] = null;
            }

            if ($value['qualification']) {
                $emp_data['qualification'] = $value['qualification'];
            } else {
                $emp_data['qualification'] = null;
            }

            $nonemp_data['martial_status'] = $value['martial_status'];
            $nonemp_data['nationality'] = $value['nationality'];
            $nonemp_data['f_h_name'] = $value['f_h_name'];
            $nonemp_data['emp_status'] = $value['emp_status'];
            //$nonemp_data['file'] =  SITE_URL."images/".$idsprimeID."_image/".$value['file'];


            if ($value['file']) {

                $nonemp_data["file"] = SITE_URL . $idsprimeID . '/' . 'employees/' . $value['file'];
            } else {
                $nonemp_data["file"] = SITE_URL . 'images/NOIMAGE.JPG';
            }


            $nonemp_data['basic_salary'] = $value['employeesalary']['basic_salary'];

            if ($value['designation']['name']) {
                $nonemp_data['designation'] = $value['designation']['name'];
            } else {
                $nonemp_data['designation'] = null;
            }
            if ($value['department']['name']) {
                $nonemp_data['department'] = $value['department']['name'];
            } else {
                $nonemp_data['department'] = null;
            }


            $empdatanontech_data[] = $nonemp_data;
        }

        if ($emptech) {
            $response["success"] = 1;
            $response["teacherData"] =  $empdata_data;
            $response['nonTeacherData'] = $empdatanontech_data;
        } else {
            $response["success"] = 0;
            $response["message"] = "Invalid Data";
        }
        echo json_encode($response);
    }


    /****************************************  This api used for admin all fees collection *******************************************/



    // public function adminFeesCollection()
    // {
    //     $this->autoRender = false;
    //     $jsonData = $this->request->input('json_decode');
    //     if (empty($jsonData)) {
    //         $response["success"] = 0;
    //         $response["message"] = "Invalid Json Data";
    //         echo json_encode($response);
    //         return;
    //     } else {
    //         $postData = $this->dPayload($jsonData);
    //         $userId = $postData->userId;
    //         $idsprimeID = $postData->idsprimeID;
    //         $this->db($idsprimeID);
    //         if (empty($idsprimeID) || empty($userId)) {
    //             $response['success'] = 0;
    //             $response["message"] = "Missing parameter(s)";
    //             echo json_encode($response);
    //             return;
    //         }

    //         $user = $this->Users->find()->where(['id' => $userId, 'is_admin' => 'Y'])->first();
    //         if (empty($user)) {
    //             $response['success'] = 0;
    //             $response['message'] = "Invalid UserId";
    //             echo json_encode($response);
    //             die;
    //         }
    //         $today = date('Y-m-d');
    //         $yesterday = date('Y-m-d', strtotime($today . '-1 days'));
    //         $week_start = new \DateTime();
    //         $week_start->setISODate(date('Y'), date('W'));
    //         $week = $week_start->format('Y-m-d');
    //         $month = date('Y-m') . '-1';
    //         $user = $this->Users->find()->where(['role_id' => 1])->first();
    //         $years = explode('-', $user['academic_year']);
    //         $year = $years[0] . '-04-1';
    //         //$data['pendingFees'] = 523698;

    //         $fees = $this->Studentfees->find()->select(['sum' => 'SUM(fee)'])->first()->sum;

    //         $deposit_amt = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->first()->sum;

    //         $data['pendingFees'] = $fees - $deposit_amt;

    //         $data['Today']['total'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $today])->first()->sum;
    //         $data['Today']['cash'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $today, 'mode' => 'CASH', 'status' => 'Y'])->first()->sum;
    //         $data['Today']['cheque'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $today, 'mode' => 'CHEQUE', 'status' => 'Y'])->first()->sum;
    //         $data['Today']['dd'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $today, 'mode' => 'DD', 'status' => 'Y'])->first()->sum;
    //         $data['Today']['card'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $today, 'mode' => 'Credit Card/Debit Card/UPI', 'status' => 'Y'])->first()->sum;
    //         $data['Today']['netbanking'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $today, 'mode' => 'NETBANKING', 'status' => 'Y'])->first()->sum;
    //         $data['Yesterday']['total'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $yesterday, 'status' => 'Y'])->first()->sum;
    //         $data['Yesterday']['cash'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $yesterday, 'mode' => 'CASH', 'status' => 'Y'])->first()->sum;
    //         $data['Yesterday']['cheque'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $yesterday, 'mode' => 'CHEQUE', 'status' => 'Y'])->first()->sum;
    //         $data['Yesterday']['dd'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $yesterday, 'mode' => 'DD', 'status' => 'Y'])->first()->sum;
    //         $data['Yesterday']['card'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $yesterday, 'mode' => 'Credit Card/Debit Card/UPI', 'status' => 'Y'])->first()->sum;
    //         $data['Yesterday']['netbanking'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $yesterday, 'mode' => 'NETBANKING', 'status' => 'Y'])->first()->sum;
    //         $data['Month']['total'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $month, 'status' => 'Y'])->first()->sum;
    //         $data['Month']['cash'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $month, 'mode' => 'CASH', 'status' => 'Y'])->first()->sum;
    //         $data['Month']['cheque'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $month, 'mode' => 'CHEQUE', 'status' => 'Y'])->first()->sum;
    //         $data['Month']['dd'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $month, 'mode' => 'DD', 'status' => 'Y'])->first()->sum;
    //         $data['Month']['card'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $month, 'mode' => 'Credit Card/Debit Card/UPI', 'status' => 'Y'])->first()->sum;
    //         $data['Month']['netbanking'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $month, 'mode' => 'NETBANKING', 'status' => 'Y'])->first()->sum;
    //         $data['Year']['total'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $year, 'status' => 'Y'])->first()->sum;
    //         $data['Year']['cash'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $year, 'mode' => 'CASH', 'status' => 'Y'])->first()->sum;
    //         $data['Year']['cheque'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $year, 'mode' => 'CHEQUE', 'status' => 'Y'])->first()->sum;
    //         $data['Year']['dd'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $year, 'mode' => 'DD', 'status' => 'Y'])->first()->sum;
    //         $data['Year']['card'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $year, 'mode' => 'Credit Card/Debit Card/UPI', 'status' => 'Y'])->first()->sum;
    //         $data['Year']['netbanking'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $year, 'mode' => 'NETBANKING', 'status' => 'Y'])->first()->sum;
    //         $response['success'] = 1;
    //         $response['output'] = $data;
    //         echo json_encode($response);
    //         die;
    //     }
    // }

    public function adminFeesCollection()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $userId = $postData->userId;
            $idsprimeID = $postData->idsprimeID;
            $this->db($idsprimeID);
            if (empty($idsprimeID) || empty($userId)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }

            $user = $this->Users->find()->where(['id' => $userId, 'is_admin' => 'Y'])->first();
            if (empty($user)) {
                $response['success'] = 0;
                $response['message'] = "Invalid UserId";
                echo json_encode($response);
                die;
            }
            $today = date('Y-m-d');
            $yesterday = date('Y-m-d', strtotime($today . '-1 days'));
            $week_start = new \DateTime();
            $week_start->setISODate(date('Y'), date('W'));
            $week = $week_start->format('Y-m-d');
            $month = date('Y-m') . '-1';
            $user = $this->Users->find()->where(['role_id' => 1])->first();
            $years = explode('-', $user['academic_year']);
            $year = $years[0] . '-04-1';
            //$data['pendingFees'] = 523698;

            // $fees = $this->Studentfees->find()->select(['sum' => 'SUM(fee)'])->first()->sum;

            $deposit_amt = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => date('Y'), 'status' => 'Y'])->first()->sum;

            $data['pendingFees'] = $deposit_amt;
            // $data['pendingFees'] = $fees - $deposit_amt;



            $data['Today']['total'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $today])->first()->sum;

            $data['Today']['cash'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $today, 'mode' => 'CASH', 'status' => 'Y'])->first()->sum;

            $data['Today']['cheque'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $today, 'mode' => 'CHEQUE', 'status' => 'Y'])->first()->sum;

            $data['Today']['dd'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $today, 'mode' => 'DD', 'status' => 'Y'])->first()->sum;

            $data['Today']['card'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $today, 'mode' => 'Credit Card/Debit Card/UPI', 'status' => 'Y'])->first()->sum;

            $data['Today']['netbanking'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $today, 'mode' => 'NETBANKING', 'status' => 'Y'])->first()->sum;

            $data['Week']['total'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['DATE(created) >=' => date('Y-m-d', strtotime('monday this week')), 'status' => 'Y'])->first()->sum;

            $data['Week']['cash'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['DATE(created) >=' => date('Y-m-d', strtotime('monday this week')), 'mode' => 'CASH', 'status' => 'Y'])->first()->sum;

            $data['Week']['cheque'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate' => $yesterday, 'mode' => 'CHEQUE', 'status' => 'Y'])->first()->sum;

            $data['Week']['dd'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['DATE(created) >=' => date('Y-m-d', strtotime('monday this week')), 'mode' => 'DD', 'status' => 'Y'])->first()->sum;

            $data['Week']['card'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['DATE(created) >=' => date('Y-m-d', strtotime('monday this week')), 'mode' => 'Credit Card/Debit Card/UPI', 'status' => 'Y'])->first()->sum;

            $data['Week']['netbanking'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['DATE(created) >=' => date('Y-m-d', strtotime('monday this week')), 'mode' => 'NETBANKING', 'status' => 'Y'])->first()->sum;

            $data['Month']['total'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $month, 'status' => 'Y'])->first()->sum;

            $data['Month']['cash'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $month, 'mode' => 'CASH', 'status' => 'Y'])->first()->sum;

            $data['Month']['cheque'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $month, 'mode' => 'CHEQUE', 'status' => 'Y'])->first()->sum;

            $data['Month']['dd'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $month, 'mode' => 'DD', 'status' => 'Y'])->first()->sum;

            $data['Month']['card'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $month, 'mode' => 'Credit Card/Debit Card/UPI', 'status' => 'Y'])->first()->sum;

            $data['Month']['netbanking'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['paydate >=' => $month, 'mode' => 'NETBANKING', 'status' => 'Y'])->first()->sum;

            $data['Year']['total'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => date('Y'), 'status' => 'Y'])->first()->sum;

            $data['Year']['cash'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => date('Y'), 'mode' => 'CASH', 'status' => 'Y'])->first()->sum;

            $data['Year']['cheque'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => date('Y'), 'mode' => 'CHEQUE', 'status' => 'Y'])->first()->sum;

            $data['Year']['dd'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => date('Y'), 'mode' => 'DD', 'status' => 'Y'])->first()->sum;

            $data['Year']['card'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => date('Y'), 'mode' => 'Credit Card/Debit Card/UPI', 'status' => 'Y'])->first()->sum;

            $data['Year']['netbanking'] = $this->Studentfees->find()->select(['sum' => 'SUM(deposite_amt)'])->where(['YEAR(created)' => date('Y'), 'mode' => 'NETBANKING', 'status' => 'Y'])->first()->sum;

            $response['success'] = 1;
            $response['output'] = $data;
            echo json_encode($response);
            die;
        }
    }

    /****************************************  This api used for admin teacher timetable list *******************************************/

    public function adminTeacherTimetableList()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $userId = $postData->userId;
            $idsprimeID = $postData->idsprimeID;
            $this->db($idsprimeID);
            if (empty($idsprimeID) || empty($userId)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }
            $user = $this->Users->find()->where(['id' => $userId, 'is_admin' => 'Y'])->first();

            if (empty($user)) {
                $response['success'] = 0;
                $response['message'] = "Invalid UserId";
                echo json_encode($response);
                die;
            }
            $empIds = $this->ClasstimeTabs->find('list', ['keyField' => 'id', 'valueField' => 'employee_id'])->group(['employee_id'])->toarray();
            $employees = $this->Employees->find()->where(['id IN' => $empIds])->order(['Employees.fname' => 'ASC'])->toarray();
            if (empty($employees)) {
                $response['success'] = 0;
                $response['message'] = "No Data Found";
                echo json_encode($response);
                die;
            }
            $response['success'] = 1;
            foreach ($employees as $employee) {
                $data = [];
                $data['emppId'] = $employee['id'];
                $data['name'] = $employee['full_name'];
                $data['mobile'] = $employee['mobile'];
                $response['empList'][] = $data;
            }
            echo json_encode($response);
            die;
        }
    }



    /*****************************************************  Get Teacher/Staff timetable in app *****************************************************/
    public function teacherTimeTable()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $teacherId = $postData->teacherId;
            $idsprimeID = $postData->idsprimeID;
            if (empty($teacherId) || empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $time_tab = $this->Timetables->find('all')->toarray();
            $weekdays = explode(',', $time_tab[0]['weekday']);
            $response = array();
            $response['success'] = 1;
            $response['timeTable'] = '';
            $output = array();
            $break = '';
            foreach ($weekdays as $day) {
                $i = 1;

                $key = strtolower($day);
                $output[$key] = '';
                $periods = array();
                foreach ($time_tab as $time_value) {
                    //pr($time_value);

                    if ($time_value['is_break'] != 1) {
                        $per_details = $this->ClasstimeTabs->find('all')->contain(['Classections'])->where(['FIND_IN_SET(\'' . $teacherId . '\',ClasstimeTabs.employee_id)', 'ClasstimeTabs.weekday' => $day, 'ClasstimeTabs.tt_id' => $time_value['id'], 'ClasstimeTabs.status' => '1'])->first();


                        $subj_name = $this->Subjects->find('all')->select(['alias'])->where(['id' => $per_details['subject_id']])->first();
                        $class_title = $this->Classes->find('all')->select(['title'])->where(['id' => $per_details['classection']['class_id']])->first();
                        $section_title = $this->Sections->find('all')->select(['title'])->where(['id' => $per_details['classection']['section_id']])->first();

                        if (!empty($per_details)) {

                            $periods[] = $subj_name['alias'] . "(" . $class_title['title'] . "-" . $section_title['title'] . ")";
                        } else {
                            $periods[] = "-";
                        }
                    } else {
                        $break = $i;
                    }
                    $i++;
                }
                $output[$key] = $periods;
            }
            $output['break'] = $break;
            $response['timeTable'] = $output;
            echo json_encode($response);
        }
    }


    /****************************************  This api used for admin class timetable list *******************************************/


    public function adminClassTimetableList()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $userId = $postData->userId;
            $idsprimeID = $postData->idsprimeID;
            $this->db($idsprimeID);
            if (empty($idsprimeID) || empty($userId)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }
            $this->loadModel('classections');
            $user = $this->Users->find()->where(['id' => $userId, 'is_admin' => 'Y'])->first();
            if (empty($user)) {
                $response['success'] = 0;
                $response['message'] = "Invalid UserId";
                echo json_encode($response);
                die;
            }
            $acedmic = $user['academic_year'];
            $classess = $this->Classections->find('all')->contain(['Classes', 'Sections'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
            $classlist = $this->Classes->find('list')->toarray();
            $sectionlist = $this->Sections->find('list')->toarray();
            if (!empty($classess)) {
                $today = date('Y-m-d');
                $today = "2019-04-03";
                $response['success'] = 1;
                $response['output'] = [];
                foreach ($classess as $class) {
                    $data = [];
                    $data['classId'] = $class['class_id'];
                    $data['sectionId'] = $class['section_id'];
                    $data['class'] = $classlist[$class['class_id']] . '-' . $sectionlist[$class['section_id']];
                    $response['output'][] = $data;
                }
                echo json_encode($response);
                die;
            } else {
                $response['success'] = 0;
                $response['message'] = null;
                $response['output'] = "No record found";
                echo json_encode($response);
                die;
            }
        }
    }



    public function adminLibraryData()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $userId = $postData->userId;
            $idsprimeID = $postData->idsprimeID;
            $this->db($idsprimeID);
            if (empty($idsprimeID) || empty($userId)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }
            $this->loadModel('classections');
            $user = $this->Users->find()->where(['id' => $userId, 'is_admin' => 'Y'])->first();
            if (empty($user)) {
                $response['success'] = 0;
                $response['message'] = "Invalid UserId";
                echo json_encode($response);
                die;
            }
            $user = $this->Users->find()->where(['role_id' => 1])->first();
            $years = explode('-', $user['academic_year']);
            $year = $years[0] . '-04-1';
            $data['totalBooks'] = $this->Book->find()->where(['status' => 'Y'])->count();
            $data['issuedBooks'] = $this->BookCopyDetail->find()->contain(['Book'])->where(['BookCopyDetail.status' => 'Issued'])->count();

            $data['availableBooks'] = $data['totalBooks'] - $data['issuedBooks'];
            $data['totalCupBoards'] = $this->CupBoard->find()->where(['status' => 'Y'])->count();
            $data['totalShelf'] = $this->CupBoardShelf->find()->where(['status' => 'Y'])->count();
            $data['totalBookCategory'] = $this->BookCategory->find()->where(['status' => 'Y'])->count();
            $data['totalFineCount'] = $this->Fine->find()->where(['sub_date >=' => $year])->count();
            $response['success'] = 1;
            $response['output'] = $data;
            echo json_encode($response);
            die;
        }
    }

    public function adminDatesheet()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $userId = $postData->userId;
            $idsprimeID = $postData->idsprimeID;
            $this->db($idsprimeID);
            if (empty($idsprimeID) || empty($userId)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }
            $this->loadModel('Datesheet');
            $this->loadModel('classections');

            $user = $this->Users->find()->where(['id' => $userId])->first();
            if (empty($user)) {
                $response['success'] = 1;
                $response['dateSheet'] = null;
                $response['message'] = "Invalid User Id";
                echo json_encode($response);
                die;
            }
            $cond['success'] = 0;
            $response = array();
            $date = date('Y-m-d');
            $sheet = $this->Datesheet->find('all')->where(['end_date >=' => $date])->toarray();

            if (!empty($sheet)) {
                $response['success'] = 1;
                $response['dateSheet'] = [];
                $cond['success'] = 0;
                foreach ($sheet as $values) {
                    $cond['success'] = 1;
                    $class_id = $det['class_id'];
                    $output = array();
                    $classes = explode(',', $values['class_id']);
                    $output['title'] = ucwords($values['title']);
                    $output['start_date'] = date('d-m-Y', strtotime($values['start_date']));
                    $output['end_date'] = date('d-m-Y', strtotime($values['end_date']));
                    $db = $this->Users->find()->where(['role_id' => 1])->first();
                    $filename = IMAGE_URL . $db['db'] . 'img/' . $values['sheet_name'];
                    $file_headers = @get_headers($filename);

                    if ($file_headers && strpos($file_headers[0], '200 OK')) {
                        $output['url'] = $filename;
                    } else {
                        $output['url'] = SITE_URL . "img/" . $values['sheet_name'];
                    }
                    $response['dateSheet'][] = $output;
                    break;
                }
            }

            if ($cond['success'] == 0) {
                $response['success'] = 1;
                $response['dateSheet'] = null;
                $response['message'] = "No Data Available";
                echo json_encode($response);
            } else {
                echo json_encode($response);
            }
        }
    }


    public function visitors()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $userId = $postData->userId;
            $login_type = $postData->login_type;
            $idsprimeID = $postData->idsprimeID;
            if (empty($idsprimeID)) {
                $response["success"] = 0;
                $response["message"] = "Invalid Parameter";
                echo json_encode($response);
                return;
            }
            $this->db($idsprimeID);
            $this->loadModel('Visitors');
            $this->loadModel('Users');

            if (empty($userId) || empty($login_type) || empty($idsprimeID)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }

            $date = date('y-m-d');
            if ($login_type == "Admin") {
                $gatepasses = $this->Visitors->find('all')->where(['DATE(created) >=' => $date, 'status' => 'Y'])->order(['id' => 'DESC'])->toarray();
            } else {
                $gatepasses = $this->Visitors->find('all')->where(['user_id' => $userId, 'DATE(created) >=' => $date, 'status' => 'Y'])->order(['id' => 'DESC'])->toarray();
            }
            $response = array();
            $response['success'] = 1;
            if (!empty($gatepasses)) {
                foreach ($gatepasses as $gatepass) {
                    $output['name'] = $gatepass['name'];
                    $output['phone'] = $gatepass['phone'];
                    $output['toMeet'] = $gatepass['to_meet'];
                    $output['persons'] = $gatepass['persons'];
                    $output['purpose'] = $gatepass['purpose'];
                    $output['inTime'] = $gatepass['intime'];

                    $db = $this->Users->find()->where(['role_id' => 1])->first();
                    $filename = IMAGE_URL . $db['db'] . 'img/' . $gatepass['image'];

                    $file_headers = @get_headers($filename);

                    if ($file_headers && strpos($file_headers[0], '200 OK')) {
                        $output['photo'] = $filename;
                    } else {
                        $output['photo'] = SITE_URL . "visitors/" . $gatepass['image'];
                    }
                    $response['output'][] = $output;
                }
                $response['currentDate'] = date('d/m/Y');
            } else {
                $response['success'] = 0;
                $response['output'] = null;
                $response['currentDate'] = date('d/m/Y');
                $response['message'] = "No Visitors Today";
            }
        }
        echo json_encode($response);
        return;
    }

    //old code 
    // public function leadManagment()
    // {
    //     $idsprimeID = $this->request->data['idsprimeID'];
    //     $this->db($idsprimeID);
    //     $this->loadModel('Enquires');
    //     $this->loadModel('Followup');
    //     $this->loadModel('Modes');
    //     $this->loadModel('Classes');
    //     $this->loadModel('Students');


    //     $this->autoRender = false;
    //     $response = array();
    //     $classes_data = $this->Enquires->find('all')->where(['Enquires.formno' => '0000'])->order(['Enquires.id' => 'DESC'])->contain(['Classes', 'Modes',])->toarray();


    //     foreach ($classes_data as $value) {

    //         $follow_data = $this->Followup->find('all')->where(['enq_id' => $value['id']])->toarray();
    //         $admission_details['id'] = $value['id'];
    //         $admission_details['name'] = $value['s_name'];
    //         $admission_details['mobile'] = $value['mobile'];
    //         $admission_details['class'] = $value['class']['title'];
    //         $admission_details['mode'] = $value['mode']['name'];
    //         $admission_details['remark'] = $value['enquiry'];
    //         $admission_details['followup_date'] = date('d-m-Y', strtotime($value['next_followup_date']));
    //         $admission_details['enquiry_date'] = date('d-m-Y', strtotime($value['created']));

    //         $admission_detailss[] = $admission_details;
    //     }
    //     $response['success'] = 1;
    //     $response['results'] = $admission_detailss;
    //     $this->response->type('application/json');
    //     $this->response->body(json_encode($response));
    //     return $this->response;
    //     die;
    // }

    // new lead managment code
    public function leadManagment()
    {
        $idsprimeID = $this->request->data['idsprimeID'];
        $this->db($idsprimeID);
        $this->loadModel('Enquires');
        $this->loadModel('Followup');
        $this->loadModel('Modes');
        $this->loadModel('Classes');
        $this->loadModel('Students');

        //sanjay code 03-05-2023
        $this->autoRender = false;
        $response = array();


        $mode_id = $this->request->data['mode_id'];
        $lead_type = $this->request->data['lead_type'];

        if (!empty($mode_id)) {
            $cond[] = array('Enquires.mode_id' => $mode_id);
        }
        if (!empty($lead_type)) {
            $cond[] = array('Enquires.lead_type' => $lead_type);
        }
        // pr($cond); die;
        $modess = $this->Modes->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Modes.status' => 'Y'])->toArray();
        foreach ($modess as $key => $value) {
            $mode_data['Id'] = $key;
            $mode_data['Value'] = $value;
            $mode_data['Name'] = $value;
            $modess_data[] = $mode_data;
        }

        $lead_type1 = array('Hot Lead' => 'Hot Lead', 'Cold Lead' => 'Cold Lead', 'Follow Up Lead' => 'Follow Up Lead', 'Interested' => 'Interested', 'Converted' => 'Converted', 'New Lead' => 'New Lead', 'Not Interested' => 'Not Interested');

        foreach ($lead_type1 as $key => $value) {
            $lead_type['Id'] = $key;
            $lead_type['Value'] = $value;
            $lead_type['Name'] = $value;
            $lead_type_data[] = $lead_type;
        }

        $conns = ConnectionManager::get('default');
        $query1 = "SELECT *,Max(f_id) as mf FROM `followup` group by enq_id";
        $foll = $conns->execute($query1)->fetchALL("assoc");
        $fids = array();
        foreach ($foll as $fl) {
            $fids[] = $fl['mf'];
        }

        $orderby = [];
        // $orderby['Enquires.next_followup_date'] = 'desc';
        $orderby['Followup.f_date'] = 'desc';
        $orderby['Enquires.created'] = 'desc';
        if ($fids) {
            $allenquires = $this->Followup->find('all')->contain(['Enquires' => ['Classes', 'Modes']])->where(['Followup.f_id IN' => $fids, $cond, 'Enquires.user_id IS NULL'])->order($orderby)->toArray();
        } else {
            $allenquires = $this->Followup->find('all')->where(['Enquires.user_id IS NULL'])->contain(['Enquires' => ['Classes', 'Modes']])->order($orderby)->toArray();
        }

        foreach ($allenquires as $value) {
            // pr($value); die;

            // $follow_data = $this->Followup->find('all')->where(['enq_id' => $value['id']])->toarray();
            $admission_details['id'] = $value['enquire']['id'];
            $admission_details['name'] = Ucfirst($value['enquire']['s_name']);
            $admission_details['mobile'] = $value['enquire']['mobile'];
            $admission_details['class'] = $value['enquire']['class']['title'];
            $admission_details['mode'] = $value['enquire']['mode']['name'];
            $admission_details['lead_type'] = $value['enquire']['lead_type'];
            $admission_details['remark'] = $value['enquire']['enquiry'];
            $admission_details['followup_date'] = date('d-m-Y', strtotime($value['enquire']['next_followup_date']));
            $admission_details['enquiry_date'] = date('d-m-Y', strtotime($value['enquire']['created']));

            $admission_detailss[] = $admission_details;
        }
        $response['success'] = 1;
        $response['results'] = $admission_detailss;
        $response['mode_type'] = $modess_data;
        $response['lead_type'] = $lead_type_data;
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
        die;
    }


    // get followup details for app side api
    public function getfollowupDetails()
    {
        $idsprimeID = $this->request->data['idsprimeID'];
        $enquiryID = $this->request->data['id'];
        $this->db($idsprimeID);
        $this->loadModel('Enquires');
        $this->loadModel('Modes');
        $this->loadModel('Classes');
        $this->loadModel('Students');
        $this->loadModel('Followup');

        $this->autoRender = false;
        $response = array();

        $followup_data = $this->Followup->find('all')->where(['Followup.enq_id' => $enquiryID])->order(['Followup.f_id' => 'DESC'])->contain(['Enquires'])->toarray();


        foreach ($followup_data as $value) {

            $followup_details['id'] = $value['f_id'];
            $followup_details['mobile'] = $value['enquire']['mobile'];
            $followup_details['remark'] = $value['f_responce'];
            $followup_details['followup_date'] = date('d-m-Y', strtotime($value['f_date']));

            $followup_datas[] = $followup_details;
        }

        $response['success'] = 1;
        $response['followup_details'] = $followup_datas;

        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
        die;
    }

    public function getprospectusDetails()
    {
        $idsprimeID = $this->request->data['idsprimeID'];
        $admissionDate = $this->request->data['admissionDate'];

        $this->db($idsprimeID);
        $this->loadModel('Enquires');
        $this->loadModel('Modes');
        $this->loadModel('Classes');
        $this->loadModel('Students');
        $this->loadModel('Applicant');

        $this->autoRender = false;
        $response = array();
        if ($admissionDate) {
            $month = date('m');
            $year = date('Y');
            $date_data =  $year . "-" . $month . "-" . $admissionDate;
            $prospectus_data = $this->Enquires->find('all')->where(['DATE(Enquires.created)' => $date_data, 'Enquires.formno !=' => '0000'])->order(['Enquires.id' => 'DESC'])->contain(['Classes', 'Modes',])->toarray();
        } else {

            $prospectus_data = $this->Enquires->find('all')->order(['Enquires.id' => 'DESC'])->where(['Enquires.formno !=' => '0000'])->contain(['Classes', 'Modes',])->toarray();
        }

        $chkoutdate = date('d-m-Y');
        $curr = date('d');
        for ($i = 1; $i <= 4; $i++) {
            $dates_Data[] = date('d', strtotime($chkoutdate . ' - ' . $i . ' day'));
        }
        array_unshift($dates_Data, $curr);


        foreach ($prospectus_data as $value) {

            $prospectus_details['form_no'] = $value['formno'];
            $prospectus_details['pupils_name'] = $value['s_name'];
            $prospectus_details['mobile'] = $value['mobile'];
            // $prospectus_details['type']=$value['fathername'];
            $prospectus_details['type'] = $value['mode']['name'];

            $prospectus_details['class'] = $value['class']['title'];
            $prospectus_details['sms_mobile'] = $value['sms_mobile'];
            $prospectus_details['acedmicyear'] = $value['acedmicyear'];
            $prospectus_details['selling_date'] = date('d-m-Y', strtotime($value['created']));
            $prospectus_payment += $value['p_fees'];

            $prospectus_detail[] = $prospectus_details;
        }


        if ($prospectus_detail) {
            $response['success'] = 1;
            $response['totalPayment'] = $prospectus_payment;
            $response['dates'] = $dates_Data;
            $response['prospectus_details'] = $prospectus_detail;
        } else {
            $response['success'] = 0;
            $response['totalPayment'] = 0;
            $response['dates'] = $dates_Data;
            $response['message'] = "No Prospectus";
        }

        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
        die;
    }


    public function getadmissionDetails()
    {
        $idsprimeID = $this->request->data['idsprimeID'];
        $admissionDate = $this->request->data['admissionDate'];

        $this->db($idsprimeID);
        $this->loadModel('Enquires');

        $this->loadModel('Modes');
        $this->loadModel('Classes');
        $this->loadModel('Students');


        $this->autoRender = false;
        $response = array();
        if ($admissionDate) {
            $month = date('m');
            $year = date('Y');
            $date_data =  $year . "-" . $month . "-" . $admissionDate;

            $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['DATE(Students.created)' => $date_data])->order(['Students.enroll' => 'DESC'])->toarray();
        } else {

            $student_data = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.status' => 'Y'])->order(['Students.enroll' => 'DESC'])->toarray();
        }
        $stu_count = $this->Students->find('all')->where(['DATE(Students.created)' => $date_data])->count();

        $chkoutdate = date('d-m-Y');
        $curr = date('d');
        for ($i = 1; $i <= 4; $i++) {

            $dates_Data[] = date('d', strtotime($chkoutdate . ' - ' . $i . ' day'));
        }

        array_unshift($dates_Data, $curr);
        foreach ($student_data as $value) {

            $admission_details['enroll'] = $value['enroll'];
            $admission_details['name'] = $value['fname'] . " " . $value['middlename'] . " " . $value['lname'];
            $admission_details['mobile'] = $value['mobile'];
            $admission_details['fathername'] = $value['fathername'];
            $admission_details['mothername'] = $value['mothername'];
            $admission_details['sms_mobile'] = $value['sms_mobile'];
            $admission_details['admission_date'] = date('d-m-Y', strtotime($value['created']));
            $admission_details['acedmicyear'] = $value['acedmicyear'];
            $admission_details['class'] = $value['class']['title'];
            $admission_details['section'] = $value['section']['title'];

            $admission_detailss[] = $admission_details;
        }

        if ($admission_detailss) {
            $response['success'] = 1;
            $response['admission_details'] = $admission_detailss;
            $response['totalPayment'] = $stu_count;
            $response['dates'] = $dates_Data;
        } else {

            $response['success'] = 0;
            $response['totalPayment'] = $stu_count;
            $response['dates'] = $dates_Data;
            $response['message'] = "No Admission";
        }

        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
        die;
    }
    /************************************************************************************
     ******************Admin Api's End***********************************************/





    /************************************************************************************
     ******************Guard Api's Start***********************************************/
    /*
1. addVisitor
2. verifyVisitorOtp
3. resendVisitorOtp
 */

    public function addVisitor()
    {
        $this->autoRender = false;


        if ($this->request->is('post')) {


            $validator = new Validator();
            $validator->requirePresence(['name', 'phone', 'purpose', 'persons', 'toMeet', 'photo', 'userId'])
                ->notEmpty('name', 'Name can\'t be empty')
                ->notEmpty('phone', 'phone can\'t be empty')
                ->notEmpty('purpose', 'purpose can\'t be empty')
                ->notEmpty('persons', 'persons can\'t be empty')
                ->notEmpty('toMeet', 'toMeet can\'t be empty')
                ->notEmpty('photo', 'image can\'t be empty')
                ->notEmpty('userId', 'userId can\'t be empty');
            $errors = $validator->errors($this->request->data);
            if (!empty($errors)) {
                $response['success'] = 0;
                $response['message'] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            } else {
                $idsprimeID = $this->request->data['idsprimeID'];
                $this->db($idsprimeID);
                $this->loadModel('visitors');
                $data = array();
                $data['name'] = $this->request->data['name'];
                $data['phone'] = $this->request->data['phone'];
                $data['purpose'] = $this->request->data['purpose'];
                $data['persons'] = $this->request->data['persons'];
                $data['to_meet'] = $this->request->data['toMeet'];
                $data['user_id'] = $this->request->data['userId'];
                $data['intime'] = date('H:i:s');
                $image = $this->request->data['photo'];
                $tmp = $image['tmp_name'];
                $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
                $img_name = $data['phone'] . uniqid() . '.' . $ext;
                $location = "visitors/" . $img_name;
                $filePath = WWW_ROOT . 'visitors/' . $imagename;
                if (move_uploaded_file($tmp, $location)) {



                    // $data['type'] = "sanskarimg";
                    // $data['file'] = $img_name;
                    // $data['types'] = $image['type'];
                    // $ext = pathinfo($data['file'], PATHINFO_EXTENSION);
                    // $data['ext'] = $ext;
                    // // $http = new Client();

                    // $responser = $http->post('https://bucket.idsprime.com/Pages/uploadidsprimeassignment', $data);
                    // if (strpos($responser->body, '<!DOCTYPE html>') === false && strpos($responser->body, 'Invalid') === false) {
                    // $data['image'] = $responser->body;
                    $data['image'] = $img_name;

                    //     unlink($filePath);
                    // } else {
                    //     $data['image'] = "";
                    // }
                    //  $data['otp'] = rand(1001, 9999);
                    $data['otp'] = '1234';
                    $data['image'] = $img_name;
                    // pr($data); die;
                    $patch = $this->visitors->patchEntity($this->visitors->newEntity(), $data);
                    if ($visitor = $this->visitors->save($patch)) {
                        $mesg = "Your One Time Password for Sanskar School  is " . $data['otp'];
                        // $result = $this->file_get_contents_curl('http://alerts.prioritysms.com/api/web2sms.php?workingkey=Afb7ede974e22367003ac66f8514bd152&to=' . $data['phone'] . '&sender=SNSKAR&message=' . urlencode($mesg));
                        if ($result != "Invalid Mobile Numbers") {
                            $response['success'] = 1;
                            $response["message"] = "please verify OTP sent to your number";
                            $response['visitorId'] = $visitor->id;
                        } else {
                            $response['success'] = 0;
                            $response["message"] = "Invalid Mobile Numbers";
                        }
                        echo json_encode($response);
                        return;
                    }
                } else {
                    $response['success'] = 0;
                    $response["message"] = "Error in uploading image Please try later";
                    echo json_encode($response);
                    return;
                }
            }
        } else {
            $response['success'] = 0;
            $response["message"] = "Invalid Request Type";
            echo json_encode($response);
            return;
        }
    }

    public function verifyVisitorOtp()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $id = $postData->visitorId;
            $otp = $postData->otp;
            $idsprimeID = $postData->idsprimeID;

            $this->db($idsprimeID);
            if (empty($id) || empty($idsprimeID) || empty($otp)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }
            $this->loadModel('visitors');
            $det = $this->visitors->find('all')->where(['id' => $id])->first();
            if (empty($det)) {
                $response['success'] = 0;
                $response["message"] = "Invalid Visitor Id";
                echo json_encode($response);
                return;
            }
            if ($det['otp'] == $otp) {
                $data['status'] = 'Y';
                $patch = $this->visitors->patchEntity($det, $data);
                $this->visitors->save($patch);
                $response['success'] = 1;
                $response["message"] = "Verified Successfully";
                echo json_encode($response);
                return;
            } else {
                $response['success'] = 0;
                $response["message"] = "Invalid OTP";
                echo json_encode($response);
                return;
            }
        }
    }

    public function resendVisitorOtp()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $id = $postData->visitorId;
            $idsprimeID = $postData->idsprimeID;
            $this->db($idsprimeID);
            if (empty($visitorId) || empty($idsprimeID)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }
            $this->loadModel('visitors');
            $det = $this->visitors->find('all')->where(['id' => $id])->first();
            if (empty($det)) {
                $response['success'] = 0;
                $response["message"] = "Invalid Visitor Id";
                echo json_encode($response);
                return;
            }
            $data['otp'] = rand(1001, 9999);
            $patch = $this->visitors->patchEntity($det, $data);
            $this->visitors->save($patch);
            $mesg = "Your One Time Password for Sanskar School  is " . $data['otp'];
            $result = $this->file_get_contents_curl('http://alerts.prioritysms.com/api/web2sms.php?workingkey=Afb7ede974e22367003ac66f8514bd152&to=' . $det['phone'] . '&sender=SNSKAR&message=' . urlencode($mesg));
            if ($result != "Invalid Mobile Numbers") {
                $response['success'] = 1;
                $response["message"] = "please verify OTP sent to your number";
            } else {
                $response['success'] = 0;
                $response["message"] = "Invalid Mobile Numbers";
            }
            echo json_encode($response);
            return;
        }
    }

    /************************************************************************************
     ******************Guard Api's End***********************************************/
    //************************************************************Joined functions start*****************************************************/
    /*
1. is_url_exist
2. findsections
3. findclass
4. findamount
*/
    public function is_url_exist($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);
        return $status;
    }

    public function findsections($id)
    {
        return $this->Sections->find('all')->select(['id', 'title'])->where(['id' => $id])->order(['title' => 'Asc'])->first();
    }


    public function findclass($id)
    {
        return $this->Classes->find('all')->select(['id', 'title'])->where(['id' => $id])->order(['title' => 'Asc'])->first();
    }


    public function findclasstecher($class_id, $section_id)
    {

        return $this->Classteachers->find('all')->where(['class_id' => $class_id, 'section_id' => $section_id, 'teacher_type' => '1'])->contain(['Employees'])->toArray();
    }

    public function findamount($id, $a_year)
    {

        return $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.academic_year')->group('Classfee.class_id')->select([
            'qu1_fees' => $this->Classfee->find()->func()->sum('Classfee.qu1_fees'), 'qu2_fees' => $this->Classfee->find('all')->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $this->Classfee->find('all')->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $this->Classfee->find('all')->func()->sum('Classfee.qu4_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.qu1_date', 'Classfee.qu2_date', 'Classfee.qu3_date', 'Classfee.qu4_date', 'Classfee.status', 'Classfee.class_id',
        ])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year])->order(['Classfee.id' => 'ASC'])->toArray();
    }

    public function findamount4month($id, $a_year)
    {
        $articles = TableRegistry::get('Classfee');
        $m = date('Y-m-d');
        return $articles->find('all')->contain(['Classes'])->select(['qu4_fees' => $articles->find()->func()->sum('Classfee.qu4_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.qu4_date', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'DATE(Classfee.qu4_date) <=' => $m])->order(['Classfee.id' => 'ASC'])->first()->toArray();
    }

    public function findamount3month($id, $a_year)
    {
        $articles = TableRegistry::get('Classfee');
        $m = date('Y-m-d');
        return $articles->find('all')->contain(['Classes'])->select(['qu3_fees' => $articles->find()->func()->sum('Classfee.qu3_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.qu3_date', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'DATE(Classfee.qu3_date) <=' => $m])->order(['Classfee.id' => 'ASC'])->first()->toArray();
    }

    public function findamount2month($id, $a_year)
    {
        $articles = TableRegistry::get('Classfee');
        $m = date('Y-m-d');
        return $articles->find('all')->contain(['Classes'])->select(['qu2_fees' => $articles->find()->func()->sum('Classfee.qu2_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.qu2_date', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'DATE(Classfee.qu2_date) <=' => $m])->order(['Classfee.id' => 'ASC'])->first()->toArray();
    }

    public function findamount1month($id, $a_year)
    {
        $articles = TableRegistry::get('Classfee');
        $m = date('Y-m-d');
        return $articles->find('all')->contain(['Classes'])->select(['qu1_fees' => $articles->find()->func()->sum('Classfee.qu1_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.qu1_date', 'Classfee.class_id'])->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year, 'DATE(Classfee.qu1_date) <=' => $m])->order(['Classfee.id' => 'ASC'])->first()->toArray();
    }

    public function finddisountstudent($stid, $a_year)
    {
        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->where(['Studentfees.student_id' => $stid, 'Studentfees.acedmicyear' => $a_year, 'Studentfees.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
    }
    public function finddisountstudenthistory($stid)
    {
        $articles = TableRegistry::get('Studentfees');
        return $articles->find('all')->where(['Studentfees.student_id' => $stid, 'Studentfees.status' => 'Y'])->order(['Studentfees.id' => 'ASC'])->toArray();
    }
    public function findfeeheadsid($name)
    {
        $articles = TableRegistry::get('Feesheads');
        return $articles->find('all')->where(['Feesheads.name' => $name])->first();
    }


    public function findfeeheadsamount($id, $a_year, $feeheads)
    {
        $articles = TableRegistry::get('Classfee');
        return $articles->find('all')->contain(['Classes'])->group('Classfee.academic_year')->group('Classfee.class_id')->select([
            'qu1_fees' => $articles->find()->func()->sum('Classfee.qu1_fees'), 'qu2_fees' => $articles->find('all')->func()->sum('Classfee.qu2_fees'), 'qu3_fees' => $articles->find('all')->func()->sum('Classfee.qu3_fees'), 'qu4_fees' => $articles->find('all')->func()->sum('Classfee.qu4_fees'), 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.status', 'Classfee.class_id',
        ])->where(['Classfee.class_id' => $id, 'Classfee.fee_h_id' => $feeheads, 'Classfee.academic_year' => $a_year])->order(['Classfee.id' => 'ASC'])->toArray();
    }
    public function findclassfee($id, $a_year)
    {
        $articles = TableRegistry::get('Classfee');
        return $articles->find('all')->contain(['Classes'])->group('Classfee.academic_year')->group('Classfee.class_id')->where(['Classfee.class_id' => $id, 'Classfee.academic_year' => $a_year])->order(['Classfee.id' => 'ASC'])->first();
    }

    public function findfeeheadsname($id)
    {
        $articles = TableRegistry::get('Feesheads');
        return $articles->find('all')->where(['Feesheads.id' => $id])->first();
    }

    public function CalculateDiscount($id, $cid, $acedamicyear, $qu_fee_name)
    {
        $fees = 0;
        $conn = ConnectionManager::get('default');
        $sintall = "select * FROM class_fee_allocations WHERE academic_year='" . $acedamicyear . "' AND class_id =" . $cid;
        $rinstall = $conn->execute($sintall)->fetch('assoc');
        $installment = $rinstall[$qu_fee_name];

        $p_user_id = "select * from discountcategory  where name=(select discountcategory FROM students WHERE id=" . $id . " and discountcategory!=''  order by id desc limit 1)";
        $result = $conn->execute($p_user_id)->fetch('assoc');
        $quas[] = unserialize($result['discount']);
        $quas1[] = unserialize($result['fh_id']);
        $fix = $quas[0][2];
        $percent = $quas1[0][2];

        if ($percent > 0) {
            $fees = $installment - ($installment * $percent) / 100;
        } else {
            $fees = $installment - $fix;
        }
        return $fees;
    }
    public function findsubject($id)
    {
        return $this->Subjects->find('all')->select(['id', 'name'])->where(['id' => $id])->order(['name' => 'Asc'])->first();
    }
    public function findteacher($id)
    {
        return $this->Employees->find('all')->where(['id' => $id])->first();
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

    public function getAllTokens($type = null)
    {
        $this->loadModel('Students');
        $this->loadModel('Employees');
        $tokens = array();

        if ($type == 'Student') {

            $findData = $this->Students->find('all')->limit(250)->order(['Students.id' => 'DESC'])->toarray();
        } else if ($type == "Teacher") {

            $findData = $this->Employees->find('all')->limit(250)->order(['Employees.id' => 'DESC'])->toarray();
        } else {
            $employeeData = $this->Employees->find('all')->limit(250)->order(['Employees.id' => 'DESC'])->toarray();
            $studentData = $this->Students->find('all')->limit(250)->order(['Students.id' => 'DESC'])->toarray();
            $findData = array_merge($employeeData, $studentData);
        }
        // pr($findData); 
        foreach ($findData as $value) {

            if (!empty($value['token'])) {
                array_push($tokens, $value['token']);
            }
        }
        // array_push($tokens, "ev61AXfGRbibXz1DG73Xq2:APA91bFcZh6fiW4ytvIGtVvMm_gsCtdf4PDEsJyYPucFq_MGkux4kOQglDNhoKHq_Z2zQIAKl7nc4trxt7e7H_Nzn-qdZN_wgKpRfB7m0xWhUB1zpOrs-gNYKbTHkRx8RDnw4-Wjw9Sn");
        return $tokens;
    }

    public function cities($id = null)
    {
        $clsasses = $this->Cities->find('all')->where(['Cities.id' => $id])->toArray();
        return $clsasses;
    }

    public function states($id = null)
    {
        $clsasses = $this->States->find('all')->where(['States.id' => $id])->toArray();
        return $clsasses;
    }

    public function countries($id = null)
    {
        $clsasses = $this->Country->find('all')->where(['Country.id' => $id])->toArray();
        return $clsasses;
    }
    //********************************************************Joined functions end***********************************************/

    //////////////////////////////////////////Student Image Crop Function ///////////////////////////////////////////////////////////////////
    public function studentuploadimagecrop()
    {
        $this->autoRender = false;
        $student_id = $this->request->data['student_id'];
        $idsprimeID = $this->request->data['idsprimeID'];
        if (empty($student_id) || empty($idsprimeID)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Parameter";
            echo json_encode($response);
            return;
        }
        $this->db($idsprimeID);
        $this->loadModel('Students');
        $response = [];
        $filename = $_FILES['file']['name'];
        $tmp =  $_FILES['file']['tmp_name'];

        $ext = end(explode('.', $filename));
        $bordd = '';

        $students = $this->Students->find('all')->where(['Students.id' => $student_id, 'Students.status' => 'Y'])->first();
        if ($students) {
            $imagename = $bordd . $students['enroll'] . strtotime("now") . "." . $ext;
            $filePath_normal = WWW_ROOT . $idsprimeID . '_image/student/' . $imagename;
            $filePathh_thumbnail = WWW_ROOT . $idsprimeID . '_image/thumbnailstudent/';
            if ($filename = $_FILES['file']['name'] != '') {
                unlink(WWW_ROOT . $idsprimeID . '_image/student/' . $students['file']);

                $galls = $this->move_images($_FILES['file'], $filePath_normal);
                $this->upload_images($imagename, array(300, 300), $filePathh_thumbnail, $filePath_normal);
            } else {
                $this->request->data['file'] = $students['file'];
            }
            $student_update = $this->Students->patchEntity($students, $this->request->data);
            $this->Students->save($student_update);

            $response["success"] = 1;
            $response["message"] = "image uploaded successfully";
            echo json_encode($response);
            die;
        } else {
            $response["success"] = 0;
            $response["message"] = "Student record not available";
            echo json_encode($response);
            die;
        }
    }
    // new api for admin side students photos count
    public function AdminStudentPhotoCount()
    {
        $this->autoRender = false;
        $jsonData = $this->request->input('json_decode');
        // pr($jsonData);
        if (empty($jsonData)) {
            $response["success"] = 0;
            $response["message"] = "Invalid Json Data";
            echo json_encode($response);
            return;
        } else {
            $postData = $this->dPayload($jsonData);
            $userId = $postData->userId;
            $idsprimeID = $postData->idsprimeID;
            $this->db($idsprimeID);
            if (empty($idsprimeID) || empty($userId)) {
                $response['success'] = 0;
                $response["message"] = "Missing parameter(s)";
                echo json_encode($response);
                return;
            }
            $this->loadModel('Datesheet');
            $this->loadModel('classections');
            $user = $this->Users->find()->where(['id' => $userId, 'is_admin' => 'Y'])->first();
            if (empty($user)) {
                $response['success'] = 0;
                $response['message'] = "Invalid UserId";
                echo json_encode($response);
                die;
            }
            $acedmic = $user['academic_year'];
            $classess = $this->Classections->find('all')->contain(['Classes', 'Sections'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
            $classlist = $this->Classes->find('list')->toarray();
            $sectionlist = $this->Sections->find('list')->toarray();
            if (!empty($classess)) {
                $today = date('Y-m-d');
                // $today = "2019-04-03";
                $response['success'] = 1;
                $response['output'] = [];
                $response['output']['totalStudent'] = "";
                $response['output']['totalAbsent'] = "";
                $totalStudent = 0;
                $totalAbsent = 0;
                foreach ($classess as $class) {
                    $data = [];
                    $data['class_id'] = $class['class_id'];
                    $data['section_id'] = $class['section_id'];
                    $data['class'] = $classlist[$class['class_id']] . '-' . $sectionlist[$class['section_id']];

                    $data['totalStudent'] = $this->Students->find('all')->where(['Students.status' => 'Y', 'Students.acedmicyear' => $acedmic, 'class_id' => $class['class_id'], 'section_id' => $class['section_id']])->count();

                    $data['without_upload_photo'] = $this->Students->find()->where(['Students.status' => 'Y', 'Students.acedmicyear' => $acedmic, 'class_id' => $class['class_id'], 'section_id' => $class['section_id'], 'Students.file IS NULL'])->count();

                    $totalStudent += $data['totalStudent'];
                    $totalAbsent += $data['without_upload_photo'];
                    $response['output']['classInfo'][] = $data;
                }
                $response['output']['totalStudents'] = $totalStudent;
                $response['output']['totalAbsentStudents'] = $totalAbsent;
                echo json_encode($response);
                die;
            } else {
                $response['success'] = 0;
                $response['message'] = null;
                $response['output'] = "No record found";
                echo json_encode($response);
                die;
            }
        }
    }

    //this code for student result download
    public function downloadPdf()
    {
        // Generate the PDF using TCPDF or any other library of your choice
        $pdf = new TCPDF("H", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->AddPage();
        $pdf->setHeaderMargin(0);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, 0);
        $pdf->SetFont('', '', 10, '', 'true');

        // Add some content to the PDF
        $pdf->Write(0, "Hello World");

        // Set the headers and response type for the PDF file
        $this->response = $this->response->withType('application/pdf');
        $this->response = $this->response->withHeader('Content-Disposition', 'attachment;filename=my_pdf_file.pdf');
        $this->response = $this->response->withHeader('Content-Length', strlen($pdf->Output('', 'S')));

        // Output the PDF file contents to the response body
        $this->response->getBody()->write($pdf->Output('', 'S'));

        return $this->response;
    }
}
