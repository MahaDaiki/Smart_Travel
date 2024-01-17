<?php
require_once("Model\config\Connection.php");
require_once("Model\Bus\ClassBus.php");
include_once("Model\Company\CompanyDao.php");

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
        $companyDAO = new CompanyDAO();
        $buses = array();
       
        foreach ($busData as $bus) { 
            // $company = $companyDAO->getCompanyByName($bus['companyname']);
        
            $buses[] = new Bus($bus["busnumber"], $bus["licenseplate"], $bus["capacity"], $bus["companyname"]);
        }
        return $buses;
    }

    public function getbusbyid($busnumber){
        $query = "SELECT * FROM Bus where busnumber = $busnumber";
        $stmt = $this->db->query($query);
        $stmt->execute();
        $busData = $stmt->fetch();
        $companyDAO = new CompanyDAO();
      
      
        if ($busData) {
            $company = $companyDAO->getCompanyByName($busData['companyname']);
            
            return new Bus($busData["busnumber"], $busData["licenseplate"], $busData["capacity"], $company);
        }
        return NULL;
         
    }
    public function insert_bus($bus){
        $query = "INSERT INTO Bus (licenseplate , capacity , companyname) VALUES ( '" . $bus->getLicenseplate() . "', " . $bus->getCapacity() . ", '" . $bus->getCompanyName() . "')";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }

    public function update_bus($bus){
        $query = "UPDATE Bus  SET licensePlate = '" . $bus->getLicenseplate() . "', capacity = " . $bus->getCapacity() . ",companyname = '" . $bus->getCompanyName() . "'  WHERE busnumber = " . $bus->getBusNumber();
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