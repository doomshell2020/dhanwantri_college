<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;


class TimetablesController extends AppController
{

	public function index()
	{
		$this->viewBuilder()->layout('admin');
		//using for listing
		$timetable_data = $this->Timetables->find('all')->toArray();
		$this->set('timetabledata', $timetable_data);
	}

	public function add($id = null)
	{
		$this->viewBuilder()->layout('admin');
		if (isset($id) && !empty($id)) {
			$sections = $this->Timetables->get($id);
			$weekd = $sections->weekday;
			$weekd = explode(',', $weekd);
			$this->set('weekd', $weekd);
		} else {
			$sections = $this->Timetables->newEntity();
			$this->request->data['status'] = '1';
		}

		$this->set('timestable', $sections);
		if ($this->request->is(['post', 'put'])) {
			$this->request->data['weekday'] = implode(',', $this->request->data['weekday']);
			// save all data in database
			$sections = $this->Timetables->patchEntity($sections, $this->request->data);

			$timetable_datas = $this->Timetables->find('all')->where(['Timetables.is_break' => '1'])->order(['Timetables.id' => 'DESC'])->toarray();
			$dt = $timetable_datas[0]['id'];
			if ($dt && $this->request->data['is_break'] == '1' && $dt != $id) {

				$this->Flash->error(
					__("Please fix the following error(s): Timetable have already break time")
				);
			} else {
				if ($this->request->data['time_from'] != $this->request->data['time_to']) {

					if ($this->Timetables->save($sections)) {
						$this->Flash->success(__('Your Time table information has been saved.'));
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
				} else {
					$errors_msg = "Make some differnce in time.";
					$this->Flash->error(
						__("Please fix the following error(s): " . $errors_msg)
					);
				}
			}
		}
	}
	// view functionality particular id
	public function view($id)
	{
		$this->viewBuilder()->layout('admin');
		$sections = $this->Timetables->get($id);
		$this->set(compact('sections'));
	}


	// delete particular id
	public function delete($id)
	{
		$work = $this->Timetables->get($id);
		if ($this->Timetables->delete($work)) {
			$this->Flash->success(__('The Time tables with id: {0} has been deleted.', h($id)));
			return $this->redirect(['action' => 'index']);
		}
	}

	//changes status functionlity
	public function status($id, $status)
	{
		if ($status == 1) {
			$status = 0;
		} else {
			$status = 1;
		}
		if (isset($id) && !empty($id)) {
			$section = $this->Timetables->get($id);
			$section->status = $status;
			if ($this->Timetables->save($section)) {
				$this->Flash->success(__('Your Time tables status has been updated.'));
				return $this->redirect(['action' => 'index']);
			}
		}
	}
}
