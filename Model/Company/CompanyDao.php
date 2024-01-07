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
}
?>