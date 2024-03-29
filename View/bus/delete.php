<?php
$title = "Delete Bus";
ob_start();
?>
<div class="container mt-5">

    <h1>
        <?php $title ?>
    </h1>
    <p>Are you sure you want to delete this Bus?</p>

    <form method="post" action="index.php?action=busdestroy&busnumber=<?= $bus->getBusnumber() ?>">
        <button type="submit" class="btn btn-danger">Delete bus</button>
        <a href="index.php?action=busindex" class="btn btn-secondary">Cancel</a>
    </form>


    <?php $content = ob_get_clean(); ?>
    <?php include_once 'View/layout.php'; ?>