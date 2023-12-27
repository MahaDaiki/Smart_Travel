<?php
require_once("Model\Bus\BusDao.php");

class ControllerBus{
    function getbus(){
        $BusDao = new BusDao();
        $Bus = $BusDao->get_bus();
        $busses = $BusDao
        include "View\AddBus.php";
    }
}

?>