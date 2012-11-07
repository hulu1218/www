<?php
/**
 * @version        $Id: mygroup.php 1 12:11 2010年9月13日Z tianya $
 * @package        DedeCMS.Module.Group
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/system/config.php");
require_once(DEDEINC."/datalistcp.class.php");
$menutype = 'mydede';
$sql = "SELECT * FROM #@__groups WHERE ishidden='0' AND uid='".$cfg_ml->M_ID."'  ORDER BY threads DESC,stime DESC";
$dl = new DataListCP();
$dl->pageSize = 20;

//这两句的顺序不能更换
$dl->SetTemplate(_SYSTEM_."/mygroup.htm");      //载入模板
$dl->SetSource($sql);            //设定查询SQL
$dl->Display();                  //显示