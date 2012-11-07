<?php
/**
 * @version        $Id: search.php 1 12:11 2010年9月13日Z tianya $
 * @package        DedeCMS.Module.Group
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once(DEDEINC.'/datalistcp.class.php');

$sad = preg_replace("#[^g|t]#i", "", $sad);
$keyword = isset($keyword) ? trim($keyword) : '';
$keyword = stripslashes($keyword);
$keyword = preg_replace("#[\"\r\n\t\*\?\(\)\$%']#", " ", trim($keyword));
$keyword = addslashes($keyword);

if(empty($sad))
{
    $sad = "t";
}
if(empty($keyword))
{
    ShowMsg("错误,请输入搜索关键字！", "-1");
    exit();
}

if($sad=="g")
{
    $searchtable = "#@__groups";
    $WhereSql = "WHERE ishidden=0 AND groupname like '%".$keyword."%'";
    $Orders = "ORDER BY stime DESC";
}
else
{
    $searchtable = "#@__group_threads";
    $WhereSql = "WHERE closed=0 AND subject like '%".$keyword."%'";
    $Orders = "ORDER BY lastpost DESC";
}
$title = "搜索";
$sql = "SELECT * FROM $searchtable $WhereSql $Orders";

$dl = new DataListCP();
$dl->pageSize = 10;
$dl->SetParameter('keyword', $keyword);
$dl->SetParameter("sad", $sad);

//这两句的顺序不能更换
$tpl = $sad=="g" ? 'search_groups.htm' : 'search_topic.htm';
$dl->SetTemplate(DEDEGROUP."/templets/".$tpl);      //载入模板
$dl->SetSource($sql);            //设定查询SQL
$dl->Display();                  //显示