<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class ExpenseCategoryTable extends Table
{

    public $name = 'ExpenseCategory';

    public function initialize(array $config)
    {

        $this->table('expenses_category');
        $this->primaryKey('id');


    }


}
?>