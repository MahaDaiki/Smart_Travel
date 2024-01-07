<?php

class ControllerHome
{
    public function index()
    {
        $City = new CityDao();
           $Cities=$City->getAllCities();
    
        include_once 'View\home.php';

    }
}