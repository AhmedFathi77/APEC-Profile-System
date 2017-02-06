<?php 
	ini_set("error_log", __DIR__ . "/error.log");


	
	define("BASE_URI" ,"C:/wamp64/www/apec_oop/");
	define("BASE_URL" , "http://localhost/apec_oop/");



	// DataBase Config .. 
	define("HOST","localhost");
	define("D_Name","apec_last");
	define("U_Pass","");
    define("D_UserName","root");



	// This Mail Will Use To Send Any Error To It In Message .. 
	define("CONTACT_EMAIL" , "one_zoma@yahoo.com");


	function error_handler($e_number , $e_message , $e_file , $e_line , $e_vars)
	{
		$on = false;
		$Message = "There Is An Error On File " . $e_file . " <br />";
		$Message .= "No. -> $e_number At Line $e_line";

		if($on)
		{
			// Log It
			

			if($e_file != E_NOTICE)
			{
					// i Must Here Use Jquery And Some Thing Like That 

					echo "<h1>Sorry .. </h1>";
			}

			error_log($Message);

		}else
		{
			echo $Message;
		}

			return true;
	}
	set_error_handler("error_handler");


	// Set Exception Handler 

	function my_exception_handler($m_Exception)
	{
			$on = false;

			if($on)
			{
				error_log($m_Exception);

			}else
			{
				echo $m_Exception->getMessage();
			}
		return true;	
	}

	set_exception_handler("my_exception_handler");


	// Auto Load Classes ..

	spl_autoload_register(function($class_name){

		require BASE_URI . "private/classes/" . $class_name . '.php';
	});
