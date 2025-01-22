<?php 
    $user = $result['data']['user'];
    $posts = $result['data']['posts'];
?>

<p><?= $user->getUserName()?></p>
<p><?= $user->getEmail()?></p>
<p><?= $user->getRegistrationDate()?></p>
<p><?=$user->getAvatar()?><p>
<p><?= $user->getRole()?></p>

<?php 
if($posts){
    foreach($posts as $post){
?>
        <p><a href="index.php?ctrl=forum&action=displayPost&id=<?= $post->getId() ?>"><?=$post->getTopic()?></a></p>
    <?php
    }
    ?>
<?php
}
?>
