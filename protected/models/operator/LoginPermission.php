<?php

class LoginPermission {
	
	private $user;
	
	public function __construct($user) {
		$this->user = $user;
	}
	
	public function havePermission($cabang) {
		if(($this->user->role == "admin") || (CabangUser::recordExist($this->user, $cabang))) {
			return true;
		} else {
			return false;
		}
	}
	
	public function addPermision($cabang) {
		if(!CabangUser::recordExist($this->user, $cabang)) {
			CabangUser::addRecord($this->user, $cabang);
		}
	}
	
	public function removePermission($cabang) {
		if(CabangUser::recordExist($this->user, $cabang)) {
			CabangUser::removeRecord($this->user, $cabang);
		}
	}
}