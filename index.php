<?php
include_once "Controller\ControllerAdmin.php";
include_once "Controller\ControllerBus.php";
include_once "Controller\ControllerFilter.php";
include_once "Controller\ControllerHome.php";
include_once "Controller\ControllerRoad.php";
include_once "Controller\ControllerSchedule.php";
include_once "Controller\ControllerSearch.php";

include_once "Model\city\CityDao.php";
include_once "Model\Company\CompanyDao.php";
include_once "Model\Road\RoadDao.php";
include_once "Model\Schedule\ScheduleDao.php";
include_once "Model\Bus\BusDao.php";

if (ISSET($_GET['action'])){
    $action = $_GET["action"];
    $BusController = new ControllerBus();
    $RoadController = new RoadController();
    $ScheduleController = new ScheduleController();
    $FilterController = new FilterController();
    $HomeController = new  ControllerHome();
    $SearchController = new SearchController();
    $AdminController = new AdminController();
 switch ($action){
    // case '/':
    //     $HomeController = new  ControllerHome();
    //     $HomeController->index();
    //     break; 
    case 'search':
        $SearchController->index();
        break;
    case 'filter':
        $FilterController->index();
        break;
    case 'Admin':
        $AdminController->admin();
        break;
    case 'busindex':
        $BusController->display();
        break;
    case 'buscreate':
        $BusController->create();
        break;
    case 'busstore':
        $BusController->store();
        break;
    case 'busedit':
        if (isset($_GET['busnumber']) && !empty($_GET['busnumber'])) {
            $BusController->edit($_GET['busnumber']);
        } else {
            // Handle the case when 'busnumber' is not set
            echo "Invalid bus number.";
        }
        break;
    case 'busupdate':
   
        $BusController->update($_GET['busnumber']);
        break;
    case 'busdelete':
        $BusController->delete($_GET['busnumber']);
        break;
    case 'busdestroy':
        $BusController->destroy($_GET['busnumber']);
        break;
    case 'roadindex':
        $RoadController->roads();
        break;
    case 'roadcreate':
        $RoadController->create();
        break;
    case 'roadstore':
        $RoadController->store();
        break;
    case 'roadedit':
        $RoadController->edit($_GET['startCity'],$_GET['endcity']);
        break;
    case 'roadupdate':
        $RoadController->update($_GET['startCity'],$_GET['endcity']);
        break;
    case 'roaddelete':
        $RoadController->delete($_GET['startCity'],$_GET['endcity']);
        break;
    case 'roaddestroy':
        $RoadController->destroy($_GET['startCity'],$_GET['endcity']);
        break;
    case 'scheduleindex':
 
        $ScheduleController->index();
        break;
    case 'schedulecreate':
       
        $ScheduleController->create();
        break;
    case 'schedulestore':
        $ScheduleController->store();
        break;
    case 'scheduleedit':
        $ScheduleController->edit($_GET['id']);
        break;
    case 'scheduleupdate':
        $ScheduleController->update($_GET['id']);
        break;
    case 'scheduledelete':
        $ScheduleController->delete($_GET['id']);
        break;
    case 'scheduledestroy':
        $ScheduleController->destroy($_GET['id']);
        break;
    default:
       
        break;
} 

} else{   
    $HomeController = new  ControllerHome();
        $HomeController->index();
 }
