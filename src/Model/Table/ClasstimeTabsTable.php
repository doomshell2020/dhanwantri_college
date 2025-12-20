<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ClasstimeTabsTable extends Table {

    public $name = 'ClasstimeTabs';
			
			  public function initialize(array $config)
    {
       
       
       
			  $this->table('classtime_tabs');
        
        
        		
        $this->primaryKey('id');
        
			 $this->belongsTo('Classections', [
           'foreignKey' => 'class_id',
         'joinType' => 'INNER',
           
        ]);

       $this->belongsTo('Classes', [
           'foreignKey' => 'class_id',
         'joinType' => 'INNER',
           
        ]);

        	 $this->belongsTo('Timetables', [
           'className' => 'Timetables',
           'foreignKey' => 'tt_id',
           'propertyName' => 'Timetables',
            'joinType' => 'INNER',
           
        ]);
        	
         $this->belongsTo('Subjects', [
           'className' => 'Subjects',
           'foreignKey' => 'subject_id',
           'propertyName' => 'Subjects',
            'joinType' => 'INNER',
           
        ]);
           $this->belongsTo('Employees', [
           'className' => 'Employees',
           'foreignKey' => 'employee_id',
           'propertyName' => 'Employees',
            'joinType' => 'INNER',
           
        ]); 
	}
	    
	 public function validationDefault(Validator $validator)
    {
       $validator = new Validator();
       $validator
	    ->requirePresence('class_id','create')
	->notEmpty('class_id', 'Please Select class id')
   	    ->requirePresence('subject_id','create')
	->notEmpty('subject_id', 'Please Select Subjects')
	  ->requirePresence('tt_id','create')
	->notEmpty('tt_id', 'Please Select Employee')
	   ->requirePresence('employee_id','create')
	->notEmpty('employee_id', 'Please Select Employees');
	
	
	 

        return $validator;
    }  


}
?>
