<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php 
      include 'fileUpload_class.php';
	  include 'filec_class.php';
	 
	  class FileAction{
		  private $file;
		  private $action;
		  function _construct($filename="",$action=""){
			  
			  if(!empty($filename)){
				  $this->file=new Dirc($filename);
				  
				  
				  }
			  if(is_file($filename)){
				  $this->file = new Filec($filename);
				  
				  
				  }
				  if (!empty($action)){
					  $this->action=$action;
					  
					  
					  }
			  }
		  
		  function getForm($submitPage){
			  echo '<form action="'.$submitPage.'" method="post" enctype="multipart/form-data">';
			  if(isset($_GET['filename'])){
				             echo '<input type="hidden" name="filename" value=".$this->file->getName().">';     
			  if(isset($_GET["dirname"])){
				  
				             echo '<input type="hidden" name="dirname" value="'.$_GET['dirname'].'">';
							 
				  }	  
				  switch($this->action){
					  
					  case "copy":      //如果用户是复制活动则提供复制操作的表单界面
					echo '<input type="hidden" name="action" value="copy">';
					echo '将文件<b>'.$this->file->getName().'</b>复制到:';
					echo '<input type="text" name="tofile">';
					echo '<input type="submit" value="复制">';
					break;
				case "rename":    //如果用户是移动或重命名活动则提供相应的操作表单界面
					echo '<input type="hidden" name="action" value="rename">';
					echo '将文件<b>'.$this->file->getName().'</b>移动/重命名为:';
					echo '<input type="text" name="tofile">';
					echo '<input type="submit" value="移动/重命名">';
					break;
				case "delete":     //如果用户是删除活动则提供删除操作的表单界面
					echo '<input type="hidden" name="action" value="delete">';
					echo '将文件<b>'.$this->file->getName().'</b>删除:';
					echo '<input type="submit" value="删除">';
					echo '<a href="'.$submitPage.'">取消</a>';
					break;
				case "edit":       //如果用户是编辑文件活动则提供编辑操作的表单界面
					echo '<input type="hidden" name="action" value="edit">';
					echo '<center><h3>编辑'.$this->file->getName().'</h3>';
					echo '<textarea rows="25" cols="100" name="content">';
					echo $this->file->getText();
					echo '</textarea><br>';
					echo '<input type="submit" value="修改文件">';
					echo '<input type="reset" value="重置">';
					echo '<a href="'.$submitPage.'">取消</a></center>';
					break;
				case "addfile":   //如果用户是添加文件活动则提供添加文件操作的表单界面
					echo '<input type="hidden" name="action" value="addfile">';
					echo '<center>文件名：<input type="text" size=30 name="filename">';
					echo '<br><textarea rows="25" cols="100" name="content">';
					echo '</textarea><br>';
					echo '<input type="submit" value="创建文件">';
					echo '<input type="reset" value="重置">';
					echo '<a href="'.$submitPage.'">取消</a></center>';
					break;
				case "adddir":    //如果用户是添加目录活动则提供添加目录操作的表单界面
					echo '<input type="hidden" name="action" value="adddir">';
					echo '目录名：<input type="text" size=30 name="newdirname">';
					echo '<input type="submit" value="创建目录">';
					echo '<a href="'.$submitPage.'">取消</a>';
					break;
				case "upload":   //如果用户是上传文件活动则提供上传操作的表单界面
					echo '<input type="hidden" name="action" value="upload">';
					echo '上传文件：<input type="file" name="upfile">';
					echo '<input type="submit" value="上传">';
					echo '<a href="'.$submitPage.'">取消</a>';
					break;
				
					  }
				  echo '</form>';
				  }
			
			  
			  }
		  		function option() {
			switch($this->action){    //根据不同的用户活动进行处理
				case "copy":       //如果用户提供复制文件的活动则进行文件复制处理
					if(isset($_POST["tofile"]) && !empty($_POST["tofile"])){
						if($_POST["dirname"])
							$toFile=$_POST["dirname"].'/'.$_POST["tofile"];
						else
							$toFile=$_POST["tofile"];
						$this->file->copyFile($toFile) or die("文件复制失败！");
					}
					break;
				case "rename":   //如果用户提供重命名或移动文件的活动则进行文件移动处理
					if(isset($_POST["tofile"]) && !empty($_POST["tofile"])){
						if($_POST["dirname"])
							$toFile=$_POST["dirname"].'/'.$_POST["tofile"];
						else
							$toFile=$_POST["tofile"];
						$this->file->moveFile($toFile) or die("文件移动失败！");
					}
					break;
				case "delete":    //如果用户提供删除文件的活动则进行文件删除处理
					$this->file->delFile() or die("文件移动失败！");
					break;
				case "edit":      //如果用户提供编辑文件的活动则进行文件编辑处理
					$this->file->setText($_POST["content"]);
					break;
				case "addfile":   //如果用户提供添加文件的活动则进行文件添加处理
					$newfilename=$_POST["dirname"].'/'.$_POST["filename"];
					if(file_exists($newfilename)) {
						echo "文件".$newfilename."已经存在！";
					}else{
						$newfile=new Filec($newfilename);
						$newfile->setText($_POST["content"]);
					}
					break;
				case "adddir":   //如果用户提供添加目录的活动则进行目录添加处理
					$newfilename=$_POST["dirname"].'/'.$_POST["newdirname"];
					if(file_exists($newfilename)) {
						echo "目录".$newfilename."已经存在！";
					}else {
						$newdir=new Dirc($newfilename);
					}
					break;
				case "upload":   //如果用户提供上传文件的活动则进行文件上传处理
					$tmp = new FileUpload(array('filePath'=>$_POST["dirname"]));
					$res = $tmp->uploadFile($_FILES["upfile"]);
					if ($res < 0) {
						echo $tmp->getErrorMsg().'<br>';
						exit;
					}
					break;
			}
		}
		function getFileinfo(){
			if(empty($this->file)){
				echo "<center><h1>创建新的文件或者目录<h1></center>";
				
				}
			else 
			{echo '<center> <h1>file and dir oper </h1></center>';
			echo $$this->file;                                                                                                                                                                     
	
			}
			
			
			}
		  }





?>
</body>
</html>