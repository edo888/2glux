CREATE TABLE IF NOT EXISTS `#__sexy_polls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `id_category` mediumint(8) unsigned NOT NULL,
  `id_template` mediumint(8) unsigned NOT NULL,
  `name` text NOT NULL,
  `alias` text NOT NULL,
  `question` text NOT NULL,
  `date` datetime NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `published` tinyint(1) unsigned NOT NULL,
  `order` mediumint(8) unsigned NOT NULL,
  `multiple_answers` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `order` (`order`),
  KEY `id_category` (`id_category`),
  KEY `id_template` (`id_template`)
) ENGINE=MyISAM CHARACTER SET = `utf8`;

INSERT IGNORE INTO `#__sexy_polls` (`id`, `id_user`, `id_category`, `id_template`, `name`, `alias`, `question`, `date`, `date_start`, `date_end`, `published`, `order`, `multiple_answers`) VALUES
(1, 0, 1, 1, 'Do You like Sexy Polling by 2GLux company?', '', 'Do You like Sexy Polling by 2GLux company?', '2012-04-19 19:13:34', '0000-00-00', '0000-00-00', '1', '0', '0');

CREATE TABLE IF NOT EXISTS `#__sexy_answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_poll` int(10) unsigned NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  `name` text NOT NULL,
  `published` tinyint(1) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `order` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_poll` (`id_poll`),
  KEY `id_user` (`id_user`),
  KEY `order` (`order`)
) ENGINE=MyISAM CHARACTER SET = `utf8`;

INSERT IGNORE INTO `#__sexy_answers` (`id`, `id_poll`, `id_user`, `name`, `published`, `date`, `order`) VALUES
(1, 1, 0, 'Yes, I like it very much', 1, '2012-04-20 17:41:04', 0),
(2, 1, 0, 'It is the most amazing poll i have ever seen', 1, '2012-04-20 17:41:04', 0),
(3, 1, 0, 'No, i don&#39;t like it', 1, '2012-04-20 17:41:04', 0),
(4, 1, 0, 'Yes, template customization is great', 1, '2012-04-20 17:41:04', 0),
(5, 1, 0, 'There are too much effects i think', 1, '2012-04-20 17:41:04', 0);


CREATE TABLE IF NOT EXISTS `#__sexy_votes` (
  `id_answer` int(10) unsigned NOT NULL,
  `ip` text NOT NULL,
  `date` date NOT NULL,
  `country` text NOT NULL,
  `city` text NOT NULL,
  `region` text NOT NULL,
  `countrycode` text NOT NULL,
  KEY `id_answer` (`id_answer`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `#__sexy_votes` (`id_answer`, `ip`, `date`,`country`,`city`,`region`,`countrycode`) VALUES
(1, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(1, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(1, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(1, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(1, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(1, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(1, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),

(1, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),

(1, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),

(1, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),

(1, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),

(1, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),

(1, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),

(1, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(1, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),

(2, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(2, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),

(2, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),

(2, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),

(2, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),

(2, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),

(2, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),

(2, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),

(2, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(2, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),

(3, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(3, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(3, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),

(3, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(3, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),

(3, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(3, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(3, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),

(3, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(3, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(3, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),

(3, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),
(3, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),
(3, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),

(3, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(3, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(3, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),

(3, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),
(3, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),

(3, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),

(4, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(4, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(4, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(4, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(4, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(4, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(4, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(4, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(4, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(4, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(4, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(4, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),

(4, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),

(4, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),

(4, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),

(4, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),

(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),

(4, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),

(4, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(4, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),

(5, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(5, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),
(5, '', NOW(),'Unknown','Unknown','Unknown','Unknown'),

(5, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 1 day),'Unknown','Unknown','Unknown','Unknown'),

(5, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 2 day),'Unknown','Unknown','Unknown','Unknown'),

(5, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 3 day),'Unknown','Unknown','Unknown','Unknown'),

(5, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 4 day),'Unknown','Unknown','Unknown','Unknown'),

(5, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 5 day),'Unknown','Unknown','Unknown','Unknown'),

(5, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 6 day),'Unknown','Unknown','Unknown','Unknown'),

(5, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown'),
(5, '', DATE_SUB(NOW(), INTERVAL 7 day),'Unknown','Unknown','Unknown','Unknown');


CREATE TABLE IF NOT EXISTS `#__sexy_categories` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `published` tinyint(1) unsigned NOT NULL,
  `order` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARACTER SET = `utf8`;

INSERT IGNORE INTO `#__sexy_categories` (`id`, `name`, `published`, `order`) VALUES
(1, 'Uncategorized', 1, 0);

CREATE TABLE IF NOT EXISTS `#__sexy_templates` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `styles` text NOT NULL,
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARACTER SET = `utf8`;

INSERT IGNORE INTO `#__sexy_templates` (`id`, `name`, `styles`, `published`) VALUES
(1, 'Gray', '0~#e3e3e3|1~#a19fa1|2~1|165~double|51~10|52~10|53~10|54~10|3~#828082|50~inset|46~0|47~0|48~45|49~0|5~#828082|55~inset|56~0|57~0|58~50|59~0|7~#333333|8~20|36~normal|37~normal|38~none|39~left|40~arial|63~#565757|60~0|61~0|62~0|9~#575757|10~14|41~normal|42~normal|43~none|44~left|45~arial|67~#ffffff|64~0|65~0|66~0|12~#ffffff|11~#7a7a7a|68~inset|69~0|70~0|71~55|72~-1|73~#adaaad|74~8|75~8|76~8|77~8|90~14|78~#636466|79~|80~3|81~3|82~3|83~0|84~#ffffff|89~0|85~4|86~4|87~4|88~4|272~23|273~#ffffff|251~#b3b3b3|270~#7a787a|271~#7a787a|252~12|253~bold|254~italic|255~none|256~arial|274~#424242|275~0|276~0|277~0|257~#8a8a8a|258~inset|259~0|260~0|261~25|262~-1|263~#747475|264~1|265~dotted|266~4|267~4|268~4|269~5|91~#044bd9|92~4|93~20|100~#1f59cc|101~1|127~solid|102~4|103~4|104~4|105~4|94~#5d89e8|95~inset|96~0|97~11|98~5|99~0|106~#ffffff|107~12|108~bold|109~normal|110~none|112~Arial|113~#003dad|114~0|115~-1|116~1|123~#044bd9|124~#fafafa|125~#032561|126~#1f59cc|117~#5d89e8|118~inset|119~0|120~-11|121~5|122~0|128~#fd9312|129~4|130~20|137~#ec8911|138~1|164~solid|139~4|140~4|141~4|142~4|131~#fedb4d|132~inset|133~0|134~12|135~5|136~0|143~#333333|144~12|145~bold|146~normal|147~none|149~arial|150~#fedb4d|151~0|152~-1|153~3|160~#fd9312|161~#474547|162~#fedb4d|163~#ec8911|154~#fedb4d|155~inset|156~0|157~-14|158~6|159~-2|166~#545454|167~12|168~normal|169~normal|170~none|171~arial|172~#595659|173~0|174~0|175~0|176~#333233|177~14|178~bold|179~normal|180~none|181~arial|182~#080808|183~0|184~0|185~0|186~#545454|187~12|188~normal|189~normal|190~none|191~arial|192~#ffffff|193~0|194~0|195~0|196~#333233|197~13|198~bold|199~normal|200~none|201~arial|202~#000000|203~0|204~0|205~0|206~#ffffff|207~2|208~5|209~#525252|210~12|211~normal|212~normal|213~none|214~arial|215~#ffffff|216~0|217~0|218~0|219~#b8b8b8|220~1|221~solid|222~4|223~4|224~4|225~4|226~#fcfcfc|227~#858585|228~#424242|229~#ffffff|230~#ffffff|231~#5e5e5e|232~11|233~#ee442e|234~#991200|235~#fedb4d|236~#ec8911|237~#ec8911|238~#fedb4d|239~#4f4f4f|249~#6b6b6b|248~12|250~8|240~normal|241~normal|242~none|243~arial|244~#000000|245~0|246~0|247~0|500~#4f0d0d|501~#ff0000|502~#02008f|503~#2369f5|504~#ff3f05|505~#ffee00|506~#0e4a00|507~#46ff08|508~#ff0000|509~#fa9805|510~#00356e|511~#00fbff|512~#3c0070|513~#b45eff|514~#000303|515~#0032fa|516~#000000|517~#1dd600|518~#ff001e|519~#8c00ff|520~#039488|521~#e8f000|522~#ff2929|523~#ffc20a|524~#b0005e|525~#db00e6|526~#573400|527~#ff8112|528~#3b303b|529~#bab1ba|530~#1938ff|531~#20fab1|532~#ff0000|533~#ff6600|534~#000000|535~#9e9e9e|536~#000000|537~#ccff00|538~#000000|539~#08e2ff', 1),
(2, 'Blue-Yellow', '0~#0067c8|1~#00478a|2~1|165~double|51~10|52~10|53~10|54~10|3~#00478a|50~inset|46~2|47~2|48~25|49~2|5~#054175|55~inset|56~2|57~2|58~30|59~4|7~#cce5ff|8~20|36~normal|37~normal|38~none|39~left|40~arial|63~#012d57|60~-2|61~-1|62~2|9~#fafafa|10~16|41~normal|42~normal|43~none|44~left|45~arial|67~#002e57|64~-1|65~-1|66~1|12~#02519c|11~#ffffff|68~inset|69~0|70~0|71~46|72~-7|73~#0067c8|74~4|75~4|76~4|77~4|90~14|78~#0c3d9e|79~|80~2|81~2|82~6|83~2|84~#ec8911|89~1|85~4|86~4|87~4|88~4|272~23|273~#075da8|251~#a2b1b8|270~#ffffff|271~#ffffff|252~12|253~bold|254~italic|255~none|256~arial|274~#424242|275~-1|276~-1|277~1|257~#bfe0ff|258~inset|259~0|260~0|261~18|262~-1|263~#aad2f7|264~1|265~dotted|266~10|267~8|268~10|269~10|91~#991200|92~4|93~20|100~#951100|101~1|127~solid|102~4|103~4|104~4|105~4|94~#ee442e|95~inset|96~0|97~14|98~11|99~-2|106~#ffffff|107~12|108~bold|109~normal|110~none|112~Arial|113~#0f0f0e|114~0|115~-1|116~1|123~#991200|124~#fafafa|125~#0f0f0e|126~#951100|117~#ee442e|118~inset|119~0|120~-14|121~11|122~-2|128~#fc8014|129~4|130~20|137~#ec8911|138~1|164~solid|139~4|140~4|141~4|142~4|131~#fedb4d|132~inset|133~0|134~14|135~6|136~-2|143~#474547|144~12|145~bold|146~normal|147~none|149~arial|150~#fedb4d|151~-1|152~-1|153~0|160~#fd9312|161~#474547|162~#fedb4d|163~#ec8911|154~#fedb4d|155~inset|156~0|157~-14|158~6|159~-2|166~#ffffff|167~12|168~bold|169~normal|170~none|171~arial|172~#000000|173~0|174~-1|175~1|176~#fedb4d|177~14|178~bold|179~normal|180~none|181~arial|182~#080808|183~0|184~-1|185~1|186~#ffffff|187~12|188~bold|189~normal|190~none|191~arial|192~#000000|193~0|194~-1|195~1|196~#fedb4d|197~13|198~bold|199~normal|200~none|201~arial|202~#000000|203~0|204~-1|205~1|206~#fedb4d|207~2|208~5|209~#474547|210~12|211~bold|212~normal|213~none|214~arial|215~#fadb61|216~0|217~0|218~0|219~#ec8911|220~1|221~solid|222~4|223~4|224~4|225~4|226~#fedb4d|227~#fedb4d|228~#474547|229~#ffffff|230~#ffffff|231~#951100|232~11|233~#ee442e|234~#991200|235~#fedb4d|236~#ec8911|237~#ec8911|238~#fedb4d|239~#fedb4d|249~#fedb4d|248~13|250~8|240~bold|241~normal|242~none|243~arial|244~#000000|245~0|246~-1|247~1|500~#ffee00|501~#fc8014|502~#ffee00|503~#fc8014|504~#ffee00|505~#fc8014|506~#ffee00|507~#fc8014|508~#ffee00|509~#fc8014|510~#ffee00|511~#fc8014|512~#ffee00|513~#fc8014|514~#ffee00|515~#fc8014|516~#ffee00|517~#fc8014|518~#ffee00|519~#fc8014|520~#ffee00|521~#fc8014|522~#ffee00|523~#fc8014|524~#ffee00|525~#fc8014|526~#ffee00|527~#fc8014|528~#ffee00|529~#fc8014|530~#ffee00|531~#fc8014|532~#ffee00|533~#fc8014|534~#ffee00|535~#fc8014|536~#ffee00|537~#fc8014|538~#ffee00|539~#fc8014', 1),
(3, 'Green', '0~#97a71a|1~#8c9929|2~1|165~solid|51~7|52~7|53~7|54~7|3~#707d0f|50~|46~0|47~0|48~24|49~1|5~#707d0f|55~|56~0|57~0|58~30|59~2|7~#ffffff|8~20|36~normal|37~normal|38~none|39~left|40~"lucida grande",tahoma,verdana,arial,sans-serif|63~#424242|60~-1|61~-1|62~1|9~#ffffff|10~14|41~normal|42~normal|43~none|44~left|45~"lucida grande",tahoma,verdana,arial,sans-serif|67~#363636|64~-1|65~-1|66~1|12~#6a7804|11~#fcf7fc|68~inset|69~0|70~0|71~40|72~0|73~#859606|74~6|75~6|76~6|77~6|90~18|78~#d7dbb8|79~|80~2|81~2|82~6|83~0|84~#8a8a8a|89~0|85~6|86~6|87~6|88~6|272~23|273~#818f00|251~#dbebc5|270~#ffffff|271~#ffffff|252~14|253~normal|254~normal|255~none|256~"lucida grande",tahoma,verdana,arial,sans-serif|274~#696769|275~-1|276~-1|277~1|257~#e6e8eb|258~inset|259~0|260~0|261~32|262~0|263~#879410|264~1|265~solid|266~6|267~6|268~6|269~6|91~#76bd0b|92~5|93~20|100~#006300|101~1|127~solid|102~3|103~3|104~3|105~3|94~#053d00|95~inset|96~6|97~10|98~33|99~-4|106~#ffffff|107~12|108~bold|109~normal|110~none|112~"lucida grande",tahoma,verdana,arial,sans-serif|113~#1f1f1f|114~1|115~1|116~1|123~#76bd0b|124~#ffffff|125~#000000|126~#006300|117~#053d00|118~inset|119~-6|120~-10|121~33|122~-4|128~#385ae0|129~5|130~20|137~#273b9c|138~1|164~solid|139~3|140~3|141~3|142~3|131~#03004d|132~inset|133~6|134~10|135~33|136~-4|143~#ffffff|144~12|145~bold|146~normal|147~none|149~"lucida grande",tahoma,verdana,arial,sans-serif|150~#1f1f1f|151~1|152~1|153~1|160~#385ae0|161~#ffffff|162~#000000|163~#273b9c|154~#03004d|155~inset|156~-6|157~-10|158~33|159~-4|166~#ffffff|167~12|168~normal|169~normal|170~none|171~"lucida grande",tahoma,verdana,arial,sans-serif|172~#424242|173~-1|174~-1|175~1|176~#fcf9fc|177~13|178~bold|179~normal|180~none|181~"lucida grande",tahoma,verdana,arial,sans-serif|182~#1c1c1c|183~-1|184~-1|185~1|186~#ffffff|187~11|188~normal|189~normal|190~none|191~"lucida grande",tahoma,verdana,arial,sans-serif|192~#292729|193~1|194~1|195~1|196~#ffffff|197~13|198~bold|199~normal|200~none|201~"lucida grande",tahoma,verdana,arial,sans-serif|202~#212121|203~1|204~1|205~1|206~#3a4799|207~2|208~2|209~#ffffff|210~12|211~bold|212~normal|213~none|214~arial|215~#302d30|216~1|217~1|218~1|219~#1c2d73|220~1|221~solid|222~3|223~3|224~3|225~3|226~#1c2d73|227~#1c2d73|228~#ffffff|229~#000000|230~#ffffff|231~#117009|232~5|233~#acfaa0|234~#459900|235~#fcfffc|236~#053d00|237~#ffffff|238~#4f4f4f|239~#dfdfed|249~#ffffff|248~11|250~6|240~normal|241~normal|242~none|243~"lucida grande",tahoma,verdana,arial,sans-serif|244~#292729|245~-1|246~-1|247~1|500~#ebebeb|501~#403940|502~#ebebeb|503~#ad3841|504~#ebebeb|505~#2243e6|506~#ebebeb|507~#1d8f0b|508~#ebebeb|509~#d1b500|510~#ebebeb|511~#79478c|512~#ebebeb|513~#26a682|514~#ebebeb|515~#b33f00|516~#ebebeb|517~#43870b|518~#ebebeb|519~#b03ac2|520~#ebebeb|521~#005703|522~#ebebeb|523~#0f1ec4|524~#ebebeb|525~#d8dfea|526~#ebebeb|527~#d8dfea|528~#ebebeb|529~#d8dfea|530~#ebebeb|531~#d8dfea|532~#ebebeb|533~#d8dfea|534~#ebebeb|535~#d8dfea|536~#ebebeb|537~#d8dfea|538~#ebebeb|539~#d8dfea', 1),
(4, 'Orange', '0~#ff9900|1~#cc4100|2~1|165~double|51~10|52~10|53~10|54~10|3~#cc4100|50~inset|46~10|47~10|48~45|49~2|5~#cc4100|55~inset|56~15|57~15|58~50|59~2|7~#ffffff|8~20|36~normal|37~normal|38~none|39~left|40~arial|63~#c70000|60~0|61~1|62~3|9~#ffffff|10~14|41~normal|42~normal|43~none|44~left|45~arial|67~#a60000|64~1|65~0|66~3|12~#ffd494|11~#ff4400|68~inset|69~0|70~0|71~55|72~8|73~#ff6c0a|74~4|75~4|76~4|77~4|90~14|78~#666666|79~|80~2|81~2|82~2|83~0|84~#ffffff|89~0|85~4|86~4|87~4|88~4|272~23|273~#ffffff|251~#c2b8b9|270~#cc6900|271~#cc6900|252~12|253~bold|254~italic|255~none|256~arial|274~#6021de|275~0|276~0|277~0|257~#f28500|258~inset|259~0|260~0|261~25|262~3|263~#ff4400|264~1|265~dotted|266~4|267~4|268~4|269~5|91~#d40012|92~5|93~20|100~#ba0d1e|101~1|127~solid|102~12|103~12|104~12|105~12|94~#ff7886|95~inset|96~3|97~3|98~5|99~0|106~#ffffff|107~12|108~bold|109~normal|110~none|112~Arial|113~#4d0008|114~0|115~-1|116~1|123~#d9041d|124~#fafafa|125~#4d0008|126~#ba0d1e|117~#ff7886|118~inset|119~4|120~4|121~5|122~0|128~#fa8500|129~5|130~20|137~#d67200|138~1|164~solid|139~12|140~12|141~12|142~12|131~#fedb4d|132~inset|133~3|134~3|135~5|136~1|143~#333333|144~12|145~bold|146~normal|147~none|149~arial|150~#fedb4d|151~0|152~-1|153~3|160~#ff8400|161~#474547|162~#fedb4d|163~#ec8911|154~#fedb4d|155~inset|156~4|157~4|158~5|159~1|166~#ffffff|167~12|168~normal|169~normal|170~none|171~arial|172~#380c01|173~1|174~0|175~1|176~#850000|177~14|178~bold|179~normal|180~none|181~arial|182~#380c01|183~0|184~0|185~0|186~#ffffff|187~12|188~normal|189~normal|190~none|191~arial|192~#380c01|193~0|194~-1|195~1|196~#850000|197~13|198~bold|199~normal|200~none|201~arial|202~#473569|203~0|204~0|205~0|206~#ffffff|207~2|208~5|209~#661e08|210~12|211~normal|212~normal|213~none|214~arial|215~#ffffff|216~0|217~0|218~0|219~#e62e00|220~1|221~solid|222~4|223~4|224~4|225~4|226~#fcfcfc|227~#ff8605|228~#a63500|229~#ffffff|230~#ffffff|231~#c24e00|232~11|233~#ee442e|234~#991200|235~#fedb4d|236~#ec8911|237~#ec8911|238~#fedb4d|239~#850000|249~#d9d9d9|248~12|250~8|240~normal|241~normal|242~none|243~arial|244~#000000|245~0|246~0|247~0|500~#4f0d0d|501~#ff0000|502~#02008f|503~#2369f5|504~#ff3f05|505~#ffee00|506~#0e4a00|507~#46ff08|508~#ff0000|509~#fa9805|510~#00356e|511~#00fbff|512~#3c0070|513~#b45eff|514~#000303|515~#0032fa|516~#000000|517~#1dd600|518~#ff001e|519~#8c00ff|520~#039488|521~#e8f000|522~#ff2929|523~#ffc20a|524~#b0005e|525~#db00e6|526~#573400|527~#ff8112|528~#3b303b|529~#bab1ba|530~#1938ff|531~#20fab1|532~#ff0000|533~#ff6600|534~#000000|535~#9e9e9e|536~#000000|537~#ccff00|538~#000000|539~#08e2ff', 1),
(5, 'Raver', '0~#0491c9|1~#0031ad|2~1|165~solid|51~9|52~9|53~9|54~9|3~#00183d|50~inset|46~0|47~0|48~45|49~7|5~#00183d|55~inset|56~0|57~0|58~49|59~10|7~#ffffff|8~20|36~normal|37~italic|38~none|39~left|40~|63~#00183d|60~1|61~1|62~1|9~#f0f0f0|10~14|41~normal|42~italic|43~none|44~left|45~|67~#00183d|64~1|65~1|66~1|12~#05cdff|11~#00122e|68~inset|69~0|70~0|71~48|72~7|73~#004ab8|74~5|75~5|76~5|77~5|90~17|78~#000b26|79~inset|80~4|81~-2|82~23|83~-1|84~#666566|89~1|85~3|86~3|87~3|88~3|272~22|273~#05b5fa|251~#d1d1d1|270~#ffffff|271~#ffffff|252~14|253~normal|254~italic|255~none|256~|274~#000b26|275~1|276~1|277~1|257~#003042|258~inset|259~-7|260~0|261~24|262~4|263~#003042|264~1|265~dotted|266~6|267~6|268~6|269~6|91~#ff8800|92~3|93~22|100~#ec8911|101~1|127~solid|102~3|103~3|104~3|105~3|94~#fedb4d|95~inset|96~3|97~3|98~5|99~1|106~#333333|107~12|108~bold|109~normal|110~none|112~|113~#fedb4d|114~0|115~-1|116~3|123~#ff8800|124~#424242|125~#ffdc52|126~#ec8911|117~#fedb4d|118~inset|119~3|120~2|121~7|122~4|128~#ff8800|129~3|130~22|137~#ec8911|138~1|164~solid|139~3|140~3|141~3|142~3|131~#fedb4d|132~inset|133~3|134~2|135~5|136~1|143~#333333|144~12|145~bold|146~normal|147~none|149~|150~#fedb4d|151~0|152~-1|153~3|160~#ff8800|161~#424242|162~#ffdc52|163~#ec8911|154~#fedb4d|155~inset|156~3|157~2|158~7|159~4|166~#c7c3c7|167~12|168~normal|169~normal|170~none|171~|172~#00122e|173~1|174~1|175~1|176~#fffcff|177~13|178~bold|179~normal|180~none|181~|182~#00122e|183~0|184~0|185~3|186~#fafafa|187~11|188~normal|189~normal|190~none|191~|192~#00122e|193~1|194~1|195~1|196~#ffffff|197~13|198~bold|199~normal|200~none|201~|202~#00122e|203~1|204~1|205~1|206~#004b85|207~2|208~2|209~#ffffff|210~12|211~bold|212~normal|213~none|214~arial|215~#000000|216~1|217~1|218~1|219~#01445c|220~1|221~solid|222~3|223~3|224~3|225~3|226~#005a9e|227~#01445c|228~#ffffff|229~#000000|230~#fffaff|231~#470006|232~5|233~#fa0808|234~#1f0000|235~#a8a8a8|236~#282829|237~#ffffff|238~#4f4f4f|239~#ffffff|249~#fafafa|248~11|250~6|240~normal|241~normal|242~none|243~|244~#000000|245~1|246~1|247~1|500~#ebebeb|501~#403940|502~#ebebeb|503~#ad3841|504~#ebebeb|505~#2243e6|506~#ebebeb|507~#1d8f0b|508~#ebebeb|509~#d1b500|510~#ebebeb|511~#79478c|512~#ebebeb|513~#26a682|514~#ebebeb|515~#b33f00|516~#ebebeb|517~#43870b|518~#ebebeb|519~#b03ac2|520~#ebebeb|521~#005703|522~#ebebeb|523~#0f1ec4|524~#ebebeb|525~#d8dfea|526~#ebebeb|527~#d8dfea|528~#ebebeb|529~#d8dfea|530~#ebebeb|531~#d8dfea|532~#ebebeb|533~#d8dfea|534~#ebebeb|535~#d8dfea|536~#ebebeb|537~#d8dfea|538~#ebebeb|539~#d8dfea', 1),
(6, 'Purple Dark', '0~#a700d1|1~#310040|2~1|165~solid|51~9|52~9|53~9|54~9|3~#70006c|50~inset|46~0|47~0|48~41|49~17|5~#70006c|55~inset|56~0|57~0|58~50|59~20|7~#ffffff|8~21|36~normal|37~italic|38~none|39~left|40~Geneva, Arial, SunSans-Regular, sans-serif|63~#460059|60~1|61~1|62~1|9~#ffffff|10~16|41~bold|42~italic|43~none|44~left|45~Geneva|67~#3e004f|64~1|65~1|66~1|12~#e68cff|11~#400036|68~inset|69~0|70~0|71~48|72~10|73~#70006c|74~5|75~5|76~5|77~5|90~20|78~#000b26|79~inset|80~4|81~-2|82~23|83~-1|84~#666566|89~1|85~6|86~6|87~6|88~6|272~22|273~#e796ff|251~#d1d1d1|270~#ffffff|271~#ffffff|252~14|253~normal|254~italic|255~none|256~|274~#5c005a|275~1|276~1|277~1|257~#430047|258~inset|259~0|260~0|261~28|262~2|263~#70006c|264~1|265~dotted|266~6|267~6|268~6|269~6|91~#ff8800|92~3|93~22|100~#ec8911|101~1|127~solid|102~3|103~3|104~3|105~3|94~#fedb4d|95~inset|96~3|97~3|98~5|99~1|106~#333333|107~12|108~bold|109~normal|110~none|112~|113~#fedb4d|114~0|115~-1|116~3|123~#ff8800|124~#424242|125~#ffdc52|126~#ec8911|117~#fedb4d|118~inset|119~3|120~2|121~7|122~4|128~#ff8800|129~3|130~22|137~#ec8911|138~1|164~solid|139~3|140~3|141~3|142~3|131~#fedb4d|132~inset|133~3|134~2|135~5|136~1|143~#333333|144~12|145~bold|146~normal|147~none|149~|150~#fedb4d|151~0|152~-1|153~3|160~#ff8800|161~#424242|162~#ffdc52|163~#ec8911|154~#fedb4d|155~inset|156~3|157~2|158~7|159~4|166~#c7c3c7|167~12|168~normal|169~normal|170~none|171~|172~#3d003b|173~1|174~1|175~1|176~#fffcff|177~13|178~bold|179~normal|180~none|181~|182~#3d003b|183~0|184~0|185~3|186~#fafafa|187~11|188~normal|189~normal|190~none|191~|192~#3d003b|193~1|194~1|195~1|196~#ffffff|197~13|198~bold|199~normal|200~none|201~|202~#3d003b|203~1|204~1|205~1|206~#3d003b|207~2|208~2|209~#ffffff|210~12|211~bold|212~normal|213~none|214~arial|215~#a1039e|216~1|217~1|218~1|219~#170017|220~1|221~solid|222~3|223~3|224~3|225~3|226~#5c005a|227~#3d003b|228~#ffffff|229~#3d003b|230~#fffaff|231~#3d003b|232~5|233~#ff00fb|234~#1c001c|235~#ff7fff|236~#470047|237~#ffffff|238~#470047|239~#ffffff|249~#fafafa|248~11|250~6|240~normal|241~normal|242~none|243~|244~#260026|245~1|246~1|247~1|500~#ebebeb|501~#403940|502~#ebebeb|503~#ad3841|504~#ebebeb|505~#2243e6|506~#ebebeb|507~#1d8f0b|508~#ebebeb|509~#d1b500|510~#ebebeb|511~#79478c|512~#ebebeb|513~#26a682|514~#ebebeb|515~#b33f00|516~#ebebeb|517~#43870b|518~#ebebeb|519~#b03ac2|520~#ebebeb|521~#005703|522~#ebebeb|523~#0f1ec4|524~#ebebeb|525~#d8dfea|526~#ebebeb|527~#d8dfea|528~#ebebeb|529~#d8dfea|530~#ebebeb|531~#d8dfea|532~#ebebeb|533~#d8dfea|534~#ebebeb|535~#d8dfea|536~#ebebeb|537~#d8dfea|538~#ebebeb|539~#d8dfea', 1),
(7, 'Dark Black', '0~#202020|1~#111111|2~1|165~solid|51~3|52~3|53~3|54~3|3~#999999|50~inset|46~0|47~0|48~49|49~-14|5~#ffffff|55~inset|56~0|57~0|58~0|59~0|7~#ffffff|8~20|36~normal|37~normal|38~none|39~left|40~"lucida grande",tahoma,verdana,arial,sans-serif|63~#000000|60~1|61~1|62~1|9~#bababa|10~14|41~normal|42~normal|43~none|44~left|45~"lucida grande",tahoma,verdana,arial,sans-serif|67~#000000|64~1|65~1|66~1|12~#000000|11~#e6e2dd|68~inset|69~0|70~0|71~68|72~-13|73~#67686b|74~5|75~5|76~5|77~5|90~17|78~#202020|79~inset|80~4|81~-2|82~23|83~-1|84~#666566|89~1|85~3|86~3|87~3|88~3|272~23|273~#0f0f0f|251~#777777|270~#ffffff|271~#ffffff|252~14|253~normal|254~normal|255~none|256~"lucida grande",tahoma,verdana,arial,sans-serif|274~#000000|275~1|276~1|277~1|257~#aaabad|258~inset|259~0|260~0|261~23|262~-4|263~#757575|264~1|265~dotted|266~3|267~3|268~3|269~3|91~#636262|92~5|93~20|100~#757075|101~1|127~dotted|102~3|103~3|104~3|105~3|94~#000000|95~inset|96~3|97~-3|98~17|99~-4|106~#ffffff|107~12|108~bold|109~normal|110~none|112~"lucida grande",tahoma,verdana,arial,sans-serif|113~#1f1f1f|114~1|115~1|116~1|123~#636262|124~#ffffff|125~#000000|126~#3d3d3d|117~#000000|118~inset|119~3|120~-3|121~23|122~-3|128~#636262|129~5|130~20|137~#757075|138~1|164~dotted|139~3|140~3|141~3|142~3|131~#000000|132~inset|133~3|134~-3|135~17|136~-4|143~#ffffff|144~12|145~bold|146~normal|147~none|149~"lucida grande",tahoma,verdana,arial,sans-serif|150~#1f1f1f|151~1|152~1|153~1|160~#636262|161~#ffffff|162~#000000|163~#3d3d3d|154~#000000|155~inset|156~3|157~-3|158~23|159~-3|166~#c7c3c7|167~12|168~normal|169~normal|170~none|171~"lucida grande",tahoma,verdana,arial,sans-serif|172~#000000|173~1|174~1|175~1|176~#fffcff|177~13|178~bold|179~normal|180~none|181~"lucida grande",tahoma,verdana,arial,sans-serif|182~#750000|183~1|184~1|185~8|186~#fafafa|187~11|188~normal|189~normal|190~none|191~"lucida grande",tahoma,verdana,arial,sans-serif|192~#00050d|193~1|194~1|195~1|196~#ffffff|197~13|198~bold|199~normal|200~none|201~"lucida grande",tahoma,verdana,arial,sans-serif|202~#000000|203~1|204~1|205~1|206~#636262|207~2|208~2|209~#ffffff|210~12|211~bold|212~normal|213~none|214~arial|215~#000000|216~1|217~1|218~1|219~#757075|220~1|221~dotted|222~3|223~3|224~3|225~3|226~#2e2e2e|227~#2e2e2e|228~#ffffff|229~#000000|230~#fffaff|231~#696969|232~5|233~#ffffff|234~#333333|235~#a8a8a8|236~#282829|237~#ffffff|238~#4f4f4f|239~#ffffff|249~#fafafa|248~11|250~6|240~normal|241~normal|242~none|243~"lucida grande",tahoma,verdana,arial,sans-serif|244~#000000|245~1|246~1|247~1|500~#ebebeb|501~#403940|502~#ebebeb|503~#ad3841|504~#ebebeb|505~#2243e6|506~#ebebeb|507~#1d8f0b|508~#ebebeb|509~#d1b500|510~#ebebeb|511~#79478c|512~#ebebeb|513~#26a682|514~#ebebeb|515~#b33f00|516~#ebebeb|517~#43870b|518~#ebebeb|519~#b03ac2|520~#ebebeb|521~#005703|522~#ebebeb|523~#0f1ec4|524~#ebebeb|525~#d8dfea|526~#ebebeb|527~#d8dfea|528~#ebebeb|529~#d8dfea|530~#ebebeb|531~#d8dfea|532~#ebebeb|533~#d8dfea|534~#ebebeb|535~#d8dfea|536~#ebebeb|537~#d8dfea|538~#ebebeb|539~#d8dfea', 1),
(8, 'Red Dark', '0~#9c000d|1~#012b03|2~1|165~solid|51~3|52~3|53~3|54~3|3~#470006|50~inset|46~0|47~0|48~49|49~19|5~#470006|55~inset|56~0|57~0|58~49|59~25|7~#ffffff|8~20|36~normal|37~normal|38~none|39~left|40~|63~#000000|60~1|61~1|62~1|9~#f0f0f0|10~14|41~normal|42~normal|43~none|44~left|45~|67~#000000|64~1|65~1|66~1|12~#ff0000|11~#2b0105|68~inset|69~0|70~0|71~45|72~10|73~#520008|74~5|75~5|76~5|77~5|90~17|78~#202020|79~inset|80~4|81~-2|82~23|83~-1|84~#666566|89~1|85~3|86~3|87~3|88~3|272~23|273~#cc0014|251~#bd9199|270~#ffffff|271~#ffffff|252~14|253~normal|254~normal|255~none|256~|274~#000000|275~1|276~1|277~1|257~#470006|258~inset|259~-7|260~0|261~24|262~7|263~#140002|264~1|265~dotted|266~3|267~3|268~3|269~3|91~#000000|92~5|93~22|100~#1f1d1f|101~1|127~solid|102~3|103~3|104~3|105~3|94~#575557|95~inset|96~3|97~2|98~8|99~1|106~#ffffff|107~12|108~bold|109~normal|110~none|112~|113~#20123d|114~0|115~-1|116~1|123~#ff0000|124~#ffffff|125~#050000|126~#1a0c0c|117~#140e0e|118~inset|119~0|120~0|121~14|122~6|128~#000000|129~5|130~22|137~#000000|138~1|164~solid|139~3|140~4|141~3|142~3|131~#575557|132~inset|133~3|134~2|135~8|136~1|143~#ffffff|144~12|145~bold|146~normal|147~none|149~|150~#20123d|151~0|152~-1|153~1|160~#000dff|161~#ffffff|162~#000000|163~#12121a|154~#000000|155~inset|156~0|157~0|158~14|159~4|166~#c7c3c7|167~12|168~normal|169~normal|170~none|171~|172~#000000|173~1|174~1|175~1|176~#fffcff|177~13|178~bold|179~normal|180~none|181~|182~#750000|183~1|184~1|185~8|186~#fafafa|187~11|188~normal|189~normal|190~none|191~|192~#00050d|193~1|194~1|195~1|196~#ffffff|197~13|198~bold|199~normal|200~none|201~|202~#000000|203~1|204~1|205~1|206~#636262|207~2|208~2|209~#ffffff|210~12|211~bold|212~normal|213~none|214~arial|215~#000000|216~1|217~1|218~1|219~#757075|220~1|221~dotted|222~3|223~3|224~3|225~3|226~#2e2e2e|227~#2e2e2e|228~#ffffff|229~#000000|230~#fffaff|231~#470006|232~5|233~#fa0808|234~#1f0000|235~#a8a8a8|236~#282829|237~#ffffff|238~#4f4f4f|239~#ffffff|249~#fafafa|248~11|250~6|240~normal|241~normal|242~none|243~|244~#000000|245~1|246~1|247~1|500~#ebebeb|501~#403940|502~#ebebeb|503~#ad3841|504~#ebebeb|505~#2243e6|506~#ebebeb|507~#1d8f0b|508~#ebebeb|509~#d1b500|510~#ebebeb|511~#79478c|512~#ebebeb|513~#26a682|514~#ebebeb|515~#b33f00|516~#ebebeb|517~#43870b|518~#ebebeb|519~#b03ac2|520~#ebebeb|521~#005703|522~#ebebeb|523~#0f1ec4|524~#ebebeb|525~#d8dfea|526~#ebebeb|527~#d8dfea|528~#ebebeb|529~#d8dfea|530~#ebebeb|531~#d8dfea|532~#ebebeb|533~#d8dfea|534~#ebebeb|535~#d8dfea|536~#ebebeb|537~#d8dfea|538~#ebebeb|539~#d8dfea', 1),
(9, 'Blue', '0~#4a64a0|1~#3c507d|2~1|165~solid|51~7|52~7|53~7|54~7|3~#4a64a0|50~|46~0|47~0|48~24|49~1|5~#4a64a0|55~|56~0|57~0|58~30|59~2|7~#ffffff|8~20|36~normal|37~normal|38~none|39~left|40~"lucida grande",tahoma,verdana,arial,sans-serif|63~#424242|60~-1|61~-1|62~1|9~#ffffff|10~14|41~normal|42~normal|43~none|44~left|45~"lucida grande",tahoma,verdana,arial,sans-serif|67~#363636|64~-1|65~-1|66~1|12~#3b568f|11~#fcf7fc|68~inset|69~1|70~0|71~32|72~-4|73~#484e91|74~5|75~5|76~5|77~5|90~18|78~#292429|79~|80~2|81~2|82~4|83~0|84~#8a8a8a|89~0|85~3|86~3|87~3|88~3|272~23|273~#163780|251~#aeb1f5|270~#ffffff|271~#ffffff|252~14|253~normal|254~normal|255~none|256~"lucida grande",tahoma,verdana,arial,sans-serif|274~#383838|275~-1|276~-1|277~1|257~#e6e8eb|258~inset|259~0|260~0|261~39|262~-3|263~#8c99b3|264~1|265~solid|266~3|267~3|268~3|269~3|91~#385ae0|92~5|93~20|100~#273b9c|101~1|127~solid|102~3|103~3|104~3|105~3|94~#03004d|95~inset|96~6|97~10|98~33|99~-4|106~#ffffff|107~12|108~bold|109~normal|110~none|112~"lucida grande",tahoma,verdana,arial,sans-serif|113~#1f1f1f|114~1|115~1|116~1|123~#385ae0|124~#ffffff|125~#000000|126~#273b9c|117~#03004d|118~inset|119~-6|120~-10|121~33|122~-4|128~#385ae0|129~5|130~20|137~#273b9c|138~1|164~solid|139~3|140~3|141~3|142~3|131~#03004d|132~inset|133~6|134~10|135~33|136~-4|143~#ffffff|144~12|145~bold|146~normal|147~none|149~"lucida grande",tahoma,verdana,arial,sans-serif|150~#1f1f1f|151~1|152~1|153~1|160~#385ae0|161~#ffffff|162~#000000|163~#273b9c|154~#03004d|155~inset|156~-6|157~-10|158~33|159~-4|166~#ffffff|167~12|168~normal|169~normal|170~none|171~"lucida grande",tahoma,verdana,arial,sans-serif|172~#424242|173~-1|174~-1|175~1|176~#fcf9fc|177~13|178~bold|179~normal|180~none|181~"lucida grande",tahoma,verdana,arial,sans-serif|182~#1c1c1c|183~-1|184~-1|185~1|186~#ffffff|187~11|188~normal|189~normal|190~none|191~"lucida grande",tahoma,verdana,arial,sans-serif|192~#292729|193~1|194~1|195~1|196~#ffffff|197~13|198~bold|199~normal|200~none|201~"lucida grande",tahoma,verdana,arial,sans-serif|202~#212121|203~1|204~1|205~1|206~#3a4799|207~2|208~2|209~#ffffff|210~12|211~bold|212~normal|213~none|214~arial|215~#302d30|216~1|217~1|218~1|219~#1c2d73|220~1|221~solid|222~3|223~3|224~3|225~3|226~#1c2d73|227~#1c2d73|228~#ffffff|229~#000000|230~#ffffff|231~#0000fc|232~5|233~#a0acfa|234~#2e41b8|235~#a8a8a8|236~#282829|237~#ffffff|238~#4f4f4f|239~#dfdfed|249~#ffffff|248~11|250~6|240~normal|241~normal|242~none|243~"lucida grande",tahoma,verdana,arial,sans-serif|244~#292729|245~-1|246~-1|247~1|500~#ebebeb|501~#403940|502~#ebebeb|503~#ad3841|504~#ebebeb|505~#2243e6|506~#ebebeb|507~#1d8f0b|508~#ebebeb|509~#d1b500|510~#ebebeb|511~#79478c|512~#ebebeb|513~#26a682|514~#ebebeb|515~#b33f00|516~#ebebeb|517~#43870b|518~#ebebeb|519~#b03ac2|520~#ebebeb|521~#005703|522~#ebebeb|523~#0f1ec4|524~#ebebeb|525~#d8dfea|526~#ebebeb|527~#d8dfea|528~#ebebeb|529~#d8dfea|530~#ebebeb|531~#d8dfea|532~#ebebeb|533~#d8dfea|534~#ebebeb|535~#d8dfea|536~#ebebeb|537~#d8dfea|538~#ebebeb|539~#d8dfea', 1),
(10, 'Green Dark', '0~#004f05|1~#012b03|2~1|165~solid|51~3|52~3|53~3|54~3|3~#012b03|50~inset|46~0|47~0|48~49|49~19|5~#012b03|55~inset|56~0|57~0|58~49|59~25|7~#ffffff|8~20|36~normal|37~normal|38~none|39~left|40~|63~#000000|60~1|61~1|62~1|9~#bababa|10~14|41~normal|42~normal|43~none|44~left|45~|67~#000000|64~1|65~1|66~1|12~#007004|11~#001a01|68~inset|69~0|70~0|71~45|72~2|73~#003b02|74~5|75~5|76~5|77~5|90~17|78~#202020|79~inset|80~4|81~-2|82~23|83~-1|84~#666566|89~1|85~3|86~3|87~3|88~3|272~23|273~#003d03|251~#769177|270~#ffffff|271~#ffffff|252~14|253~normal|254~normal|255~none|256~|274~#000000|275~1|276~1|277~1|257~#aaabad|258~inset|259~0|260~0|261~23|262~-4|263~#757575|264~1|265~dotted|266~3|267~3|268~3|269~3|91~#636262|92~5|93~20|100~#757075|101~1|127~dotted|102~3|103~3|104~3|105~3|94~#000000|95~inset|96~3|97~-3|98~17|99~-4|106~#ffffff|107~12|108~bold|109~normal|110~none|112~|113~#1f1f1f|114~1|115~1|116~1|123~#636262|124~#ffffff|125~#000000|126~#3d3d3d|117~#000000|118~inset|119~3|120~-3|121~23|122~-3|128~#636262|129~5|130~20|137~#757075|138~1|164~dotted|139~3|140~3|141~3|142~3|131~#000000|132~inset|133~3|134~-3|135~17|136~-4|143~#ffffff|144~12|145~bold|146~normal|147~none|149~|150~#1f1f1f|151~1|152~1|153~1|160~#636262|161~#ffffff|162~#000000|163~#3d3d3d|154~#000000|155~inset|156~3|157~-3|158~23|159~-3|166~#c7c3c7|167~12|168~normal|169~normal|170~none|171~|172~#000000|173~1|174~1|175~1|176~#fffcff|177~13|178~bold|179~normal|180~none|181~|182~#750000|183~1|184~1|185~8|186~#fafafa|187~11|188~normal|189~normal|190~none|191~|192~#00050d|193~1|194~1|195~1|196~#ffffff|197~13|198~bold|199~normal|200~none|201~|202~#000000|203~1|204~1|205~1|206~#636262|207~2|208~2|209~#ffffff|210~12|211~bold|212~normal|213~none|214~arial|215~#000000|216~1|217~1|218~1|219~#757075|220~1|221~dotted|222~3|223~3|224~3|225~3|226~#2e2e2e|227~#2e2e2e|228~#ffffff|229~#000000|230~#fffaff|231~#003d03|232~5|233~#00ad06|234~#003d03|235~#a8a8a8|236~#282829|237~#ffffff|238~#4f4f4f|239~#ffffff|249~#fafafa|248~11|250~6|240~normal|241~normal|242~none|243~|244~#000000|245~1|246~1|247~1|500~#ebebeb|501~#403940|502~#ebebeb|503~#ad3841|504~#ebebeb|505~#2243e6|506~#ebebeb|507~#1d8f0b|508~#ebebeb|509~#d1b500|510~#ebebeb|511~#79478c|512~#ebebeb|513~#26a682|514~#ebebeb|515~#b33f00|516~#ebebeb|517~#43870b|518~#ebebeb|519~#b03ac2|520~#ebebeb|521~#005703|522~#ebebeb|523~#0f1ec4|524~#ebebeb|525~#d8dfea|526~#ebebeb|527~#d8dfea|528~#ebebeb|529~#d8dfea|530~#ebebeb|531~#d8dfea|532~#ebebeb|533~#d8dfea|534~#ebebeb|535~#d8dfea|536~#ebebeb|537~#d8dfea|538~#ebebeb|539~#d8dfea', 1),
(11, 'Blue Dark', '0~#0036bd|1~#012b03|2~1|165~solid|51~3|52~3|53~3|54~3|3~#001445|50~inset|46~0|47~0|48~49|49~19|5~#001445|55~inset|56~0|57~0|58~49|59~25|7~#ffffff|8~20|36~normal|37~italic|38~none|39~left|40~|63~#000b26|60~1|61~1|62~1|9~#f0f0f0|10~14|41~normal|42~italic|43~none|44~left|45~|67~#000000|64~1|65~1|66~1|12~#0550ff|11~#000b26|68~inset|69~0|70~0|71~45|72~10|73~#000b26|74~5|75~5|76~5|77~5|90~17|78~#000b26|79~inset|80~4|81~-2|82~23|83~-1|84~#666566|89~1|85~3|86~3|87~3|88~3|272~23|273~#0a56fa|251~#7591d1|270~#ffffff|271~#ffffff|252~14|253~normal|254~italic|255~none|256~|274~#000b26|275~1|276~1|277~1|257~#001340|258~inset|259~-7|260~0|261~24|262~7|263~#00091f|264~1|265~dotted|266~3|267~3|268~3|269~3|91~#ff8800|92~3|93~22|100~#ec8911|101~1|127~solid|102~3|103~3|104~3|105~3|94~#fedb4d|95~inset|96~3|97~3|98~5|99~1|106~#333333|107~12|108~bold|109~normal|110~none|112~|113~#fedb4d|114~0|115~-1|116~3|123~#ff8800|124~#424242|125~#ffdc52|126~#ec8911|117~#fedb4d|118~inset|119~3|120~2|121~7|122~4|128~#ff8800|129~3|130~22|137~#ec8911|138~1|164~solid|139~3|140~3|141~3|142~3|131~#fedb4d|132~inset|133~3|134~2|135~5|136~1|143~#333333|144~12|145~bold|146~normal|147~none|149~|150~#fedb4d|151~0|152~-1|153~3|160~#ff8800|161~#424242|162~#ffdc52|163~#ec8911|154~#fedb4d|155~inset|156~3|157~2|158~7|159~4|166~#c7c3c7|167~12|168~normal|169~normal|170~none|171~|172~#000000|173~1|174~1|175~1|176~#fffcff|177~13|178~bold|179~normal|180~none|181~|182~#750000|183~1|184~1|185~8|186~#fafafa|187~11|188~normal|189~normal|190~none|191~|192~#00050d|193~1|194~1|195~1|196~#ffffff|197~13|198~bold|199~normal|200~none|201~|202~#000000|203~1|204~1|205~1|206~#636262|207~2|208~2|209~#ffffff|210~12|211~bold|212~normal|213~none|214~arial|215~#000000|216~1|217~1|218~1|219~#757075|220~1|221~dotted|222~3|223~3|224~3|225~3|226~#2e2e2e|227~#2e2e2e|228~#ffffff|229~#000000|230~#fffaff|231~#470006|232~5|233~#fa0808|234~#1f0000|235~#a8a8a8|236~#282829|237~#ffffff|238~#4f4f4f|239~#ffffff|249~#fafafa|248~11|250~6|240~normal|241~normal|242~none|243~|244~#000000|245~1|246~1|247~1|500~#ebebeb|501~#403940|502~#ebebeb|503~#ad3841|504~#ebebeb|505~#2243e6|506~#ebebeb|507~#1d8f0b|508~#ebebeb|509~#d1b500|510~#ebebeb|511~#79478c|512~#ebebeb|513~#26a682|514~#ebebeb|515~#b33f00|516~#ebebeb|517~#43870b|518~#ebebeb|519~#b03ac2|520~#ebebeb|521~#005703|522~#ebebeb|523~#0f1ec4|524~#ebebeb|525~#d8dfea|526~#ebebeb|527~#d8dfea|528~#ebebeb|529~#d8dfea|530~#ebebeb|531~#d8dfea|532~#ebebeb|533~#d8dfea|534~#ebebeb|535~#d8dfea|536~#ebebeb|537~#d8dfea|538~#ebebeb|539~#d8dfea', 1),
(12, 'Purple', '0~#9e76e8|1~#6021de|2~1|165~double|51~10|52~10|53~10|54~10|3~#6021de|50~inset|46~10|47~10|48~45|49~2|5~#6021de|55~inset|56~15|57~15|58~50|59~2|7~#ffffff|8~20|36~normal|37~normal|38~none|39~left|40~arial|63~#473569|60~1|61~-1|62~1|9~#ffffff|10~14|41~normal|42~normal|43~none|44~left|45~arial|67~#473569|64~1|65~-1|66~1|12~#ffffff|11~#6021de|68~inset|69~0|70~0|71~55|72~2|73~#865ae0|74~4|75~4|76~4|77~4|90~14|78~#6021de|79~|80~3|81~3|82~3|83~0|84~#ffffff|89~0|85~4|86~4|87~4|88~4|272~23|273~#ffffff|251~#b191f2|270~#6021de|271~#6021de|252~12|253~bold|254~italic|255~none|256~arial|274~#6021de|275~0|276~0|277~0|257~#6021de|258~inset|259~0|260~0|261~25|262~-1|263~#6021de|264~1|265~dotted|266~4|267~4|268~4|269~5|91~#d40012|92~5|93~20|100~#ba0d1e|101~1|127~solid|102~12|103~12|104~12|105~12|94~#ff7886|95~inset|96~3|97~3|98~5|99~0|106~#ffffff|107~12|108~bold|109~normal|110~none|112~Arial|113~#4d0008|114~0|115~-1|116~1|123~#d9041d|124~#fafafa|125~#4d0008|126~#ba0d1e|117~#ff7886|118~inset|119~4|120~4|121~5|122~0|128~#fd9312|129~5|130~20|137~#ec8911|138~1|164~solid|139~12|140~12|141~12|142~12|131~#fedb4d|132~inset|133~3|134~3|135~5|136~1|143~#333333|144~12|145~bold|146~normal|147~none|149~arial|150~#fedb4d|151~0|152~-1|153~3|160~#ff8400|161~#474547|162~#fedb4d|163~#ec8911|154~#fedb4d|155~inset|156~4|157~4|158~5|159~1|166~#ffffff|167~12|168~normal|169~normal|170~none|171~arial|172~#473569|173~1|174~0|175~1|176~#850000|177~14|178~bold|179~normal|180~none|181~arial|182~#473569|183~0|184~0|185~0|186~#ffffff|187~12|188~normal|189~normal|190~none|191~arial|192~#ffffff|193~0|194~0|195~0|196~#850000|197~13|198~bold|199~normal|200~none|201~arial|202~#473569|203~0|204~0|205~0|206~#ffffff|207~2|208~5|209~#6021de|210~12|211~normal|212~normal|213~none|214~arial|215~#ffffff|216~0|217~0|218~0|219~#6021de|220~1|221~solid|222~4|223~4|224~4|225~4|226~#fcfcfc|227~#6021de|228~#6021de|229~#ffffff|230~#ffffff|231~#6021de|232~11|233~#ee442e|234~#991200|235~#fedb4d|236~#ec8911|237~#ec8911|238~#fedb4d|239~#850000|249~#d9d9d9|248~12|250~8|240~normal|241~normal|242~none|243~arial|244~#000000|245~0|246~0|247~0|500~#4f0d0d|501~#ff0000|502~#02008f|503~#2369f5|504~#ff3f05|505~#ffee00|506~#0e4a00|507~#46ff08|508~#ff0000|509~#fa9805|510~#00356e|511~#00fbff|512~#3c0070|513~#b45eff|514~#000303|515~#0032fa|516~#000000|517~#1dd600|518~#ff001e|519~#8c00ff|520~#039488|521~#e8f000|522~#ff2929|523~#ffc20a|524~#b0005e|525~#db00e6|526~#573400|527~#ff8112|528~#3b303b|529~#bab1ba|530~#1938ff|531~#20fab1|532~#ff0000|533~#ff6600|534~#000000|535~#9e9e9e|536~#000000|537~#ccff00|538~#000000|539~#08e2ff', 1);








