<?php

class Laporan {
	
	private $nama;
	
	public function __construct($nama) {
		$this->nama = $nama;
	}
	
	public function getLocationSum() {
		$listInventory = Inventory::getInventoryByName($this->nama);
		$return = array();
		$return['Belum di-assign'] = 0;
		
		$len = count($listInventory);
		for($i=0 ; $i<$len ; $i++) {
			if($listInventory[$i]->lokasi0 != null) {
				if(array_key_exists($listInventory[$i]->lokasi0->nama, $return)) {
					$return[$listInventory[$i]->lokasi0->nama] += $listInventory[$i]->jumlah_barang;
				} else {
					$return[$listInventory[$i]->lokasi0->nama] = $listInventory[$i]->jumlah_barang;
				}
			} else {
				$return['Belum di-assign'] += $listInventory[$i]->jumlah_barang;
			}
		}
		
		return $return;
	}
	
	public function getReport() {
		
		$listData = array();
		$listPembelian = Pembelian::getPembelianByName($this->nama, true);
		$listPenjualan = Penjualan::getPenjualanByName($this->nama, true);
		
		foreach ($listPembelian as $pembelian) {
			$listData[] = new Data($pembelian->quantity, $pembelian->invoice->waktu_penerbitan);
		}
		foreach ($listPenjualan as $penjualan) {
			$listData[] = new Data(-$penjualan->quantity, $penjualan->invoice->waktu_penerbitan);
		}
		
		usort($listData, function($n1, $n2) {
			return ($n1->getTime() - $n2->getTime());
		});
		
		$balance = 0;
		$listEntry = array();
		foreach($listData as $data) {
			$balance += $data->getChange();
			if($data->getChange() > 0) {
				$entry = new Entri($data->getChange(), 0, $balance, Utilities::timestampToFormattedDate($data->getTime(), "d-m-Y"));
			} else {
				$entry = new Entri(0, -$data->getChange(), $balance, Utilities::timestampToFormattedDate($data->getTime(), "d-m-Y"));
			}
			$listEntry[] = $entry;
		}
		
		return $listEntry;
	}
	
}