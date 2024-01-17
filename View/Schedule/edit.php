<?php
$title = "Edit Schedule";
ob_start();
?>

<div class="container mt-5 container">
    <h1><?= $title ?></h1>

    <form method="post" action="index.php?action=scheduleupdate&id=<?= $schedule->getId() ?>">
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date"
                value="<?= $schedule->getDate() ?>" required>
        </div>

        <div class="mb-3">
            <label for="departureTime" class="form-label">Departure Time</label>
            <input type="time" class="form-control" id="departureTime" name="departureTime"
                value="<?= $schedule->getDeparturetime() ?>" required>
        </div>

        <div class="mb-3">
            <label for="arrivalTime" class="form-label">Arrival Time</label>
            <input type="time" class="form-control" id="arrivalTime" name="arrivalTime"
                value="<?= $schedule->getArrivaltime() ?>" required>
        </div>

        <div class="mb-3">
            <label for="availableSeats" class="form-label">Available Seats</label>
            <input type="number" class="form-control" id="availableSeats" name="availableSeats"
                value="<?= $schedule->getAvailableseats() ?>" required>
        </div>

        <div class="mb-3">
            <label for="bus" class="form-label">Bus Number</label>
            <select class="form-select" id="bus" name="bus" required>
                <?php foreach ($buses as $bus): ?>
                <option value="<?= $bus->getBusnumber() ?>">
                
                    <?= $bus->getBusnumber() ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="road" class="form-label">Road</label>
            <select class="form-select" id="road" name="road" required>
               
                <?php foreach ($road as $roads): ?>
                    <?php
            $routeID = $roads->getStartCity() . '|' . $roads->getEndCity();
            ?>
            <option value="<?= $routeID ?>">
                <?= $roads->getStartCity() ?> to <?= $roads->getEndCity() ?>
            </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price"
                value="<?= $schedule->getPrice() ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Schedule</button>
    </form>
</div>

<?php $content = ob_get_clean(); ?>
<?php include_once 'View/layout.php'; ?>