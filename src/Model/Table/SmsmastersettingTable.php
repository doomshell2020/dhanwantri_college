<?php

	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class SmsmastersettingTable extends Table
	{
		public $name = 'Smsmastersetting';

		
		public function initialize(array $config)
		{
			$this->table('sms_master');
        	$this->primaryKey('id');

			$this->belongsTo('Schools', [
				'foreignKey' => 'client_id',
				'joinType' => 'left',
	
			]);


		}



	}

?>
