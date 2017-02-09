<?php 



	class DataBase 
	{
		private static $_instance = null;

		private $host;
		private $user_Name;
		private $d_name;
		private $u_pass;
		

		private function  __construct()  
		{
				$this->host = HOST;
				$this->user_Name = D_UserName;
				$this->d_name = D_Name;
				$this->u_pass = U_Pass;
		}

		

		public static function  getInstance()
		{
		 	if(self::$_instance == null)
		 	{
		 		self::$_instance = new DataBase();
		 	}

		 	return self::$_instance;
		}



		public  function  dataBaseConnection()
		{
		 	$conn = new PDO('mysql:host='.$this->host.';dbname='.$this->d_name, $this->user_Name, $this->u_pass);
		 	$conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
		 	if($conn)
		 	{
		 		return $conn;
		 	}else
		 	{
		 		throw new Exception("Sorry There Is Aproblem Please Send Message To Admin At" . CONTACT_EMAIL);
		 		
		 	}

		}

		private  function __clone()
		{
			// Prevent Any One To Create Clone From This Class .. 

		}

		


	}


		// id_user int, uni_n varchar(50) , faculty_n varchar(50), department_n varchar(30) , 
//year_n varchar(10) , grade_n varchar(20) , is_garduated_n bool

			//public function  replaceDataAbout(int $user_id , array $data_about);

			// In Inserted Data I Will Take It As Array (Type : (Skill - About .. So on ) , DATA Wanted To Be Inserted ..)

		//	public function  insertData(int $user_id , array $data_inserted);

		//	public function  deleteData(int $data_id); // Example skill_id = 2 .. 
