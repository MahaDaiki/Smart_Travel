<?php
require_once("Model\config\Connection.php");
include_once("Model\city\Classcity.php");

class CityDao {
    private $db;
    
    public function __construct(){
        $this->db = DatabaseConnection::getInstance()->getConnection(); 
    }

    public function getAllCities()
    {
        $query = "SELECT * FROM City";
        $stmt = $this->db->query($query);
        $stmt->execute();
        $cityData = $stmt->fetchAll();
        $cities = array();
        foreach ($cityData as $cityRow) {
            $cities[] = new City($cityRow['cityname']);
        }
       
        
        return $cities;
    }
    public function getCityByName($cityname)
    {
        $query = "SELECT * FROM City WHERE cityname = '$cityname'";
      
        $stmt = $this->db->query($query);
        $stmt->execute();
        $cityData = $stmt->fetch();


        if ($cityData) {
            return new City($cityData['cityname']);
        }

        return null;
    }
}
?>
