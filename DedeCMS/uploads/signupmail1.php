<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>ע������ͨ��֤</title>
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
	<div class="logotxt">- ע��</div>
	<div class="headlink"><a href="http://www.sina.com.cn">������ҳ</a> | <a href="/help.html">����</a></div>
	<div class="clearit"></div>
  </div>

  <div class="main">
  <form method="post" id="reg_new.php name="vForm">
  <input type="hidden" id="act" name="act" value=1>
  <input type="hidden" id="entry" name="entry" value="sso">
  <input type="hidden" id="r" name="reference" value="" />
    <div class="logoicon"></div>
    <div class="main_top">
      <p class="notice link" style="width:470px;"><span class="fb">��ʾ��</span>����΢�������͡������ʺţ���<a href="/signup/signin.php?entry=sso">ֱ�ӵ�¼</a></p>
	  <p class="title_note red"></p>
          </div>
	<div class="main_cen">
      <p class="title">��������ע��</p>
	  <ul class="maintable">
          <li><div class="mt_l"><span class="red">*</span>�����û�����</div>
          <div class="inputbox"><span class="input"><cite><input id="name" name="name" type="text" maxlength="64" alt="�û���:������/��ȫ��/����/focusFn{nameTip}/errArea{nametip}" value="" /></cite></span></div>
          <span id="nametip"></span>
         </li>
	    <li>
		  <div class="mt_l"><span class="red">*</span>���������ַ��</div>
		  <div class="mt_r">
		    <div class="inputbox"><span class="input"><cite><input id="username" name="username" type="text" maxlength="64" alt="�����ַ:������/��ȫ��/�пո�/�д�д/������/�����ַ/����������/����/focusFn{unameTip}/errArea{usernametip}" value="" /></cite></span></div>
			<span class="inputacc link"><a href="http://login.sina.com.cn/signup/signup.php?entry=sso">��û������</a></span>
			<span id="usernametip"></span>
			<div class="inputtxt zi_9">���������ĳ��������ַ���������ַ����Ϊ��Ա��ʹ��</div>
		  </div>
		</li>
	    <li>
		  <div class="mt_l"><span class="red">*</span>���˵�¼���룺</div>
		  <div class="mt_r">
		    <div class="inputbox"><span class="input"><cite><input id="password" name="password" type="password" alt="����:������/��ȫ��/�пո�/���ַ�pwd/����{6-16}/������/�ж�ǿ��/�ظ��ַ�/�����ַ�/keyFn{�ж�ǿ��}/focusFn{passwordTip}/errArea{passwordtip}" value="" /></cite></span></div>
			<span class="inputfloat" id="passW">
				<div class="passW" id="passW1"><span class="passW_w"></span><span class="passW_t">��</span></div>
				<div class="passW" id="passW2"><span class="passW_w"></span><span class="passW_t">��</span></div>
				<div class="passW" id="passW3"><span class="passW_w"></span><span class="passW_t">ǿ</span></div>
			</span>
			<span id="passwordtip"></span>
			<div class="inputtxt zi_9">6-16λ�ַ�����ĸ�����֡����ţ������ִ�Сд<br>Ϊ�������ʺŰ�ȫ���벻Ҫʹ��������ע��������ͬ�ĵ�¼����</div>
		  </div>
		</li>
	    <li>
		  <div class="mt_l"><span class="red">*</span>�ٴ��������룺</div>
		  <div class="mt_r">
		    <div class="inputbox"><span class="input"><cite><input id="password2" name="password2" type="password" alt="ȷ������:������/��ȫ��/�пո�/���ַ�pwd/����{6-16}/��ͬ{password}/errArea{password2tip}"  value=""/></cite></span></div>
			<span id="password2tip"></span>
		  </div>
		</li>
		<!--add info ����û�ע����Ϣ -->
				<!--add end-->
	  </ul>
      <p class="title">��д��������</p>
	  <ul class="maintable">
	  	  	    <li>
		  <div class="mt_l">		  <span class="red">*</span>�ǳƣ�</div>
		  <div class="mt_r">
		    <div class="inputbox"><span class="input"><cite><input id="nickName" name="nickName" type="text" maxlength="20" alt="�ǳ�:������/ȫ����/��ȫ��/����{4-20}/�д�д/������ĸ����/errArea{nicktip}" value=""/></cite></span></div>
			<span id="nicktip"></span>
			<div class="inputtxt zi_9">4-20λСд��ĸ�����ֻ��֣���������λ�����</div>
		  </div>
          <div class="mt_l">		  <span class="red">*</span>�ǳƣ�</div>
		  <div class="mt_r">
		    <div class="inputbox"><span class="input"><cite><input id="nickName" name="nickName" type="text" maxlength="20" alt="�ǳ�:������/ȫ����/��ȫ��/����{4-20}/�д�д/������ĸ����/errArea{nicktip}" value=""/></cite></span></div>
			<span id="nicktip"></span>
			<div class="inputtxt zi_9">4-20λСд��ĸ�����ֻ��֣���������λ�����</div>
		  </div>
          <div class="mt_l">		  <span class="red">*</span>�ǳƣ�</div>
		  <div class="mt_r">
		    <div class="inputbox"><span class="input"><cite><input id="nickName" name="nickName" type="text" maxlength="20" alt="�ǳ�:������/ȫ����/��ȫ��/����{4-20}/�д�д/������ĸ����/errArea{nicktip}" value=""/></cite></span></div>
			<span id="nicktip"></span>
			<div class="inputtxt zi_9">4-20λСд��ĸ�����ֻ��֣���������λ�����</div>
		  </div>
          
		</li>
			  		
					  </ul>
<!-- ��ע�͵�����ȷ���Ƿ�����
-->
      <p class="title">��д��֤��</p>
	  <ul class="maintable">
	    <li>
		  <div class="mt_l"><span class="red">*</span>��֤�룺</div>
		  <div class="mt_r">
		    <div class="inputbox"><span class="input"><cite><input autocomplete="off" id="door" name="door" type="text" maxlength="10" alt="��֤��:������/�пո�/errArea{doortip}" value="" /></cite></span></div>
			<span id="door_img" style="display:none;">
				<span><img id="check_img" src="" /></span>
				<span class="link"><a href="javascript:con_code();">������</a>��</span>
			</span>
			<span id="doortip"></span>
		  </div>

		</li>
	    <li>
		  <div class="mt_l"></div>
		  <div class="mt_r">
		    <div class="inputacc"><input id="after" name="after" type="checkbox" alt="��ȷ�����ѿ�����ͬ�⡶�����������ʹ��Э�顷:����/errArea{aftertip}" checked="checked" />&nbsp;���Ѿ�������ͬ�⡶<a href="/signupagreement.html" target="_blank">�����������ʹ��Э��</a>��</div>
			<span id="aftertip"></span>
		  </div>
		</li>
	    <li>
		  <div class="mt_l"></div>
		  <div class="mt_r">
			<input type="submit" class="btn_submit" value="�ύ" />
		  </div>
		</li>
	  </ul>

	</div>
    <div class="main_bottom"></div>
  </form>
  </div>

  <div class="Footer">
<p>�ͻ�����绰 <a target="_blank" href="http://help.sina.com.cn/contact/contact.html">400-690-0000</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��ӭ����ָ��</p>
<p><a target="_blank" href="http://corp.sina.com.cn/chn/">���˼��</a> | <a target="_blank" href="http://corp.sina.com.cn/eng/">About Sina</a> | <a target="_blank" href="http://ads.sina.com.cn/">������</a> | <a target="_blank" href="http://www.sina.com.cn/contactus.html">��ϵ����</a> | <a target="_blank" href="http://corp.sina.com.cn/chn/sina_job.html">��Ƹ��Ϣ</a> | <a target="_blank" href="http://www.sina.com.cn/intro/lawfirm.shtml">��վ��ʦ</a> | <a target="_blank" href="http://english.sina.com/">SINA English</a> | <a target="_blank" href="http://members.sina.com.cn/apply/">ͨ��֤ע��</a> | <a target="_blank" href="http://tech.sina.com.cn/focus/sinahelp.shtml">��Ʒ����</a></p>
<p>Copyright &copy; 1996 - 2012 SINA Corporation, All Rights Reserved ���˹�˾ <a target="_blank" href="http://www.sina.com.cn/intro/copyright.shtml">��Ȩ����</a></p>

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
//�ڱ�ǩ�ڼ��� onfocus="suozaidi_onfocus(this)"
function suozaidi_onfocus(m)
{
	$addClassName(m.parentNode.parentNode, "inputGreen");
}
//�ڱ�ǩ�ڼ��� onblur="suozaidi_onblur(this)"
function suozaidi_onblur(m)
{
	$removeClassName(m.parentNode.parentNode, "inputGreen");
}
</script>
</body>
</html>
