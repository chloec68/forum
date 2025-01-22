<?php
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']; 
?>
<div class="wrapper">
    <h1>Posts</h1>


    <div class="listPosts__posts-wrapper">

        <?php if($posts){
            foreach($posts as $post){?>
                <div class="listPosts__singlePost">
                    <div class="user">
                        <img id="avatar" src="public/avatar/avatar1.jpg" alt="avatar1">
                        <p>nickname</p>
                    </div>
                    <div class="post-links-and-path">
                            <div class="post-path">
                                <p class="path">category/<?=$topic->getTitle()?></p>
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
        }
        ?>
        
    </div>


    <div class="form-wrapper topics__wrapper-form">
        <form action="index.php?ctrl=forum&action=createPost&id=<?= $topic->getId()?>" method="post">
            <label for="new">New Post:</label>
            <br>
            <textarea  name="content" id="new" rows="10" cols="80"> </textarea>
            <br>
            <input type="submit" name="submit" value="Submit" id="submit">
        </form>
    </div>

</div>