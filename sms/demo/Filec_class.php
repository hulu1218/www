<?php
	/* 文件名为Filec_class.php                                           */ 
	/* 是文件类，继承了FileDir类，又扩展了一些和文件有关处理的成员方法  */
	class Filec extends FileDir{
         	/* 构造方法，在创建文件对象时，初使化文件成员属性   */
         	/* 参数filename：需要提供一个文件名称                  */
		function __construct($filename) {
			if(!file_exists($filename)){    //如果提供的文件不存在则使用touch()函数创建该文件
				touch($filename) or die("文件<b>".$filename."</b>创建失败！");
			}	
			$this->name=$filename;                             //为成员属性name赋初值
			$this->type=$this->getMIMEType(pathinfo($filename));   //为成员属性type赋初值
			$this->size=$this->toSize(filesize($filename));           //为成员属性size赋初值
			parent::__construct($filename);         //调用父类构造方法为其他成员属性赋初值
		}
         	/*  实现父类中的抽象方法，重写删除文件的方法体 */
         	/*  如果文件删除成功返回True，失败则返回False  */
		public function delFile() {
			if(unlink($this->name))              //使用文件处理函数unlink()删除文件
				return true;                   //如果删除成功返回True
			 else 
				return false;                  //如果删除失败则返回False
		}
	    	/*  实现父类中的抽象方法，重写复制文件的方法体 */
         	/*  如果文件复制成功返回True，失败则返回False  */
		public function copyFile($dFile) {
			if(copy($this->name, $dFile))         //使用文件处理函数copy()复制文件
				return true;                   //如果文件复制成功返回True
			else
				return false;                 //如果文件复制失败则返回False
		}
         	/*  向客户端发送头文件和输出文件体内容，实现文件下载 */
		public function download(){
			header('Content-Type: '.$this->type);    //发送头文件设置MIME类型
			header('Content-Disposition: attachment; filename="'.$this->basename.'"');   //发送描述
			header('Content-Length: '.filesize($this->name));    //发送文件大小的头信息
			readfile($this->name);			               //将文件内容读出并发送给客户端
		}
        	 /* 可以在对象外部调用该函数，用来获取文件中的文本内容  */
         	/* 返回值：文件中的全部文本内容                        */
		public function getText() {
			$fp=fopen($this->name, "r");        //以只读的方式打开文件，获取文件指针
			flock($fp, LOCK_SH);             //获取文件的共享锁定
			$buffer="";                       //声明一个空字符串，做为一个缓冲区使用
			while (!feof($fp)) {                //如果没有到文件结尾，就一直循环读取文件
				$buffer.= fread($fp, 1024);     //第次从文件中读取1024个字节追加到缓冲区中
			}
			flock($fp, LOCK_UN);            //获取文件的释放锁定
			fclose($fp);                      //关闭文件指针
			return $buffer;                    //返回文件中的全部内容文本
		}
         	/* 可以在对象外部调用该函数，用来向文件中的写入文本内容     */
         	/* 参数text：写入文件的文本内容字符串                        */
		public function setText($text) {
				$fp = fopen($this->name, "w");  //以只写的方式打开文件，获取文件指针
				if (flock($fp, LOCK_EX)) {    //获取文件的独立锁定
   					fwrite($fp, $text);        //向指定的文件中写入文本内容
    					flock($fp, LOCK_UN);   //获取文件的释放锁定
				} else {                               
    					echo "不能锁定文件!";   //如果锁定失败则返回错误信息
				}
				fclose($fp);	                 //关闭文件指针
		}
	    	/* 只能在对象内部调用为成员属性type赋值，获取一些文件的常用MIME类型   */
         	/* 参数path：通过pathinfo()函数获取的文件信息数组                         */
		private function getMIMEType($path) {   
			$fileMimeType="unkown";        //存储文件的MIME类型的变量，默认unkown
			switch($path["extension"]) {       //在参数数组中获取文件的扩展名，作为选择条件
				case "html":                      //如果文件是扩展名为html的网页文件
				case "htm":                       //如果文件是扩展名为htm的网页文件
					$fileMimeType="text/html";    //设置文件的MIME类为text/html
                       break;
				case "txt":                        //如果文件是扩展名为txt的文本文件
				case "log":                        //如果文件是扩展名为log的日志文件
				case "php":                       //如果文件是扩展名为php的脚本文件
				case "phtml":                     //如果文件是扩展名为phtml的脚本文件
					$fileMimeType="text/plain";    //设置文件的MIME类为text/plain
					break;
				case "css":                       //如果文件是扩展名为css的样式表文件
					$fileMimeType="text/css";     //设置文件的MIME类为text/css
					break;
				case "xml":                       //如果文件是扩展名为xml的xml文件
				case "xsl":                       //如果文件是扩展名为xsl的xml样式表文件
					$fileMimeType="text/xml";     //设置文件的MIME类为text/xml
					break;
				case "js":                         //如果文件是扩展名为js的前台脚本文件
					$fileMimeType="text/javascript"; //设置文件的MIME类为text/javascrip
					break;
				case "gif":                        //如果文件是扩展名为gif的图片文件
					$fileMimeType="image/gif";    //设置文件的MIME类为image/gif
					break;
				case "jpeg":                       //如果文件是扩展名为jpeg的图片文件
				case "jpg":                        //如果文件是扩展名为jpg的图片文件
					$fileMimeType="image/jpeg";   //设置文件的MIME类为image/jpeg
					break;
				case "png":                        //如果文件是扩展名为png的图片文件
					$fileMimeType="image/png";    //设置文件的MIME类为image/png
					break;
				case "pdf":                         //如果文件是扩展名为pdf格式文件
					$fileMimeType="application/pdf";  //设置文件的MIME类为application/pdf
					break;
				case "doc":                         //如果文件是扩展名为doc的office文件
				case "dot":                         //如果文件是扩展名为dot的office文件
					$fileMimeType="application/msword";  //设置MIME类为application/msword
					break;
				case "zip":                         //如果文件是扩展名为zip的压缩文件
					$fileMimeType="application/zip";  //设置文件的MIME类为application/zip
					break;
				case "rar":                         //如果文件是扩展名为rar的压缩文件
					$fileMimeType="application/rar";  //设置文件的MIME类为application/rar
					break;	
				case "swf":                         //如果文件是扩展名为swf的flash文件
					$fileMimeType="application/x-shockwave-flash";	//设置flashMIME类型
					break;	
				case "bin":                         //如果文件是扩展名为bin的二进制文件
				case "exe":                         //如果文件是扩展名为ext的二进制文件
				case "com":                        //如果文件是扩展名为com的二进制文件
				case "dll":                          //如果文件是扩展名为dll的二进制文件
				case "class":                        //如果文件是扩展名为class的二进制文件
					$fileMimeType="application/octet-stream";  //设置文件的MIME类二进制
					break;
			}
			return $fileMimeType;                   //返回文件的特定MIME类型
		}
	}
?>
