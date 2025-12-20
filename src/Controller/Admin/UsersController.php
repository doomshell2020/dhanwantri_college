<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;

class UsersController extends AppController
{

    public function login()
    {
        $this->viewBuilder()->layout('login');
        return $this->redirect('/logins');
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

    public function newdbcreate($mysqlUserName, $mysqlPassword, $clonedbname, $newdbname)
    {
        /********************* START CONFIGURATION *********************/
        $DB_SRC_HOST = MYSQLHOST;
        $DB_SRC_USER = $mysqlUserName;
        $DB_SRC_PASS = $mysqlPassword;
        $DB_SRC_NAME = $clonedbname;
        $DB_DST_HOST = MYSQLHOST;
        $DB_DST_USER = $mysqlUserName;
        $DB_DST_PASS = $mysqlPassword;
        $DB_DST_NAME = $newdbname;
        /*********************** GRAB OLD SCHEMA ***********************/
        $db1 = mysqli_connect($DB_SRC_HOST, $DB_SRC_USER, $DB_SRC_PASS) or die($db1->error);
        mysqli_select_db($db1, $DB_SRC_NAME) or die($db1->error);
        $result = mysqli_query($db1, "SHOW TABLES;") or die($db1->error);
        $buf = "SET foreign_key_checks = 0;\n";
        $constraints = '';
        while ($row = mysqli_fetch_array($result)) {
            $table = $row[0];
            $result2 = mysqli_query($db1, "SHOW CREATE TABLE `$table`;") or die($db1->error);
            $res = mysqli_fetch_array($result2);
            $buf .= $res[1] . ";\n";
        }
        $buf .= "SET foreign_key_checks = 1;";
        $db2 = mysqli_connect($DB_DST_HOST, $DB_DST_USER, $DB_DST_PASS) or die($db2->error);
        mysqli_select_db($db2, $DB_DST_NAME) or die($db2->error);
        $queries = explode(';', $buf);
        foreach ($queries as $query) {
            $trimmed_query = trim($query);
            if (!empty($trimmed_query)) {
                if (!mysqli_query($db2, $trimmed_query)) {
                    die(mysqli_error($db2));
                }
            }
        }
        return;
    }






    public function clonedatatables()
    {
        $this->viewBuilder()->layout('admin');
        $connection = ConnectionManager::get('default');
        $results = $connection->execute('SHOW DATABASES')->fetchAll('assoc');
        $this->set('results', $results);
        if ($this->request->is(['post', 'put'])) {
            $clone_from = $this->request->data['clonefrom'];
            $clone_to = $this->request->data['cloneto'];

            foreach ($this->request->data['datatables'] as $value) {
                $copy_qry = "INSERT $clone_to.`$value` SELECT * FROM $clone_from.`$value`";
                //
                // echo $copy_qry; die;
                $connection->execute($copy_qry);
            }
            return $this->redirect(['controller' => 'users', 'action' => 'clonedatatables']);
        }
    }

    public function tablesfetcheddata()
    {
        $dbname = $this->request->data['dbname'];
        //$dbname = "canvas";
        $this->connection($dbname);
        $tables = ConnectionManager::get($dbname)->schemaCollection()->listTables();
        $this->set('tables', $tables);
    }

    public function add($id = null)
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Schools');
        $this->loadModel('Board');
        $this->loadModel('States');

        $companies = $this->Schools->find('all')->order(['id' => 'DESC'])->toarray();

        $franchise_schools = $this->Schools->find('list', array('keyField' => 'school_database', 'valueField' => 'school_name'))->where(['franchise_type' => '0'])->toarray();

        $allfranchise_schools = $this->Schools->find('list', array('keyField' => 'school_database', 'valueField' => 'school_name'))->toarray();

        $states = $this->States->find('list', array('keyField' => 'id', 'valueField' => 'name'))->toarray();

        $boards = $this->Board->find('list', array('keyField' => 'id', 'valueField' => 'name'))->toarray();

        $this->set(compact(['companies', 'boards', 'franchise_schools', 'states', 'allfranchise_schools']));
        // $this->loadModel('Schools');
        if (!empty($id)) {
            // pr($this->request->data);die;
            $school = $this->Schools->get($id);
            $cmp_users = $this->Users->find('all')->where(['c_id' => $id])->first();
            $school->user_name = $cmp_users['user_name'];
            $school->email = $cmp_users['email'];
            $school->password = $cmp_users['confirm_pass'];
            $school->school_contact = $cmp_users['mobile'];
            $school->db = $cmp_users['db'];
            $school->city = $cmp_users['city'];
            $school->state = $cmp_users['state'];
            $school->username = $cmp_users['user_name'];
            $school->is_hostel = $cmp_users['is_hostel'];
            $school->is_transport = $cmp_users['is_transport'];
            $school->is_payroll = $cmp_users['is_payroll'];
            $school->is_store = $cmp_users['is_store'];
            $boardss = explode(',', $cmp_users->board);
            $school->boards = $boardss;
            // pr($school);die;
            $this->set('school', $school);
        }
        if ($this->request->is(['post', 'put'])) {
            // pr($this->request->data);
            // die;

            try {
                $superadmin = $this->Users->find('all')->where(['role_id' => 101])->first();
                // pr($this->request->data); die;
                // $connection = ConnectionManager::get('default');
                // $results = $connection->execute("SHOW DATABASES LIKE '" . $this->request->data['school_database'] . "'")->fetchAll('assoc');

                // if (empty($results)) {
                //     $dbName = $this->request->data['school_database'];
                //     $clondedbname = $this->request->data['clondedbname'];
                //     $newdbname = $this->request->data['school_database'];
                //     // $connection->execute('CREATE DATABASE ' . $dbName);
                //     $mysqlUserName = MYSQLUESRNAME;
                //     $mysqlPassword = MYSQLPASSWORD;
                //     $mysqlDatabaseName = $dbName;
                //     $command = 'mysql -u' . $mysqlUserName . ' -p' . $mysqlPassword . ' ' . $mysqlDatabaseName;
                //     exec($command, $output = array(), $worked);
                //     if ($worked !== 0) {
                //         $this->Flash->error(__('Error in importing Company'));
                //         return $this->redirect(['action' => 'add']);
                //     }
                //     $this->newdbcreate($mysqlUserName, $mysqlPassword, $clondedbname, $newdbname);
                //     // $this->Flash->error(__('Database Doesnot exist please create database first'));
                //     // return $this->redirect(['controller' => 'users', 'action' => 'add']);
                // } else {
                //     $this->Flash->error(__('Sub Domain Already Register With Company.'));
                //     return $this->redirect(['action' => 'add']);
                // }
                $cmp_data['school_name'] = $this->request->data['school_name'];

                // if ($this->request->data['franchise_school']) {
                //     $get_franchise_id = $this->Schools->find('all')->where(['school_database' => $this->request->data['franchise_school']])->first();
                //     $cmp_data['franchise_type'] = $get_franchise_id['id'];
                // } else {
                //     $cmp_data['franchise_type'] = 0;
                // }

                $cmp_data['franchise_type'] = 0;
                $cmp_data['school_name'] = $this->request->data['school_name'];
                $cmp_data['school_contact'] = $this->request->data['school_contact'];
                $cmp_data['school_address'] = $this->request->data['school_address'];
                $cmp_data['school_database'] = $this->request->data['school_database'];
                $cmp_data['city'] = $this->request->data['city'];
                $cmp_data['state'] = $this->request->data['state'];
                if (empty($id)) {
                    $patch_cmp = $this->Schools->patchEntity($this->Schools->newEntity(), $cmp_data);
                } else {
                    $school_edit = $this->Schools->get($id);
                    $patch_cmp = $this->Schools->patchEntity($school_edit, $cmp_data);
                }
                if ($result = $this->Schools->save($patch_cmp)) {
                    $data['c_id'] = $result->id;
                    $data['is_payroll'] = $this->request->data['is_payroll'];
                    $data['is_store'] = $this->request->data['is_store'];
                    $data['is_hostel'] = 'Y';
                    $data['is_transport'] = $this->request->data['is_transport'];
                    $data['user_name'] = $this->request->data['username'];
                    $data['email'] = $this->request->data['email'];
                    $data['password'] = (new DefaultPasswordHasher)->hash($this->request->data['password']);
                    $data['mobile'] = $this->request->data['school_contact'];
                    $data['board'] = implode(',', $this->request->data['boards']);
                    $data['confirm_pass'] = $this->request->data['password'];
                    $data['state'] = $this->request->data['state'];
                    $data['city'] = $this->request->data['city'];
                    $data['is_admin'] = 'Y';
                    $data['role_id'] = '1';


                    $data['db'] = $this->request->data['school_database'];
                    $data['academic_year'] = $superadmin['academic_year'];
                    $email_exist = $this->Users->exists(['email' => $data['email']]);
                    if ($email_exist) {
                        $this->Flash->error(__('Email ' . $data['email'] . ' already exist'));
                        return $this->redirect(['controller' => 'users', 'action' => 'add']);
                    }
                    if ($data['school_database'] == 'test' || $data['school_database'] == 'default') {
                        $this->Flash->error(__('Please enter different database name'));
                        return $this->redirect(['controller' => 'users', 'action' => 'add']);
                    }

                    if (empty($id)) {

                        $patch_user = $this->Users->patchEntity($this->Users->newEntity(), $data);
                        if ($this->Users->save($patch_user)) {
                            $passwordss = (new DefaultPasswordHasher)->hash($this->request->data['password']);
                            $this->connection($cmp_data['school_database']);
                            $conect_new = ConnectionManager::get($cmp_data['school_database']);

                            $examterm = 1;
                            // $conect_new->execute("Insert into users(c_id,user_name,email,password,role_id,db,mobile,is_payroll,is_store,is_hostel,is_transport,academic_year,is_admin,board,confirm_pass,city,state,examterm) VALUES('" . $data['c_id'] . "','" . $data['user_name'] . "','" . $data['email'] . "','" . $passwordss . "','" . $role_data . "','" . $data['db'] . "','" . $data['mobile'] . "','" . $data['is_payroll'] . "','" . $data['is_store'] . "','" . $data['is_hostel'] . "','" . $data['is_transport'] . "','" . $data['academic_year'] . "','Y','" . $data['board'] . "','" . $data['confirm_pass'] . "','" . $data['city'] . "','" . $data['state'] . "','" . $examterm . "')");


                            $role_datas = '1';
                            $email = 'admin@' . $data['db'] . '.com';
                            $conect_new->execute("Insert into users(c_id,user_name,email,password,role_id,db,mobile,is_payroll,is_store,is_hostel,is_transport,academic_year,is_admin,board,confirm_pass,city,state,examterm) VALUES('" . $data['c_id'] . "','Admin','" . $data['email'] . "','" . $passwordss . "','" . $role_datas . "','" . $data['db'] . "','" . $data['mobile'] . "','" . $data['is_payroll'] . "','" . $data['is_store'] . "','" . $data['is_hostel'] . "','" . $data['is_transport'] . "','" . $data['academic_year'] . "','Y','" . $data['board'] . "','" . $data['confirm_pass'] . "','" . $data['city'] . "','" . $data['state'] . "','" . $examterm . "')");

                            $this->Flash->success(__('School Created successfully'));
                            return $this->redirect(['controller' => 'users', 'action' => 'add']);
                        }
                    } else {
                        $users_cid = $this->Users->find('all')->where(['c_id' => $id])->first();
                        if (empty($users_cid)) {
                            $users_cid = $this->Users->newEntity();
                        }
                        $patch_user = $this->Users->patchEntity($users_cid, $data);
                        if ($this->Users->save($patch_user)) {
                            $passwordss = (new DefaultPasswordHasher)->hash($this->request->data['password']);
                            $this->connection($cmp_data['school_database']);
                            $conn = ConnectionManager::get($cmp_data['school_database']);
                            $conn->execute("UPDATE users SET user_name='" . $data['user_name'] . "',email='" . $data['email'] . "',password='" . $passwordss . "',db='" . $data['db'] . "',mobile='" . $data['mobile'] . "',is_payroll='" . $data['is_payroll'] . "',is_store='" . $data['is_store'] . "',is_hostel='" . $data['is_hostel'] . "',is_transport='" . $data['is_transport'] . "',academic_year='" . $data['academic_year'] . "',is_admin='" . $data['is_admin'] . "',board='" . $data['board'] . "',confirm_pass='" . $data['confirm_pass'] . "',state='" . $data['state'] . "',city='" . $data['city'] . "' WHERE role_id='1' AND c_id ='" . $id . "'");

                            $this->Flash->success(__('College Upadted successfully'));
                            return $this->redirect(['controller' => 'users', 'action' => 'add']);
                        }
                    }
                }
            } catch (\PDOException $e) {
                $this->Flash->error(__($e));
                return $this->redirect(['controller' => 'users', 'action' => 'add']);
            }
        }
    }

    public function gettable()
    {
        $this->loadModel('Examtemplates');
        $this->loadModel('Examtemplategroup');

        $examname = $this->request->data['examname'];
        $sch_bord = $this->request->data['sch_bord'];
        $arra = count($sch_bord);

        $group_name = $this->Examtemplategroup->find('all')->where(['status' => 1])->toarray();

        if ($examname == 1) {

            $grname = $this->Examtemplates->find('all')->where(['term' => $examname])->toarray();
        } else {

            $grname = $this->Examtemplates->find('all')->toarray();
        }
        // pr($term2grname);die;
        $this->set('grname', $grname);
        $this->set('examname', $examname);
        $this->set('arra', $arra);
        $this->set('group_name', $group_name);
    }

    public function addStudent()
    {
        $this->loadModel('Students');
        $this->loadModel('Users');
        try {
            $students = $this->Students->find('all')->where(['status' => 'Y'])->toarray();
            $admin = $this->Users->find('all')->where(['role_id' => 1])->first();
            foreach ($students as $student) {
                $data = [];
                $data['student_id'] = $student['id'];
                $data['user_name'] = $student['fname'];
                if ($student['board_id'] == 1) {
                    $data['email'] = 'C' . $student['enroll'];
                } else if ($student['board_id'] == 2) {
                    $data['email'] = 'CAM' . $student['enroll'];
                } else if ($student['board_id'] == 3) {
                    $data['email'] = 'IB' . $student['enroll'];
                }
                $data['password'] = (new DefaultPasswordHasher)->hash($data['email']);
                $data['confirm_pass'] = $data['email'];
                $data['role_id'] = 2;
                $data['db'] = $admin->db;
                $data['c_id'] = $admin->c_id;
                $data['academic_year'] = $admin->academic_year;
                $data['board'] = $student['board_id'];
                $patch = $this->Users->patchEntity($this->Users->newEntity(), $data);
                $this->Users->save($patch);
            }
        } catch (\PDOException $e) {
            pr($e);
            die;
        }
        echo 1;
        die;
    }


    public function changepassword()
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Users');
        $this->loadModel('Classfee');

        $role_id = $this->request->session()->read('Auth.User.role_id');
        $id = $this->request->session()->read('Auth.User.id');
        $ems = $this->Users->find('all')->where(['id' => '1'])->first();
        $academic_year = $ems['academic_year'];
        $email_exists = $this->Users->find('all')->where(['role_id' => $role_id, 'id' => $id])->first();
        $id = $email_exists['id'];
        $this->set('userssid', $id);
        $this->set('role_id', $role_id);

        $classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.academic_year')->group('Classfee.class_id')->order(['Classfee.id' => 'ASC'])->where(['Classfee.academic_year' => $academic_year])->select(['Classfee.qu1_date', 'Classfee.qu2_date', 'Classfee.qu3_date', 'Classfee.qu4_date', 'Classfee.status', 'Classfee.class_id'])->first();

        $this->set('classfee', $classfee);
        $users = $this->Users->get($this->Auth->user('id'));

        $this->set('latefee', $users['latefee']);
        if (isset($id) && !empty($id)) {
            //using for edit
            $user = $this->Users->get($id);
        }
        if ($this->request->is(['post', 'put'])) {
            // pr($this->request->data);die;
            //check old password and new password
            $conn = ConnectionManager::get('default');
            if ((isset($this->request->data['new_password']) && !empty($this->request->data['new_password'])) && (isset($this->request->data['confirm_pass']) && !empty($this->request->data['confirm_pass']))) {
                if ($this->request->data['new_password'] == $this->request->data['confirm_pass']) {
                    $role_id = $this->request->session()->read('Auth.User.role_id');
                    $newpass['password'] = (new DefaultPasswordHasher)->hash($this->request->data['new_password']);
                    $newpass['confirm_pass'] = $this->request->data['new_password'];

                    //change password
                    // $newpass['role_id']=$role_id;
                    $this->request->data['role_id'] = $role_id;
                    $user = $this->Users->patchEntity($user, $newpass);
                    $this->Users->save($user);

                    $mobile = $user['mobile'];
                    $role_id = $user['role_id'];

                    $conn = ConnectionManager::get('default');
                    $detail = 'UPDATE `school_erp`.`users` SET `password` ="' . $newpass['password'] . '",`confirm_pass` ="' . $newpass['confirm_pass'] . '" WHERE `mobile` = "' . $mobile . '" and `role_id` = "' . $role_id . '"';

                    $conn->execute($detail);


                    $this->Flash->success(__('Your Password Successfully Changed !!!!'));
                    return $this->redirect(['controller' => 'users', 'action' => 'changepassword']);
                } else {
                    $this->Flash->error(__("Your new password and confirm password doesn't match, try again."));
                    return $this->redirect(['action' => 'changepassword']);
                }
            } else if ($this->request->data['qu1_date']) {

                $role_id = $this->request->session()->read('Auth.User.role_id');

                $conn = ConnectionManager::get('default');
                $detail = 'UPDATE `users` SET `latefee` ="' . $this->request->data['latefee'] . '" WHERE `role_id` = ' . $role_id;

                $results = $conn->execute($detail);
                $ems = $this->Users->find('all')->where(['id' => '1'])->first();
                $academic_year = $ems['academic_year'];

                $this->request->data['qu1_date'] = date('Y-m-d', strtotime($this->request->data['qu1_date']));
                $this->request->data['qu2_date'] = date('Y-m-d', strtotime($this->request->data['qu2_date']));
                $this->request->data['qu3_date'] = date('Y-m-d', strtotime($this->request->data['qu3_date']));
                $this->request->data['qu4_date'] = date('Y-m-d', strtotime($this->request->data['qu4_date']));
                $conns = ConnectionManager::get('default');
                $details = 'UPDATE `class_fee_allocations` SET `qu1_date`="' . $this->request->data['qu1_date'] . '" , `qu2_date`="' . $this->request->data['qu2_date'] . '" , `qu3_date`="' . $this->request->data['qu3_date'] . '" , `qu4_date`="' . $this->request->data['qu4_date'] . '" WHERE status="Y" and academic_year="' . $academic_year . '"';

                $resultss = $conns->execute($details);
                if ($resultss) {
                    $this->Flash->success(__('Your Profile Successfully Updated !!!!'));
                    return $this->redirect(['controller' => 'users', 'action' => 'changepassword']);
                }
            } else {
                return $this->redirect(['controller' => 'users', 'action' => 'changepassword']);
            }
        } // edit site setting

        $this->set('users', $users);
    }

    public function viewboard($id = null)
    {
         $this->viewBuilder()->layout('admin');
        $this->loadModel('Board');

        if (!empty($id)) {
            $board = $this->Board->get($id);
            $this->set('users_data', $board);
        } 

        // Handle form submission
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->data;

            // Handle logo upload
            if (!empty($data['logo']['tmp_name'])) {
                $ext = pathinfo($data['logo']['name'], PATHINFO_EXTENSION);
                $filename = $data['name'] . $ext;
                $targetPath = WWW_ROOT . $filename;
                move_uploaded_file($data['logo']['tmp_name'], $targetPath);
                $data['logo'] = $filename;
            } else {
                if (!empty($id)) {
                    $data['logo'] = $board->logo; // Keep old logo on edit
                }
            }

            // Handle transparent logo upload
            if (!empty($data['transparent_logo']['tmp_name'])) {
                $ext = pathinfo($data['transparent_logo']['name'], PATHINFO_EXTENSION);
                $filename = 'transparent_logo_' . time() . '.' . $ext;
                $targetPath = WWW_ROOT . 'uploads' . DS . $filename;
                move_uploaded_file($data['transparent_logo']['tmp_name'], $targetPath);
                $data['transparent_logo'] = $filename;
            } else {
                if (!empty($id)) {
                    $data['transparent_logo'] = $board->transparent_logo; // Keep old on edit
                }
            }

            if (!empty($id)) {
                $board = $this->Board->patchEntity($board, $data);
            } else {
                $board = $this->Board->patchEntity($this->Board->newEntity(), $data);
            }

            if ($this->Board->save($board)) {
                $this->Flash->success(__('Board data has been saved successfully.'));
                return $this->redirect(['action' => 'viewboard']);
            } else {
                $this->Flash->error(__('Unable to save board data. Please try again.'));
            }
        }

        // Fetch all boards for table display
        $boards = $this->Board->find('all')->order(['id' => 'DESC'])->toArray();
        $this->set('branches_data', $boards);
    }
}
