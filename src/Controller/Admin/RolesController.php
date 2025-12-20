<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;

class RolesController extends AppController
{
    //initialize component
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Roles');
        $this->loadModel('Users');
        $this->loadModel('Board');
    }

    public function index($id = null)
    {
        $this->viewBuilder()->layout('admin');
        //show data in listing
        $roles = $this->Roles->find('list')->where(['id NOT IN' => ['1', '101', '2', '3']])->order(['name' => 'ASC'])->toarray();
        $this->set('roles', $roles);
        // pr($roles);die;

        $allusers = $this->Users->find('all')->contain(['Roles'])->where(['role_id NOT IN' => ['101', '2', '3']])->toarray();

        $this->set('allusers', $allusers);

        $ems = $this->Users->find('all')->where(['is_admin' => 'Y', 'role_id IN' => ['1', '105']])->first();
        // pr($ems);die;
        $academic_year = $ems['academic_year'];
        $selectboard = explode(',', $ems['board']);
        $board = $this->Board->find('list')->where(['id IN' => $selectboard])->order(['id' => 'DESC'])->toarray();
        $this->set('board', $board);
        $this->set('roles', $roles);

        $this->set('academic_year', $academic_year);
        if (isset($id) && !empty($id)) {
            //using for edit
            $rolesnew = $this->Users->get($id);
            // pr($rolesnew);die;
        } else {
            $rolesnew = $this->Users->newEntity();
        }
        $this->set('rolesnew', $rolesnew);
        if ($this->request->is(['post', 'put'])) {
            // pr($this->request->data);
            // die;
            if ($this->request->data['id']) {
                $id = $this->request->data['id'];
            }

            if ($this->request->data['password'] == $this->request->data['confirm_pass']) {
                $ems = $this->Users->find('all')->where(['is_admin' => 'Y', 'role_id IN' => ['1', '105']])->first();
                $this->request->data['c_id'] = $ems['c_id'];
                $this->request->data['academic_year'] = $ems['academic_year'];
                $this->request->data['db'] = $ems['db'];

                if ($this->request->data['board'] == '') {
                    $this->request->data['board'] = $ems['db'];
                }

                $this->request->data['password'] = (new DefaultPasswordHasher)->hash($this->request->data['password']);
                $modes = $this->Users->patchEntity($rolesnew, $this->request->data);
                // // sanjay code 13 jan 2023
                $users_add = $this->Users->save($modes);
                // pr($users_add); die;

                $username = $users_add['user_name'];
                $cid = $users_add['c_id'];
                $academic_year = $users_add['academic_year'];
                $email = $users_add['email'];
                $password = $users_add['password'];
                $c_password = $users_add['confirm_pass'];
                $cdate = date('Y-m-d H:i:s');
                $roles = $users_add['role_id'];
                $database_name = $users_add['db'];
                $Bord = $users_add['board'];
                $mobile = $users_add['mobile'];

                $conn = ConnectionManager::get('default');
                $dbs= DB_NAME;
                $inserts = "INSERT INTO `$dbs`.`users` (`user_name`,`c_id`,`academic_year`, `email`,`tech_id`, `password`, `confirm_pass`, `created`, `role_id`, `db`,`board`,`mobile`) VALUES
                 ('$username','$cid','$academic_year','$email', NULL,'$password','$c_password', '$cdate',$roles,'$database_name','$Bord','$mobile')";
                // pr($inserts); die;

                $exicute = $conn->execute($inserts);

                if ($users_add) {
                    $this->Flash->success(__('Role Associated User has been updated ,We can now Login from this saved role Login Credentials.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    if ($modes->errors()) {
                        $error_msg = [];
                        foreach ($modes->errors() as $errors) {
                            if (is_array($errors)) {
                                foreach ($errors as $error) {
                                    $error_msg[] = $error;
                                }
                            } else {
                                $error_msg[] = $errors;
                            }
                        }
                        if (!empty($error_msg)) {
                            $this->Flash->error(
                                __("Please fix the following error(s): " . implode("\n \r", $error_msg))
                            );
                        }
                    }
                }
            } else {

                $this->Flash->error(__("Your password and confirm password doesn't match, try again."));
                return $this->redirect(['action' => 'index']);
            }
        }
    }

    public function add($id = null)
    {
        $this->viewBuilder()->layout('admin');
        if (isset($id) && !empty($id)) {
            //using for edit
            $modes = $this->Roles->get($id);
        } else {
            //using for new entry
            $modes = $this->Roles->newEntity();
        }
        if ($this->request->is(['post', 'put'])) {

            pr($this->request->data);
            die;

            // save all data in database
            $modes = $this->Roles->patchEntity($modes, $this->request->data);
            //pr($locations); die;
            if ($this->Roles->save($modes)) {
                $this->Flash->success(__('Roles User has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else { //pr($classes->errors());
                //validation error
                if ($modes->errors()) {
                    $error_msg = [];
                    foreach ($modes->errors() as $errors) {
                        if (is_array($errors)) {
                            foreach ($errors as $error) {
                                $error_msg[] = $error;
                            }
                        } else {
                            $error_msg[] = $errors;
                        }
                    }
                    if (!empty($error_msg)) {
                        $this->Flash->error(
                            __("Please fix the following error(s): " . implode("\n \r", $error_msg))
                        );
                    }
                }
            }
        }

        $this->set('modes', $modes);
    }

    public function sort()
    {
        $this->viewBuilder()->layout('admin');
        $id = $this->request->data[id];
        if (isset($id) && !empty($id)) {
            //using for edit
            $modes = $this->Roles->get($id);
        } else {
            //using for new entry
            $modes = $this->Roles->newEntity();
        }

        if ($this->request->is(['post', 'put'])) {

            //$this->request->data = $this->request->data['sort'];
            $modes->sort = $this->request->data['sort'];

            if ($this->Roles->save($modes)) {
                echo $modes['sort'];
            } else {
                echo 'wrong';
            }
        }
        die;
    }

    //delete functionality
    public function delete($id)
    {
        //$this->request->allowMethod(['post', 'delete']);
        $modes = $this->Users->get($id);
        //delete pariticular entry
        try {

            if ($this->Users->delete($modes)) {

                $this->Flash->success(__('Users with id: {0} has been deleted.', ($id)));
                return $this->redirect(['action' => 'index']);
            }
        } catch (\PDOException $e) {
            //  $error = 'The item you are trying to delete is associated with other records';

            //$this->Session->setFlash(__(' Lader all ready exists), 'flash/Error');
            return $this->redirect(['action' => 'index']);
        }
    }
    //status update functionality
    public function status($id, $status)
    {
        if (isset($id) && !empty($id)) {
            if ($status == 'Y') {

                $status = 'N';
                //status update
                $modes = $this->Roles->get($id);
                $modes->status = $status;
                if ($this->Roles->save($modes)) {
                    $this->Flash->success(__('Roles status has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            } else {
                $status = 'Y';
                //status update
                $modes = $this->Roles->get($id);
                $modes->status = $status;
                if ($this->Roles->save($modes)) {
                    $this->Flash->success(__('Roles status has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
    }
}
