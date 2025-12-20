<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class ApplicantTable extends Table
{

    public $name = 'Applicant';

    public function initialize(array $config)
    {
        $this->table('applicants');
        $this->primaryKey('id');
        $this->belongsTo('Enquires', [
            'foreignKey' => false,
            'conditions' => array(
                'Applicant.sno = Enquires.formno'
            )
        ]);
    }
}
?>
