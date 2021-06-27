## Redaxo Database Dump Version 5
## Prefix rex_
## charset utf8

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `rex_yf4b_buch`;
CREATE TABLE `rex_yf4b_buch` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `b_datum` date NOT NULL,
  `b_titel` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `b_id_dokument` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `rex_yf4b_buch` WRITE;
/*!40000 ALTER TABLE `rex_yf4b_buch` DISABLE KEYS */;
INSERT INTO `rex_yf4b_buch` VALUES 
  (1,'1919-06-14','Verbandswettfahrt des PYC','3,2'),
  (2,'1919-05-24','Berliner Frühjahrs-Woche','1');
/*!40000 ALTER TABLE `rex_yf4b_buch` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_yf4b_dokument`;
CREATE TABLE `rex_yf4b_dokument` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `d_datum` date NOT NULL,
  `d_titel` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `d_id_scan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `rex_yf4b_dokument` WRITE;
/*!40000 ALTER TABLE `rex_yf4b_dokument` DISABLE KEYS */;
INSERT INTO `rex_yf4b_dokument` VALUES 
  (1,'1919-05-09','Die Yacht, Jg. 1919, Heft 19, S. 274: Meldungen zur Berliner Frühjahrswoche','1'),
  (2,'1919-06-20','Die Yacht, Jg. 1919, Heft 25, S. 369-370: Verbandswettfahrt des PYC','3,4'),
  (3,'1919-04-25','Die Yacht, Jg. 1919, Heft 17, S. 242: Ausschreibungen der Verbandsregatten des PYC','2'),
  (4,'1919-05-23','Die Yacht, Jg. 1919, Heft 21, S. 306: Interne Wettfahrt des Segel-Club \"Ahoi\"','5');
/*!40000 ALTER TABLE `rex_yf4b_dokument` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_yf4b_historie`;
CREATE TABLE `rex_yf4b_historie` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `h_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `h_boot` int(11) DEFAULT NULL,
  `h_id_dokument` int(11) NOT NULL,
  `h_datum` date NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `rex_yf4b_historie` WRITE;
/*!40000 ALTER TABLE `rex_yf4b_historie` DISABLE KEYS */;
INSERT INTO `rex_yf4b_historie` VALUES 
  (1,'Skadi',1,1,'0000-00-00','0000-00-00'),
  (2,'Helene IV',2,1,'0000-00-00','0000-00-00'),
  (3,'Carmen',3,1,'0000-00-00','0000-00-00'),
  (4,'Skadi',1,2,'0000-00-00','0000-00-00'),
  (5,'Melusine',4,2,'0000-00-00','0000-00-00'),
  (6,'Die Elfe II',5,2,'0000-00-00','0000-00-00'),
  (7,'Brigitte',6,2,'0000-00-00','0000-00-00'),
  (8,'Irmgard',7,4,'0000-00-00','0000-00-00'),
  (9,'Helene IV',2,4,'0000-00-00','0000-00-00');
/*!40000 ALTER TABLE `rex_yf4b_historie` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `rex_yf4b_scan`;
CREATE TABLE `rex_yf4b_scan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `s_datum` date NOT NULL,
  `s_quelle` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quelle` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `rex_yf4b_scan` WRITE;
/*!40000 ALTER TABLE `rex_yf4b_scan` DISABLE KEYS */;
INSERT INTO `rex_yf4b_scan` VALUES 
  (1,'1919-05-09','https://www.yachtsportmuseum.de/suche/die-yacht/details/YACHT-s1919-19-0274',''),
  (2,'1919-04-25','https://www.yachtsportmuseum.de/suche/die-yacht/details/YACHT-s1919-17-0242',''),
  (3,'1919-06-20','https://www.yachtsportmuseum.de/suche/die-yacht/details/YACHT-s1919-25-0369',''),
  (4,'1919-06-20','https://www.yachtsportmuseum.de/suche/die-yacht/details/YACHT-s1919-25-0370',''),
  (5,'1919-05-23','https://www.yachtsportmuseum.de/suche/die-yacht/details/YACHT-s1919-21-0306','');
/*!40000 ALTER TABLE `rex_yf4b_scan` ENABLE KEYS */;
UNLOCK TABLES;

SET FOREIGN_KEY_CHECKS = 1;
