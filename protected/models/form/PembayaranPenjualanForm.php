<?php
class PembayaranPenjualanForm extends CFormModel
{
	public $biaya_pengiriman;
	public $down_payment;
	public $jenis_pembayaran;
	public $comment_external;
	public $comment_internal;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
				array('jenis_pembayaran, down_payment', 'required'),
				array('biaya_pengiriman, down_payment', 'length', 'max'=>10),
				array('biaya_pengiriman, down_payment', 'numerical','integerOnly'=>true),
				array('comment_external, comment_internal', 'length', 'max'=>255),
		);
	}
}