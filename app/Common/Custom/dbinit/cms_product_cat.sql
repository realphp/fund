DROP TABLE IF EXISTS <--db-prefix-->cms_product_cat;
CREATE TABLE `<--db-prefix-->cms_product_cat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catname` varchar(50) NOT NULL DEFAULT '必须填写' COMMENT '分类名称',
  `sort` int(10) unsigned NOT NULL DEFAULT '999' COMMENT '显示顺序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `catname` (`catname`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
INSERT INTO `<--db-prefix-->cms_product_cat` VALUES 
('1','手机','999'),
('2','笔记本','999'),
('3','平板电脑','999');