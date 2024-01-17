<?php
$title = "Schedule List";
ob_start();
?>
<div class="container-fluid mb-4 d-flex align-items-center justify-content-center mt-4" >
    <div>
        <h1 class="text-center">Admin Page</h1>
        <ul class="nav">
            <li class="nav-item "><a class="nav-link" href="index.php?action=roadindex">Road</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?action=busindex">Bus</a></li>
            <li class="nav-item activee"><a class="nav-link" href="index.php?action=scheduleindex">Schedule</a></li>
        </ul>
    </div>
</div>
<div class="container mt-5 text-center">
    <h1>Schedule List</h1>

    <!-- Add a link to create a new schedule -->
    <a href="index.php?action=schedulecreate" class="btn btn-primary mb-3">Add New Schedule</a>

    <?php if (!empty($schedules)): ?>
        <table class="table">
           
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Available Seats</th>
                    <th>Bus</th>
                    <th>Price</th>
                    <th>Route</th>
                    
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($schedules as $schedule): ?>
                    <tr>
                        <td>
                            <?= $schedule->getId() ?>
                        </td>
                        <td>
                            <?= $schedule->getDate() ?>
                        </td>
                        <td>
                            <?= $schedule->getDeparturetime() ?>
                        </td>
                        <td>
                            <?= $schedule->getArrivaltime() ?>
                        </td>
                        <td>
                            <?= $schedule->getAvailableseats() ?>
                        </td>
                        <td>
                            <?= $schedule->getBusnumber() ?>
                        </td>
                        <td>
                            <?= $schedule->getPrice(). "DH"?>
                        </td>
                        <td>
                            <?= $schedule->getStartcity() ?> to
                            <?= $schedule->getEndcity() ?>
                        </td>

                       
                        <td>
                            <!-- Add links to edit and delete each schedule -->
                            <a href="index.php?action=scheduleedit&id=<?= $schedule->getId() ?>"
                                class="btn btn-warning">Edit</a>
                            <a href="index.php?action=scheduledelete&id=<?= $schedule->getId() ?>"
                                class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">No schedules found.</p>
    <?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>
<?php include_once 'View/layout.php'; ?>