<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';


class TransportsController extends AppController
{
	//initialize component
	public function initialize()
	{
		parent::initialize();
		$this->loadModel('Transports');
		$this->loadModel('Locations');
		$this->loadModel('Routemaster');
		$this->loadModel('Students');
	}

	public function index($id = null)
	{
		$this->viewBuilder()->layout('admin');
		//show data in listing
		$transports = $this->Transports->find('all')->contain(['Routemaster'])->order(['Transports.id' => 'asc'])->toarray();
		$studnetdata = $this->Students->find('all')->where(['location_id !=' => 0])->toarray();

		$this->paginate($service_data);
		$this->set('transports', $transports);
		$this->set('studnetdata', $studnetdata);
	}

	public function exportexcel($var = null)
	{
		$studnetdata = $this->Students->find('all')->contain(['Classes', 'Sections', 'Locations'])->where(['location_id !=' => 0])->toarray();
		$this->set('studnetdata', $studnetdata);
	}

	public function add($id = null)
	{
		$this->viewBuilder()->layout('admin');
		$route_master = $this->Routemaster->find('list', ['keyField' => 'id', 'valueField' => 'route_name'])->where(['Routemaster.status' => 'Y'])->order(['route_name' => 'ASC'])->toArray();

		$this->set(compact('locations', 'route_master'));
		if (isset($id) && !empty($id)) {
			$transports = $this->Transports->get($id);
			$optns = $transports->route;
			$this->set('optns', $optns);
		} else {

			$transports = $this->Transports->newEntity();
		}
		if ($this->request->is(['post', 'put'])) {

			$this->request->data['route'] = $this->request->data['route'];
			$driver_name = Ucfirst($this->request->data['driver_name']);
			$this->request->data['driver_name'] = $driver_name;
			$transports = $this->Transports->patchEntity($transports, $this->request->data);
			if ($this->Transports->save($transports)) {
				$this->Flash->success(__('Transport has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				//validation error
				if ($transports->errors()) {
					$error_msg = [];
					foreach ($transports->errors() as $errors) {
						if (is_array($errors)) {
							foreach ($errors as $error) {
								$error_msg[]    =   $error;
							}
						} else {
							$error_msg[]    =   $errors;
						}
					}
					if (!empty($error_msg)) {
						$this->Flash->error(
							__("Please fix the following error(s): " . implode("\n \r", $error_msg))
						);
					}
				}
			}
		}

		$this->set('transports', $transports);
	}


	public function sort()
	{
		$this->viewBuilder()->layout('admin');
		$id = $this->request->data['id'];
		if (isset($id) && !empty($id)) {
			//using for edit
			$classes = $this->Transports->get($id);
		} else {
			//using for new entry
			$classes = $this->Transports->newEntity();
		}

		if ($this->request->is(['post', 'put'])) {
			$classes->sort = $this->request->data['sort'];
			if ($this->Transports->save($classes)) {
				echo $classes['sort'];
			} else {
				echo 'wrong';
			}
		}
		die;
	}
	//view functionality
	public function view($id)
	{
		$this->viewBuilder()->layout('admin');
		//get data from paricular id
		$classes = $this->Transports->get($id);
		$this->set(compact('classes'));
	}


	//delete functionality
	public function delete($id)
	{
		$classes = $this->Transports->get($id);
		//delete pariticular entry
		if ($this->Transports->delete($classes)) {
			$this->Flash->success(__(' Transport with id: {0} has been deleted.', h($id)));
			return $this->redirect(['action' => 'index']);
		}
	}

	//status update functionality
	public function status($id, $status)
	{
		if (isset($id) && !empty($id)) {
			if ($status == 'Y') {
				$status = 'N';
				//status update
				$classes = $this->Transports->get($id);
				$classes->status = $status;
				if ($this->Transports->save($classes)) {
					$this->Flash->success(__(' Transport status has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			} else {
				$status = 'Y';
				//status update
				$classes = $this->Transports->get($id);
				$classes->status = $status;
				if ($this->Transports->save($classes)) {
					$this->Flash->success(__('Transport status has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			}
		}
	}
}
