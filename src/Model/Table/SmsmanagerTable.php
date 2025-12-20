<?php

	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class SmsmanagerTable extends Table
	{
		public $name = 'Smsmanager';

		
		public function initialize(array $config)
		{
			$this->table('sms_templates');
        	$this->primaryKey('id');
		}



	}

?>
