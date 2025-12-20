<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * Creating Issue Book for Library Management System
 */
class IssuebooksController extends AppController
{
    //----------------------------------------
    public $helpers = ['CakeJs.Js'];

    //----------------------------------------
    public function initialize()
    {
        parent::initialize();
        //Loading Models
        $this->loadModel('BookCategory');
        $this->loadModel('Book');
        $this->loadModel('IssueBook');
        $this->loadModel('BookCopyDetail');
        $this->loadModel('BookStatus');
        $this->loadModel('Smsmanager');
        $this->loadModel('Smsdelivery');

        //For autocomplete feature
        $this->loadModel('Students');
        $this->loadModel('Employees');
    }

    public function file_get_contents_curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function sendsms($smstemp_id = null, $mesg = null)
    {

        //    pr($due_books); die;
        $session = $this->request->session();
        $acd = $session->read('Auth.User.academic_year');
        $current_date = date('Y-m-d');
        $due_books = $this->IssueBook->find('all')->contain(['BookCopyDetail' => ['Book' => ['CupBoard' => ['conditions' => ['CupBoard.roomid IN' => ['1', '2']]]]]])->where(['IssueBook.due_date <' => $current_date, 'IssueBook.holder_type_id' => 'Student', 'IssueBook.status' => 'Y'])->toarray();
        $count = count($due_books);
        //echo $count ; die;
        //    $attendence_status = $this->Studattends->find()->where(['Studattends.status' => 'A', 'Studattends.date' => $current_date])->count();
        $connsssks = ConnectionManager::get('default');
        $mesg1 = addslashes($mesg);
        $connsssks->execute("INSERT INTO
			`sms_deliveries`(`sms_temp_id`, `message`, `total students`,`status`) VALUES
			('" . $smstemp_id . "','" . $mesg1 . "','" . $count . "','Y')");

        $smsdelivery = $this->Smsdelivery->find('all')->select(['id'])->where(['sms_temp_id' => $smstemp_id])->order(['id' => 'DESC'])->first();

        if ($count > 0) {
            $g = 0;
            foreach ($due_books as $due_book) {
                $stu = $this->Students->find('all')->where(['enroll' => $due_book['holder_id'], 'board_id' => $due_book['board'], 'acedmicyear' => $acd, 'status' => 'Y'])->first();

                $mobile = trim($stu['sms_mobile']);
                $conn = ConnectionManager::get('default');
                $g++;

                $result = $this->file_get_contents_curl('http://alerts.prioritysms.com/api/web2sms.php?workingkey=Afb7ede974e22367003ac66f8514bd152&to=' . $mobile . '&sender=SNSKAR&message=' . urlencode($mesg));

                if ($result == "Invalid Input Data") {
                    $connsssksg = ConnectionManager::get('default');
                    date_default_timezone_set('Asia/Kolkata');
                    $date = date('Y-m-d H:i:s');

                    $connsssksg->execute("INSERT INTO
			`sms_deliveries_details`(`stud_id`, `smsmobile`, `sms_deliv_id`, `sms_temp_id`,`created`,`status`) VALUES
			('" . $stu['id'] . "','" . $mobile . "','" . $smsdelivery['id'] . "','" . $smstemp_id . "','" . $current_date . "','N')");

                } else if ($result == "Invalid Mobile Numbers") {
                    $connsssksk = ConnectionManager::get('default');
                    date_default_timezone_set('Asia/Kolkata');
                    $date = date('Y-m-d H:i:s');

                    $connsssksk->execute("INSERT INTO
			`sms_deliveries_details`(`stud_id`, `smsmobile`, `sms_deliv_id`, `sms_temp_id`,`created`,`status`) VALUES
			('" . $stu['id'] . "','" . $mobile . "','" . $smsdelivery['id'] . "','" . $smstemp_id . "','" . $current_date . "','N')");

                } else if ($result == "Insufficient credits") {
                    $connsssksks = ConnectionManager::get('default');
                    date_default_timezone_set('Asia/Kolkata');
                    $date = date('Y-m-d H:i:s');

                    $connsssksks->execute("INSERT INTO
			`sms_deliveries_details`(`stud_id`, `smsmobile`, `sms_deliv_id`, `sms_temp_id`,`created`,`status`) VALUES
			('" . $stu['id'] . "','" . $mobile . "','" . $smsdelivery['id'] . "','" . $smstemp_id . "','" . $current_date . "','N')");

                } else {

                    $connsssks = ConnectionManager::get('default');
                    date_default_timezone_set('Asia/Kolkata');
                    $date = date('Y-m-d H:i:s');

                    $connsssks->execute("INSERT INTO
			`sms_deliveries_details`(`stud_id`, `smsmobile`, `sms_deliv_id`, `sms_temp_id`,`created`) VALUES
			('" . $stu['id'] . "','" . $mobile . "','" . $smsdelivery['id'] . "','" . $smstemp_id . "','" . $current_date . "')");

                }

            }

        }
        return;
    }
    
    //----------------------------------------
    public function index()
    {

        $this->viewBuilder()->layout('admin');
        $today = date('Y-m-d');

        $day = date('D', strtotime($today));
        //~ if($day=="Mon"){
        //~ $category = "Library Overdue";
        //~ $smstemp = $this->Smsmanager->find('all')->select(['id', 'message'])->where(['category' => $category])->order(['id' => 'ASC'])->first();
        //~ $smstemp_id = $smstemp->id;
        //~ $msg = $smstemp->message;

        //~ $sms_exist=$this->Smsdelivery->exists(['sms_temp_id'=>$smstemp_id,'DATE(created)'=>$today]);
        //~ if($sms_exist!=1)
        //~ {

        //~ $this->sendsms($smstemp_id,$msg);
        //~ }

        //~ }
        //pr($due_books); die;
        $b_category_data = $this->BookCategory->find()->select('name')->where(['BookCategory.status' => 'Y'])->order(['BookCategory.name' => 'Asc'])->toarray();

        foreach ($b_category_data as $value) {
            $element = $value['name'];

            $b_category[$element] = $element;
        }

        $this->set('b_category', $b_category);

    }

    //----------------------------------------
    public function issue()
    {
        $this->loadModel('Boards');
        $this->loadModel('BookRequest');
        $issuebook = $this->IssueBook->newEntity();
        $this->set('issuebook', $issuebook);

        if ($this->request->is(['post', 'put'])) {
            $req_data = $this->request->data;

            $iko = $this->request->data['holder_name'];
            $data = explode('-', $iko);
            $fg = explode('(', $iko);

            $hoid = trim($data['0']);
            //echo $hoid;

            $bname = trim($fg['1'], ')');

            $bid = $this->Boards->find()->select('id', 'name')->where(['Boards.name' => $bname])->first();
            $brid = $bid['id'];
            //echo $brid; die;

            $isssuer = $this->IssueBook->find()->select(['asn_no', 'issue_date', 'due_date'])->where(['IssueBook.status' => 'Y', 'IssueBook.holder_id' => $hoid, 'IssueBook.board' => $brid])->first();

            if (!empty($isssuer)) {
                if (!empty($this->request->data['request_id'])) {
                    $this->Flash->error(__('New Book cannot be issued before depositing previously issued'));

                    return $this->redirect(['controller' => 'Books', 'action' => 'request']);
                }
                $this->Flash->error(__('Book is already issued.'));

                return $this->redirect(['controller' => 'Issuebooks', 'action' => 'index']);

            }

            // save all data in database
            $req_data['d1'] = str_replace('/', '-', $req_data['d1']);
            $req_data['d2'] = str_replace('/', '-', $req_data['d2']);
            $req_data['issue_date'] = date('Y-m-d', strtotime($req_data['d1']));
            $req_data['due_date'] = date('Y-m-d', strtotime($req_data['d2']));

            $holder_info = explode('-', $req_data['holder_name']);
            //pr($holder_info); die;
            $bname = trim($fg['1'], ')');
            $bid = $this->Boards->find()->select('id', 'name')->where(['Boards.name' => $bname])->first();
            // pr($bid); die;

            $req_data['holder_id'] = trim($holder_info[0]);
            $req_data['board'] = $bid['id'];

            $issuebook = $this->IssueBook->patchEntity($issuebook, $req_data);

            //pr($issuebook); die;
            if ($this->IssueBook->save($issuebook)) {
                $b_copy = $this->BookCopyDetail->get($req_data['asn_no2']);
                $b_copy['status'] = 'Issued';
                $this->BookCopyDetail->save($b_copy);
                if (isset($this->request->data['request_id'])) {
                    $bookRequest = $this->BookRequest->get($this->request->data['request_id']);
                    $bookRequest->status = 'approved';
                    $this->BookRequest->save($bookRequest);
                    $this->Flash->success(__('Book issued successfully.'));

                    return $this->redirect(['controller' => 'Books', 'action' => 'request']);
                }

                $this->Flash->success(__('Book issued successfully.'));

                return $this->redirect(['controller' => 'Issuebooks', 'action' => 'index']);
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
    //---------------------------------------------------------------------
    public function autocompleteList()
    {
        $h_type = $this->request->data['h_type'];

        $uid = $this->request->session()->read('Auth.User.id');

        if ($h_type != '') {
            if ($h_type == 'Student') {
                //~ if($uid=='8'){
                //~ $data_list = $this->Students->find()->select(['enroll', 'fname', 'middlename', 'lname','board_id','class_id','section_id'])->where(['Students.class_id NOT IN' => ['18','19','1','2','3','4','6'],'Students.status' => 'Y'])
                //~ ->order(['Students.fname' => 'ASC'])->toArray();
                //~ }

                //~ if($uid=='9'){
                //~ $data_list = $this->Students->find()->select(['enroll', 'fname', 'middlename', 'lname','board_id','class_id','section_id'])->where(['Students.class_id IN' => ['18','19','1','2','3','4','6'],'Students.status' => 'Y'])
                //~ ->order(['Students.fname' => 'ASC'])->toArray();
                //~ }

                $data_list = $this->Students->find()->select(['enroll', 'fname', 'middlename', 'lname', 'board_id', 'class_id', 'section_id'])->where(['Students.status' => 'Y'])->order(['Students.fname' => 'ASC'])->toArray();

                $data_list = $this->autocompleteArrayCreation($data_list);
            } else if ($h_type == 'Employee') {
                $data_list = $this->Employees->find()->select(['id', 'fname', 'middlename', 'lname'])->where(['Employees.status' => 'Y'])
                    ->order(['Employees.fname' => 'ASC'])->toArray();
                $data_list = $this->autocompleteArrayCreation1($data_list);
            }

        } else {
            $data_list[] = [];
        }
        //pr($data_list); die;
        header("Content-Type: application/json");
        echo json_encode($data_list);

        exit();
    }

    public function studentissue()
    {
        $this->loadModel('Boards');
        $iko = $this->request->data['hold'];
        $data = explode('-', $iko);

        $hoid = $data['0'];
        $fg = explode('(', $iko);
        $bname = trim($fg['1'], ')');
        $bid = $this->Boards->find()->select('id', 'name')->where(['Boards.name' => $bname])->first();
        $brid = $bid['id'];

        $isssuer = $this->IssueBook->find()->select(['asn_no', 'issue_date', 'due_date'])->where(['IssueBook.status' => 'Y', 'IssueBook.holder_id' => $hoid, 'IssueBook.board' => $brid])->first();

        if (!empty($isssuer)) {

            $bookname = $this->Book->find()->select(['accsnno', 'name', 'id'])->where(['Book.accsnno' => $isssuer['asn_no']])->first();
            $bjk = $bookname['name'];
            $d1 = date('d-M-Y', strtotime($isssuer['issue_date']));
            $d2 = date('d-M-Y', strtotime($isssuer['due_date']));
            echo '<table class="table table-bordered table-striped">
            <tr>
            <td><b> S.No. </b></td>
            <td><b> Issued Book Name </b></td>
            <td><b> Issue Date </b></td>
            <td><b> Return Date </b></td>

            </tr>
            <tr>
            <td> 1 </td>
            <td> ' . $bjk . '</td>
            <td> ' . $d1 . '</td>
            <td> ' . $d2 . '</td>
            </tr>

            </table>';
                        die;

                    } else {
                        echo 0;die;
                    }

    }

    public function autobookfinder()
    {
        $b_name = $this->request->data['b_name'];

        if ($b_name != '') {

            $data_list = $this->Book->find()->select(['id', 'name'])->where(['Book.status' => 'Y', 'Book.name LIKE' => $b_name . '%'])
                ->order(['Book.name' => 'ASC'])->toArray();
            $entity = array();
            foreach ($data_list as $val) {
                $entity[] = $val['name'];
            }

        } else {
            $data_list[] = [];
        }

        header("Content-Type: application/json");
        echo json_encode($entity);

        exit();
    }

    //---------------------------------------------------------------------
    public function autocompleteArrayCreation1($obj)
    {
        foreach ($obj as $value) {
            $entry = $value['id'] . ' - ' . ucwords(strtolower($value['fname'])) . ' ';

            if ($value['middlename'] != '') {
                $entry .= ucwords(strtolower($value['middlename'])) . ' ';
            }

            $entry .= ucwords(strtolower($value['lname']));

            $entity[] = $entry;
        }

        return $entity;
    }

    public function autocompleteArrayCreation($obj)
    {
        $this->loadModel('Classes');
        $this->loadModel('Sections');
        //pr($obj); die;
        foreach ($obj as $value) {
            $cls_name = $this->Classes->find('all')->where(['Classes.id' => $value['class_id']])->first();
            $cname = $cls_name['title'];

            $sls_name = $this->Sections->find('all')->where(['Sections.id' => $value['section_id']])->first();
            $sec = $sls_name['title'];
            $entry = $value['enroll'] . ' - ' . ucwords(strtolower($value['fname'])) . ' ';

            if ($value['middlename'] != '') {
                $entry .= ucwords(strtolower($value['middlename'])) . ' ';
            }

            $entry .= ucwords(strtolower($value['lname']));
            $entry .= "- " . $cname . "-" . $sec;
            if ($value['board_id'] == '1') {
                $entry .= "(CBSE)";
            } else if ($value['board_id'] == '2') {
                $entry .= "(CAMBRIDGE)";
            } else {
                $entry .= "(IBDP)";
            }
            $entity[] = $entry;
        }

        return $entity;
    }

    //---------------------------------------------------------------------
    // public function asnNoList()
    // {
    //     $h_type = $this->request->data['h_type'];
    //     $h_name = $this->request->data['h_name'];
    //     $b_id = $this->request->data['b_id'];

    //     echo "<option value=''>Select ASN No.</option>";

    //     if( !empty($h_type) && !empty($h_name) )
    //     {
    //         $b_copy_list = $this->BookCopyDetail->find()->select('id')->where(['BookCopyDetail.book_id'=>$b_id, 'BookCopyDetail.status' => 'Available'])->toArray();

    //         foreach($b_copy_list as $value)
    //         {
    //             echo "<option value=".$value['id'].">".$value['id']."</option>";
    //         }
    //     }

    //     exit();
    // }

    //------------------------------------------------------------

    // Find All bokks In library 
    public function searchBook()
    {
        $conn = ConnectionManager::get('default');

        $isbn_no = $this->request->data['isbn_no'];
        $b_name = $this->request->data['b_name'];
        $publisher = $this->request->data['publisher'];
        $author = $this->request->data['author'];
        $sbj = $this->request->data['sbj'];
        $asn = $this->request->data['asn_no'];
        $lko = $this->request->data['langu'];
        $vbn = $this->request->data['type'];
        $sub_title = $this->request->data['sub_title'];

        $detail = "SELECT Book.id,Book.lang AS language,Book.typ AS type,IssueBook.board AS board,Book.periodic_category_id AS periodic_category_id,Book.sbj AS sbj,Book.publisher AS publisher,CupBoard.roomid as roomid,Book.ISBN_NO,Book.name as b_name,Book.author,BookCategory.name as b_category,BookCopyDetail.id as asn_no,Book.accsnno as accsnno, CupBoard.name as cupboard, CupBoardShelf.name as cupboard_shelf, COUNT(CASE WHEN BookCopyDetail.status='Available' THEN 1 END) as availableCount,BookCopyDetail.status as savailableCount FROM `library_books` Book
        LEFT JOIN `library_book_categories` BookCategory ON Book.`book_category_id` = BookCategory.`id`
        LEFT JOIN `library_cup_boards` CupBoard ON Book.`cup_board_id` = CupBoard.`id`
        LEFT JOIN `library_cup_board_shelves` CupBoardShelf ON Book.`cup_board_shelf_id` = CupBoardShelf.`id`
        LEFT JOIN `library_book_copy_details` BookCopyDetail ON Book.`id` = BookCopyDetail.`book_id`
        LEFT JOIN `library_issue_books` IssueBook ON BookCopyDetail.id = IssueBook.`asn_no2` AND IssueBook.`status`='Y' WHERE  1=1";

        // echo $detail;die;
        $cond = ' ';

        if (!empty($vbn)) {
            $cond .= " AND Book.typ LIKE '" . $vbn . "%' ";
        }

        if (!empty($isbn_no)) {
            $cond .= " AND Book.ISBN_NO LIKE '" . $isbn_no . "%' ";
        }

        if (!empty($b_name)) {
            $cond .= " AND UPPER(Book.name) LIKE '" . addslashes($b_name) . "%'";
        }

        if (!empty($author)) {
            $cond .= " AND UPPER(Book.author) LIKE '" . addslashes($author) . "%' ";
        }

        if (!empty($sbj)) {
            $cond .= " AND UPPER(BookCategory.name) LIKE '" . addslashes($sbj) . "' ";
        }

        if (!empty($publisher)) {
            $cond .= " AND Book.publisher LIKE '%" . addslashes($publisher) . "%' ";
        }

        if (!empty($asn)) {
            $cond .= " AND Book.accsnno ='" . $asn . "'";
        }

        if (!empty($sub_title)) {
            $cond .= " AND Book.sub_title LIKE '%" . $sub_title . "%' ";
        }

        if (!empty($lko)) {
            $cond .= " AND Book.lang LIKE '%" . $lko . "%' ";
        }

        $detail = $detail . $cond;
        $detail = $detail . " GROUP BY Book.id";
        $SQL = $detail . " ORDER BY Book.name ASC";
        $results = $conn->execute($SQL)->fetchAll('assoc');
        // pr($results); die;
        $this->set('books', $results);
    }

    // Find All Teacher 
    public function teacherlist()
    {
        $this->loadModel('ClasstimeTabs');
        $this->loadModel('Classections');
        $conn = ConnectionManager::get('default');
        //echo "hello"; die;
        $detail = "SELECT employees.id FROM classteachers INNER JOIN employees WHERE employees.id NOT IN (SELECT teach_id FROM classteachers) GROUP BY employees.id";
        $results = $conn->execute($detail)->fetchAll('assoc');

        foreach ($results as $key => $value) {
            $id = $value['id'];
            $cls = $this->ClasstimeTabs->find('all')->select(['class_id'])->where(['FIND_IN_SET(\'' . $id . '\',ClasstimeTabs.employee_id)'])->toArray();
            $asd = array();
            foreach ($cls as $key => $value1) {
                $asd[] = $value1['class_id'];
            }
            $b = array_unique($asd);
            $bnj = $this->Classections->find('all')->select(['class_id', 'section_id'])->where(['Classections.id IN' => $b])->toArray();
            pr($bnj);die;

        }

        pr($asd);die;

    }

    //------------------------------------------------------------
    // When Issue Any Book 
    public function issueBookInfo($asn_no = null, $s_id = null, $request_id = null)
    {
        $holder_type = ['Student' => 'Student', 'Employee' => 'Employee'];
        $this->set('holder_type', $holder_type);
        $b_copy = $this->BookCopyDetail->find('all')->where(['BookCopyDetail.id' => $asn_no, 'BookCopyDetail.status' => 'Available'])->toArray();

        if (!empty($b_copy)) {
            $b_id = $b_copy[0]['book_id'];

            $book1 = $this->Book->find('all')->where(['Book.status' => 'Y', 'Book.id' => $b_id])->first();
            //pr($book); die;
            if ($book1['periodic_category_id'] != '0' && $book1['book_category_id'] == '0') {
                $book = $this->Book->find('all')->where(['Book.status' => 'Y', 'Book.id' => $b_id])->contain(['PeriodicalMaster'])->first();
                //pr($book); die;

            }

            if ($book1['periodic_category_id'] == '0' && $book1['book_category_id'] != '0') {
                $book = $this->Book->find('all')->where(['Book.status' => 'Y', 'Book.id' => $b_id])->contain(['BookCategory'])->first();

            }

            $book['asn_no'] = $asn_no;

            $this->set('book', $book);
        } else {
            $book = [];
            $this->set('book', $book);
        }
        if (!empty($s_id)) {
            $student = $this->Students->find('all')->select(['enroll', 'fname', 'middlename', 'lname', 'Classes.title', 'Sections.title', 'Boards.name'])->contain(['Classes', 'Sections', 'Boards'])->where(['Students.id' => $s_id])->first();
            $this->set(compact('student'));
        }
        if (!empty($request_id)) {
            $this->set(compact('request_id'));
        }
    }
}
