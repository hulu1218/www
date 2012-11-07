<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php 

                      class FileSystem{
						       
						       private $serverPath;
							   private $path;
							   private $pagePath;
							   private $prevpath;
							   private $files=array();
							   private $filenum=0;
							   private $dirnum=0;
							   
							   function _construct($path="."){
								   $this->serverPath = $_SERVER['DOCUMENT_ROOT'].'/';
								   $this->path=$path;
								   $this->prevpath=dirname($path);
								   $this->pagepath=dirname($_SERVER['SCRIPT_FILENAME']);
								   while($file = readdir($dir_handle)){
									  if($file!="." && $file=".."){
										  $tmp = new Dirc($filename);
										  
										  
										  } 
									   
									   
									   }
								   
								   }
						  
						  
						  
						  }   



?>
</body>
</html>