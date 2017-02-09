<?php 


	function form_token()
	{
		$_SESSION['form_protect'] = $token_form = create_token();
		$_SESSION['time_protect_form'] = time();
		$feild = "<input type='hidden' name = 'form_token' value = '" . $token_form . "' />"; 
		return $feild;

	}

	function create_token()
	{
		$token = md5(uniqid());
		return $token;
	}

	function checkVaildToken ($_SESSION_token , $form_token)
	{
		if($_SESSION_token == $form_token)
		{
			return true;

		}else
		{
			return false;
		}

   }

   function notEndOftimeOfSession()
   {
   		if($_SESSION['time_protect_form'] > (time() + 1800))
   		{

   			$_SESSION['form_protect'] = null;
   			$_SESSION['time_protect_form'] = null;
   			return false;

   		}
   		return true;
   }