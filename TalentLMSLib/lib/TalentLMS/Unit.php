<?php
class TalentLMS_Unit extends TalentLMS_ApiResource{
	
	public static function getUsersProgress($params){
		$class = get_class();
		return self::_scopedGetUsersProgressInUnits($class, $params);
	}
}