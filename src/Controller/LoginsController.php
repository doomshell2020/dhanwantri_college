<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;

class LoginsController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->loadComponent('Cookie');
        $this->Auth->allow(['newindex', 'index', 'logout', 'forgot', 'forgetcpass', 'setpass']);
    }


    public function newindex($db = null)
    {
        $user = $this->Auth->user();
        if ($user) {
            $db = $this->request->session()->read('Auth.User.db');
            if ($db != DB_NAME) {
                $role = $this->request->session()->read('Auth.User.role_id');
                $this->request->session()->write('role', $role);
                $this->request->session()->write('redirectUrl', $this->referer());
                $this->Auth->logout();
                if ($role != 101) {
                    return $this->redirect('/' . $db);
                }
                return $this->redirect('/');
            }
        }

        $this->loadModel('Schools');
        $schoolstatus = $this->Schools->find('all')->where(['school_database' => $db])->first();

        if ($schoolstatus['status'] == 'N') {
            echo '<img src="' . SITE_URL . 'img/awserror.png">';
            die;
        }
        if (empty($db)) {
            $db = DB_NAME;
        }
        $this->set(compact('db'));

        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        $user_db = $this->request->session()->read('Auth.User.db');
        if (!empty($rolepresent)) {
            $this->loadModel('ClasstimeTabs');
            $this->loadModel('Classections');
        }
        if ($rolepresent == '5' || $rolepresent == '8') {
            return $this->redirect(['controller' => 'admin/studentfees', 'action' => 'view']);
        } else if ($rolepresent == '6') {
            return $this->redirect(['controller' => 'admin/Employeeattendance', 'action' => 'rolesubstitute']);
        } else if ($rolepresent == '7') {

            return $this->redirect(['controller' => 'admin/Issuebooks', 'action' => 'index']);
        } else if ($rolepresent == '4') {

            return $this->redirect(['controller' => 'admin/exam', 'action' => 'index']);
        } else if ($rolepresent == '13') {

            return $this->redirect(['controller' => 'admin/exam', 'action' => 'index']);
        } else if ($rolepresent == '14') {

            return $this->redirect(['controller' => 'admin/permissionmodules', 'action' => 'index']);
        } else if ($rolepresent == '15') {

            return $this->redirect(['controller' => 'admin/enquires', 'action' => 'index']);
        } else if ($rolepresent == '18') {

            if ($admin_det->is_store == 'Y') {
                return $this->redirect(['controller' => 'admin/purchaseorder', 'action' => 'index']);
            } else {
                $this->Flash->error(__('You are not authorized'));
                $this->Auth->logout();
            }
        } else if ($rolepresent == '19') {

            return $this->redirect(['controller' => 'admin/indent', 'action' => 'index']);
        } else if ($rolepresent == '3') {

            $tid = $this->request->session()->read('Auth.User.tech_id');
            $csec = $this->ClasstimeTabs->find('all')->where(['FIND_IN_SET(\'' . $tid . '\',ClasstimeTabs.employee_id)'])->toarray();

            foreach ($csec as $key => $value) {
                $csection = $this->Classections->find('all')->contain(['Classes', 'Sections'])->where(['Classections.id' => $value['class_id']])->order(['Classections.id' => 'ASC'])->first();
                $classs[] = $csection['class_id'];
            }

            $cls = array_unique($classs);
            $klp = array('18', '19', '30', '1', '2', '3', '4', '6');
            $rt = array_intersect($cls, $klp);

            if (!empty($rt)) {
                return $this->redirect(['controller' => 'admin/primarycentral', 'action' => 'primaryexamcontrolview']);
            } else {

                return $this->redirect(['controller' => 'admin/studentexamresult', 'action' => 'examcontrolviewsubject']);
            }
        } else if ($rolepresent == '12') {

            return $this->redirect(['controller' => 'admin/Primarycentral', 'action' => 'primaryindex']);
        } else if ($rolepresent == '2') {
            return $this->redirect(['controller' => 'admin/Video', 'action' => 'index']);
        }
        $this->viewBuilder()->layout('login');


        if ($this->request->is('post')) {
            $conn = ConnectionManager::get('default');
            $mobile = $this->request->data['mobile'];
            $password = $this->request->data['password'];
            $db_names = DB_NAME;
            // pr($db_names); die;
            $user_detail = "SELECT * FROM `$db_names`.`users` where mobile='$mobile' and confirm_pass='$password'";
            $run_data = $conn->execute($user_detail)->fetch('assoc');
            $db = $run_data['db'];
            if (!empty($db) && $db != 'logins' && $db != $user_db) {
                ConnectionManager::config($db, [
                    'className' => 'Cake\Database\Connection',
                    'driver' => 'Cake\Database\Driver\Mysql',
                    'persistent' => false,
                    'host' => MYSQLHOST,
                    // 'port'=>'3306',
                    'username' => MYSQLUESRNAME,
                    'password' => MYSQLPASSWORD,
                    'database' => $db,
                    'encoding' => 'utf8mb4',
                    'timezone' => 'UTC',
                    'cacheMetadata' => true,
                ]);
                ConnectionManager::drop('default');
                ConnectionManager::get($db);
                \Cake\Datasource\ConnectionManager::alias($db, 'default');
                date_default_timezone_set('Asia/Kolkata');
                $this->loadModel('Users');
                $admin_det = $this->Users->find('all')->first();

                $user_detail = $this->Users->find('all')->where(['mobile' => $user_data_check['mobile']])->first();

                $user_count_check = $this->Users->find('all')->where(['mobile' => $mobile, 'role_id !=' => '2'])->count();
                if ($user_count_check > 1) {
                    $this->Flash->error(__('Mobile number is already exist in other role and school. Contact to administrator'));
                    $this->Auth->logout();
                    return $this->redirect(['controller' => 'logins', 'action' => 'index']);
                }
            }
            $this->loadModel('ClasstimeTabs');
            $this->loadModel('Classections');
            $user_check = $this->Auth->identify();
            //echo "test"; die;
            if (!empty($user_check) && $user_check['role_id'] == '2') {

                $user = $this->Users->find('all')->where(['mobile' => $user_check['mobile'], 'role_id !=' => 2])->first();
            } else {
                $user = $this->Auth->identify();
            }
            if ($user) {
                $this->Auth->setUser($user);

                if ($this->request->data['remember_me'] == 1) {
                    $this->Cookie->write('remember_me', $this->request->data['remember_me'], true, '1 month');
                    $this->Cookie->write('email', $this->request->data['email'], true, '1 month');
                    $this->Cookie->write('password', $this->request->data['password'], true, '1 month');


                    // $this->Cookie->write('rememberMe', $cookie, true, "1 week");
                } else {
                    $this->Cookie->write('remember_me', '', false, 1000);
                    $this->Cookie->write('email', '', false, 1000);
                    $this->Cookie->write('password', '', false, 1000);
                }

                $rolepresent = $this->request->session()->read('Auth.User.role_id');
                //  pr($rolepresent);die;
                if ($rolepresent == '101') {

                    return $this->redirect(['controller' => 'admin/Users', 'action' => 'add']);
                } else if ($rolepresent == '5' || $rolepresent == '8') {

                    return $this->redirect(['controller' => 'admin/dashboards/adminbranch', 'action' => 'adminbranch']);
                    // return $this->redirect(['controller' => 'admin/studentfees', 'action' => 'view']);

                } else if ($rolepresent == '6') {

                    return $this->redirect(['controller' => 'admin/dashboards/adminbranch', 'action' => 'adminbranch']);
                } else if ($rolepresent == '7') {
                    return $this->redirect(['controller' => 'admin/Issuebooks', 'action' => 'index']);
                } else if ($rolepresent == '4') {
                    return $this->redirect(['controller' => 'admin/exam', 'action' => 'index']);
                    // return $this->redirect(['controller' => 'admin/studentexamresult', 'action' => 'examcontrolview2']);
                } else if ($rolepresent == '13') {
                    return $this->redirect(['controller' => 'admin/exam', 'action' => 'index']);
                    // return $this->redirect(['controller' => 'admin/studentexamresult', 'action' => 'examcontrolview2']);
                } else if ($rolepresent == '14') {

                    return $this->redirect(['controller' => 'admin/permissionmodules', 'action' => 'index']);
                } else if ($rolepresent == '15') {

                    return $this->redirect(['controller' => 'admin/enquires', 'action' => 'index']);
                } else if ($rolepresent == '1') {

                    return $this->redirect(['controller' => 'admin/dashboards', 'action' => 'adminbranch']);
                } else if ($rolepresent == '105') {

                    return $this->redirect(['controller' => 'admin/dashboards/headbranch', 'action' => 'headbranch']);
                } else if ($rolepresent == '18') {

                    return $this->redirect(['controller' => 'admin/indent', 'action' => 'index']);
                } else if ($rolepresent == '19') {

                    return $this->redirect(['controller' => 'admin/indent', 'action' => 'index']);
                } else if ($rolepresent == '3') {

                    $tid = $this->request->session()->read('Auth.User.tech_id');
                    $csec = $this->ClasstimeTabs->find('all')->where(['FIND_IN_SET(\'' . $tid . '\',ClasstimeTabs.employee_id)'])->toarray();

                    foreach ($csec as $key => $value) {
                        $csection = $this->Classections->find('all')->contain(['Classes', 'Sections'])->where(['Classections.id' => $value['class_id']])->order(['Classections.id' => 'ASC'])->first();
                        $classs[] = $csection['class_id'];
                    }

                    $cls = array_unique($classs);
                    $klp = array('18', '19', '30', '1', '2', '3', '4', '6');
                    $rt = array_intersect($cls, $klp);

                    if (!empty($rt)) {
                        return $this->redirect(['controller' => 'admin/primarycentral', 'action' => 'primaryexamcontrolview']);
                    } else {
                        return $this->redirect(['controller' => 'admin/studentexamresult', 'action' => 'examcontrolviewsubject']);
                    }
                    
                } else if ($rolepresent == '12') {
                    return $this->redirect(['controller' => 'admin/Primarycentral', 'action' => 'primaryindex']);
                } else if ($rolepresent == '16') {
                    if ($admin_det->is_payroll == 'Y') {
                        return $this->redirect(['controller' => 'admin/payroll', 'action' => 'salarysummary']);
                    } else {
                        $this->Flash->error(__('You are not authorized'));
                        $this->Auth->logout();
                    }
                } else if ($rolepresent == '17') {
                    return $this->redirect(['controller' => 'admin/report', 'action' => 'employeesattnreport']);
                } else if ($rolepresent == '2') {
                    return $this->redirect(['controller' => 'admin/Video', 'action' => 'index']);
                } else if ($rolepresent == '10') {
                    $this->Flash->error(__('Invalid email or password, try again'));
                    $this->Auth->logout();
                    return $this->redirect(['controller' => 'logins', 'action' => 'index']);
                } else if ($rolepresent == '11') {
                    $this->Flash->error(__('Invalid email or password, try again'));
                    $this->Auth->logout();
                    return $this->redirect(['controller' => 'logins', 'action' => 'index']);
                }
                $this->set('user', $user['user_name']);
                $roleidpast = $this->request->session()->read('role');
                if ($roleidpast == $rolepresent) {
                    return $this->redirect($this->request->session()->read('redirectUrl'));
                    $this->request->session()->delete('redirectUrl');
                    $this->request->session()->delete('role');

                } else {
                    // echo 'Rupam';die;
                    return $this->redirect(['controller' => 'admin/dashboards', 'action' => 'index']);
                    $this->request->session()->delete('redirectUrl');
                    $this->request->session()->delete('role');
                }
            } else {
                $this->Flash->error(__('Invalid email or password, try again'));
                return $this->redirect($this->referer());
                // return $this->redirect('/' . $db);
            }
        }
        $remember_me = $this->Cookie->read('remember_me');
        $email = $this->Cookie->read('email');
        $password = $this->Cookie->read('password');
        $this->set(compact('email', 'password', 'remember_me'));
    }

    public function index($db = null)
    {
        $user = $this->Auth->user();
        if ($user) {
            $db = $this->request->session()->read('Auth.User.db');
            if ($db != DB_NAME) {
                $role = $this->request->session()->read('Auth.User.role_id');
                $this->request->session()->write('role', $role);
                $this->request->session()->write('redirectUrl', $this->referer());
                $this->Auth->logout();
                if ($role != 101) {
                    return $this->redirect('/' . $db);
                }
                return $this->redirect('/');
            }
        }
        $this->loadModel('Schools');
        $schoolstatus = $this->Schools->find('all')->where(['school_database' => $db])->first();

        if ($schoolstatus['status'] == 'N') {
            echo '<img src="' . SITE_URL . 'img/awserror.png">';
            die;
        }
        if (empty($db)) {
            $db = DB_NAME;
        }
        $this->set(compact('db'));
        $rolepresent = $this->request->session()->read('Auth.User.role_id');

        $user_db = $this->request->session()->read('Auth.User.db');
        if (!empty($rolepresent)) {
            $this->loadModel('ClasstimeTabs');
            $this->loadModel('Classections');
        }
        if ($rolepresent == '5' || $rolepresent == '8') {
            return $this->redirect(['controller' => 'admin/studentfees', 'action' => 'view']);
        } else if ($rolepresent == '6') {
            return $this->redirect(['controller' => 'admin/Employeeattendance', 'action' => 'rolesubstitute']);
        } else if ($rolepresent == '7') {

            return $this->redirect(['controller' => 'admin/Issuebooks', 'action' => 'index']);
        } else if ($rolepresent == '4') {
            return $this->redirect(['controller' => 'admin/exam', 'action' => 'index']);
        } else if ($rolepresent == '13') {
            return $this->redirect(['controller' => 'admin/exam', 'action' => 'index']);
        } else if ($rolepresent == '14') {
            return $this->redirect(['controller' => 'admin/permissionmodules', 'action' => 'index']);
        } else if ($rolepresent == '15') {
            return $this->redirect(['controller' => 'admin/enquires', 'action' => 'index']);
        } else if ($rolepresent == '18') {
            if ($admin_det->is_store == 'Y') {
                return $this->redirect(['controller' => 'admin/purchaseorder', 'action' => 'index']);
            } else {
                $this->Flash->error(__('You are not authorized'));
                $this->Auth->logout();
            }
        } else if ($rolepresent == '19') {

            return $this->redirect(['controller' => 'admin/indent', 'action' => 'index']);
        } else if ($rolepresent == '3') {
            $tid = $this->request->session()->read('Auth.User.tech_id');
            $csec = $this->ClasstimeTabs->find('all')->where(['FIND_IN_SET(\'' . $tid . '\',ClasstimeTabs.employee_id)'])->toarray();

            foreach ($csec as $key => $value) {
                $csection = $this->Classections->find('all')->contain(['Classes', 'Sections'])->where(['Classections.id' => $value['class_id']])->order(['Classections.id' => 'ASC'])->first();
                $classs[] = $csection['class_id'];
            }

            $cls = array_unique($classs);
            $klp = array('18', '19', '30', '1', '2', '3', '4', '6');
            $rt = array_intersect($cls, $klp);

            if (!empty($rt)) {
                return $this->redirect(['controller' => 'admin/primarycentral', 'action' => 'primaryexamcontrolview']);
            } else {
                return $this->redirect(['controller' => 'admin/studentexamresult', 'action' => 'examcontrolviewsubject']);
            }
        } else if ($rolepresent == '12') {

            return $this->redirect(['controller' => 'admin/Primarycentral', 'action' => 'primaryindex']);
        } else if ($rolepresent == '2') {
            return $this->redirect(['controller' => 'admin/Video', 'action' => 'index']);
        }

        $this->viewBuilder()->layout('login');
        if ($this->request->is('post')) {

            $db = $this->request->data['db'];
            if (!empty($db) && $db != 'logins' && $db != $user_db) {
                //  pr($db); die;
                ConnectionManager::config($db, [
                    'className' => 'Cake\Database\Connection',
                    'driver' => 'Cake\Database\Driver\Mysql',
                    'persistent' => false,
                    'host' => MYSQLHOST,
                    'username' => MYSQLUESRNAME,
                    'password' => MYSQLPASSWORD,
                    'database' => $db,
                    'encoding' => 'utf8mb4',
                    'timezone' => 'UTC',
                    'cacheMetadata' => true,
                ]);
                ConnectionManager::drop('default');
                ConnectionManager::get($db);
                \Cake\Datasource\ConnectionManager::alias($db, 'default');
                date_default_timezone_set('Asia/Kolkata');
                $this->loadModel('Users');
                $admin_det = $this->Users->find('all')->where(['role_id' => 1])->first();
            }
            $this->loadModel('ClasstimeTabs');
            $this->loadModel('Classections');
            $user = $this->Auth->identify();
            $admin_det = $this->Users->find('all')->where(['role_id' => 1])->first();
            if ($user) {
                $this->Auth->setUser($user);

                if ($this->request->data['remember_me'] == 1) {
                    $this->Cookie->write('remember_me', $this->request->data['remember_me'], true, '1 month');
                    $this->Cookie->write('email', $this->request->data['email'], true, '1 month');
                    $this->Cookie->write('password', $this->request->data['password'], true, '1 month');
                    // $this->Cookie->write('rememberMe', $cookie, true, "1 week");
                } else {
                    $this->Cookie->write('remember_me', '', false, 1000);
                    $this->Cookie->write('email', '', false, 1000);
                    $this->Cookie->write('password', '', false, 1000);
                }

                $rolepresent = $this->request->session()->read('Auth.User.role_id');
                // pr($rolepresent);die;
                if ($rolepresent == '101') {

                    return $this->redirect(['controller' => 'admin/Users', 'action' => 'add']);
                } else if ($rolepresent == '5' || $rolepresent == '8') {
                    return $this->redirect(['controller' => 'admin/dashboards/adminbranch', 'action' => 'adminbranch']);
                } else if ($rolepresent == '6') {
                    return $this->redirect(['controller' => 'admin/dashboards/adminbranch', 'action' => 'adminbranch']);
                } else if ($rolepresent == '7') {
                    return $this->redirect(['controller' => 'admin/Issuebooks', 'action' => 'index']);
                } else if ($rolepresent == '4') {
                    return $this->redirect(['controller' => 'admin/exam', 'action' => 'index']);
                } else if ($rolepresent == '13') {
                    return $this->redirect(['controller' => 'admin/exam', 'action' => 'index']);
                } else if ($rolepresent == '14') {
                    return $this->redirect(['controller' => 'admin/permissionmodules', 'action' => 'index']);
                } else if ($rolepresent == '15') {
                    return $this->redirect(['controller' => 'admin/enquires', 'action' => 'index']);
                } else if ($rolepresent == '1') {
                    return $this->redirect(['controller' => 'admin/dashboards', 'action' => 'adminbranch']);
                } else if ($rolepresent == '105') {
                    return $this->redirect(['controller' => 'admin/dashboards/headbranch', 'action' => 'headbranch']);
                } else if ($rolepresent == '18') {
                    return $this->redirect(['controller' => 'admin/indent', 'action' => 'index']);
                } else if ($rolepresent == '19') {
                    return $this->redirect(['controller' => 'admin/indent', 'action' => 'index']);
                } else if ($rolepresent == '3') {
                    $tid = $this->request->session()->read('Auth.User.tech_id');
                    $csec = $this->ClasstimeTabs->find('all')->where(['FIND_IN_SET(\'' . $tid . '\',ClasstimeTabs.employee_id)'])->toarray();

                    foreach ($csec as $key => $value) {
                        $csection = $this->Classections->find('all')->contain(['Classes', 'Sections'])->where(['Classections.id' => $value['class_id']])->order(['Classections.id' => 'ASC'])->first();
                        $classs[] = $csection['class_id'];
                    }

                    $cls = array_unique($classs);
                    $klp = array('18', '19', '30', '1', '2', '3', '4', '6');
                    $rt = array_intersect($cls, $klp);

                    if (!empty($rt)) {
                        return $this->redirect(['controller' => 'admin/primarycentral', 'action' => 'primaryexamcontrolview']);
                    } else {
                        return $this->redirect(['controller' => 'admin/studentexamresult', 'action' => 'examcontrolviewsubject']);
                    }
                } else if ($rolepresent == '12') {
                    return $this->redirect(['controller' => 'admin/Primarycentral', 'action' => 'primaryindex']);
                } else if ($rolepresent == '16') {
                    if ($admin_det->is_payroll == 'Y') {
                        return $this->redirect(['controller' => 'admin/payroll', 'action' => 'salarysummary']);
                    } else {
                        $this->Flash->error(__('You are not authorized'));
                        $this->Auth->logout();
                    }
                } else if ($rolepresent == '17') {
                    return $this->redirect(['controller' => 'admin/report', 'action' => 'employeesattnreport']);
                } else if ($rolepresent == '2') {
                    return $this->redirect(['controller' => 'admin/Video', 'action' => 'index']);
                } else if ($rolepresent == '10') {
                    $this->Flash->error(__('Invalid email or password, try again'));
                    $this->Auth->logout();
                    return $this->redirect(['controller' => 'logins', 'action' => 'index']);
                } else if ($rolepresent == '11') {
                    $this->Flash->error(__('Invalid email or password, try again'));
                    $this->Auth->logout();
                    return $this->redirect(['controller' => 'logins', 'action' => 'index']);
                }
                $this->set('user', $user['user_name']);
                $roleidpast = $this->request->session()->read('role');
                if ($roleidpast == $rolepresent) {
                    return $this->redirect($this->request->session()->read('redirectUrl'));
                    $this->request->session()->delete('redirectUrl');
                    $this->request->session()->delete('role');
                } else {
                    return $this->redirect(['controller' => 'admin/dashboards', 'action' => 'index']);
                    $this->request->session()->delete('redirectUrl');
                    $this->request->session()->delete('role');
                }
            } else {
                $this->Flash->error(__('Invalid email or password, try again'));
                return $this->redirect($this->referer());
            }
        }
        $remember_me = $this->Cookie->read('remember_me');
        $email = $this->Cookie->read('email');
        $password = $this->Cookie->read('password');
        $this->set(compact('email', 'password', 'remember_me'));
    }

    public function logout()
    {
        $db = $this->request->session()->read('Auth.User.db');
        $role = $this->request->session()->read('Auth.User.role_id');
        $this->request->session()->write('role', $role);
        $this->request->session()->write('redirectUrl', $this->referer());
        $this->Auth->logout();
        return $this->redirect('/logins');
    }


    public function forgot()
    {
        $this->viewBuilder()->layout('login');
        $email = $this->request->data['email'];
        $userDatas = $this->Users->find('all')->where(['email' => $email])->first();

        if (isset($userDatas) && !empty($userDatas)) {

            $fkey = rand(1, 10000);
            $conn = ConnectionManager::get('default');
            $detail = 'UPDATE `users` SET `fkey` ="' . $fkey . '" WHERE `users`.`email` ="' . $email . '"';
            $results = $conn->execute($detail);
            $mid = base64_encode(base64_encode($fkey));
            $url = SITE_URL . "logins/forgetcpass/" . $mid;
            $subject = 'Forgot Password';
            //set header
            $from = 'admin@idsprime.com';
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: <' . $from . '>' . "\r\n";
            //set message
            $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Mail</title>
            </head><body style="margin:0px; padding:0px; font-family:Arial, Helvetica, sans-serif">
            <div style=" text-align:left; font-size:15px; margin:40px 0;">
            <b><a style=" color:#2586a2;"  href="' . $url . '">Click here to reset your password</a></b>
            </div>
            ';

            echo mail($email, $subject, $message, $headers);
            $this->Flash->success(__('Your has been Updated on your Email ID.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__("This Email ID doesn't exist in database"));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function forgetcpass()
    {
        $this->viewBuilder()->layout('forgetcpass');
    }

    public function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public function setpass()
    {
        $studata = $this->Users->find()->where(['Users.role_id' => '2', 'Users.password' => '2y'])->select(['email', 'id'])->toArray();
        $i = 0;
        foreach ($studata as $val) {
            $hasher = new DefaultPasswordHasher();
            $newpassword = $hasher->hash($val['email']);
            $user = $val['email'];
            $ids = $val['id'];
            $conn = ConnectionManager::get('default');
            $detail1 = 'UPDATE `users` SET `password` ="' . $newpassword . '",`confirm_pass` ="' . $user . '" WHERE `users`.`id` = "' . $ids . '" AND `users`.`email` = "' . $user . '"';
            if ($conn->execute($detail1)) {
                echo $i++;
            }
        }
    }
}
