<?php
class UpdateInventoryHargaForm extends CFormModel
{
	public $harga;
	public $harga_minimum;
	public $harga_minimum_khusus;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('harga, harga_minimum, harga_minimum_khusus', 'required'),
			array('harga, harga_minimum, harga_minimum_khusus', 'numerical', 'integerOnly'=>true),
			array('harga, harga_minimum, harga_minimum_khusus', 'length', 'max'=>10),
		);
	}
}