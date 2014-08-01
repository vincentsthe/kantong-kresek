<?php

class AddLoginPermissionForm extends CFormModel {
	
	public $user;
	public $cabang;
	
	public function rules() {
		return array (
			array('user, cabang', 'required'),
		);
	}
	
}