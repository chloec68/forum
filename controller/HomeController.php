<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;
use Model\Managers\PostManager;

class HomeController extends AbstractController implements ControllerInterface {

    public function index(){
        return [
            "view" => VIEW_DIR."home.php",
            "meta_description" => "Page d'accueil du forum"
        ];
    }
        
    public function users(){
        $this->restrictTo("ROLE_USER");

        $manager = new UserManager();
        $users = $manager->findAll(['registrationDate', 'DESC']);

        return [
            "view" => VIEW_DIR."security/users.php",
            "meta_description" => "Liste des utilisateurs du forum",
            "data" => [ 
                "users" => $users 
            ]
        ];
    }

    public function userProfile($id){
        $userManager = new UserManager();
        $user = $userManager->findOneById($id);

        $postManager = new PostManager();
        // ici les posts ne sont pas récupérés : $posts = NULL
        $posts = $postManager->findPostsByUser($id);

        return [
            "view" => VIEW_DIR. "security/userProfile.php",
            "meta_description" => "User's profile",
            "data" => [
                "user"=>$user,
                "posts"=>$posts
            ]
        ];
    }

}