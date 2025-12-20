<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';

class ClassfeeController extends AppController
{
    //initialize component
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Classfee');
        $this->loadModel('Classes');
        $this->loadModel('Subjects');
        $this->loadModel('Subjectclass');
        $this->loadModel('Feesheads');
        $this->loadModel('Classections');
        $this->loadModel('Users');
        $this->loadModel('Boards');
    }
    public function index($id = null)
    {

        $this->viewBuilder()->layout('admin');
        //show data in listing
        $this->loadModel('Classes');
        $this->loadModel('Classfee');

        $rolepresent = $this->request->session()->read('Auth.User.role_id');

        // if ($rolepresent == '1' || $rolepresent == '6') {
        $classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.academic_year')->group('Classfee.slab')->order(['Classes.sort' => 'ASC', 'Classfee.slab' => 'ASC'])->select(['qu1_fees' => 'Classfee.qu1_fees', 'qu2_fees' => 'Classfee.qu2_fees', 'qu3_fees' => 'Classfee.qu3_fees', 'qu4_fees' => 'Classfee.qu4_fees', 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.qu1_date', 'Classfee.qu2_date', 'Classfee.qu3_date', 'Classfee.qu4_date', 'Classfee.status', 'Classfee.class_id', 'Classfee.slab'])->toarray();
        // pr($classfee);exit;

        // } 
        // pr($classfee); die;
        $this->set('classfee', $classfee);
    }

    public function find_fee()
    {
        $selectid = $this->request->data['id'];
        if ($selectid == '1') {
            $feesheads = $this->Feesheads->find('all')->where(['type' => '2'])->order(['id' => 'ASC'])->toarray();
            echo $feesheads[0]['cbse_fee'] . ',' . $feesheads[1]['cbse_fee'] . ',' . $feesheads[2]['cbse_fee'];
            die;
        } else if ($selectid == '2') {
            $feesheads = $this->Feesheads->find('all')->where(['type' => '2'])->order(['id' => 'ASC'])->toarray();
            echo $feesheads[0]['cambridge_fee'] . ',' . $feesheads[1]['cambridge_fee'] . ',' . $feesheads[2]['cambridge_fee'];
            die;
        } else if ($selectid == '3') {
            $feesheads = $this->Feesheads->find('all')->where(['type' => '2'])->order(['id' => 'ASC'])->toarray();
            echo $feesheads[0]['ibdp_fee'] . ',' . $feesheads[1]['ibdp_fee'] . ',' . $feesheads[2]['ibdp_fee'];
            die;
        } else {
            echo '0,0,0';
            die;
        }
        die;
    }

    // this is use to edit classfee
    public function edit($id = null)
    {
        $this->viewBuilder()->layout('admin');
        $subjectclasses_data = $this->Subjectclass->find('list', [
            'keyField' => 'Classes.id',
            'valueField' => 'Classes.title',
        ])->contain(['Classes'])->order(['Classes.id' => 'ASC'])->toarray();
        //$this->paginate($service_data);
        $this->set('classlist', $subjectclasses_data);
        $user = $this->Users->find('all')->where(['Users.role_id' => '1'])->first();
        $acedmicyear = $user['academic_year'];
        $this->set('acedmicyearpresent', $acedmicyear);
        $subjectclasses_data = $this->Classfee->find('all')->where(['id' => $id])->first()->toarray();
        $slab = $subjectclasses_data['slab'];
        $classid = $subjectclasses_data['class_id'];
        $subjectclaa = $this->Classfee->find('all')->contain(['Classes'])->where(['Classfee.slab' => $slab])->group(['Classfee.class_id'])->order(['Classes.sort' => 'ASC'])->toarray();
        $this->set('subjectclaa', $subjectclaa);
        $classt = $this->Classes->find('all')->where(['id' => $classid])->first()->toarray();
        $this->set('classtitle', $classt['title']);
        $academic_year = $subjectclasses_data['academic_year'];
        $alldata = $this->Classfee->find('all')->contain(['Feesheads'])->where(['class_id' => $classid, 'academic_year' => $academic_year])->toarray();
        $this->set('alldata', $alldata);
        $arrayOfIds = ['1', '2'];
        $feesheads = $this->Feesheads->find('all')->where(['type IN' => $arrayOfIds])->order(['id' => 'ASC'])->toarray();
        $this->set('feesheads', $feesheads);
        $this->set('id', $id);

        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->find('all')->where(['Users.role_id' => '1'])->first();
            $acedmicyear = $user['academic_year'];
            if ($this->request->data['submit'] == "Update") {

                $slab = $this->request->data['slab'];

                $academic_year = $this->request->data['academic_year'];
                $romms = sizeof($this->request->data['class_id']);

                for ($si = 0; $si < $romms; $si++) {
                    $conn = ConnectionManager::get('default');
                    $conn->execute("DELETE FROM class_fee_allocations WHERE academic_year='" . $academic_year . "' AND class_id='" . $this->request->data['class_id'][$si] . "' AND slab='" . $this->request->data['slab'] . "'");

                    $peopleTable = TableRegistry::get('Classfee');
                    $oQuery = $peopleTable->query();
                    $romm = sizeof($this->request->data['qu1_fees']);

                    for ($i = 0; $i < $romm; $i++) {

                        $oQuery->insert(['class_id', 'academic_year', 'fee_h_id', 'slab', 'board_id', 'qu1_fees', 'qu2_fees', 'qu3_fees', 'qu4_fees', 'status', 'qu1_date', 'qu2_date', 'qu3_date', 'qu4_date'])
                            ->values([
                                'class_id' => $this->request->data['class_id'][$si], 'academic_year' => $this->request->data['academic_year'], 'fee_h_id' => $this->request->data['fee_h_id'][$i], 'slab' => $slab, 'board_id' => $this->request->data['board_id'], 'qu1_fees' => $this->request->data['qu1_fees'][$i], 'qu2_fees' => $this->request->data['qu2_fees'][$i], 'qu3_fees' => $this->request->data['qu3_fees'][$i], 'qu4_fees' => $this->request->data['qu4_fees'][$i], 'status' => 'Y', 'qu1_date' => $this->request->data['qu1_date'], 'qu2_date' => $this->request->data['qu2_date'], 'qu3_date' => $this->request->data['qu3_date'], 'qu4_date' => $this->request->data['qu4_date']
                            ]);
                    }

                    $d = $oQuery->execute();
                }
            } else if ($this->request->data['submit'] = "Clone " . $acedmicyear) {

                $this->request->data['academic_year'] = $acedmicyear;

                $slab = $this->request->data['slab'];
                $academic_year = $this->request->data['academic_year'];
                $romms = sizeof($this->request->data['class_id']);

                for ($si = 0; $si < $romms; $si++) {

                    $peopleTable = TableRegistry::get('Classfee');
                    $oQuery = $peopleTable->query();
                    $romm = sizeof($this->request->data['qu1_fees']);

                    for ($i = 0; $i < $romm; $i++) {

                        $oQuery->insert(['class_id', 'academic_year', 'fee_h_id', 'slab', 'board_id', 'qu1_fees', 'qu2_fees', 'qu3_fees', 'qu4_fees', 'status', 'qu1_date', 'qu2_date', 'qu3_date', 'qu4_date'])
                            ->values([
                                'class_id' => $this->request->data['class_id'][$si], 'academic_year' => $this->request->data['academic_year'], 'fee_h_id' => $this->request->data['fee_h_id'][$i], 'slab' => $slab, 'board_id' => $this->request->data['board_id'], 'qu1_fees' => $this->request->data['qu1_fees'][$i], 'qu2_fees' => $this->request->data['qu2_fees'][$i], 'qu3_fees' => $this->request->data['qu3_fees'][$i], 'qu4_fees' => $this->request->data['qu4_fees'][$i], 'status' => 'Y', 'qu1_date' => $this->request->data['qu1_date'], 'qu2_date' => $this->request->data['qu2_date'], 'qu3_date' => $this->request->data['qu3_date'], 'qu4_date' => $this->request->data['qu4_date']
                            ]);
                    }
                    $d = $oQuery->execute();
                }
            }
            if ($d) {
                $this->Flash->success(__('Class Fee  has been updated Sucessfully.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->success(__('Class Fee  not updated.'));
                return $this->redirect(['action' => 'index']);
            }
        }
    }

    // this is use to add class fees structure
    public function add($id = null)
    {

        $this->viewBuilder()->layout('admin');
        $this->loadModel('Classes');
        $subjectclasses_data = $this->Classes->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toarray();
        //$this->paginate($service_data);
        $this->set('classlist', $subjectclasses_data);

        $boarddata = $this->Boards->find('all', [
            'keyField' => 'Boards.id',
            'valueField' => 'Boards.name',
        ])->toarray();

        $this->set('boarddata', $boarddata);

        $arrayOfIds = ['1', '2', '3'];
        $feesheads = $this->Feesheads->find('all')->where(['type IN' => $arrayOfIds])->order(['id' => 'ASC'])->toarray();
        $this->set('feesheads', $feesheads);
        if (isset($id) && !empty($id)) {
            //using for edit
            $classes = $this->Classfee->get($id);
        } else {
            //using for new entry
            $classes = $this->Classfee->newEntity();
            $this->request->data['status'] = '1';
        }
        if ($this->request->is(['post', 'put'])) {
            //  pr($this->request->data); die;
            $user = $this->Users->find('all')->where(['Users.role_id' => '1'])->first();
            $acedmicyear = $user['academic_year'];
            // $this->request->data['academic_year'] = $acedmicyear;
            $this->request->data['academic_year'] = "2023-24";

            $classfeeexits = $this->Classfee->find('all')->order(['id' => 'ASC'])->where(['Classfee.class_id' => $this->request->data['class_id'], 'Classfee.academic_year' => $this->request->data['academic_year']])->first();
            if ($classfeeexits['id']) {
                $this->Flash->error(__('Class Fee already exits with selected acedmic year.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $peopleTable = TableRegistry::get('Classfee');
                $oQuery = $peopleTable->query();
                $romm = sizeof($this->request->data['qu1_fees']);
                for ($i = 0; $i < $romm; $i++) {
                    $oQuery->insert(['class_id', 'academic_year', 'fee_h_id', 'board_id', 'qu1_fees', 'qu2_fees', 'qu3_fees', 'qu4_fees', 'status', 'qu1_date', 'qu2_date', 'qu3_date', 'qu4_date'])
                        ->values([
                            'class_id' => $this->request->data['class_id'], 'academic_year' => $this->request->data['academic_year'], 'fee_h_id' => $this->request->data['fee_h_id'][$i], 'board_id' => $this->request->data['board_id'], 'qu1_fees' => $this->request->data['qu1_fees'][$i], 'qu2_fees' => $this->request->data['qu2_fees'][$i], 'qu3_fees' => $this->request->data['qu3_fees'][$i], 'qu4_fees' => $this->request->data['qu4_fees'][$i], 'status' => 'Y', 'qu1_date' => $this->request->data['qu1_date'], 'qu2_date' => $this->request->data['qu2_date'], 'qu3_date' => $this->request->data['qu3_date'], 'qu4_date' => $this->request->data['qu4_date']
                        ]);
                }
                $d = $oQuery->execute();
                // save all data in database
                if ($d) {
                    $this->Flash->success(__('Class Fee  has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('Class Fee  not saved.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
        $this->set('classes', $classes);
    }


    public function sort()
    {
        $this->viewBuilder()->layout('admin');
        $id = $this->request->data[id];
        if (isset($id) && !empty($id)) {
            //using for edit
            $classes = $this->Locations->get($id);
        } else {
            //using for new entry
            $classes = $this->Locations->newEntity();
        }
        if ($this->request->is(['post', 'put'])) {
            //$this->request->data = $this->request->data['sort'];
            $classes->sort = $this->request->data['sort'];
            if ($this->Locations->save($classes)) {
                echo $classes['sort'];
            } else {
                echo 'wrong';
            }
        }
        die;
    }

    //view functionality
    public function view($id = null)
    {
        $this->viewBuilder()->layout('admin');
        $subjectclasses_data = $this->Subjectclass->find('list', [
            'keyField' => 'Classes.id',
            'valueField' => 'Classes.title',
        ])->contain(['Classes'])->order(['Classes.id' => 'ASC'])->toarray();
        $this->set('classes', $subjectclasses_data);
    }

    //delete functionality
    public function delete($id, $academic_year)
    {
        $conn = ConnectionManager::get('default');
        $conn->execute("DELETE FROM class_fee_allocations WHERE academic_year='" . $academic_year . "' AND class_id='" . $id . "'");
        $this->Flash->success(__('Class Fee with id: {0} has been deleted.', h($id)));
        return $this->redirect(['action' => 'index']);
    }

    //status update functionality
    public function status($id, $status, $academic_year)
    {
        if (isset($id) && !empty($id)) {
            if ($status == 'Y') {
                $status = 'N';
                //status update
                $conn = ConnectionManager::get('default');
                $conn->execute("UPDATE `class_fee_allocations` SET `status` = 'N' WHERE `academic_year`='" . $academic_year . "' AND `class_fee_allocations`.`class_id` = " . $id);
                $this->Flash->success(__('Class Fee status has been updated.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $conn = ConnectionManager::get('default');
                $conn->execute("UPDATE `class_fee_allocations` SET `status` = 'Y' WHERE `academic_year`='" . $academic_year . "' AND `class_fee_allocations`.`class_id` = " . $id);
                $this->Flash->success(__('Class Fee status has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
        }
    }


    public function exportdata()
    {
        $this->loadModel('Classes');
        $this->loadModel('Classfee');

        $rolepresent = $this->request->session()->read('Auth.User.role_id');

        // if ($rolepresent == '1' || $rolepresent == '6') {
        $classfee = $this->Classfee->find('all')->contain(['Classes'])->group('Classfee.academic_year')->group('Classfee.slab')->order(['Classes.sort' => 'ASC', 'Classfee.slab' => 'ASC'])->select(['qu1_fees' => 'Classfee.qu1_fees', 'qu2_fees' => 'Classfee.qu2_fees', 'qu3_fees' => 'Classfee.qu3_fees', 'qu4_fees' => 'Classfee.qu4_fees', 'Classes.title', 'Classfee.academic_year', 'Classfee.id', 'Classfee.qu1_date', 'Classfee.qu2_date', 'Classfee.qu3_date', 'Classfee.qu4_date', 'Classfee.status', 'Classfee.class_id', 'Classfee.slab'])->toarray();
        // pr($classfee);exit;
        $this->set('classfee', $classfee);
    }
}
