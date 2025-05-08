<?php
class Customer {
    private $conn;
    private $table_name = "customers";

    public $customer_id;
    public $customer_name;
    public $contact_number;
    public $email;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new customer
    public function createCustomer() {
        $query = "INSERT INTO " . $this->table_name . " 
                (customer_name, contact_number, email) 
                VALUES (?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize inputs
        $this->customer_name = htmlspecialchars(strip_tags($this->customer_name));
        $this->contact_number = htmlspecialchars(strip_tags($this->contact_number));
        $this->email = htmlspecialchars(strip_tags($this->email));
        
        // Bind values
        $stmt->bindParam(1, $this->customer_name);
        $stmt->bindParam(2, $this->contact_number);
        $stmt->bindParam(3, $this->email);
        
        if($stmt->execute()) {
            // Get the last inserted ID
            $this->customer_id = $this->conn->lastInsertId();
            return true;
        }
        
        return false;
    }

    // Check if customer exists by email
    public function checkCustomerExists() {
        $query = "SELECT customer_id FROM " . $this->table_name . " WHERE email = ? LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->email);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->customer_id = $row['customer_id'];
            return true;
        }
        
        return false;
    }
}
?>