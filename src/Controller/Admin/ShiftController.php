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
 *Creating Shifts for School Employees
 */
class ShiftController extends AppController
{
	//----------------------------------------
	public $helpers = ['CakeJs.Js'];

	//----------------------------------------
	public function initialize()
	{
		parent::initialize();

		//Loading Models
		$this->loadModel('Shift');
	}

	//----------------------------------------
	public function index()
	{
		$this->viewBuilder()->layout('admin');

		$shifts = $this->Shift->find('all')->toArray();

		$this->set(compact('shifts'));
		// pr($shifts);die;
	}

	//----------------------------------------
	public function edit($id=null)
	{
		if(!empty($id))
		{
			$shift = $this->Shift->get($id);
			$shift['s_time'] = date('h:i a', strtotime($shift['start_time']));
			$shift['e_time'] = date('h:i a', strtotime($shift['end_time']));

			$this->set(compact('shift'));
		}

		if( $this->request->is( ['post', 'put'] ) )
		{
			$req_data = $this->request->data;

			$req_data['start_time'] = date('H:i', strtotime($req_data['s_time']));
			$req_data['end_time'] = date('H:i', strtotime($req_data['e_time']));
			unset($req_data['s_time']);
			unset($req_data['e_time']);

			$shift = $this->Shift->patchEntity($shift, $req_data);

			if( $this->Shift->save( $shift ) )
			{
				$this->Flash->success( __('Your Shift has been updated.') );

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
}