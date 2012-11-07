<?php
/**
 * @version        $Id: templets.php 1 12:11 2010年9月13日Z tianya $
 * @package        DedeCMS.Module.Group
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
 
if(!defined('DEDEINC') || !isset($_GROUPS)) exit("403 Forbidden!");
$_templets = DEDEGROUP.'/templets/'.$_GROUPS['theme'];
$_GROUPS['theme'] = !is_dir($_templets) ? 'default' : $_GROUPS['theme'];
define('GROUP_TPL', str_replace('\\', '/', DEDEROOT).'/group/templets/'.$_GROUPS['theme']); 