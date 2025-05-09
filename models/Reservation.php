<?php
/**
 * Manages bookings
 */
class Reservation {
    // Database connection and table name
    private $conn;
    private $table_name = "reservations";

    // Reservation properties
    public $reservation_id;
    public $customer_id;
    public $room_id;
    public $date_reserved;
    public $date_from;
    public $date_to;
    public $payment_type_id;
    public $special_requests;
    public $num_days;
    public $subtotal;
    public $discount;
    public $additional_charge;
    public $total_bill;

    /**
     * Sets up DB connection
     * @param PDO $db Database connection object
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Saves booking to DB
     * @return bool True if reservation was created successfully, false otherwise
     */
    public function createReservation() {
        $query = "INSERT INTO " . $this->table_name . " 
                (customer_id, room_id, date_reserved, date_from, date_to, payment_type_id, 
                special_requests, num_days, subtotal, discount, additional_charge, total_bill) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize inputs
        $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));
        $this->room_id = htmlspecialchars(strip_tags($this->room_id));
        $this->date_reserved = htmlspecialchars(strip_tags($this->date_reserved));
        $this->date_from = htmlspecialchars(strip_tags($this->date_from));
        $this->date_to = htmlspecialchars(strip_tags($this->date_to));
        $this->payment_type_id = htmlspecialchars(strip_tags($this->payment_type_id));
        $this->special_requests = htmlspecialchars(strip_tags($this->special_requests));
        $this->num_days = htmlspecialchars(strip_tags($this->num_days));
        $this->subtotal = htmlspecialchars(strip_tags($this->subtotal));
        $this->discount = htmlspecialchars(strip_tags($this->discount));
        $this->additional_charge = htmlspecialchars(strip_tags($this->additional_charge));
        $this->total_bill = htmlspecialchars(strip_tags($this->total_bill));
        
        // Bind values
        $stmt->bindParam(1, $this->customer_id);
        $stmt->bindParam(2, $this->room_id);
        $stmt->bindParam(3, $this->date_reserved);
        $stmt->bindParam(4, $this->date_from);
        $stmt->bindParam(5, $this->date_to);
        $stmt->bindParam(6, $this->payment_type_id);
        $stmt->bindParam(7, $this->special_requests);
        $stmt->bindParam(8, $this->num_days);
        $stmt->bindParam(9, $this->subtotal);
        $stmt->bindParam(10, $this->discount);
        $stmt->bindParam(11, $this->additional_charge);
        $stmt->bindParam(12, $this->total_bill);
        
        if($stmt->execute()) {
            // Get the last inserted ID
            $this->reservation_id = $this->conn->lastInsertId();
            return true;
        }
        
        return false;
    }

    /**
     * Works out total bill
     * @param float $room_rate Daily room rate
     * @param int $num_days Number of days staying
     * @param array $payment_type Payment type details including additional charge percentage
     * @return array Bill breakdown including subtotal, additional charge, discount, and total
     */
    public function calculateBill($room_rate, $num_days, $payment_type) {
        // Calculate subtotal
        $subtotal = $room_rate * $num_days;
        
        // Calculate additional charge
        $additional_charge = ($subtotal * $payment_type['additional_charge_percentage']) / 100;
        
        // Calculate discount (only for cash payment)
        $discount = 0;
        if($payment_type['payment_name'] == 'Cash') {
            if($num_days >= 3 && $num_days <= 5) {
                $discount = ($subtotal * 10) / 100; // 10% discount
            } else if($num_days >= 6) {
                $discount = ($subtotal * 15) / 100; // 15% discount
            }
        }
        
        // Calculate total bill
        $total_bill = $subtotal + $additional_charge - $discount;
        
        return [
            'subtotal' => $subtotal,
            'additional_charge' => $additional_charge,
            'discount' => $discount,
            'total_bill' => $total_bill
        ];
    }
}
?>