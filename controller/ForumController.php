<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
/* La déclaration use App\Session, etc permet de pouvoir étendre les classes sans avoir à spécifier leur chemin complet (namespace \ classname) car le chemin complet est déjà
spécifié ici ; 
Sinon on devrait écrire : class ForumController extends App\AbstractController implements App\ControllerInterface {} */

class ForumController extends AbstractController implements ControllerInterface{

    public function index() {
        
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categoryManager->findAll(["categoryName", "ASC"]); 

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        $result = [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "categories",
            "data" => [
                "categories" => $categories,
            ]
        ];

        return $result;
    }

    public function listTopicsByCategory($id) {

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id);

        if(empty($topics)){
            $message = "No topic yet";
            return [
                "view" => VIEW_DIR."forum/createTopic.php",
                "meta_description" => "create Topic",
                "data" => ["category"=>$category,
                "message"=>$message]
            ];
           
        }else{

            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "meta_description" => "Topics by category : ".$category,
                "data" => [
                    "category" => $category,
                    "topics" => $topics
                ]
            ];
        }
    }

    public function listPostsByTopic($id){
        $postManager = new PostManager();
        $topicManager = new TopicManager();

        $session = new Session();
        $topic = $topicManager ->findOneById($id);
        $posts = $postManager->findPostsByTopic($id);

        if(empty($posts)){
            $session->addFlash("error","No post yet");
        };
        
        return [
            "view" => VIEW_DIR. "forum/listPosts.php",
            "meta_description" => "Liste des posts par topic :".$topic,
            "data" => [
                "topic" => $topic,
                "posts" => $posts
            ]
        ];
    }


    function createCategory(){
        $categoryManager = new CategoryManager();
        $session = new Session();

        $this->restrictTo("ROLE_USER");

        $categoryName ="";

        if(isset($_POST['submit'])){
            
            $categoryName = filter_input(INPUT_POST,"categoryName",FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($categoryName){
                $categoryManager->add(["categoryName" => $categoryName]);
                $session->addFlash("success","Category sucessfully created");
                header("Location: index.php?ctrl=forum&action=index");
                exit;
            }else{
                $session->addFlash("error","Error : couldn't create category");
            }
        }

        $categories = $categoryManager->findAll(["categoryName","ASC"]);

        $result = [
            "view" => VIEW_DIR. "forum/createCategory.php",
            "meta_description" => "create a category",
            "data" => [
                "categories" =>$categories,
                "categoryName"=>$categoryName,
            ]
        ];

        return $result;
        
    }

    // creation de fonction qui permet d'ajouter un topic à une catégorie
    // je mets en paramètres l'id de la catégorie afin de le récupérer dans l'url
    public function createTopic($idCategory){

        // je crée une nouvelle instance de topic manger. La couche modèle s'occupe de la logique métier ( la couche qui d'occupe ds données et de l'accès à la bdd)
        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $postManager = new PostManager();
        $session = new Session();

        $user = $session->getUser();
        $category = $categoryManager->findOneById($idCategory);
        if(isset($user) && $user !==false){
            $userId = $user->getId();
            $newTopic = filter_input(INPUT_POST,"title",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $firstPost = filter_input(INPUT_POST,"firstPost",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           
            if($newTopic && $firstPost){

                $idTopic = $topicManager->add(['title' => $newTopic,
                'user_id'=>$userId,
                'category_id'=>$idCategory,
                'closed'=>0]);

                $postManager->add([
                    "content"=>$firstPost,
                    "user_id"=>$userId,
                    "topic_id"=>$idTopic
                ]);

                $session->addFlash("success","Success!");
                header("Location: index.php?ctrl=forum&action=listTopicsByCategory&id=$idCategory");
                exit;
            }else{
                $session->addFlash("error","you must type a first post if you wish to create a topic");
                header("Location: index.php?ctrl=forum&action=listTopicsByCategory&id=$idCategory");
                die;
            }
        }else{
            $session->addFlash('error','you must be connected');
        }
        $topics = $topicManager->findAll(["title","ASC"]);

        return [
            "view" => VIEW_DIR. "forum/listTopics.php",
            "meta_description" => "New topic",
            "data" => [
                "topics" => $topics,
                "category"=>$category,
            ]
        ];
    }


    //Je crée une fonction pour ajouter un nouveau post dans un topic 
    //Je mets l'id (du topic) en paramètre afin de le récupérer dans l'URL

    public function createPost($idTopic){

        $postManager = new PostManager();
        $topicManager = new TopicManager();
        $session = new Session();

        $user = $session->getUser();
        $topic = $topicManager->findOneById($idTopic);
        if(isset($user) && $user!==false){
            $userId = $user->getId();
            $newPost = filter_input(INPUT_POST,"content",FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($newPost){
                $postManager->add(["content"=>$newPost,
                                    "topic_id"=>$idTopic,
                                    "user_id"=>$userId]);
            }
        }else{
            $session->addFlash('error','you must be connected');
        }

        $posts = $postManager->findAll(["content","ASC"]);

        return [
            "view" => VIEW_DIR. "forum/listPosts.php",
            "meta_description" => "New post",
            "data" => [
                "topic" => $topic,
                "posts" => $posts
                ]
            ];
    }

    public function editCategory($idCategory){
        $categoryManager = new CategoryManager(); 
     
        $category = $categoryManager->findOneById($idCategory);
        // var_dump($category);
        $this->restrictTo("ROLE_USER");

        $updatedCategory = filter_input(INPUT_POST,"updatedCategory",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     
        if($updatedCategory){
            $categoryManager->edit( $idCategory,["categoryName"=>$updatedCategory]);
            header("Location:index.php?ctrl=forum&action=index");
            exit;
        }

        return [
            "view" => VIEW_DIR. "forum/editCategory.php",
            "meta_description" => "New category",
            "data" => [
                "updatedCategory" => $updatedCategory,
                "category" => $category
            ]
        ];
    }

    public function editTopic($idTopic){
        $topicManager = new TopicManager(); /* j'instancie un nouvel objet topicManager qui hérite de toutes les classes publiques et protégées
        de la classe abstraite Manager car la classe TopicManager étend la classe Manager - les méthodes (publiques et protégées) sont disponibles pour
        les instances de TopicManager */
        /* la classe TopicManager hérite donc de la méthode publique findOneById($id), edit() et de la méthode protégée connect() */

        $session = new Session();

        $this->restrictTo("ROLE_USER");

        $topic = $topicManager -> findOneById($idTopic); // j'appelle la méthode findOneById() sur l'objet $topicManager et je contiens le résultat dans la variable $topic

        $updatedTopic = filter_input(INPUT_POST,"title",FILTER_SANITIZE_FULL_SPECIAL_CHARS); /* "Je récupère la valeur du champ 'updatedCategory' du formulaire $_POST,
        et je la filtre pour en sécuriser les caractères spéciaux, puis je la stocke dans la variable $updatedTopic." */
        /* filter_input() => cette fonction récupère une valeur d'entrée (ici depuis la super globale $_POST) */ 
        /* INPUT_POST => indique que l'entrée vient de $_POST => le formulaire envoyé en méthode POST */
        /* updatedCategory => nom du champ du formulaire (clé du tableau $_POST)
        /* FILTER_SANITIZE_FULL_SPECIAL_CHARS => supprime ou échappe tous les caractères spéciaux */

        if($updatedTopic){ //si la valeur de $updatedCategory n'est pas FALSE (NULL, empty string, nombre 0, tableau vide []) // si la valeur  est TRUE 
                            // permet de vérifier qu'une valeur a été récupérée et donc filtrée 
            $topicManager->edit($idTopic,["title"=>$updatedTopic]); /*J'appelle la méthode edit() sur l'objet $topicManager et je lui passe en paramètre
            l'identifiant du topic ($idTopic) ainsi qu'un tableau associatif contenant la clé "title" et la valeur associée à $updatedTopic. */

            $session->addFlash("success","Topic successfully updated");

            header("Location: index.php?ctrl=home&action=index");
            exit;
        }

        return [
            "view" => VIEW_DIR. "forum/editTopic.php",
            "meta_description" => "New Topic",
            "data" => [
                "updatedTopic" => $updatedTopic,
                "topic" => $topic
            ]
        ];

    }

    public function deleteCategory($id){
        $categoryManager = new CategoryManager(); // création d'une nouvelle instance de la classe CategoryManager qui va me permettre de gérer la logique métier liée aux catégories (suppression ici)
        $categories = $categoryManager->findAll(["categoryName", "ASC"]); //
        $category = $categoryManager->findOneById($id); // récupération d'une catégorie en fonction de son id
        $session = new Session();

        $this->restrictTo("ROLE_USER");

        if($category){
            $delete = $categoryManager->delete($id);
            if($delete){
                $session->addFlash("sucess","Category has been sucessfully deleted");
                header("Location: index.php?ctrl=forum&action=index");exit;
            }else{
                $session->addFlash("error","couldn't delete category");
                header("Location: index.php?ctrl=home&action=index");exit;
            }
        }
        
        return [
            "view" => VIEW_DIR. "forum/listCategories.php",
            "meta_description" => "", 
            "data" => [
                "categories" => $categories // obligée de passer toutes les catégories car la vue contenait déjà $categories en raison de la méthode index() qui renvoie à la même vue
            ]
        ];
    }

    public function deleteTopicAndRelatedPosts($id){
        $topicManager = new TopicManager(); 
        $postManager = new PostManager();

        $this->restrictTo("ROLE_USER");

        $session = new Session();

        $topic = $topicManager -> findOneById($id); 
        $relatedPosts = $postManager -> findPostsByTopic($id);    

        if($topic){
            $topicManager->delete($id);
            $postManager->delete($id);
            $session->addFlash("success","Topic successfully deleted");
            header("Location : index.php?ctrl=home&action=index");
        }else{
            $message = "Error - couldn't delete topic and related posts";
        }

        return [
            "view" => VIEW_DIR. "forum/listTopics.php",
            "meta_description" => "", 
            "data" => [
                "message" => $message,
                "topic" => $topic,
            ]
        ];
    }

    public function displayPost($id){
        $postManager = new PostManager();
        $post = $postManager->findOneById($id);
        // var_dump($post);

        $topicManager = new TopicManager();

        return[
            "view" => VIEW_DIR. "forum/singlePost.php",
            "meta_description" => "post", 
            "data" => [
                "post" => $post,
            ]
        ];
    }

}

