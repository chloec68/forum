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
<div class="wrapper">
    <div class="content">


        <h1>Categories</h1>

            <div class="categories-container">
                <?php
                foreach($categories as $category ){ ?>
                    <div class="category-container">
                        <p id="categoryName"><a href='index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>'><?= $category->getCategoryName() ?></a></p>
                        <hr id="line">
                        <p id="categoryUpdate"><a href="index.php?ctrl=forum&action=editCategory&id=<?= $category->getId() ?>"><i class="fa-solid fa-pen"></i> Update</a></p>
                    </div>
                <?php
                }
                ?>
            </div>
        <div class="form-wrapper">
            <form action="index.php?ctrl=forum&action=createCategory" method="post">
                <label for="newCategory">Create a category:</label>
                <br>
                <input  name="categoryName" id="newCategory"> </input>
                <br>
                <input type="submit" name="submit" value="Submit" id="submit">
            </form>
        </div>
    </div>
</div>
