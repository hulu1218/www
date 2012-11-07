<?php
/**
 * @version        $Id: story_add_content_action.php 1 9:02 2010年9月25日Z 蓝色随想 $
 * @package        DedeCMS.Module.Book
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

require_once(dirname(__FILE__). "/../member/config.php");
CheckRank(0, 0);
include_once(DEDEINC. "/oxwindow.class.php");
require_once(dirname(__FILE__). "./include/story.func.php");

if( empty($chapterid)
|| (!empty($addchapter) && !empty($chapternew)) )
{
    if(empty($chapternew))
    {
        ShowMsg("由于你发布的内容没选择章节，系统拒绝发布！", "-1");
        exit();
    }
    $row = $dsql->GetOne("SELECT * FROM #@__story_chapter WHERE bookid='$bookid' AND mid='$cfg_ml->M_ID' ORDER BY chapnum DESC");
    if(is_array($row))
    {
        $nchapnum = $row['chapnum']+1;
    }
    else
    {
        $nchapnum = 1;
    }
    $query = "INSERT INTO `#@__story_chapter`(`bookid`,`catid`,`chapnum`,`mid`,`chaptername`,`bookname`)
            VALUES ('$bookid', '$catid', '$nchapnum', '$cfg_ml->M_ID', '$chapternew','$bookname');";
    $rs = $dsql->ExecuteNoneQuery($query);
    if($rs)
    {
        $chapterid = $dsql->GetLastID();
    }
    else
    {
        ShowMsg("增加章节失败，请检查原因！", "-1");
        exit();
    }
}

//获得父栏目
$nrow = $dsql->GetOne("SELECT * FROM #@__story_catalog WHERE id='$catid' ");
$bcatid = $nrow['pid'];
$booktype = $nrow['booktype'];
if(empty($bcatid))
{
    $bcatid = 0;
}
if(empty($booktype))
{
    $booktype = 0;
}
$addtime = time();

//本章最后一个小说的排列顺次序
$lrow = $dsql->GetOne("SELECT sortid FROM #@__story_content WHERE bookid='$bookid' AND chapterid='$chapterid' AND mid='$cfg_ml->M_ID' ORDER BY sortid DESC");
if(empty($lrow))
{
    $sortid = 1;
}
else
{
    $sortid = $lrow['sortid']+1;
}
$inQuery = "
INSERT INTO `#@__story_content`(`title`,`bookname`,`chapterid`,`catid`,`bcatid`,`bookid`,`booktype`,`sortid`,
`mid`,`bigpic`,`body`,`addtime`)
VALUES ('$title','$bookname', '$chapterid', '$catid','$bcatid', '$bookid','$booktype','$sortid', '$cfg_ml->M_ID', '' , '', '$addtime');";
if(!$dsql->ExecuteNoneQuery($inQuery))
{
    ShowMsg("把数据保存到数据库时出错，请检查！".$dsql->GetError().$inQuery,"-1");
    exit();
}
$arcID = $dsql->GetLastID();
WriteBookText($arcID,addslashes($body));

//更新图书的内容数
$row = $dsql->GetOne("SELECT count(id) AS dd From #@__story_content  WHERE bookid = '$bookid' AND mid='$cfg_ml->M_ID' ");
$dsql->ExecuteNoneQuery("UPDATE #@__story_books SET postnum='{$row['dd']}',lastpost='$addtime' WHERE bid='$bookid' AND mid='$cfg_ml->M_ID' ");

//更新章节的内容数
$row = $dsql->GetOne("SELECT count(id) AS dd FROM #@__story_content  WHERE bookid = '$bookid' AND chapterid='$chapterid' AND mid='$cfg_ml->M_ID' ");
$dsql->ExecuteNoneQuery("UPDATE #@__story_chapter SET postnum='{$row['dd']}' WHERE id='$chapterid' AND mid='$cfg_ml->M_ID' ");

//生成HTML
//$artUrl = MakeArt($arcID,true);
if(!isset($artUrl) || $artUrl=="") $artUrl = $cfg_cmspath. "/book/story.php?id=$arcID";


//返回成功信息
$msg = "
　　请选择你的后续操作：
<a href='story_add_content.php?bookid={$bookid}'><u>继续发布</u></a>
&nbsp;&nbsp;
<a href='$artUrl' target='_blank'><u>预览内容</u></a>
&nbsp;&nbsp;
<a href='../book/book.php?id=$bookid' target='_blank'><u>预览图书</u></a>
&nbsp;&nbsp;
<a href='story_list_content.php?bookid={$bookid}'><u>管理所有内容</u></a>
&nbsp;&nbsp;
<a href='mybooks.php'><u>管理所有图书</u></a>
";
$wintitle = "成功发布文章！";
$wecome_info = "连载管理::发布文章";
$win = new OxWindow();
$win->AddTitle("成功发布文章：");
$win->AddMsgItem($msg);
$winform = $win->GetWindow("hand","&nbsp;", false);
$win->Display();
