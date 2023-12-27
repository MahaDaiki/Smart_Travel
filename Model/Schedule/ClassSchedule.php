<?php
Class Schedule{
    private $id;
    private $date;
    private $departuretime;
    private $arrivaltime;
    private $availableseats;
    private $price;
    private $busnumber;
    private $startcity;
    private $endcity;
    public function __construct($id,$date,$departuretime,$arrivaltime,$availableseats,$price,$busnumber,$startcity,$endcity){
        $this->id = $id;
        $this->date = $date;
        $this->departuretime =$departuretime;
        $this->arrivaltime =$arrivaltime;
        $this->availableseats = $availableseats;
        $this->price = $price;
        $this->busnumber = $busnumber;
        $this->startcity = $startcity;
        $this->endcity = $endcity;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get the value of departuretime
     */ 
    public function getDeparturetime()
    {
        return $this->departuretime;
    }

    /**
     * Get the value of arrivaltime
     */ 
    public function getArrivaltime()
    {
        return $this->arrivaltime;
    }

    /**
     * Get the value of availableseats
     */ 
    public function getAvailableseats()
    {
        return $this->availableseats;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get the value of busnumber
     */ 
    public function getBusnumber()
    {
        return $this->busnumber;
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