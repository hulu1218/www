<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 
 * @version        2011/2/11  沙羡 $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2011, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 *
 **/

$timestamp = time();
//采用同步的方式更新总结分排行(一分钟更新一次)
if(file_exists(DEDEASK.'/data/cache/scorestime.txt')) {
    $fp = fopen(DEDEASK.'/data/cache/scorestime.txt' ,'r');
    $scorestime = trim(fread($fp,64));
    fclose($fp);
    $hours = ($timestamp - $scorestime)/60;
    if($hours > 1)
    {
        transport();
        $fp = fopen(DEDEASK.'/data/cache/scorestime.txt',"w") or die("写入文件失败，请检查权限！");
        fwrite($fp,$timestamp);
        fclose($fp);	
    }
}else{
    transport();
    $fp = fopen(DEDEASK.'/data/cache/scorestime.txt',"w") or die("写入文件失败，请检查权限！");
    fwrite($fp,$timestamp);
    fclose($fp);	
}


//获取用户总积分
if(file_exists(DEDEASK."/data/cache/scores.inc")) {
    require_once(DEDEASK."/data/cache/scores.inc");
    $memberlists = unserialize($memberlists);
}else{
    $memberlists = "";
}

//处理周积分上升排行
$path = DEDEASK."/data/cache/week.txt";
if(file_exists($path)) {
    $fp = fopen($path ,'r');
    $week = trim(fread($fp,64));
    fclose($fp);
    //计算天数
    $day = ($timestamp - $week)/(24 * 3600);
    //如果天数大于7天,获取数据存储在缓冲文件中
    if($day > 7)
    {
        $query = "SELECT * FROM `#@__ask_scores` ORDER BY mscores DESC";
        $dsql->SetQuery($query);
        $dsql->Execute();
        $row = array();
        while($arr = $dsql->GetArray())
        {
            $row[] = $arr;
        }
        if(count($row))
        {   
            $row = serialize($row);
            $mpath = DEDEASK."/data/cache/week_scores.inc";
            $configstr = "<"."?php\r\n\$memberweeklists = '".$row."';";
            file_put_contents($mpath, $configstr);
            unset($row);
        }
        //清空数据库字段
        $query = "UPDATE `#@__ask_scores` SET mscores = '0'";
        $dsql->ExecuteNoneQuery($query);
        //重新将当前时间写入文件
        $fp = fopen($path,"w") or die("写入文件失败，请检查权限！");
        fwrite($fp,$timestamp);
        fclose($fp);	
    }else{
        if(file_exists(DEDEASK."/data/cache/week_scores.inc"))
        {
            require_once(DEDEASK."/data/cache/week_scores.inc");
            $memberweeklists = unserialize($memberweeklists);
        }else{
            $memberweeklists = "";
        }           
    }  
}else{
    $fp = fopen($path,"w") or die("写入文件失败，请检查权限！");
    fwrite($fp,$timestamp);
    fclose($fp);
    $memberweeklists = "";	
} 

function transport()
{    
    global $cfg_basehost;
    $path = $cfg_basehost.'/'.APPNAME."/?ct=index&ac=scores";
    $host = preg_replace('#http://#','',$cfg_basehost);
    $str = "";
    $fp = fsockopen($host,80,$errno,$errstr,30); 
    if(!$fp)
    {
        die("service.dedecms.com".$errstr.$errno);
    }else{ 
        fputs($fp, "POST $path HTTP/1.1\r\n"); 
        fputs($fp, "Host: $host\r\n"); 
        fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n"); 
        fputs($fp, "Content-length: ".strlen($str)."\r\n"); 
        fputs($fp, "Connection: close\r\n\r\n"); 
        fputs($fp, $str."\r\n\r\n"); 
        fclose($fp); 
    }  
}
?>