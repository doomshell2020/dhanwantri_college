<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper;

/**
 *Creating Return/Renew Books for Library Management Module 
 */
class ReturnRenewBooksController extends AppController
{
	

	//----------------------------------------
	public $helpers = ['CakeJs.Js'];

	//----------------------------------------
	public function initialize()
	{
		parent::initialize();
		
		//Loading Models
		$this->loadModel('IssueBook');
		$this->loadModel('Book');
		$this->loadModel('BookCopyDetail');
		//$this->loadModel('Sitesettings');
		$this->loadModel('Employees');
		$this->loadModel('CupBoard');
			

	
	}

	//----------------------------------------

public function depositebooksearch()
	{
		//pr($this->request->data); die;
		

		$typ_id=$this->request->data['holder_type_id'];
		$h_name=explode('-',$this->request->data['holder_name']);
		$asn=$this->request->data['asn_no'];

		$session = $this->request->session();
		$role_id = $session->read('Auth.User.role_id');
		$user_id = $session->read('Auth.User.id');
		//pr($user_id); die;

		$apk=array();
		
		if(!empty($typ_id)){
 	$st1=array('IssueBook.holder_type_id' =>$typ_id);
 	$apk[]=$st1;

 }
  if(!empty($h_name[0])){
 	$st2=array('IssueBook.holder_id' =>$h_name[0]);
 	$apk[]=$st2;

 } if(!empty($asn)){
 	$st3=array('IssueBook.asn_no' =>$asn);
 	$apk[]=$st3;

 } 
 
 $st4=array('IssueBook.status'=>'Y');
 $apk[]=$st4;
 
 	if($user_id=='9' && $role_id=='7')
			{
			$issued_books = $this->IssueBook->find('all')->contain(['BookCopyDetail'=>['Book'=>['CupBoard'=>['conditions'=>['CupBoard.roomid'=>'1']]]]])->where($apk)->order(['IssueBook.id' => 'DESC'])->toarray();
		   }
		   elseif($user_id=='8' && $role_id=='7')
			{
				$issued_books = $this->IssueBook->find('all')->contain(['BookCopyDetail'=>['Book'=>['CupBoard'=>['conditions'=>['CupBoard.roomid'=>'2']]]]])->where($apk)->order(['IssueBook.id' => 'DESC'])->toarray();	
				//pr($issued_books); die;
			}
			elseif($role_id=='1')
			{
			$issued_books = $this->IssueBook->find('all')->contain(['BookCopyDetail'])->where($apk)->order(['IssueBook.id' => 'DESC'])->toarray();	
			}
			
			
			
			

			foreach ($issued_books as $value)
		{
			$book_details = $this->Book->find()->select(['name', 'ISBN_NO'])->contain(['CupBoard'])->where(['Book.id'=>$value['book_copy_detail']['book_id']])->toArray();
			//pr($book_details);
	    $value = $value->toArray();
	    //pr($value);
		if($book_details['0']){
		
			$book_details = $book_details['0']->toArray();
			$books[] = array_merge( $value, $book_details);
			//pr($books);
}else{
$books[] = $value;
}
			
		}
$this->set('books',$books);


	}






public function autoholdernamefinder()
	{
		$conn = ConnectionManager::get('default');
		$h_type = $this->request->data['h_type'];
		if( $h_type != '')
		{
		if( $h_type == 'Student' )
		{
		$detail = "SELECT Students.enroll,Students.fname,Students.middlename,Students.lname
				  
		FROM `library_issue_books` IssueBooks 
		LEFT JOIN `library_book_copy_details` BookCopyDetails ON IssueBooks.`asn_no2` = BookCopyDetails.`id` 
		LEFT JOIN `library_books` Books ON Books.`id` = BookCopyDetails.`book_id` 
		LEFT JOIN `students` Students ON (IssueBooks.`holder_id` = Students.`enroll` AND IssueBooks.holder_type_id = 'Student') 
		LEFT JOIN `employees` Employees ON IssueBooks.`holder_id` = Employees.`id` AND IssueBooks.holder_type_id = 'Employee' WHERE  IssueBooks.status='Y'";
			
		$SQL = $detail." ORDER BY Students.id DESC";   
		$resul = $conn->execute( $SQL )->fetchAll('assoc');
	
		foreach($resul as $value)
			{
				$data_list[] = $value['enroll'].'-'.$value['fname'].' '.$value['middlename'].' '.$value['lname'];
			}

			}
			else if( $h_type == 'Employee' )
			{
				$stmt = $conn->execute("select holder_name from library_issue_books where holder_type_id = 'Employee';");
			
			$results = $stmt ->fetchAll('assoc');
			foreach($results as $value)
			{
				$data_list[] = $value['holder_name'];
			}

			}
		}
		else
		{
			$data_list[] = [];
		}
		header("Content-Type: application/json");
		echo json_encode($data_list);

		exit();
	}

	public function index()
	{
		$this->viewBuilder()->layout('admin');

		$holder_type = ['Student' => 'Student', 'Employee' => 'Employee'];
		$this->set('holder_type', $holder_type);

		
		
		$session = $this->request->session();
		$role_id = $session->read('Auth.User.role_id');
		$user_id = $session->read('Auth.User.id');
		if($role_id == '3')
		{
			$email = $session->read('Auth.User.email');
			$emp_id = $this->Employees->find()->select('id')->where(['Employees.email'=>$email])->first()->id;
			
			$issued_books = $this->IssueBook->find("all")->where(['IssueBook.holder_id'=>$emp_id,'IssueBook.status'=>'Y'])->contain(['BookCopyDetail'])->toArray();
		}
		else
		{
			if($user_id=='9' && $role_id=='7')
			{
			$issued_books = $this->IssueBook->find('all')->where(['IssueBook.status'=>'Y'])->contain(['BookCopyDetail'=>['Book'=>['CupBoard'=>['conditions'=>['CupBoard.roomid'=>'1']]]]])->order(['IssueBook.id' => 'DESC'])->toarray();
		   }
		   elseif($user_id=='8' && $role_id=='7')
			{
				$issued_books = $this->IssueBook->find('all')->contain(['BookCopyDetail'=>['Book'=>['CupBoard'=>['conditions'=>['CupBoard.roomid'=>'2']]]]])->where(['IssueBook.status'=>'Y'])->order(['IssueBook.id' => 'DESC'])->toarray();	
				
			}
			elseif($role_id=='1')
			{
			$issued_books = $this->IssueBook->find('all')->contain(['BookCopyDetail'])->where(['IssueBook.status'=>'Y'])->order(['IssueBook.id' => 'DESC'])->toarray();	
			}
		}
		
		//pr($issued_books ); die;
		foreach ($issued_books as $value)
		{
			$book_details = $this->Book->find()->select(['name', 'ISBN_NO'])->contain(['CupBoard'])->where(['Book.id'=>$value['book_copy_detail']['book_id']])->toArray();
			//pr($book_details);
	    $value = $value->toArray();
	 
		if($book_details['0']){
		
			$book_details = $book_details['0']->toArray();
			$books[] = array_merge( $value, $book_details);
			//pr($books);
}else{
$books[] = $value;
}
			
		}//pr($books); die;
	
		$this->set('books',$books);
	}
	
	//----------------------------------------
	public function update($id=null)
	{
		$holder_type = ['Student' => 'Student', 'Employee' => 'Employee'];
		$this->set('holder_type', $holder_type);

		if(isset($id) && !empty($id))
		{
			$issuebook = $this->IssueBook->get($id);

			$issuebook['d1'] = date('d-m-Y',strtotime($issuebook['issue_date']));
			$issuebook['d2'] =  date('d-m-Y',strtotime($issuebook['due_date']));

			$this->set('issuebook', $issuebook);
		}

		if( $this->request->is( ['post', 'put'] ) )
		{
			// save all data in database
			$req_data = $this->request->data;
            
		    $req_data['d1']=str_replace('/', '-',$req_data['d1']);
		    $req_data['d2']=str_replace('/', '-',$req_data['d2']);
			$issuebook['issue_date']=date('Y-m-d',strtotime($req_data['d1']));
			$issuebook['due_date']=date('Y-m-d',strtotime($req_data['d2']));
			if( $this->IssueBook->save( $issuebook ) )
			{
				$this->Flash->success( __('Record updated successfully. ') );

				return $this->redirect(['action' => 'index']);
			}
			else
			{    
				//check validation error
				if( $issuebook->errors() )
				{
					$error_msg = [];

					foreach( $issuebook->errors() as $errors )
					{
						if( is_array( $errors ) )
						{
							foreach( $errors as $error )
							{
								$error_msg[] = $error;
							}
						}
						else
						{
							$error_msg[]    =   $errors;
						}
					}

					if( !empty( $error_msg ) )
					{
						$this->Flash->error( __( "Please fix the following error(s): ".implode( "\n \r", $error_msg ) ) );
					}
				}
			}
		}
	}


public function calculateFine()
	{
		$conn = ConnectionManager::get('default');

		$fine_type = $this->request->data['fine_type'];
		$asn_no = $this->request->data['asn_no'];
		//echo $fine_type.'-'.$asn_no; die;

		if( !empty($fine_type) && !empty($asn_no) )
		{
			$issuebook = $this->IssueBook->find()->select('due_date')->where(['IssueBook.asn_no2' => $asn_no])->first()->toArray();
			$d2 = date('d-m-Y', strtotime($issuebook['due_date']));
			$diff = date_diff( date_create(date("d-m-Y")) , date_create($d2) );

			$days = (int)$diff->format("%a");

			$stmt = $conn->execute("select fine_rate from sitesettings where id = '1';");
			$results = $stmt ->fetchAll('assoc');

			$rate = (int)$results[0]['fine_rate'];

			$fine = $rate * $days;
			
			//-------------------------------------

			if( $fine_type == 'Over due' )
			{
				echo $fine; die;
			}
			else if( $fine_type == 'Book lost' )
			{
				$stmt = $conn->execute("select book_id from library_book_copy_details where id ='".$asn_no."';");
				$results = $stmt ->fetchAll('assoc');
				
				$stmt = $conn->execute("select book_cost from library_books where id ='".$results['0']['book_id']."';");
				$results = $stmt ->fetchAll('assoc');

				$b_cost = (int)$results[0]['book_cost'];
				$fine += $b_cost;
				
				echo $fine; die;
			}else{
				echo 0; die;
			}
		}
	}




	//-----------------------------------------------------------------------------------------------------------------------
	public function returnBook($id=null,$oid=null)
	{
		$this->loadModel('Fine');
		$session = $this->request->session();
		$req_data = $this->request->data; 
		$user_id = $session->read('Auth.User.id');

		//pr($user_id); die;
		$nu='';
		if($user_id=='8'){
			$nu='2';

		}else if($user_id=='9'){
			$nu='1';
		}
		$issued_books = $this->IssueBook->find('all')->contain(['BookCopyDetail'=>['Book'=>['CupBoard'=>['conditions'=>['CupBoard.roomid'=>$nu]]]]])->where(['IssueBook.id' => $id])->order(['IssueBook.id' => 'DESC'])->first();
		//pr($issued_books); die;
$d1 = date('d-m-Y',strtotime($issued_books['issue_date']));
$bname=$issued_books['book_copy_detail']['book']['name'];
$asn=$issued_books['asn_no'];
$asns=$issued_books['asn_no2'];
 $this->set('dat',$d1);
 $this->set('bname',$bname);
 $this->set('asnn',$asn);
 $this->set('asnn2',$asns);
 $this->set('did',$oid);



		if( (isset( $req_data['checkbox'] ) && !empty( $req_data['checkbox'] && !empty( $req_data['fine_type']=='Over due' )) ) || (isset( $req_data['checkbox'] ) && !empty( $req_data['checkbox'] && !empty( $req_data['fine_type']=='No Fine' )) )
		|| (isset( $req_data['checkbox'] ) && !empty( $req_data['checkbox'] && !empty( $req_data['fine_type']=='' )) )  )	// code for book renew
		{
			//echo $id; die;
			//pr($this->request->data); die;
			if(isset($id) && !empty($id))
			{
				$issuebook = $this->IssueBook->get($id);
				//pr($issuebook); die;
				if($this->request->data['fine_type']=='Over due'){


					$session = $this->request->session();
  $u_id = $session->read('Auth.User.id');

				$fine = $this->Fine->newEntity();
				$fn['holder_type_id']=$issuebook['holder_type_id'];
				$fn['holder_name']=$issuebook['holder_name'];
				$fn['fine_type']=$this->request->data['fine_type'];

				$fn['amount']=$this->request->data['amount'];
				$di=str_replace('/', '-', $this->request->data['sub_date']);
				$df=date('Y-m-d',strtotime($di));
				$fn['sub_date']=$df;
				$fn['asn_no']=$this->request->data['asn'];
				$fn['remarks']="fine";
				$fn['user_id']=$u_id;
				$fine = $this->Fine->patchEntity($fine, $fn);
				//pr($fine); die;
				$this->Fine->save( $fine ); 

}//echo "hello"; die;



				$d1 = date('Y-m-d');						// current date
				$issuebook['issue_date'] = $d1;
				$renew_days = $this->Sitesettings->find()->select('renew_days')->where(['id'=>1])->first()->renew_days;	// renewing days
				$d2 = date('Y-m-d', strtotime('+'.$renew_days.' days'));	// calculating renewing date
				$issuebook['due_date'] = $d2;
				$asn_no2 = $issuebook['asn_no2'];
				if( $this->IssueBook->save( $issuebook ) )
				{

					$b_copy = $this->BookCopyDetail->get($asn_no2);
					$b_copy['status'] = 'Renew';
					$this->BookCopyDetail->save( $b_copy );
					$this->Flash->success( __('Book renewed successfully. ') );
					return $this->redirect(['action' => 'index']);
				}
				else
				{    
					//check validation error
					if( $issuebook->errors() )
					{
						$error_msg = [];

						foreach( $issuebook->errors() as $errors )
						{
							if( is_array( $errors ) )
							{
								foreach( $errors as $error )
								{
									$error_msg[] = $error;
								}
							}
							else
							{
								$error_msg[]    =   $errors;
							}
						}

						if( !empty( $error_msg ) )
						{
							$this->Flash->error( __( "Please fix the following error(s): ".implode( "\n \r", $error_msg ) ) );
						}
					}
				}
			}
		}
		else if( isset( $req_data['return'] ) && !empty( $req_data['return'] ) )	// code for book return
		{
			//pr($this->request->data); die;
			if(isset($id) && !empty($id))
			{
				$issuebook = $this->IssueBook->get($id);

				if($this->request->data['fine_type']=='Over due' || $this->request->data['fine_type']=='Book lost'){
					 $session = $this->request->session();
  $u_id = $session->read('Auth.User.id');

				$fine = $this->Fine->newEntity();
				$fn['holder_type_id']=$issuebook['holder_type_id'];
				$fn['holder_name']=$issuebook['holder_name'];
				$fn['fine_type']=$this->request->data['fine_type'];

				$fn['amount']=$this->request->data['amount'];
				$di=str_replace('/', '-', $this->request->data['sub_date']);
				$df=date('Y-m-d',strtotime($di));
				$fn['sub_date']=$df;
				$fn['asn_no']=$this->request->data['asn'];
				$fn['remarks']="fine";
				$fn['user_id']=$u_id;
				$fine = $this->Fine->patchEntity($fine, $fn);
				//pr($fine); die;
				$this->Fine->save( $fine ); 
} //echo "hello"; die;
				$asn_no2 = $issuebook['asn_no2'];


$connssss = ConnectionManager::get('default');
	    	$resultsucessssss = $connssss->execute("UPDATE `library_issue_books` SET `status` = 'N' WHERE `library_issue_books`.`id` =$id");

				

				if( $resultsucessssss )
				{
					if($this->request->data['fine_type']=='Book lost'){
				$b_copy = $this->BookCopyDetail->get($asn_no2);
				$b_copy['status'] = 'Lost';
				$this->BookCopyDetail->save( $b_copy );
				//pr($b_copy); die;
}else{
					$b_copy = $this->BookCopyDetail->get($asn_no2);

					if( $b_copy['status'] != 'Lost')
					{
						$b_copy['status'] = 'Available';
						$this->BookCopyDetail->save( $b_copy );
					}
				}
					
					$this->Flash->success( __('Book returned successfully. ') );
					return $this->redirect(['action' => 'index']);
				}
			}
		}
	}
}

?>

