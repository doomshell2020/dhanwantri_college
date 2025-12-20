<?php
namespace App\Model\Table;

use Cake\ORM\Table;

use Cake\Validation\Validator;


class ExpenseTable extends Table
{

    public $name = 'Expense';

    public function initialize(array $config)
    {

        $this->table('expenses');
        $this->primaryKey('id');


    }


}
?>