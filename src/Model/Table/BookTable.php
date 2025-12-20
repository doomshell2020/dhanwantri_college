<?php

	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	/**
	* Creating Model for Library cup board shelf module
	*/
	class BookTable extends Table
	{
		public $name = 'Book';

		//---------------------------------------------------------
		public function initialize(array $config)
		{
			$this->table('library_books');
        	$this->primaryKey('id');

       	$this->belongsTo(
        		'BookCategory',
        		['foreignKey' => 'book_category_id', 'joinType' => 'INNER']
        	);
        	$this->belongsTo(
        		'PeriodicalMaster',
        		['foreignKey' => 'periodic_category_id', 'joinType' => 'INNER']
        	);
        	$this->hasMany(
        		'BookCopyDetail',
        		['foreignKey' => 'book_id', 'joinType' => 'INNER']
        	);

        	$this->belongsTo(
        		'CupBoard',
        		['foreignKey' => 'cup_board_id', 'joinType' => 'INNER']
        	); 

        	$this->belongsTo(
        		'CupBoardShelf',
        		['foreignKey' => 'cup_board_shelf_id', 'joinType' => 'INNER']
        	);
         
        	$this->belongsTo(
        		'BookVendor',
        		['foreignKey' => 'book_vendor_id', 'joinType' => 'INNER']
        	);
		}

		//---------------------------------------------------------
		public function validationDefault(Validator $validator)
		{
			$validator = new Validator();

			$validator
				->requirePresence('name')
				->notEmpty('name', 'Please enter a valid name.')
				
				->requirePresence('book_type')
				->notEmpty('book_type', 'Please choose a Book type.')

				->requirePresence('book_category_id')
				->notEmpty('book_category_id', 'Please select a Book category.')

				->requirePresence('copy')
				->notEmpty('copy', 'Please enter no. of copy of book.');

			return $validator;
		}
	}

?>
