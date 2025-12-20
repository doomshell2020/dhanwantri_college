<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class PermissionmodulesController extends AppController
{
    //initialize component
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Classes');
        $this->loadModel('Sections');
        $this->loadModel('Subjects');
        $this->loadModel('Classections');
        $this->loadModel('Subjectclass');
        $this->loadModel('Assignments');
        $this->loadModel('Employees');
        $this->loadModel('PermissionModules');
        $this->loadModel('Users');
    }

    public function index($id = null)
    {
        // pr($id);die;

        $this->viewBuilder()->layout('admin');
        $employees = $this->Users->find('all')->find('list', ['keyField' => 'id', 'valueField' => 'email'])->where(['Users.role_id !=' => '2'])->order(['Users.user_name' => 'ASC'])->toarray();
        $this->set(compact('employees'));
        if ($id) {
            $employees = $this->Users->find('all')->find('all')->where(['Users.id' => $id])->order(['Users.user_name' => 'ASC'])->first();
            $employees_rollid = $this->Users->find('all')->select(['role_id'])->where(['Users.id' => $id])->order(['Users.user_name' => 'ASC'])->first();
             
            // pr($employees_rollid);die;            
            $username = $employees['user_name'];
            $this->set(compact('username'));
            $this->set(compact('id'));
            $this->set(compact('employees_rollid'));
        }

        if ($this->request->is(['post', 'put'])) {
            // pr($this->request->data); die;
            $modules = sizeof($this->request->data['module']);
            // pr($modules);die;
            $user_id = $this->request->data['user_id'];
            $userTable = TableRegistry::get('PermissionModules');
            $exists = $userTable->exists(['user_id' => $user_id]);
            if ($exists) {
                $conns = ConnectionManager::get('default');
                $quersy = "DELETE FROM `permission_module` WHERE `user_id`='$user_id'";
                $conns->execute($quersy);
            }

            for ($i = 1; $i <= $modules; $i++) {
                $menu = array();
                $featured = array();
                $mod = array();
                $mod = $this->request->data['module' . $i];
                $menu = $this->request->data['menu' . $i];

                $featured = $this->request->data['menu' . $i . 'a'];

                foreach ($menu as $kty => $ddd) {
                    $ter = array();
                    $ter = explode('^', $ddd);
                    $conn = ConnectionManager::get('default');
                    if ($featured[$kty]) {

                        $query = "INSERT INTO `permission_module`(`user_id`, `module`, `menu`, `controller`, `action`, `featured`,`status`) VALUES ('$user_id','$mod[0]','$ter[0]','$ter[1]','$ter[2]','$featured[$kty]','Y')";
                        $module = explode(' ', $mod[0]);
                        $short_name = $module[0];
                        // $query1="INSERT INTO `permissions`(`module`, `menu`, `controller`, `action`,`short_name`) VALUES ('$mod[0]','$ter[0]','$ter[1]','$ter[2]','$short_name')";
                        // $conn->execute($query1);

                    } else {
                        $query = "INSERT INTO `permission_module`(`user_id`, `module`, `menu`, `controller`, `action`,`status`) VALUES ('$user_id','$mod[0]','$ter[0]','$ter[1]','$ter[2]','Y')";
                    }

                    $results = $conn->execute($query);
                }
            }

            if ($this->request->data['naction']) {

                $this->Flash->success(__('Rights Update to User sucessfully.'));
                return $this->redirect(['controller' => 'roles', 'action' => 'index']);
            } else {
                $this->Flash->success(__('Rights Update to User sucessfully.'));
                return $this->redirect(['action' => 'index']);
            }
        }
    }

    public function adjustassign()
    {
        $storeId = "Senior";
        $getdata = $this->Employees->find('all')->where(['FIND_IN_SET(\'' . $storeId . '\',slab_type)'])->toArray();

        $getdata = $this->Employees->find('all')->where(['FIND_IN_SET(\'' . $storeId . '\',slab_type)'])->toArray();
        foreach ($getdata as $kj => $ll) {
            $employees = $this->Users->find('all')->where(['Users.role_id' => '3', 'Users.email' => $ll['username']])->order(['Users.user_name' => 'ASC'])->first();
            $employeesh = $employees['id'];
            if ($employeesh != '') {

                $userTable = TableRegistry::get('PermissionModules');
                $exists = $userTable->exists(['user_id' => $employeesh]);
                if ($exists) {
                } else {

                    $conn = ConnectionManager::get('default');

                    $query = "INSERT INTO `permission_module` (`user_id`, `module`, `menu`, `controller`, `action`, `status`) VALUES ('$employeesh', 'Higher Classes Exam Mangement (VI-XII)', 'Upload Results', 'studentexamresult', 'examcontrolviewsubject', 'Y'), ('$employeesh', 'Assignment Managment', 'Post Home Work', 'assignments', 'index', 'Y'), ('$employeesh', 'Timetable Management', 'Teacher Timetable', 'ClasstimeTabs', 'teachertimetable', 'Y')";
                    $results = $conn->execute($query);
                }
            }
        }
    }
    public function calculatepermission()
    {
        if ($this->request->is(['post', 'put'])) {
            $empid = $this->request->data['empid'];
            $this->set(compact('empid'));
            $employees_rollid = $this->request->data['emp_roleid'];
           // echo  $employees_rollid; die;
            $this->set(compact('employees_rollid'));

            $userTable = TableRegistry::get('PermissionModules');
            $exists = $userTable->exists(['user_id' => $empid]);
            if ($exists) {
                $employees = $this->PermissionModules->find('all')->find('all')->where(['PermissionModules.user_id' => $empid])->order(['PermissionModules.id' => 'ASC'])->toarray();
                $module = array();
                $menu = array();
                $featured = array();
                foreach ($employees as $k => $ty) {

                    if (!in_array($ty['module'], $module)) {
                        $module[] = $ty['module'];
                    }

                    if (!in_array($ty['menu'], $menu)) {
                        $menu[] = $ty['menu'];
                        $featured[] = $ty['featured'];
                    }
                }

                $this->set(compact('module', 'menu', 'featured'));
            } else {
                $module = array();
                $menu = array();
                $this->set(compact('module', 'menu'));
            }
        }
    }
    public function add($subjectid = null)
    {
        $this->loadModel('ClasstimeTabs');

        $er = base64_decode($subjectid);
        $value = explode('/', $er);
        //pr($value); die;
        $getdata = $this->ClasstimeTabs->find('all')->where(['ClasstimeTabs.weekday' => $value[1], 'ClasstimeTabs.tt_id' => $value[0], 'FIND_IN_SET(\'' . $value[2] . '\',ClasstimeTabs.employee_id)'])->toArray();

        //pr($getdata); die;
        $a = array();
        foreach ($getdata as $key => $value2) {
            $a[] = $value2['class_id'];
        }
        //pr($a); die;
        $b = array_unique($a);
        $sec = array();
        $cls = array();
        foreach ($b as $key => $va) {
            $sdf = $this->Classections->find('all')->select(['class_id', 'section_id', 'id'])->contain(['Classes', 'Sections'])->where(['Classections.id' => $va])->first();

            $sec[] = $sdf['section_id'];
            $cls[] = $sdf['class_id'];
        }
        //pr($sec);  pr($cls); die;
        $this->set(compact('sec', 'cls'));

        $this->viewBuilder()->layout('admin');

        $subjectid = $this->Subjects->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Subjects.id' => $value[3]])->toArray();
        // pr($locations); die;
        $this->set(compact('subjectid'));

        if (isset($id) && !empty($id)) {
            //using for edit
            $assignments = $this->Assignments->get($id);
        } else {
            //using for new entry
            $assignments = $this->Assignments->newEntity();
        }
        if ($this->request->is(['post', 'put'])) {
            //pr($this->request->data); die;
            $cid = $this->request->data['class_id'];
            //pr($cid);

            if (!empty($this->request->data['file']['name'])) {
                $filename = $this->request->data['file']['name'];
                $item = $this->request->data['file']['tmp_name'];
                $ext = end(explode('.', $filename));
                $name = md5(time($filename));
                $imagename = $name . '.' . $ext;

                move_uploaded_file($item, "img/" . $imagename);
            }
            foreach ($cid as $vao) {
                $assignments = $this->Assignments->newEntity();
                $dr = explode('-', $vao);

                $this->request->data['class_id'] = $dr[0];
                $this->request->data['section_id'] = $dr[1];
                $this->request->data['file'] = $imagename;

                $session = $this->request->session();
                $role_id = $session->read('Auth.User.role_id');
                $this->request->data['academic_year'] = $session->read('Auth.User.academic_year');

                if ($role_id == '3') {
                    $email = $session->read('Auth.User.email');
                    $emp_id = $this->Employees->find()->select('id')->where(['Employees.email' => $email])->first()->id;

                    $this->request->data['teacher_id'] = $emp_id;
                }
                //pr($this->request->data); die;
                // save all data in database

                $this->request->data['allocate_date'] = date('Y-m-d', strtotime($this->request->data['allocate_date']));
                $this->request->data['due_date'] = date('Y-m-d', strtotime($this->request->data['due_date']));
                $assignments = $this->Assignments->patchEntity($assignments, $this->request->data);

                $this->Assignments->save($assignments);
            }
            //pr($assignments); die;
            $this->Flash->success(__('Your Assignments has been saved.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set('assignments', $assignments);
    }

    public function edit($id = null)
    {

        $this->viewBuilder()->layout('admin');
        $classes = $this->Classes->find('list', ['keyField' => 'id', 'valueField' => 'title'])->where(['Classes.status' => '1'])->toArray();
        // pr($locations); die;
        $assign_details = $this->Assignments->find()->where(['Assignments.id' => $id])->first();
        $subjectid = $this->Subjects->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Subjects.id' => $assign_details['subject_id']])->toArray();
        $sec = explode(',', $assign_details['section_id']);
        $cls = explode(',', $assign_details['class_id']);
        $des = $assign_details['description'];
        $gh = $assign_details['file'];
        $this->set(compact('sec', 'cls', 'des', 'subjectid', 'gh'));

        // pr($assign_details); die;
        $this->set(compact('classes'));
        if (isset($id) && !empty($id)) {
            //using for edit
            $assignments = $this->Assignments->get($id);
        } else {
            //using for new entry
            $assignments = $this->Assignments->newEntity();
        }
        if ($this->request->is(['post', 'put'])) {
            // pr($this->request->data); die;
            $cid = $this->request->data['class_id'];
            //pr($cid);
            $cld = array();
            $sld = array();
            foreach ($cid as $vao) {
                $dr = explode('-', $vao);
                $cld[] = $dr[0];
                $sld[] = $dr[1];
            }
            $this->request->data['class_id'] = implode(',', $cld);
            $this->request->data['section_id'] = implode(',', $sld);
            if (!empty($this->request->data['file']['name'])) {
                $filename = $this->request->data['file']['name'];
                $item = $this->request->data['file']['tmp_name'];
                $ext = end(explode('.', $filename));
                $name = md5(time($filename));
                $imagename = $name . '.' . $ext;
                unlink(WWW_ROOT . 'img/' . $this->request->data['file12']);
                if (move_uploaded_file($item, "img/" . $imagename)) {
                    $this->request->data['file'] = $imagename;
                } else {
                    $this->request->data['file'] = "";
                }
            } else {

                $this->request->data['file'] = $this->request->data['file12'];
            }

            $session = $this->request->session();
            $role_id = $session->read('Auth.User.role_id');
            $this->request->data['academic_year'] = $session->read('Auth.User.academic_year');

            if ($role_id == '3') {
                $email = $session->read('Auth.User.email');
                $emp_id = $this->Employees->find()->select('id')->where(['Employees.email' => $email])->first()->id;

                $this->request->data['teacher_id'] = $emp_id;
            }

            // save all data in database
            $assignments = $this->Assignments->patchEntity($assignments, $this->request->data);
            if ($this->Assignments->save($assignments)) {
                $this->Flash->success(__('Your Assignments has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set('assignments', $assignments);
    }

    public function search()
    {

        //show all data in listing page
        //connection

        //pr($this->request->data); die;
        $conn = ConnectionManager::get('default');

        $class = $this->request->data['class_id'];
        //pr($class); die;
        $subject = $this->request->data['subject'];
        $name = $this->request->data['name'];

        $due_date = $this->request->data['due_date'];

        $detail = "SELECT Assignments.id,Assignments.name,Assignments.class_id,Assignments.section_id,Assignments.file,Assignments.description,Assignments.academic_year,Assignments.allocate_date,Assignments.due_date,Classes.title as classtitle , Sections.title as sectiontitle , Subjects.name as subjectname FROM `assignments` Assignments LEFT JOIN classes Classes ON Assignments.`class_id` = Classes.id LEFT JOIN sections Sections ON Assignments.`section_id` = Sections.id LEFT JOIN subjects Subjects ON Assignments.`subject_id` = Subjects.id    WHERE  1=1 ";
        $cond = ' ';

        if (!empty($class)) {

            $cond .= " AND Assignments.class_id = $class";
        }

        if (!empty($subject)) {

            $cond .= " AND Subjects.name LIKE '" . $subject . "%' ";
        }

        if (!empty($name)) {

            $cond .= " AND Assignments.name LIKE '" . $name . "%' ";
        }

        if (!empty($due_date)) {

            $cond .= " AND Assignments.due_date LIKE '" . $due_date . "%' ";
        }

        $detail = $detail . $cond;

        $SQL = $detail . " ORDER BY Assignments.id ASC";
        $assignment = $conn->execute($SQL)->fetchAll('assoc');
        //pr($assignment); die;
        $this->set('assignments', $assignment);
    }

    public function delete($id)
    {
        //$this->request->allowMethod(['post', 'delete']);
        $classes = $this->Assignments->get($id);
        //delete pariticular entry
        if ($this->Assignments->delete($classes)) {
            $this->Flash->success(__(' Assignments with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function find_section($id = null)
    {

        $classid = $this->request->data['id'];
        $this->viewBuilder()->layout('admin');
        $sections = $this->Classections->find('list', [
            'keyField' => 'Sections.id',
            'valueField' => 'Sections.title',
        ])->contain(['Sections'])->where(['Classections.class_id' => $classid])->order(['Sections.title' => 'ASC'])->toArray();

        echo "<option value=''>Select Section</option>";
        foreach ($sections as $sections => $value) {
            echo "<option value=" . $sections . ">" . $value . "</option>";
        }
        die;
    }

    public function find_subjects($id = null)
    {

        $classid = $this->request->data['ids'];
        $this->viewBuilder()->layout('admin');
        $subject = $this->Subjectclass->find('all')->contain(['Subjects'])->where(['Subjectclass.class_id' => $classid])->order(['Subjects.name' => 'ASC'])->toArray();
        echo "<option value=''>Select Section</option>";
        foreach ($subject as $sections => $value) {
            echo "<option value=" . $value['Subjects']['id'] . ">" . $value['Subjects']['name'] . "</option>";
        }
        die;
    }
}
