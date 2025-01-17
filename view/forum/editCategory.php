<?php
  $category = $result["data"]['category'];
?>

<h1>Edit category</h1>

<form action="index.php?ctrl=forum&action=editCategory&id=<?= $category->getId() ?>" method="post" onsubmit="clearInput()">
    <label for="updatedCategory">new category name:</label>
    <br>
    <input  name="updatedCategory" id="updatedCategory"  value="<?= $category->getCategoryName()?>"> </input>
    <br>
    <input type="submit" name="submit" value="Submit" id="submit">
</form>

