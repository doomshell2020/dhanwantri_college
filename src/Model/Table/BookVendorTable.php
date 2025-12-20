<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
* Creating Model for Library cup board module
*/
class BookVendorTable extends Table
{
	public $name = 'BookVendor';

	//---------------------------------------------------------
	public function initialize(array $config)
	{
		$this->table('library_book_vendors');
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