<?php
$title = "Edit Road";
ob_start();
?>

<div class="container mt-5">
    <h1>
       
        <?= $title ?>
        
    </h1>
    <form method="post" action="index.php?action=roadupdate&startCity=<?= $road->getStartCity() ?>&endCity=<?= $road->getEndCity() ?>">
        <div class="mb-3">
            <label for="distance">Distance</label>
            <input type="text" name="distance" id="distance" class="form-control" value="<?= $road->getDistance() ?>" required>
        </div>

        <div class="mb-3">
            <label for="duration">Duration</label>
            <input type="text" name="duration" id="duration" class="form-control" value="<?= $road->getDuration() ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Route</button>
    </form>
</div>

<?php $content = ob_get_clean(); ?>
<?php include_once 'View/layout.php'; ?>
