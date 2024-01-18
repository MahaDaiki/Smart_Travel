<?php

$title = "Smart travel";
ob_start();


$depart = $_POST['StartCity'];
$End = $_POST['EndCity'];
$date = $_POST['travelDate'];


?>
<form class="container mt-5" id="filterForm" action="index.php?action=filterPage" method="post">
    <select class="form-control" name="Company" id="Companyname">
        <option selected>All</option>
        <?php foreach ($availableSchedules["company"] as $company): ?>
            <option value="<?= $company->getCompanyname() ?>">

                <?= $company->getCompanyname() ?>
            </option>
        <?php endforeach; ?>
    </select>
    <!-- <div class="form-group">
        <label for="Price">Price:</label>
        <input type="number" class="form-control" name="Price" id="Price" min="1">
    </div> -->
    <!-- Add a new dropdown for Time of Day -->
    <div class="form-group">
        <label for="TimeOfDay">Time of Day:</label>
        <select class="form-control" name="TimeOfDay" id="TimeOfDay">
            <option value="any">Any Time</option>
            <option value="morning">Morning</option>
            <option value="evening">Evening</option>
            <option value="night">Night</option>
        </select>
    </div>
   
</form>
<div id="filteredResults">
    <!-- Div to display filtered results -->
    <div class="container mt-5">


        <?php if (!empty($availableSchedules)): ?>
            <div class="row">
                <?php foreach ($availableSchedules["schedules"] as $schedule): ?>
                    <div class="col-md-6 mb-4 allSchedules" id="<?= $schedule->getId() ?>">
                        <div class="card">
                            <?php
                            // $companyID = $schedule->getCompanyname();
                            // $companyImage = $schedule->getImgByName($companyName);
                            $company = $availableSchedules["company"][$schedule->getBusNumber()];
                            $companyImage = $company->getImg();
                            $companyName = $company->getCompanyname();
                            ?>
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <?php if (!empty($companyImage)): ?>
                                        <img src="View\images\<?= $companyImage ?>" class="card-img" alt="">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?= $schedule->getStartcity() ?> to
                                            <?= $schedule->getEndcity() ?>
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
                                            <?= $companyName ?>
                                        </p>
                                        <p class="card-text">Price:
                                            <?= $schedule->getPrice() ?> DH
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
    let allSchedules = document.querySelectorAll('.allSchedules');
    console.log(allSchedules);
    // document.addEventListener('DOMContentLoaded', function () {
    var filterButton = document.getElementById('filterButton');
    var filterForm = document.getElementById('filterForm');
    var Companyname = document.getElementById('Companyname');
    var timeSelect = document.getElementById('TimeOfDay');
    var filteredResults = document.getElementById('filteredResults');

    // filterButton.addEventListener('click', function () {
    //     var formData = new FormData(filterForm);
    //     console.log(formData)
    //     var xhr = new XMLHttpRequest();
    //     xhr.open('POST', 'index.php?action=filter', true);
    //     xhr.onload = function () {
    //         if (xhr.status == 200) {
    //             filteredResults.innerHTML = xhr.responseText;
    //         }
    //     };
    //     xhr.send(formData); // Send the FormData directly
    // });
    let schedules_id = [];
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?action=filterByTime&date=' + "<?= $date ?> " + "&depart=" + "<?= $depart ?>" + "&end=" + "<?= $End ?>", false);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status == 200) {
            schedules_id = JSON.parse(this.responseText);
        }
    };
    xhr.send('companyFilter');

    let morning = [];
    let evening = [];
    let night = [];
    schedules_id.forEach(function (sch) {
        // console.log(sch['departuretime'].split(":"));
        times = sch['departuretime'].split(":");
        heures = Number(times[0]) * 60;
        minutes = Number(times[1]);
        if ((heures + minutes) >= 6 * 60 && (heures + minutes) <= 12 * 60) {
            morning.push(sch['id']);
        } else if ((heures + minutes) > 12 * 60 && (heures + minutes) <= 18 * 60) {
            evening.push(sch['id']);
        } else if ((heures + minutes) > 18 * 60) {
            night.push(sch['id']);
        }
    });
    // console.log(morning, evening, night);


    Companyname.addEventListener('change', function () {
        if (Companyname.value === "All") {
            allSchedules.forEach(function (sch) {
                sch.style.display = 'block';
            });
        } else {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'index.php?action=filterByCompany&company=' + Companyname.value + "&date=" + "<?= $date ?>", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status == 200) {
                    schedules_id = JSON.parse(this.responseText);

                    allSchedules.forEach(function (sch) {
                        if (!schedules_id.includes(Number(sch.id))) {
                            sch.style.display = 'none';
                        } else {
                            sch.style.display = 'block';
                        }
                    })
                }
            };
            xhr.send('companyFilter');
        }

    });

    timeSelect.addEventListener('change', function () {
        // console.log(timeSelect.value);
        if (timeSelect.value === "any") {
            allSchedules.forEach(function (sch) {
                sch.style.display = 'block';
            });
        } else if (timeSelect.value === "morning") {
            allSchedules.forEach(function (sch) {
                if (!morning.includes(Number(sch.id))) {
                    sch.style.display = 'none';
                } else {
                    sch.style.display = 'block';
                }
            });
        }  else if (timeSelect.value === "evening") {
            allSchedules.forEach(function (sch) {
                if (!evening.includes(Number(sch.id))) {
                    sch.style.display = 'none';
                } else {
                    sch.style.display = 'block';
                }
            });
        }  else if (timeSelect.value === "night") {
            allSchedules.forEach(function (sch) {
                if (!night.includes(Number(sch.id))) {
                    sch.style.display = 'none';
                } else {
                    sch.style.display = 'block';
                }
            });
        }


    });

</script>



<?php $content = ob_get_clean(); ?>
<?php include_once 'View\layout.php'; ?>