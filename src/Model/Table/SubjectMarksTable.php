<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class SubjectMarksTable extends Table
{

    public $name = 'SubjectMarks';

    public function initialize(array $config)
    {

        $this->table('subject_marks');
        $this->primaryKey('id');

    }

}