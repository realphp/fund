-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-05-09 04:29:46
-- 服务器版本： 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fund`
--

-- --------------------------------------------------------

--
-- 表的结构 `tpx_admin_access`
--

CREATE TABLE IF NOT EXISTS `tpx_admin_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `module` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tpx_admin_node`
--

CREATE TABLE IF NOT EXISTS `tpx_admin_node` (
`id` smallint(6) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tpx_admin_node`
--

INSERT INTO `tpx_admin_node` (`id`, `name`, `title`, `status`, `remark`, `sort`, `pid`, `level`) VALUES
(1, 'Admin', '_ADMIN_ROOT_', 1, NULL, 0, 0, 1),
(2, 'Administrator', '管理人员', 1, NULL, 100, 1, 2),
(3, 'rolelist', '角色列表', 1, NULL, 100, 2, 3),
(4, 'rolehandle', '角色管理', 1, NULL, 100, 2, 3),
(5, 'nodelist', '节点列表', 1, NULL, 100, 2, 3),
(6, 'nodehandle', '节点管理', 1, NULL, 100, 2, 3),
(7, 'userlist', '管理员列表', 1, NULL, 100, 2, 3),
(8, 'userhandle', '管理员管理', 1, NULL, 100, 2, 3),
(9, 'CmsNews', '内容管理', 1, NULL, 100, 1, 2),
(10, 'cmslist', '新闻动态', 1, NULL, 100, 9, 3),
(11, 'cmshandle', '新闻动态管理', 1, NULL, 100, 9, 3),
(12, 'CmsPartner', '友情链接', 1, NULL, 100, 1, 2),
(13, 'cmslist', '链接列表', 1, NULL, 100, 12, 3),
(14, 'cmshandle', '友情链接管理', 1, NULL, 100, 12, 3),
(15, 'cmsadd', '添加链接', 1, NULL, 100, 12, 3),
(16, 'CmsProductCat', '内容管理', 1, NULL, 100, 1, 2),
(17, 'cmslist', '产品分类', 1, NULL, 100, 16, 3),
(18, 'cmshandle', '产品分类管理', 1, NULL, 100, 16, 3),
(19, 'CmsProduct', '内容管理', 1, NULL, 100, 1, 2),
(20, 'cmslist', '产品中心', 1, NULL, 100, 19, 3),
(21, 'cmshandle', '产品管理', 1, NULL, 100, 19, 3),
(22, 'CmsSinglePage', '单页管理', 1, NULL, 100, 1, 2),
(23, 'cmslist', '单页列表', 1, NULL, 100, 22, 3),
(24, 'cmshandle', '单页管理', 1, NULL, 100, 22, 3),
(25, 'CmsSlide', '网站设置', 1, NULL, 100, 1, 2),
(26, 'cmslist', '首页大图', 1, NULL, 100, 25, 3),
(27, 'cmshandle', '首页大图管理', 1, NULL, 100, 25, 3),
(28, 'Database', '数据库', 1, NULL, 100, 1, 2),
(29, 'backup', '数据库备份', 1, NULL, 100, 28, 3),
(30, 'restore', '数据库恢复', 1, NULL, 100, 28, 3),
(31, 'operation', '数据库操作', 1, NULL, 100, 28, 3),
(32, 'ModConfig', '网站设置', 1, NULL, 100, 1, 2),
(33, 'basic', '基本设置', 1, NULL, 100, 32, 3),
(34, 'contact', '联系方式', 1, NULL, 100, 32, 3),
(35, 'counter', '访问统计', 1, NULL, 100, 32, 3),
(36, 'domain', '域名绑定', 1, NULL, 100, 32, 3),
(37, 'ModConfigCustom', '网站设置', 1, NULL, 100, 1, 2),
(38, 'index', '其他设置', 1, NULL, 100, 37, 3),
(39, 'System', '系统维护', 1, NULL, 100, 1, 2),
(40, 'cmslist', '内容模型', 1, NULL, 100, 39, 3),
(41, 'modlist', '系统模块', 1, NULL, 100, 39, 3),
(42, 'security', '系统安全', 1, NULL, 100, 39, 3),
(43, 'filelist', '文件列表', 1, NULL, 100, 39, 3),
(44, 'filehandle', '文件管理', 1, NULL, 100, 39, 3),
(45, 'clean', '系统清理', 1, NULL, 100, 39, 3),
(46, 'info', '系统信息', 1, NULL, 100, 39, 3),
(47, 'uploadhandle', '文件上传', 1, NULL, 100, 39, 3),
(48, 'maintain', '日常维护', 1, NULL, 100, 39, 3),
(49, 'downloader', '下载文件', 1, NULL, 100, 39, 3),
(50, 'upgrade', '系统升级', 1, NULL, 100, 39, 3),
(51, 'profile', '个人信息', 1, NULL, 100, 39, 3),
(52, 'changepwd', '修改密码', 1, NULL, 100, 39, 3);

-- --------------------------------------------------------

--
-- 表的结构 `tpx_admin_role`
--

CREATE TABLE IF NOT EXISTS `tpx_admin_role` (
`id` int(6) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `pid` int(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tpx_admin_role`
--

INSERT INTO `tpx_admin_role` (`id`, `name`, `pid`, `status`, `remark`) VALUES
(1, '超级管理员', NULL, 1, NULL),
(2, '操作员', NULL, 1, NULL),
(3, '网站编辑', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tpx_admin_role_user`
--

CREATE TABLE IF NOT EXISTS `tpx_admin_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tpx_admin_user`
--

CREATE TABLE IF NOT EXISTS `tpx_admin_user` (
`id` int(10) unsigned NOT NULL,
  `username` char(16) NOT NULL,
  `password` char(32) NOT NULL,
  `password_salt` char(10) NOT NULL,
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0',
  `reg_ip` bigint(20) NOT NULL DEFAULT '0',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login_ip` bigint(20) NOT NULL DEFAULT '0',
  `last_change_pwd_time` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) DEFAULT '0' COMMENT '用户状态0正常1锁定'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tpx_admin_user`
--

INSERT INTO `tpx_admin_user` (`id`, `username`, `password`, `password_salt`, `reg_time`, `reg_ip`, `last_login_time`, `last_login_ip`, `last_change_pwd_time`, `status`) VALUES
(1, 'admin', 'a9bb1786c424ce2b8dde861bb16bfdbb', 'hSimxbAcGO', 1460432062, 2130706433, 1462759722, 2130706433, 1460432062, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tpx_cms_news`
--

CREATE TABLE IF NOT EXISTS `tpx_cms_news` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '新闻标题',
  `posttime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `keywords` varchar(200) DEFAULT '' COMMENT '新闻关键词(Keywords)',
  `description` text COMMENT '新闻描述(Description)',
  `cover` varchar(200) NOT NULL DEFAULT '' COMMENT '封面',
  `content` text COMMENT '内容'
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tpx_cms_news`
--

INSERT INTO `tpx_cms_news` (`id`, `title`, `posttime`, `keywords`, `description`, `cover`, `content`) VALUES
(1, '移动互联网产品设计的核心要素有哪些？', 1429287394, '移动互联网产品设计的核心要素有哪些？', '移动互联网产品设计的核心要素有哪些？', 'data/image/201504/18/58763_lPCY_1069.jpg', '<p style="text-indent: 2em; text-align: left;"><span style="text-indent: 2em;">移动互联网和传统互联网的设计有很多不同，针对前者有哪些关键的设计重点、考虑要素、交互或体验要特别注意的呢？本文来自知乎网友可风的回答。</span></p><p style="text-indent: 2em; text-align: left;"><span style="text-indent: 2em;">最近越来越多的圈内人开始随大潮进入移动互联网领域，从传统的web或者桌面端设计开始学习移动互联网产品的设计。在很多人眼里，设计移动互联网产品和传统互联网产品的区别无非就是载体从电脑变成了手机，所以只要熟悉一下各个手机中不同的规范和特性就算是完成了过渡，学习了下ios human guideline，了解了一下拟物化设计和扁平化设计，就以为是了解了移动互联网的设计方法。其实这种思想完全是只看到表现而没看到本质的错误，移动互联网和传统互联网的区别不光是设计标准和设计规范的变化，而应该从整个物理环境的变化来重新全面的认识。那么我们分析一下，移动互联网产品的用户体验和传统互联网产品有什么区别呢？</span></p><p style="text-indent: 2em; text-align: left;"><br/></p><p style="text-indent: 2em; text-align: left;">一、使用场景的复杂</p><p style="text-indent: 2em; text-align: left;">用户在使用桌面客户端或者访问web页面的时候，多半是坐在电脑前，固定的盯着屏幕和使用键鼠操作，这个时候对于用户来说，使用场景是简单而固定的。但是在使用手机的时候，用户可能在地铁中，在公交上，在电梯中，无聊等待时或者边走路边用。如此复杂的场景，需要产品的设计者考虑的要素也自然非常的复杂。</p><p style="text-indent: 2em; text-align: left;">比如在公交车上拥挤和摇晃时，用户如果才能顺畅的单手操作？比如在地铁或者电梯的信号不好的情况下，是否要考虑各种网络情况带来的问题？比如用户在无聊等待玩游戏，或者在床上睡前时，又变成了深入沉浸的体验？不同的场景不同的情况在设计时是否都有考虑清楚？</p><p style="text-indent: 2em; text-align: left;"><br/></p><p style="text-indent: 2em; text-align: left;">二、使用时间碎片化</p><p style="text-indent: 2em; text-align: left;">用户在使用电脑时，大部分时间还是固定的，无非可能因为工作和同事沟通一下，或者起身上个厕所，一般都有10-20分钟完整的时间片在操作电脑。但是移动端就不一样了，用户既然在移动，使用手机时要随时随地观察周围的情况，随时可能中断现在的操作，锁屏，再继续刚才的操作。所以用户使用移动产品的时间不是连成片的，而是一段一段的，有的时候中断回再回来，有的时候中断就不会回来了。</p><p style="text-indent: 2em; text-align: left;"><br/></p><p style="text-indent: 2em; text-align: left;">三、屏幕尺寸的缩小</p><p style="text-indent: 2em; text-align: left;">用户使用电脑产品的屏幕尺寸是可以很大的，小则13寸大到27寸，这样使得桌面产品和web产品有充足的区域展现信息，整个界面利用率就可以很高。我们在做交互设计的时候会有一种方法，如果一个次要信息的出现不会影响大部分用户的时候，那么这个次要信息是可以放在界面上的，这就是为什么网站可以加入很多广告banner的原因，因为只要保持到一个度不影响正常的使用就不会破坏整体的用户体验。但是在移动端，这个度是非常的小的，因为屏幕尺寸的限制，本身需要你展现的必要信息都需要有一个合理的规划和抉择，次要的信息再一出来肯定破坏体验。将前2条结合你会发现，用户在使用移动产品是需要非常追求效率的，所以移动端产品的设计难道会大大增加。</p><p style="text-indent: 2em; text-align: left;"><br/></p><p style="text-indent: 2em; text-align: left;">四、无法多任务的处理信息</p><p style="text-indent: 2em; text-align: left;">用户在使用桌面产品时，是更加容易的进行多任务操作和处理的，比如我正在浏览web查资料，又正在进行文档的整理，还可能开着QQ和朋友聊天。因为大屏幕的关系和系统机制让用户能够高效的同时处理多个信息，当然，还得益于固定的使用场景和完整的时间片。但是因为前面也提到的问题，移动端的产品往往是沉浸式的，用户在同一时期只可能使用一个应用，完成一个流程，然后结束，再去开启另一个应用和另一个流程，所以大部分移动产品设计时往往讲求遵循的是单一的任务流，期间结束和跳转的设计非常的少。</p><p style="text-indent: 2em; text-align: left;"><br/></p><p style="text-indent: 2em; text-align: left;">五、平台的设计规范和特性</p><p style="text-indent: 2em; text-align: left;">最后才是各自的平台规范和标准，比如什么ios human guideline或者WindowsPhone的metro理念，纵观知乎和各大网站，很多人每天关注的都是这些比如拟物化设计和扁平化设计的风格，返回按钮的逻辑或者隐藏title之类的方法论细节。的确你了解这些信息是可以快速方便的设计出一个可用的移动产品的，但是如果没有了解之前所说的几条移动产品和传统互联网产品在用户体验上的区别，你可能永远也无法参透移动互联网用户体验的规律和本质。<br style="text-indent: 2em; text-align: left;"/></p><p><br style="text-indent: 2em; text-align: left;"/></p>'),
(2, '互联网+政府新模式，BAT又在搞什么？', 1429291904, '互联网+政府新模式，BAT又在搞什么？', '互联网+政府新模式，BAT又在搞什么？', 'data/image/201504/18/63208_nvLT_7733.jpg', '<p style="text-indent: 2em; text-align: left;">李克强总理的一句互联网+，不仅深受各领域的企业追捧，政府部门也积极响应总理的号召，寻找自身互联网+的着力点，在政府找寻的依靠中，BAT无疑是中意的人选。这不，微信才开始布局城市服务不久，高德也积极展开了与政府的牵手活动，推出高德交通信息公共服务平台，而在此前，百度早有预谋，与北京市政府以及服务商等打造“北京健康云”。BAT三家此次在牵手政府方面，又走在了前面，随着互联网的发展，未来互联网+政府的新模式是大势所趋，接下来会是哪一家追随BAT三家的脚步，让我们静观其变。</p><p style="text-indent: 2em; text-align: left;">2015年互联网界谁最忙？不是互联网巨头，也不是某个领域群起的创业企业，更不是行业内不断的投资并购案，最忙的应该是“互联网+”这个词语。因为李克强总理在两会之中，对互联网+概念的延伸，引起了互联网界沸腾式的开启了“互联网+运动”。互联网+医疗、互联网+金融、互联网+餐饮等等等等，互联网+存在于各行各业，许多互联网企业都不甘愿只专注互联网本身，它们通过互联网+看到了更多的可能性。不仅互联网巨头忙着跟互联网+建立各种联系，初创企业、小微企业也忙着向互联网+靠拢。</p><p style="text-indent: 2em; text-align: left;">其实，除了这些互联网大佬，政府也忙着响应总理的号召，开始了自己拼命的互联网+之路，而在政府找寻的依靠中，BAT首当其冲。今天，高德联手交管部门推出交通信息公共服务平台，互联网+政府又一案敲定，互联网公司找寻政府部门合作，政府部门也需要互联网的洗礼，在总理的响应下，开启了互联网+政府的新合作模式。下面，笔者将带领大家回忆一下BAT与政府的一系列合作，看看他们密谋的是什么？</p><p style="text-indent: 2em; text-align: left;"><br/></p><p style="text-indent: 2em; text-align: left;"><strong>阿里巴巴：高德与交管部门——交通信息公共服务平台</strong></p><p style="text-indent: 2em; text-align: left;">高德联合北京、广州等8个城市的政府交通管理部门，以及北京交通台等权威媒体机构，共同推出“高德交通信息公共服务平台”。 该服务平台依托于高德交通大数据系统——“高德交通大数据云”进行研发，同时也是“高德交通大数据云”系统与相关交通机构进行数据合作对接之后发布的首款产品。</p><p style="text-indent: 2em; text-align: left;">据了解，基于高德提供的实时交通信息和交通大数据能力，该服务平台为相关交通机构提供“城市堵点排行”、“热点商圈路况”、“权威交通事件”、“堵点异常监测”等交通信息分析，并提出智能出行躲避拥堵方案。目前，该平台已向北京、广州、深圳、天津、沈阳、大连、无锡、青岛等8个城市的交通管理部门以及各地广播交通台等媒体机构开放。未来，该平台还将扩大服务范围。</p><p style="text-indent: 2em; text-align: left;">此前不久，高德刚刚宣布推出LBS+战略，能够提供覆盖“工具+数据+服务”全系列的LBS能力。LBS（基于位置的服务）是移动互联网区别PC互联网的最大变量。移动互联网领域的下一波创新产品，例如O2O、智能硬件、公益环保等都离不开LBS的支持， LBS开放平台将成为这股热潮的重要支撑。阿里巴巴移动事业群总裁俞永福曾说，高德三年内的明确定位，不考虑商业的O2O，只考虑用户服务。通过与政府达成合作，LBS+开放平台，更加掌握用户习惯，聚点大数据，高德似乎在谋划一张很大的网。</p><p style="text-indent: 2em; text-align: left;"><br/></p><p style="text-indent: 2em; text-align: left;"><strong>腾讯：微信与政府——城市服务</strong></p><p style="text-indent: 2em; text-align: left;">2015年，微信城市服务落地广州，“城市服务”入口将把包括交通、医疗、社保、公积金、旅游、金融等分散的生活服务功能在微信上集合到一起，市民足不出户，就能获得便捷高效的服务体验。腾讯方面称，基于公司积累的海量数据基础及成熟的云计算能力，腾讯已专门定制了一套基于互联网+的智慧解决方案。目前，上线的城市有广州、深圳、佛山、武汉、郑州、重庆、上海等多个城市都已开通。</p><p style="text-indent: 2em; text-align: left;">微信与各地政府就“互联网＋”达成全方位、深层次的战略合作，将共同探索和推进“互联网＋”在各个城市领域的应用，为民生发展和产业转型寻找新风口。此次微信城市服务的推出，一方面，加速了微信在移动互联网领域入口的布局，另一方面，也深耕了与政府的合作，实现了落地。但是，未来，在医疗、交通等细分领域的进一步发展，还有许多难题需要突破，微信需要做好足够的准备。</p><p style="text-indent: 2em; text-align: left;"><br/></p><p style="text-indent: 2em; text-align: left;"><strong>百度：百度与北京政府合作——北京健康云</strong></p><p style="text-indent: 2em; text-align: left;">一向反应有点迟钝的百度，在与政府合作方面却走在了前面。在互联网+概念还未被提及之时，百度于去年，就已经与北京政府展开合作，将同智能设备厂商和服务商联手打造“北京健康云”。北京市相关负责人也表示：“北京健康云”也是北京“祥云工程”的重点项目之一。</p><p style="text-indent: 2em; text-align: left;">百度副总裁李明远曾说：在“移动互联网+云计算+大数据”时代，创新的方向是“软件+硬件、线下+线上”结合在一起的创新。这也是百度的方向。百度云技术经理孙鹤飞透露，百度在大数据处理方面正断在招兵买马，未来将引入更多深度学习方面的高技术人才。北京市经济与信息化委员会副主任姜贵平曾也表示，北京市经济和信息化委员会组织百度等相关参与企业制定了“一、十、百、千万”战略目标，即建设一个统一的健康云平台，在明年建成十个市民体验中心，接入百家智能设备厂商，并在三年内覆盖千万市民。可见，百度与北京市政府一拍即合，而百度最近一直比较关注人工智能等领域，在互联网+的冲击下，相信很快，百度将会展开互联网+政府的新合作。</p><p style="text-indent: 2em; text-align: left;">BAT三家此次在牵手政府方面，又走在了前面，随着互联网的发展，未来互联网+政府的新模式是大势所趋，接下来会是哪一家追随BAT三家的脚步，让我们静观其变。</p><p><br style="text-indent: 2em; text-align: left;"/></p>'),
(3, '58同城和赶集网为什么选择合并？', 1429295453, '58同城和赶集网为什么选择合并？', '58同城和赶集网为什么选择合并？', 'data/image/201504/18/66725_YkgS_4582.jpg', '<p style="text-indent: 2em; text-align: left;">58同城今日宣布战略入股另一分类信息网站赶集网，双方将共同成立58赶集有限公司。58同城将以现金加股票的方式获得赶集网43.2%的股份（完全稀释后），其中包含3400万份普通股（合1700万份ADS）及4.122亿美元现金。</p><p style="text-indent: 2em; text-align: left;">根据双方协议，合并后，两家公司将保持品牌独立性，网站及团队均继续保持独立发展与运营。</p><p style="text-indent: 2em; text-align: left;">公告同时显示，腾讯将以52美元每ADS的价格认购价值4亿美元的58同城新发股票。这轮追加投资后，腾讯占股比例将达到25.1%。</p><p style="text-indent: 2em; text-align: left;"><br/></p><p style="text-indent: 2em; text-align: left;"><strong>赶集网为何接受58同城的投资？</strong></p><p style="text-indent: 2em; text-align: left;">今年以来，不断传出赶集网寻求新一轮融资的消息，而此前于去年8月，赶集网CEO杨浩涌还曾公开对外宣布，将于2015年6月左右启动IPO计划。</p><p style="text-indent: 2em; text-align: left;">赶集网从去年下半年以来，开始在汽车、房产等领域频频试水新的业务模式，这些举动也被视为赶集冲击上市前的准备动作。</p><p style="text-indent: 2em; text-align: left;">但知情人士对腾讯科技透露，赶集的投资方对公司上市前景预期并不乐观，因此强力撮合赶集与58同城。</p><p style="text-indent: 2em; text-align: left;">此前腾讯科技也曾报道过，推动此次交易的推手很有可能是老虎基金。老虎基金在赶集和58同城两边下筹码，积极游说双方合并。</p><p style="text-indent: 2em; text-align: left;">按照此次交易条款，58同城以1700万份ADS及4.122亿美元现金，换得赶集网43.2%股份。按照腾讯认购58同城新股的52美元计算，赶集网在此轮融资中的估值应为30亿美元。</p><p style="text-indent: 2em; text-align: left;">赶集网此前共获得五轮融资，包括2009年获得蓝驰创投的A轮投资800万美元；2010年，获得诺基亚成长伙伴基金和蓝驰创投的B轮投资2000万美元；2011年，获得今日资本和红杉资本的C轮7000万美元投资；2012年，获得来自中信产业基金， OTTP及麦格理的两轮融资总规模9000万美元D轮融资。2014年8月，赶集获得E轮融资，融资总额超过2亿美金,投资方为老虎基金和凯雷投资集团。</p><p style="text-indent: 2em; text-align: left;">此次接受58同城的战略投资，意味着两家分类信息平台多年的激烈竞争即将告一段落。作为该领域排名第一和第二位的公司，战略合作后将获得分类信息市场的绝对份额。</p><p style="text-indent: 2em; text-align: left;"><br/></p><p style="text-indent: 2em; text-align: left;"><strong>58同城为什么对赶集有兴趣？</strong></p><p style="text-indent: 2em; text-align: left;">由于分类信息模式护城河较浅，因此不论是58同城还是赶集网，在发展上都依赖资本的支持以及在营销上的投入。在过去的激烈竞争中，双方的营销费用都持续大幅上涨。在这种背景下，58同城积极投资赶集网也在情理之中。</p><p style="text-indent: 2em; text-align: left;">58同城战略投资赶集网后，双方的合同效应将加强，包括降低市场投入，以提升行业利润率水平，以及继续在产业链深化布局，促进商业模式升级。</p><p style="text-indent: 2em; text-align: left;">58同城与赶集网在业务层面上，都依赖在本地市场的口碑和知名度。除去在百度上投放关键词广告，双方都长期在各类本地媒体投放广告，包括电视广播、公交楼宇广告等。</p><p style="text-indent: 2em; text-align: left;">2011年，58同城曾大举投放7000万美元广告，以树立品牌形象。随着业务的稳定，58在随后几年中，市场及销售费用占比逐渐缩减。但进入到2014年，分类信息领域的竞争进一步加剧，58同城及赶集都加大了广告投放力度。</p><p style="text-indent: 2em; text-align: left;">根据财报，2014年，58同城全年广告费用为7340万美元，相较于2013年的2270万美元增长超过两倍，增长速度远高于当年营收81.8%的增长率。广告费用的大幅提升，主要是移动端的市场推广以及PC端的流量成本。而58同城CEO姚劲波(微博)在14年四季度电话会议上也表示，将持续加大在市场及销售上的投入。</p><p style="text-indent: 2em; text-align: left;">赶集网在14年8月获得2亿美元E轮融资后，也开始加大市场营销力度。此前在14年初，杨浩涌就表示，全年将投放2亿元人民币在市场推广上。当年，赶集网重金邀请谢娜作为代言人并投放巨额电视、户外广告，打出了转型招聘的口号。一年后,赶集的代言人又再一次“升级”为范冰冰。</p><p style="text-indent: 2em; text-align: left;">双方在市场推广上的巨额投入势必拉低利润率水平。14年全年，58同城总营收为2.65亿美元，净利润2260万美元，净利率为8.5%，低于2013年的13.4%。</p><p style="text-indent: 2em; text-align: left;">这种情况显然不为58同城所乐见，作为行业排名第一位的分类信息平台，58同城通过战略投资赶集网，势必将降低在市场上的推广费用，有利于提升行业的利润率水平。</p><p style="text-indent: 2em; text-align: left;"><br/></p><p style="text-indent: 2em; text-align: left;"><strong>新成立的58赶集会如何整合？</strong></p><p style="text-indent: 2em; text-align: left;">根据协议，两家公司将保持品牌独立性，网站及团队均继续保持独立发展与运营。此前，腾讯科技曾报道，58同城CEO姚劲波、赶集CEO杨浩涌或将共同担任新成立公司的联席CEO，两人共同决定公司的重大决策。</p><p style="text-indent: 2em; text-align: left;">联席CEO在此前的并购案中鲜有成功案例。参照此前滴滴快的合并，交易达成后后，快的管理层也开始套现退出。</p><p style="text-indent: 2em; text-align: left;">如果能够实现顺利过渡和整合，除了将在分类信息业务上发挥协同效应，双方在房产、汽车等产业链的布局也能形成进一步的同盟。</p><p style="text-indent: 2em; text-align: left;">2014年开始，58同城与赶集在产业布局上的脚步都开始加快。不同的是，58同城主要通过投资和收购，而赶集更多的是通过内部孵化，来培育一些生活服务相关的O2O项目。</p><p style="text-indent: 2em; text-align: left;">过去一年，58同城公开宣布的投资就接近10起，陆续驾考平台驾校一点通、房产信息平台安居客，以及入股装修O2O公司土巴兔等，除此之外公司表示“还有五六起目前不能公布”。另一方面，58同城成立了独立子公司“58到家”，发力上门经济。</p><p style="text-indent: 2em; text-align: left;">赶集网也从去年起开始在汽车、房产等领域试水新的业务模式，包括推出C2C二手车项目“赶集好车”及上门洗车项目“赶集易洗车”，同时在房产也刚刚与房多多宣布达成战略合作。</p><p style="text-indent: 2em; text-align: left;">可以看出，房产、汽车是58同城及赶集网发展的重点领域。不论是通过投资，或内部孵化，双方都试图深化业务模式，打通线下交易服务环节，形成更完整的生态链。</p><p style="text-indent: 2em; text-align: left;">在多年的激烈竞争后，58同城战略投资赶集网，将有利于控制双方成本，提升盈利水平，同时加强协同效应，进一步在O2O方向上进行布局，深化原有的业务模式。</p><p><br style="text-indent: 2em; text-align: left;"/></p>'),
(4, '我们都有“病”：互联网时代的数字遗忘症', 1429295560, '我们都有“病”：互联网时代的数字遗忘症', '我们都有“病”：互联网时代的数字遗忘症', 'data/image/201504/18/66863_TlwV_3898.jpg', '<p style="text-indent: 2em; text-align: left;">网络文学的兴起让阅读变成了文字快餐，一章还没看完就忘了楔子是什么；每一天都在制造和遗忘着一些二进制数据，再一次“重见天日”之时往往带来的是“致命”的打击；今天还在人人追捧的新闻，隔天已成昨日黄花，除了真真假假的唏嘘什么都没留下。</p><p style="text-indent: 2em; text-align: left;">飞逝的何止是时间，还有互联网的价值，一直从信息中汲取养分的互联网发展变得价值不明。互联网带给我们的比让我们失去的究竟哪个更多？</p><p style="text-indent: 2em; text-align: left;">谨慎互联网的去价值化</p><p style="text-indent: 2em; text-align: left;"><br/></p><p style="text-indent: 2em; text-align: left;">1. 眼球经济</p><p style="text-indent: 2em; text-align: left;">互联网时代也可以说是一个眼球经济的时代，人们倾向于获取新的事物信息满足更高层次的精神需求，并且保证自己在人群中的谈资和优越感。价值信息没有更多的时间去创作和修饰，甚至于完整信息都会被拆解分离、无序整合以便于传播。每一天你都在转发有意思的内容，到最后真正记住的可能只是了了。信息的流通造就了互联网时代，社交网络的出现进一步带给人们“时刻都在进步”的假象。人们的注意力被标题党和眼球经济内容夺走了，2011年中国人均读书的4.3本中可能还包括了电子书、网络文学等电子阅读物，这让过渡到互联网时代的电子读物的价值变得单薄。大量的推文、社交APP只为人们提供有吸引力的碎片化、快餐式内容，少量的学习成本却让你感到了博学，碎片化信息让互联网丧失了原有的高品质传播价值。</p><p style="text-indent: 2em; text-align: left;"><br/></p><p style="text-indent: 2em; text-align: left;">2.公关热点</p><p style="text-indent: 2em; text-align: left;">在网上流行的“看完速7去速8”的段子，让其两天的时间段内在全国范围达到10%的转化率，这个数字让PR们打足了鸡血。</p><p><br style="text-indent: 2em; text-align: left;"/></p><p style="text-align:center"><img src="data/image/201504/18/66783_pkFb_1297.jpg" alt="互联网时代 网络文学是垃圾" border="0" style="margin: 0px; padding: 0px; border: 1px solid rgb(153, 153, 153); font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle; color: transparent; display: inline-block;"/></p><p style="text-indent: 2em; text-align: left;">相信不久后又会形成以综艺为主题的“跑男”、“花少”热点。社会意识形态随着90后的成长也在缓慢发生着变化，一代新人不喜欢循规蹈矩。成长于互联网土壤的眼球经济不仅加速了信息的更迭和传播，也培养出了一群“博取眼球”，爱骂战、爱呛声、爱撕逼的PR群体和一群爱看戏的人。就像此前小米和海尔的你来我往一样，人们太喜欢看到两个一边扔钱一边拉你入伙的人了，站站队就有礼物拿，何乐而不为？最后就剩下送出去的奖品，可谁也不会去买产品。</p><p style="text-indent: 2em; text-align: left;">每时每刻的热点让人们在接收信息，理解内容时并非采取主动姿态。被动即遗忘，被动接受的互联网环境是容易让人们形成抗性，产生感官疲劳的。人们不再主动地像从前一样慢慢品味一段文字，热点可以被公关们玩转出转化率，转化率反过来刺激公关们制造更多的热点。执着于热点的PR们似乎集体走了一条歪路，放弃了对完整价值信息流通进行把关的使命。可悲的是这些热点可能只是被被动遗忘的信息片段，速8的段子还会在下一场电影下一个情人节出现在微博头条和朋友圈里。麻木者恒麻木，打鸡血的还在打鸡血。</p><p style="text-indent: 2em; text-align: left;"><br/></p><p style="text-indent: 2em; text-align: left;">3.信息高墙</p><p style="text-indent: 2em; text-align: left;">越来越多的服务端因为消费习惯几乎被垄断，服务端的出路被局限于小众垂直，但是由于垂直电商自身的局限以及信息爆炸时代人们越来越倾向于固定的可靠的平台。碎片化、热点化的互联网传播的信息在“信息高墙”下进一步丧失了价值，那些较为完整的信息内容在版权的保护下失去了流通机会，每个子集的内容被人为分割，让互联网的线出现连通阻碍。</p><p style="text-indent: 2em; text-align: left;">人为的“玛利亚之墙”或许比较容易被打破，但是科学的柏林墙却在20世纪末被建立了起来。互联网靠着信息流通实现了全球化，技术层面却迟迟没有进步。我们可以明显感觉到科学的发展速度远远落后于20世纪70年代到21世纪初里信息科学，更加比不上20世纪60年代那些把人类送上伟大征途的科学发现。如今的互联网分支移动互联网存在的技术瓶颈把互联网产业及其延伸的价值再次削弱，世界范围内真正的科技创新团体实在是少之又有，大部分科研机构和创新公司只是在重复着模仿和碰运气。</p><p style="text-indent: 2em; text-align: left;">“数字遗忘症”与失去了价值的互联网</p><p style="text-indent: 2em; text-align: left;">人们在使用着逐渐失去部分价值的互联网同时，也在丧失自己的信息接收处理能力和储存能力，现代社会超过承载峰值的信息很难在短时间内被人们的大脑内化让人们只是左耳进右耳出。人们把大量信息塞进了二进制中去，这种分散的零散的信息很难被再一次找到并利用。简单来说，人类的大脑被数字信息只是充当了一个把信息从一个地方转移到另一个地方的流通环节中的一环。人们在互联网技术一成不变、信息膨胀的今天，患上了“软性数字遗忘症”。</p><p style="text-indent: 2em; text-align: left;">“软性数字遗忘症”又加剧了互联网的“贬值”，信息的价值没有在使用者身上发生化学反应，反而成了累赘。人们的一连串思考行为被互联网切割了，听过或者看过的信息并没有被记住，等到你想再次唤醒那部分记忆的时候只能看到空洞的大脑。不是书到用时方恨少，而是书到用时始觉无。互联网的去价值化导致了数字遗忘症，数字遗忘症让人们转而回到原始的纸笔时代以保证思维的连续性，没有人参与的互联网就像一座虚有其表的数字空城。</p><p style="text-indent: 2em; text-align: left;">就个人来言，忽略前期的有序整理，即使是经过归纳分类的照片、文字数据，在需要某一特定文件时的寻找也是需要耗费大量时间的，更不要说文件随处乱放或者胡乱命名了，在一个个文件夹翻找一样东西的难度堪比在蜂房迷宫中找到逃出的钥匙一般，庆幸的是电脑为你解决了找到钥匙后怎么出来的问题。这种遥不可及的距离让我怀念起一本被翻出来就可以触摸到质感的老照片。</p><p style="text-indent: 2em; text-align: left;">除了“软性数字遗忘症”之外，意义多元化的互联网还在蔓延着一种“硬性数字遗忘症”。在大数据已成定局的时代我们需要想想把自己的全部身家都交给0和1真的好吗？其中个人隐私的问题，人们开始注意到数字遗忘权的重要性，谷歌的一项自动启动匿名浏览模式甚至获得了专利，不过这个问题涉及到更广层面的探讨。</p><p style="text-indent: 2em; text-align: left;">人们对数据统计和分析事实上是缺乏探索精神的，而是更加倾向于个体的数据整合和最终呈现。大量的数据需要被存储，这让人们患上“硬性数字遗忘症”的几率又增加了。就像我们大量的浏览历史等数据信息很难被完整保存、呈现，去找上个月的一个搜索记录可能会花费你相当多的时间（如果你想的起来关键内容的话）。前面有提到，人们好像把自己的记忆全权交给了互联网环境下的数据存储设备，但是数据的存储也是有极限的，个人信息被全盘接收的信息却不能被完全呈现，信息的价值在“硬性数字遗忘症”中损耗流失了，互联网也随之“贬值”。</p><p style="text-indent: 2em; text-align: left;">人类是一个需要记录的物种，这也是社交性动物的一种需求。不仅是中国地区的博客，世界范围内曾经代表新兴文化的个人记录类网站都在萎缩，你只要一搜索，各种部落格、微型博客、生活日记甚至打卡记录的网站、APP比比皆是。红极一时的饭否就是一个典型例子，被认为是微博鼻祖的它却在2009年7月7日被关闭，用户也随之树倒猢猴散，而在互联网应用中产生的信息也被遏止甚至停止了生命力。这与人们的获取信息习惯的改变关系很大。你无法把大量数据在短时间内炼化或者整体搬移，一旦“硬件”消失，所有的记录信息都会被付之一炬。更不用说选择了小众化记录的人群更容易患上“硬性数字遗忘症”，一旦运营者无法支付网站或者应用的服务器费用，随着服务器关闭所有记录的信息都会被抹灭。“硬性数字遗忘症”强制性让人们远离了互联网，互联网也因此失去了存在意义。</p><p style="text-indent: 2em; text-align: left;">最后再讲一个小段子，曾经看过有一个手机端的养成类APP应用在准备关停服务器时发现竟然还有个位数的活跃用户，于是运营者决定有使用用户一天，服务器运行一天。这看上去是一个很有爱的故事，但是又有几人可以真正为了用户而把钱烧在没有回报的产品中？寥寥几人的世界到底体现了多少互联网价值？</p><p style="text-indent: 2em; text-align: left;">显然，把互联网比作百足之虫是不妥当的。但是，互联网繁荣让人们忽略了互联网部分价值已经处于垂危状态的事实。看似方兴未艾的互联网经济实际上是非常脆弱的，有病就得治，就像我们不一定非要在股市大崩盘的时候才开始谈谨慎入市的重要性一样。</p><p><br style="text-indent: 2em; text-align: left;"/></p>'),
(5, '都是队友的错！？联发科高端之梦再被堵', 1429295669, '都是队友的错！？联发科高端之梦再被堵', '都是队友的错！？联发科高端之梦再被堵', 'data/image/201504/18/66932_NCau_2769.jpg', '<p></p><p style="text-align:center"><img src="data/image/201504/18/66901_JakO_5621.jpg" alt="联发科 联发科技" border="0" width="592" style="margin: 0px; padding: 0px; border: 1px solid rgb(153, 153, 153); font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle; color: transparent; display: inline-block;"/></p><p style="text-indent: 2em; text-align: left;">数月前，乐视曾经在宣传自家手机时称将会率先采用一款未上市的处理器，而在前两天的发布会上，这款搭载于乐1上的芯片被确认为是隶属于联发科高端智能手机芯片品牌Helio旗下的X10（即MT6795）。</p><p style="text-indent: 2em; text-align: left;">X系列定位于Helio品牌中的顶级性能版，其与Helio品牌都是前不久才发布的，从时间和宣传上，也都算对得起乐视。但相比起来，乐视却结结实实的坑了联发科一把。</p><p style="text-indent: 2em; text-align: left;">联发科的高端梦，又一次毁在了队友手上</p><p style="text-indent: 2em; text-align: left;">在乐视手机发布会上，虽然乐1跑分超过5万分，一举超越了小米、魅族等一众国产与国际品牌旗舰机，同时贾跃亭也口口声声称乐1用的是全球最顶级的MTK处理器，但尴尬的是，乐1却是乐视三款手机当中定位最低的，其售价更是只要1499元，这无疑给观众传达出了最顶级的MTK芯片也只能卖这个价格的感觉。</p><p style="text-indent: 2em; text-align: left;">而这还不够，在介绍到乐1 Pro和乐1 Max时，贾跃亭称二者所搭载的高通骁龙810芯片是世界上最先进的处理器，尽管因为后者的产能问题导致这两款手机当下都无法给出上市时间，也尽管搭载骁龙810的手机在实测中跑分并不如联发科Helio X10，更别说由于工艺和性能问题，骁龙810本身就属于高通的一个过渡性的产品——可在贾跃亭的言语里，还是颇有一种因为用了810而产生的自豪感，这是你在他提及联发科时所听不到的。</p><p style="text-indent: 2em; text-align: left;">这时候，估计联发科心里肯定不好受，自己辛辛苦苦打拼这么多年，就为了能脱下山寨的外衣，可一直没能求得翻身，这也就算了，今年新改了个高大上的马甲（Helio一词取自古希腊太阳神之名Helios），准备重新出发，又拿出了旗下最顶级的芯片给乐视这个备受关注的新厂商，希望能借助贾跃亭口中的“化反”再来一次逆袭，可结果呢？1499不仅把联发科一夜打回解放前，还把这个高端新品牌给再一次牢牢钉在了2000元以下的价位。相比之下，HTC对联发科可算是情深意重了。</p><p style="text-indent: 2em; text-align: left;">为什么联发科一直如此尴尬？</p><p style="text-indent: 2em; text-align: left;">尽管业绩、营收、名气、技术、指标等等都在年年上涨，但联发科始终没有真正的和高通站在统一起跑线上，原因一方面在于联发科的芯片性能上从一开始就存在着一定的弱势，加上其战略上又选择了提供较低的价格，同时又把尽可能多的功能整合在芯片里，为厂商提供一揽子解决方案，导致缺乏开发能力的中小厂商甚至是山寨厂商纷纷簇拥联发科，久而久之，就把联发科的品牌给带Low了。</p><p></p><p style="text-align:center"><img src="data/image/201504/18/66901_rRnF_9284.jpg" alt="联发科 联发科技" border="0" width="600" style="margin: 0px; padding: 0px; border: 1px solid rgb(153, 153, 153); font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle; color: transparent; display: inline-block;"/></p><p style="text-indent: 2em; text-align: left;">虽然经过了这几年，联发科早已经摘掉了山寨的帽子，但低端的印象却不容易被根除，典型的一点就是搭载联发科芯片的手机在价格和市场上始终上不去，去年的魅族MX4虽然引发了轰动，但1799的价格对于联发科来说显然只能说是上了一个阶梯，而算不上是逆袭，更何况MX4发布时，魅族也和其他厂商一样，闭口不提联发科的品牌和型号，只顾说处理器的主频、核心数和跑分，这也明里暗里，让联发科显得更加尴尬了。</p><p style="text-indent: 2em; text-align: left;">总的来说，早期联发科自己的战略，和现下厂商们的不给力，最终导致了联发科的晋升之路走的尤其艰难，而更让人郁闷的是，这一点在未来可能也无法取得多大改观。</p><p style="text-indent: 2em; text-align: left;">高端逆袭依旧长路漫漫</p><p style="text-indent: 2em; text-align: left;">虽然国内智能手机的销量在放缓，但是海外还有大把机会，包括谷歌面向低端市场和小厂商的Android One计划也率先选择了联发科做合作伙伴，这是目前而言对联发科利好的一面。但不利的一面是，以联发科目前的体量，继续挖掘中低端市场肯定会逐渐难以支撑其增长，因此其往高端发展是必由之路，可从上文中看，这一点绝非易事。</p><p style="text-indent: 2em; text-align: left;">而之前在小米印度禁售事件中我们也可以看到，联发科虽然能提供给厂商极富性价比的芯片，却无法给予厂商专利上的保护伞，虽然这一点可能很片面，但多少又一次分化了联发科的吸引力。再者，高通也已经推出了多款定位低端的处理芯片，而在低端市场表现尤其亮眼的Windows Phone更是全部采用了高通处理器。</p><p style="text-indent: 2em; text-align: left;">此外，包括英特尔、展讯、联芯、瑞芯微等也把目光瞄准了低端手机芯片和新兴市场，它们也将率先影响到联发科当下占据主位的中低端市场份额。</p><p style="text-indent: 2em; text-align: left;">而在前景广阔的可穿戴市场，联发科虽然走在比较前列，目前已经推出了支持Android Wear的MT2601以及可用于嵌入式系统的墨水屏产品或类传统手表设备的MT2502，但遗憾的是，它们并没有获得主流手机厂商的青睐，而更多被选用于本土小厂商，甚至是山寨厂商所推出的产品上。而由于穿戴设备行业本身的虚假繁荣，我们可以看到低价产品，甚至是山寨产品往往卖的比品牌产品还要好，这可能进一步推动联发科在穿戴设备领域重走一遍当年功能机时代的老路。</p><p style="text-indent: 2em; text-align: left;">但联发科对此似乎并不关切，至少与它在手机芯片上所表现出来的进取心并不匹配，而可以想见的是，长此以往联发科品牌的含金量还将被进一步压制——也许联发科应该换一种思路，不应该再去追逐难度极高的高端手机市场，而应该在穿戴设备，包括智能家居等新兴市场从头来过，毕竟这可比分离出一个高端品牌的打法要省时省力的多了。</p><p><br style="text-indent: 2em; text-align: left;"/></p>'),
(7, '高官密集调整:10人履新省级副书记 多要职仍缺', 1462505355, '', '　中新网北京5月6日电(记者 阚枫)官方5日发布消息称，苟仲文出任北京市委副书记。今年2月以来，在新一轮的省部级高官人事变动中，已有多省份的省级党委副书记进行人事调整。', 'data/image/201605/06/12639_afYd_5627.jpg', '<p style="text-align:center;margin: 23px auto 0px; padding: 0px; list-style: none; line-height: 30px; font-family: SimSun; color: rgb(43, 43, 43); white-space: normal; overflow: visible !important;"><img src="data/image/201605/06/12620_NqWY_9756.jpg" style="border: none; max-width: 600px; height: auto; overflow: hidden; margin: 30px auto 10px;"/></p><p style="text-align:center;margin: 23px auto 0px; padding: 0px; list-style: none; line-height: 30px; font-family: SimSun; color: rgb(43, 43, 43); white-space: normal; overflow: visible !important;">资料图：苟仲文</p><p style="margin: 23px auto 0px; padding: 0px; list-style: none; line-height: 30px; font-family: SimSun; color: rgb(43, 43, 43); white-space: normal; overflow: visible !important;">　　<strong style="font-size: 14px;">苟仲文履新北京市委副书记</strong></p><p style="margin: 23px auto 0px; padding: 0px; list-style: none; line-height: 30px; font-family: SimSun; color: rgb(43, 43, 43); white-space: normal; overflow: visible !important;">　　5日上午，官方媒体发布消息称，“近日，中共中央批准：苟仲文同志任中共北京市委副书记”。</p><p style="margin: 23px auto 0px; padding: 0px; list-style: none; line-height: 30px; font-family: SimSun; color: rgb(43, 43, 43); white-space: normal; overflow: visible !important;">　　去年11月11日，官方通报，时任北京市委副书记的吕锡文涉嫌严重违纪接受组织调查。数日之后，吕锡文被免职。今年1月，吕锡文被开除党籍和公职。</p><p style="margin: 23px auto 0px; padding: 0px; list-style: none; line-height: 30px; font-family: SimSun; color: rgb(43, 43, 43); white-space: normal; overflow: visible !important;">　　此番，履新北京市委副书记的苟仲文，1957年6月生，甘肃镇原人。今年59岁的苟仲文可谓“学者型官员”。今次调整前，苟仲文任北京市委常委、市委教工委书记、中关村管委会党组书记。</p><p style="margin: 23px auto 0px; padding: 0px; list-style: none; line-height: 30px; font-family: SimSun; color: rgb(43, 43, 43); white-space: normal; overflow: visible !important;">　　根据公开简历，苟仲文拥有管理学博士和研究员级高级工程师的“高知”标签。大学毕业后，苟仲文长期在电子工业领域工作，曾在国家机械电子工业部任职多年，2002年2月起任国家信息产业部副部长。</p><p style="margin: 23px auto 0px; padding: 0px; list-style: none; line-height: 30px; font-family: SimSun; color: rgb(43, 43, 43); white-space: normal; overflow: visible !important;">　　2008年，苟仲文从工业和信息化部副部长任上调入北京，任职北京市副市长，2013年7月，开始任北京市委常委。</p><p style="margin: 23px auto 0px; padding: 0px; list-style: none; line-height: 30px; font-family: SimSun; color: rgb(43, 43, 43); white-space: normal; overflow: visible !important;">　　根据北京市政府主办的“首都之窗”网站显示，此番调整前，苟仲文在北京市委领导班子中排在第八位。</p><p><br/></p>');

-- --------------------------------------------------------

--
-- 表的结构 `tpx_cms_partner`
--

CREATE TABLE IF NOT EXISTS `tpx_cms_partner` (
`id` int(10) unsigned NOT NULL,
  `url` varchar(200) NOT NULL DEFAULT 'http://' COMMENT '网址',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '网站名称',
  `logo` varchar(200) DEFAULT '' COMMENT 'Logo',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '链接位置'
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tpx_cms_partner`
--

INSERT INTO `tpx_cms_partner` (`id`, `url`, `name`, `logo`, `type`) VALUES
(1, 'http://www.tecmz.com', 'TecMZ', 'data/image/', 2),
(2, 'http://dazhihu.com', '大知乎', 'data/image/', 2),
(4, 'http://www.eamonning.com', '清泉逐流', 'data/image/', 2),
(5, 'http://kkdiary.com', '可可日记', 'data/image/', 2),
(6, 'http://www.baidu.com', '百度', 'data/image/201504/18/67127_JDxZ_4687.png', 1),
(7, 'http://www.jd.com', '京东', 'data/image/201504/18/67331_akeC_6911.png', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tpx_cms_product`
--

CREATE TABLE IF NOT EXISTS `tpx_cms_product` (
`id` int(10) unsigned NOT NULL,
  `cat` varchar(200) NOT NULL DEFAULT '0' COMMENT '产品分类',
  `recommend` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '首页推荐',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '产品名称',
  `keywords` varchar(200) DEFAULT '' COMMENT '产品关键词(Keywords)',
  `description` text COMMENT '产品描述(Description)',
  `price` int(10) unsigned DEFAULT '0' COMMENT '产品价格',
  `cover` varchar(200) NOT NULL DEFAULT '' COMMENT '封面',
  `content` text COMMENT '内容'
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- 表的结构 `tpx_cms_product_cat`
--

CREATE TABLE IF NOT EXISTS `tpx_cms_product_cat` (
`id` int(10) unsigned NOT NULL,
  `catname` varchar(50) NOT NULL DEFAULT '必须填写' COMMENT '分类名称',
  `sort` int(10) unsigned NOT NULL DEFAULT '999' COMMENT '显示顺序'
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tpx_cms_product_cat`
--

INSERT INTO `tpx_cms_product_cat` (`id`, `catname`, `sort`) VALUES
(1, '手机', 999),
(2, '笔记本', 999),
(3, '平板电脑', 999);

-- --------------------------------------------------------

--
-- 表的结构 `tpx_cms_single_page`
--

CREATE TABLE IF NOT EXISTS `tpx_cms_single_page` (
`id` int(10) unsigned NOT NULL,
  `url` varchar(200) NOT NULL DEFAULT '' COMMENT '访问URL路径',
  `show_in_nav` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '导航显示',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '页面标题',
  `keywords` varchar(200) DEFAULT '' COMMENT '页面关键词(Keywords)',
  `description` text COMMENT '页面描述(Description)',
  `content` text COMMENT '内容'
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tpx_cms_single_page`
--

INSERT INTO `tpx_cms_single_page` (`id`, `url`, `show_in_nav`, `title`, `keywords`, `description`, `content`) VALUES
(1, 'about', 1, '关于我们', '关于我们', '关于我们', '<p><img src="data/image/201504/18/71949_nMQP_7254.png" title="Screen Shot 2015-04-18 at 03.58.38.png" alt="Screen Shot 2015-04-18 at 03.58.38.png" width="283" height="210" style="width: 283px; height: 210px; float: left;"/></p><p style="text-indent: 2em; text-align: left;">Co.MZ 是一款轻量级企业网站管理系统，基于PHP+Mysql架构的，可运行在Linux、Windows、MacOSX、Solaris等各种平台上，系统基于ThinkPHP，支持自定义伪静态，前台模板采用DIV+CSS设计，后台界面设计简洁明了，功能简单易具有良好的用户体验，稳定性好、扩展性及安全性强，可面向中小型站点提供网站建设解决方案。</p><p style="text-indent: 2em; text-align: left;"><span style="text-indent: 32px;">某某公司</span>是一家面向全球提供IT解决方案与服务的公司，致力于通过创新的信息化技术来推动社会的发展与变革，为个人创造新的生活方式，为社会创造价值。公司创立于1991年，目前拥有20000名员工，在中国建立了8个区域总部，10个软件研发基地， 16个软件开发与技术支持中心，在60多个城市建立营销与服务网络; 在美国、日本、欧洲、中东、南美设有子公司。</p><p style="text-indent: 2em; text-align: left;">某某公司以软件技术为核心，提供行业解决方案和产品工程解决方案以及相关软件产品、平台及服务。</p><p style="text-indent: 2em; text-align: left;">面向行业客户，<span style="text-indent: 32px;">某某公司</span>提供满足行业智慧发展与管理的解决方案、产品及服务，涵盖领域包括：电信、能源、金融、政府、制造业、商贸流通业、医疗卫生、教育与文化、交通、移动互联网、传媒、环保等。<span style="text-indent: 32px;">某某公司</span>在众多行业领域拥有领先的市场占有率，并参与多项中国国家级信息化标准制定。</p><p><br style="text-indent: 2em; text-align: left;"/></p>'),
(2, 'contact', 1, '联系我们', '联系我们', '联系我们', '<p style="text-indent: 2em; text-align: left;">Co.MZ的为您的公司提供最便捷的服务。</p><p style="text-indent: 2em; text-align: left;">客服电话工作时间为周一至周日 8:00-20:00，节假日不休息，免长途话费。</p><p style="text-indent: 2em; text-align: left;">我们将随时为您献上真诚的服务。</p><hr/><p style="white-space: normal; text-indent: 2em; text-align: left;">邮箱：example@163.com</p><p style="white-space: normal; text-indent: 2em; text-align: left;">手机：13100000000</p><p style="white-space: normal; text-indent: 2em; text-align: left;">QQ ：88888888</p><p style="text-align: center;"><img width="530" height="340" src="http://api.map.baidu.com/staticimage?center=121.387616,31.213301&zoom=13&width=530&height=340&markers=121.387616,31.213301"/></p>'),
(3, 'awards', 1, '荣誉资质', '荣誉资质', '荣誉资质', '<p>荣誉资质</p>');

-- --------------------------------------------------------

--
-- 表的结构 `tpx_cms_slide`
--

CREATE TABLE IF NOT EXISTS `tpx_cms_slide` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(200) DEFAULT '' COMMENT '标题',
  `image` varchar(200) NOT NULL DEFAULT '' COMMENT '本地图片',
  `url` varchar(300) NOT NULL DEFAULT '' COMMENT '跳转链接'
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tpx_cms_slide`
--

INSERT INTO `tpx_cms_slide` (`id`, `title`, `image`, `url`) VALUES
(1, '', 'data/image/201604/22/4064_OonZ_9778.png', ''),
(2, '', 'data/image/201604/22/4192_FxDa_6658.png', ''),
(3, '', 'data/image/201504/19/48571_IvJQ_4623.png', ''),
(5, '', 'data/image/201604/22/3383_UaFb_1916.png', '');

-- --------------------------------------------------------

--
-- 表的结构 `tpx_cms_tag_pool`
--

CREATE TABLE IF NOT EXISTS `tpx_cms_tag_pool` (
`id` int(10) unsigned NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `cat` varchar(6) NOT NULL,
  `name` varchar(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tpx_config`
--

CREATE TABLE IF NOT EXISTS `tpx_config` (
  `name` varchar(50) NOT NULL DEFAULT '',
  `val` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tpx_config`
--

INSERT INTO `tpx_config` (`name`, `val`) VALUES
('home_title', 'Co.MZ演示'),
('home_keywords', 'Co.MZ演示,Co.MZ企业系统'),
('home_description', '这是一个Co.MZ演示站点，Co.MZ企业系统。'),
('contact_address', '上海市长宁区某某路XX号 100000'),
('contact_email', 'example@tecmz.com'),
('contact_website', 'http://www.tecmz.com'),
('contact_tel', '021-88888888-0000'),
('contact_detail', '<p style="text-indent: 2em; text-align: left;">Co.MZ的建站咨询电话为 15121021787。</p><p style="text-indent: 2em; text-align: left;">客服电话工作时间为周一至周日 8:00-20:00，节假日不休息，免长途话费。</p><p style="text-indent: 2em; text-align: left;">我们将随时为您献上真诚的服务。</p><p style="text-align: center;"><img width="530" height="340" src="http://api.map.baidu.com/staticimage?center=121.387616,31.213301&zoom=13&width=530&height=340&markers=121.387616,31.213301"/></p>'),
('home_about', '<p><img src="data/image/201504/18/71949_nMQP_7254.png" title="Screen Shot 2015-04-18 at 03.58.38.png" alt="Screen Shot 2015-04-18 at 03.58.38.png" width="283" height="210" style="width: 283px; height: 210px; float: left;"/></p><p style="text-indent: 2em; text-align: left;">Co.MZ 是一款轻量级企业网站管理系统，基于PHP+Mysql架构的，可运行在Linux、Windows、MacOSX、Solaris等各种平台上，系统基于ThinkPHP，支持自定义伪静态，前台模板采用DIV+CSS设计，后台界面设计简洁明了，功能简单易具有良好的用户体验，稳定性好、扩展性及安全性强，可面向中小型站点提供网站建设解决方案。</p><p style="text-indent: 2em; text-align: left;"><span style="text-indent: 32px;">某某公司</span>是一家面向全球提供IT解决方案与服务的公司，致力于通过创新的信息化技术来推动社会的发展与变革，为个人创造新的生活方式，为社会创造价值。公司创立于1991年，目前拥有20000名员工，在中国建立了8个区域总部，10个软件研发基地， 16个软件开发与技术支持中心，在60多个城市建立营销与服务网络; 在美国、日本、欧洲、中东、南美设有子公司。</p><p style="text-indent: 2em; text-align: left;">某某公司以软件技术为核心，提供行业解决方案和产品工程解决方案以及相关软件产品、平台及服务。</p><p style="text-indent: 2em; text-align: left;">面向行业客户，<span style="text-indent: 32px;">某某公司</span>提供满足行业智慧发展与管理的解决方案、产品及服务，涵盖领域包括：电信、能源、金融、政府、制造业、商贸流通业、医疗卫生、教育与文化、交通、移动互联网、传媒、环保等。<span style="text-indent: 32px;">某某公司</span>在众多行业领域拥有领先的市场占有率，并参与多项中国国家级信息化标准制定。</p><p><br style="text-indent: 2em; text-align: left;"/></p>'),
('theme_color', 'orange'),
('image_logo', 'asserts/res/image/logo.png'),
('image_qr', 'asserts/res/image/qr.jpg'),
('contact_qq', '917673489');

-- --------------------------------------------------------

--
-- 表的结构 `tpx_data_files`
--

CREATE TABLE IF NOT EXISTS `tpx_data_files` (
`id` bigint(20) unsigned NOT NULL,
  `uptime` int(10) unsigned NOT NULL DEFAULT '0',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `dir` char(6) NOT NULL,
  `path` char(40) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tpx_data_files`
--

INSERT INTO `tpx_data_files` (`id`, `uptime`, `filesize`, `dir`, `path`) VALUES
(1, 1429287563, 0, 'image', '201504/18/58763_lPCY_1069.jpg'),
(2, 1429292008, 0, 'image', '201504/18/63208_nvLT_7733.jpg'),
(8, 1429294999, 0, 'image', '201504/18/66199_Lljz_9332.jpg'),
(51, 1429450171, 0, 'image', '201504/19/48571_IvJQ_4623.png'),
(55, 1461286583, 289105, 'image', '201604/22/3383_UaFb_1916.png'),
(40, 1429302703, 0, 'image', '201504/18/73903_uise_3350.png'),
(9, 1429295294, 0, 'image', '201504/18/66494_ZHIk_5322.jpg'),
(10, 1429295525, 0, 'image', '201504/18/66725_YkgS_4582.jpg'),
(11, 1429295583, 0, 'image', '201504/18/66783_pkFb_1297.jpg'),
(12, 1429295663, 0, 'image', '201504/18/66863_TlwV_3898.jpg'),
(13, 1429295701, 0, 'image', '201504/18/66901_JakO_5621.jpg'),
(14, 1429295701, 0, 'image', '201504/18/66901_rRnF_9284.jpg'),
(15, 1429295732, 0, 'image', '201504/18/66932_NCau_2769.jpg'),
(16, 1429295761, 0, 'image', '201504/18/66961_GoUn_4239.jpg'),
(56, 1461287264, 149483, 'image', '201604/22/4064_OonZ_9778.png'),
(18, 1429295927, 0, 'image', '201504/18/67127_JDxZ_4687.png'),
(19, 1429296131, 0, 'image', '201504/18/67331_akeC_6911.png'),
(39, 1429302620, 0, 'image', '201504/18/73820_EFmd_8714.png'),
(38, 1429302559, 0, 'image', '201504/18/73759_mDJd_9908.png'),
(37, 1429302530, 0, 'image', '201504/18/73730_iHRe_5330.png'),
(36, 1429302499, 0, 'image', '201504/18/73699_CnaL_1332.png'),
(35, 1429302426, 0, 'image', '201504/18/73626_Mdzg_6386.png'),
(34, 1429302426, 0, 'image', '201504/18/73626_kMmd_8906.png'),
(33, 1429300749, 0, 'image', '201504/18/71949_nMQP_7254.png'),
(27, 1429296247, 0, 'image', '201504/18/67447_Xxhn_9726.png'),
(28, 1429296460, 0, 'image', '201504/18/67660_PlHk_3667.png'),
(29, 1429296540, 0, 'image', '201504/18/67740_XJbt_7173.png'),
(30, 1429296702, 0, 'image', '201504/18/67902_iEQW_4278.png'),
(31, 1429296803, 0, 'image', '201504/18/68003_mzAM_7323.png'),
(32, 1429296894, 0, 'image', '201504/18/68094_Mlzb_7150.png'),
(41, 1429302768, 0, 'image', '201504/18/73968_dIYb_1520.png'),
(42, 1429302768, 0, 'image', '201504/18/73968_xoEC_7550.png'),
(58, 1462505420, 23110, 'image', '201605/06/12620_NqWY_9756.jpg'),
(57, 1461287392, 204385, 'image', '201604/22/4192_FxDa_6658.png'),
(59, 1462505439, 6782, 'image', '201605/06/12639_afYd_5627.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tpx_admin_access`
--
ALTER TABLE `tpx_admin_access`
 ADD KEY `groupId` (`role_id`), ADD KEY `nodeId` (`node_id`);

--
-- Indexes for table `tpx_admin_node`
--
ALTER TABLE `tpx_admin_node`
 ADD PRIMARY KEY (`id`), ADD KEY `level` (`level`), ADD KEY `pid` (`pid`), ADD KEY `status` (`status`), ADD KEY `name` (`name`);

--
-- Indexes for table `tpx_admin_role`
--
ALTER TABLE `tpx_admin_role`
 ADD PRIMARY KEY (`id`), ADD KEY `pid` (`pid`), ADD KEY `status` (`status`);

--
-- Indexes for table `tpx_admin_role_user`
--
ALTER TABLE `tpx_admin_role_user`
 ADD KEY `group_id` (`role_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tpx_admin_user`
--
ALTER TABLE `tpx_admin_user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD KEY `status` (`status`);

--
-- Indexes for table `tpx_cms_news`
--
ALTER TABLE `tpx_cms_news`
 ADD PRIMARY KEY (`id`), ADD KEY `title` (`title`), ADD KEY `posttime` (`posttime`), ADD KEY `keywords` (`keywords`);

--
-- Indexes for table `tpx_cms_partner`
--
ALTER TABLE `tpx_cms_partner`
 ADD PRIMARY KEY (`id`), ADD KEY `type` (`type`);

--
-- Indexes for table `tpx_cms_product`
--
ALTER TABLE `tpx_cms_product`
 ADD PRIMARY KEY (`id`), ADD KEY `cat` (`cat`), ADD KEY `recommend` (`recommend`), ADD KEY `title` (`title`), ADD KEY `keywords` (`keywords`), ADD KEY `price` (`price`);

--
-- Indexes for table `tpx_cms_product_cat`
--
ALTER TABLE `tpx_cms_product_cat`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `catname` (`catname`), ADD KEY `sort` (`sort`);

--
-- Indexes for table `tpx_cms_single_page`
--
ALTER TABLE `tpx_cms_single_page`
 ADD PRIMARY KEY (`id`), ADD KEY `url` (`url`), ADD KEY `title` (`title`), ADD KEY `keywords` (`keywords`);

--
-- Indexes for table `tpx_cms_slide`
--
ALTER TABLE `tpx_cms_slide`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tpx_cms_tag_pool`
--
ALTER TABLE `tpx_cms_tag_pool`
 ADD PRIMARY KEY (`id`), ADD KEY `addtime` (`addtime`), ADD KEY `updatetime` (`updatetime`), ADD KEY `cat` (`cat`), ADD KEY `name` (`name`);

--
-- Indexes for table `tpx_config`
--
ALTER TABLE `tpx_config`
 ADD KEY `name` (`name`);

--
-- Indexes for table `tpx_data_files`
--
ALTER TABLE `tpx_data_files`
 ADD PRIMARY KEY (`id`), ADD KEY `uptime` (`uptime`), ADD KEY `dir` (`dir`), ADD KEY `path` (`path`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tpx_admin_node`
--
ALTER TABLE `tpx_admin_node`
MODIFY `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `tpx_admin_role`
--
ALTER TABLE `tpx_admin_role`
MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tpx_admin_user`
--
ALTER TABLE `tpx_admin_user`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tpx_cms_news`
--
ALTER TABLE `tpx_cms_news`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tpx_cms_partner`
--
ALTER TABLE `tpx_cms_partner`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tpx_cms_product`
--
ALTER TABLE `tpx_cms_product`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tpx_cms_product_cat`
--
ALTER TABLE `tpx_cms_product_cat`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tpx_cms_single_page`
--
ALTER TABLE `tpx_cms_single_page`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tpx_cms_slide`
--
ALTER TABLE `tpx_cms_slide`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tpx_cms_tag_pool`
--
ALTER TABLE `tpx_cms_tag_pool`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tpx_data_files`
--
ALTER TABLE `tpx_data_files`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=60;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



CREATE TABLE IF NOT EXISTS `tpx_cms_articles` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '文章标题',
  `posttime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `keywords` varchar(200) DEFAULT '' COMMENT '文章关键词(Keywords)',
  `description` text COMMENT '文章描述(Description)',
  `cover` varchar(200) NOT NULL DEFAULT '' COMMENT '封面',
  `content` text COMMENT '内容'
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

ALTER TABLE `tpx_cms_articles`
 ADD PRIMARY KEY (`id`), ADD KEY `title` (`title`), ADD KEY `posttime` (`posttime`), ADD KEY `keywords` (`keywords`);

 ALTER TABLE `tpx_cms_articles`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;



CREATE TABLE IF NOT EXISTS `tpx_cms_album` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(250)  NOT NULL DEFAULT '' COMMENT '相册标题(title)',
  `description` text COMMENT '相册描述(Description)',
  `cover` varchar(200) NOT NULL DEFAULT '' COMMENT '相册封面',
  `created_time` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `tpx_cms_album`
 ADD PRIMARY KEY (`id`),  ADD KEY `created_time` (`created_time`);

 ALTER TABLE `tpx_cms_album`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;


CREATE TABLE IF NOT EXISTS `tpx_cms_photo` (
`id` int(10) unsigned NOT NULL,
  `path` varchar(200) NOT NULL DEFAULT '' COMMENT '相册封面',
  `uptime` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `tpx_cms_photo`
 ADD PRIMARY KEY (`id`),  ADD KEY `uptime` (`uptime`);

 ALTER TABLE `tpx_cms_photo`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;

ALTER TABLE `tpx_cms_photo` ADD `aid` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '相册id' ;