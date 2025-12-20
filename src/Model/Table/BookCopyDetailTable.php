<?php

	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	/**
	* Creating Model for Library cup board shelf module
	*/
	class BookCopyDetailTable extends Table
	{
		public $name = 'BookCopyDetail';

		//---------------------------------------------------------
		public function initialize(array $config)
		{
			$this->table('library_book_copy_details');
        	$this->primaryKey('id');
        	
        	$this->belongsTo(
        		'Book',
        		['foreignKey' => 'book_id', 'joinType' => 'INNER']
        	);
		}

		//---------------------------------------------------------
		public function validationDefault(Validator $validator)
		{
			$validator = new Validator();

			$validator
				->requirePresence('book_id')
				->notEmpty('book_id', 'Please enter book_id.')

				->requirePresence('status')
				->notEmpty('status', 'Please enter book status.');

			return $validator;
		}
	}

?>
