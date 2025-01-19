<?php
    $message = $result['data']['message'];
?>


<p><?= $message ?></p>
        <div class="form-wrapper categories__wrapper-form">
            <form action="index.php?ctrl=forum&action=createCategory" method="post">
                <label for="new">Create a category:</label>
                <br>
                <input  name="categoryName" id="new"> </input>
                <br>
                <input type="submit" name="submit" value="submit" id="submit">
            </form>
        </div>



