<?php




class Register 
{
	// Use Vaildation Of Phone Number (Trait) ..

	use VaildPhoneNumber;


	protected $firstName;
	protected $lastName;
	protected $phone;
	protected $pwd;
	protected $country;
	protected $Crud;
	protected $cleardata;
	protected $db;
	protected $errorMsg = array();


	function __construct(DataBase $db_instance, Crud $crud_instance , ClearData $clean_instance)
	{
		$this->db = $db_instance;
		$this->Crud = $crud_instance;
		$this->cleardata = $clean_instance;

	}

	public function setFirstName ($fN)
	{
		$this->firstName = $fN;
		return $this;
	}

	public function setlastName ($lN)
	{
		$this->lastName = $lN;
		return $this;
	}

	public function setPwd ($pwd)
	{
		$this->pwd = $pwd;
		return $this;
	}

	public function setcountry($country)
	{
		$this->country = $country;
		return $this;
	}

	public function setPhone ($phone)
	{
		$this->phone = $phone;
		return $this;
	}
	 
	// DataBase $db_instance , array $where_clause = null , array $specific_columns = array("all" => '*')
	protected function  userFoundOrNot() // This For Check If User Phone Found In DataBase ..
	{
		$this->phone = $this->regexRegisterPhone($this->phone);
		if($this->phone != false)
		{
			         		$userFoundOrNot = $this->Crud->setTableName('users')->selectData($this->db , array('phone' , "\"$this->phone\"") , array('phone')); 
							if($userFoundOrNot == false)
							{
								return false; // This Mean User Not Found ..

							}else
							{
								$this->errorMsg['user_register'] = 'This Phone Number Found If You  The Owner Please Login In If You Have A Problem You Can Contact Us At ' . CONTACT_EMAIL;
							}
		}else
		{
			$this->errorMsg[] = 'Invailed Phone Number Example :- 01234567890';
				
		}

				return $this->errorMsg;
	}





}