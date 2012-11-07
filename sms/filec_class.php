<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
    <?php
	        include 'file_dir.php'; 
	         class filec extends FileDir{
				 
				 function _construct($filename){
					 if(file_existss($filename)){
						 touch ($filename) or die("creat file .$filename. failed");
						 
						 }
					 $this->name = $filename;
					 $this->type =$this->getMIMEType(pathinfo($filename));
					 $this->size= $this->toSize(filesize($filename));
					 parent :: _construct($filename);
					 
					 
					 
					 }
				 public function delFile(){
					 if(unlink($this->name))
						 
						 return true ;
						 else 
						 
						 return false;
						 
					   
					 }
				 public function copuFile($dFile){
					 
					 if(copy($this->name,$dFile))
					 return true;
					 else
					 return false;
					 }
			   public function download	(){
				   header("content-type:".$this->type);
				   header("content-disposition:attachment; filename=".$this->basename."");
				   header("content-Length:'.filesize($this->name).'");
				   readfile($this->name);
				   }	 
				  public function getText(){
					  $fp =fopen($this->name,"r"); 
					  
					  flock($fp,LOCK_SH);
					  $buffer="";
					   while(!feof($fp)){
						   $buffer=fread($fp,1024);
						   
						   }
						 
						flock($fp,LOCK_UN);	 
						fclose($fp);
						return $buffer;
					  } 
					public function setText(){
						
						
						$fp = fopen($this->name,"w");
						if(flock($fp,LOCK_EX)){
							fwrite($fp,$text);
							flock($fp,LOCK_UN);
							
							
							
							}
							else 
							{echo "cant lock file";}
							fclose($fp); 
						}
					private function getMUMEType($path){
						$fileMimeType="unknown";
						switch($path["extension"]){
							
							
							case "html":
							case "htm":
							$fileMimeType="text/html";
							break;
							case "txt":
							case "log":
							case "php":
							case "phtml":                     //如果文件是扩展名为phtml的脚本文件
					$fileMimeType="text/plain";    //设置文件的MIME类为text/plain
					break;
				case "css":                       //如果文件是扩展名为css的样式表文件
					$fileMimeType="text/css";     //设置文件的MIME类为text/css
					break;
				case "xml":                       //如果文件是扩展名为xml的xml文件
				case "xsl":                       //如果文件是扩展名为xsl的xml样式表文件
					$fileMimeType="text/xml";     //设置文件的MIME类为text/xml
					break;
				case "js":                         //如果文件是扩展名为js的前台脚本文件
					$fileMimeType="text/javascript"; //设置文件的MIME类为text/javascrip
					break;
				case "gif":                        //如果文件是扩展名为gif的图片文件
					$fileMimeType="image/gif";    //设置文件的MIME类为image/gif
					break;
				case "jpeg":                       //如果文件是扩展名为jpeg的图片文件
				case "jpg":                        //如果文件是扩展名为jpg的图片文件
					$fileMimeType="image/jpeg";   //设置文件的MIME类为image/jpeg
					break;
				case "png":                        //如果文件是扩展名为png的图片文件
					$fileMimeType="image/png";    //设置文件的MIME类为image/png
					break;
				case "pdf":                         //如果文件是扩展名为pdf格式文件
					$fileMimeType="application/pdf";  //设置文件的MIME类为application/pdf
					break;
				case "doc":                         //如果文件是扩展名为doc的office文件
				case "dot":                         //如果文件是扩展名为dot的office文件
					$fileMimeType="application/msword";  //设置MIME类为application/msword
					break;
				case "zip":                         //如果文件是扩展名为zip的压缩文件
					$fileMimeType="application/zip";  //设置文件的MIME类为application/zip
					break;
				case "rar":                         //如果文件是扩展名为rar的压缩文件
					$fileMimeType="application/rar";  //设置文件的MIME类为application/rar
					break;	
				case "swf":                         //如果文件是扩展名为swf的flash文件
					$fileMimeType="application/x-shockwave-flash";	//设置flashMIME类型
					break;	
				case "bin":                         //如果文件是扩展名为bin的二进制文件
				case "exe":                         //如果文件是扩展名为ext的二进制文件
				case "com":                        //如果文件是扩展名为com的二进制文件
				case "dll":                          //如果文件是扩展名为dll的二进制文件
				case "class":                        //如果文件是扩展名为class的二进制文件
					$fileMimeType="application/octet-stream";  //设置文件的MIME类二进制
					break;
							
						
							
							
							}
						return $fileMimeType;
						
						}
					 }
				
	
	
	
	?>

<body>
</body>
</html>