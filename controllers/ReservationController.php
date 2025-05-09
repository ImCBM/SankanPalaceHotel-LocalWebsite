<?php
require_once '../config/database.php';
require_once '../models/Reservation.php';
require_once '../models/Customer.php';
require_once '../models/Room.php';
require_once '../models/PaymentType.php';

/**
 * Handles all reservation-related operations including creation, payment calculations,
 * and customer management
 */
class ReservationController {
    private $db;
    private $reservation;
    private $customer;
    private $room;
    private $paymentType;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->reservation = new Reservation($this->db);
        $this->customer = new Customer($this->db);
        $this->room = new Room($this->db);
        $this->paymentType = new PaymentType($this->db);
    }

    /**
     * Retrieves all available payment methods from the database
     * @return array List of payment types with their details
     */
    public function getAllPaymentTypes() {
        $stmt = $this->paymentType->getAllPaymentTypes();
        $paymentTypes = [];
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $paymentTypes[] = $row;
        }
        
        return $paymentTypes;
    }

    /**
     * Calculates the total bill including discounts and additional charges
     * @param float $roomRate Base rate per night
     * @param int $numNights Number of nights staying
     * @param int $paymentTypeId Selected payment method ID
     * @return array Bill details including subtotal, discount, and final amount
     */
    public function calculateBill($roomRate, $numNights, $paymentTypeId) {
        // Get payment type details
        $stmt = $this->paymentType->getPaymentTypeById($paymentTypeId);
        $paymentType = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$paymentType) {
            return [
                'status' => 'error',
                'message' => 'Invalid payment type'
            ];
        }
        
        // Calculate bill using the model
        $bill = $this->reservation->calculateBill($roomRate, $numNights, $paymentType);
        
        return [
            'status' => 'success',
            'data' => $bill
        ];
    }

    /**
     * Creates a new reservation with customer details, room selection, and payment info
     * @param array $data Reservation details including customer info, dates, room preferences
     * @return array Status of reservation creation with booking details
     */
    public function createReservation($data) {
        // First, handle customer data
        $this->customer->customer_name = $data['name'];
        $this->customer->contact_number = $data['phone'];
        $this->customer->email = $data['email'];
        
        // Check if customer already exists
        if($this->customer->checkCustomerExists()) {
            $customer_id = $this->customer->customer_id;
        } else {
            // Create new customer
            if($this->customer->createCustomer()) {
                $customer_id = $this->customer->customer_id;
            } else {
                return ['status' => 'error', 'message' => 'Failed to create customer record.'];
            }
        }
        
        // Validate room information
        if(!isset($data['room_capacity']) || !isset($data['room_type']) || !isset($data['payment_type'])) {
            return ['status' => 'error', 'message' => 'Please select room capacity, room type, and payment type.'];
        }
        
        // Validate dates
        if(!isset($data['date_from']) || !isset($data['date_to'])) {
            return ['status' => 'error', 'message' => 'Please select valid dates for your reservation.'];
        }
        
        $date_from = date('Y-m-d', strtotime($data['date_from']));
        $date_to = date('Y-m-d', strtotime($data['date_to']));
        $date_reserved = date('Y-m-d');
        
        // Check that check-out date is after check-in date
        if(strtotime($date_to) <= strtotime($date_from)) {
            return ['status' => 'error', 'message' => 'Check-out date must be after check-in date.'];
        }
        
        // Calculate number of days
        $num_days = (strtotime($date_to) - strtotime($date_from)) / (60 * 60 * 24);
        
        // Check for available room
        $stmt = $this->room->getAvailableRooms($data['room_capacity'], $data['room_type'], $date_from, $date_to);
        if($stmt->rowCount() === 0) {
            return ['status' => 'error', 'message' => 'No rooms available for the selected dates, capacity, and type.'];
        }
        $room = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Get payment type details
        $stmt = $this->paymentType->getPaymentTypeById($data['payment_type']);
        if($stmt->rowCount() === 0) {
            return ['status' => 'error', 'message' => 'Invalid payment type.'];
        }
        $paymentType = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Calculate the bill
        $bill = $this->reservation->calculateBill($room['rate_per_day'], $num_days, $paymentType);
        
        // Set reservation data
        $this->reservation->customer_id = $customer_id;
        $this->reservation->room_id = $room['room_id'];
        $this->reservation->date_reserved = $date_reserved;
        $this->reservation->date_from = $date_from;
        $this->reservation->date_to = $date_to;
        $this->reservation->payment_type_id = $data['payment_type'];
        $this->reservation->special_requests = isset($data['special_requests']) ? $data['special_requests'] : '';
        $this->reservation->num_days = $num_days;
        $this->reservation->subtotal = $bill['subtotal'];
        $this->reservation->discount = $bill['discount'];
        $this->reservation->additional_charge = $bill['additional_charge'];
        $this->reservation->total_bill = $bill['total_bill'];
        
        // Create reservation
        if($this->reservation->createReservation()) {
            return [
                'status' => 'success',
                'message' => 'Reservation created successfully!',
                'reservation_id' => $this->reservation->reservation_id,
                'customer_name' => $this->customer->customer_name,
                'room_number' => $room['room_number'],
                'room_type' => $room['room_type'],
                'capacity' => $room['capacity_name'],
                'date_from' => $date_from,
                'date_to' => $date_to,
                'num_days' => $num_days,
                'payment_type' => $paymentType['payment_name'],
                'subtotal' => $bill['subtotal'],
                'discount' => $bill['discount'],
                'additional_charge' => $bill['additional_charge'],
                'total_bill' => $bill['total_bill']
            ];
        } else {
            return ['status' => 'error', 'message' => 'Failed to create reservation.'];
        }
    }
}
?>