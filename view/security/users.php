<?php
    $users = $result["data"]['users']; 
?>

<div class="wrapper">
    <h1>Users</h1>
        <div class="userContent">
            <?php
            foreach($users as $user){ ?>
                <p><img id="avatar" src="public/avatar/avatar1.jpg" alt="avatar1"><a href="#"><?= $user ?></a> 
            <?php }?>
        </div>
</div>

<style>
    .userContent{
        display:grid; 
        grid-template-columns : 1fr 1fr 1fr;
    }
</style>