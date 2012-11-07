<?php
/**
 * @version        $Id: directry.php 1 12:11 2010年9月13日Z tianya $
 * @package        DedeCMS.Module.Group
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");

//目录树列表文件
$title = "所有分类";
$db->SetQuery("SELECT * FROM #@__store_groups WHERE tops=0 AND nums>0 ORDER BY nums DESC");
$db->Execute();
$stores = array();
while($rs = $db->GetArray())
{
    array_push ($stores, $rs);
}
require_once(DEDEGROUP."/templets/directry.htm");