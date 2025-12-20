<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ExamResultTable extends Table
{

    public $name = 'ExamResult';

    public function initialize(array $config)
    {

        $this->table('exam_result');
        $this->primaryKey('id');

        $this->belongsTo('SubjectMarks', [
            'className' => 'SubjectMarks', // Replace 'SubjectMarks' with the actual model name
            'foreignKey' => 'subject_id'
        ]);

    }
}
