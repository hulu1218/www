<?php
/**
 * @version        $Id: book.php 1 9:02 2010年9月25日Z 蓝色随想 $
 * @package        DedeCMS.Module.Book
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 
require_once(dirname(__FILE__). "/../include/common.inc.php");
require_once(dirname(__FILE__). '/include/story.view.class.php');
$bid = (empty($bid) ? 0 : intval($bid));
if($bid==0)
{
    ParamError();
}
$bv = new BookView($bid, 'book');
$ischeck = $bv->Fields['ischeck'];
if($ischeck == 0)
{
    require_once(DEDEINC. "/../include/memberlogin.class.php");
    $ml = new MemberLogin();
    if($bv->Fields['mid'] != $ml->M_ID)
    {
        showmsg('图书未经审核', $cfg_mainsite.$cfg_cmspath.'/book');
        exit();
    }
}
$bv->Display();
$bv->Close();
