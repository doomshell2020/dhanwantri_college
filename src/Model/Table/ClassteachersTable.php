<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ClassteachersTable extends Table {

    public $name = 'Classteachers';
    
    public function initialize(array $config)
    {
			  $this->table('classteachers');
        $this->primaryKey('id');

        $this->belongsTo('Classes', [
           'foreignKey' => 'class_id',
         'joinType' => 'INNER',
           
        ]);

         $this->belongsTo('Sections', [
           'foreignKey' => 'section_id',
         'joinType' => 'INNER',
           
        ]);

        $this->belongsTo('Employees', [
           'className' => 'Employees',
           'foreignKey' => 'teach_id',
           
            'joinType' => 'INNER',
           
        ]); 
			
	

  
	 
	}

}
?>
