<?php

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
* Creating Model for Library cup board module
*/
class StockregisterTable extends Table
{
	public $name = 'Stockregister';
	public function initialize(array $config)
	{
		$this->table('st_stock_register');
		$this->primaryKey('id');

		$this->belongsTo('Additem', [
			'foreignKey' => 'item_id',
			'joinType' => 'INNER',
		]);

		$this->belongsTo('Goodsreceived', [
			'foreignKey' => 'goods_id',
			'joinType' => 'INNER',
		]);
		$this->belongsTo('Purchaseorder', [
			'foreignKey' => 'purchaseorder_id',
			'joinType' => 'INNER',
		]);
		
	}
}

?>
