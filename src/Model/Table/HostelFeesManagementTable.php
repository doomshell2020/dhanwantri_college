<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class HostelFeesManagementTable extends Table
{

    public $name = 'HostelFeesManagement';

    public function initialize(array $config)
    {
        $this->table('hostel_fees_management');
        $this->primaryKey('id');

        // $this->belongsTo('Classes', [
        //     'foreignKey' => 'class_id',
        //     'joinType' => 'Left',
        // ]);
        $this->belongsTo('Students', [
            'foreignKey' => 'student_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Feesheads', [
            'foreignKey' => 'fees_head_id',
            'joinType' => 'INNER',
        ]);

        // $this->belongsTo('Subjects', [
        //     'foreignKey' => 'comp_sid',
        //     'joinType' => 'INNER',
        // ]);
        // $this->belongsTo('Boards', [
        //     'foreignKey' => 'board_id',
        //     'joinType' => 'INNER',
        // ]);
        // $this->hasOne('DropOutStudent', [
        //     'foreignKey' => 's_id',
        //     'joinType' => 'INNER',
        // ]);
        // $this->belongsTo('Locations', [
        //     'foreignKey' => 'location_id',
        //     'joinType' => 'Left',
        // ]);
    }
}
