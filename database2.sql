-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forum_chloe
CREATE DATABASE IF NOT EXISTS `forum_chloe` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forum_chloe`;

-- Listage de la structure de table forum_chloe. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_chloe.category : ~0 rows (environ)
INSERT INTO `category` (`id_category`, `categoryName`) VALUES
	(1, 'Technology'),
	(2, 'Health'),
	(3, 'Science'),
	(4, 'Entertainment');

-- Listage de la structure de table forum_chloe. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `text` text,
  `dateOfCreation` datetime DEFAULT CURRENT_TIMESTAMP,
  `topic_id` int DEFAULT '0',
  `user_id` int DEFAULT '0',
  PRIMARY KEY (`id_post`),
  KEY `FK_post_user` (`user_id`),
  KEY `FK_post_topic` (`topic_id`),
  CONSTRAINT `FK_post_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_chloe.post : ~0 rows (environ)
INSERT INTO `post` (`id_post`, `text`, `dateOfCreation`, `topic_id`, `user_id`) VALUES
	(1, 'The newest tech trends are amazing!', '2025-01-04 14:05:00', 1, 1),
	(2, 'AI will change the world in ways we can\'t imagine!', '2025-01-05 15:05:00', 2, 1),
	(3, 'Eating healthy is important for longevity.', '2025-01-06 16:05:00', 3, 2),
	(4, 'Taking care of mental health is vital for overall well-being.', '2025-01-07 17:05:00', 4, 2),
	(5, 'Space exploration is advancing rapidly, and it\'s exciting!', '2025-01-08 18:05:00', 5, 3),
	(6, 'We are on the verge of some groundbreaking scientific discoveries!', '2025-01-09 19:05:00', 6, 3),
	(7, 'Electric vehicles are the future, and we should all embrace them!', '2025-01-10 20:05:00', 7, 1),
	(8, 'The pandemic is still affecting many lives, we need to stay strong.', '2025-01-11 21:05:00', 8, 2),
	(9, 'Can\'t wait to see the new blockbuster films this year!', '2025-01-12 22:05:00', 9, 3),
	(10, '2025 is shaping up to be a fantastic year for new tech gadgets.', '2025-01-13 23:05:00', 10, 1),
	(11, 'We need to keep pushing the boundaries of artificial intelligence.', '2025-01-05 15:10:00', 2, 1),
	(12, 'Healthy eating habits are essential, but it\'s not always easy.', '2025-01-06 16:10:00', 3, 2),
	(13, 'It\'s important to check in on your mental health regularly.', '2025-01-07 17:10:00', 4, 2),
	(14, 'We are entering an era of space exploration unlike anything before.', '2025-01-08 18:10:00', 5, 3),
	(15, 'Exciting scientific breakthroughs are happening across the globe.', '2025-01-09 19:10:00', 6, 3),
	(16, 'Electric vehicles are not just the future, they are the present.', '2025-01-10 20:10:00', 7, 1),
	(17, 'We must continue the fight against COVID-19, even as things improve.', '2025-01-11 21:10:00', 8, 2),
	(18, '2025 promises a lot for movie lovers, with new genres emerging.', '2025-01-12 22:10:00', 9, 3),
	(19, 'Innovation is the key to a brighter future in technology.', '2025-01-13 23:10:00', 10, 1);

-- Listage de la structure de table forum_chloe. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT '',
  `dateOfCreation` datetime DEFAULT CURRENT_TIMESTAMP,
  `closed` tinyint DEFAULT '0',
  `user_id` int DEFAULT '0',
  `category_id` int DEFAULT '0',
  PRIMARY KEY (`id_topic`),
  KEY `FK_topic_category` (`category_id`),
  KEY `FK_topic_user` (`user_id`),
  CONSTRAINT `FK_topic_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `FK_topic_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_chloe.topic : ~10 rows (environ)
INSERT INTO `topic` (`id_topic`, `title`, `dateOfCreation`, `closed`, `user_id`, `category_id`) VALUES
	(1, 'Latest tech trends in 2025', '2025-01-04 14:00:00', 0, 1, 1),
	(2, 'Advancements in AI', '2025-01-05 15:00:00', 0, 1, 1),
	(3, 'Tips for a healthier lifestyle', '2025-01-06 16:00:00', 0, 2, 2),
	(4, 'Mental health awareness', '2025-01-07 17:00:00', 1, 2, 2),
	(5, 'The future of space exploration', '2025-01-08 18:00:00', 0, 3, 3),
	(6, 'Scientific discoveries in 2025', '2025-01-09 19:00:00', 0, 3, 3),
	(7, 'The rise of electric vehicles', '2025-01-10 20:00:00', 0, 1, 1),
	(8, 'COVID-19: Ongoing challenges', '2025-01-11 21:00:00', 1, 2, 2),
	(9, 'Movies to watch in 2025', '2025-01-12 22:00:00', 0, 3, 4),
	(10, 'Top gadgets of 2025', '2025-01-13 23:00:00', 0, 1, 1);

-- Listage de la structure de table forum_chloe. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `password` varchar(255) DEFAULT NULL,
  `userName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `registrationDate` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_chloe.user : ~3 rows (environ)
INSERT INTO `user` (`id_user`, `password`, `userName`, `role`, `email`, `registrationDate`) VALUES
	(1, 'password1', 'johnDoe', 'admin', 'user1@example.com', '2025-01-01 10:00:00'),
	(2, 'password2', 'johnyBravo', 'member', 'user2@example.com', '2025-01-02 11:00:00'),
	(3, 'password3', 'lili', 'member', 'user3@example.com', '2025-01-03 12:00:00');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
