<?php
require_once '../config/database.php';
require_once '../models/Contact.php';

class ContactController {
    private $db;
    private $contact;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->contact = new Contact($this->db);
    }

    // Create a new contact message
    public function createMessage($data) {
        // Validate inputs
        if(empty($data['name']) || empty($data['email']) || empty($data['subject']) || empty($data['message'])) {
            return ['status' => 'error', 'message' => 'Please fill in all required fields.'];
        }
        
        // Validate email
        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['status' => 'error', 'message' => 'Please enter a valid email address.'];
        }
        
        // Set contact data
        $this->contact->name = $data['name'];
        $this->contact->email = $data['email'];
        $this->contact->phone = isset($data['phone']) ? $data['phone'] : '';
        $this->contact->subject = $data['subject'];
        $this->contact->message = $data['message'];
        
        // Create message
        if($this->contact->createMessage()) {
            return ['status' => 'success', 'message' => 'Your message has been sent successfully!'];
        } else {
            return ['status' => 'error', 'message' => 'Failed to send message. Please try again later.'];
        }
    }
}
?>