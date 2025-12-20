<?php

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
* Creating Model for Library cup board module
*/
class StudentFinalResultTable extends Table
{
	public $name = 'StudentFinalResult';
	public function initialize(array $config)
	{
		$this->table('student_final_result');
		$this->primaryKey('id');

	}

	
}
