<?php
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']; 
?>

<h1>Posts</h1>

<?php if($posts){
    foreach($posts as $post){?>
    <p><?= $post ?></p><br>
<?php
    }
}
?>


<div class="form-wrapper topics__wrapper-form">
        <form action="index.php?ctrl=forum&action=createPost&id=<?= $topic->getId()?>" method="post">
            <label for="new">New Post:</label>
            <br>
            <textarea  name="content" id="new" rows="10" cols="80"> </textarea>
            <br>
            <input type="submit" name="submit" value="Submit" id="submit">
        </form>
    </div>

