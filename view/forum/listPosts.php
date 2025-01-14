<?php
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']; 
    $content = 
?>

<h1>Posts</h1>

<?php
foreach($posts as $post ){ ?>
    <p><?= $post ?></p><br>
<?php
}
?>

<p>New Post:</p>
<form action="index.php?ctrl=forum&action=createPost&id=<?= $topic->getId()?>" method="post">
    <label for="content">Title:</label>
    <br>
    <textarea  name="content" id="content"> </textarea>
    <br>
    <input type="submit" name="submit" value="Submit" id="submit">
</form>
