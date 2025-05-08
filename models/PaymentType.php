<?php
class PaymentType {
    private $conn;
    private $table_name = "payment_types";

    public $payment_type_id;
    public $payment_name;
    public $additional_charge_percentage;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all payment types
    public function getAllPaymentTypes() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY payment_type_id ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Get payment type by ID
    public function getPaymentTypeById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE payment_type_id = ? LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->payment_type_id = $row['payment_type_id'];
            $this->payment_name = $row['payment_name'];
            $this->additional_charge_percentage = $row['additional_charge_percentage'];
            return true;
        }
        
        return false;
    }
}
?>