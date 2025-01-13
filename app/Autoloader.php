<?php
namespace App;

class Autoloader{

	public static function register(){
		spl_autoload_register(array(__CLASS__, 'autoload'));
						}
								// méthode statique de la classe Autoloader qui enregistre une fonction de rappel (callback)
								// lorsque register() est appelée, elle enregistre la méthode autoload()
								// si on tente d'utiliser une classe qui n'est pas encore définie, PHP appelle automatiquement
								//la méthode autoload qui devra charger le fichir correspond à la classe demandée (si le fichier existe)


	public static function autoload($class){
								// méthode statique de la classe Autoloader qui charge les classes automatiquement 
								// (pas besoin de require ou include chaque classe)

		//$class = Model\Managers\TopicManager (FullyQualifiedClassName)
		//namespace = Model\Managers, nom de la classe = TopicManager

		// on explose notre variable $class par \
		$parts = preg_split('#\\\#', $class);
		//$parts = ['Model', 'Managers', 'TopicManager']
								//preg_split() est une fonction PHP qui permet de diviser une chaîne de caractères ($class) en un tableau en utilisant
								// une expression régulière comme délimiteur ("#\\\#").
								//La fonction preg_split() va diviser la chaîne $class en parties en utilisant chaque antislash (\) comme séparateur.
								// Elle retourne un tableau contenant toutes les parties de la chaîne, séparées par les antislashs.

		// on extrait le dernier element 
		$className = array_pop($parts);
		//$className = TopicManager
								//array_pop() -> fonction PHP qui extrait le dernier élément d'un tableau et le retourne en le supprimant du
								// tableau 

		// on créé le chemin vers la classe
		// on utilise DS car plus propre et meilleure portabilité entre les différents systèmes (windows/linux) 

		$path = strtolower(implode(DS, $parts));
		//$path = 'model/manager'
		$file = $className.'.php';
		//$file = TopicManager.php

		$filepath = BASE_DIR.$path.DS.$file;
		//$filepath = model/managers/TopicManager.php
		if(file_exists($filepath)){
			require $filepath;
		}
	}
}
