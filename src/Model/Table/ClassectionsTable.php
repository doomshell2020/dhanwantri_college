<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ClassectionsTable extends Table {

    public $name = 'Classections';
	
	
 public function initialize(array $config)
    {
       
       
       
			  $this->table('classections');
			
			
        $this->primaryKey('id');
			 $this->belongsTo('Classes', [
           'className' => 'Classes',
           'foreignKey' => 'class_id',
           'propertyName' => 'Classes',
            'joinType' => 'INNER',
           
        ]);
        
        $this->belongsTo('Sections', [
            'className' => 'Sections',
             'foreignKey' => 'section_id',
             'propertyName' => 'Sections',
              'joinType' => 'INNER',
           
        ]);
          $this->belongsTo('Employees', [
          'className' => 'Employees',
             'foreignKey' => 'teacher_id',
             'propertyName' => 'Employees',
              'joinType' => 'INNER',
           
        ]);
        
        
        
	}
    public function validationDefault(Validator $validator)
    {
    $validator = new Validator();
				
	$validator
	    ->requirePresence('class_id')
	    ->notEmpty('class_id', 'Please Add Class')
	   
	    ->requirePresence('section_id')
	     ->notEmpty('section_id', 'Please Add Section')
	     ->requirePresence('teacher_id')
	     ->notEmpty('teacher_id', 'Please Add Teacher')
	     ->requirePresence('capacity')
	     ->notEmpty('capacity', 'Please Add capacity');

	    
		
	    
  
	return $validator;
	 
	}

}
?>
