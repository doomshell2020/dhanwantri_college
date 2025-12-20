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
	 *Creating Cup Boards for Library Management System 
	 */
	class BookVendorsController extends AppController
	{
		//----------------------------------------
		public $helpers = ['CakeJs.Js'];

		//----------------------------------------
		public function initialize()
		{
			parent::initialize();

			//Loading Models
			$this->loadModel('BookVendor');
		}

		//----------------------------------------
		public function index($id=null)
		{
			$this->viewBuilder()->layout('admin');
			if(isset($id) && !empty($id))
			{
				$bookvendor = $this->BookVendor->get($id);
			}
			else
			{
				$bookvendor = $this->BookVendor->newEntity();
			}
			$this->set('bookvendor', $bookvendor);
			if( $this->request->is( ['post', 'put'] ) )
			{
				// save all data in database
				$req_data = $this->request->data;
				$bookvendor = $this->BookVendor->patchEntity($bookvendor, $req_data);
				if( $this->BookVendor->save( $bookvendor ) )
				{
					if( isset( $req_data['button'] ) && !empty( $req_data['button'] ))
						$this->Flash->success( __('Your Book Vendor has been updated.') );
					else
						$this->Flash->success( __('Your Book Vendor has been created.') );
					    return $this->redirect(['action' => 'index']);
				}
				else
				{    
					//check validation error
					if( $bookvendor->errors() )
					{
						$error_msg = [];

						foreach( $bookvendor->errors() as $errors )
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
           //------------------------------------------------------------------------------------------------------------------------
			$bookvendors=$this->BookVendor->find('all')->order(['BookVendor.id' => 'DESC'])->toarray();
			$this->set('bookvendors',$bookvendors);
		}
		//---------------------------------------------------------
		public function status($id, $status)
		{
			if( isset( $id ) && !empty( $id ) )
			{
				if( $status == 'Y' )
				{
					$status = 'N';
					//status update
					$bookvendor = $this->BookVendor->get($id);
					$bookvendor->status = $status;
					
					if( $this->BookVendor->save( $bookvendor ) )
					{
						$this->Flash->success(__('Your Book Vendor status has been updated.'));
						return $this->redirect(['action' => 'index']);	
					}
				}
				else
				{
					$status = 'Y';
					//status update
					$bookvendor = $this->BookVendor->get($id);
					$bookvendor->status = $status;
					
					if ($this->BookVendor->save($bookvendor))
					{
						$this->Flash->success(__('Your Book Vendor status has been updated.'));
						return $this->redirect(['action' => 'index']);	
					}
				}

			}
		}

		//---------------------------------------------------------
		public function delete($id)
		{
			$this->loadmodel('Book');
            $this->loadmodel('PeriodicalMaster'); 

			$periodcial_master  = $this->PeriodicalMaster->find('all')->where(['PeriodicalMaster.vendor'=>$id ])->count();
			$book_vandor = $this->Book->find('all')->where(['book_vendor_id'=>$id ])->count();
            if($book_vandor + $periodcial_master > 0){
			$this->Flash->error('This books vendor is used in another module so you can not delete this.');
			return $this->redirect(['action' => 'index']);
		}


			$bookvendor = $this->BookVendor->get($id);
			if( $this->BookVendor->delete( $bookvendor ) )
			{
				$this->Flash->success(__('The Book Vendor with id: {0} has been deleted.', h( $id ) ) );
				return $this->redirect(['action' => 'index']);
			}
		}
		//---------------------------------------------------------
		public function view($id)
		{
			$this->viewBuilder()->layout('admin');
			$bookvendor = $this->BookVendor->get($id);
			$this->set(compact('bookvendor'));
		}
	}

	?>
