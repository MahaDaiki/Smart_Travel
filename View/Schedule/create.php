<?php
$title = "Create Schedule";
ob_start();
?>

<div class="container mt-5 container">
    <h1>
        <?= $title ?>
    </h1>

    <form method="post" action="index.php?action=schedulestore">
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>

        <div class="mb-3">
            <label for="departureTime" class="form-label">Departure Time</label>
            <input type="time" class="form-control" id="departureTime" name="departureTime" required>
        </div>

        <div class="mb-3">
            <label for="arrivalTime" class="form-label">Arrival Time</label>
            <input type="time" class="form-control" id="arrivalTime" name="arrivalTime" required>
        </div>

        <div class="mb-3">
            <label for="availableSeats" class="form-label">Available Seats</label>
            <input type="number" class="form-control" id="availableSeats" name="availableSeats" required>
        </div>

        <div class="mb-3">
            <label for="bus" class="form-label">Bus</label>
            <select class="form-select" id="bus" name="bus" required>
                <?php foreach ($buses as $bus): ?>
                <option>
                    <?= $bus->getBusnumber() ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="route" class="form-label">Route</label>
            <select class="form-select" id="road" name="road" required>
               <?php foreach ($road as $roads): ?>
                   <?php
           $roadID = $roads->getStartCity() . '|' . $roads->getEndCity();
           ?>
           <option value="<?= $roadID ?>">
               <?= $roads->getStartCity() ?> to <?= $roads->getEndCity() ?>
           </option>
               <?php endforeach; ?>
           </select>
        </div>

        
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Schedule</button>
    </form>
</div>

<?php $content = ob_get_clean(); ?>
<?php include_once 'View/layout.php'; ?>