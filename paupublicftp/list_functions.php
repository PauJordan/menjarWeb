<?php
include_once './connect.php';


class IngredientList {
	private $list = array();

	function addToTotal($ingredients, $times){
		for ($i=0; $i < count($ingredients); $i++) { 
			$qty = floatval($ingredients[$i][1])*$times;
			$this->addIngredient($ingredients[$i][0], $qty);
		}
	}
	function addIngredient($id, $qty){
		if(array_key_exists($id, $this->list)){
			$this->list[$id] += $qty;
		} else {
			$this->list[$id] = $qty;
		}
	}
	function getList(){
		return $this->list;
	}
}
?>