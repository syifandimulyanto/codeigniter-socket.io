-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `chats`;
CREATE TABLE `chats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group` varchar(24) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `content` text,
  `create_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(125) DEFAULT NULL,
  `first_name` varchar(64) DEFAULT NULL,
  `last_name` varchar(64) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `fb_id` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `register_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `avatar`, `fb_id`, `google_id`, `register_at`, `last_login`) VALUES
(1,	'fanfandi17@gmail.com',	'Fan',	'Fandi',	'https://lh5.googleusercontent.com/-GuSBnOR_E1o/AAAAAAAAAAI/AAAAAAAAAkw/7RI8qBgKD9o/photo.jpg',	NULL,	'106951121330245933889',	'2017-03-14 17:05:43',	'2017-03-14 17:05:43'),
(2,	'syifandimulyanto@yahoo.co.id',	'Syifandi',	'Mulyanto',	'http://graph.facebook.com/1472767526080914/picture?width=800&height=500',	'1472767526080914',	NULL,	'2017-03-14 17:12:34',	'2017-03-14 17:12:34'),
(3,	'm.amiruddinirsyad@ymail.com',	'Amiruddin',	'Irsyad',	'http://graph.facebook.com/1442214322476304/picture?width=800&height=500',	'1442214322476304',	NULL,	'2017-03-15 08:33:01',	'2017-03-15 08:33:01'),
(4,	'harunnorman16@gmail.com',	'Fajar',	'Harun',	'http://graph.facebook.com/1844014412514196/picture?width=800&height=500',	'1844014412514196',	NULL,	'2017-03-21 08:30:41',	'2017-03-21 08:30:41'),
(5,	'fanfandi1721@gmail.com',	'Andre',	'Kurniawan',	'http://graph.facebook.com/343059899423867/picture?width=800&height=500',	'343059899423867',	NULL,	'2017-03-22 10:33:03',	'2017-03-22 10:33:03'),
(6,	'ag@agastyadarma.com',	'Agastya Darma',	'Laksana',	'http://graph.facebook.com/1875083796097433/picture?width=800&height=500',	'1875083796097433',	NULL,	'2017-03-22 13:15:29',	'2017-03-22 13:15:29'),
(7,	'donny.staark@gmail.com',	'Rizki',	'Romadhoni',	'http://graph.facebook.com/1226697920755333/picture?width=800&height=500',	'1226697920755333',	NULL,	'2017-03-22 13:16:19',	'2017-03-22 13:16:19'),
(8,	'tanjungyuko@gmail.com',	'Yuko',	'Tanjung',	'http://graph.facebook.com/10206639676631104/picture?width=800&height=500',	'10206639676631104',	NULL,	'2017-03-22 13:16:56',	'2017-03-22 13:16:56'),
(9,	'rendraseptian24@gmail.com',	'Rendra',	'Septian',	'http://graph.facebook.com/1248951928559541/picture?width=800&height=500',	'1248951928559541',	NULL,	'2017-03-22 13:17:49',	'2017-03-22 13:17:49'),
(10,	'kikilockoflove@yahoo.com',	'Mohammad',	'Hakiki',	'http://graph.facebook.com/1681966608497214/picture?width=800&height=500',	'1681966608497214',	NULL,	'2017-03-22 13:22:40',	'2017-03-22 13:22:40'),
(11,	'oim_trust@yahoo.com',	'O\'im',	'Trust',	'http://graph.facebook.com/744563572387587/picture?width=800&height=500',	'744563572387587',	NULL,	'2017-03-22 13:25:28',	'2017-03-22 13:25:28');

-- 2017-03-27 09:09:42
