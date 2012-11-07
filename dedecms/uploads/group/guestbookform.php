<?php
/**
 * @version        $Id: guestbookform.php 1 12:11 2010年9月13日Z tianya $
 * @package        DedeCMS.Module.Group
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
$id = isset($id) && is_numeric($id) ? $id : 0;
$action = isset($action) ? trim($action) : '';
if(!$cfg_ml->IsLogin())
{
    ShowMsg("未登录前不充许该操作！","-1");
    exit();
}
if($id < 1)
{
    ShowMsg("错误,未定义的操作！","-1");
    exit();
}
if($action=="save")
{
    $svali = GetCkVdValue();
    if(strtolower($vdcode) != $svali || $svali=="")
    {
        ShowMsg("认证码错误！","-1");
        exit();
    }

    $subject = cn_substrR(trim(HtmlReplace($subject), 2), 80);
    $text = preg_replace("#<(iframe|script)#i", "", $text);
    if(CountStrLen($text) < 3 || CountStrLen($text) > 1000)
    {
        ShowMsg("内容字数应该在3-1000个汉字！","-1");
        exit();
    }
    if(preg_match("#$cfg_notallowstr#", $subject) || preg_match("#$cfg_notallowstr#", $text))
    {
        ShowMsg("含有非法字符！", "-1");
        exit();
    }
    $subject = preg_replace("/$cfg_replacestr/", "***", $subject);
    $text = preg_replace("/$cfg_replacestr/", "***", $text);
    $userip = GetIP();
    $SetQuery = "INSERT INTO #@__group_guestbook(gid,title,uname,userid,stime,message,ip) ";
    $SetQuery .= "VALUES('$id','$subject','".$cfg_ml->M_UserName."','".$cfg_ml->M_ID."','".time()."','$text','$userip');";
    if($db->ExecuteNoneQuery($SetQuery))
    {
        ShowMsg("留言成功！","guestbook.php?id={$id}");
        exit();
    }
    else
    {
        ShowMsg("出错了！","-1");
        exit();
    }
}
else
{
    exit("403 Forbidden!");
}