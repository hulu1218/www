﻿ ----------------------------------------
|     DedeCMS 产品使用说明               |
 ----------------------------------------

一、平台需求
1.Windows 平台：
IIS/Apache/Nginx + PHP4/PHP5.2+/PHP5.3+ + MySQL4/5
如果在windows环境中使用，建议用DedeCMS提供的DedeAMPZ套件以达到最佳使用性能。

2.Linux/Unix 平台
Apache + PHP4/PHP5 + MySQL3/4/5 (PHP必须在非安全模式下运行)

建议使用平台：Linux + Apache2.2 + PHP5.2/PHP5.3 + MySQL5.0

3.PHP必须环境或启用的系统函数：
allow_url_fopen
GD扩展库
MySQL扩展库
系统函数 —— phpinfo、dir

4.基本目录结构
/
..../install     安装程序目录，安装完后可删除[安装时必须有可写入权限]
..../dede        默认后台管理目录（可任意改名）
..../include     类库文件目录
..../plus        附助程序目录
..../member      会员目录
..../images      系统默认模板图片存放目录
..../uploads     默认上传目录[必须可写入]
..../a        默认HTML文件存放目录[必须可写入]
..../templets    系统默认内核模板目录
..../data        系统缓存或其它可写入数据存放目录[必须可写入]
..../special     专题目录[生成一次专题后可以删除special/index.php，必须可写入]

5.PHP环境容易碰到的不兼容性问题
  (1)data目录没写入权限，导致系统session无法使用，这将导致无法登录管理后台（直接表现为验证码不能正常显示）；
  (2)php的上传的临时文件夹没设置好或没写入权限，这会导致文件上传的功能无法使用；
  (3)出现莫名的错误，如安装时显示空白，这样能是由于系统没装载mysql扩展导致的，对于初级用户，可以下载dede的php套件包，以方便简单的使用。

二、程序安装使用
1.下载程序解压到本地目录;
2.上传程序目录中的/uploads到网站根目录
3.运行http://www.yourname.com/install/index.php(yourname表示你的域名),按照安装提速说明进行程序安装
 
三、相关资源
DedeCMS官方主站       www.dedecms.com
织梦维基              docs.dedecms.com
客服中心              service.dedecms.com
技术支持论坛          bbs.dedecms.com
上海卓卓网络科技      www.desdev.cn