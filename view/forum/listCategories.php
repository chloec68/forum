<?php
    $categories = $result["data"]['categories']; 
?>

<h1>Categories</h1>

<?php
foreach($categories as $category ){ ?>
    <p><a href='index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>'><?= $category->getCategoryName() ?></a></p>
<?php
}
?>

<p>Create a category:</p>
<form action="index.php?ctrl=forum&action=createCategory" method="post">
    <label for="categoryName">Category name:</label>
    <br>
    <input  name="categoryName" id="categoryName"> </input>
    <br>
    <input type="submit" name="submit" value="Submit" id="submit">
</form>
