<?php

	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	/**
	* Creating Model for Library cup board shelf module
	*/
	class IssueBookTable extends Table
	{
		public $name = 'IssueBook';

		//---------------------------------------------------------
		public function initialize(array $config)
		{
			$this->table('library_issue_books');
        	$this->primaryKey('id');

        	$this->belongsTo(
        		'BookCopyDetail',
        		['foreignKey' => 'asn_no2', 'joinType' => 'INNER']
        	);
        	
        	
		}

		//---------------------------------------------------------
		public function validationDefault(Validator $validator)
		{
			$validator = new Validator();

			$validator
				->requirePresence('holder_type_id')
				->notEmpty('holder_type_id', 'Please select a Holder type.')

				->requirePresence('holder_name')
				->notEmpty('holder_name', 'Please enter a valid Holder name.')

				->requirePresence('asn_no')
				->notEmpty('asn_no', 'Please enter ASN No.');

				// ->requirePresence('issue_date')
				// ->notEmpty('issue_date', 'Please select issue date.')

				// ->requirePresence('due_date')
				// ->notEmpty('due_date', 'Please select due date.');

			return $validator;
		}
	}

?>
