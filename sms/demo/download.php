<?php
     	/* 根据在该脚本中所用到的类名，自动加载当前脚本所在目录下对应该名类称的脚本文件 */
	function __autoload($className){
		include $className."_class.php";
	}
	isset($_GET["filename"]) or die("下载的文件名不存在！");  //判断是否将文件名称传递过来
	!empty($_GET["filename"]) or die("文件名为空");          //判断传递过来的文件名称是否为空

	$file=new Filec($_GET["filename"]);                   //根据文件名称创建文件对象
	$file->download();	                               //调用文件对象中的下载方法实现下载
?>
