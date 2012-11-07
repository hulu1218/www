<?php
     	/* 根据在该脚本中所用到的类名，自动加载当前脚本所在目录下对应该名类称的脚本文件 */
	function __autoload($className){        
		include $className."_class.php";
	}
	isset($_GET["action"]) or die("没有任何活动发生！");   //如果没有任何用户活动则退出

     	/* 根据接收到的文件名称和活动字符串创建FileAction对象    */
	$fileaction=new FileAction($_GET["filename"], $_GET["action"]);  
	$fileaction->getFileInfo();   //调用FileAction对象中的getFileInfo()方法获取对象中的属性信息

	if(isset($_GET["dirname"]))    //如果接收到提供过来的目录名称则条件成立
		$fileaction->getForm("filesystem.php?dirname=".$_GET["dirname"]);  //获取用户操作表单界面
	else
		$fileaction->getForm("filesystem.php");                          //获取用户操作表单界面
?>

