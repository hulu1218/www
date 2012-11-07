<?php
     	/* �ļ�����FileSystem_class.php                               */
     	/* �ļ�ϵͳ�����࣬�����˺��ļ�ϵͳ������ص����Ժʹ����� */
	class FileSystem {
		private $serverpath;         //����web���������ĵ���Ŀ¼
		private $path;              //���浱ǰ�ļ�ϵͳ��������Ŀ¼
		private $pagepath;          //��ǰ�ű�ҳ������Ŀ¼
		private $prevpath;          //����������ҳ�����һ��Ŀ¼
		private $files=array();       //���浱ǰ������Ŀ¼�µ��ļ���Ŀ¼���������
		private $filenum=0;         //����ͳ�Ƶ�ǰ������Ŀ¼�µ��ļ�����ĸ���
		private $dirnum=0;         //����ͳ�Ƶ�ǰ������Ŀ¼�µ�Ŀ¼����ĸ���

      		/* ���췽�����ڴ����ļ�ϵͳ����ʱ����ʹ���ļ�ϵͳ����ĳ�Ա����      */
         	/* ����path����Ҫ�ṩ������Ŀ¼��Ŀ¼λ�����ƣ�Ĭ��Ϊ��ǰĿ¼        */
		function __construct($path=".") {
			$this->serverpath = $_SERVER["DOCUMENT_ROOT"]."/"; //��ʹ��Web��������Ŀ¼
			$this->path=$path;                                   //��ʹ���û�������Ŀ¼
			$this->prevpath=dirname($path);                       //��ʹ����ǰ�ű�����Ŀ¼
			$this->pagepath=dirname($_SERVER["SCRIPT_FILENAME"]);  //��ʹ����һ��Ŀ¼
			$dir_handle=opendir($path);                //���ļ�ϵͳ��Ҫ�����Ŀ¼
			while($file=readdir($dir_handle)) {           //����Ŀ¼�µ����ж���
				if($file!="." && $file!="..") {           //ȥ��Ŀ¼�µ�ǰĿ¼����һ��Ŀ¼
					$filename=$path."/".$file;         //��Ŀ¼���͵�ǰĿ¼�µ��ļ�������
					if(is_dir($filename)){            //�����������Ŀ¼
						$tmp=new Dirc($filename);  //����һ��Ŀ¼����
						$this->dirnum++;          //��ͳ��Ŀ¼���ĳ�Ա����ֵ�Լ�1
					}
					if(is_file($filename)){            //������������ļ�
						$tmp=new Filec($filename);  //����һ���ļ�����
						$this->filenum++;          //��ͳ���ļ�������Ա����ֵ�Լ�1
					}
					array_push($this->files, $tmp);  //�������������ļ���Ŀ¼����ѹ������
				}
			}
			closedir($dir_handle);  			    //�ر�Ŀ¼��Դָ��
		}

		public function getServerPath() {               //���ʸ÷�����ȡWeb�������ĵ���Ŀ¼
			return $this->serverpath;
		}

		public function getPagePath(){                //���ʸ÷�����ȡ��ǰ�ű����ڵ�Ŀ¼
			return $this->pagepath;
		}

		public function getPrevPath(){                //���ʸ÷�����ȡ������Ŀ¼����һ��Ŀ¼
			return $this->prevpath;
		}
		
		public function getDirInfo(){     //���ʸ÷�����ȡ������Ŀ¼�µ��ļ���Ŀ¼����ĸ���
			$str="��Ŀ¼�¹����ļ�<b>".($this->dirnum+$this->filenum)."</b>����";
			$str.="����Ŀ¼<b>".$this->dirnum."</b>��,";
			$str.="�ļ�<b>".$this->filenum."</b>����";
			return $str;
		}
		
		public function getDiskSpace() {  //���ʸ÷�����ȡ������Ŀ¼���ڵĴ��̿ռ�ʹ����Ϣ
			$totalSpace=round(disk_total_space($this->prevpath)/pow(1024,2),2);
			$freeSpace=round(disk_free_space($this->prevpath)/pow(1024,2),2);
			$usedSpace=$totalSpace-$freeSpace;		
			$str="���ڷ������ܴ�С��<b>".$totalSpace."</b>MB��";
			$str.="���ã�<b>".$usedSpace."</b>MB��";
			$str.="���ã�<b>".$freeSpace."</b>MB��";
			return $str;             //���ش��̿ռ�ʹ�õ���Ϣ�ַ���
		} 
 
		public function getMenu() {    //���ʸ÷�����ȡ�ļ�ϵͳ�Ĳ����˵�
			$menu='<a href="contral.php?action=upload&dirname='.$this->path.'">�ϴ��ļ�</a>||';
			$menu.='<a href="contral.php?action=adddir&dirname='.$this->path.'">�½��ļ���</a>||';
			$menu.='<a href="contral.php?action=addfile&dirname='.$this->path.'">�����ļ�</a>||';
			$menu.='<a href="filesystem.php?dirname='.$this->getPrevPath().'">�ϼ�Ŀ¼</a>||';
			$menu.='<a href="filesystem.php?dirname='.$this->getPagePath().'">��ʼĿ¼</a>||';
			$menu.='<a href="filesystem.php?dirname='.$this->getServerPath().'">�ĵ���Ŀ¼</a>';
			echo $menu;           //����ļ�ϵͳ�����˵�
		}
         	/* ���ʸ÷�����ȡ�ļ�ϵͳ������Ŀ¼�µ��ļ���Ŀ¼�����б��Ա����ʽ��� */
		public function fileList(){  
			echo '<table border="0" cellspacing="1" cellpadding="1" width="100%">';
			echo '<tr bgcolor="#b0c4de">';
			echo '<th>����</th> <th>����</th> <th>��С</th> <th>�޸�ʱ��</th> <th>����</th>';
			echo '</tr>';
			if(is_array($this->files)) {          //�ж���������Ŀ¼���Ƿ����ļ�����Ŀ¼����
				$trcolor="#dddddd";          //��ʹ�û����б�����ɫ
				foreach($this->files as $file) {  //�����������Ŀ¼���ļ���Ϣ
					if($trcolor=="#dddddd")  //���õ�˫�н��汳����ɫ
						$trcolor="#ffffff";
					else
						$trcolor="#dddddd";
					echo '<tr style="font-size:14px;" bgcolor='.$trcolor.'>';
					echo '<td>'.$file->getType().'</td>';         //����ļ�����
					echo '<td>'.$file->getBaseName().'</td>';     //����ļ�����
					echo '<td>'.$file->getSize().'</td>';          //����ļ���С
					echo '<td>'.$file->getMtime().'</td>';        //����ļ�������޸�ʱ��
					echo '<td>'.$this->operate("contral.php",$file).'</td>'; //����ļ��Ĳ���ѡ��
					echo '</tr>';
				}
			}
			echo '</table>';
		}

         	/* ���ʸ÷�����ȡ�ļ�ϵͳ�е����ļ���Ŀ¼����Ĳ���ѡ��             */
         	/* ����cpage���ṩһ�����ƽű������û�����ĳ�����ʱת��Ĵ���ҳ��  */
         	/* ����file���ṩһ���ļ���Ŀ¼���� */
		private function operate($cpage, $file) {
			list($maintype,$subtype)=explode("/",$file->getType());   //���ļ���MIME���ͷ���
			$query='filename='.$file->getName().'&dirname='.$this->path;      //��ȡ��ѯ�ַ���
			$operstr='<a href="'.$cpage.'?action=copy&'.$query.'"> ���� </a>';     //��ȡ��������
			$operstr.='/<a href="'.$cpage.'?action=rename&'.$query.'"> ������ </a>'; //����������
			$operstr.='/<a href="'.$cpage.'?action=delete&'.$query.'"> ɾ�� </a>';    //ɾ������
			switch($maintype){       //�����ļ������������ļ����������е�ĳ�����
				case 'directory':      //�����Ŀ¼�������ṩ����Ŀ¼�Ĳ�������
					$operstr.='/<a href="filesystem.php?dirname='.$file->getName().'"> ���� </a>';
					break;
				case 'text':          //������ı��ļ����ṩ�ɱ༭�����صĲ�������
					$operstr.='/<a href="'.$cpage.'?action=edit&'.$query.'"> �༭ </a>';
					$operstr.='/<a href="download.php?filename='.$file->getName().'"> ����</a>';
					break;
				case 'image':         //�����ͼ���ļ����ṩ�����غ�Ԥ���Ĳ�������
					$operstr.='/<a href="'.$file->getName().'"> Ԥ�� </a>';
					$operstr.='/<a href="download.php?filename='.$file->getName().'"> ����</a>';
					break;
				default:            //�������ļ����Ͷ��ṩ���صĹ���
					$operstr.='/<a href="download.php?filename='.$file->getName().'"> ����</a>';
			}
			return $operstr;		    //���ص����ļ���Ŀ¼��������в���ѡ���ַ���
		}
	}
?>
