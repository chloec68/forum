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

        $message = "";

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        $result = [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "categories",
            "data" => [
                "categories" => $categories,
                "message" =>$message
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
        $topic = $topicManager ->findOneById($id);
        $posts = $postManager->findPostsByTopic($id);

        if(empty($posts)){
            echo "no post yet";
            exit;
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

        $categoryName ="";
        $message=null;

        if(isset($_POST['submit'])){
            
            $categoryName = filter_input(INPUT_POST,"categoryName",FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($categoryName){
                $categoryManager->add(["categoryName" => $categoryName]);
                // $message = "Category successfully created";
                header("Location: index.php?ctrl=forum&action=index");
                exit;
            }else{
                $message = "Error : couldn't create category";
            }
        }

        $categories = $categoryManager->findAll(["categoryName","ASC"]);

        $result = [
            "view" => VIEW_DIR. "forum/createCategory.php",
            "meta_description" => "create a category",
            "data" => [
                "categories" =>$categories,
                "categoryName"=>$categoryName,
                "message"=>$message
            ]
        ];

        return $result;
        
    }
    // creation de fonction qui permet d'ajouter un topic à une catégorie
    // je mets en paramètres l'id de la catégorie afin de la récupérer dans l'url
    public function createTopic($idCategory){

        // je crée une nouvelle instance de topic manger. La couche modèle s'occupe de la logique métier ( la couche qui d'occupe ds données et de l'accès à la bdd)
        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $postManager = new PostManager();

        // le form d'ajout est dans ma vue détail catégorie, je vérifie que la mathod du form est bien en post et que la methode s'appelle bien create topic
        $newTopic = filter_input(INPUT_POST,"title",FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $firstPost = filter_input(INPUT_POST,"firstPost",FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Je teste si le filtre est bien appliqué à ma variable ; 
        // var_dump($newTopic);
        // var_dump($firstPost);
        // die;

        // j'ai filtré mes données venant du form pour me protéger de la faille XSS
        $category = $categoryManager->findOneById($idCategory);

        
        // Si la sanitisation s'est bien passé pour les DEUX champs (car je souhaite que le créateur d'un topic crée obligatoirement un premier post)
        if($newTopic && $firstPost){
            // j'appelle la fonction add de mon topic Manager
            // Mon topicManager n'a pas de fonction add mais hérite du manager général 
            // grâce au principe d'héritage, une classe fille (topic manager) peut hériter des classes de sa classe mère (manager)
            $topicManager->add(['title' => $newTopic,
                                'user_id'=>"1",
                                'category_id'=>$idCategory,
                                'closed'=>0]);
            // j'appelle le post manager pour pouvoir hériter du add
            // $postManager->add(['content'=>$firstPost]);

            header("Location: index.php?ctrl=forum&action=listTopicsByCategory&id=$idCategory");
            exit;
        }else{
            echo "You must write a first post if you wish to create a topic";
            die;
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
        //Je crée une nouvelle instance de PostManager 
        $postManager = new PostManager();
        $topicManager = new TopicManager();

        $newPost = filter_input(INPUT_POST,"content",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // var_dump($newPost);
        // die;

        $topic = $topicManager->findOneById($idTopic);
        // var_dump($topic);
        // die;

        if($newPost){
            $postManager->add(["content"=>$newPost,
                                "topic_id"=>$idTopic,
                                "user_id"=>"2"]);
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

            header("Location:index.php");
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
        $message="";

        if($category){
            $categoryManager->delete($id);// je passe l'id à la méthode delete() du CategoryManager // ou $categoryManager->delete($category['id]);
            header("Refresh:0");
            $message = "Category " . $category->getCategoryName() . " has been sucessfully deleted";
            exit;
        // }else{
            // $message = "Category not found or already deleted";
        }

      
        return [
            "view" => VIEW_DIR. "forum/listCategories.php",
            "meta_description" => "", 
            "data" => [
                "message" => $message,// passage du message à la vue ; inutile de passes les informations de la cat supprimée qui ne seront plus dispo en BDD;
                "categories" => $categories // obligée de passer toutes les catégories car la vue contenait déjà $categories en raison de la méthode index() qui renvoie à la même vue
               
            ]
        ];
    }

    public function deleteTopicAndRelatedPosts($id){
        $topicManager = new TopicManager(); 
        $postManager = new PostManager();

        $topic = $topicManager -> findOneById($id); 
        $relatedPosts = $postManager -> findPostsByTopic($id);    


        if($topic){
            $topicManager->delete($id);
            $postManager->delete($id);
            $message = "Topic and all related posts sucessfully deleted";
            header('Location : index.php');
        }else{
            $message = "Error - couldn't delete topic and related posts";
        }

        return [
            "view" => VIEW_DIR. "forum/deleteTopic.php",
            "meta_description" => "", 
            "data" => [
                "message" => $message,
                "topic" => $topic,
            ]
        ];
    }

}

