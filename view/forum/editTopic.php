<?php 
$topic = $result['data']['topic'];
?>

<form action="index.php?ctrl=forum&action=editTopic&id= <?= $topic->getId() ?>" method="post">
    <label for="title">Edit topic</label>
    <input type="text" name="title" id="title" value=" <?= $topic->getTitle() ?>">
    <input type="submit" value="update">
</form>
