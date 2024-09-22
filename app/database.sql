-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for loans_db
DROP DATABASE IF EXISTS `loans_db`;
CREATE DATABASE IF NOT EXISTS `loans_db` /*!40100 DEFAULT CHARACTER SET utf32 */;
USE `loans_db`;

-- Dumping structure for table loans_db.currency
DROP TABLE IF EXISTS `currency`;
CREATE TABLE IF NOT EXISTS `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curr_symbol` varchar(3) NOT NULL,
  `curr_desc` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf32;

-- Dumping data for table loans_db.currency: ~2 rows (approximately)
DELETE FROM `currency`;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` (`id`, `curr_symbol`, `curr_desc`) VALUES
	(1, 'KES', 'KES'),
	(2, 'USD', 'USD');
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;

-- Dumping structure for table loans_db.customer
DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `id_no` varchar(20) DEFAULT NULL,
  `phy_address` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf32;

-- Dumping data for table loans_db.customer: ~2 rows (approximately)
DELETE FROM `customer`;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` (`id`, `customer_name`, `email`, `dob`, `phone_no`, `id_no`, `phy_address`) VALUES
	(1, 'James Wamora', 'jwamora@gmail.com', '2024-09-20', '0715756532', '84196262', 'Homa Bay County'),
	(2, 'Rosemary Njoki', 'rozie272@yahoo.com', '2024-09-20', '071255665', '84114', 'Mombasa');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;

-- Dumping structure for table loans_db.loan_request
DROP TABLE IF EXISTS `loan_request`;
CREATE TABLE IF NOT EXISTS `loan_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `loan_no` varchar(45) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('A','D','R','N') DEFAULT 'N',
  `period` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf32;

-- Dumping data for table loans_db.loan_request: ~2 rows (approximately)
DELETE FROM `loan_request`;
/*!40000 ALTER TABLE `loan_request` DISABLE KEYS */;
INSERT INTO `loan_request` (`id`, `customer_id`, `product_id`, `loan_no`, `amount`, `status`, `period`) VALUES
	(1, 1, 1, '5801907909', 150000.00, 'N', 4),
	(2, 2, 1, '9126015089', 120000.00, 'D', 3);
/*!40000 ALTER TABLE `loan_request` ENABLE KEYS */;

-- Dumping structure for table loans_db.loan_schedule
DROP TABLE IF EXISTS `loan_schedule`;
CREATE TABLE IF NOT EXISTS `loan_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_date` date DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- Dumping data for table loans_db.loan_schedule: ~0 rows (approximately)
DELETE FROM `loan_schedule`;
/*!40000 ALTER TABLE `loan_schedule` DISABLE KEYS */;
/*!40000 ALTER TABLE `loan_schedule` ENABLE KEYS */;

-- Dumping structure for table loans_db.product
DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_name` varchar(200) NOT NULL,
  `prod_code` varchar(45) DEFAULT NULL,
  `min_amount` decimal(10,2) DEFAULT NULL,
  `int_rate` float DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  `max_amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf32;

-- Dumping data for table loans_db.product: ~0 rows (approximately)
DELETE FROM `product`;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`id`, `prod_name`, `prod_code`, `min_amount`, `int_rate`, `currency_id`, `max_amount`) VALUES
	(1, 'Education Fund', 'EDU001', 10000.00, 15.2, 1, 500000.00);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;

-- Dumping structure for table loans_db.statement
DROP TABLE IF EXISTS `statement`;
CREATE TABLE IF NOT EXISTS `statement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `trans_date` date NOT NULL,
  `cr_dr` char(1) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `trans_type` varchar(45) DEFAULT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf32;

-- Dumping data for table loans_db.statement: ~4 rows (approximately)
DELETE FROM `statement`;
/*!40000 ALTER TABLE `statement` DISABLE KEYS */;
INSERT INTO `statement` (`id`, `customer_id`, `trans_date`, `cr_dr`, `amount`, `trans_type`, `loan_id`, `user_id`) VALUES
	(1, 2, '2024-09-20', 'C', 120000.00, 'RECEIPT', 2, 1),
	(2, 2, '2024-09-20', 'C', 54720.00, 'RECEIPT', 2, 1),
	(3, 2, '2024-09-20', 'D', 20000.00, 'PAYMENT', 2, 1),
	(4, 2, '2024-09-20', 'D', 5000.00, 'PAYMENT', 2, 1);
/*!40000 ALTER TABLE `statement` ENABLE KEYS */;

-- Dumping structure for table loans_db.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(45) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varbinary(200) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `time_created` time DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf32;

-- Dumping data for table loans_db.user: ~1 rows (approximately)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `fname`, `lname`, `email`, `password`, `date_created`, `time_created`, `last_login`) VALUES
	(1, 'Walter', 'Omedo', 'walter.omedo@gmail.com', _binary 0x6D1F791EF8B6B08E849C6EA7F7FA7C3F5B66FA384C8E4E6147FC98E088B43C1A, '2024-09-20', '11:30:49', NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
