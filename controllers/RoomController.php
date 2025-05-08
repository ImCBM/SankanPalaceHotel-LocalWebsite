<?php
require_once '../config/database.php';
require_once '../models/Room.php';
require_once '../models/RoomType.php';
require_once '../models/RoomCapacity.php';

class RoomController {
    private $db;
    private $room;
    private $roomType;
    private $roomCapacity;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->room = new Room($this->db);
        $this->roomType = new RoomType($this->db);
        $this->roomCapacity = new RoomCapacity($this->db);
    }

    // Get all rooms
    public function getAllRooms() {
        $stmt = $this->room->getAllRooms();
        $rooms = [];
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rooms[] = $row;
        }
        
        return $rooms;
    }

    // Get all room types
    public function getAllRoomTypes() {
        $stmt = $this->roomType->getAllRoomTypes();
        $roomTypes = [];
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $roomTypes[] = $row;
        }
        
        return $roomTypes;
    }

    // Get all room capacities
    public function getAllRoomCapacities() {
        $stmt = $this->roomCapacity->getAllRoomCapacities();
        $roomCapacities = [];
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $roomCapacities[] = $row;
        }
        
        return $roomCapacities;
    }

    // Get available rooms
    public function getAvailableRooms($capacity_id, $type_id, $from_date, $to_date) {
        $stmt = $this->room->getAvailableRooms($capacity_id, $type_id, $from_date, $to_date);
        if($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    // Get room rates
    public function getRoomRates() {
        $stmt = $this->room->getRoomRates();
        $rates = [];
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rates[] = $row;
        }
        
        return $rates;
    }
}
?>