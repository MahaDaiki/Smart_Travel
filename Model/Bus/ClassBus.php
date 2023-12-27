<?php
Class Bus{
    private $busnumber;
    private $licenseplate;
    private $capacity;
    private $companyname;

    public function __construct($busnumber,$licenseplate,$capacity,$companyname){
        $this->busnumber = $busnumber;
        $this->licenseplate = $licenseplate;
        $this->capacity = $capacity;
        $this->companyname = $companyname;

    }

    /**
     * Get the value of busnumber
     */ 
    public function getBusnumber()
    {
        return $this->busnumber;
    }

    /**
     * Get the value of licenseplate
     */ 
    public function getLicenseplate()
    {
        return $this->licenseplate;
    }

    /**
     * Get the value of capacity
     */ 
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Get the value of companyname
     */ 
    public function getCompanyname()
    {
        return $this->companyname;
    }
}
?>