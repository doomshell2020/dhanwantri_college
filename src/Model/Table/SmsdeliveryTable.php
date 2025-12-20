<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class SmsdeliveryTable extends Table
	{
		public $name = 'Smsdelivery';

		
		public function initialize(array $config)
		{
			$this->table('sms_deliveries');
        	$this->primaryKey('id');
		}



	}

?>
