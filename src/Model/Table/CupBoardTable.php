<?php

	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	/**
	* Creating Model for Library cup board module
	*/
	class CupBoardTable extends Table
	{
		public $name = 'CupBoard';

		//---------------------------------------------------------
		public function initialize(array $config)
		{
			$this->table('library_cup_boards');
        	$this->primaryKey('id');
		}

		//---------------------------------------------------------
		public function validationDefault(Validator $validator)
		{
			$validator = new Validator();

			$validator
				->requirePresence('name')
				->notEmpty('name', 'Please enter a valid name.');

			return $validator;
		}
	}

?>