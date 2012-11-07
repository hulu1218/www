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
 
//问答分类
$path = DEDEASK."/data/cache/asktype.inc";
if(file_exists($path)) {
    global $cfg_soft_lang;
    require_once($path);
    $asktypes = unserialize($asktypes);
}else{
    global $dsql;
    $query = "SELECT * FROM `#@__asktype` ORDER BY disorder DESC, id ASC";
    $dsql->Execute('me',$query);
    $tids = $tid2s = $asktypes = array();
    while($asktype = $dsql->getarray())
    {
    	if($asktype['reid'] == 0)
    	{
    		$tids[] = $asktype;
    	}else{
    		$tid2s[] = $asktype;
    	}
    
    }
    foreach($tids as $tid)
    {
    	$asktypes[] = $tid;
    	foreach($tid2s as $key => $tid2)
    	{
    		if($tid2['reid'] == $tid['id'])
    		{
    			$asktypes[] = $tid2;
    			unset($tid2s[$key]);
    		}
    	}
    }
    if(count($asktypes))
    {   
        $row = serialize($asktypes);
        $configstr = "<"."?php\r\n\$asktypes = '".$row."';";
        file_put_contents($path, $configstr);	
    }
}
?>