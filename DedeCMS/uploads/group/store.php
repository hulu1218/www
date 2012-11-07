<?php
/**
 * @version        $Id: store.php 1 12:11 2010年9月13日Z tianya $
 * @package        DedeCMS.Module.Group
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once(DEDEINC.'/datalistcp.class.php');

$id = isset($id) && is_numeric($id) ? $id : 0;

if($id < 1)
{
    ShowMsg("错误,未定义的操作！", "-1");
    exit();
}
$rs = $db->GetOne("SELECT * FROM #@__store_groups WHERE storeid='$id'");
if(!is_array($rs))
{
    ShowMsg("错误,分类已被移除！", "-1");
    exit();
}
$n     = $rs['nums'];
$tops  = $rs['tops'];
if($tops > 0)
{
    $store = $rs['storename'];
    $row = $db->GetOne("SELECT * FROM #@__store_groups WHERE storeid='".$tops."'");
    $topstore = $row['storename'];
    $title = $store."-".$topstore;
    $topid = $tops;
    $nextid = $id;
}
else
{
    $topid = $id;
    $topstore = $rs['storename'];
    $store    = "";
    $title = $rs['storename'];
}

$sql = "SELECT * FROM #@__groups WHERE (storeid='$id' OR rootstoreid='$id') AND ishidden=0 ORDER BY isindex DESC,stime DESC";

$dl = new DataListCP();
$dl->pageSize = 20;
$a = $dl->pageNO * ($dl->pageSize - 1) + 1;
$dl->SetParameter('id', $id);

//这两句的顺序不能更换
$dl->SetTemplate(DEDEGROUP."/templets/store.htm");      //载入模板
$dl->SetSource($sql);            //设定查询SQL
$dl->Display();                  //显示