
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title>无标题文档</title>
</head>

<body>

<?php



// 梦网短信平
include_once("Client.php");
 $a = split("\n", $_POST['phone']);

$b=$_POST['content'];

	$smsInfo['server_url'] = 'http://ws.montnets.com:7902/MWGate/wmgw.asmx?wsdl';
	$smsInfo['user_name'] = 'J20513';
	$smsInfo['password'] = '598987';
	$smsInfo['pszSubPort'] = '*';
	
	$content = $b;
	$mobiles = $a;
	/*
	print_r(implode(",",$mobiles));
	echo "<br>";
	print_r(count($mobiles));
	exit;
	*/
	$sms = new Client($smsInfo['server_url'],$smsInfo['user_name'],$smsInfo['password']);
	$sms->pszSubPort = $smsInfo['pszSubPort'];
	$sms->setOutgoingEncoding("UTF-8");
	$result = $sms->sendSMS($mobiles,$content);

	$c = $result['msg'];
	$url = "http://127.0.0.1/sms/index.php?res=$c";
	
	
	
	
	
	
?>
  <script>
   window.location.href='<?php echo $url?>';
  
  </script>


</body>
</html>
