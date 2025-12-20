<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class SmsTable extends Table {

    public $name = 'Sms';
	
	public function initialize(array $config)
	{
		$this->table('sms_config');
		$this->primaryKey('id');
	}

}
?>
