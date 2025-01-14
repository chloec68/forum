<?php
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']; 
?>

<h1>Posts</h1>

<?php
foreach($posts as $post ){ ?>
    <p><?= $post ?></p><br>
<?php }
