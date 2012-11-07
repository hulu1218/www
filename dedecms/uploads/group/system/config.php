<?php
/**
 * @version        $Id: config.php 1 12:11 2010年9月13日Z tianya $
 * @package        DedeCMS.Module.Group
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/../../member/config.php");
CheckRank(0, 0);
define('_SYSTEM_', DEDEROOT.'/group/templets/system');