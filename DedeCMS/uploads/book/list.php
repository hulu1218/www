<?php
/**
 * @version        $Id: list.php 1 9:02 2010年9月25日Z 蓝色随想 $
 * @package        DedeCMS.Module.Book
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

require_once(dirname(__FILE__)."/../include/common.inc.php");
require_once(dirname(__FILE__).'./include/story.view.class.php');
$id = intval($id);
if(empty($id))
{
    ParamError();
}
$bv = new BookView($id, 'catalog');
$bv->Display();
$bv->Close();
