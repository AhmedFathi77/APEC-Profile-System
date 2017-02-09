<?php



	class StoredProcedure 
	{

			private static  $_instance = null;
			private function __construct()
			{

			}

			public static function  getInstance()
			{
			 	if(self::$_instance == null)
			 	{
			 		self::$_instance = new StoredProcedure();
			 	}

			 	return self::$_instance;
			}


			// Select Data M7taga Lesa Tzbetat Bs B3d Ama Arkb Fe Al Design .. 
			public function selectData(int $id , string $typeOfData , DataBase $db_instance)
			{
			 		$db = $db_instance->dataBaseConnection();
			 		$data = $this->kindOfDataReturn($typeOfData);
			 		$data = $data . "(" . $id . ")";

			 		$find = $db ->query($data);

			 		$result = $find ->fetchAll(PDO::FETCH_ASSOC);
			 		return $result;
			}

		public function dataReplace( int $user_id ,  array $data , string $typeOfData)
		{
			$typeOfData = strtolower($typeOfData);
			if($typeOfData == 'about') {$replaced = ($this->replaceDataAbout($user_id , $data)) ?  true : false;}
			else if($typeOfData == 'education') {$replaced =( $this->replaceDataEducation($user_id , $data)) ?  true :  false;}
			else{throw new Exception("Sorry There Are A Problem In our System Please Contact Us At " . CONTACT_EMAIL);}
			return $replaced;

		}

		 public function  insertData(int $user_id , array $data_inserted, string $typeOfData)
		 {

		 	switch ($typeOfData) {
		 		  case 'skill':
		 		  	$successOrNot = ($this->skillInsert($user_id , $data_inserted)) ? true : false;
		 		  	return $successOrNot;
		 		   break;
		 		    case 'course':
		 		  	$successOrNot = ($this->courseInsert($user_id , $data_inserted)) ? true : false;
		 		  	return $successOrNot;
		 		   break;
		 		    case 'trainning':
		 		  	$successOrNot = ($this->trainningInsert($user_id , $data_inserted)) ? true : false;
		 		  	return $successOrNot;
		 		   break;
		 		    case 'activity':
		 		  	$successOrNot = ($this->activityInsert($user_id , $data_inserted)) ? true : false;
		 		  	return $successOrNot;
		 		   break;
		 		
		 		default:
		 		throw new Exception("Sorry There Are A Problem In our System Please Contact Us At " . CONTACT_EMAIL);
		 		
		 		break;

		 		
		 	}
		 	
		 }

		 public function deleteData(int $type_id , string $typeOfData)
		 {
		 		switch ($typeOfData) {
		 		  case 'skill':
		 		  	$successOrNot = ($this->delete_from_procedure($type_id , 'skill')) ? true : false;
		 		  	return 	$successOrNot;
		 		   break;
		 		    case 'course':
		 		  	$successOrNot = ($this->delete_from_procedure($type_id , 'course')) ? true : false;
		 		  	return 	$successOrNot;
		 		   break;
		 		    case 'trainning':
		 		  	$successOrNot = ($this->delete_from_procedure($type_id , 'trainning')) ? true : false;
		 		  	return 	$successOrNot;
		 		   break;
		 		    case 'activity':
		 		  	$successOrNot = ($this->delete_from_procedure($type_id , 'activity')) ? true : false;
		 		  	return 	$successOrNot;
		 		   break;
		 		
		 		default:
		 		throw new Exception("Sorry There Are A Problem In our System Please Contact Us At " . CONTACT_EMAIL);
		 		
		 		break;
		 	}


		 }


		 private function delete_from_procedure ( int $id , string $type , DataBase $db_instance)
		 {
		 		$db = $db_instance->dataBaseConnection();
		 		$delete = $db->prepare('CALL delete_user_' . $type . "(" . $id . ")");
		 		$delete ->execute();
		 		return ($delete -> rowcount() > 0) ? true : false;


		 }

		 private function replaceDataEducation(int $user_id , array $data_edu , DataBase $db_instance)
		 {
		 		$db = $db_instance->dataBaseConnection();
		 		$replace_data = $db-> prepare("CALL replace_user_education(? , ? , ? , ? , ? , ? , ?)");
		 		$replace_data ->bindparam(1 , $user_id , PDO::PARAM_INT);
		 		$replace_data ->bindparam(2 , $data_edu['uni_n'] , PDO::PARAM_STR);
		 		$replace_data ->bindparam(3 , $data_edu['faculty_n'] , PDO::PARAM_STR);
		 		$replace_data ->bindparam(4 , $data_edu['department_n'] ,PDO::PARAM_STR);
		 		$replace_data ->bindparam(5 , $data_edu['year_n'] , PDO::PARAM_STR);
		 		$replace_data ->bindparam(6 , $data_edu['grade_n'] , PDO::PARAM_STR);
		 		$replace_data ->bindparam(7 , $data_edu['is_garduated_n'] , PDO::PARAM_BOOL);
		 		$replace_data ->execute();

		 		return ($replace_data->rowcount() > 0) ? true : false ;
		 }

		 private function  replaceDataAbout(int $user_id , array $data_about, DataBase $db_instance)
		 {
		 		$db = $db_instance->dataBaseConnection();
		 		$replace_data = $db-> prepare("CALL replace_user_about(? , ? , ?)");
		 		$replace_data ->bindparam(1 , $user_id , PDO::PARAM_INT);
		 		$replace_data ->bindparam(2 , $data_about['bio_n'] , PDO::PARAM_STR);
		 		$replace_data ->bindparam(3 , $data_about['lives_in_n'] , PDO::PARAM_STR);
		 		$replace_data ->execute();
		 		return ($replace_data->rowcount() > 0) ? true : false ;
		 }

		

		 private function skillInsert(int $user_id , array $data_inserted , DataBase $db_instance)
		 {

		 	    $db = $db_instance->dataBaseConnection();
		 		$skill_insert = $db-> prepare("CALL add_skill(? , ?)");
		 		$skill_insert ->bindparam(1 , $user_id , PDO::PARAM_INT);
		 		$skill_insert ->bindparam(2 , $data_inserted['cert'] , PDO::PARAM_STR);
		 		$skill_insert ->execute();
		 		return ($skill_insert->rowcount() > 0) ? true : false ;
		 }


		 private function courseInsert(int $user_id , array $data_inserted , DataBase $db_instance)
		 {
		 		$db = $db_instance->dataBaseConnection();
		 		$course_insert = $db-> prepare("CALL add_course(? , ? , ? , ? , ?)");
		 		$course_insert ->bindparam(1 , $user_id , PDO::PARAM_INT);
		 		$course_insert ->bindparam(2 , $data_inserted['cert'] , PDO::PARAM_STR);
		 		$course_insert ->bindparam(3 , $data_inserted['c_from_a'] , PDO::PARAM_STR);
		 		$course_insert ->bindparam(4 , $data_inserted['year_n'] , PDO::PARAM_INT);
		 		$course_insert ->bindparam(5 , $data_inserted['month_n'] , PDO::PARAM_STR);
		 		$course_insert ->execute();
		 		return ($course_insert->rowcount() > 0) ? true : false ;
		 }


		  private function trainningInsert(int $user_id , array $data_inserted , DataBase $db_instance)
		 {

		 	    $db = $db_instance->dataBaseConnection();
		 		$trainningInsert = $db-> prepare("CALL add_trainning(? , ? , ? , ?)");
		 		$trainningInsert ->bindparam(1 , $user_id , PDO::PARAM_INT);
		 		$trainningInsert ->bindparam(2 , $data_inserted['cert'] , PDO::PARAM_STR);
		 		$trainningInsert ->bindparam(3 , $data_inserted['decs_n'] , PDO::PARAM_STR);
		 		$trainningInsert ->bindparam(4 , $data_inserted['year_n'] , PDO::PARAM_INT);
		 		$trainningInsert ->execute();
		 		return ($trainningInsert->rowcount() > 0) ? true : false ;
		 }

		 private function activityInsert(int $user_id , array $data_inserted , DataBase $db_instance)
		 {
		 		$db = $db_instance->dataBaseConnection();
		 		$activity_insert = $db-> prepare("CALL add_activity(? , ? , ? , ? , ?)");
		 		$activity_insert ->bindparam(1 , $user_id , PDO::PARAM_INT);
		 		$activity_insert ->bindparam(2 , $data_inserted['activity_n'] , PDO::PARAM_STR);
		 		$activity_insert ->bindparam(3 , $data_inserted['job_des_n'] , PDO::PARAM_STR);
		 		$activity_insert ->bindparam(4 , $data_inserted['year_n'] , PDO::PARAM_INT);
		 		$activity_insert ->bindparam(5, $data_inserted['position_n'] , PDO::PARAM_STR);
		 		$activity_insert ->execute();
		 		return ($activity_insert->rowcount() > 0) ? true : false ;
		 }


		 
		 private function kindOfDataReturn (string $typeOfData)
		 {
		 	switch ($typeOfData) {
		 		case 'education':
		 		    return "CALL education_user_data";
		 			break;
		 			case 'about':
		 		    return "CALL about_user_data";
		 			break;
		 			case 'skill':
		 			return  "CALL skill_user_data";
		 			break;
		 			case 'course':
		 			return "CALL course_user_data";
		 			break;
		 			case 'trainning':
		 			return "CALL trainning_user_data";
		 			break;
		 			case 'activity':
		 			return "CALL activity_user_data";
		 			break;
		 		
		 		default:
		 			throw new Exception("Sorry There Are A Problem In our System Please Contact Us At " . CONTACT_EMAIL);
		 		break;
		 	}

		 }


	}