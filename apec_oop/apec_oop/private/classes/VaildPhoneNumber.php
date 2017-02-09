<?php

	// Please Note this Vaildation Work For Egypt Only ..

	trait VaildPhoneNumber
	{

		public function regexRegisterPhone($phoneNumber)
		{

			$phoneNumber = (strlen($phoneNumber) == 11 && $phoneNumber[0] == 0) ? substr($phoneNumber, 1) : $phoneNumber;

			if(!preg_match("/^[0-9]{10}$/", $phoneNumber))
			{
				return false;

			}else
			{
				$vaildNumber = '+20' . $phoneNumber; // if Number 01125724372  Return +201125724372 To Use In Twillio .. 
				return $vaildNumber;
			}

		} 

	} 