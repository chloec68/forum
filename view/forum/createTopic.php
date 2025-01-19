<?php
    $category=$result['data']['category'];
    $message=$result['data']['message'];
?>
<h2><?=$message?></h2>
<div class=createTopic-wrapper>
   <div class="form-wrapper topics__wrapper-form">
        <form action="index.php?ctrl=forum&action=createTopic&id=<?= $category->getId()?>" method="post">
            <label for="new">New topic:</label>
            <br>
            <input type="text" name="title" id="new"> </input>
            <br>
            <label for="">First post (mandatory):</label>
            <br>
            <textarea name="firstPost" id="new" rows="10" cols="80"></textarea>
            <input type="submit" name="submit" value="Submit" id="submit">
        </form>
    </div>
</div>

<style>
    h2{
        text-align:center;
        margin:50px;
    }
    .createTopic-wrapper{
        display:flex;
        justify-content:center;
        padding:50px;
    }

</style>