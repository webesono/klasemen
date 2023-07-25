-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
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

-- Dumping structure for table klasemen.clubs
CREATE TABLE IF NOT EXISTS `clubs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `club_name` varchar(50) NOT NULL,
  `kota` varchar(255) NOT NULL DEFAULT 'CURRENT_TIMESTAMP',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table klasemen.clubs: ~3 rows (approximately)
REPLACE INTO `clubs` (`id`, `club_name`, `kota`, `created_at`, `updated_at`) VALUES
	(1, 'Arema', 'Malang', '2023-07-24 13:14:25', '2023-07-25 01:25:38'),
	(2, 'Persib', 'Bandung', '2023-07-24 13:15:43', '2023-07-25 01:25:47'),
	(3, 'Persija', 'Jakarta', '2023-07-25 01:29:08', NULL);

-- Dumping structure for table klasemen.matches
CREATE TABLE IF NOT EXISTS `matches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `desc` text,
  `match_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table klasemen.matches: ~0 rows (approximately)

-- Dumping structure for table klasemen.match_detail
CREATE TABLE IF NOT EXISTS `match_detail` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` bigint(20) unsigned NOT NULL,
  `club_id` bigint(20) unsigned NOT NULL,
  `match_status_id` bigint(20) unsigned NOT NULL,
  `gm_num` tinyint(4) NOT NULL,
  `gk_num` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_match_detail_match` (`match_id`),
  KEY `FK_match_detail_club` (`club_id`),
  KEY `FK_match_detail_match_status` (`match_status_id`),
  CONSTRAINT `FK_match_detail_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_match_detail_match` FOREIGN KEY (`match_id`) REFERENCES `matches` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_match_detail_match_status` FOREIGN KEY (`match_status_id`) REFERENCES `match_status` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Dumping data for table klasemen.match_detail: ~0 rows (approximately)

-- Dumping structure for table klasemen.match_status
CREATE TABLE IF NOT EXISTS `match_status` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(50) NOT NULL,
  `inisial` char(50) NOT NULL,
  `point` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table klasemen.match_status: ~3 rows (approximately)
REPLACE INTO `match_status` (`id`, `status`, `inisial`, `point`) VALUES
	(1, 'Menang', 'm', 3),
	(2, 'Seri', 's', 1),
	(3, 'Kalah', 'k', 0);

-- Dumping structure for table klasemen.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id_submenu` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `url` varchar(100) NOT NULL,
  `is_active` enum('0','1') NOT NULL,
  PRIMARY KEY (`id_submenu`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table klasemen.menu: ~0 rows (approximately)
REPLACE INTO `menu` (`id_submenu`, `title`, `icon`, `url`, `is_active`) VALUES
	(1, 'Klasemen', 'fa-shop', 'klasemen', '1');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
