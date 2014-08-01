<?php

class PenjualanBaru extends CFormModel {
	
	public $quantity;
	public $harga;
	public $inventory;
	
	public function __construct($inventory, $harga, $quantity) {
		$this->inventory = $inventory;
		$this->harga = $harga;
		$this->quantity = $quantity;
	}
	
}