<?php
$title = "Route List";
ob_start();
?>

<div class="container-fluid mb-4 d-flex align-items-center justify-content-center mt-4" >
    <div>
        <h1 class="text-center">Admin Page</h1>
        <ul class="nav">
            <li class="nav-item activee"><a class="nav-link" href="index.php?action=roadindex">Road</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?action=busindex">Bus</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?action=scheduleindex">Schedule</a></li>
        </ul>
    </div>
</div>

<div class="container mt-5 text-center">
    <h1>Route List</h1>

  
    <a href="index.php?action=roadcreate" class="btn btn-primary mb-3">Add New Route</a>

    <?php if (!empty($routes)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Start City</th>
                    <th>End City</th>
                    <th>Distance</th>
                    <th>Duration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($routes as $route): ?>
                    <tr>
                        <td><?= $route->getStartCity() ?></td>
                        <td><?= $route->getEndCity() ?></td>
                        <td><?= $route->getDistance() ?></td>
                        <td><?= $route->getDuration() ?></td>
                        <td>
                        
    <a href="index.php?action=roadedit&startCity=<?= $route->getStartCity() ?>&endCity=<?= $route->getEndCity() ?>" class="btn btn-warning">Edit</a>
    <a href="index.php?action=roaddelete&startCity=<?= $route->getStartCity() ?>&endCity=<?= $route->getEndCity() ?>" class="btn btn-danger">Delete</a>
</td>

                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">No road found.</p>
    <?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>
<?php include_once 'View/layout.php'; ?>

