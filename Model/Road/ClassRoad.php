<?php
Class Road {
    private $distance;
    private $duration;
    private $startcity;
    private $endcity;

public function __construct($distance,$duration,$startcity,$endcity){
    $this->distance = $distance;
    $this->duration = $duration;
    $this->startcity = $startcity;
    $this->endcity = $endcity;
}


    /**
     * Get the value of distance
     */ 
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Get the value of duration
     */ 
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Get the value of startcity
     */ 
    public function getStartcity()
    {
        return $this->startcity;
    }

    /**
     * Get the value of endcity
     */ 
    public function getEndcity()
    {
        return $this->endcity;
    }
}
?>