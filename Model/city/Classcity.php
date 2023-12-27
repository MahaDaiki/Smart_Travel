<?php
Class City {
    private $cityname;

public function __construct($cityname){
    $this->cityname=$cityname;
}

    /**
     * Get the value of cityname
     */ 
    public function getCityname()
    {
        return $this->cityname;
    }
}


?>
