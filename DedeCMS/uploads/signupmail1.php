<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>注册新浪通行证</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/vconf.js"></script>
<script type="text/javascript" src="js/validator.js"></script>

</head>

<body>

<div id="wrap">
  <div class="head">
    <div class="logo"></div>
	<div class="logotxt">- 注册</div>
	<div class="headlink"><a href="http://www.sina.com.cn">新浪首页</a> | <a href="/help.html">帮助</a></div>
	<div class="clearit"></div>
  </div>

  <div class="main">
  <form method="post" id="reg_new.php name="vForm">
  <input type="hidden" id="act" name="act" value=1>
  <input type="hidden" id="entry" name="entry" value="sso">
  <input type="hidden" id="r" name="reference" value="" />
    <div class="logoicon"></div>
    <div class="main_top">
      <p class="notice link" style="width:470px;"><span class="fb">提示：</span>新浪微博、博客、邮箱帐号，请<a href="/signup/signin.php?entry=sso">直接登录</a></p>
	  <p class="title_note red"></p>
          </div>
	<div class="main_cen">
      <p class="title">常用邮箱注册</p>
	  <ul class="maintable">
          <li><div class="mt_l"><span class="red">*</span>您的用户名：</div>
          <div class="inputbox"><span class="input"><cite><input id="name" name="name" type="text" maxlength="64" alt="用户名:无内容/有全角/排重/focusFn{nameTip}/errArea{nametip}" value="" /></cite></span></div>
          <span id="nametip"></span>
         </li>
	    <li>
		  <div class="mt_l"><span class="red">*</span>您的邮箱地址：</div>
		  <div class="mt_r">
		    <div class="inputbox"><span class="input"><cite><input id="username" name="username" type="text" maxlength="64" alt="邮箱地址:无内容/有全角/有空格/有大写/有中文/邮箱地址/非新浪邮箱/排重/focusFn{unameTip}/errArea{usernametip}" value="" /></cite></span></div>
			<span class="inputacc link"><a href="http://login.sina.com.cn/signup/signup.php?entry=sso">我没有邮箱</a></span>
			<span id="usernametip"></span>
			<div class="inputtxt zi_9">请输入您的常用邮箱地址，此邮箱地址将作为会员名使用</div>
		  </div>
		</li>
	    <li>
		  <div class="mt_l"><span class="red">*</span>新浪登录密码：</div>
		  <div class="mt_r">
		    <div class="inputbox"><span class="input"><cite><input id="password" name="password" type="password" alt="密码:无内容/有全角/有空格/怪字符pwd/长度{6-16}/有中文/判断强度/重复字符/连续字符/keyFn{判断强度}/focusFn{passwordTip}/errArea{passwordtip}" value="" /></cite></span></div>
			<span class="inputfloat" id="passW">
				<div class="passW" id="passW1"><span class="passW_w"></span><span class="passW_t">弱</span></div>
				<div class="passW" id="passW2"><span class="passW_w"></span><span class="passW_t">中</span></div>
				<div class="passW" id="passW3"><span class="passW_w"></span><span class="passW_t">强</span></div>
			</span>
			<span id="passwordtip"></span>
			<div class="inputtxt zi_9">6-16位字符（字母、数字、符号），区分大小写<br>为了您的帐号安全，请不要使用与您的注册邮箱相同的登录密码</div>
		  </div>
		</li>
	    <li>
		  <div class="mt_l"><span class="red">*</span>再次输入密码：</div>
		  <div class="mt_r">
		    <div class="inputbox"><span class="input"><cite><input id="password2" name="password2" type="password" alt="确认密码:无内容/有全角/有空格/怪字符pwd/长度{6-16}/相同{password}/errArea{password2tip}"  value=""/></cite></span></div>
			<span id="password2tip"></span>
		  </div>
		</li>
		<!--add info 添加用户注册信息 -->
				<!--add end-->
	  </ul>
      <p class="title">填写个人资料</p>
	  <ul class="maintable">
	  	  	    <li>
		  <div class="mt_l">		  <span class="red">*</span>昵称：</div>
		  <div class="mt_r">
		    <div class="inputbox"><span class="input"><cite><input id="nickName" name="nickName" type="text" maxlength="20" alt="昵称:无内容/全数字/有全角/长度{4-20}/有大写/数字字母中文/errArea{nicktip}" value=""/></cite></span></div>
			<span id="nicktip"></span>
			<div class="inputtxt zi_9">4-20位小写字母、数字或汉字（汉字算两位）组成</div>
		  </div>
          <div class="mt_l">		  <span class="red">*</span>昵称：</div>
		  <div class="mt_r">
		    <div class="inputbox"><span class="input"><cite><input id="nickName" name="nickName" type="text" maxlength="20" alt="昵称:无内容/全数字/有全角/长度{4-20}/有大写/数字字母中文/errArea{nicktip}" value=""/></cite></span></div>
			<span id="nicktip"></span>
			<div class="inputtxt zi_9">4-20位小写字母、数字或汉字（汉字算两位）组成</div>
		  </div>
          <div class="mt_l">		  <span class="red">*</span>昵称：</div>
		  <div class="mt_r">
		    <div class="inputbox"><span class="input"><cite><input id="nickName" name="nickName" type="text" maxlength="20" alt="昵称:无内容/全数字/有全角/长度{4-20}/有大写/数字字母中文/errArea{nicktip}" value=""/></cite></span></div>
			<span id="nicktip"></span>
			<div class="inputtxt zi_9">4-20位小写字母、数字或汉字（汉字算两位）组成</div>
		  </div>
          
		</li>
			  		
					  </ul>
<!-- 先注释掉，不确定是否能下
-->
      <p class="title">填写验证码</p>
	  <ul class="maintable">
	    <li>
		  <div class="mt_l"><span class="red">*</span>验证码：</div>
		  <div class="mt_r">
		    <div class="inputbox"><span class="input"><cite><input autocomplete="off" id="door" name="door" type="text" maxlength="10" alt="验证码:无内容/有空格/errArea{doortip}" value="" /></cite></span></div>
			<span id="door_img" style="display:none;">
				<span><img id="check_img" src="" /></span>
				<span class="link"><a href="javascript:con_code();">看不清</a>？</span>
			</span>
			<span id="doortip"></span>
		  </div>

		</li>
	    <li>
		  <div class="mt_l"></div>
		  <div class="mt_r">
		    <div class="inputacc"><input id="after" name="after" type="checkbox" alt="请确认您已看过并同意《新浪网络服务使用协议》:条款/errArea{aftertip}" checked="checked" />&nbsp;我已经看过并同意《<a href="/signupagreement.html" target="_blank">新浪网络服务使用协议</a>》</div>
			<span id="aftertip"></span>
		  </div>
		</li>
	    <li>
		  <div class="mt_l"></div>
		  <div class="mt_r">
			<input type="submit" class="btn_submit" value="提交" />
		  </div>
		</li>
	  </ul>

	</div>
    <div class="main_bottom"></div>
  </form>
  </div>

  <div class="Footer">
<p>客户服务电话 <a target="_blank" href="http://help.sina.com.cn/contact/contact.html">400-690-0000</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;欢迎批评指正</p>
<p><a target="_blank" href="http://corp.sina.com.cn/chn/">新浪简介</a> | <a target="_blank" href="http://corp.sina.com.cn/eng/">About Sina</a> | <a target="_blank" href="http://ads.sina.com.cn/">广告服务</a> | <a target="_blank" href="http://www.sina.com.cn/contactus.html">联系我们</a> | <a target="_blank" href="http://corp.sina.com.cn/chn/sina_job.html">招聘信息</a> | <a target="_blank" href="http://www.sina.com.cn/intro/lawfirm.shtml">网站律师</a> | <a target="_blank" href="http://english.sina.com/">SINA English</a> | <a target="_blank" href="http://members.sina.com.cn/apply/">通行证注册</a> | <a target="_blank" href="http://tech.sina.com.cn/focus/sinahelp.shtml">产品答疑</a></p>
<p>Copyright &copy; 1996 - 2012 SINA Corporation, All Rights Reserved 新浪公司 <a target="_blank" href="http://www.sina.com.cn/intro/copyright.shtml">版权所有</a></p>

  </div>
</div>

<script type="text/javascript">
function con_code() {
	var qq = Math.round((Math.random()) * 100000000);
	$("check_img").src = '../include/vdimgck.php?tag=' + qq;
}
onReady(function(){
	var conf = (typeof $vconf == 'undefined') ? {} : $vconf;
	var v = new Validator(conf);
	v.init('vForm');
});
//在标签内加入 onfocus="suozaidi_onfocus(this)"
function suozaidi_onfocus(m)
{
	$addClassName(m.parentNode.parentNode, "inputGreen");
}
//在标签内加入 onblur="suozaidi_onblur(this)"
function suozaidi_onblur(m)
{
	$removeClassName(m.parentNode.parentNode, "inputGreen");
}
</script>
</body>
</html>
