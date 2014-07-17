<?php

class InvoicePenjualanPublisher {
	
	private $invoice;
	
	public function __construct() {
		$this->invoice = new InvoicePenjualan;
	}
	
}