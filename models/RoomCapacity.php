<?php
class RoomCapacity {
    private $conn;
    private $table_name = "room_capacities";

    public $room_capacity_id;
    public $capacity_name;
    public $max_guests;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all room capacities
    public function getAllRoomCapacities() {
        try {
            $query = "SELECT * FROM " . $this->table_name . " ORDER BY room_capacity_id ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch(PDOException $e) {
            // If room_capacity_id fails, try with id
            $query = "SELECT * FROM " . $this->table_name . " ORDER BY id ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
    }

    // Get room capacity by ID
    public function getRoomCapacityById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE room_capacity_id = ? LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->room_capacity_id = $row['room_capacity_id'];
            $this->capacity_name = $row['capacity_name'];
            $this->max_guests = $row['max_guests'];
            return true;
        }
        
        return false;
    }
}
?>