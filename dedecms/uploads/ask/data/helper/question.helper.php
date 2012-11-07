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


//获取用户短信数目
function get_pms($uid)
{
    //引入数据库类
    if ($GLOBALS['cfg_mysql_type'] == 'mysqli' && function_exists("mysqli_init"))
    {
        $dsql = $GLOBALS['dsqli'];
    } else {
        $dsql = $GLOBALS['dsql'];
    }
    $row = $dsql->GetOne("SELECT COUNT(*) AS nums FROM #@__member_pms 
                          WHERE toid='{$uid}' AND `hasview`=0 AND folder = 'inbox'");
    if(is_array($row)) return $row['nums'];
    else return 0;
}

?>