<?php
	require("../includes/config.php");

	try
	{
		
		
	//	$i = DataBase::getInstance();
	//	$db = Crud::getInstance() -> setTableName('education') ->deleteData($i , array('id' , 1)) ;
	//	var_dump($db);

	}catch(EXCEPTION $e)
	{
		echo $e->getMessage();
	}