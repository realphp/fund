DROP TABLE IF EXISTS <--db-prefix-->cms_single_page;
CREATE TABLE `<--db-prefix-->cms_single_page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(200) NOT NULL DEFAULT '' COMMENT '访问URL路径',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '页面标题',
  `keywords` varchar(200) DEFAULT '' COMMENT '页面关键词(Keywords)',
  `description` text COMMENT '页面描述(Description)',
  `content` text COMMENT '内容',
  PRIMARY KEY (`id`),
  KEY `url` (`url`),
  KEY `title` (`title`),
  KEY `keywords` (`keywords`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
INSERT INTO `<--db-prefix-->cms_single_page` VALUES 
('1','about','关于我们','关于我们','关于我们','<p><img src=\"data/image/201504/18/71949_nMQP_7254.png\" title=\"Screen Shot 2015-04-18 at 03.58.38.png\" alt=\"Screen Shot 2015-04-18 at 03.58.38.png\" width=\"283\" height=\"210\" style=\"width: 283px; height: 210px; float: left;\"/></p><p style=\"text-indent: 2em; text-align: left;\">Co.MZ 是一款轻量级企业网站管理系统，基于PHP+Mysql架构的，可运行在Linux、Windows、MacOSX、Solaris等各种平台上，系统基于ThinkPHP，支持自定义伪静态，前台模板采用DIV+CSS设计，后台界面设计简洁明了，功能简单易具有良好的用户体验，稳定性好、扩展性及安全性强，可面向中小型站点提供网站建设解决方案。</p><p style=\"text-indent: 2em; text-align: left;\"><span style=\"text-indent: 32px;\">某某公司</span>是一家面向全球提供IT解决方案与服务的公司，致力于通过创新的信息化技术来推动社会的发展与变革，为个人创造新的生活方式，为社会创造价值。公司创立于1991年，目前拥有20000名员工，在中国建立了8个区域总部，10个软件研发基地， 16个软件开发与技术支持中心，在60多个城市建立营销与服务网络; 在美国、日本、欧洲、中东、南美设有子公司。</p><p style=\"text-indent: 2em; text-align: left;\">某某公司以软件技术为核心，提供行业解决方案和产品工程解决方案以及相关软件产品、平台及服务。</p><p style=\"text-indent: 2em; text-align: left;\">面向行业客户，<span style=\"text-indent: 32px;\">某某公司</span>提供满足行业智慧发展与管理的解决方案、产品及服务，涵盖领域包括：电信、能源、金融、政府、制造业、商贸流通业、医疗卫生、教育与文化、交通、移动互联网、传媒、环保等。<span style=\"text-indent: 32px;\">某某公司</span>在众多行业领域拥有领先的市场占有率，并参与多项中国国家级信息化标准制定。</p><p><br style=\"text-indent: 2em; text-align: left;\"/></p>'),
('2','contact','联系我们','联系我们','联系我们','<p style=\"text-indent: 2em; text-align: left;\">Co.MZ的为您的公司提供最便捷的服务。</p><p style=\"text-indent: 2em; text-align: left;\">客服电话工作时间为周一至周日 8:00-20:00，节假日不休息，免长途话费。</p><p style=\"text-indent: 2em; text-align: left;\">我们将随时为您献上真诚的服务。</p><hr/><p style=\"white-space: normal; text-indent: 2em; text-align: left;\">邮箱：example@163.com</p><p style=\"white-space: normal; text-indent: 2em; text-align: left;\">手机：13100000000</p><p style=\"white-space: normal; text-indent: 2em; text-align: left;\">QQ ：88888888</p><p style=\"text-align: center;\"><img width=\"530\" height=\"340\" src=\"http://api.map.baidu.com/staticimage?center=121.387616,31.213301&zoom=13&width=530&height=340&markers=121.387616,31.213301\"/></p>'),
('3','awards','荣誉资质','荣誉资质','荣誉资质','<p>荣誉资质</p>');