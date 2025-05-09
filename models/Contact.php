<?php
/**
 * Stores guest messages
 */
class Contact {
    // Database connection and table name
    private $conn;
    private $table_name = "contact_messages";

    // Contact message properties
    public $message_id;
    public $name;
    public $email;
    public $phone;
    public $subject;
    public $message;
    public $date_submitted;

    /**
     * Sets up DB connection
     * @param PDO $db Database connection object
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Saves message to DB
     * @return bool True if message was created successfully, false otherwise
     */
    public function createMessage() {
        $query = "INSERT INTO " . $this->table_name . " 
                (name, email, phone, subject, message) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize inputs
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->subject = htmlspecialchars(strip_tags($this->subject));
        $this->message = htmlspecialchars(strip_tags($this->message));
        
        // Bind values
        $stmt->bindParam(1, $this->name);
        $stmt->bindParam(2, $this->email);
        $stmt->bindParam(3, $this->phone);
        $stmt->bindParam(4, $this->subject);
        $stmt->bindParam(5, $this->message);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}
?>