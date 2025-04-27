<?php
class Contact {
    private $id;
    private $name;
    private $email;
    private $phone;
    private $subject;
    private $message;
    private $date_submitted;

    // Constructor
    public function __construct($data = []) {
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->phone = $data['phone'] ?? '';
        $this->subject = $data['subject'] ?? '';
        $this->message = $data['message'] ?? '';
        $this->date_submitted = date('Y-m-d H:i:s');
    }

    // Getters and setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getDateSubmitted() {
        return $this->date_submitted;
    }

    public function setDateSubmitted($date_submitted) {
        $this->date_submitted = $date_submitted;
    }
}
?>