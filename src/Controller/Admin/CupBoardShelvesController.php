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
class CupBoardShelvesController extends AppController
{
	//----------------------------------------
	public $helpers = ['CakeJs.Js'];

	//----------------------------------------
	public function initialize()
	{
		parent::initialize();
		//Loading Models
		$this->loadModel('CupBoardShelf');
		$this->loadModel('CupBoard');
	}

	//----------------------------------------
	public function index($id = null)
	{
		$this->viewBuilder()->layout('admin');
		$cupboards=$this->CupBoard->find('list')->where(['CupBoard.status' => 'Y'])->order(['CupBoard.name' => 'Asc'])->toarray();
		$this->set('cupboards',$cupboards);
		if(isset($id) && !empty($id))
		{
			$cupboardshelf = $this->CupBoardShelf->get($id);
		}
		else
		{
			$cupboardshelf = $this->CupBoardShelf->newEntity();
		}
		$this->set('cupboardshelf', $cupboardshelf);
		if( $this->request->is( ['post', 'put'] ) )
		{
			// save all data in database
			$req_data = $this->request->data;
			$cupboardshelf = $this->CupBoardShelf->patchEntity($cupboardshelf, $req_data);
			if( $this->CupBoardShelf->save( $cupboardshelf ) )
			{
				if(isset( $req_data['button'] ) && !empty( $req_data['button'] ))
					$this->Flash->success( __('Your Shelf has been updated.') );
				else
					$this->Flash->success( __('Your Shelf has been created.') );
				
				return $this->redirect(['action' => 'index']);
			}
			else
			{    
				//check validation error
				if( $cupboardshelf->errors() )
				{
					$error_msg = [];
					foreach( $cupboardshelf->errors() as $errors )
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
		//------------------------------------------------------------------------------------
		$cupboardshelfs = $this->CupBoardShelf->find('all')->contain(['CupBoard'])->order(['CupBoardShelf.id' => 'DESC'])->toArray();
		$this->set('cupboardshelfs',$cupboardshelfs);
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
				$cupboardshelf = $this->CupBoardShelf->get($id);
				$cupboardshelf->status = $status;
				if( $this->CupBoardShelf->save( $cupboardshelf ) )
				{
					$this->Flash->success(__('Your Shelf status has been updated.'));
					return $this->redirect(['action' => 'index']);	
				}
			}
			else
			{
				$status = 'Y';
				//status update
				$cupboardshelf = $this->CupBoardShelf->get($id);
				$cupboardshelf->status = $status;
				if ($this->CupBoardShelf->save($cupboardshelf))
				{
					$this->Flash->success(__('Your Shelf status has been updated.'));
					return $this->redirect(['action' => 'index']);	
				}
			}
		}
	}

//---------------------------------------------------------
	public function delete($id)
	{
		$this->loadModel('Book');

		$library_book =  $this->Book->find('all')->where(['Book.cup_board_shelf_id'=>$id])->count(); 
		// pr($library_book); die; 
		if($library_book > 0){
			$this->Flash->error(__('This Cup Board shelf is use in another module so you can not delete this.'));
			return $this->redirect(['action' => 'index']);

		}
	
		$cupboardshelf = $this->CupBoardShelf->get($id);
		if( $this->CupBoardShelf->delete( $cupboardshelf ) )
		{
			$this->Flash->success(__('The Shelf with id: {0} has been deleted.', h( $id ) ) );
			return $this->redirect(['action' => 'index']);
		}
	}

	//---------------------------------------------------------
	public function view($id)
	{
		$this->viewBuilder()->layout('admin');
		$cupboardshelf_data = $this->CupBoardShelf->find('all')->where(['CupBoardShelf.id' => $id])->contain(['CupBoard'])->toArray();
		foreach ($cupboardshelf_data as $cupboardshelf)
		{
			$this->set(compact('cupboardshelf'));	
		}
	}
}

?>
