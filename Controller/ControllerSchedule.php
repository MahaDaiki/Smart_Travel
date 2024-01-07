<?php
class ScheduleController
{
    private $scheduleDAO;
    private $busDAO;
    private $companyDAO;
    private $routeDAO;
    public function __construct()
    {
        $this->scheduleDAO = new ScheduleDAO();
        $this->busDAO = new BusDAO();
        $this->companyDAO = new CompanyDAO();
        $this->routeDAO = new RoadDAO();
    }

    public function index()
    {
        // Retrieve all schedules
        $schedules = $this->scheduleDAO->get_Schedule();

        // Pass the data to the view (you may have a specific view for listing schedules)
        include_once 'View/schedule/index.php';
    }

    public function create()
    {
        $schedules = $this->scheduleDAO->get_Schedule();
        $buses = $this->busDAO->get_Bus();
        $companies = $this->companyDAO->getAllCompanies();
        $routes = $this->routeDAO->get_Road();
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
            $busnumber = $_POST['bus'];
            $startcity = $_POST['startcity'];
            $endcity = $_POST['endcity'];
            $companyname = $_POST['company'];
            $price = $_POST['price'];

            // Retrieve the selected bus and route based on IDs
            $selectedBus = $this->busDAO->getBusById($busnumber);
            $selectedRoad = $this->routeDAO->getRoadByCities($startcity, $endcity);

            // Create a new Schedule object
            $schedule = new Schedule(null, $date, $departureTime, $arrivalTime, $availableSeats, $selectedBus, $selectedRoad, $companyname, $price);

            // Pass the Schedule object to the addSchedule method in ScheduleDAO
            $this->scheduleDAO->insert_schedule($schedule);

            // Redirect to the index page or show the newly created schedule
            header("Location: index.php?action=scheduleindex");
            exit();
        }
    }


    public function edit($scheduleID)
    {
        $schedules = $this->scheduleDAO->get_Schedule();
        $buses = $this->busDAO->get_Bus();
        $companies = $this->companyDAO->getAllCompanies();
        $routes = $this->routeDAO->get_Road();
        // Retrieve a specific schedule by ID to populate the edit form
        $schedule = $this->scheduleDAO->get_schedule_by_id($scheduleID);
        // Display the form for editing the schedule
        include_once 'View/schedule/edit.php';
    }

    public function update($scheduleID)
    {
        // Handle the form submission to update an existing schedule in the database
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and process the form data
            $date = $_POST['date'];
            $departureTime = $_POST['departureTime'];
            $arrivalTime = $_POST['arrivalTime'];
            $availableSeats = $_POST['availableSeats'];
            $busID = $_POST['bus'];
            $routeID = $_POST['route'];
            $companyID = $_POST['company'];
            $price = $_POST['price'];

            // Retrieve the existing schedule
            $existingSchedule = $this->scheduleDAO->get_schedule_by_id($scheduleID);

            // Update its properties

            // Pass the updated schedule object to the updateSchedule method in ScheduleDAO
            $this->scheduleDAO->update_schedule($existingSchedule);

            // Redirect to the index page or show the updated schedule
            header("Location: index.php?action=scheduleindex");
            exit();
        } else {
            // Display an error or redirect to the edit page with a message
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