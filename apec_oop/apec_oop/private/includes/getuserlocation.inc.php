<?php


	// This Function Return Location Of User Function .. 
	// This Need To Be Class Crew 18 ..


	/*
		returned Json Data From  ("http://freegeoip.net/json/" . $userIp)

		  public 'ip' => string '197.52.24.242' (length=13)
		  public 'country_code' => string 'EG' (length=2)
		  public 'country_name' => string 'Egypt' (length=5)
		  public 'region_code' => string 'C' (length=1)
		  public 'region_name' => string 'Cairo Governorate' (length=17)
		  public 'city' => string 'Cairo' (length=5)
		  public 'zip_code' => string '' (length=0)
		  public 'time_zone' => string 'Africa/Cairo' (length=12)
		  public 'latitude' => float 30.0771
		  public 'longitude' => float 31.2859
		  public 'metro_code' => int 0



	*/
	function getUserLocation($userIp)
	{

		$startInteract = curl_init("http://freegeoip.net/json/" . $userIp);
		curl_setopt($startInteract, CURLOPT_FAILONERROR, 1);
		curl_setopt($startInteract, CURLOPT_TIMEOUT, 20);
		curl_setopt($startInteract, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($startInteract);
		curl_close($startInteract);

		if(!empty($result))
		{
			return $result;
		}

		return false; 

	}

	// 197.52.24.242,EG,Egypt,C,Cairo Governorate,Cairo,,Africa/Cairo,30.08,31.29,0

	function getUserIp()
	{

		//return $_SERVER['REMOTE_ADDR'];
		return '197.52.24.242';
	}


	function json_decoded($json_data)
	{
		return json_decode($json_data);

	}