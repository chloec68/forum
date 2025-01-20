<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;

use Model\Managers\UserManager;

class SecurityController extends AbstractController{
    // contiendra les méthodes liées à l'authentification : register, login et logout

    public function register() {
        $userName = filter_input(INPUT_POST,"userName",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL); // on peut appliquer 2 filtres ici
        $pass1 = filter_input(INPUT_POST,"pass1",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pass2 = filter_input(INPUT_POST,"pass2",FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        //si le formulaire est soumis alors (...) sinon par défaut : header("Location: register.php");exit;
        // AJOUTER if($_POST["submit"]){}

        $userManager = new UserManager(); 
        $message="";
            // var_dump($userName);
            // var_dump($email);
            // var_dump($pass1);
            // var_dump($pass2);
            // die;
        if($userName && $email && $pass1 && $pass2){
            // var_dump($userName);
            // var_dump($email);
            // var_dump($pass1);
            // var_dump($pass2);
            // die;
            $user = $userManager->findUser($email);
            // var_dump($user);die;

            if($user){
                // si l'utilisateur existe => redirection vers logIn
                // $ctl="security";
                // $action="register";
                // redirectTo($security,$action)

                // var_dump($user);die;
            }else{
                 // si l'utilisateur n'existe pas, on l'ajoute en BDD
                if($pass1==$pass2 && strlen($pass1)>=2){

                    $data = ["userName" => $userName,
                            "email"=> $email,
                            "password"=>password_hash($pass1,PASSWORD_DEFAULT),
                            "role"=>"user"];
            
                    $user = $userManager->add($data);
                    $message="Signed up!";
                    // redirectTo(); =>redirection vers logIn
                }else{
                    if($pass1 !==$pass2){
                        $message = "passwords don't match";
                    }else if(strlen($pass1<12)){
                        $message= "password is too short";
                    }else{
                        $message = "couldn't create account";
                    }
                }
            }
                   
        // }else{
        //     $message = "error" ; 
        }

        return [
            "view" => VIEW_DIR. "security/register.php",
            "meta_description" => "register",
            "data" => [
                "message" => $message
            ]
        ];
    }

    public function login(){

        $userManager = new UserManager;

        $email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_VALIDATE_EMAIL); 
        $password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $message="";

        if($email && $password){
            var_dump($password);
            var_dump($email);

          (...................)
        }

        return[
            "view" => VIEW_DIR. "security/login.php",
            "meta_description" => "logIn",
            "data" => [
                "message" => $message
            ]
        ];
    }
    

    public function logout () {}
}





// - si les filtres passent, on retrouve le password correspondant au mail entré dans le formulaire 


