<?php
    $message = $result['data']['message'];

?>

<h1>Sign Up</h1>

<form class="registerForm" action="index.php?ctrl=security&action=register" method="post">
    <!-- <label for="userName">User name</label> -->
    <input type="text" name="userName" id="userName" value="User name"><br>

    <!-- <label for="email">Mail</label> -->
    <input type="email" name="email" id="email" value="Email"><br>

    <!-- <label for="pass1">Password</label> -->
    <input type="password" name="pass1" id="pass1" placeholder="Password"> <br>

    <!-- <label for="pass2">Confirm password</label> -->
    <input type="password" name="pass2" id="pass2" placeholder="Confirm password"><br>

    <input type="submit" value="Sign Up" id="submitRegistration"> 
</form>

<div class="registrationMessage-container"><p class="registrationMessage"><?=$message?></p></div>


<style>
    h2{
        text-align:center;
    }

    .registerForm{
        display: flex;
        flex-direction: column;
        width:fit-content;
        margin:100px auto 50px auto;
    }

    .registerForm input{
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #DDDDDD;
        color: #A0A6A3;
        box-shadow: 1px 5px 9px rgba(211, 211, 211, .7);
    }
     #submitRegistration{
        border : 3px solid var(--bright-green);
        /* background-color:var(--white); */
        /* color : var(--black); */
        font-weight:700;
        font-size:1.2em;
        background-color:var(--black);
        color:var(--white);
    }

    #submitRegistration:hover{
        background-color:var(--bright-green);
        cursor:pointer;
    }

    .registrationMessage-container{
        width:fit-content;
        margin: 0 auto 100px auto;
        padding:10px;
        border-radius:4px;
    }

    .registrationMessage{
        font-weight:700;
    }
    
</style>