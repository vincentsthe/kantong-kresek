<?php
class PenjualanContactForm extends CFormModel
{
	public $nama_pembeli;
	public $alamat_pembeli;
	public $telpon_pembeli;
	public $nama_terkirim;
	public $alamat_terkirim;
	public $telpon_terkirim;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('nama_pembeli, nama_terkirim, telpon_pembeli, telpon_terkirim', 'length', 'max'=>64),
			array('alamat_pembeli, alamat_terkirim', 'length', 'max'=>255),
		);
	}
}