<?php
$post = $result["data"]["post"];
?>

<div class="listPosts__posts-wrapper">

<?php if($post){
?>
        <div class="listPosts__singlePost">
            <div class="post-links-and-path">
                    <div class="post-path">
                        <p class="path">Topic/<?=$post->getTopic()->getTitle() ?></p>
                    </div>
                    <div class="post-links">
                        <p><i class="fa-solid fa-square-share-nodes"></i></p>
                        <p>2 <i class="fa-regular fa-message"></i></p>
                        <p>1 min ago</p>
                    </div>
            </div>
            <p><?= $post ?></p><br>
        </div>
<?php
    }
?>

</div>