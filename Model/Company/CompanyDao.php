<?php
require_once("Model\config\Connection.php");
include_once("Model\Company\ClassCompany.php");

class CompanyDao {
    private $db;

    public function __construct(){
        $this->db = DatabaseConnection::getInstance()->getConnection(); 
    }

    public function getAllCompanies()
    {
        $query = "SELECT * FROM Company";
        $stmt = $this->db->query($query);
        $stmt->execute();
        $companyData = $stmt->fetchAll();
        
        $companies = array();
        foreach ($companyData as $companyRow) {
            $companies[] = new Company($companyRow['companyname'], $companyRow['shortname'], $companyRow['img']);
        }

        return $companies;
    }

    public function getCompanyByName($companyName)
    {
        $query = "SELECT * FROM Company WHERE companyName = '$companyName'";
        $stmt = $this->db->query($query);
        $stmt->execute();
        $companyData = $stmt->fetch();

        if ($companyData) {
            return new Company($companyData['companyname'], $companyData['shortname'], $companyData['img']);
        }

        return null; 
    }
    public function getCompanybyBusNumber($number){
        $query ="SELECT company.companyname , company.shortname,company.img FROM company 
        INNER JOIN `bus` ON `bus`.companyname = `company`.companyname
        INNER join schedule  ON `schedule`.busnumber = `bus`.busnumber
        WHERE schedule.busnumber = $number  limit 1";

        $stmt = $this->db->query($query);
        $stmt->execute();
        $companyname = $stmt->fetch();
        if($companyname){
            return new company($companyname['companyname'],$companyname['shortname'],$companyname['img']);
        }

    }
}
?>