<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>

<div class="wrapper">
    <h1>Topics</h1>
    <div class="content">
        <div class="topics-container">
            <?php
            foreach($topics as $topic ){ ?>
            <div class="container topic-container">
                <p class="name topicName"><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $topic->getId() ?>"><?= $topic ?></a></p> 
                <br>
                    <p><a href="PROFIL USER"><img id="avatar" src="public/avatar/avatar1.jpg" alt="avatar1">by <?= $topic->getUser() ?></p>
                    <hr id="line">
                    <p class="update topicUpdate"><a href="index.php?ctrl=forum&action=editTopic&id=<?= $topic->getId()?>"><i class="fa-solid fa-pen"></i> Update topic</a></p>
            </div>
            <?php
            }
            ?>
        </div>
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
