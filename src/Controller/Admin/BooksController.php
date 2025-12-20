<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

/**
 *Creating Cup Boards for Library Management System
 */
class BooksController extends AppController
{
    //----------------------------------------
    public $helpers = ['CakeJs.Js'];

    //----------------------------------------
    public function initialize()
    {
        parent::initialize();
        //$this->Auth->allow(['updatesql']);
        //Loading Models
        $this->loadModel('BookCategory');
        $this->loadModel('CupBoard');
        $this->loadModel('CupBoardShelf');
        $this->loadModel('BookVendor');
        $this->loadModel('Book');
        $this->loadModel('BookCopyDetail');
        $this->loadModel('Language');
        $this->loadModel('BookRequest');
        $this->loadModel('Classes');
        $this->loadModel('Sections');
        $this->loadModel('Employeesalary');
        $this->loadModel('Employees');
        $this->loadModel('Language');
        $this->loadModel('Periodicity');
        $this->loadModel('PeriodicalMaster');
        $this->loadModel('BookVendor');
        $this->loadModel('Periodicity');
        $this->loadModel('Language');
        $this->loadModel('PeriodicalMasterDetails');

    }

    //----------------------------------------
    public function updatesql()
    {
        $this->viewBuilder()->layout('admin');
        $bookscategory = $this->BookCategory->find('all')->toArray();
        foreach ($bookscategory as $value) {
            $conn = ConnectionManager::get('default');
            $cat = $value['id'];
            $b_id = trim($value['name']);
            $conn->execute("UPDATE `another_books` SET `book_category_id` = '$cat' WHERE `sbj` LIKE '%" . $b_id . "%' AND `book_category_id`=0");
        }
        echo "completed";die;
    }

    public function cupboardupdatesql()
    {
        $this->viewBuilder()->layout('admin');
        $CupBoardShelf = $this->CupBoardShelf->find('all')->toArray();
        foreach ($CupBoardShelf as $value) {
            $conn = ConnectionManager::get('default');
            $sid = $value['id'];
            $cup_id = $value['cup_board_id'];
            $conn->execute("UPDATE `another_books` SET `cup_board_id` = '$cup_id' WHERE `cup_board_shelf_id`=" . $sid);
        }
        echo "completed";die;
    }

    public function index()
    {
        $this->viewBuilder()->layout('admin');
        $books = $this->Book->find('all')->contain(['BookCategory', 'CupBoard', 'CupBoardShelf'])->order(['Book.id' => 'desc'])->toArray();
        $this->set('books', $books);
    }

    //---------------------------------------------------------
    public function periodicSearch()
    {
        $id = $this->request->data('idf');
        $pdetails = $this->PeriodicalMasterDetails->find('all')->contain(['PeriodicalMaster'])->where(['PeriodicalMasterDetails.periodic_id' => $id])->order(['PeriodicalMasterDetails.id' => 'desc'])->first();
        $locationid = $this->Book->find('all')->where(['Book.periodic_category_id' => $pdetails['periodic_id']])->order(['Book.id' => 'DESC'])->first();
        $locat = $this->CupBoardShelf->find('all')->contain(['CupBoard'])->where(['CupBoardShelf.id' => $locationid['cup_board_shelf_id']])->first();
        $this->set('pdetails', $pdetails);
        $this->set('locat', $locat);

    }

    public function periodicVolume($id = null)
    {
        $this->viewBuilder()->layout('admin');
        $pdetails = $this->Book->find('all')->where(['Book.periodic_category_id' => $id])->order(['Book.id' => 'desc'])->toarray();
        $pname = $this->PeriodicalMaster->find('all')->select(['name'])->where(['PeriodicalMaster.id' => $id])->first();
        $pcount = $this->Book->find('all')->where(['Book.periodic_category_id' => $id])->count();
        $this->set('pdetails', $pdetails);
        $this->set('pname', $pname);
        $this->set('pcount', $pcount);
    }

    public function findperiodicasscno()
    {
        $id = $this->request->data('pid');
        $pdetails = $this->Book->find('all')->where(['Book.periodic_category_id' => $id])->order(['Book.id' => 'desc'])->first();
        $acn = $pdetails['accsnno'];
        echo $acn;die;
    }

    public function periodicData()
    {

        $id = $this->request->data('idf');
        $wer = $this->PeriodicalMasterDetails->find('all')->contain(['PeriodicalMaster'])->where(['PeriodicalMasterDetails.periodic_id' => $id])->order(['PeriodicalMasterDetails.id' => 'desc'])->first();
        echo $wer['periodical_master']['subtitle'] . '#' . $wer['periodical_master']['vendor'] . '#' . $wer['periodical_master']['lang'] . '#' . $wer['periodical_master']['publisher'] . '#' . $wer['periodical_master']['ISBN_NO'] . '#' . $wer['bill_no'] . '#' . date('d-m-Y', strtotime($wer['bill_date'])) . '#' . $wer['bill_amount'] . '#' . date('d-m-Y', strtotime($wer['bill_pay_date'])) . '#' . $wer['subs_no'] . '#' . $wer['subs_amount'] . '#' . $wer['per_volume_cost'] . '#' . date('d-m-Y', strtotime($wer['subs_start_date'])) . '#' . date('d-m-Y', strtotime($wer['subs_end_date'])) . '#' . $wer['per_annum_volume'];die;

    }

    public function periodicExcel()
    {
        $this->autoRender = false;
        $this->viewBuilder()->layout('admin');
        $connssss = ConnectionManager::get('default');

        $resultsucessssss = $connssss->execute("SELECT * FROM `library_periodical_details` WHERE subs_end_date IN( SELECT MAX(subs_end_date) FROM `library_periodical_details` GROUP BY `periodic_id`  ) AND id IN(SELECT MAX(id)FROM `library_periodical_details` GROUP BY `periodic_id`) ");
        $ghj = $resultsucessssss->fetchAll('assoc');
        ini_set('max_execution_time', 1600);
        $headerRow = array("SNo", "Periodical Name", "Periodicity", "Language", "Subscription Start", "Subscription End", "Price", "Author", "Volume");
        $output = implode("\t", $headerRow) . "\n";
        $counter = '1';
        foreach ($ghj as $service) {
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
        echo $output;die;

    }

    public function periodicRenew($id = null, $pid = null)
    {
        $this->viewBuilder()->layout('admin');
        $pwer = $this->PeriodicalMasterDetails->find('all')->contain(['PeriodicalMaster'])->where(['PeriodicalMasterDetails.periodic_id' => $pid])->order(['PeriodicalMasterDetails.id' => 'desc'])->toArray();
        $this->set('pwer', $pwer);
        $this->set('id', $id);

        if ($this->request->is(['post', 'put'])) {
            $pmasterdetail = $this->PeriodicalMasterDetails->newEntity();
            $bildate = date('Y-m-d', strtotime($this->request->data['bill_date']));
            $bill_pay_date = date('Y-m-d', strtotime($this->request->data['bill_pay_date']));
            $subsdate = date('Y-m-d', strtotime($this->request->data['subs_start_date']));
            $subedate = date('Y-m-d', strtotime($this->request->data['subs_end_date']));
            $tn['subs_start_date'] = $subsdate;
            $tn['subs_end_date'] = $subedate;
            $tn['bill_date'] = $bildate;
            $tn['bill_pay_date'] = $bill_pay_date;
            $tn['periodic_id'] = $pid;
            $tn['bill_no'] = $this->request->data['bill_no'];
            $tn['bill_amount'] = $this->request->data['bill_amount'];
            $tn['subs_no'] = $this->request->data['subs_no'];
            $tn['subs_amount'] = $this->request->data['subs_amount'];
            $tn['per_volume_cost'] = $this->request->data['per_volume_cost'];
            $pmasterdetail = $this->PeriodicalMasterDetails->patchEntity($pmasterdetail, $tn);
            $resultss = $this->PeriodicalMasterDetails->save($pmasterdetail);

            $this->Flash->success(__('Your Subscription Successfully added.'));
            return $this->redirect(['controller' => 'books', 'action' => 'periodicView']);

        }

    }

    public function periodicView()
    { 
        $this->viewBuilder()->layout('admin');
        $connssss = ConnectionManager::get('default');
        $perio = $this->PeriodicalMasterDetails->find('all')->contain(['PeriodicalMaster'])->where(['PeriodicalMasterDetails.subs_end_date IN(SELECT MAX(subs_end_date) FROM `library_periodical_details` GROUP BY `periodic_id`)', 'PeriodicalMasterDetails.id IN(SELECT MAX(id) FROM `library_periodical_details` GROUP BY `periodic_id` )'])->order(['PeriodicalMaster.name' => 'Asc'])->toarray();
        $value = $this->request->data['value'];

        $this->set('perio', $perio);
        $bookvendors = $this->BookVendor->find('list')->where(['BookVendor.status' => 'Y'])->order(['BookVendor.name' => 'Asc'])->toarray();
        $this->set('bookvendors', $bookvendors);
        $peropt1 = $this->PeriodicalMaster->find('list')->select(['id', 'name'])->order(['PeriodicalMaster.name' => 'ASC'])->toarray();
        $this->set('peropt1', $peropt1);

    }

    public function periodic()
    {
        $this->viewBuilder()->layout('admin');
        $lahu = $this->Language->find('list', [
            'keyField' => 'id',
            'valueField' => 'language',
        ])->order(['Language.id' => 'asc'])->toArray();
        $this->set('lahu', $lahu);
        $pere = $this->Periodicity->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])->order(['Periodicity.id' => 'asc'])->toArray();
        $this->set('pere', $pere);

        $bookvendors = $this->BookVendor->find('list')->where(['BookVendor.status' => 'Y'])->order(['BookVendor.name' => 'Asc'])->toarray();
        $this->set('bookvendors', $bookvendors);

        if ($this->request->is(['post', 'put'])) {
            $permaster = $this->PeriodicalMaster->newEntity();
            $fn['name'] = ucwords($this->request->data['name']);
            $fn['ISBN_NO'] = $this->request->data['ISBN_NO'];
            $fn['subtitle'] = $this->request->data['subtitle'];
            $fn['vendor'] = $this->request->data['vendor'];
            $fn['publisher'] = $this->request->data['publisher'];
            $fn['lang'] = $this->request->data['lang'];
            $fn['author'] = $this->request->data['author'];
            $fn['periodicity'] = $this->request->data['periodicity'];
            $permaster = $this->PeriodicalMaster->patchEntity($permaster, $fn);
            $result = $this->PeriodicalMaster->save($permaster);
            $id = $result->id;

            if ($id) {
                $pmasterdetail = $this->PeriodicalMasterDetails->newEntity();
                $bildate = date('Y-m-d', strtotime($this->request->data['bill_date']));
                $bill_pay_date = date('Y-m-d', strtotime($this->request->data['bill_pay_date']));
                $subsdate = date('Y-m-d', strtotime($this->request->data['subs_start_date']));
                $subedate = date('Y-m-d', strtotime($this->request->data['subs_end_date']));
                $tn['subs_start_date'] = $subsdate;
                $tn['subs_end_date'] = $subedate;
                $tn['bill_date'] = $bildate;
                $tn['bill_pay_date'] = $bill_pay_date;
                $tn['periodic_id'] = $id;
                $tn['bill_no'] = $this->request->data['bill_no'];
                $tn['bill_amount'] = $this->request->data['bill_amount'];
                $tn['subs_no'] = $this->request->data['subs_no'];
                $tn['subs_amount'] = $this->request->data['subs_amount'];
                $tn['per_volume_cost'] = $this->request->data['per_volume_cost'];
                $pmasterdetail = $this->PeriodicalMasterDetails->patchEntity($pmasterdetail, $tn);
                $resultss = $this->PeriodicalMasterDetails->save($pmasterdetail);

            }
            $this->Flash->success(__('Your Periodical details has been saved.'));
            return $this->redirect(['controller' => 'books', 'action' => 'periodicView']);
        }
    }

    public function periodicEdit($id, $pid)
    {
        $this->viewBuilder()->layout('admin');
        $lahu = $this->Language->find('list', [
            'keyField' => 'id',
            'valueField' => 'language',
        ])->order(['Language.id' => 'asc'])->toArray();
        $this->set('lahu', $lahu);
        $pere = $this->Periodicity->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])->order(['Periodicity.id' => 'asc'])->toArray();
        $this->set('pere', $pere);

        $bookvendors = $this->BookVendor->find('list')->where(['BookVendor.status' => 'Y'])->order(['BookVendor.name' => 'Asc'])->toarray();
        $this->set('bookvendors', $bookvendors);
        $prty = $this->PeriodicalMaster->get($pid);
        $this->set('prty', $prty);
        $pdty = $this->PeriodicalMasterDetails->get($id);
        $this->set('pdty', $pdty);

        if ($this->request->is(['post', 'put'])) {
            $fn['name'] = ucwords($this->request->data['name']);
            $fn['ISBN_NO'] = $this->request->data['ISBN_NO'];
            $fn['subtitle'] = $this->request->data['subtitle'];
            $fn['vendor'] = $this->request->data['vendor'];
            $fn['publisher'] = $this->request->data['publisher'];
            $fn['lang'] = $this->request->data['lang'];
            $fn['author'] = $this->request->data['author'];
            $fn['periodicity'] = $this->request->data['periodicity'];

            $prty = $this->PeriodicalMaster->patchEntity($prty, $fn);
            $result = $this->PeriodicalMaster->save($prty);

            if ($id) {

                $bildate = date('Y-m-d', strtotime($this->request->data['bill_date']));
                $bill_pay_date = date('Y-m-d', strtotime($this->request->data['bill_pay_date']));
                $subsdate = date('Y-m-d', strtotime($this->request->data['subs_start_date']));
                $subedate = date('Y-m-d', strtotime($this->request->data['subs_end_date']));
                $tn['subs_start_date'] = $subsdate;
                $tn['subs_end_date'] = $subedate;
                $tn['bill_date'] = $bildate;
                $tn['bill_pay_date'] = $bill_pay_date;
                $tn['periodic_id'] = $pid;
                $tn['bill_no'] = $this->request->data['bill_no'];
                $tn['bill_amount'] = $this->request->data['bill_amount'];
                $tn['subs_no'] = $this->request->data['subs_no'];
                $tn['subs_amount'] = $this->request->data['subs_amount'];
                $tn['per_volume_cost'] = $this->request->data['per_volume_cost'];
                $pdty = $this->PeriodicalMasterDetails->patchEntity($pdty, $tn);
                $resultss = $this->PeriodicalMasterDetails->save($pdty);

            }
            $this->Flash->success(__('Your Periodical details has been updated.'));
            return $this->redirect(['controller' => 'books', 'action' => 'periodicView']);
        }
    }

    public function create($id = null)
    {
        $this->viewBuilder()->layout('admin');
        $lahu = $this->Language->find('list', [
            'keyField' => 'id',
            'valueField' => 'language',
        ])->order(['Language.id' => 'asc'])->toArray();
        $this->set('lahu', $lahu);

        $peri = $this->PeriodicalMaster->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])->order(['PeriodicalMaster.name' => 'asc'])->toArray();
        $this->set('peri', $peri);

        $exissts = $this->Book->find('all')->where(['Book.accsnno NOT LIKE' => '%-%'])->order(['Book.id' => 'DESC'])->first();
        $exissts['accsnno'] = $exissts['accsnno'] + 1;

        $this->set('accssnno', $exissts['accsnno']);
        $bookcategories = $this->BookCategory->find('list')->where(['BookCategory.status' => 'Y'])->order(['BookCategory.name' => 'Asc'])->toarray();
        $this->set('bookcategories', $bookcategories);

        $cupboards = $this->CupBoard->find('list')->where(['CupBoard.status' => 'Y'])->order(['CupBoard.name' => 'Asc'])->toarray();
        $this->set('cupboards', $cupboards);

        $bookvendors = $this->BookVendor->find('list')->where(['BookVendor.status' => 'Y'])->order(['BookVendor.name' => 'Asc'])->toarray();
        $this->set('bookvendors', $bookvendors);

        if (isset($id) && !empty($id)) {
            $book = $this->Book->get($id);
            $shelf_list = $this->CupBoardShelf->find('list')->where(['CupBoardShelf.cup_board_id' => $book['cup_board_id'], 'CupBoardShelf.status' => 'Y'])->toArray();
            $this->set('shelves', $shelf_list);
        } else {
            $book = $this->Book->newEntity();
        }

        $this->set('book', $book);
        if ($this->request->is(['post', 'put'])) {
            // save all data in database
            $req_data = $this->request->data;
            if ($req_data['typ'] == '0') {
                if (!isset($id)) {
                    $asn = trim($req_data['accsnno']);
                    $userTable = TableRegistry::get('Book');
                    $exists = $userTable->exists(['TRIM(accsnno)' => $asn]);
                    if ($exists) {
                        $this->Flash->error(__('Book With same Asn no. is already exist.'));
                        return $this->redirect(['controller' => 'books', 'action' => 'create']);
                    }

                }
                $this->request->data['bildt'] = $this->request->data['bildt']['year'] . "-" . $this->request->data['bildt']['month'] . "-" . $this->request->data['bildt']['day'];

                $book = $this->Book->patchEntity($book, $req_data);
                if ($this->Book->save($book)) {
                    if (isset($req_data['button']) && !empty($req_data['button'])) {
                        $this->Flash->success(__('Your Book details has been updated.'));
                    } else {
                        $this->addCopy((int) $req_data['copy']);
                        $this->Flash->success(__('Your Book has been added.'));
                    }
                    if (isset($id)) {
                        return $this->redirect(['controller' => 'books', 'action' => 'view/' . $id . '/' . $req_data['typ']]);

                    } else {
                        $books = $this->Book->find('all')->select('id')->order(['Book.id' => 'desc'])->first();
                        return $this->redirect(['controller' => 'books', 'action' => 'view/' . $books['id'] . '/' . $req_data['typ']]);
                    }
                } else {
                    //check validation error
                    if ($book->errors()) {
                        $error_msg = [];

                        foreach ($book->errors() as $errors) {
                            if (is_array($errors)) {
                                foreach ($errors as $error) {
                                    $error_msg[] = $error;
                                }
                            } else {
                                $error_msg[] = $errors;
                            }
                        }

                        if (!empty($error_msg)) {
                            $this->Flash->error(__("Please fix the following error(s): " . implode("\n \r", $error_msg)));
                        }
                    }
                }

            } else {
                if (!isset($id)) {
                    $asn = trim($req_data['accsnno']);
                    $userTable = TableRegistry::get('Book');
                    $exists = $userTable->exists(['TRIM(accsnno)' => $asn]);
                    if ($exists) {
                        $this->Flash->error(__('Book With same Asn no. is already exist.'));
                        return $this->redirect(['controller' => 'books', 'action' => 'create']);
                    }

                }
                $prid = $req_data['periodic_category_id'];
                $wer = $this->PeriodicalMasterDetails->find('all')->contain(['PeriodicalMaster'])->where(['PeriodicalMasterDetails.periodic_id' => $prid])->order(['PeriodicalMasterDetails.id' => 'desc'])->first();
                $req_data['book_category_id'] = '0';
                $req_data['book_vendor_id'] = $wer['periodical_master']['vendor'];
                $req_data['ISBN_NO'] = $wer['periodical_master']['ISBN_NO'];
                $req_data['sub_title'] = $wer['periodical_master']['subtitle'];
                $req_data['publisher'] = $wer['periodical_master']['publisher'];
                $req_data['lang'] = $wer['periodical_master']['lang'];
                $req_data['book_cost'] = $wer['per_volume_cost'];
                $req_data['name'] = ucwords($req_data['prt']);
                $req_data['author'] = ucwords($wer['periodical_master']['author']);
                $book = $this->Book->patchEntity($book, $req_data);
                if ($this->Book->save($book)) {
                    if (isset($req_data['button']) && !empty($req_data['button'])) {
                        $this->Flash->success(__('Your Book details has been updated.'));
                    } else {
                        $this->addCopy((int) $req_data['copy']);

                        $this->Flash->success(__('Your Book has been added.'));
                    }
                    if (isset($id)) {
                        return $this->redirect(['controller' => 'books', 'action' => 'view/' . $id . '/' . $req_data['typ']]);

                    } else {
                        $books = $this->Book->find('all')->select('id')->order(['Book.id' => 'desc'])->first();
                        return $this->redirect(['controller' => 'books', 'action' => 'view/' . $books['id'] . '/' . $req_data['typ']]);
                    }
                } else {
                    //check validation error
                    if ($book->errors()) {
                        $error_msg = [];

                        foreach ($book->errors() as $errors) {
                            if (is_array($errors)) {
                                foreach ($errors as $error) {
                                    $error_msg[] = $error;
                                }
                            } else {
                                $error_msg[] = $errors;
                            }
                        }

                        if (!empty($error_msg)) {
                            $this->Flash->error(__("Please fix the following error(s): " . implode("\n \r", $error_msg)));
                        }
                    }
                }

            }
        }
    }

    public function addCopy($no_of_copy)
    {
        //Preparing data
        $b_id = $this->Book->find()->select('id')->order(['Book.id' => 'DESC'])->first()->id;

        $book_copy_data['book_id'] = $b_id;
        $book_copy_data['status'] = 'Available';

        for ($i = 1; $i <= $no_of_copy; $i++) {
            //Creating new entity and patching it
            $book_copy = $this->BookCopyDetail->newEntity();
            $book_copy = $this->BookCopyDetail->patchEntity($book_copy, $book_copy_data);

            //Saving final data object to database.
            $this->BookCopyDetail->save($book_copy);
        }
    }

    //---------------------------------------------------------
    public function status($id, $status)
    {
        if (isset($id) && !empty($id)) {
            if ($status == 'Y') {
                $status = 'N';
                //status update
                $book = $this->Book->get($id);
                $book->status = $status;

                if ($this->Book->save($book)) {
                    $this->Flash->success(__('Your Book status has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            } else {
                $status = 'Y';
                //status update
                $book = $this->Book->get($id);
                $book->status = $status;

                if ($this->Book->save($book)) {
                    $this->Flash->success(__('Your Book status has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
    }

    //---------------------------------------------------------
    public function delete($id)
    {
        $book = $this->Book->get($id);
        if ($this->Book->delete($book)) {
            $this->Flash->success(__('The Book with id: {0} has been deleted.', h($id)));
            return $this->redirect(['controller' => 'issuebooks', 'action' => 'index']);
        }
    }

    //---------------------------------------------------------
    public function view($id, $tid)
    {
        $this->viewBuilder()->layout('admin');
        if ($tid == '0') {
            $book = $this->Book->find('all')->where(['Book.id' => $id])->contain(['BookCategory', 'CupBoard', 'CupBoardShelf'])->first();
        } else {
            $book = $this->Book->find('all')->where(['Book.id' => $id])->contain(['PeriodicalMaster', 'CupBoard', 'CupBoardShelf'])->first();
        }
        $kid = $book['periodical_master']['id'];
        $bnm = $this->PeriodicalMasterDetails->find('all')->where(['PeriodicalMasterDetails.periodic_id' => $kid])->order(['PeriodicalMasterDetails.id' => 'desc'])->first();

        $this->set(compact('book', 'tid', 'bnm'));

        //------------ Copies part --------------
        $copies = $this->BookCopyDetail->find('all')->where(['BookCopyDetail.book_id' => $id])->toArray();
        $this->set(compact('copies'));
    }

    //---------------------------------------------------------
    public function find_shelf()
    {
        $this->viewBuilder()->layout('admin');

        $id = $this->request->data['id'];
        $shelf_list = $this->CupBoardShelf->find('list')->where(['CupBoardShelf.cup_board_id' => $id, 'CupBoardShelf.status' => 'Y'])->toArray();

        echo "<option value=''>Select Cupboard Shelf</option>";
        foreach ($shelf_list as $shelf => $value) {
            echo "<option value=" . $shelf . ">" . $value . "</option>";
        }die;
    }

    //---------------------------------------------------------
    public function addMoreCopy($id = null)
    {
        if ($this->request->is(['post', 'put']) && isset($id) && !empty($id)) {
            $conn = ConnectionManager::get('default');

            //Preparing data
            $book_copy_data['book_id'] = $id;
            $book_copy_data['status'] = 'Available';

            $req_data = $this->request->data;
            $n = $req_data['no_of_copy'];

            for ($i = 1; $i <= $n; $i++) {
                //Creating new entity and patching it
                $book_copy = $this->BookCopyDetail->newEntity();
                $book_copy = $this->BookCopyDetail->patchEntity($book_copy, $book_copy_data);

                //Saving final data object to database.
                $save_success = $this->BookCopyDetail->save($book_copy);
            }

            if ($save_success) {
                $conn->execute("UPDATE `library_books` SET `copy` = `copy`+" . $n . " WHERE `id`='" . $id . "'");

                $this->Flash->success(__('Copies added successfully.'));
                return $this->redirect(['action' => 'view/' . $id]);
            } else {
                //check validation error
                if ($issuebook->errors()) {
                    $error_msg = [];

                    foreach ($issuebook->errors() as $errors) {
                        if (is_array($errors)) {
                            foreach ($errors as $error) {
                                $error_msg[] = $error;
                            }
                        } else {
                            $error_msg[] = $errors;
                        }
                    }

                    if (!empty($error_msg)) {
                        $this->Flash->error(__("Please fix the following error(s): " . implode("\n \r", $error_msg)));
                    }
                }
            }
        }
    }

    //--------------------------------------------------------------------------------------------
    public function addcsv()
    {
        $this->viewBuilder()->layout('admin');
        if ($this->request->is('post') || $this->request->is('put')) {
            $na = $this->request->data['file']['name'];
            //echo ROOT .DS. "webroot" . DS  . "Classes" . DS . "PHPExcel" . DS . "IOFactory.php"; die;
            require_once ROOT . DS . "vendor" . DS . "PHPExcel" . DS . "excel_reader2.php";
            $data = Spreadsheet_Excel_Reader($na);
            pr($data);die;

            $inputfilename = $_FILES['file']['tmp_name'];
            pr($inputfilename);die;

            try {

                $inputfiletype = PHPExcel_IOFactory::identify($inputfilename);
                echo "hello";die;
                $objReader = PHPExcel_IOFactory::createReader($inputfiletype);

                $objPHPExcel = $objReader->load($inputfilename);

/*\PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
$objPHPExcel = \PHPExcel_IOFactory::load($inputfilename);*/

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
                pr($filesop);die;

                if ($filesop[0][0] != '') {
                    $lang0 = $filesop[0][0];
                    $lang1 = $filesop[0][1];
                    $lang6 = $filesop[0][6];
                    $lang8 = $filesop[0][8];
                    $lang6 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($lang6));
                    $lang8 = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($lang8));
                    $lang2 = $filesop[0][2];
                    $lang3 = $filesop[0][3];
                    $lang4 = $filesop[0][4];
                    $lang5 = $filesop[0][5];
                    $lang7 = $filesop[0][7];
                    $lang9 = $filesop[0][9];
                    $sql = "UPDATE `employees` SET `fname`='$lang1',`middlename`='$lang2',`lname`='$lang3',`username`='$lang4', `dob`='$lang8',`mobile`='$lang5',`joiningdate`='$lang6',`email`='$lang4',`experience`='',`f_h_name`='$lang9' WHERE `id`='$lang0'";
                    mysqli_query("SET NAMES 'utf8'");
                    $result = mysqli_query($db, $sql);
                    $sql2 = mysqli_query($db, "UPDATE `users` SET `email`='$lang4' WHERE `tech_id`='$lang0'");
                    echo $last_id . "<br>";
                    $c++;
                }
            }
        }
    }

    //--------------------------------------------------------------------------------------------

    public function csv($filename)
    {
        $file = SITE_URL . 'excel_file/' . $filename;
        // open the file
        $handle = fopen($file, "r");
        $header = fgetcsv($handle);
        // Remove any invalid or hidden characters
        $field = preg_replace('/[\x00-\x1F\x80-\xFF]/', ',', $header[0]);
        $header = explode(",", $field);
        // create a message container
        $return = array(
            'messages' => array(),
            'errors' => array(),
        );

        // read each data row in the file
        while (($row = fgetcsv($handle)) != false) {
            // Remove any invalid or hidden characters
            $row = preg_replace('/[\x00-\x1F\x80-\xFF]/', ',', $row[0]);
            $row = explode(",", $row);

            $book_category_id = $this->BookCategory->find()->select('id')->where(['BookCategory.name' => $row[1], 'BookCategory.status' => 'Y'])->first()->id;
            $row[1] = $book_category_id;

            $cup_board_id = $this->CupBoard->find()->select('id')->where(['CupBoard.name' => $row[6], 'CupBoard.status' => 'Y'])->first()->id;
            $row[6] = $cup_board_id;

            $cup_board_shelf_id = $this->CupBoardShelf->find()->select('id')->where(['CupBoardShelf.name' => $row[7], 'CupBoardShelf.status' => 'Y'])->first()->id;
            $row[7] = $cup_board_shelf_id;

            $book_vendor_id = $this->BookVendor->find()->select('id')->where(['BookVendor.name' => $row[11], 'BookVendor.status' => 'Y'])->first()->id;
            $row[11] = $book_vendor_id;

            $data = array();

            // for each header field
            foreach ($header as $k => $head) {
                $data[$head] = isset($row[$k]) ? $row[$k] : ',';
            }
            $documents = $this->Book->newEntity();
            $documents = $this->Book->patchEntity($documents, $data);
            $this->Book->save($documents);
            $this->addCopy((int) $row[12]);
        }
        //close the file
        fclose($handle);
        //return the messages
        return $return;
    }



    //--------------------------------------------------------------------------------------------
    public function check_isbn()
    {
        if ($this->request->is(['post', 'put'])) {
            $isbn_no = trim($this->request->data['isbnno']);
            $exists = $this->Book->find('all')->where(['Book.accsnno' => $isbn_no])->count();
            if ($exists >= 1) {
                echo "This Number already exists!";
            } else {
                echo "OK";
            }
        }
        die;
    }

    public function autoaccessionfinder()
    {
        if ($this->request->is(['post', 'put'])) {
            $isbn_no = trim($this->request->data['types']);
            if ($isbn_no == '1') {
                $exists = $this->Book->find('all')->where(['Book.accsnno NOT LIKE' => '%-%'])->order(['Book.id' => 'DESC'])->first();
                $exissts['accsnno'] = $exists['accsnno'] + 1;
                echo $exissts['accsnno'];die;
            } else if ($isbn_no == '0') {
                $exissts = $this->Book->find('all')->where(['Book.accsnno NOT LIKE' => '%-%'])->order(['Book.id' => 'DESC'])->first();
                $exissts['accsnno'] = $exissts['accsnno'] + 1;
                echo $exissts['accsnno'];die;

            }
        }
        die;
    }

    public function searchperiodicals()
    {
        if ($this->request->is(['post', 'put'])) {
            $dt = $this->request->data;
            $permast = $this->request->data['book_vendor_id'];
            $this->set('permast', $permast);
            $con = array();
            if (isset($dt['book_vendor_id']) && !empty($dt['book_vendor_id'])) {
                $con['Book.book_vendor_id'] = $permast;
            }
    
            if (isset($dt['per_search']) && !empty($dt['per_search'])) {
                $con1['Book.periodic_category_id'] = $dt['per_search'];
                $con[] = $con1;
            }

            if (isset($dt['d1']) && !empty($dt['d1'])) {
                $con2['DATE(Book.created) >='] = date('Y-m-d', strtotime($dt['d1']));
                $con[] = $con2;
            }
            if (isset($dt['d2']) && !empty($dt['d2'])) {
                $con3['DATE(Book.created) <='] = date('Y-m-d', strtotime($dt['d2']));
                $con[] = $con3;
            }
            $periodic = $this->Book->find('all')->contain(['PeriodicalMaster'])->where($con)->order(['Book.id' => 'DESC'])->toarray();
            $this->set('periodic', $periodic);

        }

    }
    public function selectopt()
    {
        $this->autoRender = false;
        $value = $this->request->data['value'];
        if ($value == '') {
            $peropt = $this->PeriodicalMaster->find('list')->select(['id', 'name'])->order(['PeriodicalMaster.name' => 'ASC'])->toarray();
            $peropt[0] = "---Select Periodicals---";
            $this->set('peropt', $peropt);
            header('Content-Type: application/json');
            echo json_encode($peropt);
            die;
        } else if (isset($value) && !empty($value)) {
            $peropt = $this->PeriodicalMaster->find('list')->select(['id', 'name'])->where(['PeriodicalMaster.vendor' => $value])->order(['PeriodicalMaster.name' => 'ASC'])->toarray();
            $this->set('peropt', $peropt);
            $peropt[0] = "---Select Periodicals---";

            header('Content-Type: application/json');
            echo json_encode($peropt);
            die;
        }
    }

    public function updatesubstatus($id, $status)
    {
        $this->autoRender = false;
        $res = $this->PeriodicalMaster->get($id);
        $res->sub_status = $status;
        $result = $this->PeriodicalMaster->patchEntity($res, $this->request->data);
        if ($this->PeriodicalMaster->save($result)) {
            $this->redirect($this->referer());
        }

    }

    public function importbooks()
    {
        $this->viewBuilder()->layout('admin');
    }


    public function import()
    {
        $this->autoRender = false;
        if ($this->request->is(['post'])) {
            try {
                if ($this->request->data['file']['tmp_name']) {
                    $empexcel = $this->request->data['file'];
                    $excel_array = $this->bookExcelDatapalaceschool($empexcel['tmp_name']);
                    if ($excel_array == "null") {
                        $this->Flash->error(__('Please Fill Mandatory Fields'));
                        $this->set('error', $error);
                        return $this->redirect(['action' => 'importbooks']);
                    }
                    if (!empty($excel_array['message'])) {

                        $this->Flash->error(__($excel_array['message']));
                        $this->set('error', $error);
                        return $this->redirect(['action' => 'importbooks']);
                    }
                    foreach ($excel_array as $refer_data) {
                      try {
                            $books=$this->Book->find('all')->where(['Book.id' =>$refer_data['accsnno']])->order(['Book.id' => 'desc'])->first();
                             if($books['id']){
                                $book = $this->Book->get($books['id']);
                                $book = $this->Book->patchEntity($book, $refer_data);
                                if ($book = $this->Book->save($book)) {
                                }
                             }else{
                                $book = $this->Book->newEntity();
                                $book = $this->Book->patchEntity($book, $refer_data);
                                if ($book = $this->Book->save($book)) {
                                    $bookcopy = $this->BookCopyDetail->newEntity();
                                    $bookcopy->book_id = $book->id;
                                    $bookcopy->status = 'available';
                                    $this->BookCopyDetail->save($bookcopy);
                                }
                             }
                        } catch (\PDOException $e) { 
                            pr($e);exit;
                            $this->Flash->error(__('Books updation Failed' . $error));
                            $this->set('error', $error);
                            return $this->redirect(['action' => 'importbooks']);
                        } 
                    }
                    $this->Flash->success(__('Library list  has been saved.'));
                    return $this->redirect(['action' => 'importbooks']);
                }
                $this->Flash->error(__('Library  has not been saved.'));
                return $this->redirect(['action' => 'importbooks']);

            } catch (\PDOException $e) {

                $this->Flash->error(__('Library updation Failed' . $error));
                $this->set('error', $error);
                return $this->redirect(['action' => 'importbooks']);
            }
        }
    }

    public function bookExcelData($inputfilename)
    {
        require_once ROOT . DS . "vendor" . DS . "PHPExcel" . DS . "Classes" . DS . "PHPExcel" . DS . "IOFactory.php";
        if ($_POST) {
            try {
                $objPHPExcel = \PHPExcel_IOFactory::load($inputfilename);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputfilename, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestDataRow();
            $highestColumn = $sheet->getHighestDataColumn();
            $c = 0;
            $firstrow = 1;
            $firstsop = $sheet->rangeToArray('A' . $firstrow . ':' . $highestColumn . $firstrow, null, true, false);
            for ($row = 2; $row <= $highestRow; $row++) {
                $exceldata = array();
                $filesop = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
                $colB = $objPHPExcel->getActiveSheet()->getCell('A' . $row)->getValue();
                if ($colB == null || $colB == '') {
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $objPHPExcel->getActiveSheet()->getCell('A' . ($row - 1))->getValue());
                }

                //$val[] = $exceldata['book_type'] = $filesop[0][1];
                $val[] = $exceldata['book_type'] = "General";
                $val[] = $exceldata['book_category_id'] = $this->BookCategory->find('all')->where(['name' => trim($filesop[0][3])])->first()->id;

                $val[] = $exceldata['sbj'] =$this->BookCategory->find('all')->where(['name' => trim($filesop[0][3])])->first()->name;
                $val[] = $exceldata['accsnno'] = $filesop[0][0];
                $val[] = $exceldata['ISBN_NO'] = md5(uniqid(rand(), true));
                $val[] = $exceldata['name'] = $filesop[0][2];
                $val[] = $exceldata['sub_title'] = $filesop[0][2];
                $val[] = $exceldata['lang'] = "5";
                $val[] = $exceldata['author'] = $filesop[0][1];
                $val[] = $exceldata['publisher'] = $filesop[0][4];
                $val[] = $exceldata['vol'] = '1';
                $val[] = $exceldata['copy'] = '1';
                $val[] =  $exceldata['book_cost'] = $filesop[0][5];
                $exceldata['cup_board_id'] = '1';
                $exceldata['cup_board_shelf_id'] = '1';
                $exceldata['bilno'] = '0';
                $exceldata['typ'] = '0';
                $exceldata['bildt'] = date('Y-m-d');
                $val[] = $exceldata['book_vendor_id'] = '1';
                $exceldata['created'] = date('Y-m-d 00:00:00');
                $csv_data[] = $exceldata;

            }
            return $csv_data;
        }
    }

    public function bookExcelDatapalaceschool($inputfilename)
    {
    require_once ROOT . DS . "vendor" . DS . "PHPExcel" . DS . "Classes" . DS . "PHPExcel" . DS . "IOFactory.php";
	if ($_POST) {
		try {
			$objPHPExcel = \PHPExcel_IOFactory::load($inputfilename);
		} catch (Exception $e) {
			die('Error loading file "' . pathinfo($inputfilename, PATHINFO_BASENAME) . '": ' . $e->getMessage());
		}
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestDataRow();
		$highestColumn = $sheet->getHighestDataColumn();
		$c = 0;
		$firstrow = 1;
		$firstsop = $sheet->rangeToArray('A' . $firstrow . ':' . $highestColumn . $firstrow, null, true, false);
		for ($row = 2; $row <= $highestRow; $row++) {
			$exceldata = array();
            $filesop = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
            $val[] = $exceldata['book_type'] = "General";
            $val[] = $exceldata['ISBN_NO'] = md5(uniqid(rand(), true));
			$val[]=$exceldata['accsnno'] = $filesop[0][0];
			$val[]=$exceldata['author'] = $filesop[0][1];
			$val[]=$exceldata['name'] = $filesop[0][2];
            $val[]=$exceldata['publisher'] = $filesop[0][3];
            if($filesop[0][4]!=''){
            $val[]=$exceldata['book_cost'] = $filesop[0][4];
        }else{
           $val[]=$exceldata['book_cost'] = '0';
        }
        $val[] = $exceldata['vol'] = '1';
        $val[] = $exceldata['copy'] = '1';
			$val[]=$exceldata['vndr'] = "The Palace School";
			$book_cat_id=$this->BookCategory->find('all')->where(['name'=>trim($filesop[0][6])])->first()->id;
			if(empty($book_cat_id)){
				$new_cat=$this->BookCategory->newEntity();
				$new_cat->name=trim($filesop[0][6]);
				$new_cat=$this->BookCategory->save($new_cat);
                $book_cat_id=$new_cat->id;
                $name=$new_cat->name;
			}
            $val[]=$exceldata['book_category_id'] = $book_cat_id;
            $val[] = $exceldata['sbj'] =$this->BookCategory->find('all')->where(['id'=>$book_cat_id])->first()->name;
            $val[]= $exceldata['typ'] = '0';
            $val[]= $exceldata['copy'] = '1';
			$val[]=$exceldata['lang'] = $this->Language->find('all')->where(['language'=>trim($filesop[0][7])])->first()->id;
            $val[] = $exceldata['cup_board_id'] = '1';
            $val[] =$exceldata['cup_board_shelf_id'] = '1';
            $val[] = $exceldata['bilno'] = '0';
            $val[] = $exceldata['typ'] = '0';
            $val[] = $exceldata['book_vendor_id'] = '1';
			$csv_data[] = $exceldata;
        }
		return $csv_data;
	}
}

    public function request()
    {
        $this->viewBuilder()->layout('admin');

        $bookCopyDetails = $this->BookCopyDetail->find('list', ['keyField' => 'id', 'valueField' => 'book_id'])->where(['status' => 'Available'])->toarray();
        $bookRequests = $this->BookRequest->find('all')->contain(['Students', 'Book'])->where(['BookRequest.status' => 'pending'])->order(['BookRequest.created' => 'DESC'])->toarray();
        $bookCategory = $this->BookCategory->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toarray();
        $classes = $this->Classes->find('list', ['keyField' => 'id', 'valueField' => 'title'])->toarray();
        $sections = $this->Sections->find('list', ['keyField' => 'id', 'valueField' => 'title'])->toarray();
        $shelves = $this->CupBoardShelf->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toarray();
        $cupBoards = $this->CupBoard->find('all')->toarray();
        foreach ($cupBoards as $cupBoard) {
            $data = [];
            $data['room_id'] = $cupBoard['roomid'];
            $data['name'] = $cupBoard['name'];
            $cupboardLocation[$cupBoard['id']] = $data;
        }
        $this->set(compact('bookRequests', 'classes', 'sections', 'bookCategory', 'cupboardLocation', 'shelves', 'bookCopyDetails'));
    }

    public function request_search()
    {
        if ($this->request->is('post')) {
            $this->viewBuilder()->layout(false);
    
            $bookCopyDetails = $this->BookCopyDetail->find('list', ['keyField' => 'id', 'valueField' => 'book_id'])->where(['status' => 'Available'])->toarray();
            $bookCategory = $this->BookCategory->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toarray();
            $classes = $this->Classes->find('list', ['keyField' => 'id', 'valueField' => 'title'])->toarray();
            $sections = $this->Sections->find('list', ['keyField' => 'id', 'valueField' => 'title'])->toarray();
            $shelves = $this->CupBoardShelf->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toarray();
            $cupBoards = $this->CupBoard->find('all')->toarray();
            foreach ($cupBoards as $cupBoard) {
                $data = [];
                $data['room_id'] = $cupBoard['roomid'];
                $data['name'] = $cupBoard['name'];
                $cupboardLocation[$cupBoard['id']] = $data;
            }
            if (!empty($this->request->data['class_id'])) {
                $con['Students.class_id'] = $this->request->data['class_id'];
            }
            if (!empty($this->request->data['d1'])) {
                $con['DATE(BookRequest.created) >='] = date('Y-m-d', strtotime($this->request->data['d1']));
            }
            if (!empty($this->request->data['d2'])) {
                $con['DATE(BookRequest.created) <='] = date('Y-m-d', strtotime($this->request->data['d2']));
            }
            $con['BookRequest.status']='pending';
            $bookRequests = $this->BookRequest->find('all')->contain(['Students', 'Book'])->where($con)->order(['BookRequest.created' => 'DESC'])->toarray();
            $this->set(compact('bookRequests', 'classes', 'sections', 'bookCategory', 'cupboardLocation', 'shelves', 'bookCopyDetails'));
        }
    }
    public function reject_book_request()
    {
        $this->autoRender=false;
        $request = $this->BookRequest->find('all')->where(['id' => $this->request->data['id']])->first();
        $request->status = "rejected";
        if ($this->BookRequest->save($request)) {
            echo 1;
            return;
        } else {
            echo 0;
            return;
        }

    }

}
