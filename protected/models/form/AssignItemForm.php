<?php
class AssignItemForm extends CFormModel
{
	public $lokasi;
	public $harga;
	public $harga_minimum;
	public $harga_minimum_khusus;
	public $jumlah;
	public $serial_number;
	
	public function rules() {
		return array (
			array('lokasi, harga, harga_minimum, harga_minimum_khusus, jumlah', 'required'),
			array('harga, harga_minimum, harga_minimum_khusus, jumlah', 'numerical', 'integerOnly'=>true),
			array('serial_number', 'length', 'max'=>128),
			array('harga, harga_minimum, harga_minimum_khusus', 'length', 'max'=>10),
		);
	}
}