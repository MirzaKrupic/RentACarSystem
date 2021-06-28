/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 8.0.22 : Database - rentacarsystem
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`rentacarsystem` /*!40100 DEFAULT CHARACTER SET latin1 */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `rentacarsystem`;

/*Table structure for table `brands` */

DROP TABLE IF EXISTS `brands`;

CREATE TABLE `brands` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `brands` */

insert  into `brands`(`id`,`name`) values 
(1,'Audi'),
(2,'BMW'),
(3,'Mercedes'),
(4,'Volkswagen'),
(5,'Opel');

/*Table structure for table `cars` */

DROP TABLE IF EXISTS `cars`;

CREATE TABLE `cars` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_id` int unsigned NOT NULL,
  `owner_id` int unsigned NOT NULL,
  `created_at` timestamp NOT NULL,
  `number_of_seats` int NOT NULL,
  `number_of_gears` int NOT NULL,
  `number_of_doors` int NOT NULL,
  `licence_plate` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'FOR RENT',
  `image` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/istockphoto-463397913-612x612.jpg',
  PRIMARY KEY (`id`),
  KEY `a` (`brand_id`),
  KEY `owne` (`owner_id`),
  CONSTRAINT `brand` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  CONSTRAINT `owne` FOREIGN KEY (`owner_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cars` */

insert  into `cars`(`id`,`model`,`brand_id`,`owner_id`,`created_at`,`number_of_seats`,`number_of_gears`,`number_of_doors`,`licence_plate`,`status`,`image`) values 
(33,'a2',1,9,'2021-06-13 14:19:31',4,4,4,'xxx-xxx-xxx','FOR RENT','https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/665e3353c5a0a1298b58f0408e39e998_XL.jpg'),
(34,'A3 sportback',1,9,'2021-06-13 14:43:41',4,4,2,'222-222-222','FOR RENT','https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/audi-a3-sportback-45-tfsie-compact-hybrid-2020-proauto-01.jpg'),
(35,'opel meriva',5,9,'2021-06-13 20:10:17',4,6,2,'123-123-123','FOR RENT','https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/opel-meriva_2010_Minivens_1512150555_4.jpg'),
(36,'Passat 3',4,9,'2021-06-14 12:51:23',4,4,4,'123-123-123','FOR RENT','https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/VW_Passat_B3_Variant_front_20080222.jpg'),
(37,'SL',3,9,'2021-06-16 14:21:29',4,2,4,'333-333-333','RENTED','https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/Mercedes-Benz_SL_63_AMG_%28R_231%29_%E2%80%93_Frontansicht%2C_13._September_2012%2C_Velbert.jpg');

/*Table structure for table `companies` */

DROP TABLE IF EXISTS `companies`;

CREATE TABLE `companies` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NOT SET',
  `address` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NOT SET',
  `mail` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `created_at` timestamp NOT NULL,
  `token` char(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NOT SET',
  `image` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/avatar.png',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_mail` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `companies` */

insert  into `companies`(`id`,`name`,`address`,`mail`,`status`,`created_at`,`token`,`password`,`phone`,`image`) values 
(9,'Renta a car Kramar','Sarajevska 1','myemail@gmail.com','ACTIVE','2021-04-06 13:45:27','03fd392c54a572aed1096f11d677d628','827ccb0eea8a706c4c34a16891f84e7b','066066060','https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/avatar.png'),
(11,'RentIt','Titova 3','myema2@gmail.com','PENDING','2021-04-06 13:46:35','19f928b674f33f1a64da8feb623067df','827ccb0eea8a706c4c34a16891f84e7b','NOT SET','https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/avatar.png'),
(12,'CarRent','Zagrebacka 15','mye3@gmail.com','PENDING','2021-04-06 13:47:26','b8b90b28a1fdeb7a32abd7cd13221f26','827ccb0eea8a706c4c34a16891f84e7b','NOT SET','https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/avatar.png'),
(13,'Renter','Adema buce 3','myemail4@gmail.com','ACTIVE','2021-04-06 14:18:37','eb6f843c5f648050c35119ba9b8a6405','827ccb0eea8a706c4c34a16891f84e7b','NOT SET','https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/avatar.png'),
(14,'Rentaj','Tuzlanska 22','mailer4@gmail.com','PENDING','2021-04-06 19:15:08','2a50d45643e7d1e76a16b0c2ef7197dc','827ccb0eea8a706c4c34a16891f84e7b','NOT SET','https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/avatar.png');

/*Table structure for table `rentings` */

DROP TABLE IF EXISTS `rentings`;

CREATE TABLE `rentings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `car_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `rented_on_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `status` varchar(256) NOT NULL DEFAULT 'ONGOING',
  PRIMARY KEY (`id`),
  KEY `car` (`car_id`),
  KEY `user` (`user_id`),
  CONSTRAINT `car` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`),
  CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

/*Data for the table `rentings` */

insert  into `rentings`(`id`,`car_id`,`user_id`,`rented_on_date`,`return_date`,`status`) values 
(8,33,49,'2021-06-15','2021-06-15','DONE'),
(9,34,49,'2021-06-15','2021-06-16','DONE'),
(10,35,48,'2021-06-16','2021-06-16','DONE'),
(11,36,49,'2021-06-16','2021-06-16','DONE'),
(12,33,49,'2021-06-20','2021-06-20','DONE');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `role` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USER',
  `created_at` timestamp NOT NULL,
  `token` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NOT SET',
  `phone` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NOT SET',
  `image` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/avatar.png',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_user_email` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`mail`,`password`,`status`,`role`,`created_at`,`token`,`address`,`phone`,`image`) values 
(46,'John Doe','myemail@gmail.com','827ccb0eea8a706c4c34a16891f84e7b','ACTIVE','ADMIN','2021-03-27 19:37:23','0d9b529f9ce9b4ace19685c2b267b573','NOT SET','NOT SET','https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/avatar.png'),
(48,'James Miller','myemail2@gmail.com','827ccb0eea8a706c4c34a16891f84e7b','ACTIVE','USER','2021-04-06 13:27:56','b964e3a332e3ac7927abaa0c2e20a345','NOT SET','NOT SET','https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/avatar.png'),
(49,'John Johnson','myemail3@gmail.com','827ccb0eea8a706c4c34a16891f84e7b','ACTIVE','USER','2021-05-04 19:26:52','b88389af3ac3b979f8476ab9eb289657','Adresaa','066955978','https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/62407621_2702764756403713_4397678565550718976_o.jpg'),
(50,'Johnny Deep','myemail4@gmail.com','827ccb0eea8a706c4c34a16891f84e7b','PENDING','USER','2021-05-04 19:29:21','e97e375dea77316a8d6eadf150c2fff1','NOT SET','NOT SET','https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/avatar.png'),
(51,'Dwayne Johnson','myemail5@gmail.com','827ccb0eea8a706c4c34a16891f84e7b','PENDING','USER','2021-06-25 16:56:43','317e7fa24af0bba9079d8033e2290084','NOT SET','NOT SET','https://fra1.digitaloceanspaces.com/cdn.rentacar.ba/avatar.png');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
