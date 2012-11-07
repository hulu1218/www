<?php
	/* �ļ�����FileAction_class.php                                         */ 
	/* �ڸ������������ڶ��ļ�ϵͳ����ʱ,���������¼������йص����Ժͷ���  */
	class FileAction {
		private $file;                   //������Ҫ������ļ���Ŀ¼����
		private $action;                 //���ڱ����û��������Ĳ����������ַ���
   
      		/* ���췽�����ڴ���Ŀ¼����ʱ����ʹ��Ŀ¼��Ա����      */
         	/* ����filename����Ҫ�ṩһ���ļ�����                   */
		/* ����action����Ҫ�ṩ�û������ļ�ϵͳ�Ļ�ַ���     */
		function __construct($filename="", $action="") { 
			if(!empty($filename)){                      //�жϴ�������ʱ�Ƿ��ṩ�ļ���
				if(is_dir($filename)){                  //�ж��ṩ�ĵ�һ�������Ƿ���Ŀ¼
					$this->file=new Dirc($filename);    //ͨ��Ŀ¼�ഴ��Ŀ¼����
				}
				if(is_file($filename)){                 //�ж��ṩ�ĵ�һ�������Ƿ����ļ�
					$this->file=new Filec($filename);   //ͨ���ļ��ഴ���ļ�����
				}
			}
			if(!empty($action)) {                      //�ж��ṩ�ĵڶ��������Ƿ�Ϊ��
				$this->action=$action;                //�����Ϊ�����ʹ��action����
			}
		}
         	/* ͨ�����ø÷�����ȡ�û�����������                  */
         	/* ����submitPage���ṩ�û�������ʱ�ύ��λ��  */
		function getForm($submitPage){
			echo '<form action="'.$submitPage.'" method="post" enctype="multipart/form-data">';
			if(isset($_GET["filename"]))    //�ж��û��ڲ���ʱ�Ƿ���URL���ṩ�ļ���
				echo '<input type="hidden" name="filename" value="'.$this->file->getName().'">';
			if(isset($_GET["dirname"]))    //�ж��û��ڲ���ʱ�Ƿ���URL���ṩĿ¼��
				echo '<input type="hidden" name="dirname" value="'.$_GET["dirname"].'">';		
			switch($this->action){        //�����û���ͬ�Ļ�ṩ���û���ͬ�Ĳ���������
				case "copy":      //����û��Ǹ��ƻ���ṩ���Ʋ����ı�����
					echo '<input type="hidden" name="action" value="copy">';
					echo '���ļ�<b>'.$this->file->getName().'</b>���Ƶ�:';
					echo '<input type="text" name="tofile">';
					echo '<input type="submit" value="����">';
					break;
				case "rename":    //����û����ƶ�������������ṩ��Ӧ�Ĳ���������
					echo '<input type="hidden" name="action" value="rename">';
					echo '���ļ�<b>'.$this->file->getName().'</b>�ƶ�/������Ϊ:';
					echo '<input type="text" name="tofile">';
					echo '<input type="submit" value="�ƶ�/������">';
					break;
				case "delete":     //����û���ɾ������ṩɾ�������ı�����
					echo '<input type="hidden" name="action" value="delete">';
					echo '���ļ�<b>'.$this->file->getName().'</b>ɾ��:';
					echo '<input type="submit" value="ɾ��">';
					echo '<a href="'.$submitPage.'">ȡ��</a>';
					break;
				case "edit":       //����û��Ǳ༭�ļ�����ṩ�༭�����ı�����
					echo '<input type="hidden" name="action" value="edit">';
					echo '<center><h3>�༭'.$this->file->getName().'</h3>';
					echo '<textarea rows="25" cols="100" name="content">';
					echo $this->file->getText();
					echo '</textarea><br>';
					echo '<input type="submit" value="�޸��ļ�">';
					echo '<input type="reset" value="����">';
					echo '<a href="'.$submitPage.'">ȡ��</a></center>';
					break;
				case "addfile":   //����û�������ļ�����ṩ����ļ������ı�����
					echo '<input type="hidden" name="action" value="addfile">';
					echo '<center>�ļ�����<input type="text" size=30 name="filename">';
					echo '<br><textarea rows="25" cols="100" name="content">';
					echo '</textarea><br>';
					echo '<input type="submit" value="�����ļ�">';
					echo '<input type="reset" value="����">';
					echo '<a href="'.$submitPage.'">ȡ��</a></center>';
					break;
				case "adddir":    //����û������Ŀ¼����ṩ���Ŀ¼�����ı�����
					echo '<input type="hidden" name="action" value="adddir">';
					echo 'Ŀ¼����<input type="text" size=30 name="newdirname">';
					echo '<input type="submit" value="����Ŀ¼">';
					echo '<a href="'.$submitPage.'">ȡ��</a>';
					break;
				case "upload":   //����û����ϴ��ļ�����ṩ�ϴ������ı�����
					echo '<input type="hidden" name="action" value="upload">';
					echo '�ϴ��ļ���<input type="file" name="upfile">';
					echo '<input type="submit" value="�ϴ�">';
					echo '<a href="'.$submitPage.'">ȡ��</a>';
					break;
				}

			echo '</form>';
		}
         	/* ͨ�����ø÷������û��Ļ���д���                 */
		function option() {
			switch($this->action){    //���ݲ�ͬ���û�����д���
				case "copy":       //����û��ṩ�����ļ��Ļ������ļ����ƴ���
					if(isset($_POST["tofile"]) && !empty($_POST["tofile"])){
						if($_POST["dirname"])
							$toFile=$_POST["dirname"].'/'.$_POST["tofile"];
						else
							$toFile=$_POST["tofile"];
						$this->file->copyFile($toFile) or die("�ļ�����ʧ�ܣ�");
					}
					break;
				case "rename":   //����û��ṩ���������ƶ��ļ��Ļ������ļ��ƶ�����
					if(isset($_POST["tofile"]) && !empty($_POST["tofile"])){
						if($_POST["dirname"])
							$toFile=$_POST["dirname"].'/'.$_POST["tofile"];
						else
							$toFile=$_POST["tofile"];
						$this->file->moveFile($toFile) or die("�ļ��ƶ�ʧ�ܣ�");
					}
					break;
				case "delete":    //����û��ṩɾ���ļ��Ļ������ļ�ɾ������
					$this->file->delFile() or die("�ļ��ƶ�ʧ�ܣ�");
					break;
				case "edit":      //����û��ṩ�༭�ļ��Ļ������ļ��༭����
					$this->file->setText($_POST["content"]);
					break;
				case "addfile":   //����û��ṩ����ļ��Ļ������ļ���Ӵ���
					$newfilename=$_POST["dirname"].'/'.$_POST["filename"];
					if(file_exists($newfilename)) {
						echo "�ļ�".$newfilename."�Ѿ����ڣ�";
					}else{
						$newfile=new Filec($newfilename);
						$newfile->setText($_POST["content"]);
					}
					break;
				case "adddir":   //����û��ṩ���Ŀ¼�Ļ�����Ŀ¼��Ӵ���
					$newfilename=$_POST["dirname"].'/'.$_POST["newdirname"];
					if(file_exists($newfilename)) {
						echo "Ŀ¼".$newfilename."�Ѿ����ڣ�";
					}else {
						$newdir=new Dirc($newfilename);
					}
					break;
				case "upload":   //����û��ṩ�ϴ��ļ��Ļ������ļ��ϴ�����
					$tmp = new FileUpload(array('filePath'=>$_POST["dirname"]));
					$res = $tmp->uploadFile($_FILES["upfile"]);
					if ($res < 0) {
						echo $tmp->getErrorMsg().'<br>';
						exit;
					}
					break;
			}
		}
         	/* ͨ�����ø÷�����ȡ�������Ķ���������Ϣ */
		function getFileInfo() {
			if(empty($this->file)) {    
				echo "<center><h1>�����µ��ļ���Ŀ¼</h1></center>";
			}else{	
				echo "<center><h1>�ļ���Ŀ¼����</h1></center>";
				echo $this->file;
			}
		}
	}
?>
