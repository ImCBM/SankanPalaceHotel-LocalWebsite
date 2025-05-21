<?php
require_once '../config/database.php';
require_once '../models/Admin.php';
require_once '../models/Room.php';
require_once '../models/Reservation.php';
require_once '../models/Customer.php';

class AdminController {
    private $db;
    private $admin;
    private $room;
    private $reservation;
    private $customer;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->admin = new Admin($this->db);
        $this->room = new Room($this->db);
        $this->reservation = new Reservation($this->db);
        $this->customer = new Customer($this->db);
    }

    public function login($username, $password) {
        // Default admin credentials check
        if($username === 'admin' && $password === 'admin123') {
            $_SESSION['admin_id'] = 1;
            $_SESSION['admin_username'] = 'admin';
            return true;
        }
        return false;
    }

    public function getAllReservations() {
        $query = "SELECT r.*, c.customer_name, c.email, c.contact_number, 
                        rm.room_number, rt.room_type, rc.capacity_name 
                 FROM reservations r
                 JOIN customers c ON r.customer_id = c.customer_id
                 JOIN rooms rm ON r.room_id = rm.room_id
                 JOIN room_types rt ON rm.room_type_id = rt.room_type_id
                 JOIN room_capacities rc ON rm.room_capacity_id = rc.room_capacity_id
                 ORDER BY r.date_reserved DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getReservationById($id) {
        $query = "SELECT r.*, c.customer_name, c.email, c.contact_number, 
                        rm.room_number, rt.room_type, rc.capacity_name 
                 FROM reservations r
                 JOIN customers c ON r.customer_id = c.customer_id
                 JOIN rooms rm ON r.room_id = rm.room_id
                 JOIN room_types rt ON rm.room_type_id = rt.room_type_id
                 JOIN room_capacities rc ON rm.room_capacity_id = rc.room_capacity_id
                 WHERE r.reservation_id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateReservation($data) {
        try {
            $this->db->beginTransaction();
            
            // Update customer information
            $stmt = $this->db->prepare("UPDATE customers SET 
                customer_name = ?, email = ?, contact_number = ?
                WHERE customer_id = ?");
            $stmt->execute([
                $data['name'],
                $data['email'],
                $data['phone'],
                $data['customer_id']
            ]);
            
            // Update reservation
            $stmt = $this->db->prepare("UPDATE reservations SET 
                date_from = ?, date_to = ?, special_requests = ?,
                num_days = ?, subtotal = ?, discount = ?,
                additional_charge = ?, total_bill = ?
                WHERE reservation_id = ?");
            $stmt->execute([
                $data['date_from'],
                $data['date_to'],
                $data['special_requests'],
                $data['num_days'],
                $data['subtotal'],
                $data['discount'],
                $data['additional_charge'],
                $data['total_bill'],
                $data['reservation_id']
            ]);
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function deleteReservation($id) {
        $query = "DELETE FROM reservations WHERE reservation_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }
}
?>