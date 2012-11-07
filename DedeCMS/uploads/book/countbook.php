<?php
/**
 * @version        $Id: countbook.php 1 9:02 2010年9月25日Z 蓝色随想 $
 * @package        DedeCMS.Module.Book
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */


$__ONLYDB = true;
require_once(dirname(__FILE__). "/../include/common.inc.php");
$id = intval($aid);
$id = preg_replace("#[^0-9]#","",$id);
$dsql->ExecuteNoneQuery("UPDATE #@__story_books SET click=click+1 WHERE bid='$id'");
if(!empty($view))
{
    $row = $dsql->GetOne("SELECT click FROM #@__story_books  WHERE bid='$id'");
    echo "document.write('".$row['click']."');\r\n";
}
exit();
//如果想显示点击次数,请增加view参数,即把下面ＪＳ调用放到文档模板适当位置
/*<script src="{dede:field name='phpurl'/}/countbook.php?view=yes&aid={dede:field name='id'/}" language="javascript"></script>
//普通计数器为
//<script src="{dede:field name='phpurl'/}/countbook.php?aid={dede:field name='id'/}" language="javascript"></script>
*/
