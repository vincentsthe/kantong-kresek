<?php
class PembayaranForm extends CFormModel
{
	public $jumlah;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('jumlah', 'required'),
			array('jumlah', 'numerical', 'integerOnly'=>true),
			array('jumlah', 'length', 'max'=>10),
		);
	}
}