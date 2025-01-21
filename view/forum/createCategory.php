<?php
    $message = $result['data']['message'];
?>


<p><?= $message ?></p>
        <div class="page createCategory-wrapper">
            <form action="index.php?ctrl=forum&action=createCategory" method="post">
                <label class="createCategory-label" for="new">Create a category:</label>
                <br>
                <input class="createCategory-input" name="categoryName" id="new" type="text"> </input>
                <br>
                <input type="submit" name="submit" value="submit" id="createCategory-submit">
            </form>
        </div>






