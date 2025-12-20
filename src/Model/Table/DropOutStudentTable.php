<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class DropOutStudentTable extends Table
{

    public $name = 'DropOutStudent';


    public function initialize(array $config)
    {
        $this->table('drop_out_students');

        $this->primaryKey('id');

        $this->belongsTo('Classes', [
            'foreignKey' => 'class_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Classes', [
            'foreignKey' => 'class_id',
            'joinType' => 'INNER',
            'className' => 'Classes'
        ]);



        $this->belongsTo('Sections', [
            'foreignKey' => 'section_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Subjects', [
            'foreignKey' => 'comp_sid',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Boards', [
            'foreignKey' => 'board_id',
            'joinType' => 'INNER',
        ]);
    }

    /* public function validationDefault(Validator $validator)
    {
       $validator = new Validator();
       $validator
	    //->requirePresence('fname')
	->notEmpty('fname', 'Please fill First Name')
	 ->allowEmpty('fname', 'edit')
	 
   	 //   ->requirePresence('lname')
	->notEmpty('lname', 'Please fill Last Name')
	   //->requirePresence('dob')
	->notEmpty('dob', 'Please fill Date')
	
	
	  // ->requirePresence('nationality')
	->notEmpty('nationality', 'Please Select Nationality')
	   //->requirePresence('nationality')
	->notEmpty('nationality', 'Please Select Nationality')
	 ->allowEmpty('nationality', 'edit')
	 
	->notEmpty('admissionyear', 'Please Select Admissionyear')
	 ->allowEmpty('admissionyear', 'edit')
		 
	->notEmpty('acedmicyear', 'Please Select Acedmicyear')
		 ->allowEmpty('acedmicyear', 'edit')
	
	 
	->notEmpty('class_id', 'Please Select Acedmicyear')
		 ->allowEmpty('class_id', 'edit')
	
	->notEmpty('section_id', 'Please Select Acedmicyear')
		 ->allowEmpty('section_id', 'edit')
	//->requirePresence('mobile')
	->notEmpty('mobile', 'Please fill Mobile')
	 ->add('mobile','numeric',array('rule' => 'numeric' ,'message'=> 'Please provide a valid format'))
		->add('mobile', [
        'minLength' => [
            'rule' => ['minLength', 10],
            'last' => true,
            'message' => 'Mobile Number minimum ten digit length.'
        ],
        'maxLength' => [
            'rule' => ['maxLength', 10],
            'message' => 'Mobile Number cannot be too long.'
        ]
    ])
    
    
  
   /*  ->requirePresence('adaharnumber')
	->notEmpty('adaharnumber', 'Please fill Aadhar Number')
		->add('adaharnumber', [
        'minLength' => [
            'rule' => ['minLength', 12],
            'last' => true,
            'message' => 'Aadhar Number minimum 12 digit length.'
        ],
        'maxLength' => [
            'rule' => ['maxLength', 12],
            'message' => 'Aadhar Number cannot be too long.'
        ]
    ])
	  
	  
	  
	 ->add('username', 'validFormat', [
    'rule' => ['email', true],
    'message' => 'Email must be valid.'
]);

        return $validator;
    }  */
}
