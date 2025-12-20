<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class ExpenseDetailTable extends Table
{

    public $name = 'ExpenseDetail';

    public function initialize(array $config)
    {

        $this->table('exp_detail');
        $this->primaryKey('id');


    }


}
?>