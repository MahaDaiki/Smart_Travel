<?php
require_once("Model\config\Connection.php");

class CityDao {
    private $db;
    
    public function __construct(){
        $this->db = DatabaseConnection::getInstance()->getConnection(); 
    }

    public function get_cities(){
        $query = "SELECT * FROM City";
        $stmt = $this->db->query($query);
        $stmt->execute();
        $cityData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $cityData;
    }
}
?>
