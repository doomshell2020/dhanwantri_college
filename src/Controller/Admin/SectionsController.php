<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\View\Exception\MissingTemplateException;


class SectionsController extends AppController
{
	
	public function index()
	{
		// echo 'test';die;
		$this->loadModel('Sections');
		$this->viewBuilder()->layout('admin');
		//using for listing
		$section_data = $this->Sections->find('all')->order(['title' => 'ASC'])->toArray();
		// pr($section_data);die;
		$this->set('sections', $section_data);
	}
	public function add($id = null)
	{
		$this->loadModel('Sections');
		$this->viewBuilder()->layout('admin');
		if (isset($id) && !empty($id)) {
			$sections = $this->Sections->get($id);
		} else {
			$sections = $this->Sections->newEntity();
			$this->request->data['status'] = '1';
		}
		if ($this->request->is(['post', 'put'])) {

			// save all data in database
			$peopleTablsen = TableRegistry::get('Sections');
			$peopleTablsen->query();
			$exi = $peopleTablsen->exists(['title' => $this->request->data['title']]);
			if ($exi) {
				$this->Flash->error(__('Duplicate Entry not Allowed.'));
				return $this->redirect(['action' => 'index']);
			}
			$sections = $this->Sections->patchEntity($sections, $this->request->data);
			if ($this->Sections->save($sections)) {
				$this->Flash->success(__('Your Section has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {    //check validation error
				if ($sections->errors()) {
					$error_msg = [];
					foreach ($sections->errors() as $errors) {
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
		$this->set('sections', $sections);
	}
	// view functionality particular id
	public function view($id)
	{
		$this->loadModel('Sections');
		$this->viewBuilder()->layout('admin');
		$sections = $this->Sections->get($id);
		$this->set(compact('sections'));
	}
	// delete particular id
	public function delete($id)
	{
		$this->loadModel('Sections');
		//$this->request->allowMethod(['post', 'delete']);
		$work = $this->Sections->get($id);
		try {
			if ($this->Sections->delete($work)) {
				$this->Flash->success(__(' Section with id: {0} has been deleted.', h($id)));
				return $this->redirect(['action' => 'index']);
			}
		} catch (\PDOException $e) {
			//  $error = 'The item you are trying to delete is associated with other records';
			$this->Flash->error(__(' You can not delete this record because it is used in another table.'));
			$this->set('error', $error);
			//$this->Session->setFlash(__(' Lader all ready exists), 'flash/Error');
			return $this->redirect(['action' => 'index']);
		}
	}
	public function status($id, $status)
	{
		$this->loadModel('Sections');
		if ($status == 1) {
			$status = 0;
		} else {
			$status = 1;
		}
		//$this->viewBuilder()->layout('admin');
		if (isset($id) && !empty($id)) {
			$section = $this->Sections->get($id);
			$section->status = $status;
			if ($this->Sections->save($section)) {
				$this->Flash->success(__('Your section status has been updated.'));
				return $this->redirect(['action' => 'index']);
			}
		}
	}
}
