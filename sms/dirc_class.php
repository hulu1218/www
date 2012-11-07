<?php
	/* �ļ���ΪDirc_class.php                                            */ 
	/* ��Ŀ¼�࣬�̳���FileDir�࣬����չ��һЩ��Ŀ¼�йش���ĳ�Ա����  */
	class Dirc extends FileDir{
         	/* ���췽�����ڴ���Ŀ¼����ʱ����ʹ��Ŀ¼��Ա����      */
         	/* ����filename����Ҫ�ṩһ���ļ�����                   */
		function __construct($dirname=".") {
			if(!file_exists($dirname)){    //����ṩ��Ŀ¼��������ʹ��mkdir()����������Ŀ¼
				mkdir($dirname) or die("Ŀ¼<b>".$dirname."</b>����ʧ�ܣ�");
			}	
			$this->name=$dirname;                          //Ϊ��Ա����name����ֵ
			$this->type="directory/";                         //Ϊ��Ա����type����ֵ
			$this->size=$this->toSize($this->dirSize($dirname));   //Ϊ��Ա����size����ֵ
			parent::__construct($dirname);      //���ø��๹�췽��Ϊ������Ա���Ը���ֵ
		}
         	/*  ʵ�ָ����еĳ��󷽷�����дɾ���ļ��ķ����� */
         	/*  ���Ŀ¼ɾ���ɹ�����True��ʧ���򷵻�False  */
		public function delFile() {
			$this->delDir($this->name);       //���ö����ڲ��Զ����ɾ��Ŀ¼����
			if(!file_exists($this->name))       //���Ŀ��Ŀ¼��������ɾ����
				return true;                //���Ŀ¼��ɾ�����򷵻���
			else
				return false;               //���Ŀ¼�����ڣ���ɾ��ʧ�ܷ��ؼ�
		}
		
	    	/*  ʵ�ָ����еĳ��󷽷�����д�����ļ��ķ����� */
         	/*  ���Ŀ¼���Ƴɹ�����True��ʧ���򷵻�False  */
		public function copyFile($dFile){
			$this->copyDir($this->name, $dFile);  //���ö����ڲ��Զ��帴��Ŀ¼�ķ���
			if(file_exists($dFile))               //���Ŀ��Ŀ¼�������Ƴɹ�
				return true;                   //���Ŀ¼���Ƴɹ��򷵻���
			else
				return false;                  //���Ŀ¼����ʧ���򷵻ؼ�
		}

        	 /* �ݹ��ȡĿ¼ռ�ô�С��Ŀ¼�������ļ���С�����ۼ���һ�𣬼�Ŀ¼��С */
        	 /* ����directory���ṩ��Ҫ��ȡ��С��Ŀ¼                               */
         	/* ����ֵdir_size�����������ļ���С����                              */
		private function dirSize($directory) {     
			$dir_size=0;                                  //���������洢�ļ���С�ı���
			if($dir_handle=opendir($directory)) {             //��Ŀ¼������Ŀ¼ָ��
				while($filename=@readdir($dir_handle)) {    //ѭ������Ŀ¼�е��ļ�
					if($filename!="." && $filename!="..") {  //ȥ��.��..Ŀ¼
						$subFile=$directory."/".$filename;  //��Ŀ¼�е��ļ��͵�ǰĿ¼����
						if(is_dir($subFile))               //�����������Ŀ¼
							$dir_size+=$this->dirSize($subFile);  //�����Լ�������Ŀ¼��С
						if(is_file($subFile))              //������������ļ�
							$dir_size+=filesize($subFile);  //ֱ�ӻ�ȡ�ļ���С���ۼ�����
					}
				}     
		    		closedir($dir_handle);		               //�ر�Ŀ¼
				return $dir_size;                         //����Ŀ¼��С
			}
		}

         	/* �ݹ�ɾ��Ŀ¼�е��ļ�����ɾ����Ŀ¼       */
         	/* ����directory���ṩҪ��ɾ����Ŀ¼         */
		private function delDir($directory) {         
			if(file_exists($directory)) {                        //�жϱ�ɾ����Ŀ¼�Ƿ����
				if($dir_handle=@opendir($directory)) {         //��Ŀ¼������Ŀ¼ָ��
					while($filename=readdir($dir_handle)) {   //ѭ������Ŀ¼�е��ļ�
						if($filename!="." && $filename!="..") {   //ȥ��.��..Ŀ¼
							$subFile=$directory."/".$filename;   //����Ŀ¼��
							if(is_dir($subFile))                //�����������Ŀ¼
								$this->delDir($subFile);       //�����Լ�ɾ����Ŀ¼
							if(is_file($subFile))               //������������ļ�
								unlink($subFile);            //ֱ��ɾ���ļ�
						}
					}
					closedir($dir_handle);                      //�ر�Ŀ¼��Դ
					rmdir($directory);                         //ɾ����Ŀ¼
				}
			}
		}

         	/* �ݹ鸴��Ŀ¼��Ŀ¼�µ��ļ����µ�λ��       */
        	 /* ����dirSrc���ṩҪ�����Ƶ�ԴĿ¼            */
         	/* ����dirTo���ṩҪ������Ŀ¼��Ŀ��λ��       */
		private function copyDir($dirSrc, $dirTo) {       
			if(is_file($dirTo)) {                      //���Ŀ��Ŀ¼��һ���ļ����ܸ���
				echo "Ŀ�겻��Ŀ¼���ܴ���!!";     //���������Ϣ
				return;                           //�˳�����
			}
			if(!file_exists($dirTo)) {                 //���Ŀ��Ŀ¼�������򴴽���
				mkdir($dirTo);                    //ʹ��mkdir()��������һ����Ŀ¼
			}
			if($dir_handle=@opendir($dirSrc)) {                 //��ԴĿ¼������Ŀ¼ָ��
				while($filename=readdir($dir_handle)) {         //ѭ������Ŀ¼�е��ļ�
					if($filename!="." && $filename!="..") {     //ȥ��.��..Ŀ¼
						$subSrcFile=$dirSrc."/".$filename;     //��ȡԴĿ¼����Ŀ¼�ļ���
						$subToFile=$dirTo."/".$filename;      //��ȡĿ��Ŀ¼����Ŀ¼�ļ���
						if(is_dir($subSrcFile))                     //�ж����ļ��Ƿ���Ŀ¼
							$this->copyDir($subSrcFile, $subToFile); //�����Լ�������Ŀ¼
						if(is_file($subSrcFile))                    //�ж����ļ��Ƿ����ļ�
							copy($subSrcFile, $subToFile);        //ֱ�Ӹ��Ƶ�Ŀ��λ��
					}
				}
				closedir($dir_handle);                            //�ر�Ŀ¼��Դ
			}
		}
	}
?>
