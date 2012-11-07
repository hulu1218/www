<?php
	/* �ļ���ΪFilec_class.php                                           */ 
	/* ���ļ��࣬�̳���FileDir�࣬����չ��һЩ���ļ��йش���ĳ�Ա����  */
	class Filec extends FileDir{
         	/* ���췽�����ڴ����ļ�����ʱ����ʹ���ļ���Ա����   */
         	/* ����filename����Ҫ�ṩһ���ļ�����                  */
		function __construct($filename) {
			if(!file_exists($filename)){    //����ṩ���ļ���������ʹ��touch()�����������ļ�
				touch($filename) or die("�ļ�<b>".$filename."</b>����ʧ�ܣ�");
			}	
			$this->name=$filename;                             //Ϊ��Ա����name����ֵ
			$this->type=$this->getMIMEType(pathinfo($filename));   //Ϊ��Ա����type����ֵ
			$this->size=$this->toSize(filesize($filename));           //Ϊ��Ա����size����ֵ
			parent::__construct($filename);         //���ø��๹�췽��Ϊ������Ա���Ը���ֵ
		}
         	/*  ʵ�ָ����еĳ��󷽷�����дɾ���ļ��ķ����� */
         	/*  ����ļ�ɾ���ɹ�����True��ʧ���򷵻�False  */
		public function delFile() {
			if(unlink($this->name))              //ʹ���ļ�������unlink()ɾ���ļ�
				return true;                   //���ɾ���ɹ�����True
			 else 
				return false;                  //���ɾ��ʧ���򷵻�False
		}
	    	/*  ʵ�ָ����еĳ��󷽷�����д�����ļ��ķ����� */
         	/*  ����ļ����Ƴɹ�����True��ʧ���򷵻�False  */
		public function copyFile($dFile) {
			if(copy($this->name, $dFile))         //ʹ���ļ�������copy()�����ļ�
				return true;                   //����ļ����Ƴɹ�����True
			else
				return false;                 //����ļ�����ʧ���򷵻�False
		}
         	/*  ��ͻ��˷���ͷ�ļ�������ļ������ݣ�ʵ���ļ����� */
		public function download(){
			header('Content-Type: '.$this->type);    //����ͷ�ļ�����MIME����
			header('Content-Disposition: attachment; filename="'.$this->basename.'"');   //��������
			header('Content-Length: '.filesize($this->name));    //�����ļ���С��ͷ��Ϣ
			readfile($this->name);			               //���ļ����ݶ��������͸��ͻ���
		}
        	 /* �����ڶ����ⲿ���øú�����������ȡ�ļ��е��ı�����  */
         	/* ����ֵ���ļ��е�ȫ���ı�����                        */
		public function getText() {
			$fp=fopen($this->name, "r");        //��ֻ���ķ�ʽ���ļ�����ȡ�ļ�ָ��
			flock($fp, LOCK_SH);             //��ȡ�ļ��Ĺ�������
			$buffer="";                       //����һ�����ַ�������Ϊһ��������ʹ��
			while (!feof($fp)) {                //���û�е��ļ���β����һֱѭ����ȡ�ļ�
				$buffer.= fread($fp, 1024);     //�ڴδ��ļ��ж�ȡ1024���ֽ�׷�ӵ���������
			}
			flock($fp, LOCK_UN);            //��ȡ�ļ����ͷ�����
			fclose($fp);                      //�ر��ļ�ָ��
			return $buffer;                    //�����ļ��е�ȫ�������ı�
		}
         	/* �����ڶ����ⲿ���øú������������ļ��е�д���ı�����     */
         	/* ����text��д���ļ����ı������ַ���                        */
		public function setText($text) {
				$fp = fopen($this->name, "w");  //��ֻд�ķ�ʽ���ļ�����ȡ�ļ�ָ��
				if (flock($fp, LOCK_EX)) {    //��ȡ�ļ��Ķ�������
   					fwrite($fp, $text);        //��ָ�����ļ���д���ı�����
    					flock($fp, LOCK_UN);   //��ȡ�ļ����ͷ�����
				} else {                               
    					echo "���������ļ�!";   //�������ʧ���򷵻ش�����Ϣ
				}
				fclose($fp);	                 //�ر��ļ�ָ��
		}
	    	/* ֻ���ڶ����ڲ�����Ϊ��Ա����type��ֵ����ȡһЩ�ļ��ĳ���MIME����   */
         	/* ����path��ͨ��pathinfo()������ȡ���ļ���Ϣ����                         */
		private function getMIMEType($path) {   
			$fileMimeType="unkown";        //�洢�ļ���MIME���͵ı�����Ĭ��unkown
			switch($path["extension"]) {       //�ڲ��������л�ȡ�ļ�����չ������Ϊѡ������
				case "html":                      //����ļ�����չ��Ϊhtml����ҳ�ļ�
				case "htm":                       //����ļ�����չ��Ϊhtm����ҳ�ļ�
					$fileMimeType="text/html";    //�����ļ���MIME��Ϊtext/html
                       break;
				case "txt":                        //����ļ�����չ��Ϊtxt���ı��ļ�
				case "log":                        //����ļ�����չ��Ϊlog����־�ļ�
				case "php":                       //����ļ�����չ��Ϊphp�Ľű��ļ�
				case "phtml":                     //����ļ�����չ��Ϊphtml�Ľű��ļ�
					$fileMimeType="text/plain";    //�����ļ���MIME��Ϊtext/plain
					break;
				case "css":                       //����ļ�����չ��Ϊcss����ʽ���ļ�
					$fileMimeType="text/css";     //�����ļ���MIME��Ϊtext/css
					break;
				case "xml":                       //����ļ�����չ��Ϊxml��xml�ļ�
				case "xsl":                       //����ļ�����չ��Ϊxsl��xml��ʽ���ļ�
					$fileMimeType="text/xml";     //�����ļ���MIME��Ϊtext/xml
					break;
				case "js":                         //����ļ�����չ��Ϊjs��ǰ̨�ű��ļ�
					$fileMimeType="text/javascript"; //�����ļ���MIME��Ϊtext/javascrip
					break;
				case "gif":                        //����ļ�����չ��Ϊgif��ͼƬ�ļ�
					$fileMimeType="image/gif";    //�����ļ���MIME��Ϊimage/gif
					break;
				case "jpeg":                       //����ļ�����չ��Ϊjpeg��ͼƬ�ļ�
				case "jpg":                        //����ļ�����չ��Ϊjpg��ͼƬ�ļ�
					$fileMimeType="image/jpeg";   //�����ļ���MIME��Ϊimage/jpeg
					break;
				case "png":                        //����ļ�����չ��Ϊpng��ͼƬ�ļ�
					$fileMimeType="image/png";    //�����ļ���MIME��Ϊimage/png
					break;
				case "pdf":                         //����ļ�����չ��Ϊpdf��ʽ�ļ�
					$fileMimeType="application/pdf";  //�����ļ���MIME��Ϊapplication/pdf
					break;
				case "doc":                         //����ļ�����չ��Ϊdoc��office�ļ�
				case "dot":                         //����ļ�����չ��Ϊdot��office�ļ�
					$fileMimeType="application/msword";  //����MIME��Ϊapplication/msword
					break;
				case "zip":                         //����ļ�����չ��Ϊzip��ѹ���ļ�
					$fileMimeType="application/zip";  //�����ļ���MIME��Ϊapplication/zip
					break;
				case "rar":                         //����ļ�����չ��Ϊrar��ѹ���ļ�
					$fileMimeType="application/rar";  //�����ļ���MIME��Ϊapplication/rar
					break;	
				case "swf":                         //����ļ�����չ��Ϊswf��flash�ļ�
					$fileMimeType="application/x-shockwave-flash";	//����flashMIME����
					break;	
				case "bin":                         //����ļ�����չ��Ϊbin�Ķ������ļ�
				case "exe":                         //����ļ�����չ��Ϊext�Ķ������ļ�
				case "com":                        //����ļ�����չ��Ϊcom�Ķ������ļ�
				case "dll":                          //����ļ�����չ��Ϊdll�Ķ������ļ�
				case "class":                        //����ļ�����չ��Ϊclass�Ķ������ļ�
					$fileMimeType="application/octet-stream";  //�����ļ���MIME�������
					break;
			}
			return $fileMimeType;                   //�����ļ����ض�MIME����
		}
	}
?>
