<?php
class User{
    // database connection and table name
    private $conn;
    private $table_name = "users";

    // object properties
    public $id;
    public $username;
    public $password;
    public $created;
    public $modified;
    public $type;


    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // check if given username exists in the database
    function usernameExists(){

        // query to check if username exists
        $query = "SELECT id, password, type
                FROM " . $this->table_name . "
                WHERE username = ?
                LIMIT 0,1";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->username=htmlspecialchars(strip_tags($this->username));

        // bind the value
        $stmt->bindParam(1, $this->username);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if username exists, assign values to object properties for easy access and use for php sessions
        if($num>0){

            // get record details/values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            $this->id = $row['id'];
            $this->password = $row['password'];
            $this->type = $row['type'];
            // return true because username exists in the database
            return true;
        }

        // return false if username does not exist in the database
        return false;
    }

    // login user
    public function login($password){
        $query = "SELECT id, username, password FROM " . $this->table_name . " WHERE username = :username";
    
        $stmt = $this->conn->prepare($query);
        $this->username=htmlspecialchars(strip_tags($this->username));
    
        $stmt->bindParam(":username", $this->username);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if($row){
            // vérifier si le mot de passe est correct
            $stored_password = $row['password'];
            
            // Comparez le mot de passe entré avec le mot de passe stocké dans la base de données
            if($password == $stored_password){
                $this->id = $row['id'];
                return true;
            }
        }
    
        return false;
    }

    function create() {
        // Query to insert record
        $query = "INSERT INTO " . $this->table_name . " (username, password, type) VALUES (:username, :password, :type)";
    
        // Prepare query
        $stmt = $this->conn->prepare($query);
    
        // Clean data
        $this->username = htmlspecialchars(strip_tags($this->username));
    
        // Set default user type to "client"
        $userType = "client";
    
        // Bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":type", $userType);
    
        // Execute query
        if ($stmt->execute()) {
            return true;
        }
    
        return false;
    }


    function findUserIdByUsername($username) {

        // query to find user by username
        $query = "SELECT id, password, type
                FROM " . $this->table_name . "
                WHERE username = ?
                LIMIT 0,1";
    
        // prepare the query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $username = htmlspecialchars(strip_tags($username));
    
        // bind the value
        $stmt->bindParam(1, $username);
    
        // execute the query
        $stmt->execute();
    
        // get number of rows
        $num = $stmt->rowCount();
    
        // if username exists, return user details
        if($num > 0){
    
            // get record details/values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $localUser = new User($this->conn); // assuming you have a constructor in User class
            $localUser->id = $row['id'];
            $localUser->password = $row['password'];
            $localUser->type = $row['type'];
            $localUser->username = $username;

            // return the local user
            return $localUser->id;
        }
    
        // return false if username does not exist in the database
        return false;
    }
    
    public function type(){
        $query = "SELECT type FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
}
?>
