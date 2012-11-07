<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>



<?php 

 $file=fopen("http://www.lampbrother.net/","r");
 while(!feof($file)){
	 $line =fgets($file);
	 if(preg_match("/<title>(.*)<\/title>/",$line,$out)){
		 
		 $title=$out[1];
		 break;
		 
		 
		 }
	 
	 }

fclose($file);
echo $title;
?>
<body>
</body>
</html>