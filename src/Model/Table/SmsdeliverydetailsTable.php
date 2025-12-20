<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class SmsdeliverydetailsTable extends Table
	{
		public $name = 'Smsdeliverydetails';

		
		public function initialize(array $config)
		{
			$this->table('sms_deliveries_details');
        	$this->primaryKey('id');
	

 $this->belongsTo('Smsdelivery', [
          'className' => 'Smsdelivery',
             'foreignKey' => 'sms_deliv_id',
             'propertyName' => 'Smsdelivery',
              'joinType' => 'INNER',
           
        ]);
        
         $this->belongsTo('Smsmanager', [
          'className' => 'Smsmanager',
             'foreignKey' => 'sms_temp_id',
             'propertyName' => 'Smsmanager',
              'joinType' => 'INNER',
           
        ]);
        
           $this->belongsTo('Students', [
          'className' => 'Students',
             'foreignKey' => 'stud_id',
             'propertyName' => 'Students',
              'joinType' => 'INNER',
           
        ]);
         $this->belongsTo('Employees', [
          'className' => 'Employees',
             'foreignKey' => 'stud_id',
             'propertyName' => 'Employees',
              'joinType' => 'INNER',
           
        ]);
	}
	}

?>
