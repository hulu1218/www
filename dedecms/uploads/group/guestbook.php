<?php
/**
 * @version        $Id: guestbook.php 1 12:11 2010年9月13日Z tianya $
 * @package        DedeCMS.Module.Group
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
include_once DEDEGROUP."/global.inc.php";
include_once DEDEINC.'/datalistcp.class.php';
$bid = isset($bid) && is_numeric($bid) ? $bid : 0;
$do = isset($do) ? trim($do) : '';
if($id < 1)
{
    ShowMsg("错误,未定义的操作！","-1");
    exit();
}

if($do=="del" && $ismaster)
{
    $row = $db->GetOne("SELECT bid FROM #@__group_guestbook WHERE bid='$bid'");
    if(!is_array($row))
    {
        ShowMsg("记录不存在！","-1");
        exit();
    }
    $db->ExecuteNoneQuery("DELETE FROM #@__group_guestbook WHERE bid='$bid'");
}

$pagesize = 5;
$nowpage = isset($pageno) && is_numeric($pageno) ? max($pageno, 1) : 1;
$topic = ($nowpage-1) * $pagesize;
$sql = "SELECT G.stime,G.bid,G.message,G.title,M.uname,M.userid,M.face,M.sex FROM #@__group_guestbook G LEFT JOIN #@__member M ON G.userid=M.mid WHERE G.gid='$id' ORDER BY G.stime ASC";

$dl = new DataListCP();
$dl->pageSize = $pagesize;    //设定每页显示记录数（默认5条）
$dl->SetParameter('id',$id);  //设定get字符串的变量

//这两句的顺序不能更换
$dl->SetTemplate(GROUP_TPL.'/guestbook.html');      //载入模板
$dl->SetSource($sql);            //设定查询SQL
$dl->Display();                  //显示