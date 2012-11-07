<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php 
 if($_FILES['myfile']['error']>0){
	 echo "上传错误";
	 switch($_FILES['myfile']['error']){
		 case 1:
		 echo "max_size limited";
		 break;
		 
		 case 2:
		 echo "max limited";
		 break;
		 	 case 3:
		 echo "max limited";
		 break;
		 	 case 4:
		 echo "max limited";
		 break;
		     
		 
		 }
	 
	 exit ;
	 list ($maintype , $subtye)= explode ("/",$_FILES['myfile']['type']);
	 if($maintype = "text"){
		 echo "cant upload txt files";
		 exit ;
		 
		 }
		 $upfile = './uploads/'.time().$_FILES['myfile']['type'];
		 if(is_uploaded_file($_FILES['myfile']['tmp_name'])){
			 
			 if(!move_uploaded_file($_FILES['myfile']['tmp_name'],$upfile)){
				 echo "cant move to dir";
				 exit ;
				 }
			 }
			 else {
				 echo "不是一个合法文件：";
				 echo $_FILES['myfile']['name'];
				 exit;
				 
				 }
	 }

   echo "file ".$upfile." upload success size : ".$_FILES['myfile']['size']."";

?>
</body>
</html>