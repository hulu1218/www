<?php  if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 
 * @version        2011/2/11  沙羡 $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2011, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 *
 **/
@set_magic_quotes_runtime(0);
require_once DEDEINC.'/memberlogin.class.php';
//载入分类
require_once DEDEASK.'/data/asktype.inc.php';
//载入积分排行
require_once DEDEASK.'/data/scores.inc.php';
//载入基本function
require_once DEDEASK.'/data/functions.inc.php';

@ob_start();
if($cfg_ask == 'N')
{
	showmsg('问答系统已关闭，请返回', '-1');
	exit;
}
//会员信息
$cfg_ml = new MemberLogin();
//问答模块列表显示问题数
$cfg_ask_tpp = $cfg_ask_tpp = 20;
$cfg_ask_tpp = max(1,$cfg_ask_tpp);
//问答模块问题有效期
$cfg_ask_expiredtime = isset($cfg_ask_expiredtime) && is_numeric($cfg_ask_expiredtime) ? $cfg_ask_expiredtime : 20;
$cfg_ask_expiredtime = max($cfg_ask_expiredtime, 1);
//当前系统时间
$cfg_ask_timestamp = time();
//获取地址
$cfg_ask_curl = geturl(1);
//对获取的地址进行处理，方便调用
$callurl = str_replace('&','^',$cfg_ask_curl);
//会员注册跳转地址
$cfg_ask_member = $cfg_basehost.'/member/login.php?gourl='.$callurl;
//问答当前目录
$cfg_ask_directory = $cfg_cmspath.$cfg_ask_directory;
//问答所在主网站绝对地址
$cfg_ask_basehost = empty($cfg_cmspath)? $cfg_basehost : $cfg_basehost.$cfg_cmspath;
//当前位置
$cfg_ask_position = '<a href="'.$cfg_ask_directory.'">'.$cfg_ask_sitename.'</a> '.$cfg_ask_symbols;
//如果启用二级域名，禁止二级目录访问
if($cfg_ask_isdomain == 'Y')
{
    if(!preg_match ("#$cfg_ask_domain#i",$callurl))
    {
        showmsg('非法操作',$cfg_ask_domain);
	    exit;
    } 
}
?>