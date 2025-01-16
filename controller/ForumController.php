<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;

class ForumController extends AbstractController implements ControllerInterface{

    public function index() {
        
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categoryManager->findAll(["categoryName", "DESC"]);

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories
            ]
        ];
    }

    public function listTopicsByCategory($id) {

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id);

        if(empty($topics)){
            echo "no post yet";
            //ajouter lien "en créer un" ?
            exit;
        };

        return [
            "view" => VIEW_DIR."forum/listTopics.php",
            "meta_description" => "Liste des topics par catégorie : ".$category,
            "data" => [
                "category" => $category,
                "topics" => $topics
            ]
        ];
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

        $categoryName = filter_input(INPUT_POST,"categoryName",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // var_dump($newCategoryName);
        // die;

        if($categoryName){
            $categoryManager->add(["categoryName" => $categoryName]);
        }

        $categories = $categoryManager->findall(["categoryName","ASC"]);

        return [
            "view" => VIEW_DIR. "forum/listCategories.php",
            "meta_description" => "New Category",
            "data" => [
                "categories" =>$categories,
                "categoryName"=>$categoryName
            ]
        ];
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
        // var dump($newTopic);
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
                                'category_id'=>$idCategory]);
            // j'appelle le post manager pour pouvoir hériter du add
            $postManager->add(['content'=>$firstPost]);
        }else{
            echo "You must write a first post if you wish to create a topic";
            die;
        }
        $topics = $topicManager->findAll(["title","DESC"]);

        return [
            "view" => VIEW_DIR. "forum/listTopics.php",
            "meta_description" => "New topic",
            "data" => [
                "topics" => $topics,
                "category"=>$category
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

    editCategory($idCategory){
        $categoryManager = new CategoryManager(); 
        
        $updatedCategory = filter_input(INPUT_POST,"updatedCategory",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // var_dump($updatedCategory)
        // die; 

        $category = $categoryManager->findOneById($idCategory);
        //var_dump($category)
        //die;

        if($updatedCategory){
            $categoryManager->update(["updatedCategory"=>$updatedCategory]);
        }

        return [
            "view" => VIEW_DIR. "forum/listCategories.php",
            "meta_description" => "New category",
            "data" => [
                "updatedCategory" => $updatedCategory,
                "category" => $category
            ]
        ]
    }

}

