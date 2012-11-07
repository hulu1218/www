<?php
/**
 * @version        $Id: index.php 1 12:09 2010年9月13日Z tianya $
 * @package        DedeCMS.Module.Group
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");

//热门分类
$db->SetQuery("SELECT storename,storeid FROM #@__store_groups WHERE tops=0 ORDER BY nums DESC LIMIT 0,9");
$db->Execute();
$topgroups = array();
while($rs = $db->GetArray())
{
    array_push ($topgroups, $rs);
}
$title = "圈子首页";

//推荐圈子图标
function Showindeximage($storeid, $s="img")
{
    global $db;
    $storeid = preg_replace("#[^0-9]#", "", $storeid);
    $rs = $db->GetOne("SELECT groupid,groupimg FROM #@__groups WHERE rootstoreid='{$storeid}' AND isindex=1 ORDER BY stime DESC");
    if($s=="id")
    {
        if(!is_array($rs)) return 0;
        else return $rs['groupid'];
    }
    else
    {
        if(!is_array($rs)) return "images/group_mainlist00.gif";
        else return $rs['groupimg'];
    }
}

$sprit = array(3, 6);
require_once(DEDEGROUP."/templets/index.htm");