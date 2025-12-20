<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;


class SubjectclassController extends AppController
{
	//initialize component
	public function initialize()
	{
		parent::initialize();
		$this->loadModel('Subjectclass');
		$this->loadModel('Classes');
		$this->loadModel('Subjects');
		$this->loadModel('Classections');
	}

	public function index()
	{
		$this->viewBuilder()->layout('admin');
		//show data in listing
		$subjectclasses_data = $this->Subjectclass->find('all')->contain(['Classes', 'Subjects'])->order(['Subjectclass.id' => 'asc'])->toarray();
		$this->set('subjectclasses', $subjectclasses_data);
	}


	public function add($id = null)
	{
		$this->viewBuilder()->layout('admin');
		$classeslist  = $this->Classections->find('list', [
			'keyField' => 'Classes.id',
			'valueField' => 'Classes.title'
		])->contain(['Classes'])->where(['Classections.status' => 'Y', 'Classes.status' => '1'])->order(['Classes.sort' => 'asc'])->toArray();


		$this->set('classeslist', $classeslist);
		$subjectlist = $this->Subjects->find('list', [
			'keyField' => 'id',
			'valueField' => 'name'
		])->where(['status' => '1'])->order(['name' => 'ASC'])->toArray();
		$this->set('subjectlist', $subjectlist);
		if (isset($id) && !empty($id)) {
			//using for edit
			$subjectclasses_data = $this->Subjectclass->get($id);
			$this->set('id', $id);
		} else {
			//using for new entry
			$subjectclasses_data = $this->Subjectclass->newEntity();
			$statusquery = $this->Subjectclass->find('all')->where(['Subjectclass.status' => 'Y'])->count();
			if ($statusquery < 8) {
				$this->request->data['status'] = 'Y';
			} else {
				$this->request->data['status'] = 'Y';
			}
		}

		$this->set('subjectclasses_data', $subjectclasses_data);
		if ($this->request->is(['post', 'put'])) {
			$peopleTable = TableRegistry::get('Subjectclass');
			$oQuery = $peopleTable->query();
			$subject = sizeof($this->request->data['subject_id']);
			if ($subject >= 1) {
				for ($i = 0; $i < $subject; $i++) {
					$oQuery->insert(['class_id', 'subject_id', 'is_optional', 'is_result', 'status'])
						->values([
							'class_id' => $this->request->data['class_id'], 'subject_id' => $this->request->data['subject_id'][$i], 'is_optional' => $this->request->data['is_optional'], 'is_result' => $this->request->data['is_result'], 'status' => 'Y'
						]);
				}
				$d = $oQuery->execute();
				if ($d) {
					$this->Flash->success(__('Your Subject class has been saved.'));
					return $this->redirect(['action' => 'index']);
				}
			} else {
				$subjectclasses_data = $this->Subjectclass->patchEntity($subjectclasses_data, $this->request->data);
				if ($this->Subjectclass->save($subjectclasses_data)) {
					$this->Flash->success(__('Your Subject class has been saved.'));
					return $this->redirect(['action' => 'index']);
				}
			}
		}
	}


	public function sort()
	{
		$this->viewBuilder()->layout('admin');
		$id = $this->request->data['id'];
		if (isset($id) && !empty($id)) {
			//using for edit
			$classes = $this->Subjectclass->get($id);
		} else {
			//using for new entry
			$classes = $this->Subjectclass->newEntity();
		}

		if ($this->request->is(['post', 'put'])) {
			$classes->sort = $this->request->data['sort'];
			if ($this->Subjectclass->save($classes)) {
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
		$subjectclasses_data = $this->Subjectclass->find('all')->where(['Subjectclass.id' => $id])->contain(['Classes', 'Subjects'])->order(['Subjectclass.id' => 'ASC'])->toarray();
		$this->set('subjectclasses_data', $subjectclasses_data);
	}
	//delete functionality
	public function delete($id)
	{
		$classes = $this->Subjectclass->get($id);
		if ($this->Subjectclass->delete($classes)) {
			$this->Flash->success(__('The Subject class  with id: {0} has been deleted.', h($id)));
			return $this->redirect(['action' => 'index']);
		}
	}
	//status update functionality
	public function status($id, $status)
	{
		$statusquery = $this->Subjectclass->find('all')->where(['Subjectclass.status' => 'Y'])->count();
		if (isset($id) && !empty($id)) {
			if ($status == 'Y') {
				$status = 'N';
				//status update
				$classes = $this->Subjectclass->get($id);
				$classes->status = $status;
				if ($this->Subjectclass->save($classes)) {
					$this->Flash->success(__('Your Subject class has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			} else {
				$status = 'Y';
				//status update
				$classes = $this->Subjectclass->get($id);
				$classes->status = $status;
				if ($this->Subjectclass->save($classes)) {
					$this->Flash->success(__('Your Subject class has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			}
		}
	}



	public function optional($id, $status)
	{
		$statusquery = $this->Subjectclass->find('all')->where(['Subjectclass.is_optional' => '0'])->count();
		if (isset($id) && !empty($id)) {
			if ($status == '0') {
				$status = '1';
				//status update
				$classes = $this->Subjectclass->get($id);
				$classes->is_optional = $status;
				if ($this->Subjectclass->save($classes)) {
					$this->Flash->success(__('Your Subject details has been updated to optional successfully.'));
					return $this->redirect(['action' => 'index']);
				}
			} else {
				$status = '0';
				//status update
				$classes = $this->Subjectclass->get($id);
				$classes->is_optional = $status;
				if ($this->Subjectclass->save($classes)) {
					$this->Flash->success(__('Your Subject details has been updated to  Main Subject successfully.'));
					return $this->redirect(['action' => 'index']);
				}
			}
		}
	}

	public function isresult($id, $status)
	{
		$statusquery = $this->Subjectclass->find('all')->where(['Subjectclass.is_result' => '0'])->count();
		if (isset($id) && !empty($id)) {
			if ($status == '0') {
				$status = '1';
				//status update
				$classes = $this->Subjectclass->get($id);
				$classes->is_result = $status;

				if ($this->Subjectclass->save($classes)) {
					$this->Flash->success(__('Your Subject details has been updated  successfully.'));
					return $this->redirect(['action' => 'index']);
				}
			} else {
				$status = '0';
				//status update
				$classes = $this->Subjectclass->get($id);
				$classes->is_result = $status;
				if ($this->Subjectclass->save($classes)) {
					$this->Flash->success(__('Your Subject details has been updated successfully.'));
					return $this->redirect(['action' => 'index']);
				}
			}
		}
	}
}
