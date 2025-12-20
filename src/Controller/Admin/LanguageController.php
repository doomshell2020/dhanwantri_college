<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\View\Helper;

	/**
	 *Creating Cup Boards for Library Management System 
	 */
	class LanguageController extends AppController
	{
		//----------------------------------------
		public $helpers = ['CakeJs.Js'];

		//----------------------------------------
		public function initialize()
		{
			parent::initialize();

			//Loading Models
			$this->loadModel('Language');
		}

		//----------------------------------------
		public function index($id=null)
		{
			$this->viewBuilder()->layout('admin');
			if(isset($id) && !empty($id))
			{
				$language1 = $this->Language->get($id);
			}
			else
			{
				$language1 = $this->Language->newEntity();
			}
			$this->set('language1', $language1);
			if( $this->request->is( ['post', 'put'] ) )
			{
				// save all data in database
				$req_data = $this->request->data;
				$lkj=$req_data['language'];
				$userTable = TableRegistry::get('Language');
				$exists = $userTable->exists(['language' => $lkj]);
				if($exists){
					$this->Flash->error( __('This book is already exist.') );
					return $this->redirect(['action' => 'index']);
				}
				$language1 = $this->Language->patchEntity($language1, $req_data);
				
				if( $this->Language->save( $language1 ) )
				{
					if( isset( $req_data['button'] ) && !empty( $req_data['button'] ))
						$this->Flash->success( __('Your Book Language has been updated.') );
					else
						$this->Flash->success( __('Your Book Language has been created.') );
					return $this->redirect(['action' => 'index']);
				}
				else
				{    
					//check validation error
					if( $language1->errors() )
					{
						$error_msg = [];

						foreach( $lanh->errors() as $errors )
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

			//-------------------------------------------------------------------------------------------------
			$languages=$this->Language->find('all')->order(['Language.id' => 'DESC'])->toarray();
			$this->set('languages',$languages);
		}

		// Status Update functionality
		public function status($id, $status)
		{
			if( isset( $id ) && !empty( $id ) )
			{
				if( $status == 'Y' )
				{
					$status = 'N';
					//status update
					$lanh = $this->Language->get($id);
					$lanh->status = $status;
					if( $this->Language->save( $lanh ) )
					{
						$this->Flash->success(__('Your Book Language status has been updated.'));
						return $this->redirect(['action' => 'index']);	
					}
				}
				else
				{
					$status = 'Y';
					//status update
					$lanh = $this->Language->get($id);
					$lanh->status = $status;
					if ($this->Language->save($lanh))
					{
						$this->Flash->success(__('Your Book Language status has been updated.'));
						return $this->redirect(['action' => 'index']);	
					}
				}

			}
		}

		// Delete Functionality
		public function delete($id)
		{
			$lanh = $this->Language->get($id);
			if( $this->Language->delete( $lanh ) )
			{
				$this->Flash->success(__('The Book Language with id: {0} has been deleted.', h( $id ) ) );
				return $this->redirect(['action' => 'index']);
			}
		}

		//---------------------------------------------------------
		
	}

	?>
