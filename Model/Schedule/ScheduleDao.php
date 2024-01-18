<?php
require_once("Model\config\Connection.php");
require_once("Model\Schedule\ClassSchedule.php");
include_once("Model\Company\CompanyDao.php");

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
        // $CityDao = new RoadDao(); 
        // $BusDao = new BusDao();

        foreach ($scheduleData as $schedule) {
            // $busnumber= $BusDao->getbusbyid($schedule["busnumber"]);
            // $startCity = $CityDao->getRoadByCities($schedule["startcity"],["endcity"]); 
            // $endCity = $CityDao->getRoadByCities($schedule["startcity"],["endcity"]); 
    
            $schedules[] = new Schedule(
                $schedule["id"],
                $schedule["date"],
                $schedule["departuretime"],
                $schedule["arrivaltime"],
                $schedule["availableseats"],
                $schedule["price"],
                $schedule["busnumber"],
                $schedule["startcity"],
                $schedule["endcity"]
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
        $stmt = $this->db->prepare($query);
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
        $query = "SELECT Schedule.*, Road.*
            FROM Schedule
            INNER JOIN Road ON Schedule.startcity = Road.startcity and schedule.endcity = road.endcity
            INNER JOIN Bus ON Schedule.busnumber = Bus.busnumber
            WHERE Schedule.date = '$date'
            AND Schedule.availableSeats >= '$availableseats'
            AND Road.startCity = '$startCity'
            AND Road.endCity = '$endCity'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $scheduleData = $stmt->fetchAll();
        
        $schedules = array();
        $company = array();

        // $CityDao = new RoadDao(); 
        // $BusDao = new BusDao();
    $companyDAO = new  CompanyDao();
        foreach ($scheduleData as $schedule) {
            // $busnumber = $BusDao->getbusbyid($schedule["busnumber"]);
            // $startCity = $CityDao->getRoadByCities($schedule["StartCity"], $schedule["EndCity"]);
            // $endCity = $CityDao->getRoadByCities($schedule["EndCity"], $schedule["EndCity"]);
    
            $schedules[] = new Schedule(
                $schedule["id"],
                $schedule["date"],
                $schedule["departuretime"],
                $schedule["arrivaltime"],
                $schedule["availableseats"],
                $schedule["price"],
                $schedule["busnumber"],
                $schedule["startcity"],
                $schedule["endcity"]
            );
            $company[$schedule["busnumber"]] =  $companyDAO->getCompanybyBusNumber( $schedule["busnumber"]);
            
        }
        return array(
            "schedules" => $schedules,
            "company"=> $company
        );
        // return $schedules;
    }

    public function get_schedule_by_company($company, $date) {
        $sql = "SELECT schedule.* FROM schedule
        INNER JOIN bus ON schedule.busnumber = bus.busnumber
        INNER JOIN company ON bus.companyname = company.companyname
        WHERE bus.companyname = ? AND schedule.date = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$company, $date]);
        $scheduleData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result_id = [];

        foreach($scheduleData as $sch) {
            $result_id[] = $sch['id'];
        }
        return json_encode($result_id);
    }

    public function get_schedule_by_date($date, $depart, $end) {
        $sql = "SELECT schedule.* FROM schedule
        INNER JOIN bus ON schedule.busnumber = bus.busnumber
        INNER JOIN company ON bus.companyname = company.companyname
        WHERE schedule.date = ? AND schedule.startcity = ? AND schedule.endcity = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$date, $depart, $end]);
        $scheduleData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result_id = [];

        foreach($scheduleData as $sch) {
            $result_id[] = $sch['id'];
        }
        return json_encode($scheduleData);
    }
    
    public function FilterByPrice($pricemin,$pricemax){
        $sql ="SELECT schedule.* FROM schedule
          INNER JOIN bus ON schedule.busnumber = bus.busnumber
        INNER JOIN company ON bus.companyname = company.companyname
        Where price BETWEEN $pricemin AND $pricemax";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $scheduleData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result_id = [];

        foreach($scheduleData as $sch) {
            $result_id[] = $sch['id'];
        }
        return json_encode($result_id);
    }
    
}
?>