<?php if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 
 * @version        2011/2/11  沙羡 $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2011, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 *
 **/

function GetFileSize($fs)
{
    $fs = $fs/1024;
    return trim(sprintf("%10.1f",$fs)." K");
}

function UploadAdmin($mid)
{
    global $dsql;
    if($mid!='') return $mid;
    else return $mid;
}

?>