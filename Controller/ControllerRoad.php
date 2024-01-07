<?php
class RoadController
{
    private $routeDAO;
    private $cityDAO; 

    public function __construct()
    {
        $this->routeDAO = new RoadDao();
        $this->cityDAO = new CityDao(); 
    }

    public function roads()
    {
        // Retrieve all routes
        $routes = $this->routeDAO->get_road();

        // Pass the data to the view (you may have a specific view for listing routes)
        include_once 'View/road/indexroad.php';
    }

    public function create()
    {   // Retrieve all cities (you may have a method in CityDAO to get all cities)
        $cities = $this->cityDAO->getAllCities();
        // Display the form for creating a new route
        include_once 'View/road/create.php';
    }

    public function store()
    {
        // Handle the form submission to store a new route in the database
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and process the form data
            $startCity = $_POST['startCity'];
            $endCity = $_POST['endCity'];
            $distance = $_POST['distance'];
            $duration = $_POST['duration'];

            // Retrieve City objects based on IDs
            $startCity = $this->cityDAO->getCityByName($startCity);
            $endCity = $this->cityDAO->getCityByName($endCity);

            // Check if cities are found

            // Create a new Route object
            $road = new Road($distance,$duration,$startCity,$endCity );

            // Pass the route object to the addRoute method in RouteDAO
            $this->routeDAO->insert_road($road);
            // Redirect to the index page or show the newly created route
            header("Location: index.php?action=roadadd");
            exit();
        }
    }

    public function edit($startCity,$endCity)
    {
        // Retrieve a specific route by ID to populate the edit form
        $road = $this->routeDAO->getRoadByCities($startCity, $endCity);

        // Retrieve all cities (you may have a method in CityDAO to get all cities)
        $cities = $this->cityDAO->getAllCities();

        // Display the form for editing the route
        include_once 'View/road/edit.php';
    }

    public function update($startCity,$endCity)
    {
        // Handle the form submission to update an existing route in the database
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and process the form data
            $startCity = $_POST['startCity'];
            $endCity = $_POST['endCity'];
            $distance = $_POST['distance'];
            $duration = $_POST['duration'];

            // Retrieve existing route and City objects
            $existingRoute = $this->routeDAO->getRoadByCities($startCity, $endCity);
            $startCity = $this->cityDAO->getCityByName($startCity);
            $endCity = $this->cityDAO->getCityByName($endCity);

          
            // Pass the updated route object to the updateRoute method in RouteDAO
            $this->routeDAO->update_road($existingRoute);

            // Redirect to the index page or show the updated route
            header("Location: index.php?action=roadindex");
            exit();
        } else {
            // Display an error or redirect to the edit page with a message
        }
    }

    public function delete($startCity, $endCity)
    {
        // Retrieve a specific route by ID to confirm deletion
        $route = $this->routeDAO->getRoadByCities($startCity, $endCity);

        // Display the delete confirmation page
        include_once 'View/road/delete.php';
    }

    public function destroy($startCity, $endCity)
    {
        // Delete a route by ID
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Call the deleteRoute method in RouteDAO
            $this->routeDAO->delete_road($startCity, $endCity);

            // Redirect to the index page or show a success message
            header("Location: index.php?action=roadindex");
            exit();
        } else {
           
        }
    }
}
?>