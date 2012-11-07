<?php
	/* 文件名：FileAction_class.php                                         */ 
	/* 在该类中声明了在对文件系统操作时,所触发的事件处理有关的属性和方法  */
	class FileAction {
		private $file;                   //保存需要处理的文件或目录对象
		private $action;                 //用于保存用户所发出的操作请求动作字符串
   
      		/* 构造方法，在创建目录对象时，初使化目录成员属性      */
         	/* 参数filename：需要提供一个文件名称                   */
		/* 参数action：需要提供用户操作文件系统的活动字符串     */
		function __construct($filename="", $action="") { 
			if(!empty($filename)){                      //判断创建对象时是否提供文件名
				if(is_dir($filename)){                  //判断提供的第一个参数是否是目录
					$this->file=new Dirc($filename);    //通过目录类创建目录对象
				}
				if(is_file($filename)){                 //判断提供的第一个参数是否是文件
					$this->file=new Filec($filename);   //通过文件类创建文件对象
				}
			}
			if(!empty($action)) {                      //判断提供的第二个参数是否为空
				$this->action=$action;                //如果不为空则初使化action属性
			}
		}
         	/* 通过调用该方法获取用户操作表单界面                  */
         	/* 参数submitPage：提供用户操作表单时提交的位置  */
		function getForm($submitPage){
			echo '<form action="'.$submitPage.'" method="post" enctype="multipart/form-data">';
			if(isset($_GET["filename"]))    //判断用户在操作时是否在URL中提供文件名
				echo '<input type="hidden" name="filename" value="'.$this->file->getName().'">';
			if(isset($_GET["dirname"]))    //判断用户在操作时是否在URL中提供目录名
				echo '<input type="hidden" name="dirname" value="'.$_GET["dirname"].'">';		
			switch($this->action){        //根据用户不同的活动提供给用户不同的操作表单界面
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
         	/* 通过调用该方法对用户的活动进行处理                 */
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
         	/* 通过调用该方法获取所操作的对象属性信息 */
		function getFileInfo() {
			if(empty($this->file)) {    
				echo "<center><h1>创建新的文件或目录</h1></center>";
			}else{	
				echo "<center><h1>文件或目录操作</h1></center>";
				echo $this->file;
			}
		}
	}
?>
