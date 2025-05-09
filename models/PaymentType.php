<?php
/**
 * Manages payment methods
 */
class PaymentType {
    // Database connection and table name
    private $conn;
    private $table_name = "payment_types";

    // Payment type properties
    public $payment_type_id;
    public $payment_name;
    public $additional_charge_percentage;

    /**
     * Sets up DB connection
     * @param PDO $db Database connection object
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Shows all payment types
     * @return PDOStatement Query result containing all payment types
     */
    public function getAllPaymentTypes() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY payment_type_id ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Gets one payment type
     * @param int $id Payment type ID to fetch
     * @return PDOStatement Query result containing payment type details
     */
    public function getPaymentTypeById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE payment_type_id = ? LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        return $stmt;
    }
}
?>