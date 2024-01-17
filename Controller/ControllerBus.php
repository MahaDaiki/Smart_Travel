<?php
require_once("Model\Bus\BusDao.php");

class ControllerBus{
    private $BusDao;
    private $companyDAO;


public function __construct()
    {
        $this->BusDao = new BusDao();
        $this->companyDAO = new CompanyDao();
    }

    public function display() 
    { // kant index()
        // Retrieve all buses
        $buses = $this->BusDao->get_Bus();
        include_once 'View/bus/busindex.php';
    }

    public function create()
    {
    
        $companies = $this->companyDAO->getAllCompanies();
        // Display the form 
        include_once 'View\bus\create.php';
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
            $licensePlate = $_POST['licensePlate'];
            $capacity = $_POST['capacity'];
            $companyName = $_POST['company']; 
           

            // Retrieve Company object
           
            // Create a new Bus object
            $bus = new Bus(0, $licensePlate, $capacity,$companyName);

            // Pass the Bus object to the addBus method in BusDAO
            $this->BusDao->insert_bus($bus);

            // Redirect to the index page or show the newly created bus
            header("Location: index.php?action=busindex");
            exit();
        }
    }

    public function edit($busnumber)
    {
        $bus = $this->BusDao->getBusById($busnumber);

        // Fetch the list of companies
        $companies = $this->companyDAO->getAllCompanies();
  
        // Display the form for editing the bus
        include_once 'View\bus\edit.php';
    }

    public function update($busnumber)
    {
        // Handle the form submission to update an existing bus in the database
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and process the form data
            $licensePlate = $_POST['licensePlate'];
            $companyname = $_POST['company']; 
            $capacity = $_POST['capacity'];
    
            // Retrieve the existing bus
            $existingBus = $this->BusDao->getBusById($busnumber);
    
            // // Retrieve Company object based on name
            // $company = $this->companyDAO->getCompanyByName($companyname);
            // // Set the company for the bus
            // $existingBus->setCompany($company);
            $existingBus = new bus(  $busnumber,$licensePlate,$capacity ,$companyname);
            // Pass the updated bus object to the updateBus method in BusDAO
            $this->BusDao->update_bus($existingBus);
    
            // Redirect to the index page or show the updated bus
            header("Location: index.php?action=busindex&number={$busnumber}");
            exit();
        }
    }
    


    public function delete($busnumber)
    {
        // Retrieve a specific bus by ID to confirm deletion
        $bus = $this->BusDao->getBusById($busnumber);

        // Display the delete confirmation page
        include_once 'view/bus/delete.php';
    }

    public function destroy($busnumber)
    {
        // Delete a bus by ID
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Call the deleteBus method in BusDAO
            $this->BusDao->delete_bus($busnumber);

            // Redirect to the index page or show a success message
            header("Location: index.php?action=busindex");
            exit();
        } else {
          
        }
    }

}

?>