<?php
class AddPenjualanForm extends CFormModel
{
	public $jumlah;
	public $harga;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('jumlah, harga', 'required'),
			array('jumlah, harga', 'length', 'max'=>10),
			array('jumlah, harga', 'numerical', 'integerOnly'=>true),
		);
	}
}