<?php
/**
 * @version        $Id: story.php 1 9:02 2010年9月25日Z 蓝色随想 $
 * @package        DedeCMS.Module.Book
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

require_once(dirname(__FILE__). "/../include/common.inc.php");
require_once(dirname(__FILE__). './include/story.view.class.php');
$id = intval($id);
if(empty($id)) ParamError();

$bv = new BookView($id, 'content');

//检测是否收费图书
$arcrank = $bv->Fields['arcrank'];
$freenum = $bv->Fields['freenum'];
if($freenum > -1)
{
    require_once(DEDEINC. "/memberlogin.class.php");
    $ml = new MemberLogin();
    if($ml->M_Rank < $arcrank)
    {
        $row = $bv->dsql->GetOne("SELECT chapnum FROM #@__story_chapter WHERE id='{$bv->Fields['chapterid']}' ");
        $chapnum = $row['chapnum'];
        $member_err = '';

        //确定当前内容属于收费章节
        if($chapnum > $freenum)
        {
            if(empty($ml->M_ID))
            {
                $member_err = "NoLogin";
            }
            else
            {
                $row = $bv->dsql->GetOne("SELECT * FROM #@__story_viphistory WHERE mid='{$ml->M_ID}' ");
                if(!is_array($row) && $ml->M_Money < $cfg_book_money)
                {
                    $member_err = "NoEnoughMoney";
                }
            }
            //权限错误
            if($member_err!='')
            {
                $row = $bv->dsql->GetOne("SELECT membername FROM #@__arcrank WHERE rank = '$arcrank' ");
                if(!is_array($row))
                {
                    $membername = '';
                }
                else
                {
                    $membername = $row['membername'];
                }
                require_once(DEDEROOT. '/book/templets/'.$cfg_df_style.'/book_member_err.htm');
                $bv->Close();
                exit();
            }

            //扣点
            else
            {
                $row = $bv->dsql->GetOne("SELECT mid FROM #@__story_viphistory WHERE cid = '$id' ");
                if($row['mid']!=$ml->M_ID)
                {
                    $rs = $bv->dsql->ExecuteNoneQuery("INSERT INTO #@__story_viphistory(cid,mid) VALUES('{$id}','{$ml->M_ID}') ");
                    if($rs)
                    {
                        $bv->dsql->ExecuteNoneQuery("UPDATE #@__member SET money=money-{$cfg_book_money} WHERE mid='{$ml->M_ID}' ");
                    }
                }
            }
        }
    }
}
$bv->Display();
$bv->Close();
