<?php

class Stok {
	
	private $nama;
	private $jumlah;
	private static $pageSize = 50;
	
	public function __construct($inventory) {
		$this->nama = $inventory->nama_barang;
		$this->jumlah = 0;
	}
	
	public function getNama() {
		return $this->nama;
	}
	
	public function getJumlah() {
		return $this->jumlah;
	}
	
	public static function getStok($location=0, $like="", $page) {
		$listStok = self::getStokArray($location, $like);
		$size = count($listStok);
		
		$return = array();
		for($i=self::$pageSize*$page ; $i<min(self::$pageSize*($page+1), $size) ; $i++) {
			$return[] = $listStok[$i];
		}
		
		return $return;
	}
	
	public static function getPageCount($location=0, $like="") {
		$stokArray = self::getStokArray($location, $like);
		return floor((count($stokArray)+self::$pageSize-1)/self::$pageSize);
	}
	
	private static function getStokArray($location=0, $like="") {
		$listInventory = Inventory::getInventory($location, $like);
		$listStok = array();
		$size = 0;
		
		$len = count($listInventory);
		for($i=0 ; $i<$len ; $i++) {
			if(($i==0) || ($listInventory[$i]->nama_barang != $listInventory[$i-1]->nama_barang)) {
				$listStok[$size] = new Stok($listInventory[$i]);
				$listStok[$size]->add($listInventory[$i]->jumlah_barang);
				$size++;
			} else {
				$listStok[$size-1]->add($listInventory[$i]->jumlah_barang);
			}
		}
		
		return $listStok;
	}
	
	private function add($count) {
		$this->jumlah += $count;
	}
	
}