<?php

/**
 * Enter description here...
 *
 * @author Administrator
 * @package defaultPackage
 * @rcsfile 	$RCSfile: index.php,v $
 * @revision 	$Revision: 1.1 $
 * @date 	$Date: 2008/12/11 02:09:40 $
 */

require_once(dirname(__FILE__)."/../include/common.inc.php");
require_once(dirname(__FILE__).'/include/story.view.class.php');
$bv = new BookView(0,'index');
$bv->Display();
$bv->Close();
?>