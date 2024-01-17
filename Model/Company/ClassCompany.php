<?php
Class Company {
    private $companyname ;
    private $shortname;
    private $img;

    public function __construct($companyname,$shortname,$img){
        $this->companyname=$companyname;
        $this->shortname=$shortname;
        $this->img=$img;
        
    }

    /**
     * Get the value of companyname
     */ 
    public function getCompanyname()
    {
        return $this->companyname;
    }

    /**
     * Get the value of shortname
     */ 
    public function getShortname()
    {
        return $this->shortname;
    }

    /**
     * Get the value of img
     */ 
    public function getImg()
    {
        return $this->img;
    }
    public function test(){
        return $this->companyname;
    }
}

?>