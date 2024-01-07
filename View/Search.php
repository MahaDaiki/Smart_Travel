<?php

$title = "Smart travel";
ob_start();
?>

<form id="filterForm" action="index.php?action=filterPage" method="post">
    <select class="form-control" name="Company" id="departureCity">
        <!-- Add an option to show all schedules -->
        <option value="">Show All Schedules</option>

        <!-- Populate with dynamic data from your database -->
        <?php foreach ($availableSchedules as $schedule): ?>
            <option value="<?= $schedule->getBusnumber()->getCompany()->getCompanyname() ?>">
                <?= $schedule->getBusnumber()->getCompany()->getCompanyname() ?>
            </option>
        <?php endforeach; ?>
    </select>
    <div class="form-group">
        <label for="Price">Price:</label>
        <input type="number" class="form-control" name="Price" id="Price" min="1">
    </div>
    <!-- Add a new dropdown for Time of Day -->
    <div class="form-group">
        <label for="TimeOfDay">Time of Day:</label>
        <select class="form-control" name="TimeOfDay" id="TimeOfDay">
            <option value="">Any Time</option>
            <option value="morning">Morning</option>
            <option value="evening">Evening</option>
            <option value="night">Night</option>
        </select>
    </div>
    <button type="button" class="btn btn-primary" id="filterButton">Filter</button>
</form>
<div id="filteredResults">
    <!-- Div to display filtered results -->
    <div class="container mt-5">


        <?php if (!empty($availableSchedules)): ?>
            <div class="row">
                <?php foreach ($availableSchedules as $schedule): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <?php
                            $companyID = $schedule->getCompanyname();
                            $companyImage = $schedule->getImgByName($companyName);
                            ?>
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <?php if (!empty($companyImage)): ?>
                                        <img src="<?= $schedule->getBusnumber()->getCompany()->getImg() ?>" class="card-img"
                                            alt="<?= $schedule->getBusnumber()->getCompany()->getImg() ?>View\images\">
                                    <?php else: ?>
                                        <!-- Default image or placeholder if no image is available -->
                                        <img src="default_image.jpg" class="card-img" alt="Default Image">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Schedule ID:
                                            <?= $schedule->getId() ?>
                                        </h5>
                                        <p class="card-text">Date:
                                            <?= $schedule->getDate() ?>
                                        </p>
                                        <p class="card-text">Departure Time:
                                            <?= $schedule->getDeparturetime() ?>
                                        </p>
                                        <p class="card-text">Arrival Time:
                                            <?= $schedule->getArrivaltime() ?>
                                        </p>
                                        <p class="card-text">Available Seats:
                                            <?= $schedule->getAvailableseats() ?>
                                        </p>
                                        <p class="card-text">Company:
                                            <?= $schedule->getBusnumber()->getCompany()->getCompanyname() ?>
                                        </p>
                                        <p class="card-text">Price:
                                            <?= $schedule->getPrice() ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center">No available schedules found for the selected route and date.</p>
        <?php endif; ?>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get references to elements
        var filterButton = document.getElementById('filterButton');
        var filterForm = document.getElementById('filterForm');
        var StartCity = document.getElementById('StartCity');
        var filteredResults = document.getElementById('filteredResults');

        // Add click event listener to filter button
        filterButton.addEventListener('click', function () {
            // Serialize the form data
            var formData = new FormData(filterForm);

            // Make an Ajax request
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'index.php?action=filterPage', true);
            xhr.onload = function () {
                if (xhr.status == 200) {
                    // Update the content of the div with the filtered results
                    filteredResults.innerHTML = xhr.responseText;
                }
            };
            xhr.send(formData);
        });

        // Add change event listener to departureCity select element
        StartCity.addEventListener('change', function () {
            if (StartCity.value === "") {
                // Make an Ajax request to get all schedules without company filter
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'index.php?action=filterPage', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status == 200) {
                        // Update the content of the div with all schedules
                        filteredResults.innerHTML = xhr.responseText;
                    }
                };
                xhr.send('companyFilter=');
            }
        });
    });
</script>

<?php $content = ob_get_clean(); ?>
<?php include_once 'View\layout.php'; ?>