<?php

class TalentLMS_Category extends TalentLMS_ApiResource{
	
	public static function retrieve($id){
		$class = get_class();
		return self::_scopedRetrieve($class, $id);
	}
	
	public static function all(){
		$class = get_class();
		return self::_scopedAll($class);
	}
	
	public static function retrieveLeafsAndCourses($params){
		$class = get_class();
		return self::_scopedRetrieveLeafsAndCourses($class, $params);
	}
}