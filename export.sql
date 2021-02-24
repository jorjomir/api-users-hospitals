-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.17-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table credo.hospitals
DROP TABLE IF EXISTS `hospitals`;
CREATE TABLE IF NOT EXISTS `hospitals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table credo.hospitals: ~3 rows (approximately)
/*!40000 ALTER TABLE `hospitals` DISABLE KEYS */;
REPLACE INTO `hospitals` (`id`, `name`, `address`, `phone`) VALUES
	(1, 'Tokuda', 'Sofia', '0897328423'),
	(2, 'Aleksandrovska', 'Sofia', '0893424324'),
	(3, 'Avis Medika', 'Pleven', '0883242233');
/*!40000 ALTER TABLE `hospitals` ENABLE KEYS */;

-- Dumping structure for table credo.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `workplace_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `workplace` (`workplace_id`),
  CONSTRAINT `workplace` FOREIGN KEY (`workplace_id`) REFERENCES `hospitals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table credo.users: ~3 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `email`, `first_name`, `last_name`, `type`, `workplace_id`, `created_at`) VALUES
	(1, 'pesho@abv.bg', 'Petar', 'Ivanov', 1, 1, '2021-02-24 00:45:33'),
	(2, 'georgimisa@abv.bg', 'Georgi', 'Sabev', 0, NULL, '2021-02-24 21:45:25'),
	(3, 'georgi.msabev@gmail.com', 'Georgi', 'Miroslavov', 1, 1, '2021-02-24 23:35:27'),
	(4, 'test@yahoo.com', 'Ivan', 'Georgiev', 0, NULL, '2021-02-24 23:37:28'),
	(5, 'krasi@abv.bg', 'Krasi', 'Stefanov', 1, 3, '2021-02-24 23:38:23');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
