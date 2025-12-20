<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class StudentexamresultTable extends Table
{

    public $name = 'Studentexamresult';

    public function initialize(array $config)
    {



        $this->table('studentexamresult');
        $this->primaryKey('id');
        $this->belongsTo('Students', [
            'foreignKey' => 'stud_id',
            'joinType' => 'INNER',
        ]);
        // $this->belongsTo('Students_previous', [
        //     'foreignKey' => 'stud_id',
        //     'joinType' => 'INNER',
        // ]);
        $this->belongsTo('DropOutStudent', [

            'foreignKey' => false,
            'conditions' => array(
                'Studentexamresult.stud_id = DropOutStudent.s_id'
            ),
            'propertyName' => 'student'

        ]);



        $this->belongsTo('Studentshistory', [

            'foreignKey' => false,
            'conditions' => array(
                'Studentexamresult.stud_id = Studentshistory.stud_id'
            ),
            'propertyName' => 'student'

        ]);
        $this->belongsTo('ExamSubjects', [
            'foreignKey' => 'subject_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Exams', [
            'foreignKey' => 'exam_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Classes', [
            'foreignKey' => 'class_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Sections', [
            'foreignKey' => 'sect_id',
            'joinType' => 'INNER',
        ]);
    }



    public function validationDefault(Validator $validator)
    {
        $validator = new Validator();
    }
}
