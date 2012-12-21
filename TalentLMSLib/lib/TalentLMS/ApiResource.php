<?php

abstract class TalentLMS_ApiResource{

	protected static function _scopedRetrieve($class, $id){
		$url = self::_instanceUrl($class, $id);
		$response = TalentLMS_ApiRequestor::request('get', $url);
		
		return $response;
	}
	
	protected static function _scopedAll($class){
		$url = self::_classUrl($class);
		$response = TalentLMS_ApiRequestor::request('get', $url);
		
		return $response;
	}
	
	protected static function _scopedLogin($class, $params){
		self::_validateCall('login', $class, $params);
		$url = self::_postUrl('login');
		$response = TalentLMS_ApiRequestor::request('post', $url, $params);
		
		return $response;
	}
	
	protected static function _scopedSignup($class, $params){
		self::_validateCall('signup', $class, $params);
		$url = self::_postUrl('signup');
		$response = TalentLMS_ApiRequestor::request('post', $url, $params);
	
		return $response;
	}
	
	protected static function _scopedAddUserToCourse($class, $params){
		self::_validateCall('addUser', $class, $params);
		$url = self::_postUrl('addUser');
		$response = TalentLMS_ApiRequestor::request('post', $url, $params);
	
		return $response;
	}
	
	protected static function _scopedGotoCourse($class, $params){
		self::_validateCall('gotoCourse', $class, $params);
		$url = self::_postUrl('gotoCourse');
		$response = TalentLMS_ApiRequestor::request('post', $url, $params);
		
		return $response;
	}
	
	protected static function _scopedBuyCourse($class, $params){
		self::_validateCall('buyCourse', $class, $params);
		$url = self::_postUrl('buyCourse');
		$response = TalentLMS_ApiRequestor::request('post', $url, $params);
	
		return $response;
	}
	
	protected static function _scopedRetrieveLeafsAndCourses($class, $params){
		self::_validateCall('retrieveLeafsAndCourses', $class, $params);
		$url = self::_instanceUrlByParams('leafsAndCourses', $params);
		$response = TalentLMS_ApiRequestor::request('get', $url);
	
		return $response;
	}
	
	protected static function _scopedGetCustomRegistrationFields($class){
		$url = self::_classUrlByMethodName('customRegistrationFields');
		$response = TalentLMS_ApiRequestor::request('get', $url);
	
		return $response;
	}
	
	protected function _instanceUrl($class, $id){
		$base = self::_classUrl($class);
		$url = $base."/id:".$id;
		
		return $url;
	}
	
	protected function _classUrl($class){
		$class = str_replace('TalentLMS_', '', $class);
		$class = strtolower($class);
		
		if($class == 'user'){
			return "/users";
		}
		else if($class == 'course'){
			return "/courses";
		}
		else if($class == 'category'){
			return "/categories";
		}
		else if($class == 'branch'){
			return "/branches";
		}
		else if($class == 'group'){
			return "/groups";
		}
		else if($class == 'siteinfo'){
			return "/siteinfo";
		}
	}
	
	protected function _instanceUrlByMethodName($method, $id){
		$base = self::_classUrlByMethodName($method);
		$url = $base."/id:".$id;
	
		return $url;
	}
	
	protected function _instanceUrlByParams($method, $params){
		$base = self::_classUrlByMethodName($method);
		$url = $base."/";
		
		foreach($params as $key => $value){
			$url .= $key.':'.$value.',';
		}
		
		$url = trim($url, ',');
	
		return $url;
	}
	
	protected function _classUrlByMethodName($method){
		if($method == 'leafsAndCourses'){
			return "/categoryleafsandcourses";
		}
		else if($method == 'customRegistrationFields'){
			return "/getcustomregistrationfields";
		}
	}
	
	protected function _postUrl($method){
		if($method == 'login'){
			return "/userlogin";
		}
		else if($method == 'addUser'){
			return "/addusertocourse";
		}
		else if($method == 'signup'){
			return "/usersignup";
		}
		else if($method == 'gotoCourse'){
			return "/gotocourse";
		}
		else if($method == 'buyCourse'){
			return "/buycourse";
		}
	}
	
	private static function _validateCall($method, $class, $params=null){
		if($params && !is_array($params)){
			throw new TalentLMS_ApiError("You must pass an array as the first argument to ".$class.'::'.$method."() method calls.");
		}
	}
}