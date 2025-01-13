<?php
    $users = $result["data"]['users']; 
?>

<h1>List of users</h1>

<?php
foreach($users as $user){ ?>
    <p><a href="#"><?= $user ?></a> 
<?php }
