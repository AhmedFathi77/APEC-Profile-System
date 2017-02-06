<?php

	// id_user int, uni_n varchar(50) , faculty_n varchar(50), department_n varchar(30) , 
//year_n varchar(10) , grade_n varchar(20) , is_garduated_n bool
	require("../includes/config.php");

	try
	{
		$id  = 1;
		
		$x = DataBase::getInstance();
		var_dump($x);

	}catch(EXCEPTION $e)
	{
		echo $e->getMessage();
	}