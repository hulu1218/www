<?php
	/* 文件名为FileDir_class.php                                              */ 
	/* 是文件和目录类的父类，定义了文件和目录公用的属性和方法，是一个抽象类 */
	abstract class FileDir {
		protected $name;                             //文件名称，包含路径
		protected $basename;                         //文件名部分，不包含路径
		protected $type;                             //文件类型
		protected $size;                             //文件占用磁盘大小
		protected $ctime;                            //文件创建时间
		protected $mtime;                           //文件修改时间
		protected $atime;                            //文件最后访问时间
		protected $able;                             //文件权限

      	   	/* 构造方法，在创建子类对象时，在子类的构造方法中调用该法初使化成员属性 */
        	 /* 参数filename：提供一个文件或目录名称                                 */
		function __construct($filename) {		
			$this->basename=basename($filename);           //为成员属性basename赋初值
			$this->ctime=$this->getDateTime($filename,'c');    //为成员属性ctime赋初值
			$this->mtime=$this->getDateTime($filename,'m');   //为成员属性mtime赋初值
			$this->atime=$this->getDateTime($filename,'a');    //为成员属性atime赋初值
			$this->able=$this->fileAble($filename);           //为成员属性able赋初值
		}	
         
        	 /* 调用时返回对象中的成员属性name的值，用来获取文件名称*/
		public function getName() {
			return $this->name;            //返回保存文件名称的成员属性name的值
		}

         	/* 调用时返回对象中的成员属性basename的值，用来获取文件的基名称*/
		public function getBaseName() {
			return $this->basename;        //返回保存文件基名称的成员属性basename的值
		}

         	/* 调用时返回对象中的成员属性size的值，用来获取文件的占用的磁盘空间大小 */
		public function getSize() {
			return $this->size;             //返回保存文件大小的成员属性size的值
		}

         	/* 调用时返回对象中的成员属性type的值，用来获取文件的类型 */
		public function getType() {
			return $this->type;            //返回保存文件类型的成员属性type的值
		}

         	/* 调用时返回对象中的成员属性able的值，用来获取文件的访问权限 */
		public function getAble(){
			return $this->able;            //返回保存文件访问权限的成员属性able的值
		}

         	/* 调用时返回对象中的成员属性ctime的值，用来获取文件的创建时间 */
		public function getCtime(){
			return $this->ctime;	        //返回保存文件创建时间的成员属性ctime的值
		}

         	/* 调用时返回对象中的成员属性mtime的值，用来获取文件的修改时间*/
		public function getMtime(){
			return $this->mtime;	       //返回保存文件修改时间的成员属性mtime的值
		}

         	/* 调用时返回对象中的成员属性atime的值，用来获取文件的最后访问时间 */
		public function getAtime(){
			return $this->atime;	       //返回保存文件最后访问时间的成员属性atime的值
		}

		abstract protected function delFile();        //声明一个删除文件的抽象方法，在子类中实现
		
		abstract protected function copyFile($dFile);  //声明一个复制文件的抽象方法，在子类中实现

         	/* 声明移动文件或为文件重新命名的方法            */
         	/* 参数newName：提供一个文件或目录新名称       */
         	/* 返回值：如果成功返回True，失败则返回false     */
		public function moveFile($newName) {
			if(rename($this->name, $newName))  {   //使用rename重命名文件，并判断是否成功
				$this->name=$newName;           //为成员属性name，重新赋新值
				return true;                       //返回真
			}else {                               //如果移动不成功
              return false;                      //返回假
			}
		}

         	/* 将获取的文件字节数，转换为合适的单位（TB、GB、MB、KB）    */
         	/* 参数bytes：提供一个文件占用磁盘的字节数大小                  */
         	/* 返回值：合适的单位                                           */
		protected function toSize($bytes) {        
			if ($bytes >= pow(2,40)) {                    //如果字节数大小大于2的40次方
				$return = round($bytes / pow(1024,4), 2);   //将字节数大小除以1024的4次方
				$suffix = "TB";                        //单位为TB
			} elseif ($bytes >= pow(2,30)) {               //如果字节数大小大于2的30次方
				$return = round($bytes / pow(1024,3), 2);   //将字节数大小除以1024的3次方
				$suffix = "GB";                        //单位为GB
			} elseif ($bytes >= pow(2,20)) {               //如果字节数大小大于2的20次方
				$return = round($bytes / pow(1024,2), 2);   //将字节数大小除以1024的2次方
				$suffix = "MB";                        //单位为MB
			} elseif ($bytes >= pow(2,10)) {               //如果字节数大小大于2的10次方
				$return = round($bytes / pow(1024,1), 2);   //将字节数大小除以1024的1次方
				$suffix = "KB";                        //单位为KB
			} else {                                   //如果字节数大小小于2的10次方
				$return = $bytes;                       //将字节数大小不变
				$suffix = "Byte";                       //单位为Byte
			}
			return $return ." " . $suffix;                   //将转换后的数值与单位连接并返回
		}

         	/* 获取文件的时间属性，为三个存储时间的成员属性赋初值       */
         	/* 参数filename：提供一个文件名称，从该文件中获取时间属性    */
		/* 参数cate：提供一个用于选择不同类型时间的符号（m、c、a）   */
         	/* 返回值：文件符合条件并转换格式后的时间字符串              */
		protected function getDateTime($filename,$cate='m'){
			date_default_timezone_set("Etc/GMT-8");                //设置时区为东8时区
			switch($cate){                                      //按条件返回不同的时间
				case 'm':                                       //如果$cate的值为m
					return date("Y-m-j H:i:s", filemtime($filename));  //返回文件的修改时间
					break;
				case 'c':                                        //如果$cate的值为m
					return date("Y-m-j H:i:s", filectime($filename));   //返回文件的创建时间
					break;
				case 'a':                                        //如果$cate的值为m
					return date("Y-m-j H:i:s", fileatime($filename));   //返回文件的最后访问时间
					break;
				default:                                        //如果条件不成立
					return "0000-00-00 00:00:00";                 //返回无效的时间
			}
		}

         	/* 获取文件的访问权限，为成员属性able赋初值，使用8进制的整数格式代表        */
         	/* 返回值：权限值4可读\2可写\1可执行，7为4+2+1表示可读可写可执行，0没权限 */
		protected function fileAble(){
			$read=0;                      //初使用化可读的变量为0，表示不可读
			$write=0;                     //初使用化可写的变量为0，表示可写
			$exe=0;                      //初使用化执行的变量为0，表示执行
			if(is_readable($this->name))      //如果文件可读则条件成立
				$read=4;                 //将可读的变量设置为4
	  		if(is_writable($this->name))      //如果文件可写则条件成立
				$write=2;                //将可写的变量设置为2
			if(is_executable($this->name))    //如果文件可执行则条件成立
				$exe=1;                  //将可执行的变量设置为1
			return $read+$write+$exe;       //返回文件的访问权限值
		}

         	/* 声明一个魔术方法，在直接输出对象时，将对象中所有属性形成字符串返回 */
		function __toString() {
			$fileContent="";
			$fileContent.="文件名称：".$this->getName()."<br>";      
			$fileContent.="文件类型：".$this->getType()."<br>";
			$fileContent.="文件大小：".$this->getSize()."<br>";
			$fileContent.="文件访问权限：".$this->fileAble()."<br>";
			$fileContent.="文件创建时间：".$this->getCtime()."<br>";
			$fileContent.="文件修改时间：".$this->getMtime()."<br>";
			$fileContent.="文件访问时间：".$this->getAtime()."<br>";
			return $fileContent;	
		}
	}
?>
