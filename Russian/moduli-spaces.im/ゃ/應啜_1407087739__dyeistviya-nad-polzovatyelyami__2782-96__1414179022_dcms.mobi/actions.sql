INSERT INTO `all_accesses` (`type`, `name`) VALUES ('actions_edit', 'Действия - Редактирование действий');
DROP TABLE IF EXISTS `actions_list`;
CREATE TABLE IF NOT EXISTS `actions_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `for_m` varchar(200) NOT NULL,
  `for_w` varchar(200) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
INSERT INTO `actions_list` (`id`, `name`, `for_m`, `for_w`, `price`) VALUES
	(9, 'Поставить рожки', 'Поставил рожки', 'Поставила рожки', 110),
	(8, 'Сказала спасибо', 'Сказал спасибо', 'Сказала спасибо', 100),
	(10, 'Дружески обнять', 'Дружески обнял', 'Дружески обняла', 100),
	(11, 'Угостить конфетами', 'Угостил конфетами', 'Угостила конфетами', 90),
	(12, 'Нежно поцеловать', 'Нежно поцеловал', 'Нежно поцеловала', 150),
	(13, 'Пожать руку', 'Пожал руку', 'Пожала руку', 100),
	(14, 'Подмигнуть', 'Подмигнул', 'Подмигнула', 70),
	(15, 'Пожелать хорошего настроения', 'Пожелал хорошего настроения', 'Пожелала хорошего настроения', 100),
	(16, 'Страстно поцеловать', 'Страстно поцеловал', 'Страстно поцеловала', 200),
	(17, 'Поздороваться', 'Поздоровался', 'Поздоровалась', 50),
	(18, 'Зацеловать', 'Зацеловал', 'Зацеловала', 300),
	(19, 'Признаться в любви', 'Признался в любви', 'Призналась в любви', 300),
	(22, 'Поцеловать в щечку', 'Поцеловал в щечку', 'Поцеловала в щечку', 160),
	(23, 'Подарить цветок', 'Подарил цветок', 'Подарила цветок', 90),
	(24, 'Пожелать спокойной ночи', 'Пожелал спокойной ночи', 'Пожелала спокойной ночи', 80),
	(25, 'Обнять', 'Обнял', 'Обняла', 200),
	(26, 'Ущипнуть', 'Ущипнул', 'Ущипнула', 150),
	(27, 'Сыграть на гитаре', 'Сыграл на гитаре', 'Сыграла на гитаре', 100),
	(28, 'Угостить мороженым', 'Угостил мороженым', 'Угостила мороженым', 180),
	(29, 'Сыграть на баяне', 'Сыграл на баяне', 'Сыграла на баяне', 160),
	(30, 'Пригласить в кино', 'Пригласил в кино', 'Пригласила в кино', 240),
	(31, 'Похвалить', 'Похвалил', 'Похвалила', 190),
	(32, 'Прокатать на ослике', 'Прокатал на ослике', 'Прокатала на ослике', 175),
	(33, 'Пожелать удачи', 'Пожелал удачи', 'Пожелала удачи', 230),
	(34, 'Прокатать на машине', 'Прокатал на машине', 'Прокатала на машине', 260),
	(35, 'Назвать солнышком', 'Назвал солнышком', 'Назвала солнышком', 90),
	(36, 'Сказать \\"Ты в моем сердце\\"', 'Сказал \\"Ты в моем сердце\\"', 'Сказала \\"Ты в моем сердце\\"', 280);
DROP TABLE IF EXISTS `actions_user`;
CREATE TABLE IF NOT EXISTS `actions_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_action` int(11) NOT NULL,
  `id_ank` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `type` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;