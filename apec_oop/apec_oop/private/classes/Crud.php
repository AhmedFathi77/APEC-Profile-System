<?php
		// Crew 18 .. Must Add Private Function For Table Exists .. If Your Staff Needed It .. 
		// Crew 18 .. Must Add Private Function For Replace Statement .. 
       /*
			If You Create Replace Statement Public Function .. You Must Go To Classes/SessionHandler.php And Change
			The Stupied Replace That Found In  Public Write Function .. 

       */

	class  Crud 
	{

		protected   $table_name;
		protected   $columns_name = array();
		protected   $data = array();
		protected   $Where_status = 0 ;
		protected   $statement = "";



		



		public static function  getInstance()
		{
		 	if(self::$_instance == null)
		 	{
		 		self::$_instance = new Crud();
		 	}

		 	return self::$_instance;
		}


		public function setColumnName(array $columns_name)
		{
			$this->columns_name = $columns_name;
			return $this;
		}
		public function setData(array $data)
		{
			$this->data = $data;
			return $this;
		}
		public function setTableName(string $table_name)
		{
			$this->table_name = $table_name;
			return $this;
		}

		// This Function Must Split To Small Methods .. 

		public function insert(DataBase $db_instance )
		{
			
			if($this->dataCount() !=  true|| empty($this->columns_name) || empty($this->data)  || empty($this->table_name))
			{
				throw new Exception("Sorry There Is Aproblem Please Send Message To Admin At" . CONTACT_EMAIL);
			}	
			else
			{
				$data_count = count($this->data);

			    $this->statement .= 'INSERT INTO ' . $this->table_name. '(' . implode(',' , $this->columns_name) . ')'. ' VALUES ' . '(' . $this->placeHolderCounter($data_count) . ')';
				$db = $db_instance->dataBaseConnection();
				$insert_values = $db->prepare($this->statement);
				for($i=1;$i<=$data_count;$i++)
				{
					if(is_string($this->data[$i]))
					{
						$insert_values ->bindparam($i , $this->data[$i], PDO::PARAM_STR);
					}
					elseif(is_numeric($this->data[$i]))
					{
						$insert_values ->bindparam($i , $this->data[$i], PDO::PARAM_INT);
					}
					else
					{
						throw new Exception("Sorry There Is Aproblem Please Send Message To Admin At " . CONTACT_EMAIL);
					}
				}
				$insert_values->execute();

				if($insert_values->rowcount() > 0)
				{
						return true;
				}else
				{
					return false;
				}
			}
			throw new Exception("Sorry There Is Aproblem Please Send Message To Admin At" . CONTACT_EMAIL);
		}

			public function update(DataBase $db_instance , array $where_clause = null)
		{
			if($this->dataCount() != true || empty($this->columns_name) || empty($this->data) || empty($this->table_name))
			{
				throw new Exception("Sorry There Is A problem Please Send Message To Admin At " . CONTACT_EMAIL);

			}else
			{
				
				$data_combine = array_combine($this->columns_name, $this->data);
				$this->statement .= " UPDATE " . 	$this->table_name . "  SET ";
				$arr_walk = array_walk($data_combine , array($this, 'prepareStatement'));
				$this->statement .= implode(',' , $data_combine);
				var_dump($data_combine , $this->statement);
				if(isset($where_clause) && $where_clause != null)
				{
					// This Need Update In The Future .. 
					$this->statement .=  $this->WhereClause($where_clause[0] , $where_clause[1]);

				}
				$db = $db_instance->dataBaseConnection();
				$update = $db->prepare($this->statement);
				$update ->execute();

				if($update->rowcount() > 0 )
				{
					return true;

				}else
				{
					return false;
				}
			}

				throw new Exception("Sorry There Is A problem Please Send Message To Admin At " . CONTACT_EMAIL);
		}

		public function selectData(DataBase $db_instance , array $where_clause = null , array $specific_columns = array("all" => '*') )
		{
			if(!array_key_exists('all', $specific_columns)) 
			{
				if(count($specific_columns) > 1)
				{
					$this->statement .= " SELECT " . implode(',', $specific_columns) . " FROM " . $this->table_name; //THIS MEAN You Choose More Than One Columns Columns
				}else
				{
					$this->statement .= " SELECT " . $specific_columns[0] . " FROM " . $this->table_name; //THIS MEAN You Choose One Column
			    }
			}else{
				$this->statement .= "SELECT " . $specific_columns['all']. " FROM " . $this->table_name;
			}

			if(isset($where_clause) && $where_clause != null){
			// This Need Update In The Future .. 
			$this->statement .=  $this->WhereClause($where_clause[0] , $where_clause[1]);
			
			}
			var_dump($this->statement);
			$db = $db_instance->dataBaseConnection();
			$select = $db->prepare($this->statement);
			$select ->execute();
			// This Function Must Be Felxabile With Fetch And Fetch All .. We Must Added It Crew 18 :)
			list($this->data) = $select -> fetchall(PDO::FETCH_ASSOC);
			if(count($this->data) >= 1)
			{
				return $this->data;


			}else
			{
				return false;
			}

			throw new Exception("Sorry There Is A problem Please Send Message To Admin At " . CONTACT_EMAIL);
		}


		public function deleteData(DataBase $db_instance , array $where_clause)
		{

			$this->statement .= ' DELETE FROM ' . $this->table_name ;
			if(empty($where_clause) || !isset($where_clause))
			{
				throw new Exception("Please Be Attention You Can Not Delete All Data ..  " . CONTACT_EMAIL);
			}else
			{
				// This Need Update In The Future .. 
				$this->statement .=  $this->WhereClause($where_clause[0] , $where_clause[1]);
			    $db = $db_instance->dataBaseConnection();
			    $delete = $db->prepare($this->statement);
			    $delete ->execute();
			    $deleted = ($delete->rowcount() > 0 ) ? true: false;

			    return  $deleted;
			}

			throw new Exception("Sorry There Is A problem Please Send Message To Admin At " . CONTACT_EMAIL);
		}







		// ? , ? , ? , ?
		private function placeHolderCounter(int $count)
		{
			if($count >0)
			{
				$placeholder =  implode(',' , array_fill(1, $count, ' ? '));
				return $placeholder;
			}else
			{
				return false;
			}
		}

		private function  dataCount()
		{
			return (count($this->data) != count($this->columns_name)) ? false : true;
		}


		private function WhereClause(string $specific_col = null  , $specific_value = null )
		{
			$Where_status =  (isset($specific_value , $specific_col) && ($specific_value && $specific_col) != null) ?  true :  false;

			if($Where_status)
			{
				$where =" WHERE $specific_col =  $specific_value ";
				return $where;

			}
			throw new Exception("Sorry There Is A problem Please Send Message To Admin At " . CONTACT_EMAIL);
		}


	



		private function prepareStatement(&$item1, $key)
		{
			$item1 = " $key = '$item1'  ";

		}

	


	}