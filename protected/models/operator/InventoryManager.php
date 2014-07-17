<?php

class InventoryManager {
	
	private $inventory;
	
	public function __construct($inventory) {
		$this->inventory = $inventory;
	}
	
	public function setHarga($spekHarga) {
		$this->inventory->harga = $spekHarga->harga;
		$this->inventory->harga_minimum = $spekHarga->harga_minimum;
		$this->inventory->harga_minimum_khusus = $spekHarga->harga_minimum_khusus;
		
		$this->inventory->save();
	}
	
	public function pindah($destination, $count) {
		$this->inventory->subtract($count);
		
		$destinationInventory = $this->inventory->searchInLocation($destination);
		$destinationInventory->add($count);
		
		return new InventoryManager($destinationInventory);
	}
	
}