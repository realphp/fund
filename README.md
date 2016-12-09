# Co.MZ 企业系统

- 轻量级企业网站管理系统

- 运行环境:PHP5.3+, MySQL5.0

##系统预览

- 系统下载：[http://www.tecmz.com](http://www.tecmz.com)

- 预览地址：[http://co.tecmz.com](http://co.tecmz.com)



##各种设备自适应

- 响应式的网站设计能够对用户产生友好度，并且对于不同的分辨率能够灵活的进行操作应用。 简洁通俗表达就是页面宽度可以自适应屏幕大小，一个网站PC、手机、PAD通吃，页面地址一致。

- 一个字“酷“，可以用PC浏览器拉动窗口大小，网站内容显示依旧在设计之内，用户体验非常不错。 一个字“省”，一个网站PC、手机、PAD通吃，这样就不用花那么多心思去维护多个网站，无论是制作还是数据内容。


##基于HTML5技术

- HTML5对于用户来说，提高了用户体验，加强了视觉感受。HTML5技术在移动端，能够让应用程序回归到网页，并对网页的功能进行扩展，操作更加简单，用户体验更好。 

- HTML5技术跨平台，适配多终端。对于搜索引擎来说，HTML5新增的标签，使搜索引擎更加容易抓取和索引网页，从而驱动网站获得更多的点击流量。


##人性化的后台管理

- 传统的企业网站管理系统是以技术人员的角度出发，设计了很多复杂的功能，并且操作流程上也很复杂，对于最终要操控这个系统的管理员来说并不是很人性化，Co.MZ所做的只是简化不必要的功能，从操作习惯下合理地布局和设计界面，让最普通的用户，即使没有网站管理的经营，也能很容易上手我们的系统。


##伪静态代码

具体使用时，需要根据系统的路径进行设置。

###Apache环境中的.htaccess文件

	RewriteEngine On
	RewriteBase /
	RewriteRule ^/?$ - [NC,L]
	RewriteRule ^(app/|data/|asserts/|res/|_RUN/|robots\.txt|crossdomain\.xml).*$ - [NC,L]
	RewriteRule ^([a-z0-9]+)\.php - [NC,L]
	RewriteRule ^(.*)$ index.php/$1  [NC,L] 

###Nginx环境
	location / {
    	index index.php;
    	if ( !-e $request_filename ) {
            rewrite ^(.*)$ /index.php?s=$1 last;
            break;
        }
    }

    location ~ \.php$ {
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  PHP_VALUE  "open_basedir=$document_root:/tmp/";
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~* ^/(app|data|asserts|robots\.txt|crossdomain\.xml)/.*$ {
        if ( -f $request_filename ) {
            expires max;
            break;
        }
    }

# 许可协议

Co.MZ企业系统遵循Apache2开源协议发布。Apache Licence是著名的非盈利开源组织Apache采用的协议。该协议和BSD类似，鼓励代码共享和尊重原作者的著作权，同样允许代码修改，再作为开源或商业软件发布。需要满足的条件:

1. 需要给代码的用户一份Apache Licence ；
2. 如果你修改了代码，需要在被修改的文件中说明；
3. 在延伸的代码中（修改和有源代码衍生的代码中）需要带有原来代码中的协议，商标，专利声明和其他原来作者规定需要包含的说明；
4. 如果再发布的产品中包含一个Notice文件，则在Notice文件中需要带有Apache Licence。你可以在Notice中增加自己的许可，但不可以表现为对Apache Licence构成更改。

具体的协议参考：[http://www.apache.org/licenses/LICENSE-2.0](http://www.apache.org/licenses/LICENSE-2.0)。