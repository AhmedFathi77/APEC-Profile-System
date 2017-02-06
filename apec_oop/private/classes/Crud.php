<?php


	interface  Crud 
	{

			 public function selectData(int $id , string $typeOfData);

			 public function replaceDataEducation(int $user_id , array $data_edu );

			 public function  replaceDataAbout(int $user_id , array $data_about);

			// In Inserted Data I Will Take It As Array (Type : (Skill - About .. So on ) , DATA Wanted To Be Inserted ..)

			//public function  insertData(int $user_id , array $data_inserted);

			//public function  deleteData(int $data_id); // Example skill_id = 2 .. 

	}