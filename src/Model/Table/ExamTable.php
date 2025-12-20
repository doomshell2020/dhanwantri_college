<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ExamTable extends Table
{

    public $name = 'Exam';

    public function initialize(array $config)
    {

        $this->table('exams');
        $this->primaryKey('id');

    }

}