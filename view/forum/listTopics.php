<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>

<h1>Liste des topics</h1>

<?php
foreach($topics as $topic ){ ?>
    <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $topic->getId() ?>"><?= $topic ?></a> par <?= $topic->getUser() ?></p> 
    <p><a href="index.php?ctrl=forum&action=editTopic&id=<?= $topic->getId()?>">Update topic</a></p>
<?php
}
?>

<p>New Topic:</p>
<form action="index.php?ctrl=forum&action=createTopic&id=<?= $category->getId()?>" method="post">
    <label for="title">Title:</label>
    <br>
    <input type="text" name="title" id="title"> </input>
    <br>
    <label for="">Premier post du topic:</label>
    <br>
    <textarea name="firstPost" id=""></textarea>
    <input type="submit" name="submit" value="Submit" id="submit">
</form>



