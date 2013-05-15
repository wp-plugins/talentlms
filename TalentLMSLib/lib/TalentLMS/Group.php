<?php

class TalentLMS_Group extends TalentLMS_ApiResource{
	
	public static function retrieve($id){
		$class = get_class();
		return self::_scopedRetrieve($class, $id);
	}
	
	public static function all(){
		$class = get_class();
		return self::_scopedAll($class);
	}
	
	public static function addUser($params){
		$class = get_class();
		return self::_scopedAddUserToGroup($class, $params);
	}
}