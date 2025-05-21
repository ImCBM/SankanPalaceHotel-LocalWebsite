<?php
class Admin {
    private $conn;
    private $table_name = "admin_users";

    public $admin_id;
    public $username;
    public $password;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($username, $password) {
        $query = "SELECT admin_id, username, password FROM " . $this->table_name . " 
                  WHERE username = ? LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $username);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password, $row['password'])) {
                $this->admin_id = $row['admin_id'];
                $this->username = $row['username'];
                return true;
            }
        }
        return false;
    }
}
?>