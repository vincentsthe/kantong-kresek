<?php

class InvoicePembelianPublisher {
	
	private $invoice;
	private $listBarang;
	
	public function __construct() {
		$this->invoice = new InvoicePembelian;
		$this->listBarang = array();
	}
	
	public function getInvoice() {
		return $this->invoice;
	}
	
	public function setInvoice($invoice) {
		$this->invoice = $invoice;
	}
	
	public function getBarang() {
		return $this->listBarang;
	}
	
	public function addBarang($barang) {
		$this->listBarang[] = $barang;
	}
	
	public function removeBarang($index) {
		unset($this->listBarang[$index]);
		$this->listBarang = array_values($this->listBarang);
	}
	
	public function hasInfo() {
		if($this->invoice->nama_supplier == null) {
			return false;
		} else {
			return true;
		}
	}
	
	public function publish() {
		$this->invoice->save();
		foreach($this->listBarang as $barang) {
			$barang->invoice_id = $this->invoice->id;
			$barang->save();
			
			Inventory::createInventoryFromPembelian($barang, $this->invoice->id);
		}
	}
	
}