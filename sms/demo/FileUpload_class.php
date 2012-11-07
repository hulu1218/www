<?php
	/* 文件名为FileUpload_class.php                                      */ 
	/* 将与文件上传相关的成员属性和成员方法声明在一起                  */
	class FileUpload {
		private $filePath;                        //保存上传文件将被保存的目的路径
		private $fileField;                       //保存从$_FILES[$fileField]中获取上传文件信息
		private $originName;                     //保存上传文件的源文件名
		private $tmpFileName;                   //保存上传文件的临时文件名
		private $fileType;                       //保存上传文件的类型（通过文件后缀名称）
		private $fileSize;                        //保存上传文件大小
		private $newFileName;                   //保存上传文件的新文件名
         	//是一个数组，用于保存上传文件允许的文件类型（保存文件后缀名数组）
		private $allowType = array('txt','html','php','js','css','jpg','gif','png','doc','swf','rar','zip'); 
		private $maxSize = 1000000000;           //允许文件上传的最大长度，默认为1M
		private $isUserDefName = false;           //文件上传后，是否采用用户自定义文件名
		private $userDefName;                   //保存用户自定义的上传文件名称
		private $isRandName = false;              //上传文件是否使用随机文件名称
		private $randName;                      //保存系统随机命名的上传文件名称
		private $errorNum = 0;                   //保存系统自定义的错误号，默认值为0
		private $isCoverModer = true;             //上传文件是否覆盖原有的文件，默认值为true

         	/*  构造方法，创建上传文件对象时为部分成员属性列表赋初值                   */
         	/*  参数options: 提供一个数组，数组下标为成员属性名称，元素值为属性设置的值 */
		function __construct($options=array()) {
			      $this->setOptions($options);    //调用内容方法为上传文件的属性列表赋值
		}

		/* 在对象外部调用该法处理上传文件                       */
         	/* 参数filefield:提供全局变量数组$_FILES是的第二维数组    */
         	/* 返回值: 如果文件上传成功返回True，如果失败则返回False */
		function uploadFile($filefield) {
        		$this->setOption('errorNum',0);         //为错误位设置初值
        		$this->setOption('fileField', $filefield);   //通过参数设置成员属性fileField的值
			$this->setFiles();                    //调用成员方法设置文件信息
			$this->checkValid();                 //判断上传文件是否有效
			$this->checkFilePath();               //检查保存上传文件的路径是否正确
			$this->setNewFileName();             //将上传文件设置为新文件名
			if ($this->errorNum < 0)              //检查上传文件是否出错
				return $this->errorNum;          //如果出错退出函数并返回错误号
			return $this->copyFile();              //将上传文件移动到指定位置
		}

         	/* 为成员属性列表赋初值                                                    */
         	/* 参数options: 提供一个数组，数组下标为成员属性名称，元素值即为属性设置的值 */
		private function setOptions($options = array()) {
			foreach ($options as $key => $val) {     //遍历参数数组
if(!in_array($key,array('filePath','fileField','originName','allowType','maxSize','isUserDefName','userDefName','isRandName','randName')))    //检查数组的下标是否和成员属性同名
					continue;                 //如果数组中没有正确的下标则退出循环
				$this->setOption($key, $val);     //将数组中的值赋给对应数组下标的成员属性
			}
		}
		
         	/* 从$_FILES数组中取值，赋给对应的成员属性  */
		private function setFiles() {
			if ($this->getFileErrorFromFILES() != 0) {  //检查上传文件是否出现错误
				$this->setOption('errorNum', -1);    //如果有错误则设置错误标号为-1
				return $this->errorNum;            //退出函数不向下执行
			}
              		//调用对象内部函数为保存上传文件源名的成员属性赋值 
			$this->setOption('originName', $this->getFileNameFromFILES()); 
              		//调用对象内部函数为保存上传文件临时文件名的成员属性赋值     
			$this->setOption('tmpFileName', $this->getTmpFileNameFromFILES());
              		//调用对象内部函数为保存上传文件类型的成员属性赋值
			$this->setOption('fileType', $this->getFileTypeFromFILES());
              		//调用对象内部函数为保存上传文件大小的成员属性赋值
			$this->setOption('fileSize', $this->getFileSizeFromFILES());
		}
         	/* 为指定的成员属性赋值              */
         	/* 参数key: 提供保存成员属性名的变量 */
         	/* 参数val: 提供将要为成员属性赋的值  */
		private function setOption($key, $val) {
			$this->$key = $val;                 //为成员属性赋值
		}
         
         	/* 为上传文件设置新的文件名称  */
		private function setNewFileName() {
              		//如果不允充随机文件名并且不允许用户自定义文件名，则新文件名为上传文件源名
			if ($this->isRandName == false && $this->isUserDefName == false) {
				$this->setOption('newFileName', $this->originName);
              			//如果允充随机文件名但不允许用户自定义文件名，则上传文件新名称为随机文件名
			} else if ($this->isRandName == true && $this->isUserDefName == false) {
				$this->setOption('newFileName', $this->proRandName().'.'.$this->fileType);
              			//如果不允充随机文件名但不允许用户自定义文件名，则上传文件名为用户自定义名称
			} else if ($this->isRandName == false && $this->isUserDefName == true) {
				$this->setOption('newFileName', $this->userDefName);
			} else {
				$this->setOption('errorNum', -4);    //以上条件都不成立，设置错误号为-4
			}
		}
 	
		/* 检查上传是否有效  */
		private function checkValid() {
			$this->checkFileSize();       //检查上传文件大小是否超出范围
			$this->checkFileType();      //检查上传文件类型是否为允许的类型
		}
		/* 检查上传文件类型是否为允许的类型 */
		private function checkFileType() {
			if (!in_array($this->fileType, $this->allowType))  //判断文件类型是否在充许的类型数组中
				$this->setOption('errorNum', -2);          //如果不是合法的类型，设置错误号为-2
			return $this->errorNum;                      //返回错误号
		}
         
         	/* 检查上传文件大小是否超出范围 */
		private function checkFileSize() {
			if ($this->fileSize > $this->maxSize)           //判断文件大小是否超过充许值
				$this->setOption('errorNum', -3);         //如果超过范围，设置错误号为-3
			return $this->errorNum;                     //返回错误号
		}
		
         	/* 检查保存上传文件的路径是否有效   */
		private function checkFilePath() {
			if (!file_exists($this->filePath)) {            //判断指定的路径是否存在
				if ($this->isCoverModer) {            //判断是否采用覆盖模式
					$this->makePath();             //如果路径不存在则创建保存上传文件路径
				} else {
					$this->setOption('errorNum', -6);  //如果不是覆盖模式则设置错误号为-6
				}
			}
		}
		
         	/* 随机产生上传文件的新文件名称 */
		private function proRandName() {
              		//从下面字符串中取出组成上传文件新文件名的字符串
			$tmpStr = "abcdefghijklmnopqrstuvwxyz0123456789";  
			$str = "";                             //声明用于保存文件名的字符串变量
			for ($i=0; $i<8; $i++) {                 //循环8次随机从$tmpStr字符串取出8个字符
				$num = rand(0, strlen($tmpStr));     //从$tmpStr字符串长度范围内随机取一个数
				$str .= $tmpStr[$num];             //从$tmpStr字符串中取出一个指定的字符
			}    
			return $str;                           //返回随机由8个字符组成的字符串
		}
		
         	/* 创建保存上传文件的路径   */
		private function makePath() {
			if (!@mkdir($this->filePath, 0755)) {      //创建目录，设置权限为0755
				$this->setOption('errorNum', -7);     //如果创建失败，设置错误号为-7
			}
		}
         
         	/* 将上传文件从临时目录中复制到指定的新位置 */
		private function copyFile() {
			$filePath = $this->filePath;
			if ($filePath[strlen($filePath)-1] != '/') {  //判断目标目录中是否存在目录分割符号“/”
				$filePath .= '/';                 //在目录最后添加“/”符号
			}
			
			$filePath .= $this->newFileName;       //设置目标的新文件名
			if (!@move_uploaded_file($this->tmpFileName, $filePath)) {  //移动上传文件到新位置
				$this->setOption('errorNum', -5);   //如果移动失败则设置错误号为-5
			}
			return $this->errorNum;               //返回错误标号
		}
		
         	/*  从全局变量数组$_FILES中获取上传文件的错误标号 */
		private function getFileErrorFromFILES() {
			return $this->fileField['error'];          //返回数组中的错语标号
		}
		
         	/* 获取文件的后缀名  */
		private function getFileTypeFromFILES() {
			$str = $this->fileField['name'];             //将数组中的名称赋给变量$str
			$aryStr = split("\.", $str);                  //将文件名称以字符串“ ./”分割
			$ret = strtolower($aryStr[count($aryStr)-1]);  //取出文件的后缀名字符串并转为全小写
			return $ret;                             //返回上传文件的后缀名，不带点(.)
		}
		
         	/* 从全局变量数组$_FILES中获取上传文件的名称 */
		private function getFileNameFromFILES() {
			return $this->fileField['name'];             //返回数组中的上传文件名称
		}
		/* 从全局变量数组$_FILES中获取上传文件的临时文件名称 */
		private function getTmpFileNameFromFILES() {
			return $this->fileField['tmp_name'];       //返回数组中的上传文件的临时文件名称
		}
		
         	/* 从全局变量数组$_FILES中获取上传文件的大小 */
		private function getFileSizeFromFILES() {
			return $this->fileField['size'];            //返回数组中的上传文件的大小
		}
		
         	/* 根据错误标号返回对应的错误信息  */
		public function getErrorMsg() {
			$str = "上传文件出错 : ";             //如果错误标号小于0则上传文件出错
			switch ($this->errorNum) {
				case -1:                        //标号-1: 未知的错误
					$str .= "未知错误";
					break;
				case -2:                        //标号-2: 不允许的上传文件类型
					$str .= "未允许类型";
					break;
				case -3:                        //标号-3: 上传文件超过了充许的大小
					$str .= "文件过大";
					break;
				case -4:                        //标号-4: 产生文件名时出错
					$str .= "产生文件名出错";
					break;
				case -5:                        //标号-5: 上传没有成功
					$str .= "上传失败";
					break;
				case -6:                       //标号-6: 保存上传文件的目录不存在
					$str .= "目录不存在";
					break;
				case -7:                       //标号-7: 创建保存上传文件的目录失败
					$str .= "建立目录失败";
					break;
			}
			return $str;                        //返回上传文件时出错的信息
		}
	}
?>
