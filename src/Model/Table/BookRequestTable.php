<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class BookRequestTable extends Table
{

    public function initialize(array $config)
    {
        $this->belongsTo('Students', [
            'foreignKey' => 'stud_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Book', [
            'foreignKey' => 'book_id',
            'joinType' => 'INNER',
        ]);
    }
    public $name = 'book_request';

}
