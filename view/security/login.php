<?php
    $message = $result['data']['message'];

?>

<h1>Sign In</h1>

<form class="loginForm" action="index.php?ctrl=security&action=login" method="post">
  
    <!-- <label for="email">Mail</label> -->
    <input type="email" name="email" id="email" placeholder="Email"><br>

    <!-- <label for="pass1">Password</label> -->
    <input type="password" name="password" id="password" placeholder="Password"> <br>

    <input type="submit" value="Sign In" id="submitRegistration"> 
</form>


<div class="loginMessage-container"><p class="loginMessage"><?=$message?></p></div>
