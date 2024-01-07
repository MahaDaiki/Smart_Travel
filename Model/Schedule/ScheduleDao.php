<?php
require_once("Model\config\Connection.php");
require_once("Model\Schedule\ClassSchedule.php");

class ScheduleDao {
    private $db;

    public function __construct(){
        $this->db = DatabaseConnection::getInstance()->getConnection(); 
    }

    public function get_schedule(){
        $query = "SELECT * FROM Schedule";
        $stmt = $this->db->query($query);
        $stmt->execute();
        $scheduleData = $stmt->fetchAll();
        $schedules = array();
        $CityDao = new RoadDao(); // Assuming you have a CityDao class
        $BusDao = new BusDao();

        foreach ($scheduleData as $schedule) {
            $busnumber= $BusDao->getbusbyid($schedule["busnumber"]);
            $startCity = $CityDao->getRoadByCities($schedule["startcity"],["endcity"]); 
            $endCity = $CityDao->getRoadByCities($schedule["startcity"],["endcity"]); 
    
            $schedules[] = new Schedule(
                $schedule["id"],
                $schedule["date"],
                $schedule["departuretime"],
                $schedule["arrivaltime"],
                $schedule["availableseats"],
                $schedule["price"],
                $busnumber,
                $startCity,
                $endCity
            );
        }
    
        return $schedules;
    }
    public function get_schedule_by_id($scheduleId) {
        $query = "SELECT * FROM Schedule WHERE id = :scheduleId";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':scheduleId' => $scheduleId]);
        $scheduleData = $stmt->fetch();
    
        if (!$scheduleData) {
            return null; // Schedule not found
        }
    
        $CityDao = new RoadDao(); // Assuming you have a CityDao class
        $BusDao = new BusDao();
    
        $busnumber = $BusDao->getbusbyid($scheduleData["busnumber"]);
        $startCity = $CityDao->getRoadByCities($scheduleData["startcity"], $scheduleData["endcity"]);
        $endCity = $CityDao->getRoadByCities($scheduleData["endcity"],$scheduleData["endcity"]);
    
        return new Schedule(
            $scheduleData["id"],
            $scheduleData["date"],
            $scheduleData["departuretime"],
            $scheduleData["arrivaltime"],
            $scheduleData["availableseats"],
            $scheduleData["price"],
            $busnumber,
            $startCity,
            $endCity
        );
    }
    

    public function insert_schedule($schedule){
        $query = "INSERT INTO Schedule (date, departuretime, arrivaltime, availableseats, price, busnumber, startcity, endcity) VALUES (
            '" . $schedule->getDate() . "',
            '" . $schedule->getDepartureTime() . "',
            '" . $schedule->getArrivalTime() . "',
            " . $schedule->getAvailableSeats() . ",
            " . $schedule->getPrice() . ",
            " . $schedule->getBusNumber() . ",
            '" . $schedule->getStartCity() . "',
            '" . $schedule->getEndCity() . "'
        )";
        $stmt = $this->db->query($query);
        $stmt->execute();
    }

    public function update_schedule($schedule){
        $query = "UPDATE Schedule SET 
            date = '" . $schedule->getDate() . "',
            departuretime = '" . $schedule->getDepartureTime() . "',
            arrivaltime = '" . $schedule->getArrivalTime() . "',
            availableseats = " . $schedule->getAvailableSeats() . ",
            price = " . $schedule->getPrice() . ",
            busnumber = " . $schedule->getBusNumber() . ",
            startcity = '" . $schedule->getStartCity() . "',
            endcity = '" . $schedule->getEndCity() . "'
            WHERE id = " . $schedule->getId();
        $stmt = $this->db->query($query);
        $stmt->execute();
    }

    public function delete_schedule($id){
        $query = "DELETE FROM Schedule WHERE id = " . $id;
        $stmt = $this->db->query($query);
        $stmt->execute();
    }
    public function get_schedule_by_cities($startCity, $endCity,$date, $availableseats){
        $query = "SELECT Schedule.*, Road.*, Company.img AS companyimg
            FROM Schedule
            INNER JOIN Route ON Schedule.startcity = Road.startcity and schedule.endcity = road.endcity
            INNER JOIN Bus ON Schedule.busnumber = Bus.busnumber
            INNER JOIN Company ON Bus.companyname = Company.companyname
            WHERE Schedule.date >= :date
            AND Schedule.availableSeats >= :places
            AND Route.startCity = :startCity
            AND Route.endCity = :endCity";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':startCity' => $startCity, ':endCity' => $endCity]);
        $scheduleData = $stmt->fetchAll();
        
        $schedules = array();
        $CityDao = new RoadDao(); 
        $BusDao = new BusDao();
    
        foreach ($scheduleData as $schedule) {
            $busnumber = $BusDao->getbusbyid($schedule["busnumber"]);
            $startCity = $CityDao->getRoadByCities($schedule["StartCity"], $schedule["EndCity"]);
            $endCity = $CityDao->getRoadByCities($schedule["EndCity"], $schedule["EndCity"]);
    
            $schedules[] = new Schedule(
                $schedule["id"],
                $schedule["date"],
                $schedule["departuretime"],
                $schedule["arrivaltime"],
                $schedule["availableseats"],
                $schedule["price"],
                $busnumber,
                $startCity,
                $endCity
            );
        }
    
        return $schedules;
    }
    
    
    
}
?>