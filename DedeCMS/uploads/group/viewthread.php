<?php
/**
 * @version        $Id: templets.php 1 12:11 2010年9月13日Z tianya $
 * @package        DedeCMS.Module.Group
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__). "/config.php");
include_once DEDEGROUP. "/global.inc.php";
include_once DEDEINC. '/datalistcp.class.php';
$id = isset($id) && is_numeric($id) ? $id : 0;
$tid = isset($tid) && is_numeric($tid) ? $tid : 0;
$pid = isset($pid) && is_numeric($pid) ? $pid : 0;
$nowpage = isset($pageno) && is_numeric($pageno) ? max($pageno, 1) : 1;
$do = isset($do) ? trim($do) : '';
if($tid < 1)
{
    ShowMsg("错误,未定义的操作！","-1");
    exit();
}
$db->ExecuteNoneQuery("UPDATE #@__group_threads SET views=views+1 WHERE tid='$tid';");
$_threads = $row = $db->GetOne("SELECT subject,digest,displayorder,tid FROM #@__group_threads WHERE gid='$id' AND tid='$tid'");
if(!is_array($row))
{
    //开始移除相关贴子
    $db->ExecuteNoneQuery("DELETE FROM #@__group_posts WHERE tid='$tid'");
    //更新统计
    Upcountgroups($id);
    Upcontuserpost($id, $userid, "post");
    ShowMsg("主题已经被移走！", "index.php");
    exit();
}
$subject = $row['subject'];
//删除贴子操作
if($do=="del")
{
    $result = $db->GetOne("SELECT authorid,first FROM #@__group_posts WHERE pid='$pid'");
    if( is_array($result) && ($ismaster || $cfg_ml->M_ID == $result['authorid']) )
    {
		$jumpurl = "viewthread.php?id={$id}&tid={$tid}";
        if($result['first'])
        {
            //开始移除相关贴子
            $db->ExecuteNoneQuery("DELETE FROM #@__group_posts WHERE tid='$tid'");
            $db->ExecuteNoneQuery("DELETE FROM #@__group_threads WHERE tid='$tid'");
            //更新统计
            Upcountgroups($id);
            Upcontuserpost($id,$result['authorid'],"post");
			$jumpurl = "groupdisplay.php?id={$id}";
        }
        else
        {
            //移除指定贴子
            $db->ExecuteNoneQuery("DELETE FROM #@__group_posts WHERE pid='$pid'");
        }
        //更新回复统计
        Upcontuserpost($id,$result['authorid'],"replies");
        ShowMsg("成功删除帖子！", $jumpurl);
        exit();
    }
    else
    {
        ShowMsg("现您没该操作权限！", "-1");
        exit();
    }
}

$sql = "SELECT pid,first,subject,authorid,author,dateline,message FROM #@__group_posts WHERE gid='$id' AND tid='$tid' ORDER BY dateline ASC";

$dl = new DataListCP();
$dl->pageSize = 5;
$dl->SetParameter('id',$id);
$dl->SetParameter("tid",$tid);
//这两句的顺序不能更换
$dl->SetTemplate(GROUP_TPL."/viewthread.html");      //载入模板
$dl->SetSource($sql);            //设定查询SQL
$dl->Display();                  //显示