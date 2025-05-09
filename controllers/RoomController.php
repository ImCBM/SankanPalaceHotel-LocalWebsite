<?php
require_once '../config/database.php';
require_once '../models/Room.php';
require_once '../models/RoomType.php';
require_once '../models/RoomCapacity.php';

/**
 * Handles room info
 */
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

    /**
     * Shows all rooms from DB
     * @return array List of all rooms in the hotel
     */
    public function getAllRooms() {
        // Fetch all rooms with their current status and details
        $stmt = $this->room->getAllRooms();
        $rooms = [];
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rooms[] = $row;
        }
        
        return $rooms;
    }

    /**
     * Shows room types (Standard, Deluxe, etc.)
     * @return array List of room types with their descriptions
     */
    public function getAllRoomTypes() {
        // Retrieve all room categories and their descriptions
        $stmt = $this->roomType->getAllRoomTypes();
        $roomTypes = [];
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $roomTypes[] = $row;
        }
        
        return $roomTypes;
    }

    /**
     * Shows room sizes (Single, Double, Family)
     * @return array List of room capacities with their details
     */
    public function getAllRoomCapacities() {
        // Get all room capacity options with their details
        $stmt = $this->roomCapacity->getAllRoomCapacities();
        $roomCapacities = [];
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $roomCapacities[] = $row;
        }
        
        return $roomCapacities;
    }

    /**
     * Checks rooms based on dates
     * @param int $capacity_id Desired room capacity
     * @param int $type_id Desired room type
     * @param string $from_date Check-in date
     * @param string $to_date Check-out date
     * @return array|false Available room details or false if none found
     */
    public function getAvailableRooms($capacity_id, $type_id, $from_date, $to_date) {
        // Query for rooms matching criteria and available in date range
        $stmt = $this->room->getAvailableRooms($capacity_id, $type_id, $from_date, $to_date);
        if($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    /**
     * Shows room prices
     * @return array List of room rates with their conditions
     */
    public function getRoomRates() {
        // Fetch current pricing for all room configurations
        $stmt = $this->room->getRoomRates();
        $rates = [];
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rates[] = $row;
        }
        
        return $rates;
    }
}
?>