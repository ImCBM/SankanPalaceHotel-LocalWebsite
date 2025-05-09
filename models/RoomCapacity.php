<?php
/**
 * Manages room sizes
 */
class RoomCapacity {
    // Database connection and table name
    private $conn;
    private $table_name = "room_capacities";

    // Room capacity properties
    public $room_capacity_id;
    public $capacity_name;
    public $max_guests;

    /**
     * Sets up DB connection
     * @param PDO $db Database connection object
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Shows all room sizes
     * @return PDOStatement Query result containing all room capacities
     */
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

    /**
     * Gets one room size
     * @param int $id Room capacity ID to fetch
     * @return bool True if room capacity found and data loaded, false otherwise
     */
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