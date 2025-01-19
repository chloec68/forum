<?php
  $message = $result['data']['message'];
  $topic = $result['data']['topic'];
?>

<div class="wrapper">
    <h1>Delete this topic</h1>
    <div class="content">
        <div class="topics-container">
    
            <div class="container topic-container">
                <p class="name topicName"><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $topic->getId() ?>"><?= $topic ?></a></p> 
                <br>
                    <p><a href="PROFIL USER"><img id="avatar" src="public/avatar/avatar1.jpg" alt="avatar1">by <?= $topic->getUser() ?></p>
                    <hr id="line">
                    <p class="update topicUpdate"><a href="index.php?ctrl=forum&action=editTopic&id=<?= $topic->getId()?>"><i class="fa-solid fa-pen"></i> Update topic</a></p>
                    <p class="delete topicDelete"><a href="index.php?ctrl=forum&action=deleteTopicAndRelatedPosts&id= <?= $topic->getId() ?>"><i class="fa-solid fa-delete-left"></i>Delete</a></p>
            </div>
        </div>
