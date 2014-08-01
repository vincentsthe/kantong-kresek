<?php

class Entri {
	
	private $debet;
	private $kredit;
	private $saldo;
	private $date;
	
	public function __construct($debet, $kredit, $saldo, $date) {
		$this->debet = $debet;
		$this->kredit = $kredit;
		$this->saldo = $saldo;
		$this->date = $date;
	}
	
	public function getDebet() {
		return $this->debet;
	}
	
	public function getKredit() {
		return $this->kredit;
	}
	
	public function getSaldo() {
		return $this->saldo;
	}
	
	public function getDate() {
		return $this->date;
	}
	
}