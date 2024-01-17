<?php
require_once("Model\config\Connection.php");
require_once("Model\Road\ClassRoad.php");
include_once("Model\city\Classcity.php");

class RoadDao {
    private $db;

    public function __construct(){
        $this->db = DatabaseConnection::getInstance()->getConnection(); 
    }

    public function get_road(){
        $query = "SELECT * FROM Road";
        $stmt = $this->db->query($query);
        $stmt->execute();
        $roadData = $stmt->fetchAll();
        // $cityDAO = new CityDao;
        $roads = array();
        foreach ($roadData as $road) {
            // $startcity = $cityDAO->getCityByName($road['cityname']);
            // $endcity = $cityDAO->getCityByName($road['cityname']);
            $roads[] = new Road($road["distance"], $road["duration"], $road['startcity'], $road['endcity']);
        }
        return $roads;
    }

    public function insert_road($road){
        $query = "INSERT INTO Road VALUES (" . $road->getDistance() . ", '" . $road->getDuration() . "', '" . $road->getStartCity() . "', '" . $road->getEndCity() . "')";
        $stmt = $this->db->prepare($query);
        $result=$stmt->execute();
        return $result;
    }

    public function update_road($road){
        $query = "UPDATE Road SET distance = " . $road->getDistance() . ", duration = '" . $road->getDuration() . "' WHERE startcity = '" . $road->getStartCity() . "' AND endcity = '" . $road->getEndCity() . "'";
        $stmt = $this->db->query($query);
        $stmt->execute();
    }

    public function delete_road($startCity, $endCity){
        $query = "DELETE FROM Road WHERE startcity = '" . $startCity . "' AND endcity = '" . $endCity . "'";
        $stmt = $this->db->query($query);
        $stmt->execute();
    }

    public function getRoadByCities($StartCity, $EndCity){
        $query = "SELECT * FROM Road WHERE startcity = '$StartCity' AND endcity = '$EndCity'";
        $stmt = $this->db->prepare($query);
          $stmt->execute();

        $roadData = $stmt->fetch(); 
       
        // $cityDAO = new CityDao;
        if ($roadData) {
            // $StartCity = $cityDAO->getCityByName($roadData['cityname']);
            // $EndCity = $cityDAO->getCityByName($roadData['cityname']);
            return new Road($roadData["distance"], $roadData["duration"], $roadData['startcity'],$roadData['endcity']);
        }

        return null; 
    }
}
?>