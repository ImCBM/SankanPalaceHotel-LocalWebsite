<?php
/** PDO
 * Manages database connection and initialization
 */
class Database {
    // DB config
    private $host = "localhost";
    private $db_name = "SankanHotel_Database";
    private $username = "root";
    private $password = "";
    private $conn;

    /**
     * Init DB
     */
    public function __construct() {
        $this->checkAndCreateDatabase();
    }

    /**
     * Check DB
     */
    private function checkAndCreateDatabase() {
        try {
            // First connect without database name
            $temp_conn = new PDO("mysql:host=" . $this->host, $this->username, $this->password);
            $temp_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if database exists
            $stmt = $temp_conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$this->db_name}'");
            
            if ($stmt->rowCount() == 0) {
                // Database doesn't exist, create it
                $temp_conn->exec("CREATE DATABASE IF NOT EXISTS {$this->db_name}");
                $temp_conn->exec("USE {$this->db_name}");
                
                // Read and execute the SQL file
                $sql = file_get_contents(__DIR__ . '/../supabase/migrations/SQL_DB_QUERIES.sql');
                $temp_conn->exec($sql);
                
                echo "Database and tables created successfully!";
            }
            
            $temp_conn = null;
        } catch(PDOException $e) {
            echo "Error checking/creating database: " . $e->getMessage();
        }
    }

    /**
     * Get connection
     * @return PDO|null Database connection object or null if connection fails
     */
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>