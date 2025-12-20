<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class FaqTable extends Table {

    public $name = 'faq';

    public function initialize(array $config)
    {
       
	 $this->table('faq');
        $this->primaryKey('id');
			 $this->belongsTo('FaqCategory', [
            'foreignKey' => 'category_id',
            'joinType' => 'LEFT',
        ]);
            	

}
		

}
?>
