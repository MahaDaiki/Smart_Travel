<?php
// session_start();
class FilterController
{
  
    private function isValidSession()
    {
        return isset($_SESSION['startCity']) && isset($_SESSION['endCity']) &&
            isset($_SESSION['Date']) && isset($_SESSION['numPeople']);
    }

   

    public function filterByCompany() {
        $company = $_GET['company'];
        $date = $_GET['date'];
        $scheduleDAO = new ScheduleDAO();
        echo $scheduleDAO->get_schedule_by_company($company, $date);
    }

    public function filterByTime() {
        $date = $_GET['date'];
        $depart = $_GET['depart'];
        $end = $_GET['end'];
        $scheduleDAO = new ScheduleDAO();
        echo $scheduleDAO->get_schedule_by_date($date, $depart, $end);
    }

    public function filterByPrice(){
        $pricemin= $_GET['pricemin'];
        $pricemax= $_GET['pricemax'];
        $scheduleDAO = new ScheduleDAO();
        echo $scheduleDAO->FilterByPrice($pricemin,$pricemax);
    }

}