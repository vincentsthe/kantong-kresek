<?php

class Data {
	
	private $change;
	private $time;
	
	public function __construct($change, $time) {
		$this->change = $change;
		$this->time = $time;
	}
	
	public function getTime() {
		return $this->time;
	}
	
	public function getChange() {
		return $this->change;
	}
}