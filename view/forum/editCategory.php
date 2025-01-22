<?php
  $category = $result["data"]['category'];
?>

<h1>Edit category</h1>
<div class="editCategory-wrapper">
<form action="index.php?ctrl=forum&action=editCategory&id=<?= $category->getId() ?>" method="post">
    <input  class = "editCategory-input" name="updatedCategory" placeholder="Edit category"  value="<?= $category->getCategoryName()?>"> </input>
    <br>
    <input type="submit" name="submit" value="Submit" id="edit-Category-submit">
</form>

</div>



