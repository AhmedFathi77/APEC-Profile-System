<?php
  try
  {
      require_once("../private/includes/config.php");

      require(BASE_URI  . "private/includes/protectforms.inc.php");
      require(BASE_URI  . "private/includes/getuserlocation.inc.php");

      // Create Instance Of Class Clear Data .. Inside The Post Request I Not Want It OutSide it ..
       $clearData = new clearData();
       $curdd = new Crud();
    //  if($_SERVER['REQUEST_METHOD'] == 'POST')
     // {


    //  }

      $phonenumber = "125724372";
      $reg = new Register($db_instance ,  $curdd , $clearData);
      $reg->setPhone("string");
      var_dump($reg->userFoundOrNot());



     
      //require_once('views/header.inc.html');
     // require_once('views/register.inc.html');


  }catch(EXCEPTION $e){


      echo $e->getMessage();

  }
