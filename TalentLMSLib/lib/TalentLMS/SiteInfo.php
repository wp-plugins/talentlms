<?php
class TalentLMS_Siteinfo extends TalentLMS_ApiResource{
	
	public static function get(){
		$class = get_class();
		return self::_scopedAll($class);
	}
}