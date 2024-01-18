<?php

session_start();

class SearchController
{
    public function index()
    {
      
        $companyDAO = new CompanyDAO();
        $allCompanies = $companyDAO->getAllCompanies();


        $availableSchedules = [];
       

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          
            if (isset($_POST['StartCity'], $_POST['EndCity'], $_POST['travelDate'], $_POST['numPeople'])) {
            

                $scheduleDAO = new ScheduleDAO();

             
                $StartCity = $_POST['StartCity'];
                $EndCity = $_POST['EndCity'];
                $date = $_POST['travelDate'];
                $places = $_POST['numPeople'];

                $availableSchedules = $scheduleDAO->get_schedule_by_cities( $StartCity,$EndCity,$date, $places);

         
            }
        } else {
            $scheduleDAO = new ScheduleDAO();
            $availableSchedules = $scheduleDAO->get_Schedule();
         
        }

        include_once 'View/Search.php';
    }
}