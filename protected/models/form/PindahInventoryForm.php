<?php
class PindahInventoryForm extends CFormModel
{
	public $jumlah;
	public $lokasiTujuan;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('jumlah, lokasiTujuan', 'required'),
			array('jumlah, lokasiTujuan', 'numerical', 'integerOnly'=>true),
			array('jumlah, lokasiTujuan', 'length', 'max'=>10),
		);
	}
}