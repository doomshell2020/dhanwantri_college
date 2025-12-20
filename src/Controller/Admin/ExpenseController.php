<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\View\Helper\CommanHelper;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;

include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';

class ExpenseController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Subjectclass');
        $this->loadModel('Classes');
        $this->loadModel('Subjects');
        $this->loadModel('Classections');
        $this->loadModel('Users');
        $this->loadModel('Sections');
        $this->loadModel('Employees');
        $this->loadModel('Students');
        $this->loadModel('Classteachers');
        $this->loadModel('CourseTracker');
    }

    public function index()
    {
        $this->loadModel('Expense');
        $this->loadModel('ExpenseCategory');
        $this->viewBuilder()->layout('admin');
        //  echo "test"; die;
        $rec = $this->Expense->find('all')->order(['id' => 'desc'])->toArray();
        $this->set(compact('rec', 'exp'));

    }

    public function add()
    {
        $this->loadModel('Expense');
        $this->loadModel('ExpenseCategory');

        $catgory = $this->ExpenseCategory->find()->select(['id', 'category_name'])->order(['ExpenseCategory.category_name' => 'ASC'])->all()->combine('id', function ($catgory) {
            return $catgory->category_name;
        })->toArray();

        $this->set(compact('catgory'));

        if (!empty($this->request->is(['post'], ['put']))) {
            $expense = $this->Expense->newEntity();
            $data['exp_category'] = $this->request->data['Head'];
            $data['title'] = $this->request->data['Title'];
            $userdetail = $this->Expense->patchEntity($expense, $data);
            $result1 = $this->Expense->save($userdetail);
            $this->Flash->success(__('Expense has been saved.'));
            return $this->redirect(['action' => 'index']);
        }

    }
    public function status($id, $status)
    {
        $this->loadModel('Expense');
        if (isset($id) && !empty($id)) {
            $expense = $this->Expense->get($id);
            $expense->status = $status;
            if ($this->Expense->save($expense)) {
                if ($status == 'Y') {
                    $this->Flash->success(__('Expense Head Has been Activated'));
                } else {
                    $this->Flash->success(__('Expense Head Has been Deactivated.'));
                }
                return $this->redirect(['action' => 'index']);
            }
        }
    }


    public function edit($id = null)
    {
        $this->loadModel('Expense');
        $this->loadModel('ExpenseCategory');
        $this->viewBuilder()->Layout('admin');
        $expense = $this->Expense->get($id);
        $assign_details = $this->Expense->find()->where(['Expense.id' => $id])->firstOrFail();
        $expenseCategories = $this->ExpenseCategory->find('all')->toArray();
        $expenseCat = $this->ExpenseCategory->find('all')->where(['ExpenseCategory.id' => $assign_details->exp_category])->first();
        $this->set(compact('assign_details', 'expenseCategories', 'expenseCat'));
        if (isset($id) && !empty($id)) {
            $contr = $this->Expense->get($id);
        } else {
            $contr = $this->Expense->newEntity();
        }
        if ($this->request->is(['post', 'put'])) {
            $data1['exp_category'] = $this->request->data['Head'];
            $data1['title'] = $this->request->data['title'];
            $user = $this->Expense->patchEntity($contr, $data1);
            $purchasess = $this->Expense->save($user);
            $this->Flash->success(__('Expense has been Updated.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function actualexpense($bid = null, $yea = null)
    {
        $this->loadModel('ExpenseDetail');
        $this->loadModel('Expense');
        $this->loadModel('ExpenseCategory');
        $this->viewBuilder()->Layout('admin');

        $catgory = $this->ExpenseCategory->find()->select(['id', 'category_name'])->order(['ExpenseCategory.category_name' => 'ASC'])->all()->combine('id', function ($catgory) {
            return $catgory->category_name;
        })->toArray();
        $this->set(compact('catgory'));

        $yea = date('Y');
        $ex_cat = $this->ExpenseCategory->find()->order(['ExpenseCategory.category_name asc'])->toarray();
        $this->set(compact('ex_cat', 'yea', 'query'));

    }

    public function addexpense($ex_id)
    {
        $this->loadModel('Expense');
        $this->loadModel('ExpenseCategory');
        $this->loadModel('ExpenseDetail');
        $session = $this->request->session();
        $session->delete('cond');
        $catgory = $this->Expense->find('all')->where(['Expense.exp_category' => $ex_id,'Expense.status' => 'Y'])->toArray();
        $this->set(compact('catgory','ex_id'));

        if (!empty($this->request->is(['post'], ['put']))) {
            $expense = $this->ExpenseDetail->newEntity();
            $data['exp_cat_id'] = $this->request->data['Head'];
            $data['description'] = $this->request->data['Description'];
            $data['amount'] = $this->request->data['Amount'];
            $data['notes'] = $this->request->data['Notes'];
            $data['mode'] = $this->request->data['Mode'];
            $data['add_date'] = $this->request->data['datefrom'];

            $userdetail = $this->ExpenseDetail->patchEntity($expense, $data);
            $result1 = $this->ExpenseDetail->save($userdetail);
            $mounthamount = $result1->amount;
            $this->Flash->success(__('Expense has been saved.'));
            return $this->redirect(['action' => 'actualexpense']);
        }

    }

    


    public function checkHead()
    {
        $this->autoRender = false;
        $Head = $this->request->data['Head'];
        $this->loadModel('Expense');
        $checkuser = $this->Expense->find('all')->where(['Expense.exp_category' => $Head])->where(['Expense.status' => 'Y'])->toArray();

        $response = [];
        if ($checkuser != '' && !empty($checkuser)) {
            foreach ($checkuser as $value) {
                $output = [];
                $output['id'] = $value['id'];
                $output['title'] = $value['title'];
                array_push($response, $output);
            }
        }
        echo json_encode($response);
        return;
    }


    public function viewexpense($ec_id, $month, $year)
    {

        $this->loadModel('Expense');
        $this->loadModel('ExpenseDetail');
        $this->loadModel('ExpenseCategory');
        if (date('m') > 3) {
            $cond['Date(ExpenseDetail.add_date) >='] = date($year . '-04-01');
            $cond['Date(ExpenseDetail.add_date) <='] = date(($year + 1) . '-03-31');
        } else {
            $cond['Date(ExpenseDetail.add_date) >='] = date(($year - 1) . '-04-01');
            $cond['Date(ExpenseDetail.add_date) <='] = date($year . '-03-31');
        }
        $ex_cat = $this->ExpenseCategory->find()->where(['id' => $ec_id])->first();
        $ExpenseDetail = $this->ExpenseDetail->find()->where(['MONTH(add_date)' => $month, $cond, 'exp_cat_id' => $ec_id])->toarray();
        $this->set(compact('ExpenseDetail'));
    }

    public function expensedelete($id)
    {
        $this->loadModel('ExpenseDetail');
        $expense_detail_delete = $this->ExpenseDetail->get($id);
        if ($expense_detail_delete) {
            $this->ExpenseDetail->deleteAll(['ExpenseDetail.id' => $id]);
            $this->Flash->success(__('ExpenseDetail has been deleted Successfully'));
            return $this->redirect(['action' => 'actualexpense']);
        }
    }



    public function searchexpense()
    {
        $this->loadModel('ExpenseCategory');
        $this->loadModel('Expense');
        $this->loadModel('ExpenseDetail');

        $yea = $this->request->data['prev_year'];
        $Head = $this->request->data['Head'];
        $datefrom = $this->request->data['datefrom'];
        $dateto = $this->request->data['dateto'];

        $conditions = [];

        if ($Head == 'dateSum') {
            if (!empty($datefrom) && !empty($dateto)) {
                $conditions['ExpenseDetail.add_date >='] = date('Y-m-d', strtotime($datefrom));
                $conditions['ExpenseDetail.add_date <='] = date('Y-m-d', strtotime($dateto));
            }
            $query = $this->ExpenseDetail->find('all')->where($conditions)->order(['add_date' => 'DESC'])->toArray();
            $this->set(compact('query', 'Head'));
        } else {
            $conditions['year'] = $yea;
            $ex_cat = $this->ExpenseCategory->find()->order(['ExpenseCategory.category_name' => 'ASC'])->toArray();
            $this->set(compact('ex_cat', 'yea'));
        }
        $this->request->session()->write('cond', $conditions);
        $this->request->session()->write('Head', $Head);

    }


    public function actualexpensepdf()
    {
        $this->response->type('pdf');
        $this->loadModel('ExpenseDetail');
        $this->loadModel('Expense');
        $this->loadModel('ExpenseCategory');
        $this->viewBuilder()->Layout('admin');

        $where = $this->request->session()->read('cond');
        $Head = $this->request->session()->read('Head');
        if (($Head == 'dateSum')) {
            $expensedet = $this->ExpenseDetail->find('all')->where([$where])->order(['ExpenseDetail.add_date' => 'ASC'])->toarray();
        } else {
            $expensedet = $this->ExpenseCategory->find('all')->order(['ExpenseCategory.category_name' => 'ASC'])->toarray();
        }
        $this->set(compact('expensedet', 'where', 'Head'));
        $this->request->session()->delete('cond');
        $this->request->session()->delete('Head');
    }

}

