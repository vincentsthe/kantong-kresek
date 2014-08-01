<?php

class InvoicePenjualanPublisher {
	
	private $invoice;
	private $listBarang;
	
	public function __construct($location) {
		$this->invoice = new InvoicePenjualan;
		$this->invoice->location = $location;
		$this->listBarang = array();
	}
	
	public  function getInvoice() {
		return $this->invoice;
	}
	
	public function getListBarang() {
		return $this->listBarang;
	}
	
	public function fillContact($contactInfo) {
		$this->invoice->nama_pembeli = $contactInfo->nama_pembeli;
		$this->invoice->alamat_pembeli = $contactInfo->alamat_pembeli;
		$this->invoice->telpon_pembeli = $contactInfo->telpon_pembeli;
		$this->invoice->nama_terkirim = $contactInfo->nama_terkirim;
		$this->invoice->alamat_terkirim = $contactInfo->alamat_terkirim;
		$this->invoice->telpon_terkirim = $contactInfo->telpon_terkirim;
	}
	
	public function getContact() {
		$contact = new PenjualanContactForm;
		$contact->nama_pembeli = $this->invoice->nama_pembeli;
		$contact->alamat_pembeli = $this->invoice->alamat_pembeli;
		$contact->telpon_pembeli = $this->invoice->telpon_pembeli;
		$contact->nama_terkirim = $this->invoice->nama_terkirim;
		$contact->alamat_terkirim = $this->invoice->alamat_terkirim;
		$contact->telpon_terkirim = $this->invoice->telpon_terkirim;
		
		return $contact;
	}
	
	public function hasContact() {
		return ($this->invoice->nama_pembeli != null);
	}
	
	public function fillPembayaran($pembayaranInfo) {
		$this->invoice->biaya_pengiriman = $pembayaranInfo->biaya_pengiriman;
		$this->invoice->down_payment = $pembayaranInfo->down_payment;
		$this->invoice->jenis_pembayaran = $pembayaranInfo->jenis_pembayaran;
		$this->invoice->comment_external = $pembayaranInfo->comment_external;
		$this->invoice->comment_internal = $pembayaranInfo->comment_internal;
		
		if(($this->invoice->biaya_pengiriman == null) || (ctype_space($this->invoice->biaya_pengiriman))) {
			$this->invoice->biaya_pengiriman = 0;
		}
	}
	
	public function getPembayaran() {
		$pembayaran = new PembayaranPenjualanForm;
		$pembayaran->biaya_pengiriman = $this->invoice->biaya_pengiriman;
		$pembayaran->down_payment = $this->invoice->down_payment;
		$pembayaran->jenis_pembayaran = $this->invoice->jenis_pembayaran;
		$pembayaran->comment_external = $this->invoice->comment_external;
		$pembayaran->comment_internal = $this->invoice->comment_internal;
		
		return $pembayaran;
	}
	
	public function hasPembayaran() {
		return (($this->invoice->down_payment != null) && ($this->invoice->jenis_pembayaran != null));
	}
	
	/**
	 * @param unknown $barang
	 * 
	 * If inventory already exist on the list, the old inventory will be overwriten
	 */
	public function addBarang($barang) {
		$index = -1;
		$i = 0;
		foreach($this->listBarang as $oldBarang) {
			if($oldBarang->inventory->id == $barang->inventory->id) {
				$index = $i;
			}
			$i++;
		}
		if($index != -1) {
			unset($this->listBarang[$index]);
			$this->listBarang = array_values($this->listBarang);
		}
		
		$this->listBarang[] = $barang;
	}
	
	public function removeBarangById($id) {
		$index = -1;
		$i = 0;
		foreach($this->listBarang as $barang) {
			if($barang->inventory->id == $id) {
				$index = $i;
			}
			$i++;
		}
		if($index != -1) {
			unset($this->listBarang[$index]);
			$this->listBarang = array_values($this->listBarang);
		}
	}
	
	public function publishInvoice() {
		if($this->invoicePublished()) {
			throw new Exception("Invoice already published");
		}
		
		if($this->invoice->save()) {
			foreach($this->listBarang as $barang) {
				Penjualan::createRecord($barang->inventory, $barang->quantity, $barang->harga, $this->invoice->id);
				$barang->inventory->subtract($barang->quantity);
			}
			Tunggakan::createFromInvoice($this->invoice);
		} else {
			throw new Exception("Invoice can't be saved");
		}
	}
	
	private function invoicePublished() {
		if($this->invoice->id != null) {
			return true;
		} else {
			return false;
		}
	}
}