<?php
require_once("Model\config\Connection.php");
require_once("Model\Bus\ClassBus.php");

class BusDao {
    private $db;
    
    public function __construct(){
        $this->db = DatabaseConnection::getInstance()->getConnection(); 
    }

    public function get_bus(){
        $query = "SELECT * FROM Bus";
        $stmt = $this->db->query($query);
        $stmt->execute();
        $busData = $stmt->fetchAll();
        $buses = array();
        foreach ($busData as $bus) {
            $buses[] = new Bus($bus["busnumber"], $bus["licenseplate"], $bus["capacity"], $bus["companyname"]);
        }
        return $buses;
    }

    public function insert_bus($bus){
        $query = "INSERT INTO Bus VALUES (" . $bus->getBusNumber() . ", '" . $bus->getLicensePlate() . "', " . $bus->getCapacity() . ", '" . $bus->getCompanyName() . "')";
        $stmt = $this->db->query($query);
        $stmt->execute();
    }

    public function update_bus($bus){
        $query = "UPDATE Bus SET licenseplate = '" . $bus->getLicensePlate() . "', capacity = " . $bus->getCapacity() . ", companyname = '" . $bus->getCompanyName() . "' WHERE busnumber = " . $bus->getBusNumber();
        $stmt = $this->db->query($query);
        $stmt->execute();
    }

    public function delete_bus($busnumber){
        $query = "DELETE FROM Bus WHERE busnumber = " . $busnumber;
        $stmt = $this->db->query($query);
        $stmt->execute();
    }
}
?>