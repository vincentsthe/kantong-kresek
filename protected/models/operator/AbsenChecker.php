<?php

class AbsenChecker {
	
	private $user;
	private $listTodayAbsen;
	
	public function __construct($user) {
		$this->user = $user;
		$this->listTodayAbsen = Absen::getAllTodayAbsenByUser($this->user);
	}
	
	private function getAbsenPulang() {
		if(count($this->listTodayAbsen) == 2) {
			return $this->listTodayAbsen[1];
		} else {
			return null;
		}
	}
	
	private function getAbsenDatang() {
		if(count($this->listTodayAbsen) >= 1) {
			return $this->listTodayAbsen[0];
		} else {
			return null;
		}
	}
	
	private function setAbsenPulang($absen) {
		$this->listTodayAbsen[1] = $absen;
	}
	
	private function setAbsenDatang($absen) {
		$this->listTodayAbsen[0] = $absen;
	}
	
	public function doAbsen() {
		if($this->haveAbsenPulang()) {
			$this->updatePulang();
		} else if($this->haveAbsenDatang()) {
			$this->createPulang();
		} else {
			$this->createDatang();
		}
	}
	
	private function haveAbsenPulang() {
		return ($this->getAbsenPulang() != null);
	}
	
	private function haveAbsenDatang() {
		return ($this->getAbsenDatang() != null);
	}
	
	private function updatePulang() {
		$this->getAbsenPulang()->updateTimestamp(time());
	}
	
	private function createPulang() {
		$absen = Absen::createAbsen($this->user->id, time(), Absen::$TYPE_PULANG);
		$this->setAbsenPulang($absen);
	}
	
	private function createDatang() {
		$absen = Absen::createAbsen($this->user->id, time(), Absen::$TYPE_DATANG);
		$this->setAbsenDatang($absen);
	}
	
}