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

        $userManager = new UserManager(); 
        $message="";
        $user ="";
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

            $regex = " /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/ ";
            // var_dump($test = preg_match($regex,$pass1));die;
            
            if(preg_match($regex,$pass1)){

                $user = $userManager->findUser($email);
            // var_dump($user);die;

                if($user){
                    // var_dump($user);die;
                    header("Location: index.php?ctrl=security&action=login");

                }else{
                    // si l'utilisateur n'existe pas, on l'ajoute en BDD
                    if($pass1==$pass2 && strlen($pass1)>=12){

                        $data = ["userName" => $userName,
                                "email"=> $email,
                                "password"=>password_hash($pass1,PASSWORD_DEFAULT),
                                "role"=>"user"];
                
                        $user = $userManager->add($data);
                        $message="Signed up!";
            
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
            }
        }

            

        return [
            "view" => VIEW_DIR. "security/register.php",
            "meta_description" => "register",
            "data" => [
                "message" => $message,
                "user" => $user
            ]
        ];
    }

    public function login(){
        // session_start();  "Ignoring session_start() because a session is already active : index.php on line 23"; 
        // Rappel : nécessaire de démarrer une session pour utiliser la superglobale $_SESSION;
        $userManager = new UserManager;

        $email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_VALIDATE_EMAIL); 
        $password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $message="";

            if($email && $password){
                // var_dump($password);
                // var_dump($email);die;
                $user = $userManager->findUser($email);
    
                // var_dump($user);die;
                //Output : object(Model\Entities\User)#4 (3) {
                    // ["id":"Model\Entities\User":private]=> int(4)
                    // ["userName":"Model\Entities\User":private]=> string(7) "newUser"
                    // ["password":"Model\Entities\User":private]=> NULL } 
                    // Pourquoi private ? => ce sont des attributs définis privés dans la classe User d'où est instancié $user
    
                if ($user){
                    // note: $user n'est pas un tableau, mais un objet donc $hash = $user["password"] renvoie une erreur
                    // donc $user->password ; Or password est une propriété privée, donc utilisation d'une méthode publique pour y accéder
                    // et nécessité de définir une méthode publique setPassword() en raison de la méthode d'hydratation d'Entities
                   
                    $hash = $user->getPassword();
                    // var_dump($hash);die;
                    // $check = password_verify($password,$hash) ; 
                    // var_dump($check); die;

                    if($hash && password_verify($password,$hash)){
                        $_SESSION["user"]=$user;
                        header("Location: index.php?ctrl=home&action=index");
                    }else{
                        $message="User unknown or wrong password";
                        header("Location: index.php?ctrl=security&action=login");
                    }

                }else{
                    $message = "User unknown or wrong password";
                    header("Location : index.php?ctrl=security&action=login");
                }
            }
    
            return[
                "view" => VIEW_DIR. "security/login.php",
                "meta_description" => "logIn",
                "data" => [
                    "message" => $message
                ]
            ];
    }
    
    public function logout() {
        unset($_SESSION["user"]);
        header("Location : index.php?ctrl=home&action=index");
    }
}








// Recommandations CNIL relatives aux mots de passe : 
// Pour un mot de passe de douze caractères ou plus, votre phrase doit contenir au moins :

// Un nombre
// Une majuscule
// Un signe de ponctuation ou un caractère spécial (dollar, dièse, ...)
// Une douzaine de mots


// preg_match() => recherche correspondance avec une expression rationnelle (REGEX)
// paramètre 1 : regex
// paramètre 2 : mot de passe en clair

// $regex = " /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/ ";
// preg_match($regex,$pass1);
// génère 0 si pas de correspondance, 1 si correspondance
