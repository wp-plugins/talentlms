<?php

class TalentLMS_User extends TalentLMS_ApiResource{
	
	public static function retrieve($id){
		$class = get_class();
		return self::_scopedRetrieve($class, $id);
	}
	
	public static function all(){
		$class = get_class();
		return self::_scopedAll($class);
	}
	
	public static function login($params){
		$class = get_class();
		return self::_scopedLogin($class, $params);
	}
	
	public static function signup($params){
		$class = get_class();
		return self::_scopedSignup($class, $params);
	}
	
	public static function getCustomRegistrationFields(){
		$class = get_class();
		return self::_scopedGetCustomRegistrationFields($class);
	}
}