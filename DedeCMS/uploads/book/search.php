<?php
/**
 * @version        $Id: search.php 1 9:02 2010年9月25日Z 蓝色随想 $
 * @package        DedeCMS.Module.Book
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

require_once(dirname(__FILE__). "/../include/common.inc.php");
require_once(dirname(__FILE__). '/include/story.view.class.php');
$kws = Array();
if(!empty($id)) $kws['id'] = intval($id);

if(!empty($keyword)) $kws['keyword'] = html2text($keyword);

if(!empty($author)) $kws['author'] = html2text($author);

if(count($kws)==0) ParamError();

$bv = new BookView(0, 'search', $kws);
$bv->Display();
$bv->Close();
