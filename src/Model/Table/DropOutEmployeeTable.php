<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class DropOutEmployeeTable extends Table
{

    public $name = 'DropOutEmployee';

    public function initialize(array $config)
    {
        $this->table('drop_out_employees');

        $this->primaryKey('id');
        $this->belongsTo('Departments', [
            'foreignKey' => 'department_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Designations', [
            'foreignKey' => 'designation_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany(
            'Employeeattendance',
            ['foreignKey' => 'employee_id', 'joinType' => 'LEFT']
        );
        $this->hasone(
            'Users',
            ['foreignKey' => 'tech_id', 'joinType' => 'INNER']
        );
        $this->hasone(
            'Employeesalary',
            ['foreignKey' => 'employee_id', 'joinType' => 'INNER']
        );

    }

}