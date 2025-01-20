<?php
    $message = $result['data']['message'];

?>

<h1>Sign Up</h1>

<form class="registerForm" action="index.php?ctrl=security&action=register" method="post">
    <!-- <label for="userName">User name</label> -->
    <input type="text" name="userName" id="userName" placeholder="User name"><br>

    <!-- <label for="email">Mail</label> -->
    <input type="email" name="email" id="email" placeholder="Email"><br>

    <!-- <label for="pass1">Password</label> -->
    <input type="password" name="pass1" id="pass1" placeholder="Password"> <br>

    <!-- <label for="pass2">Confirm password</label> -->
    <input type="password" name="pass2" id="pass2" placeholder="Confirm password"><br>

    <input type="submit" value="Sign Up" name="submit" id="submitRegistration"> 
</form>

<div class="registrationMessage-container"><p class="registrationMessage"><?=$message?></p></div>

