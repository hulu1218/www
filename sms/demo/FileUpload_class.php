<?php
	/* �ļ���ΪFileUpload_class.php                                      */ 
	/* �����ļ��ϴ���صĳ�Ա���Ժͳ�Ա����������һ��                  */
	class FileUpload {
		private $filePath;                        //�����ϴ��ļ����������Ŀ��·��
		private $fileField;                       //�����$_FILES[$fileField]�л�ȡ�ϴ��ļ���Ϣ
		private $originName;                     //�����ϴ��ļ���Դ�ļ���
		private $tmpFileName;                   //�����ϴ��ļ�����ʱ�ļ���
		private $fileType;                       //�����ϴ��ļ������ͣ�ͨ���ļ���׺���ƣ�
		private $fileSize;                        //�����ϴ��ļ���С
		private $newFileName;                   //�����ϴ��ļ������ļ���
         	//��һ�����飬���ڱ����ϴ��ļ�������ļ����ͣ������ļ���׺�����飩
		private $allowType = array('txt','html','php','js','css','jpg','gif','png','doc','swf','rar','zip'); 
		private $maxSize = 1000000000;           //�����ļ��ϴ�����󳤶ȣ�Ĭ��Ϊ1M
		private $isUserDefName = false;           //�ļ��ϴ����Ƿ�����û��Զ����ļ���
		private $userDefName;                   //�����û��Զ�����ϴ��ļ�����
		private $isRandName = false;              //�ϴ��ļ��Ƿ�ʹ������ļ�����
		private $randName;                      //����ϵͳ����������ϴ��ļ�����
		private $errorNum = 0;                   //����ϵͳ�Զ���Ĵ���ţ�Ĭ��ֵΪ0
		private $isCoverModer = true;             //�ϴ��ļ��Ƿ񸲸�ԭ�е��ļ���Ĭ��ֵΪtrue

         	/*  ���췽���������ϴ��ļ�����ʱΪ���ֳ�Ա�����б���ֵ                   */
         	/*  ����options: �ṩһ�����飬�����±�Ϊ��Ա�������ƣ�Ԫ��ֵΪ�������õ�ֵ */
		function __construct($options=array()) {
			      $this->setOptions($options);    //�������ݷ���Ϊ�ϴ��ļ��������б�ֵ
		}

		/* �ڶ����ⲿ���ø÷������ϴ��ļ�                       */
         	/* ����filefield:�ṩȫ�ֱ�������$_FILES�ǵĵڶ�ά����    */
         	/* ����ֵ: ����ļ��ϴ��ɹ�����True�����ʧ���򷵻�False */
		function uploadFile($filefield) {
        		$this->setOption('errorNum',0);         //Ϊ����λ���ó�ֵ
        		$this->setOption('fileField', $filefield);   //ͨ���������ó�Ա����fileField��ֵ
			$this->setFiles();                    //���ó�Ա���������ļ���Ϣ
			$this->checkValid();                 //�ж��ϴ��ļ��Ƿ���Ч
			$this->checkFilePath();               //��鱣���ϴ��ļ���·���Ƿ���ȷ
			$this->setNewFileName();             //���ϴ��ļ�����Ϊ���ļ���
			if ($this->errorNum < 0)              //����ϴ��ļ��Ƿ����
				return $this->errorNum;          //��������˳����������ش����
			return $this->copyFile();              //���ϴ��ļ��ƶ���ָ��λ��
		}

         	/* Ϊ��Ա�����б���ֵ                                                    */
         	/* ����options: �ṩһ�����飬�����±�Ϊ��Ա�������ƣ�Ԫ��ֵ��Ϊ�������õ�ֵ */
		private function setOptions($options = array()) {
			foreach ($options as $key => $val) {     //������������
if(!in_array($key,array('filePath','fileField','originName','allowType','maxSize','isUserDefName','userDefName','isRandName','randName')))    //���������±��Ƿ�ͳ�Ա����ͬ��
					continue;                 //���������û����ȷ���±����˳�ѭ��
				$this->setOption($key, $val);     //�������е�ֵ������Ӧ�����±�ĳ�Ա����
			}
		}
		
         	/* ��$_FILES������ȡֵ��������Ӧ�ĳ�Ա����  */
		private function setFiles() {
			if ($this->getFileErrorFromFILES() != 0) {  //����ϴ��ļ��Ƿ���ִ���
				$this->setOption('errorNum', -1);    //����д��������ô�����Ϊ-1
				return $this->errorNum;            //�˳�����������ִ��
			}
              		//���ö����ڲ�����Ϊ�����ϴ��ļ�Դ���ĳ�Ա���Ը�ֵ 
			$this->setOption('originName', $this->getFileNameFromFILES()); 
              		//���ö����ڲ�����Ϊ�����ϴ��ļ���ʱ�ļ����ĳ�Ա���Ը�ֵ     
			$this->setOption('tmpFileName', $this->getTmpFileNameFromFILES());
              		//���ö����ڲ�����Ϊ�����ϴ��ļ����͵ĳ�Ա���Ը�ֵ
			$this->setOption('fileType', $this->getFileTypeFromFILES());
              		//���ö����ڲ�����Ϊ�����ϴ��ļ���С�ĳ�Ա���Ը�ֵ
			$this->setOption('fileSize', $this->getFileSizeFromFILES());
		}
         	/* Ϊָ���ĳ�Ա���Ը�ֵ              */
         	/* ����key: �ṩ�����Ա�������ı��� */
         	/* ����val: �ṩ��ҪΪ��Ա���Ը���ֵ  */
		private function setOption($key, $val) {
			$this->$key = $val;                 //Ϊ��Ա���Ը�ֵ
		}
         
         	/* Ϊ�ϴ��ļ������µ��ļ�����  */
		private function setNewFileName() {
              		//������ʳ�����ļ������Ҳ������û��Զ����ļ����������ļ���Ϊ�ϴ��ļ�Դ��
			if ($this->isRandName == false && $this->isUserDefName == false) {
				$this->setOption('newFileName', $this->originName);
              			//����ʳ�����ļ������������û��Զ����ļ��������ϴ��ļ�������Ϊ����ļ���
			} else if ($this->isRandName == true && $this->isUserDefName == false) {
				$this->setOption('newFileName', $this->proRandName().'.'.$this->fileType);
              			//������ʳ�����ļ������������û��Զ����ļ��������ϴ��ļ���Ϊ�û��Զ�������
			} else if ($this->isRandName == false && $this->isUserDefName == true) {
				$this->setOption('newFileName', $this->userDefName);
			} else {
				$this->setOption('errorNum', -4);    //���������������������ô����Ϊ-4
			}
		}
 	
		/* ����ϴ��Ƿ���Ч  */
		private function checkValid() {
			$this->checkFileSize();       //����ϴ��ļ���С�Ƿ񳬳���Χ
			$this->checkFileType();      //����ϴ��ļ������Ƿ�Ϊ���������
		}
		/* ����ϴ��ļ������Ƿ�Ϊ��������� */
		private function checkFileType() {
			if (!in_array($this->fileType, $this->allowType))  //�ж��ļ������Ƿ��ڳ��������������
				$this->setOption('errorNum', -2);          //������ǺϷ������ͣ����ô����Ϊ-2
			return $this->errorNum;                      //���ش����
		}
         
         	/* ����ϴ��ļ���С�Ƿ񳬳���Χ */
		private function checkFileSize() {
			if ($this->fileSize > $this->maxSize)           //�ж��ļ���С�Ƿ񳬹�����ֵ
				$this->setOption('errorNum', -3);         //���������Χ�����ô����Ϊ-3
			return $this->errorNum;                     //���ش����
		}
		
         	/* ��鱣���ϴ��ļ���·���Ƿ���Ч   */
		private function checkFilePath() {
			if (!file_exists($this->filePath)) {            //�ж�ָ����·���Ƿ����
				if ($this->isCoverModer) {            //�ж��Ƿ���ø���ģʽ
					$this->makePath();             //���·���������򴴽������ϴ��ļ�·��
				} else {
					$this->setOption('errorNum', -6);  //������Ǹ���ģʽ�����ô����Ϊ-6
				}
			}
		}
		
         	/* ��������ϴ��ļ������ļ����� */
		private function proRandName() {
              		//�������ַ�����ȡ������ϴ��ļ����ļ������ַ���
			$tmpStr = "abcdefghijklmnopqrstuvwxyz0123456789";  
			$str = "";                             //�������ڱ����ļ������ַ�������
			for ($i=0; $i<8; $i++) {                 //ѭ��8�������$tmpStr�ַ���ȡ��8���ַ�
				$num = rand(0, strlen($tmpStr));     //��$tmpStr�ַ������ȷ�Χ�����ȡһ����
				$str .= $tmpStr[$num];             //��$tmpStr�ַ�����ȡ��һ��ָ�����ַ�
			}    
			return $str;                           //���������8���ַ���ɵ��ַ���
		}
		
         	/* ���������ϴ��ļ���·��   */
		private function makePath() {
			if (!@mkdir($this->filePath, 0755)) {      //����Ŀ¼������Ȩ��Ϊ0755
				$this->setOption('errorNum', -7);     //�������ʧ�ܣ����ô����Ϊ-7
			}
		}
         
         	/* ���ϴ��ļ�����ʱĿ¼�и��Ƶ�ָ������λ�� */
		private function copyFile() {
			$filePath = $this->filePath;
			if ($filePath[strlen($filePath)-1] != '/') {  //�ж�Ŀ��Ŀ¼���Ƿ����Ŀ¼�ָ���š�/��
				$filePath .= '/';                 //��Ŀ¼�����ӡ�/������
			}
			
			$filePath .= $this->newFileName;       //����Ŀ������ļ���
			if (!@move_uploaded_file($this->tmpFileName, $filePath)) {  //�ƶ��ϴ��ļ�����λ��
				$this->setOption('errorNum', -5);   //����ƶ�ʧ�������ô����Ϊ-5
			}
			return $this->errorNum;               //���ش�����
		}
		
         	/*  ��ȫ�ֱ�������$_FILES�л�ȡ�ϴ��ļ��Ĵ����� */
		private function getFileErrorFromFILES() {
			return $this->fileField['error'];          //���������еĴ�����
		}
		
         	/* ��ȡ�ļ��ĺ�׺��  */
		private function getFileTypeFromFILES() {
			$str = $this->fileField['name'];             //�������е����Ƹ�������$str
			$aryStr = split("\.", $str);                  //���ļ��������ַ����� ./���ָ�
			$ret = strtolower($aryStr[count($aryStr)-1]);  //ȡ���ļ��ĺ�׺���ַ�����תΪȫСд
			return $ret;                             //�����ϴ��ļ��ĺ�׺����������(.)
		}
		
         	/* ��ȫ�ֱ�������$_FILES�л�ȡ�ϴ��ļ������� */
		private function getFileNameFromFILES() {
			return $this->fileField['name'];             //���������е��ϴ��ļ�����
		}
		/* ��ȫ�ֱ�������$_FILES�л�ȡ�ϴ��ļ�����ʱ�ļ����� */
		private function getTmpFileNameFromFILES() {
			return $this->fileField['tmp_name'];       //���������е��ϴ��ļ�����ʱ�ļ�����
		}
		
         	/* ��ȫ�ֱ�������$_FILES�л�ȡ�ϴ��ļ��Ĵ�С */
		private function getFileSizeFromFILES() {
			return $this->fileField['size'];            //���������е��ϴ��ļ��Ĵ�С
		}
		
         	/* ���ݴ����ŷ��ض�Ӧ�Ĵ�����Ϣ  */
		public function getErrorMsg() {
			$str = "�ϴ��ļ����� : ";             //���������С��0���ϴ��ļ�����
			switch ($this->errorNum) {
				case -1:                        //���-1: δ֪�Ĵ���
					$str .= "δ֪����";
					break;
				case -2:                        //���-2: ��������ϴ��ļ�����
					$str .= "δ��������";
					break;
				case -3:                        //���-3: �ϴ��ļ������˳���Ĵ�С
					$str .= "�ļ�����";
					break;
				case -4:                        //���-4: �����ļ���ʱ����
					$str .= "�����ļ�������";
					break;
				case -5:                        //���-5: �ϴ�û�гɹ�
					$str .= "�ϴ�ʧ��";
					break;
				case -6:                       //���-6: �����ϴ��ļ���Ŀ¼������
					$str .= "Ŀ¼������";
					break;
				case -7:                       //���-7: ���������ϴ��ļ���Ŀ¼ʧ��
					$str .= "����Ŀ¼ʧ��";
					break;
			}
			return $str;                        //�����ϴ��ļ�ʱ�������Ϣ
		}
	}
?>
