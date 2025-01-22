<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?= $meta_description ?>">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
        <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/style.css">
        <!-- SCRIPT -->
         <!-- <script src="public/script.js"></script> -->
        <!-- CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" /><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- FONTS -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Istok+Web:ital,wght@0,400;0,700;1,400;1,700&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
        <title>FORUM</title>
    </head>
    <body>
        <div id="wrapper"> 
            <div id="mainpage">
                <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
                <h3 class="message" style="color: red; text-align: center"><?= App\Session::getFlash("error") ?></h3>
                <h3 class="message" style="color: var(--bright-green); text-align: center"><?= App\Session::getFlash("success") ?></h3>
                <header>
                    <nav>
                        <div id="nav__logo">
                            <img src="public/logo/cloud-speech.svg" alt="">
                            <h1>Forum</h1>
                        </div>
                        <div id="nav-links">
                            <a href="index.php">Home page</a>
                            <a href="index.php?ctrl=forum&action=index">List of categories</a>
                            <?php
                            if(App\Session::isAdmin()){
                                ?>
                                <a href="index.php?ctrl=home&action=users">See all users</a>
                            <?php
                         } 
                         ?>
                        </div>
                        <div class="nav__search-bar">
                            <input class="search" type="text" ><i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <div id="nav-right">
                        <?php
                            // si l'utilisateur est connecté 
                            if(App\Session::getUser()){
                                ?>
                                <div class="connecterUser-container"><a class="connectedUser" href="index.php?ctrl=security&action=profile"><span class="fas fa-user"></span>&nbsp;<?= App\Session::getUser()?></a></div>
                                <a class="signOut-button sign" href="index.php?ctrl=security&action=logout">Déconnexion</a>
                                <?php
                            }
                            else{
                                ?>
                                <a class="sign signIn" href="index.php?ctrl=security&action=login">Sign In</a>
                                <a class="sign signUp" href="index.php?ctrl=security&action=register">Sign Up</a>
                                
                            <?php
                            }
                        ?>
                        </div>
                    </nav>
                </header>
                
                <main id="forum">
                    <?= $page ?>
                </main>
            </div>
            <footer>
                <div id="footer-left">
                    <p>Get Started</p>
                    <a href="">Today's post</a>
                    <a href="">Introduce yourself</a>
                    <a href="">Whatever</a>
                </div>
                <div id="footer-middle">
                    <p>Info</p>
                    <a href="#">Contact us</a>
                    <a href="#">Guidelines</a>
                    <a href="#">Legal notice</a>
                    <p id="small">&copy; <?= date_create("now")->format("Y") ?></p>
                </div>
                <div id="footer-right">
                    <p>Follow us</p>
                    <div class="socials"><img src="public/icons/facebook.png" alt=""><a href="#">Facebook</a></div>
                    <div class="socials"><img src="public/icons/tik-tok.png" alt=""><a href="#">Twitter</a></div>
                    <div class="socials"><img src="public/icons/twitter.png" alt=""><a href="#">Tik Tok</a></div>
    
                </div>
               
            </footer>
        </div>
        
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous">
        </script>
        <script>
            $(document).ready(function(){
                $(".message").each(function(){
                    if($(this).text().length > 0){
                        $(this).slideDown(500, function(){
                            $(this).delay(3000).slideUp(500)
                        })
                    }
                })
                $(".delete-btn").on("click", function(){
                    return confirm("Etes-vous sûr de vouloir supprimer?")
                })
                tinymce.init({
                    selector: '.post',
                    menubar: false,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime media table paste code help wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                    content_css: '//www.tiny.cloud/css/codepen.min.css'
                });
            })
        </script>
        <script src="<?= PUBLIC_DIR ?>/js/script.js"></script>
    </body>
</html>