<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';


class TransportfeesController extends AppController
{
	//initialize component
	public function initialize()
	{
		parent::initialize();
		$this->loadModel('Transportfees');
		$this->loadModel('Transports');
		$this->loadModel('Locations');
		$this->loadModel('Students');
		$this->loadModel('Routemaster');
		$this->loadModel('Transportstudentlist');
		$this->loadModel('Users');
		$this->loadModel('Classes');
	}

	public function index()
	{
		$this->viewBuilder()->layout('admin');
		$transportfeess = $this->Transportfees->find('all')->contain(['Locations'])->order(['Transportfees.id' => 'DESC'])->toarray();
		$this->paginate($service_data);
		$this->set('transportfeess', $transportfeess);
	}


	public function add($id = null)
	{
		$this->viewBuilder()->layout('admin');
		$locations = $this->Locations->find('all')->contain('Transportfees')->where(['Locations.status' => 'Y'])->order(['name' => 'ASC'])->toArray();
		$fee_sub_q1 = $locations[0]['transportfee']['fee_sub_q1'];
		$fee_sub_q2 = $locations[0]['transportfee']['fee_sub_q2'];
		$fee_sub_q3 = $locations[0]['transportfee']['fee_sub_q3'];
		$fee_sub_q4 = $locations[0]['transportfee']['fee_sub_q4'];

		$this->set(compact('fee_sub_q1', 'fee_sub_q2', 'fee_sub_q3', 'fee_sub_q4'));
		$this->set('locations', $locations);

		if ($this->request->is(['post', 'put'])) {

			$fee_sub_dateq1 = $this->request->data['fee_sub_dateq1'];
			$fee_sub_dateq2 = $this->request->data['fee_sub_dateq2'];
			$fee_sub_dateq3 = $this->request->data['fee_sub_dateq3'];
			$fee_sub_dateq4 = $this->request->data['fee_sub_dateq4'];
			$academic_year = $this->request->data['academic_year'];


			foreach ($this->request->data['loc_id'] as $key => $value) {
				$transportfeeexits = $this->Transportfees->find('all')->order(['id' => 'ASC'])->where(['Transportfees.loc_id' => $key, 'Transportfees.academic_year' => $this->request->data['academic_year']])->first();
				if ($transportfeeexits) {
					$atn = $this->Transportfees->find('all')->where(['id' => $transportfeeexits['id']])->first();
				} else {
					$atn = $this->Transportfees->newEntity();
				}

				$datas['loc_id'] = $key;
				$datas['quarter1'] = $value['q1'];
				$datas['quarter2'] = $value['q2'];
				$datas['quarter3'] = $value['q3'];
				$datas['quarter4'] = $value['q4'];
				$datas['fee_sub_q1'] = $fee_sub_dateq1;
				$datas['fee_sub_q2'] = $fee_sub_dateq2;
				$datas['fee_sub_q3'] = $fee_sub_dateq3;
				$datas['fee_sub_q4'] = $fee_sub_dateq4;
				$datas['academic_year'] = $academic_year;

				$atn = $this->Transportfees->patchEntity($atn, $datas);
				$this->Transportfees->save($atn);
			}
			$this->Flash->success(__('Transport Fees has been saved.'));
			return $this->redirect(['action' => 'index']);
		}

		// $this->set('transportfees', $transportfees);
	}

	public function sort()
	{
		$this->viewBuilder()->layout('admin');
		$id = $this->request->data['id'];
		if (isset($id) && !empty($id)) {
			//using for edit
			$classes = $this->Transportfees->get($id);
		} else {
			//using for new entry
			$classes = $this->Transportfees->newEntity();
		}
		if ($this->request->is(['post', 'put'])) {
			$classes->sort = $this->request->data['sort'];
			if ($this->Transportfees->save($classes)) {
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
		$classes = $this->Transportfees->get($id);
		$this->set(compact('classes'));
	}

	//delete functionality
	public function delete($id)
	{
		$classes = $this->Transportfees->get($id);
		if ($this->Transportfees->delete($classes)) {
			$this->Flash->success(__(' Transport fees with id: {0} has been deleted.', h($id)));
			return $this->redirect(['action' => 'index']);
		}
	}

	public function deletest($id)
	{
		$data = $this->Transportstudentlist->get($id);
		//delete pariticular entry
		if ($this->Transportstudentlist->delete($data)) {
			$this->Flash->success(__(' Transport fees with id: {0} has been deleted.', h($id)));
			return $this->redirect(['action' => 'studentlist']);
		}
	}


	//status update functionality
	public function status($id, $status)
	{
		if (isset($id) && !empty($id)) {
			if ($status == 'Y') {
				$status = 'N';
				//status update
				$classes = $this->Transportfees->get($id);
				$classes->status = $status;
				if ($this->Transportfees->save($classes)) {
					$this->Flash->success(__(' Transport fees status has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			} else {
				$status = 'Y';
				//status update
				$classes = $this->Transportfees->get($id);
				$classes->status = $status;
				if ($this->Transportfees->save($classes)) {
					$this->Flash->success(__('Transport fees status has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			}
		}
	}

	public function ststatus($id, $status)
	{

		if (isset($id) && !empty($id)) {
			if ($status == 'Y') {

				$status = 'N';
				//status update
				$classes = $this->Transportstudentlist->get($id);
				$classes->status = $status;
				if ($this->Transportstudentlist->save($classes)) {
					$this->Flash->success(__(' Student Transport fees status has been updated.'));
					return $this->redirect(['action' => 'studentlist']);
				}
			} else {
				$status = 'Y';
				//status update
				$classes = $this->Transportstudentlist->get($id);
				$classes->status = $status;
				if ($this->Transportstudentlist->save($classes)) {
					$this->Flash->success(__('Student Transport fees status has been updated.'));
					return $this->redirect(['action' => 'studentlist']);
				}
			}
		}
	}

	public function studentlist()
	{
		$this->viewBuilder()->layout('admin');

		$alldata = $this->Transportstudentlist->find('all')->contain(['Students' => ['Classes', 'Sections'], 'Locations'])->order(['Transportstudentlist.id' => 'DESC'])->toArray();
		$this->set(compact('alldata'));
	}

	public function add_student($id = null)
	{
		$this->viewBuilder()->layout('admin');

		$userId = $this->Users->find('all')->where(['Users.id' => '1'])->first()->toArray();
		$currentyear = $userId['academic_year'];
		$previous_year = $userId['previous_year'];
		$nextyear = $userId['next_academic_year'];
		$this->set(compact('currentyear', 'nextyear', 'previous_year'));

		if (isset($id) && !empty($id)) {

			$alldetails = $this->Transportstudentlist->get($id);
			$soptns = $alldetails->student_id;
			$loptns = $alldetails->location_id;
			$busoptns = $alldetails->bus_number;
			$academicoptns = $alldetails->acadamic_year;
			$this->set(compact('soptns', 'loptns', 'busoptns', 'academicoptns'));
		} else {
		}
		$studentlist = $this->Students->find('list', ['keyField' => 'id', 'valueField' => function ($e) {
			return $e->fname . ' ' . $e->middlename . ' ' . $e->lname;
		}])->where(['Students.status' => 'Y'])->toarray();

		$locations = $this->Locations->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Locations.status' => 'Y'])->order(['name' => 'ASC'])->toArray();

		$this->set('locations', $locations);
		$this->set('studentlist', $studentlist);

		$route = $this->Transports->find('list', ['keyField' => 'id', 'valueField' => 'vechical_no'])->where(['Transports.status' => 'Y'])->toArray();

		$this->set('route', $route);


		if ($this->request->is(['post', 'put'])) {

			if (isset($id) && !empty($id)) {
				$transportfees = $this->Transportstudentlist->get($id);
				$this->request->data['student_id'] = $this->request->data['student_id'];
				$this->request->data['location_id'] = $this->request->data['loc_id'];
				$this->request->data['location_name'] = $this->request->data['location_name'];
				$this->request->data['bus_number'] = $this->request->data['bus_id'];
				$this->request->data['acadamic_year'] = $this->request->data['academic_year'];
				$this->request->data['qu1_fees'] = $this->request->data['qu1_fees'];
				$this->request->data['qu2_fees'] = $this->request->data['qu2_fees'];
				$this->request->data['qu3_fees'] = $this->request->data['qu3_fees'];
				$this->request->data['qu4_fees'] = $this->request->data['qu4_fees'];
			} else {
				$transportfees = $this->Transportstudentlist->newEntity();
				$checkdata = $this->Transportstudentlist->find('all')->where(['Transportstudentlist.student_id' => $this->request->data['student_id']])->first();
				if ($checkdata['id'] != null) {
					$this->Flash->error(__('This Student already exist.'));
					return $this->redirect(['action' => 'studentlist']);
				}
				$this->request->data['student_id'] = $this->request->data['student_id'];
				$this->request->data['location_id'] = $this->request->data['loc_id'];
				$this->request->data['location_name'] = $this->request->data['location_name'];
				$this->request->data['bus_number'] = $this->request->data['bus_id'];
				$this->request->data['acadamic_year'] = $this->request->data['academic_year'];
				$this->request->data['qu1_fees'] = $this->request->data['qu1_fees'];
				$this->request->data['qu2_fees'] = $this->request->data['qu2_fees'];
				$this->request->data['qu3_fees'] = $this->request->data['qu3_fees'];
				$this->request->data['qu4_fees'] = $this->request->data['qu4_fees'];

				// update transport strength and occupations
				$transports_details = $this->Transports->find('all')->where(['Transports.vechical_no' => $this->request->data['bus_id']])->first();
				$tsprt = $transports_details['id'];
				$transportdata = $this->Transports->get($tsprt);

				$totalstrenght = $transportdata['strength'];
				$totaloccupations = $transportdata['occupation'];

				if ($totalstrenght == $totaloccupations) {
					$this->Flash->error(__('Bus Strength has full Please allocate new Vechical for this location then add Student !.'));
					return $this->redirect(['action' => 'studentlist']);
				} else {
					// $dataupdate['strength'] = $totalstrenght - 1;
					$dataupdate['occupation'] = $totaloccupations + 1;
					$update = $this->Transports->patchEntity($transportdata, $dataupdate);
					$this->Transports->save($update);
				}
			}

			$Transportstudentlist = $this->Transportstudentlist->patchEntity($transportfees, $this->request->data);

			if ($this->Transportstudentlist->save($Transportstudentlist)) {
				$this->Flash->success(__('Student has been saved.'));
				return $this->redirect(['action' => 'studentlist']);
			} else {

				if ($Transportstudentlist->errors()) {
					$error_msg = [];
					foreach ($transportfees->errors() as $errors) {
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
	}

	public function find_bus()
	{

		$loc_id = $this->request->data['id'];
		$route = $this->Routemaster->find('all')->where(['Routemaster.status' => 'Y'])->toArray();
		foreach ($route as $key => $value) {
			$location =  explode(",", $value['location_id']);
			if (in_array($loc_id, $location)) {
				$routeid[] = $value['id'];
			}
		}
		foreach ($routeid as $route_id) {
			$transport = $this->Transports->find('all')->where(['route' => $route_id, 'status' => 'Y'])->toArray();
		}
		if (empty($transport)) {
			echo '<option value="">---Select Bus---</option>';
		} else {
			echo '<option value="">---Select Bus---</option>';
		}

		foreach ($transport as $key => $transport_name) {

			if (!empty($transport_name['id'])) {
				echo '<option value="' . $transport_name['vechical_no'] . '">' . $transport_name['vechical_no'] . '-' . '(' . ucwords($transport_name['driver_name']) . ')' . '</option>';
			}
		}
		die;
	}

	public function find_fees()
	{
		$loc_id = $this->request->data['id'];
		$session = $this->request->data['session'];
		$student_id = $this->request->data['student_id'];
		if (!empty($student_id)) {
			$transportfees = $this->Transportstudentlist->find('all')->where(['location_id' => $loc_id, 'acadamic_year' => $session, 'student_id' => $student_id])->first();
			$transport = $this->Transportfees->find('all')->where(['loc_id' => $loc_id, 'academic_year' => $session])->first();
		} else {
			$transport = $this->Transportfees->find('all')->where(['loc_id' => $loc_id, 'academic_year' => $session])->first();
		}
		$transportfees['qu1_date'] = $transport['fee_sub_q1'];
		$transportfees['qu2_date'] = $transport['fee_sub_q2'];
		$transportfees['qu3_date'] = $transport['fee_sub_q3'];
		$transportfees['qu4_date'] = $transport['fee_sub_q4'];

		echo json_encode($transportfees);
		die;
	}

	public function exportexcel()
	{
		$alldata = $this->Transportstudentlist->find('all')->contain(['Students' => ['Classes', 'Sections'], 'Locations'])->order(['Transportstudentlist.id' => 'DESC'])->toArray();
		$this->set('alldata', $alldata);
	}
}
