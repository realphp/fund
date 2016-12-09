DROP TABLE IF EXISTS <--db-prefix-->cms_partner;
CREATE TABLE `<--db-prefix-->cms_partner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(200) NOT NULL DEFAULT 'http://' COMMENT '网址',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '网站名称',
  `logo` varchar(200) DEFAULT '' COMMENT 'Logo',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '链接位置',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
INSERT INTO `<--db-prefix-->cms_partner` VALUES 
('1','http://www.tecmz.com','TecMZ','data/image/','2'),
('2','http://dazhihu.com','大知乎','data/image/','2'),
('4','http://www.eamonning.com','清泉逐流','data/image/','2'),
('5','http://kkdiary.com','可可日记','data/image/','2'),
('6','http://www.baidu.com','百度','data/image/201504/18/67127_JDxZ_4687.png','1'),
('7','http://www.jd.com','京东','data/image/201504/18/67331_akeC_6911.png','1');