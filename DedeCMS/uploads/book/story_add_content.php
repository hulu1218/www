<?php
/**
 * @version        $Id: story_add_content.php 1 9:02 2010年9月25日Z 蓝色随想 $
 * @package        DedeCMS.Module.Book
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

require_once(dirname(__FILE__). "/../member/config.php");
CheckRank(0,0);
$menutype = 'mydede';
if(!isset($action))
{
    $action = '';
}
if(empty($bookid))
{
    ShowMsg("参数错误！","-1");
    exit();
}
$bookinfos = $dsql->GetOne("SELECT catid,bcatid,bookname,booktype FROM #@__story_books WHERE bid='$bookid' AND mid='$cfg_ml->M_ID' ");
if(!is_array($bookinfos))
{
    ShowMsg("参数错误！","-1");
    exit();
}
if($bookinfos['booktype']==1)
{
    header("location:story_add_photo.php?bookid={$bookid}");
    exit();
}

//读取所有栏目
$dsql->SetQuery("SELECT id,classname,pid,rank FROM #@__story_catalog ORDER BY rank asc");
$dsql->Execute();
$ranks = Array();
$btypes = Array();
$stypes = Array();
while($row = $dsql->GetArray())
{
    if($row['pid']==0)
    {
        $btypes[$row['id']] = $row['classname'];
    }
    else
    {
        $stypes[$row['pid']][$row['id']] = $row['classname'];
    }
    $ranks[$row['id']] = $row['rank'];
}
$lastid = $row['id'];
$msg = '';
$dsql->SetQuery("SELECT id,chapnum,chaptername FROM #@__story_chapter WHERE bookid='$bookid' AND mid='$cfg_ml->M_ID' ORDER BY chapnum DESC");
$dsql->Execute();
$chapters = Array();
$chapnums = Array();
while($row = $dsql->GetArray())
{
    $chapters[$row['id']] = $row['chaptername'];
    $chapnums[$row['id']] = $row['chapnum'];
}
$catid = $bookinfos['catid'];
$bcatid = $bookinfos['bcatid'];
$bookname = $bookinfos['bookname'];
$booktype = $bookinfos['booktype'];
require_once(dirname(__FILE__). "/templets/book/story_add_content.htm");
?>