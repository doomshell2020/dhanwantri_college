<?php

	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	/**
	* Creating Model for Library cup board shelf module
	*/
	class CupBoardShelfTable extends Table
	{
		public $name = 'CupBoardShelf';

		//---------------------------------------------------------
		public function initialize(array $config)
		{
			$this->table('library_cup_board_shelves');
        	$this->primaryKey('id');

        	$this->belongsTo(
        		'CupBoard',
        		['foreignKey' => 'cup_board_id', 'joinType' => 'INNER']
        	);
		}

		//---------------------------------------------------------
		public function validationDefault(Validator $validator)
		{
			$validator = new Validator();

			$validator
				->requirePresence('name')
				->notEmpty('name', 'Please enter a valid name.')
				
				->requirePresence('cup_board_id')
				->notEmpty('cup_board_id', 'Please select a Cup Board.');

			return $validator;
		}
	}

?>