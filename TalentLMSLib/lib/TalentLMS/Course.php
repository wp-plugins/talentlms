<?php

class TalentLMS_Course extends TalentLMS_ApiResource{
	
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
		return self::_scopedAddUserToCourse($class, $params);
	}
	
	public static function gotoCourse($params){
		$class = get_class();
		return self::_scopedGotoCourse($class, $params);
	}
	
	public static function buyCourse($params){
		$class = get_class();
		return self::_scopedBuyCourse($class, $params);
	}
}