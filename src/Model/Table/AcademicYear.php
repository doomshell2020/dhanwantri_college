<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class AcademicYearTable extends Table
{

    public $name = 'AcademicYear';

    public function initialize(array $config)
    {

        $this->table('academic_year');
        $this->primaryKey('id');
    }
}
