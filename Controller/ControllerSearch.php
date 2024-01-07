<?php

session_start();

class SearchController
{
    public function index()
    {
        // Fetch the list of companies
        $companyDAO = new CompanyDAO();
        $allCompanies = $companyDAO->getAllCompanies();

        // Initialize variables
        $availableSchedules = [];
        $filteredSchedules = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle Search Form submission
            if (isset($_POST['StartCity'], $_POST['EndCity'], $_POST['travelDate'], $_POST['numPeople'])) {
                // Handle search form submission, 

                $scheduleDAO = new ScheduleDAO();

                // Define the variables before calling the method
                $StartCity = $_POST['StartCity'];
                $EndCity = $_POST['EndCity'];
                $date = $_POST['travelDate'];
                $places = $_POST['numPeople'];

                $availableSchedules = $scheduleDAO->get_schedule_by_cities( $StartCity,$EndCity,$date, $places);

                // Handle Company Filter
                if (isset($_POST['companyFilter'])) {
                    $selectedCompanyName = $_POST['companyFilter'];

                    // Adjust the logic based on your actual filter criteria
                    foreach ($availableSchedules as $schedule) {
                        $scheduleCompanyName = $schedule->getBusnumber()->getCompany()->getCompanyname();

                        if ($selectedCompanyName === '' || $scheduleCompanyName == $selectedCompanyName) {
                            $filteredSchedules[] = $schedule;
                        }
                    }
                } else {
                    // If "Show All" is selected, reset company filter and display all schedules
                    $filteredSchedules = $availableSchedules;
                }
            }
        } else {
            // If no form submission, initialize with all schedules
            $scheduleDAO = new ScheduleDAO();
            $availableSchedules = $scheduleDAO->get_Schedule();
            $filteredSchedules = $availableSchedules;
        }

        // Load the view
        include_once 'View/Search.php';
    }
}