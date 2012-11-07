<?php  if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 
 * @version        2011/2/11  沙羡 $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2011, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 *
 **/
//清楚html样式
function ihtmlspecialchars($string)
{
	if(is_array($string))
	{
		foreach($string as $key => $val)
		{
			$string[$key] = ihtmlspecialchars($val);
		}
	} else
	{
		$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
		str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
	}
	return $string;
}

function iheader($string, $replace = true, $http_response_code = 0)
{
	$string = str_replace(array("\r", "\n"), array('', ''), $string);
	if(empty($http_response_code) || PHP_VERSION < '4.3' )
	{
		@header($string, $replace);
	} else
	{
		@header($string, $replace, $http_response_code);
	}
	if(preg_match('/^\s*location:/is', $string))
	{
		exit();
	}
}

//存储cookie
function makecookie($var, $value, $life = 0, $prefix = 0)
{
	global $cookiepre, $cookiedomain, $cookiepath, $timestamp, $_SERVER;
	setcookie(($prefix ? $cookiepre : '').$var, $value,
	$life ? $timestamp + $life : 0, $cookiepath,
	$cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}

//清楚cookie
function clearcookies()
{
	global $uid, $username, $pw, $adminid;
	makecookie('auth', '', -86400 * 365);
	$uid = $adminid = 0;
	$username = $pw = '';
}

//分页
function multi($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 10, $autogoto = TRUE, $simple = FALSE)
{
	$multipage = '';
	if(stristr($mpurl,'?')) $mpurl .= '&amp;';
	else  $mpurl .= '?';
	$realpages = 1;
	if($num > $perpage)
	{
		$offset = 2;
		$realpages = @ceil($num / $perpage);
		$pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;
		if($page > $pages)
		{
			$from = 1;
			$to = $pages;
		} else
		{
			$from = $curpage - $offset;
			$to = $from + $page - 1;
			if($from < 1)
			{
				$to = $curpage + 1 - $from;
				$from = 1;
				if($to - $from < $page)
				{
					$to = $page;
				}
			} elseif($to > $pages)
			{
				$from = $pages - $page + 1;
				$to = $pages;
			}
		}

		$multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="'.$mpurl.'page=1" class="first">1 ...</a>' : '').
		($curpage > 1 && !$simple ? '<a href="'.$mpurl.'page='.($curpage - 1).'" class="prev">&lsaquo;&lsaquo;</a>' : '');
		for($i = $from; $i <= $to; $i++)
		{
			$multipage .= $i == $curpage ? '<strong>'.$i.'</strong>' : '<a href="'.$mpurl.'page='.$i.'">'.$i.'</a>';
		}

		$multipage .= ($curpage < $pages && !$simple ? '<a href="'.$mpurl.'page='.($curpage + 1).'" class="next">&rsaquo;&rsaquo;</a>' : '').
		($to < $pages ? '<a href="'.$mpurl.'page='.$pages.'" class="last">... '.$realpages.'</a>' : '').
		(!$simple && $pages > $page && 0>1 ? '<div class="pselect"><input type="text" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location=\''.$mpurl.'page=\'+this.value; return false;}" /></div>' : '').'</div>';

		$multipage = $multipage ? '<div class="pages">'.(!$simple ? '<div class="pcount">&nbsp;'.$num.'&nbsp;</div>' : '').'<div class="plist">'.$multipage.'</div>' : '';
	}
	return $multipage;
}

//获取等级
function gethonor($score)
{
    global $dsql;
    //积分头衔
    if(isset($GLOBALS['honors']))
    { 
        $honors = $GLOBALS['honors'];
    }else{
        if(file_exists(DEDEDATA."/cache/honors.inc")) {
            require_once(DEDEDATA."/cache/honors.inc");
            $honors = unserialize($honors);
            $GLOBALS['honors'] = $honors;
        }else{
            $honors = array();
            $dsql->setquery("SELECT id, titles, icon, integral FROM `#@__scores` ORDER BY integral DESC");
            $dsql->execute();
            while($row = $dsql->getarray())
            {
            	$honors[] = $row;
            }
            $GLOBALS['honors'] = $honors;
            $row = serialize($honors);
            $mpath = DEDEDATA."/cache/honors.inc";
            $configstr = "<"."?php\r\n\$honors = '".$row."';";
            file_put_contents($mpath, $configstr);
            //unset($row);
        }
    }
	foreach($honors as $honor)
	{
		if($honor['integral'] <= $score) return $honor['titles'];
	}
}


/**
 *  清理附件，如果关连的文档ID，先把上一批附件传给这个文档ID
 *
 * @access    public
 * @param     string  $aid  文档ID
 * @param     string  $title  文档标题
 * @return    empty
 */
function clearmyaddon($aid=0, $title='',$type=0)
{
    global $dsql;
    $cacheFile = DEDEDATA.'/cache/addon-'.session_id().'.inc';
    $_SESSION['bigfile_info'] = array();
    $_SESSION['file_info'] = array();
    if(!file_exists($cacheFile))
    {
        return ;
    }
    if($type == 1) $wheresql = ',type=1';
    else $wheresql = ',type=0';
    
    //把附件与文档关连
    if(!empty($aid))
    {
        include($cacheFile);
        foreach($myaddons as $addons)
        {
			if(!empty($title)) {
				$dsql->ExecuteNoneQuery("Update `#@__uploads_ask` set arcid='$aid',title='$title'{$wheresql} where aid='{$addons[0]}'");
			}
			else {
			    //$query = "Update `#@__uploads_ask` set arcid='$aid' where aid='{$addons[0]}' ";
				$dsql->ExecuteNoneQuery("Update `#@__uploads_ask` set arcid='$aid'{$wheresql} where aid='{$addons[0]}' ");
			}
        }
    }
    @unlink($cacheFile);
}

//获取来路地址
function geturl($type = "")
{
    if ( isset( $_SERVER['REQUEST_URI'] ) ) {
        $url = $_SERVER['REQUEST_URI'];
    } elseif ( isset( $_SERVER['SCRIPT_NAME'] ) && isset( $_SERVER['QUERY_STRING'] ) ) {
        $url = $_SERVER['SCRIPT_NAME'].'?'.$_SERVER['QUERY_STRING'];
    } elseif ( isset( $_SERVER['SCRIPT_NAME'] ) ) {
        $url = $_SERVER['SCRIPT_NAME'];
    } elseif ( isset( $_SERVER['PHP_SELF'] ) && isset( $_SERVER['QUERY_STRING'] ) ) {
        $url = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
    } elseif ( isset( $_SERVER['PHP_SELF'] ) ) {
        $url = $_SERVER['PHP_SELF'];
    } else {
        $url = '';
    }
    if(!empty($type)) $url = "http://".$_SERVER['HTTP_HOST'].$url;
    return $url;
}

//处理伪静态地址
function makerewurl($arrs = array(),$id = 'id',$url = "")
{
    if(count($arrs) > 0)
    {
        foreach ($arrs as $key => $val) {
            $arrs[$key]['qurl'] = $url.$val[$id].'.html';
        }
        return $arrs;
    }
}

//处理非伪静态地址
function makeurl($arrs = array(),$id = 'id',$url = "?ct=question&askaid=")
{
    if(count($arrs) > 0)
    {
        foreach ($arrs as $key => $val) {
            $arrs[$key]['qurl'] = $url.$val[$id];
        }
        return $arrs;
    }
}

//采用独立编辑器
function GetFck($fname,$fvalue,$nheight="350",$etype="Ask")
{
    global $cfg_ask_isdomain,$cfg_ask_directory;
    require_once(LIB.'/FCK/fckeditor.php');
    $fck = new FCKeditor($fname);
    if($cfg_ask_isdomain == 'Y') $fck->BasePath = '/libraries/FCK/';
    else $fck->BasePath = $cfg_ask_directory.'/libraries/FCK/';
    $fck->Width        = '100%' ;
    $fck->Height       = $nheight ;
    $fck->ToolbarSet   = $etype;
    $fck->Value = $fvalue ;
    echo $fck->CreateHtml();
}

?>