<?php
/**
 * @version        $Id: story_list_content.php 1 9:02 2010年9月25日Z 蓝色随想 $
 * @package        DedeCMS.Module.Book
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

require_once(dirname(__FILE__). "/../member/config.php");
require_once(DEDEINC. "/datalistcp.class.php");
setcookie("ENV_GOBACK_URL", $dedeNowurl, time()+3600,"/");
CheckRank(0, 0);
$menutype = 'mydede';
if(!isset($action)) $action = '';

if(!isset($booktype)) $booktype = '-1';

if(!isset($keyword)) $keyword = "";

if(!isset($orderby)) $orderby = 0;

if(!isset($bookid)) $bookid = 0;


if(!isset($chapid)) $chapid = 0;

$addquery = "";
$orderby = " order by ct.id desc ";
if($booktype!='-1') $addquery .= " And ct.booktype='$booktype' ";

if($keyword!="") $addquery .= " And (ct.bookname like '%$keyword%' Or ct.title like '%$keyword%') ";

if($bookid!=0) $addquery .= " And ct.bookid='$bookid' ";

if($chapid!=0) $addquery .= " And ct.chapterid='$chapid' ";

if(empty($bookname)) $bookname = '';

if(empty($booktype)) $booktype = '0';

$query = "
   SELECT ct.id,ct.title,ct.bookid,ct.chapterid,ct.sortid,ct.bookname,ct.addtime,ct.booktype,c.chaptername,c.chapnum FROM #@__story_content  ct
   LEFT JOIN #@__story_chapter c ON c.id = ct.chapterid WHERE c.mid=$cfg_ml->M_ID AND ct.id>0 $addquery $orderby
";
$row = $dsql->GetOne("SELECT bookname,booktype FROM  #@__story_books WHERE bid = '$bookid'");
if(is_array($row)){
$bookname = $row['bookname'];
$booktype = $row['booktype'];
}
//echo $query;
$dlist = new DataListCP();
$dlist->pageSize = 20;
$dlist->SetParameter("keyword", $keyword);
$dlist->SetParameter("booktype", $booktype);
$dlist->SetParameter("bookit", $bookid);
$dlist->SetParameter("chapid", $chapid);
$dlist->SetTemplate(dirname(__FILE__). "/templets/book/story_list_content.htm");
$dlist->SetSource($query);
$dlist->Display();
$dlist->Close();
