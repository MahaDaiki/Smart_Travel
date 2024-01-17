<?php


class ScheduleController
{
    private $scheduleDAO;
    private $busDAO;
    private $companyDAO;
    private $roadDAO;
    public function __construct()
    {
        $this->scheduleDAO = new ScheduleDAO();
        $this->busDAO = new BusDAO();
        $this->companyDAO = new CompanyDAO();
        $this->roadDAO = new RoadDAO();
    }

    public function index()
    {
        // Retrieve all schedules
        $schedules = $this->scheduleDAO->get_Schedule();

    
        include_once 'View\Schedule\scheduleindex.php';
    }

    public function create()
    {
        $schedules = $this->scheduleDAO->get_Schedule();
        $buses = $this->busDAO->get_Bus();
        $companies = $this->companyDAO->getAllCompanies();
        $road = $this->roadDAO->get_Road();
        // Display the form for creating a new schedule
        include_once 'View/schedule/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and process the form data
            $date = $_POST['date'];
            $departureTime = $_POST['departureTime'];
            $arrivalTime = $_POST['arrivalTime'];
            $availableSeats = $_POST['availableSeats'];
            $price = $_POST['price'];
            $busnumber = $_POST['bus'];
            $roadParts = explode('|', $_POST['road']);
            $startCity = $roadParts[0];
            $endCity = $roadParts[1];
            // Create a new Schedule object
            $schedule = new Schedule(null, $date, $departureTime, $arrivalTime, $availableSeats, $price,$busnumber, $startCity, $endCity);

            // Pass the Schedule object to the addSchedule method in ScheduleDAO
            $this->scheduleDAO->insert_schedule($schedule);

            // Redirect to the index page or show the newly created schedule
            header("Location: index.php?action=scheduleindex");

            
        }
    }


    public function edit($scheduleID)
    {
        $schedules = $this->scheduleDAO->get_Schedule();
        $buses = $this->busDAO->get_Bus();
        $companies = $this->companyDAO->getAllCompanies();
        $road = $this->roadDAO->get_Road();
        // Retrieve a specific schedule by ID to populate the edit form
        $schedule = $this->scheduleDAO->get_schedule_by_id($scheduleID);
        // Display the form for editing the schedule
        include_once 'View/schedule/edit.php';
    }

    public function update($scheduleID)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and process the form data
            $date = $_POST['date'];
            $departureTime = $_POST['departureTime'];
            $arrivalTime = $_POST['arrivalTime'];
            $availableSeats = $_POST['availableSeats'];
            $busnumber = $_POST['bus'];
            $routeParts = explode('|', $_POST['road']);
            $startCity = $routeParts[0];
            $endCity = $routeParts[1];
            $price = $_POST['price'];

            // Retrieve the existing schedule
            $existingSchedule = $this->scheduleDAO->get_schedule_by_id($scheduleID);
 
            $existingSchedule = new Schedule(  0,$date,$departureTime,$arrivalTime,$availableSeats,$price,$busnumber,$startCity,$endCity);
         
            $this->scheduleDAO->update_schedule($existingSchedule);
           

            
            // header("Location: index.php?action=scheduleindex");
           
        } 
    }

    public function delete($scheduleID)
    {
        // Retrieve a specific schedule by ID to confirm deletion
        $schedule = $this->scheduleDAO->get_schedule_by_id($scheduleID);
        // Display the delete confirmation page
        include_once 'View/schedule/delete.php';
    }

    public function destroy($scheduleID)
    {
        // Delete a schedule by ID
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Call the deleteSchedule method in ScheduleDAO
            $this->scheduleDAO->delete_schedule($scheduleID);

            // Redirect to the index page or show a success message
            header("Location: index.php?action=scheduleindex");
            exit();
        } else {
            
        }
    }
}