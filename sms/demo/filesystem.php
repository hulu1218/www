<html>
	<head><title>文件目录操作系统</title></head>
	<body bgcolor="#fafad2" link="#4C4C99" vlink="#4C4C99" alink="#4C4C99">
	<center><h1>文件目录操作系统</h1></center>
	<?php
         	/* 根据在该脚本中用到的类名，自动加载当前脚本所在目录下对应该名类称的脚本文件 */
		function __autoload($className){
			include $className."_class.php";
		}
         	/* 如果接收到了活动字符串，则先调用FileAction对象中的option方法进行处理 */
		if(isset($_POST["action"])){
			$fileaction=new FileAction($_POST["filename"], $_POST["action"]); 
			$fileaction->option(); 
		}
         	/* 如果接收到了目录名称则根据接收到的目录名称创建文件系统对象 */
		if(isset($_GET["dirname"])) {	
			$fs=new FileSystem($_GET["dirname"]);
		}else{        //否则默认创建当前目录的文件系统对象
			$fs=new FileSystem();
		}
		echo "<hr>";                               //输出一条分隔线
		$fs->getMenu();                            //调用文件系统中的方法获取菜单
		echo "<hr>";                               //再次输出一条分隔线
		$fs->fileList();                             //调用文件系统中的方法获取文件目录列表
		echo '<br><font size=2 color="#005500">';
		echo $fs->getDirInfo();                //调用文件系统中的方法获取文件和目录个数
		echo $fs->getDiskSpace();             //调用文件系统中的方法获取磁盘空间使用情况
		echo "</font>"
	?>

	<hr>
	<center>作者：高洛峰 版本：1.0 编写时间：2009-01-16</center>
	</body>
</html>

