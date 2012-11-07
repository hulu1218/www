<?php
/**
 * @version        $Id: story_list_chapter.php 1 9:02 2010年9月25日Z 蓝色随想 $
 * @package        DedeCMS.Module.Book
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

require_once(dirname(__FILE__). "/../member/config.php");
require_once(DEDEINC. "/datalistcp.class.php");
setcookie("ENV_GOBACK_URL", $dedeNowurl, time()+3600,"/");
CheckRank(0,0);
if(!isset($action)) $action = '';

if(!isset($keyword)) $keyword = "";

if(!isset($bid)) $bid = 0;

if(!empty($bookid)) $bid = $bookid;

$addquery = " mid='$cfg_ml->M_ID' AND id>0 ";
$orderby = " ORDER BY id desc ";
if($keyword!="") $addquery .= " And (bookname LIKE '%$keyword%' Or chaptername LIKE '%$keyword%') ";

if($bid!=0) $addquery .= " And bookid='$bid' ";

if(empty($bookname)) $bookname = '';

if(empty($booktype)) $booktype = '0';

$row = $dsql->GetOne("SELECT bookname,booktype FROM #@__story_books WHERE bid = '$bookid'");
if(is_array($row))
{
$bookname = $row['bookname'];
$booktype = $row['booktype'];
}
$query = "SELECT * FROM #@__story_chapter WHERE $addquery $orderby";

$dlist = new DataListCP();
$dlist->pageSize = 20;
$dlist->SetParameter("keyword", $keyword);
$dlist->SetParameter("bid", $bid);
$dlist->SetTemplate(dirname(__FILE__). "/templets/book/story_list_chapter.htm");
$dlist->SetSource($query);
$dlist->Display();
$dlist->Close();
?>