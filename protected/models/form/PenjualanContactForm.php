<?php
class PenjualanContactForm extends CFormModel
{
	public $nama_pembeli;
	public $alamat_pembeli;
	public $telpon_pembeli;
	public $nama_terkirim;
	public $alamat_terkirim;
	public $telpon_terkirim;
	
	public $tipe_pembeli;
	//tipe_pembeli==1 -> pembeli biasa
	//tipe_pembeli==2 -> pembeli khusus

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('tipe_pembeli', 'required'),
			array('nama_pembeli, nama_terkirim, telpon_pembeli, telpon_terkirim', 'length', 'max'=>64),
			array('alamat_pembeli, alamat_terkirim', 'length', 'max'=>255),
		);
	}
}