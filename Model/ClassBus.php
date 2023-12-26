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
}
?>