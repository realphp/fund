DROP TABLE IF EXISTS <--db-prefix-->cms_slide;
CREATE TABLE `<--db-prefix-->cms_slide` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT '' COMMENT '标题',
  `image` varchar(200) NOT NULL DEFAULT '' COMMENT '本地图片',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
INSERT INTO `<--db-prefix-->cms_slide` VALUES 
('1','','data/image/201504/19/48505_cFJz_3727.png'),
('2','','data/image/201504/19/48560_HVLI_4666.png'),
('3','','data/image/201504/19/48571_IvJQ_4623.png'),
('4','不同的主题颜色','data/image/201504/19/48604_TSsv_6001.png');