<?php
$title = "Bus List";
ob_start();
?>

     <!-- <style>
        body {
            background-image: url('View\images\coach-volvo-buses-tour-and-travels-.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style> -->
<div class="container-fluid mb-4 d-flex align-items-center justify-content-center mt-4" >
    <div>
        <h1 class="text-center">Admin Page</h1>
        <ul class="nav">
            <li class="nav-item"><a class="nav-link" href="index.php?action=roadindex">Road</a></li>
            <li class="nav-item active"><a class="nav-link" href="index.php?action=busindex">Bus</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?action=scheduleindex">Schedule</a></li>
        </ul>
    </div>
</div>

<div class="container mt-5 text-center"  >
    <h1>Bus List</h1>

    <!-- Add a link to create a new bus -->
    <a href="index.php?action=buscreate" class="btn btn-primary mb-3">Add New Bus</a>

    <?php if (!empty($buses)): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Bus Number</th>
                <th>License Plate</th>
                <th>Company</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($buses as $bus): ?>
            <tr>
                <td>
                    <?= $bus->getBusnumber() ?>
                </td>
                <td>
                    <?= $bus->getLicensePlate() ?>
                </td>
                <td>
                    <?= $bus->getCompanyname() ?>
                </td>
                <td>
                    <?= $bus->getCapacity() ?>
                </td>
                <td>
                    <!-- Add links to edit and delete each bus -->
                    <a href="index.php?action=busedit&number=<?= $bus->getBusnumber() ?>" class="btn btn-warning">Edit</a>
                    <a href="index.php?action=busdelete&number=<?= $bus->getBusnumber() ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p class="text-center">No buses found.</p>
    <?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>
<?php include_once 'View/layout.php'; ?>