<?php
class Reservation {
    private $id;
    private $customer_name;
    private $contact_number;
    private $email;
    private $date_reserved;
    private $date_from;
    private $date_to;
    private $room_capacity;
    private $room_type;
    private $payment_type;
    private $special_requests;
    private $num_days;
    private $rate;
    private $discount;
    private $additional_charge;
    private $total_bill;

    // Constructor
    public function __construct($data = []) {
        $this->customer_name = $data['customer_name'] ?? '';
        $this->contact_number = $data['contact_number'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->date_reserved = $data['date_reserved'] ?? '';
        $this->date_from = $data['date_from'] ?? '';
        $this->date_to = $data['date_to'] ?? '';
        $this->room_capacity = $data['room_capacity'] ?? '';
        $this->room_type = $data['room_type'] ?? '';
        $this->payment_type = $data['payment_type'] ?? '';
        $this->special_requests = $data['special_requests'] ?? '';
    }

    // Calculate total bill based on room specifications and stay duration
    public function calculateBill() {
        // Calculate number of days
        $check_in = new DateTime($this->date_from);
        $check_out = new DateTime($this->date_to);
        $interval = $check_in->diff($check_out);
        $this->num_days = $interval->days;

        // Get base rate based on room capacity and type
        $rates = [
            'Single' => [
                'Regular' => 100.00,
                'De Luxe' => 300.00,
                'Suite' => 500.00
            ],
            'Double' => [
                'Regular' => 200.00,
                'De Luxe' => 500.00,
                'Suite' => 800.00
            ],
            'Family' => [
                'Regular' => 500.00,
                'De Luxe' => 750.00,
                'Suite' => 1000.00
            ]
        ];

        // Set the rate
        $this->rate = $rates[$this->room_capacity][$this->room_type];

        // Calculate subtotal
        $subtotal = $this->rate * $this->num_days;

        // Calculate discount (if applicable)
        $this->discount = 0;
        if ($this->payment_type === 'Cash') {
            if ($this->num_days >= 3 && $this->num_days <= 5) {
                // 10% discount for 3-5 days
                $this->discount = $subtotal * 0.10;
            } elseif ($this->num_days >= 6) {
                // 15% discount for 6+ days
                $this->discount = $subtotal * 0.15;
            }
        }

        // Calculate additional charge based on payment type
        $this->additional_charge = 0;
        if ($this->payment_type === 'Check') {
            // 5% additional charge for check
            $this->additional_charge = $subtotal * 0.05;
        } elseif ($this->payment_type === 'Credit Card') {
            // 10% additional charge for credit card
            $this->additional_charge = $subtotal * 0.10;
        }

        // Calculate final total bill
        $this->total_bill = $subtotal - $this->discount + $this->additional_charge;

        return [
            'num_days' => $this->num_days,
            'rate' => $this->rate,
            'subtotal' => $subtotal,
            'discount' => $this->discount,
            'additional_charge' => $this->additional_charge,
            'total_bill' => $this->total_bill
        ];
    }

    // Getters and setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCustomerName() {
        return $this->customer_name;
    }

    public function setCustomerName($customer_name) {
        $this->customer_name = $customer_name;
    }

    public function getContactNumber() {
        return $this->contact_number;
    }

    public function setContactNumber($contact_number) {
        $this->contact_number = $contact_number;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getDateReserved() {
        return $this->date_reserved;
    }

    public function setDateReserved($date_reserved) {
        $this->date_reserved = $date_reserved;
    }

    public function getDateFrom() {
        return $this->date_from;
    }

    public function setDateFrom($date_from) {
        $this->date_from = $date_from;
    }

    public function getDateTo() {
        return $this->date_to;
    }

    public function setDateTo($date_to) {
        $this->date_to = $date_to;
    }

    public function getRoomCapacity() {
        return $this->room_capacity;
    }

    public function setRoomCapacity($room_capacity) {
        $this->room_capacity = $room_capacity;
    }

    public function getRoomType() {
        return $this->room_type;
    }

    public function setRoomType($room_type) {
        $this->room_type = $room_type;
    }

    public function getPaymentType() {
        return $this->payment_type;
    }

    public function setPaymentType($payment_type) {
        $this->payment_type = $payment_type;
    }

    public function getSpecialRequests() {
        return $this->special_requests;
    }

    public function setSpecialRequests($special_requests) {
        $this->special_requests = $special_requests;
    }

    public function getNumDays() {
        return $this->num_days;
    }

    public function getRate() {
        return $this->rate;
    }

    public function getDiscount() {
        return $this->discount;
    }

    public function getAdditionalCharge() {
        return $this->additional_charge;
    }

    public function getTotalBill() {
        return $this->total_bill;
    }
}
?>