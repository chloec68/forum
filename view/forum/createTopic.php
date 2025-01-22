<?php
    $category=$result['data']['category'];
?>
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


   

