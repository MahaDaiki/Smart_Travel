<?php
$title = "Edit Bus";
ob_start();
?>

<div class="container mt-5">
    <h1>
        <?= $title ?>
    </h1>

    <form method="post" action="index.php?action=busupdate&busnumber=<?= $bus->getBusnumber() ?>">
     
        <div class="mb-3">
            <label for="licensePlate" class="form-label">License Plate</label>
            <input type="text" class="form-control" id="licensePlate" name="licensePlate"
                value="<?= $bus->getLicenseplate()?>" required>
        </div>

        <div class="mb-3">
            <label for="company" class="form-label">Company</label>
            <select class="form-select" id="company" name="company" required>
                <?php foreach ($companies as $company): ?>
                    <option> 
                        <?= $company->getCompanyname() ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" class="form-control" id="capacity" name="capacity"
                value="<?=$bus->getCapacity() ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Bus</button>
    </form>
</div>

<?php $content = ob_get_clean(); ?>
<?php include_once 'View/layout.php'; ?>