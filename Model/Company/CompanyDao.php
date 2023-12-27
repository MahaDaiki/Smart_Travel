<?php
require_once("Model\config\Connection.php");

class CompanyDao {
    private $db;

    public function __construct(){
        $this->db = DatabaseConnection::getInstance()->getConnection(); 
    }

    public function get_companies(){
        $query = "SELECT * FROM Company";
        $stmt = $this->db->query($query);
        $stmt->execute();
        $companyData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $companyData;
    }
}
?>