<?php
// session_start();
class FilterController
{
    public function index()
    {
        if ($this->isValidSession() && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the keys are set in the $_POST array
            $startDate = isset($_POST['startDate']) ? new DateTime($_POST['startDate']) : null;
            $endDate = isset($_POST['endDate']) ? new DateTime($_POST['endDate']) : null;
            $com = isset($_POST['Company']) ? $_POST['Company'] : null;
            $price = isset($_POST['Price']) ? $_POST['Price'] : null;
            $timeOfDay = isset($_POST['TimeOfDay']) ? $_POST['TimeOfDay'] : null;

            $startCity = $_SESSION['departureCity'];
            $endCity = $_SESSION['arrivalCity'];
            $date = $_SESSION['travelDate'];
            $availableseats = $_SESSION['numPeople'];
            $scheduleDAO = new ScheduleDAO();

            $availableSchedules = $scheduleDAO->get_schedule_by_cities($date, $availableseats,$startCity, $endCity);
            $cm = [];

            // Filter schedules based on user input
            foreach ($availableSchedules as $schedule) {
                $scheduleDate = new DateTime($schedule->getDate());
                $scheduleTime = new DateTime($schedule->getDepartureTime());

                // Check if the schedule matches the selected filters
                if (
                    (!$com || $schedule->getBusnumber()->getCompany()->getCompanyname() == $com) &&
                    (!$price || $schedule->getPrice() <= $price) &&
                    (!$startDate || !$endDate || ($startDate <= $scheduleDate && $endDate >= $scheduleDate)) &&
                    (!$timeOfDay || $this->isTimeOfDayMatch($scheduleTime, $timeOfDay))
                ) {
                    $cm[] = $schedule;
                }
            }

            // Pass the data to the view
            include_once 'View/filterPage.php';
        } else {
            $this->redirectToHome();
        }
    }
    private function isTimeOfDayMatch($scheduleTime, $selectedTimeOfDay)
    {
        switch ($selectedTimeOfDay) {
            case 'morning':
                return $scheduleTime >= new DateTime('06:00:00') && $scheduleTime < new DateTime('12:00:00');
            case 'evening':
                return $scheduleTime >= new DateTime('12:00:00') && $scheduleTime < new DateTime('18:00:00');
            case 'night':
                return $scheduleTime >= new DateTime('18:00:00') || $scheduleTime < new DateTime('06:00:00');
            default:
                return true; // Any Time
        }
    }
    private function isValidSession()
    {
        return isset($_SESSION['startCity']) && isset($_SESSION['endCity']) &&
            isset($_SESSION['Date']) && isset($_SESSION['numPeople']);
    }

    private function redirectToHome()
    {
        header("Location: index.php");
        exit();
    }
}