<?php
$post = $result["data"]["post"];
// var_dump($post);


?>


<p><?= $post->getContent()?></p>
<p>By <?= $post->getUser()?></p>
<p>Posted : <?= $post->getDateOfCreation()?></p>





<!-- // comment recupérer le title du topic relatif au post ?
object(Model\Entities\Post)#5 (5) {
    
    ["id":"Model\Entities\Post":private]=> int(2) 
    ["content":"Model\Entities\Post":private]=> string(50) "AI will change the world in ways we can't imagine!"
    ["dateOfCreation":"Model\Entities\Post":private]=> string(19) "2025-01-05 15:05:00"
    ["topic":"Model\Entities\Post":private]=> object(Model\Entities\Topic)#4 (6)
    
    { ["id":"Model\Entities\Topic":private]=> int(2)
        ["title":"Model\Entities\Topic":private]=> string(18) "Advancements in AI"      <======= ICI
        ["user":"Model\Entities\Topic":private]=> object(Model\Entities\User)#7 (7)
        
        { ["id":"Model\Entities\User":private]=> int(1)
            ["userName":"Model\Entities\User":private]=> string(7) "johnDoe"
            ["password":"Model\Entities\User":private]=> string(18) "password1Password@"
            ["role":"Model\Entities\User":private]=> string(5) "admin"
            ["email":"Model\Entities\User":private]=> string(17) "user1@example.com"
            ["registrationDate":"Model\Entities\User":private]=> string(19) "2025-01-01 10:00:00"
            ["avatar":"Model\Entities\User":private]=> NULL
        }
        
        ["category":"Model\Entities\Topic":private]=> object(Model\Entities\Category)#8 (2)
        
            { ["id":"Model\Entities\Category":private]=> int(1)
                ["categoryName":"Model\Entities\Category":private]=> string(10) "Technology"
            }
            
            ["dateOfCreation":"Model\Entities\Topic":private]=> string(19) "2025-01-05 15:00:00"
            ["closed":"Model\Entities\Topic":private]=> int(0)
            }
            
            ["user":"Model\Entities\Post":private]=> object(Model\Entities\User)#6 (7) 
            
                { ["id":"Model\Entities\User":private]=> int(1)
                    ["userName":"Model\Entities\User":private]=> string(7) "johnDoe"
                    ["password":"Model\Entities\User":private]=> string(18) "password1Password@"
                    ["role":"Model\Entities\User":private]=> string(5) "admin"
                    ["email":"Model\Entities\User":private]=> string(17) "user1@example.com"
                    ["registrationDate":"Model\Entities\User":private]=> string(19) "2025-01-01 10:00:00"
                    ["avatar":"Model\Entities\User":private]=> NULL } } -->


            