<?php

	
	/* Methods */
		//	abstract public bool close ( void );
		//	abstract public bool destroy ( string $session_id );
		//	abstract public bool gc ( int $maxlifetime );
		//	abstract public bool open ( string $save_path , string $session_name );
		//	abstract public string read ( string $session_id );
		//	abstract public bool write ( string $session_id , string $session_data );
	class SessionHandlerApec implements SessionHandlerInterface
	{
		private $_dbconnection;
		private $_crudObject;
		public function __construct(DataBase $db_instance , Crud $get_data)
		{
			$this->_dbconnection = $db_instance;
			$this->_crudObject = $get_data;

		}


		public function  read ( $session_id)
		{
			
			//  Parameter  of SelectData (DataBase $db_instance , array $where_clause = null , array $specific_columns = array("all" => '*')) 
			$dataSelected = $this->_crudObject->setTableName('apecsession')->selectData($this->_dbconnection , array('id' , "\"$session_id\"") , array("sdata")); 

			if(count($dataSelected) == 1)
			{
				return  $dataSelected;

			}else
			{
				return '';
			}


			throw new Exception("Sorry There Is A problem Please Send Message To Admin At " . CONTACT_EMAIL);
		}

		public function write( $session_id ,  $session_data)
		{
			$replace_statement = sprintf(" REPLACE INTO %s  ( %s, %s) VALUES (%s , %s) " , 'apecsession' , 'id',  'sdata' , '?', '?') ;
			$db = $this->_dbconnection->dataBaseConnection();
			$replace = $db->prepare($replace_statement);
			$replace ->bindparam(1 , $session_id , PDO::PARAM_STR);
			$replace ->bindparam(2 , $session_data , PDO::PARAM_STR);
			
			$replace ->execute();
			return true;
		}
		// DataBase $db_instance , array $where_clause .. 
		public function destroy ( $session_id )
		{


			$deleteData = $this->_crudObject->setTableName('apecsession')->deleteData($this->_dbconnection , array('id',$session_id));
			if($deleteData)
			{
				$_SESSION = array();
				return true;
			}
			throw new Exception("Sorry There Is A problem Please Send Message To Admin At " . CONTACT_EMAIL);
		}

		public function open (  $save_path ,  $session_name )
		{
			return true;
		}

		public function gc ($maxlifetime)
		{
			$gcStatement =sprintf(" DELETE FROM %s WHERE date_add(%s , %d ) < NOW()" , 'apecsession' , 'lastaccess', $maxlifetime); 
			$deleteQuery = $this->_dbconnection->dataBaseConnection()->prepare($gcStatement);
			$deleteQuery ->bindparam(1 , $maxlifetime , PDO::PARAM_INT);
			$deleteQuery  ->execute();
			    return true;
		}

		public function close ()
		{
			$this->_dbconnection = null;

			return true;

		}


	}