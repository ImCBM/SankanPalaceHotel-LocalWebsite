<?php
class RoomType {
    private $conn;
    private $table_name = "room_types";

    public $room_type_id;
    public $room_type;
    public $description;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all room types
    public function getAllRoomTypes() {
        try {
            $query = "SELECT * FROM " . $this->table_name . " ORDER BY room_type_id ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch(PDOException $e) {
            // If room_type_id fails, try with id
            $query = "SELECT * FROM " . $this->table_name . " ORDER BY id ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
    }

    // Get room type by ID
    public function getRoomTypeById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE room_type_id = ? LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->room_type_id = $row['room_type_id'];
            $this->room_type = $row['room_type'];
            $this->description = $row['description'];
            return true;
        }
        
        return false;
    }
}
?>