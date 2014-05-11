<?php
class ReportForm extends CFormModel {
	
	/**
	 * 0 means select all location
	 */
	public $cabang;
	
	public $startTime;
	
	public $endTime;
	
	public function rules() {
		return array(
			array('startTime, endTime', 'required'),
			array('cabang', 'length', 'max'=>10),
		);
	}
}