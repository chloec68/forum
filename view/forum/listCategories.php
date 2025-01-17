<?php
    $categories = $result["data"]['categories']; // renvoie un tableau de résultats assigné à la variable $categories

    /*
    $result = [
        "view" => "forum/listCategories.php",
        "meta_description" => "Liste des catégories du forum",
        "data" => [
            "categories" => $categories // Ce qui est probablement un tableau d'objets ou un tableau associatif représentant les catégories
        ]
    ];

    => $result est une variable qui contient les données envoyées à la vue par le CONTROLLER
    */

    /*
    $categories = [
        ['id' => 1, 'categoryName' => 'Science'],
        ['id' => 2, 'categoryName' => 'Technology'],
        ['id' => 3, 'categoryName' => 'Arts']
    ];
    */
?>

<h1>Categories</h1>

<?php
foreach($categories as $category ){ ?>
    <p><a href='index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>'><?= $category->getCategoryName() ?></a></p>
    <p><a href="index.php?ctrl=forum&action=editCategory&id=<?= $category->getId() ?>">Update</a></p>
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
