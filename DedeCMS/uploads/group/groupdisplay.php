<?php
/**
 * @version        $Id: groupdisplay.php 1 12:11 2010年9月13日Z tianya $
 * @package        DedeCMS.Module.Group
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
include_once DEDEGROUP."/global.inc.php";
include_once DEDEINC.'/datalistcp.class.php';
$typeid = isset($typeid) && is_numeric($typeid) ? $typeid : 0;
$keywords = isset($keywords) ? trim($keywords) : '';
$keywords = stripslashes($keywords);
$keywords = preg_replace("#[\"\r\n\t\*\?\(\)\$%']#", " ", trim($keywords));
$keywords = addslashes($keywords);
$addsql = "WHERE gid='{$id}' AND closed='0' ";

if($typeid > 0)
{
    $addsql .= "AND smalltype='$typeid' ";
}

if(!empty($keywords))
{
    $addsql .= "AND subject like '%".$keywords."%' ";
}

function _get_smalltype($id,$_field = 'name')
{
    global $db;
    $row = $db->GetOne("SELECT `id`,`name` FROM `#@__group_smalltypes` WHERE id='$id'");
    if(isset($row[$_field])) return '['.$row[$_field].']';
}

static $row_fields = false;

$sql = "SELECT tid,subject,digest,displayorder,replies,lastpost,lastposter,smalltype,author,views FROM #@__group_threads $addsql ORDER BY displayorder DESC, lastpost DESC";
$dl = new DataListCP();
$dl->pageSize = 20;
$dl->SetParameter('id', $id);
$dl->SetParameter("keywords", $keywords);
$dl->SetParameter("typeid", $typeid);

//这两句的顺序不能更换
$dl->SetTemplate(GROUP_TPL.'/groupdisplay.html');      //载入模板
$dl->SetSource($sql);            //设定查询SQL
$dl->Display();                  //显示