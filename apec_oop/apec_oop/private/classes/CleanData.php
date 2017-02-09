<?php

	abstract class CleanData
	{
		 // Filter Vaildate Section
		 abstract protected  function filterValidateString($string, $length);
		 abstract protected  function filterValidateNumber($number);
		 abstract protected  function filterVaildateUrl($url);
		 abstract protected  function filterVaildateEmail($email);

		 // Filter Santize Section
		 abstract protected  function filterSantizeString($string);
		 abstract protected  function filterSantizeNumber($number);
		 abstract protected  function filterSantizeUrl($url);
		 abstract protected  function filterSantizeEmail($email);


		 // Escape OutPut
		 abstract public function escapeOutput($string);
		 abstract public function urlEncode($url);
		 abstract protected function trimData($dataToTrim);


	}