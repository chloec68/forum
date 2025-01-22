<?php
    $categories = $result["data"]['categories']; 


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

<div class="createCategory__container">
    <div class="createCategory-border">
        <a class="createCategory-link" href="index.php?ctrl=forum&action=createCategory">Create a category <i class="fa-solid fa-plus"></i></a>
    </div>
</div>
<div class="wrapper">
    <h1>Categories</h1>
    <div class="content">
            <div class="categories-container">
                <?php
                foreach($categories as $category ){ ?>
                    <div class="container category-container">
                        <p class="name categoryName"><a href='index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>'><?= $category->getCategoryName() ?></a></p>
                        <hr id="line">
                        <div class="options">
                            <p class="update categoryUpdate"><a href="index.php?ctrl=forum&action=editCategory&id=<?= $category->getId() ?>"><i class="fa-solid fa-pen"></i> Update</a></p>
                            <p class="delete categoryDelete"><a href="index.php?ctrl=forum&action=deleteCategory&id= <?= $category->getId()?>"><i class="fa-solid fa-delete-left"></i> Delete</a></p>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
    </div>
</div>


<style>
    .createCategory-link{
        text-decoration:none;
        color:var(--white);
    }

    .createCategory__container{
        display:flex;
       justify-content:flex-end;
       margin:20px;
    }

    .createCategory-border{
        border:2px solid var(--purple);
        background-color:var(--purple);
        border-radius:4px;
        padding:2px;
    }
</style>