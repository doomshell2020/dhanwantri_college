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
	class CupBoardsController extends AppController
	{
		//----------------------------------------
		public $helpers = ['CakeJs.Js'];

		//----------------------------------------
		public function initialize()
		{
			parent::initialize();
			//Loading Models
			$this->loadModel('CupBoard');
		}

		//----------------------------------------
		public function index($id=null)
		{
			$this->viewBuilder()->layout('admin');
			if(isset($id) && !empty($id))
			{
				$cupboard = $this->CupBoard->get($id);
			}
			else
			{
				$cupboard = $this->CupBoard->newEntity();
			}
			$this->set('cupboard', $cupboard);
			
			if( $this->request->is( ['post', 'put'] ) )
			{
				// save all data in database
				$req_data = $this->request->data;
				 $id=$this->request->session()->read('Auth.User.id');
				 if($id==9){
					 $this->request->data['roomid']='1';
				 }else{
					 $this->request->data['roomid']='2'; 
				 }
				$cupboard = $this->CupBoard->patchEntity($cupboard, $req_data);
				
				if( $this->CupBoard->save( $cupboard ) )
				{
					if( isset( $req_data['button'] ) && !empty( $req_data['button'] ))
						$this->Flash->success( __('Your Cupboard has been updated.') );
					else
						$this->Flash->success( __('Your Cupboard has been created.') );
					
					return $this->redirect(['action' => 'index']);
				}
				else
				{    
					//check validation error
					if( $cupboard->errors() )
					{
						$error_msg = [];

						foreach( $cupboard->errors() as $errors )
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
			$cupboards=$this->CupBoard->find('all')->order(['CupBoard.id' => 'DESC'])->toarray();
			$this->set('cupboards',$cupboards);
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
					$cupboard = $this->CupBoard->get($id);
					$cupboard->status = $status;
					
					if( $this->CupBoard->save( $cupboard ) )
					{
						$this->Flash->success(__('Your Cup Board status has been updated.'));
						return $this->redirect(['action' => 'index']);	
					}
				}
				else
				{
					$status = 'Y';
					//status update
					$cupboard = $this->CupBoard->get($id);
					$cupboard->status = $status;
					if ($this->CupBoard->save($cupboard))
					{
						$this->Flash->success(__('Your Cup Board status has been updated.'));
						return $this->redirect(['action' => 'index']);	
					}
				}

			}
		}

		//---------------------------------------------------------
		public function delete($id)
		{
			$this->loadModel('Book');
			$this->loadModel('CupBoardShelf');

			$library_books =  $this->Book->find('all')->where(['Book.cup_board_id'=>$id])->count(); 
			$cup_boards = $this->CupBoardShelf->find('all')->where(['CupBoardShelf.cup_board_id'=>$id])->count(); 
			// pr($library_books); die;
			if($cup_boards +  $library_books > 0){
				$this->Flash->error(__('This Cup Board is use in another module so you can not delete this.'));
				return $this->redirect(['action' => 'index']);
			}

			$cupboard = $this->CupBoard->get($id);
			if( $this->CupBoard->delete( $cupboard ) )
			{
				$this->Flash->success(__('The Cup Board with id: {0} has been deleted.', h( $id ) ) );
				return $this->redirect(['action' => 'index']);
			}
		}

		//---------------------------------------------------------
		public function view($id)
		{
			$this->viewBuilder()->layout('admin');
			$cupboard = $this->CupBoard->get($id);
			$this->set(compact('cupboard'));
		}
	}

	?>
