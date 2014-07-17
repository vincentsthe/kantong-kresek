<?php
class UpdateInventoryHargaForm extends CFormModel
{
	public $harga;
	public $harga_minimum;
	public $harga_minimum_khusus;
	
	public static function newHargaForm($inventory) {
		$form = new UpdateInventoryHargaForm;
		$form->harga = $inventory->harga;
		$form->harga_minimum = $inventory->harga_minimum;
		$form->harga_minimum_khusus = $inventory->harga_minimum_khusus;
		
		return $form;
	}

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