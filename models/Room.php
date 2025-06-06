<?php
/**
 * Manages room data
 */
class Room {
    // Database connection and table name
    private $conn;
    private $table_name = "rooms";

    // Room properties
    public $room_id;
    public $room_number;
    public $room_type_id;
    public $room_capacity_id;
    public $rate_per_day;
    public $is_available;

    /**
     * Sets up DB connection
     * @param PDO $db Database connection object
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Gets all rooms
     * @return PDOStatement Query result containing all room details
     */
    public function getAllRooms() {
        $query = "SELECT r.*, rt.room_type, rc.capacity_name 
                 FROM " . $this->table_name . " r
                 JOIN room_types rt ON r.room_type_id = rt.room_type_id
                 JOIN room_capacities rc ON r.room_capacity_id = rc.room_capacity_id
                 ORDER BY r.room_id ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Finds free rooms for dates
     * @param int $capacity_id Room capacity ID
     * @param int $type_id Room type ID
     * @param string $from_date Check-in date
     * @param string $to_date Check-out date
     * @return PDOStatement Query result containing available room details
     */
    public function getAvailableRooms($capacity_id, $type_id, $from_date, $to_date) {
        $query = "SELECT r.*, rt.room_type, rc.capacity_name 
                 FROM " . $this->table_name . " r
                 JOIN room_types rt ON r.room_type_id = rt.room_type_id
                 JOIN room_capacities rc ON r.room_capacity_id = rc.room_capacity_id
                 WHERE r.room_capacity_id = ? AND r.room_type_id = ? AND r.is_available = 1 
                 AND r.room_id NOT IN (
                     SELECT room_id FROM reservations 
                     WHERE (date_from BETWEEN ? AND ?) 
                     OR (date_to BETWEEN ? AND ?)
                     OR (? BETWEEN date_from AND date_to)
                     OR (? BETWEEN date_from AND date_to)
                 )
                 ORDER BY r.room_id ASC
                 LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $capacity_id);
        $stmt->bindParam(2, $type_id);
        $stmt->bindParam(3, $from_date);
        $stmt->bindParam(4, $to_date);
        $stmt->bindParam(5, $from_date);
        $stmt->bindParam(6, $to_date);
        $stmt->bindParam(7, $from_date);
        $stmt->bindParam(8, $to_date);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Gets one room by ID
     * @param int $id Room ID to fetch
     * @return bool True if room found and data loaded, false otherwise
     */
    public function getRoomById($id) {
        $query = "SELECT r.*, rt.room_type, rc.capacity_name 
                 FROM " . $this->table_name . " r
                 JOIN room_types rt ON r.room_type_id = rt.room_type_id
                 JOIN room_capacities rc ON r.room_capacity_id = rc.room_capacity_id
                 WHERE r.room_id = ?
                 LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->room_id = $row['room_id'];
            $this->room_number = $row['room_number'];
            $this->room_type_id = $row['room_type_id'];
            $this->room_capacity_id = $row['room_capacity_id'];
            $this->rate_per_day = $row['rate_per_day'];
            $this->is_available = $row['is_available'];
            return true;
        }
        
        return false;
    }

    /**
     * Shows room prices
     * @return PDOStatement Query result containing room rates
     */
    public function getRoomRates() {
        $query = "SELECT rc.capacity_name, rt.room_type, r.rate_per_day 
                 FROM " . $this->table_name . " r
                 JOIN room_types rt ON r.room_type_id = rt.room_type_id
                 JOIN room_capacities rc ON r.room_capacity_id = rc.room_capacity_id
                 GROUP BY rc.capacity_name, rt.room_type
                 ORDER BY rc.room_capacity_id, rt.room_type_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
?>