<?php 

    require_once 'config/config_BD.php';

    class Database {
        
        private $host = HOST;
        private $database_name = BD;
        private $username = USER;
        private $password = PASSWORD;
        
        public $conn;

        public function getConnection() {
            
            $this->conn = null;
            
            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . 
                                       $this->database_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
                
            } catch ( PDOException $exception ) {
                echo json_encode("Database could not be connected: " . $exception->getMessage());
                die();          
            }    
            
            return $this->conn;
        }
       
        /*
        public function getParams($input)
        {
            $filterParams = [];
            foreach($input as $param => $value)
            {
                $filterParams[] = "$param=:$param";
            }
            
            return implode(", ", $filterParams);
	}
        
        //Asociar todos los parámetros a un sql
	public function bindAllValues($statement, $params)
        {
            foreach($params as $param => $value)
            {
		$statement->bindValue(':'.$param, $value);
            }
            
            return $statement;
        }
     */
    }  // Fin clase  
