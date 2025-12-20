<?php

namespace App\Controller;

use Cake\Core\Configure;

use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Cake\View\Helper;
use PHPMailer\PHPMailer\PHPMailer;

include(ROOT . DS . "vendor" . DS  . "PHPMailer/" . DS . "PHPMailerAutoload.php");

class HomesController extends AppController
{



	public function beforeFilter(Event $event)
	{
		$this->loadModel('Contacts');
		parent::beforeFilter($event);
		$this->loadComponent('Cookie');
		$this->loadComponent('Email');
		$this->Auth->allow(['index', 'add', 'findsections', 'findclass', 'findhouse', 'addsubscribe', 'transferCertificate', 'contactservice', 'contact', 'privacy', 'test', 'aboutus', 'pricing', 'whychoose', 'partner', 'benefits', 'services', 'datasecurity', 'howitwork', 'faq', 'contactus']);
	}

	public function transferCertificate($year)
	{
		$this->autoRender = false;
		$response = array();

		$conn = ConnectionManager::get('default');
		$response["output"] = [];
		$sintall = "Select * FROM `kidsclub`.drop_out_students s INNER JOIN `kidsclub`.classes c ON c.id=s.class_id  WHERE s.acedmicyear='" . $year . "' and s.status_tc='Y' Order by c.sort,s.fname ASC ";
		$rinstall = $conn->execute($sintall)->fetchAll('assoc');


		if (!empty($rinstall)) {
			foreach ($rinstall as $krt => $student) {

				$output['dwn_id'] = $student['s_id'];
				$output['name'] = $student['fname'] . ' ' . $student['middlename'] . ' ' . $student['lname'];
				$output['fathername'] = $student['fathername'];
				$output['mothername'] = $student['mothername'];
				$output['dob'] = $student['dob'];
				$output['enroll'] = $student['enroll'];
				$output['sms_mobile'] = $student['sms_mobile'];
				$output['category'] = $student['category'];

				$section_id = $this->findsections($student['section_id']);
				$class_id = $this->findclass($student['class_id']);
				$house_id = $this->findhouse($student['house_id']);
				$output["class"] = $class_id['title'];
				$output["section"] = $section_id['title'];
				$output["house"] = $house_id['name'];
				$output["admissionyear"] = $student['admissionyear'];
				$output["acedmicyear"] = $student['acedmicyear'];
				$output["board"] = "CBSE";


				array_push($response["output"], $output);
			}
		} else {
			$response['message'] = "Invalid Parameters";
		}


		$this->response->type('application/json');
		$this->response->body(json_encode($response));
		return $this->response;
	}

	public function findsections($id)
	{

		$conn = ConnectionManager::get('default');
		$sintall = "Select * FROM `kidsclub`.sections WHERE id='" . $id . "'";
		return	$rinstall = $conn->execute($sintall)->fetch('assoc');
	}

	public function findhouse($id)
	{
		$conn = ConnectionManager::get('default');
		$sintall = "Select * FROM `kidsclub`.houses WHERE id='" . $id . "'";
		return	$rinstall = $conn->execute($sintall)->fetch('assoc');
	}
	public function findclass($id)
	{
		$conn = ConnectionManager::get('default');
		$sintall = "Select * FROM `kidsclub`.classes WHERE id='" . $id . "'";
		return	$rinstall = $conn->execute($sintall)->fetch('assoc');
	}




	public function contact()
	{

		$this->viewBuilder()->layout('front');
		$this->loadModel('Enquiry');

		//pr($this->request->data); die;

		$name = $this->request->data['name'];
		$school = $this->request->data['school_or_org'] = $this->request->data['school'];
		$address = $this->request->data['address'];
		$phone = $this->request->data['mobile'] = $this->request->data['phone'];
		$email = $this->request->data['email'];
		$message = $this->request->data['message'];
		// if (isset($this->request->data['g-recaptcha-response'])) {
		// 	$captcha = $this->request->data['g-recaptcha-response'];
		// }

		// if (!$captcha) {
		// 	//echo '<h2>Please check the the captcha form.</h2>';
		// 	$this->Flash->error(__("Please check the the captcha form."));

		// 	return $this->redirect(['controller'=>'homes', 'action' => 'index']);
		// 	die;
		// }

		// $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdItuwUAAAAAFGD_Z4vX-i5LhNddHqd3GZm-hgA&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']), true);
		//pr($response); die;
		// if ($response['success'] == false) {
		// 	$this->Flash->error(__("Wrong Captcha."));
		// 	return $this->redirect(['controller' => 'homes', 'action' => 'index']);

		// } else {
		//add data
		$newpack = $this->Enquiry->newEntity();
		if ($this->request->is(['post', 'put'])) {
			//pr($this->request->data); die;
			$savepack = $this->Enquiry->patchEntity($newpack, $this->request->data);
			$results = $this->Enquiry->save($savepack);
		}

		$to = "contact@doomshell.com";

		$from = $email;
		//echo $from; die;
		$subject = "..:: iDs Prime ::..  Contact";

		$formats = '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<title>Mail</title>
			</head>
			<body style="margin:0px; padding:0px; font-family:Arial, Helvetica, sans-serif;background:#fff;"><div style="margin:auto;text-align:center;width:620px;border:5px solid #86a9e3;">

			<div style=" padding:10px;">  <div style="text-align:center;"> <img src="http://www.idsprime.com/images/logo.png" /><br>

			</div>
				<div style="text-align:left;">
					<h5 style="color: #86a9e3;font-size: 14px;padding: 0 0px; display:inline-block; margin-bottom:0; width:auto; font-family:Arial, Helvetica, sans-serif; ">Hi <strong style="color:#86a9e3;">Admin</strong>,</h5>


			<hr style="border:1px solid #eee">
					<h3 style="font-size:14px;color:#000;">Contact detail are :-</h3>
					<p><span style="width: 190px; display:inline-block; font-size:14px;">Name: </span><span style="color:#86a9e3; font-size:14px;">{name}</span></p>

					<p><span style="width: 190px; display:inline-block; font-size:14px;">Email: </span><span style="color:#86a9e3; font-size:14px;">{email}</span></p>
				
					<p><span style="width: 190px; display:inline-block; font-size:14px;">Phone: </span><span style="color:#86a9e3; font-size:14px;">{phone}</span></p>
					<p><span style="width: 190px; display:inline-block; font-size:14px;">School/Organization: </span><span style="color:#86a9e3; font-size:14px;">{school}</span></p>
						<p><span style="width: 190px; display:inline-block; font-size:14px;">Address: </span><span style="color:#86a9e3; font-size:14px;">{address}</span></p>
					<p><span style="width: 190px; display:inline-block; font-size:14px;">Message: </span><span style="color:#86a9e3; font-size:14px;">{comments}</span></p>

				<hr style="border:1px solid #eee">
				<p>Thank you for contacting us, we look forward to replying to your inquiry!&nbsp;</p>

			<p>All Our Love... Team </p>
			</hr>
				</div>
				</div>  <div style="color:#fff; background:#86a9e3; padding:5px;font-size: 14px;"> iDsPrime&reg;&nbsp; |&nbsp; <a href="http://www.idsprime.com/">idsprime.com</a> &nbsp;|&nbsp; Copyright 2021. All Rights Reserved.</div>
			</div>
			</body></html>';

		$message1 = str_replace(array('{names}', '{name}', '{email}', '{school}', '{phone}', '{address}', '{comments}'), array($name, $name, $email, $school, $phone, $address, $message), $formats);

		$message = stripslashes($message1);

		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type:text/html; charset=iso-8859-1\r\n";
		$headers .= 'From: iDsPrime Customer Service<' . $from . '>' . "\r\n";
		$cc = "sushil@doomshell.com";

		$m = $this->Email->send($to, $subject, $message, $cc);



		//echo $response; die;

		return $this->redirect(['action' => 'index/sendsuccess']);
		//send email

		exit;

		//	}
	}

	public function aboutus()
	{
		$this->viewBuilder()->layout('front');
	}
	public function pricing()
	{
		$this->viewBuilder()->layout('front');
	}
	public function privacy()
	{
		$this->viewBuilder()->layout('front');
	}
	public function index()
	{
		if ($this->request->params['pass'][0]) {
			$this->set('idspimrr', $this->request->params['pass'][0]);
		}
		$this->viewBuilder()->layout('front');
	}
	public function whychoose()
	{
		$this->viewBuilder()->layout('front');
	}
	public function partner()
	{
		$this->viewBuilder()->layout('front');
	}
	public function benefits()
	{
		$this->viewBuilder()->layout('front');
	}
	public function services()
	{
		$this->viewBuilder()->layout('front');
	}
	public function datasecurity()
	{
		$this->viewBuilder()->layout('front');
	}
	public function howitwork()
	{
		$this->viewBuilder()->layout('front');
	}
	// public function faq()
	// {
	// 	$this->viewBuilder()->layout('front');
	// }
	public function faq()
	{
		$this->viewBuilder()->layout('front');
		$id = $_GET['id'];


		$this->loadModel('Faq');
		$this->viewBuilder()->layout('front');
		$faq_data = $this->Faq->find('all')->where(['category_id' => $id])->toarray();

		$this->set(compact(['faq_data']));

		$this->loadModel('FaqCategory');
		$result = $this->FaqCategory->find('list', [
			'keyField' => 'id',
			'valueField' => 'category_name'
		])->where(['FaqCategory.status' => 'Y'])->toArray();
		$this->set(compact(['result']));
	}




	public function contactus()
	{
		$this->viewBuilder()->layout('front');
	}
}
