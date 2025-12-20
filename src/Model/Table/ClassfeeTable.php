<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class ClassfeeTable extends Table
{

  public $name = 'Classfee';

  public function initialize(array $config)
  {

    $this->table('class_fee_allocations');
    $this->primaryKey('id');

    $this->belongsTo('Feesheads', [
      'foreignKey' => 'fee_h_id',
      'joinType' => 'INNER',
    ]);

    $this->belongsTo('Classes', [
      'foreignKey' => 'class_id',
      'joinType' => 'INNER',
    ]);
  }



  public function validationDefault(Validator $validator)
  {
    $validator = new Validator();

    $validator
      //  ->requirePresence('fname')
      ->notEmpty('fee_h_id', 'Please Fill First Name')

      //  ->requirePresence('lname')
      ->notEmpty('class_id', 'Please Fill Last Name')

      // ->requirePresence('dob')
      ->notEmpty('academic_year', 'Please Fill Academic Year');


    return $validator;
  }
}
