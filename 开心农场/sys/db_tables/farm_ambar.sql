CREATE TABLE `farm_ambar` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`id_user` int(11) NOT NULL,
	`semen` int(11) NOT NULL,
	`kol` int(11) NOT NULL,
	`time` varchar(1024) DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;