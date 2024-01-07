<?php
$title = "Admin Page";
ob_start();
?>


<div class="container-fluid mb-4 d-flex align-items-center justify-content-center mt-4" >
    <div>
        <h1 class="text-center">Admin Page</h1>
        <ul class="nav">
            <li class="nav-item"><a class="nav-link" href="index.php?action=roadindex">Route</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?action=busindex">Bus</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?action=scheduleindex">Schedule</a></li>
        </ul>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php include_once 'View/layout.php'; ?>