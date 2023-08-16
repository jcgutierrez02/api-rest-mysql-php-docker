<?php
    class Employee{

        // Connection
        private $conn;

        // Table
        private $db_table = "employee";

        // Columns
        public $id;
        public $name;
        public $email;
        public $age;
        public $designation;
        public $perfil;
        public $created;

        // Db connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // GET ALL
        public function getEmployees() {
            $sqlQuery = "SELECT * FROM " . $this->db_table . "";
            
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
        
            return $stmt;
        }

        // CREATE
        public function createEmployee() {
            
            $sqlQuery = "INSERT INTO ". $this->db_table .
                    " (name, email, age, designation, perfil, created) " .
                    " VALUES (:name, :email, :age, :designation, :perfil, :created)";
        
            $stmt = $this->conn->prepare($sqlQuery);
            
            // $stmt = $database->bindAllValues($stmt, $input);

            $archivo = null;
            if ( isset($this->perfil )) {
                $archivo = file_get_contents("./$this->perfil"); 
            }
        
            $rows = $stmt->execute( array( ':name' => $this->name,
                                         ':email' => $this->email,
                                         ':age' => $this->age,
                                        ':designation' => $this->designation,
                                        ':perfil' => $archivo,
                                        ':created' => $this->created
            ));
            
            if ( $rows == 1 ) {
               return true;
            }
            return false;
        }

        // READ single
        public function getSingleEmployee() {
            $sqlQuery = "SELECT * FROM " . $this->db_table . 
                        " WHERE id = ?";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();
            
            if ( $stmt->rowCount() > 0 ) {  // id Empleado existe
                
                $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

                $datosperfil = null;
                if ( isset($dataRow['perfil']) )
                    $datosperfil = base64_encode($dataRow['perfil']);
            
                $this->name = $dataRow['name'];
                $this->email = $dataRow['email'];
                $this->age = $dataRow['age'];
                $this->designation = $dataRow['designation'];
                $this->perfil = $datosperfil;
                $this->created = $dataRow['created'];
            }
        }    

        // UPDATE
        public function updateEmployee() {
            
            $sqlQuery = "UPDATE " . $this->db_table .
                        " SET
                            name = :name, 
                            email = :email, 
                            age = :age, 
                            designation = :designation, 
                            perfil = :perfil,
                            created = :created " .
                        " WHERE 
                            id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);

            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->age = htmlspecialchars(strip_tags($this->age));
            $this->designation = htmlspecialchars(strip_tags($this->designation));
            $this->created = htmlspecialchars(strip_tags($this->created));
            $this->id = htmlspecialchars(strip_tags($this->id));
        
           // $archivo = null;
           // if ( isset($this->perfil )) {
           //     $archivo = file_get_contents($this->perfil); 
           // }

            $rows = $stmt->execute( array( ':name' => $this->name,
                ':email' => $this->email,
                ':age' => $this->age,
                ':designation' => $this->designation,
                ':perfil' => $this->perfil,
                ':created' => $this->created,
                ':id' => $this->id
            ));

                   
            $stmt->execute();
            
            if ( $rows == 1 ) {
                return true;
            }
            return false;
        }

        // DELETE
        function deleteEmployee() {
            
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id = htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
            
            $stmt->execute();
        
            if ( $stmt->rowCount() > 0 ) {
               return true;
            }   
            
            return false;
        }
    }
