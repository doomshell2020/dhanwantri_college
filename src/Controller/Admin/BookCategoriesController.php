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
	class BookCategoriesController extends AppController
	{
		//----------------------------------------
		public $helpers = ['CakeJs.Js'];

		public function initialize()
		{
			parent::initialize();
			//Loading Models
			$this->loadModel('BookCategory');
			$this->loadModel('Book');

		}

		//----------------------------------------
		public function index($id=null)
		{
			$this->viewBuilder()->layout('admin');
			if(isset($id) && !empty($id))
			{
				$bookcategory = $this->BookCategory->get($id);
			}
			else
			{
				$bookcategory = $this->BookCategory->newEntity();
			}
			$this->set('bookcategory', $bookcategory);
			if( $this->request->is( ['post', 'put'] ) )
			{
				// save all data in database
				$req_data = $this->request->data;
				$bookcategory = $this->BookCategory->patchEntity($bookcategory, $req_data);
				if( $this->BookCategory->save( $bookcategory ) )
				{
					if( isset( $req_data['button'] ) && !empty( $req_data['button'] ))
						$this->Flash->success( __('Your Book category has been updated.') );
					else
						$this->Flash->success( __('Your Book category has been created.') );
					return $this->redirect(['action' => 'index']);
				}
				else
				{    
					//check validation error
					if( $bookcategory->errors() )
					{
						$error_msg = [];
						foreach( $bookcategory->errors() as $errors )
						{
							if( is_array( $errors))
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
			//-------------------------------------------------------------------------------------------------
			$bookcategories=$this->BookCategory->find('all')->order(['BookCategory.id' => 'DESC'])->toarray();
			$this->set('bookcategories',$bookcategories);
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
					$bookcategory = $this->BookCategory->get($id);
					$bookcategory->status = $status;
					
					if( $this->BookCategory->save( $bookcategory ) )
					{
						$this->Flash->success(__('Your Book category status has been updated.'));
						return $this->redirect(['action' => 'index']);	
					}
				}
				else
				{
					$status = 'Y';
					//status update
					$bookcategory = $this->BookCategory->get($id);
					$bookcategory->status = $status;
					
					if ($this->BookCategory->save($bookcategory))
					{
						$this->Flash->success(__('Your Book category status has been updated.'));
						return $this->redirect(['action' => 'index']);	
					}
				}

			}
		}

		// Delete functionlity
		public function delete($id)
		{
			$books = $this->Book->find('all')->where(['Book.book_category_id' =>$id])->count(); 
			if($books>0){
			   $this->Flash->error('This books Category is used in another module so you can not delete this');
			   return $this->redirect($this->referer());
			}
			$bookcategory = $this->BookCategory->get($id);
			if( $this->BookCategory->delete( $bookcategory ) )
			{
				$this->Flash->success(__('The Book category with id: {0} has been deleted.', h( $id ) ) );
				return $this->redirect(['action' => 'index']);
			}
		}
	//---------------------------------------------------------
		public function view($id)
		{
			$this->viewBuilder()->layout('admin');
			$bookcategory = $this->BookCategory->get($id);
			$this->set(compact('bookcategory'));
		}
	}
