<?php


	class ClearData extends CleanData
	{
		protected  $clearData;
		protected  $maxLength = 40;
		protected  $errorMsg = array();
		protected  $dataOutput;




	    public function escapeOutput($data)
		{
			return htmlspecialchars($data);

		}

		public function urlEncode($url)
		{
			return urlencode($url);

		}

		// $dirty , string $type , int $max_length = self::$max_length
		public function  clearedData($dirty ,  $type ,  $max_length = null)
		{
			$max = ($max_length != null) ? $max_length : $this->maxLength;
			$this->dataOutput = $this->dataPrepareType( $dirty, $type  , $max);
			if(empty($this->errorMsg))
			{
				return $this->dataOutput;
			}
			return $this->errorMsg;
		}




		// First Stage Of Clear Data ..
		protected  function filterValidateString($string ,  $length = 40) // Ex: For User Data After Register ..  
		{
			if(!is_string($string) || strlen($string) > $length)
			{
				$this->errorMsg['max_length'] ='Please Type '. $length . 'Or Less Only '; 

			}else if (!preg_match ('/^[A-Z \'.-]{5,40}$/i', $string)) // String From Min Length 5 Max Length 40 ..
			{
					$this->errorMsg['Incorrect_data'] ='Please Type A Correct Data ! Or Contact Us At ' . CONTACT_EMAIL . ' If You Need Help'; 

			}else
			{
				$this->clearData = $string;
				return  $this->clearData;
			}

			return $this->errorMsg;
		}


		protected 	function filterValidateNumber($number)
		{
			$this->clearData = $this->trimData(filter_var($number , FILTER_VALIDATE_INT	 , array("option"=>array('min_range' => 0))));
			if(!empty($this->clearData)) return  $this->clearData;
			else $this->errorMsg['number_empty_error'] = 'Error I See That You Forget Required Data Or You Put Invailed Data  Please Fill It Again !';
			return $this->errorMsg;
		}

		protected   function trimData($data)
		{
			return trim($data);

		}


		protected function  filterVaildateUrl($url)
		{
		    $this->clearData = $this->trimData(filter_var($url , FILTER_VALIDATE_URL));
			if(!empty($this->clearData)) return $this->clearData;
			else $this->errorMsg['Incorect_url'] = 'Error I See That You Put Incorrect Url Please Put A Vailed One  !';
			return $this->errorMsg;

		}


		protected  function filterVaildateEmail($email)
		{
			$this->clearData = $this->trimData(filter_var($email , FILTER_VALIDATE_EMAIL));
			if(!empty($this->clearData)) return $this->clearData;
			else $this->errorMsg['Incorrect_email'] = 'Please Enter Correct Email !';
			return $this->errorMsg;

		}
		// Second Stage Of Clear Data ..
		protected   function filterSantizeString($string)
		{
			$this->clearData = filter_var($string , FILTER_SANITIZE_STRING);
			return $this->clearData;

		}

		protected  function filterSantizeNumber($number)
		{
			$this->clearData = filter_var($number,FILTER_SANITIZE_NUMBER_INT);
			return $this->clearData;

		}


		protected function filterSantizeUrl($url)
		{
			$this->clearData = filter_var($url,FILTER_SANITIZE_URL);
			return $this->clearData;

		}

		protected function filterSantizeEmail($email)
		{
			$this->clearData = filter_var($email,FILTER_SANITIZE_EMAIL);
			return $this->clearData;
		}





		protected function dataPrepareType($dirty , string $type , int $max_length)
		{
			switch ($type) {
				case 'string':
					$f =  $this->filterValidateString($dirty , $max_length);
					if(empty($this->errorMsg)) {return $this->filterSantizeString($f);}else{return $this->errorMsg;}
				break;
				case 'int':
					$f =  $this->filterValidateNumber($dirty);
					if(empty($this->errorMsg)) {return $this->filterSantizeNumber($f); }else{return $this->errorMsg;}
				break;
				
				case 'url':
					$f =  $this->filterVaildateUrl($dirty);
					if(empty($this->errorMsg)) {return $this->filterSantizeUrl($f); }else{return $this->errorMsg;}
				break;
				
				case 'email':
					$f =  $this->filterVaildateEmail($dirty);
					if(empty($this->errorMsg)) {return $this->filterSantizeEmail($f); }else{return $this->errorMsg;}
				break;
				
				default:
					throw new Exception("Sorry There Is A problem Please Send Message To Admin At " . CONTACT_EMAIL);
					
				break;
			}

		}





	}