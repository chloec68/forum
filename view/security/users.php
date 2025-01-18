<?php
    $users = $result["data"]['users']; 
?>

<div class="wrapper">
<div class="content">

<h1>Users</h1>

<?php
foreach($users as $user){ ?>
    <p><img id="avatar" src="public/avatar/avatar1.jpg" alt="avatar1"><a href="#"><?= $user ?></a> 
<?php }?>

</div>
</div>