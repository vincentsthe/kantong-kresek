<?php
class ReportForm extends CFormModel {
	
	/**
	 * 0 means select all location
	 */
	public $cabang;
	public $supplier;
	public $startTime;
	public $endTime;
	
	public function __construct() {
		$this->cabang = 0;
		$this->startTime = Utilities::timestampToFormattedDate(time());
		$this->endTime = Utilities::timestampToFormattedDate(time());
		$this->supplier = "";
	}
	
	public function rules() {
		return array(
			array('startTime, endTime', 'required'),
			array('cabang', 'length', 'max'=>10),
			array('supplier', 'length', 'max'=>128),
		);
	}
}