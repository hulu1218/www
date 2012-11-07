<?php
require_once(dirname(__FILE__). "/../member/config.php");
require_once(DEDEINC. "/datalistcp.class.php");
setcookie("ENV_GOBACK_URL", $dedeNowurl, time()+3600,"/");
CheckRank(0, 0);
$menutype = 'mydede';
if(!isset($action)) $action = '';

if(!isset($catid)) $catid = 0;

if(!isset($keyword)) $keyword = "";

if(!isset($orderby)) $orderby = 0;

if(!isset($cid)) $cid = 0;


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
$addquery = "";
$orderby = " order by b.bid desc ";
if($catid!=0)
{
    $addquery .= " And (b.bcatid='$catid' Or b.catid='$catid') ";
}
if($keyword!="")
{
    $addquery .= " And (b.bookname like '%$keyword%' Or b.author like '%$keyword%') ";
}
$query = "
   SELECT b.bid,b.catid,b.bookname,b.booktype,b.litpic,b.postnum,b.senddate,b.ischeck, c.id AS cid,c.classname FROM #@__story_books b
   LEFT JOIN #@__story_catalog c on c.id = b.catid WHERE mid={$cfg_ml->M_ID} AND b.bid>0 $addquery $orderby
";
$dlist = new DataListCP();
$dlist->pageSize = 20;
$dlist->SetParameter("keyword", $keyword);
$dlist->SetParameter("catid", $cid);
$dlist->SetParameter("orderby", $orderby);
$dlist->SetTemplate(dirname(__FILE__). "/templets/book/story_books.htm");
$dlist->SetSource($query);
$dlist->Display();
$dlist->Close();
