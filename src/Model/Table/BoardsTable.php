<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class BoardsTable extends Table {

    public $name = 'Boards';
    
    public function initialize(array $config)
    {
			  $this->table('board');
              $this->primaryKey('id');
		
	}

}
