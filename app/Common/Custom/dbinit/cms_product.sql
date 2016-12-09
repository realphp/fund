DROP TABLE IF EXISTS <--db-prefix-->cms_product;
CREATE TABLE `<--db-prefix-->cms_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat` varchar(200) NOT NULL DEFAULT '0' COMMENT '产品分类',
  `recommend` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '首页推荐',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '产品名称',
  `keywords` varchar(200) DEFAULT '' COMMENT '产品关键词(Keywords)',
  `description` text COMMENT '产品描述(Description)',
  `price` int(10) unsigned DEFAULT '0' COMMENT '产品价格',
  `cover` varchar(200) NOT NULL DEFAULT '' COMMENT '封面',
  `content` text COMMENT '内容',
  PRIMARY KEY (`id`),
  KEY `cat` (`cat`),
  KEY `recommend` (`recommend`),
  KEY `title` (`title`),
  KEY `keywords` (`keywords`),
  KEY `price` (`price`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
INSERT INTO `<--db-prefix-->cms_product` VALUES 
('1','1','1','苹果iPhone 6(16GB)','苹果iPhone 6(16GB)','苹果iPhone 6(16GB)','6000','data/image/201504/18/66199_Lljz_9332.jpg','<p style=\"text-indent: 2em; text-align: left;\">iPhone 6采用4.7英寸屏幕，分辨率为1334*750像素，内置64位构架的苹果A8处理器，性能提升非常明显；同时还搭配全新的M8协处理器，专为健康应用所设计；采用后置800万像素镜头，前置120万像素 鞠昀摄影FaceTime HD 高清摄像头；并且加入Touch ID支持指纹识别，首次新增NFC功能；也是一款三网通手机，4G LTE连接速度可达150Mbps，支持多达20个LTE频段。</p><p style=\"text-indent: 2em; text-align: left;\">北京时间2014年9月10日凌晨1点，苹果公司在加州库比蒂诺德安萨学院的弗林特艺术中心正式发布其新一代产品 iPhone 6。9月12日开启预定，9月19日上市。首批上市的国家和地区包括美国、加拿大、法国、德国、英国、中国香港、日本、新加坡和澳大利亚，中国大陆无缘iPhone 6首发。</p><p style=\"text-indent: 2em; text-align: left;\">2014年10月10日零时，苹果中国在线商店正式开启iPhone 6/6 Plus预售，iPhone 6售价5288元起，iPhone 6 Plus售6088元起，每名用户可分别最多购买2台，到货日期10月17日，同时三大运营商也同步发售。</p><p style=\"text-indent: 2em; text-align: left;\"><br/></p>'),
('2','1','1','三星GALAXY S6','三星GALAXY S6','三星GALAXY S6','5288','data/image/201504/18/66494_ZHIk_5322.jpg','<p style=\"text-indent: 2em; text-align: left;\">北京时间2015年3月2日（巴萨罗那时间2015年3月1日），三星在巴萨罗那发布三星galaxy s6，亮相MWC2015产品发布会。GALAXY S6前后均由玻璃覆盖，机身侧面具备弧度的金属边框。搭载Exynos 7420八核64位处理器，为14纳米制程，3GB的运行内存升级至LPDDR4，整体配置也当属顶级。猎豹宣布与三星达成合作，这部旗舰机中将内置猎豹清理大师提供的清理功能。首次在系统层面搭载了电话邦提供的可视化IVR语音菜单等服务。</p>'),
('3','2','1','联想（Lenovo）G50-70MA','联想（Lenovo）G50-70MA','联想（Lenovo）G50-70MA','3500','data/image/201504/18/67447_Xxhn_9726.png','<p style=\"text-indent: 2em; text-align: left;\">全新G40&amp;50系列全面支持Windows 8.1 中文版（仅限部分机型，具体请参考产品配置！），秉承了坚实耐用、稳定可靠的产品指纹，令笔记本更加安全可靠。&nbsp;</p><p style=\"text-indent: 2em; text-align: left;\">搭载独立显卡在游戏和多媒体方面较上一代显卡最高可实现&nbsp;</p><p style=\"text-indent: 2em; text-align: left;\">两倍性能提升，提供更加强大的笔记本体验。 杜比环绕立体声音效，轻松拥有影院级高品质享受； 更可以通过HDMI接&nbsp;</p><p style=\"text-indent: 2em; text-align: left;\">口连接高清电视， 实现坐拥私家高清影院的梦想！</p><p style=\"text-indent: 2em; text-align: left;\">联想全能G40&amp;50 坚实耐用 稳定可靠 杜比环绕 HDMI接口高清电视 私家高清影院</p><p style=\"text-indent: 2em; text-align: left;\">Windows 8.1 操作系统（限部分机型标配），紧跟潮流</p><p style=\"text-indent: 2em; text-align: left;\">CPU全面升级，搭载第四代智能英特尔Hasewell平台ULT CPU，&amp; AMD: 高：Kaveri 低Beema双平台齐备，极致性能一本无 忧</p><p style=\"text-indent: 2em; text-align: left;\">显卡换代，火爆升级：NVIDIA Geforce 820M 2G DDR3独立显存，为客户带来酣畅使用体验</p><p style=\"text-indent: 2em; text-align: left;\">内存 &amp; 硬盘 ：最高至16GB DDR3 1600MHz高速内&nbsp;</p><p style=\"text-indent: 2em; text-align: left;\">存 &amp; 1TB硬盘</p><p style=\"text-indent: 2em; text-align: left;\">丰富接口：HDMI/USB3.0/VGA/读卡器，主流接口一应俱全</p><p style=\"text-indent: 2em; text-align: left;\">联想全能G40&amp;50 Windows 8.1 英特尔Hasewell平台四核cpu AMD R5230 HDMI/VGA</p><p style=\"text-indent: 2em; text-align: left;\">15.6” HD LED高清宽屏，分辨率HD 1366x768</p><p style=\"text-indent: 2em; text-align: left;\">杜比认证音效，全新smart audio声音系统，打游戏看电影时可以&nbsp;</p><p style=\"text-indent: 2em; text-align: left;\">启动宽频音域(Phantom音效)、虚拟环绕立体声(3D Immersion)，&nbsp;</p><p style=\"text-indent: 2em; text-align: left;\">享受震撼 效果</p><p style=\"text-indent: 2em; text-align: left;\">720p高感光摄像头为用户在任何光照条件下，清楚完成视频聊天。</p><p style=\"text-indent: 2em; text-align: left;\">超快的 USB3.0 传输接口，给您带来十倍于 USB2.0的传输速率，&nbsp;</p><p style=\"text-indent: 2em; text-align: left;\">极速的数据分享，传输及备份，带来前所未有的使用体验。</p><p style=\"text-indent: 2em; text-align: left;\">高触感“巧克力键盘”，极佳的键盘弹性&nbsp;</p><p style=\"text-indent: 2em; text-align: left;\">和键间距设计为国际先进水平，不仅输入速度快而且更加舒适。&nbsp;</p><p style=\"text-indent: 2em; text-align: left;\">键盘下双 层金属板支撑，不仅坚固耐压更能提供屏蔽&nbsp;</p><p style=\"text-indent: 2em; text-align: left;\">辐射的健康保护。</p><p style=\"text-indent: 2em; text-align: left;\">联想全能G40&amp;50 HD LED高清宽屏 smart audio 720p高感光摄像头 USB3.0 巧克力键盘</p><p style=\"text-indent: 2em; text-align: left;\">全新Journal外观设计</p><p style=\"text-indent: 2em; text-align: left;\">导入24.8mm超薄外观</p><p style=\"text-indent: 2em; text-align: left;\">A/D面细纹理印花</p><p style=\"text-indent: 2em; text-align: left;\">C面超质感金属、拉丝、磨砂可选</p><p style=\"text-indent: 2em; text-align: left;\">联想全能G40&amp;50 Journal外观 24.8mm超薄 A/D面细纹理印花 C面超质感金属、拉丝、磨砂选择</p><p><br style=\"text-indent: 2em; text-align: left;\"/></p>'),
('4','2','1','戴尔（DELL）Ins14L-2528B','戴尔（DELL）Ins14L-2528B','戴尔（DELL）Ins14L-2528B','4500','data/image/201504/18/67660_PlHk_3667.png','<p style=\"text-indent: 2em; text-align: left;\">主体</p><p style=\"text-indent: 2em; text-align: left;\">品牌戴尔（DELL）</p><p style=\"text-indent: 2em; text-align: left;\">平台Intel</p><p style=\"text-indent: 2em; text-align: left;\">型号Ins14LR-2528B</p><p style=\"text-indent: 2em; text-align: left;\">颜色范围黑</p><p style=\"text-indent: 2em; text-align: left;\">操作系统win8</p><p style=\"text-indent: 2em; text-align: left;\">产品定位商务便携</p><p style=\"text-indent: 2em; text-align: left;\">外形尺寸宽：13.5英寸（342毫米） 高：0.88英寸（22.4毫米）/深：9.7英寸（246毫米）</p><p style=\"text-indent: 2em; text-align: left;\">厚度规格便携轻薄</p><p style=\"text-indent: 2em; text-align: left;\">重量净重 1.9kg</p><p style=\"text-indent: 2em; text-align: left;\">处理器</p><p style=\"text-indent: 2em; text-align: left;\">处理器描述inteli5</p><p style=\"text-indent: 2em; text-align: left;\">处理器系列第5代智能英特尔酷睿处理器</p><p style=\"text-indent: 2em; text-align: left;\">CPU型号 i5-5200U</p><p style=\"text-indent: 2em; text-align: left;\">CPU主频2.2 GHz</p><p style=\"text-indent: 2em; text-align: left;\">三级缓存3M</p><p style=\"text-indent: 2em; text-align: left;\">核心数双核</p><p style=\"text-indent: 2em; text-align: left;\">内存</p><p style=\"text-indent: 2em; text-align: left;\">内存容量4G</p><p style=\"text-indent: 2em; text-align: left;\">内存类型DDR3L 1600Mhz</p><p style=\"text-indent: 2em; text-align: left;\">硬盘</p><p style=\"text-indent: 2em; text-align: left;\">硬盘规格500G-1T(无SSD)</p><p style=\"text-indent: 2em; text-align: left;\">硬盘容量500GB</p><p style=\"text-indent: 2em; text-align: left;\">接口类型SATA 串行</p><p style=\"text-indent: 2em; text-align: left;\">硬盘转速5400转/分钟</p><p style=\"text-indent: 2em; text-align: left;\">显卡</p><p style=\"text-indent: 2em; text-align: left;\">显卡类型独立显卡</p><p style=\"text-indent: 2em; text-align: left;\">显卡定位性能级独显</p><p style=\"text-indent: 2em; text-align: left;\">显卡芯片AMD Radeon HD R5 M240</p><p style=\"text-indent: 2em; text-align: left;\">显存容量独立2GB</p><p style=\"text-indent: 2em; text-align: left;\">屏幕</p><p style=\"text-indent: 2em; text-align: left;\">显示屏类型非触摸</p><p style=\"text-indent: 2em; text-align: left;\">屏幕规格14英寸</p><p style=\"text-indent: 2em; text-align: left;\">屏幕尺寸14.0英寸</p><p style=\"text-indent: 2em; text-align: left;\">屏幕比例宽屏16：9</p><p style=\"text-indent: 2em; text-align: left;\">屏幕分辨率1366 x 768</p><p style=\"text-indent: 2em; text-align: left;\">背光技术LED背光</p><p style=\"text-indent: 2em; text-align: left;\">光驱</p><p style=\"text-indent: 2em; text-align: left;\">光驱类型无</p><p style=\"text-indent: 2em; text-align: left;\">音频</p><p style=\"text-indent: 2em; text-align: left;\">扬声器立体声扬声器，支持Waves MaxxAudio 4处理技术 内置数字麦克风</p><p style=\"text-indent: 2em; text-align: left;\">麦克风有</p><p style=\"text-indent: 2em; text-align: left;\">通信</p><p style=\"text-indent: 2em; text-align: left;\">无线局域网英特尔双频无线-AC 3160 802.11ac, 1X1, 2.4&amp;5GHz</p><p style=\"text-indent: 2em; text-align: left;\">局域网描述集成以太网10/100</p><p style=\"text-indent: 2em; text-align: left;\">蓝牙蓝牙4.0</p><p style=\"text-indent: 2em; text-align: left;\">端口</p><p style=\"text-indent: 2em; text-align: left;\">摄像头HD 720p 网络摄像头与阵列麦克风</p><p style=\"text-indent: 2em; text-align: left;\">数据接口2个USB 3.0端口+1 个USB2.0</p><p style=\"text-indent: 2em; text-align: left;\">视频接口HDMI</p><p style=\"text-indent: 2em; text-align: left;\">音频接口组合耳机/麦克风插孔</p><p style=\"text-indent: 2em; text-align: left;\">其他接口RJ45</p><p style=\"text-indent: 2em; text-align: left;\">读卡器5 合 1 卡读卡器</p><p style=\"text-indent: 2em; text-align: left;\">输入设备</p><p style=\"text-indent: 2em; text-align: left;\">指取设备英文键盘</p><p style=\"text-indent: 2em; text-align: left;\">键盘描述触摸板</p><p style=\"text-indent: 2em; text-align: left;\">电池/电源</p><p style=\"text-indent: 2em; text-align: left;\">电池类型3芯锂离子电池 (43瓦时) 电池</p><p style=\"text-indent: 2em; text-align: left;\">续航时间2-3小时, 具体时间视使用环境而定</p><p style=\"text-indent: 2em; text-align: left;\">电源适配器65W 交流电适配器</p><p><br style=\"text-indent: 2em; text-align: left;\"/></p>'),
('5','3','1','小米（MI）7.9英寸平板','小米（MI）7.9英寸平板','小米（MI）7.9英寸平板','2000','data/image/201504/18/67740_XJbt_7173.png','<p style=\"text-indent: 2em; text-align: left;\">从小米这个品牌诞生开始，已经被无数人吐槽的饥饿营销到了第四个年头还是依然没有停止，即使现在的小米已经基本摆脱了生产线可以完全可以满足量产的需求，甚至是小米任何产品的供货早已经没有什么问题，依然有不少人在吐槽，似乎这没有意义的吐槽，已经成了家常便饭。</p><p><br style=\"padding: 0px; margin: 0px; text-indent: 2em; text-align: left;\"/></p><p style=\"text-indent: 2em; text-align: left;\">在Geek今天介绍的小米平板里体现的也极为明显，其实这款产品顶多也只是名义上的饥饿营销，事实上都能买得到的情况下，饥饿营销的刻板印象还是停留在人们的脑海里，Geek只能说，雷布斯真的赢了。</p><p><br style=\"padding: 0px; margin: 0px; text-indent: 2em; text-align: left;\"/></p><p style=\"text-indent: 2em; text-align: left;\">小米平板没什么好多介绍的了，易迅网目前售价1488元包邮，比官方稍微便宜点。至于饥饿营销这一说，个人觉得已经完全没什么意义了。</p><p><br style=\"text-indent: 2em; text-align: left;\"/></p>'),
('6','3','1','华为MediaPad','华为MediaPad','华为MediaPad','5500','data/image/201504/18/67902_iEQW_4278.png','<p style=\"text-indent: 2em; text-align: left;\">华为公司的最新平板电脑“MediaPad”即将面世，该平板可能将成为华为IDEOS系列产品线的一部分，而华为公司选择在2011年的亚洲通讯展（CommunicAsia 2011）上来进行发布。据了解，2011年亚洲通讯展将于6月21日-24日在新加坡举行。国内将在10月份上市。</p><p style=\"text-indent: 2em; text-align: left;\">关于MediaPad，可实现“云通话”的双核高清平板，全球首款Android 3.2(Honeycomb) 7寸旗舰平板电脑。华为公司称MediaPad是该公司至今为止“最智能、最小、最轻便的平板电脑”，并表示他们认为这款平板“一定能够改变消费者的娱乐体验”。</p><p><br style=\"text-indent: 2em; text-align: left;\"/></p><p style=\"text-indent: 2em; text-align: left;\">全球最新蜂巢操作系统</p><p style=\"text-indent: 2em; text-align: left;\">拥有应用兼容性缩放、SD卡媒体同全新特性配合Mediapad集结的顶尖硬件配置，为消费者提供全新的平板电脑操作体验。</p><p style=\"text-indent: 2em; text-align: left;\">最清晰的平板显示屏幕</p><p style=\"text-indent: 2em; text-align: left;\">7英寸IPS屏幕，分辨率1280*800，像素密度达到业界最高的217ppi（高于IPAD2）， 拥有全球最清晰的平板电脑显示效果。</p><p style=\"text-indent: 2em; text-align: left;\">最急速双核CPU完美整合</p><p style=\"text-indent: 2em; text-align: left;\">业界最快的1.2GHZ双核处理器，14.4Mbps HSPA+;802.11n高速无线网络。</p><p style=\"text-indent: 2em; text-align: left;\">时尚轻巧的外观设计</p><p style=\"text-indent: 2em; text-align: left;\">10.5毫米厚度，仅重390克，口袋平板，unibody工艺设计，一体化全铝合金机身。面板上无任何物理按键“简单”到极致，背面采用沙漏型图案设计。</p><p style=\"text-indent: 2em; text-align: left;\">2外观简介</p><p><br style=\"text-indent: 2em; text-align: left;\"/></p><p style=\"text-indent: 2em; text-align: left;\">根据公布的MediaPad图片我们可以看到，这款平板电脑不设任何按钮装置，拥有一个非常清晰的正面布局。媒体猜测，MediaPad或将运行Android蜂巢操作系统。同时，该平板看起来大小约为7英寸（或者5英<span style=\"text-indent: 2em;\">寸）。</span></p><p style=\"text-indent: 2em; text-align: left;\">关于该平板是一款全新的产品或只是华为先前平板电脑S7 tablet的加强版尚未有结论，但媒体认为前者的可能性会更大。</p><p><br style=\"text-indent: 2em; text-align: left;\"/></p>'),
('7','3','1','台电（Teclast）X98','台电（Teclast）X98','台电（Teclast）X98','4444','data/image/201504/18/68003_mzAM_7323.png','<p style=\"text-indent: 2em; text-align: left;\">台电X98 Air 3G 搭载英特尔Bay Trail-T Z3736F处理器（X86架构），主频高达2.16GHz，并且装配了2GB DDR3L内存与32GB eMMC内置储存，通话方面支持3G的一切功能。X98 Air 3G 在继承9.7英寸IPS屏幕的同时把屏幕边框缩小至9.5mm，分辨率为2048*1536（4:3）。后置500万像素摄像头，前置200万像素。此外台电X98 Air 3G可以运行Android 4.4与Windows8.1系统，可以实现安卓系统下的通话与3G上网，同时也保证Win8系统下强大的硬件功能。</p>'),
('8','3','1','Apple iPad Air','Apple iPad Air','Apple iPad Air','4444','data/image/201504/18/68094_Mlzb_7150.png','<p style=\"text-indent: 2em; text-align: left;\">苹果&nbsp;iPad&nbsp;Air&nbsp;2使用iOS8系统，为您带来一系列全新功能。由于其专为iPad度身设计，因此一切不仅看起来赏心悦目，运行起来也同样出色。苹果&nbsp;iPad&nbsp;Air&nbsp;2内置一系列出色的app可用来发送电子邮件、浏览网页和进行视频通话。另有多款app让你可使用你的照片、影片、音乐、文档、演示文稿和电子表格来创造更多精彩。</p>');