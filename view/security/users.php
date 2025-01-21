<?php
    $users = $result["data"]['users']; 
?>


<div class="users-wrapper">
    <h1>Users</h1>
        <div class="usersProfile__container">
            <?php
            foreach($users as $user){ ?>
            <div class="userProfile-box">
            <img id="userProfile-avatar" src="public/avatar/avatar1.jpg" alt="avatar1">
                <p>Username : <?= $user ?>
                <p>Email : <?= $user->getEmail() ?></p>
                <p>Role : <?= $user->getrole() ?></p>
                <p>Registration date : <?= $user->getRegistrationDate() ?></p>
             
            </div>
            <?php }?>
        </div>
    </div>
