<?php
	/* 文件名为Dirc_class.php                                            */ 
	/* 是目录类，继承了FileDir类，又扩展了一些和目录有关处理的成员方法  */
	class Dirc extends FileDir{
         	/* 构造方法，在创建目录对象时，初使化目录成员属性      */
         	/* 参数filename：需要提供一个文件名称                   */
		function __construct($dirname=".") {
			if(!file_exists($dirname)){    //如果提供的目录不存在则使用mkdir()函数创建该目录
				mkdir($dirname) or die("目录<b>".$dirname."</b>创建失败！");
			}	
			$this->name=$dirname;                          //为成员属性name赋初值
			$this->type="directory/";                         //为成员属性type赋初值
			$this->size=$this->toSize($this->dirSize($dirname));   //为成员属性size赋初值
			parent::__construct($dirname);      //调用父类构造方法为其他成员属性赋初值
		}
         	/*  实现父类中的抽象方法，重写删除文件的方法体 */
         	/*  如果目录删除成功返回True，失败则返回False  */
		public function delFile() {
			$this->delDir($this->name);       //调用对象内部自定义的删除目录方法
			if(!file_exists($this->name))       //如果目标目录不存在则被删除了
				return true;                //如果目录被删除了则返回真
			else
				return false;               //如果目录还存在，则删除失败返回假
		}
		
	    	/*  实现父类中的抽象方法，重写复制文件的方法体 */
         	/*  如果目录复制成功返回True，失败则返回False  */
		public function copyFile($dFile){
			$this->copyDir($this->name, $dFile);  //调用对象内部自定义复制目录的方法
			if(file_exists($dFile))               //如果目标目录存在则复制成功
				return true;                   //如果目录复制成功则返回真
			else
				return false;                  //如果目录复制失败则返回假
		}

        	 /* 递归获取目录占用大小，目录中所有文件大小遍历累加在一起，即目录大小 */
        	 /* 参数directory：提供需要获取大小的目录                               */
         	/* 返回值dir_size：将计算后的文件大小返回                              */
		private function dirSize($directory) {     
			$dir_size=0;                                  //声明用来存储文件大小的变量
			if($dir_handle=opendir($directory)) {             //打开目录，返回目录指针
				while($filename=@readdir($dir_handle)) {    //循环遍历目录中的文件
					if($filename!="." && $filename!="..") {  //去掉.和..目录
						$subFile=$directory."/".$filename;  //将目录中的文件和当前目录连接
						if(is_dir($subFile))               //如果遍历的是目录
							$dir_size+=$this->dirSize($subFile);  //调用自己计算子目录大小
						if(is_file($subFile))              //如果遍历的是文件
							$dir_size+=filesize($subFile);  //直接获取文件大小并累加起来
					}
				}     
		    		closedir($dir_handle);		               //关闭目录
				return $dir_size;                         //返回目录大小
			}
		}

         	/* 递归删除目录中的文件，再删除空目录       */
         	/* 参数directory：提供要被删除的目录         */
		private function delDir($directory) {         
			if(file_exists($directory)) {                        //判断被删除的目录是否存在
				if($dir_handle=@opendir($directory)) {         //打开目录，返回目录指针
					while($filename=readdir($dir_handle)) {   //循环遍历目录中的文件
						if($filename!="." && $filename!="..") {   //去掉.和..目录
							$subFile=$directory."/".$filename;   //连接目录名
							if(is_dir($subFile))                //如果遍历的是目录
								$this->delDir($subFile);       //调用自己删除子目录
							if(is_file($subFile))               //如果遍历的是文件
								unlink($subFile);            //直接删除文件
						}
					}
					closedir($dir_handle);                      //关闭目录资源
					rmdir($directory);                         //删除空目录
				}
			}
		}

         	/* 递归复制目录及目录下的文件到新的位置       */
        	 /* 参数dirSrc：提供要被复制的源目录            */
         	/* 参数dirTo：提供要被复制目录的目标位置       */
		private function copyDir($dirSrc, $dirTo) {       
			if(is_file($dirTo)) {                      //如果目标目录是一个文件则不能复制
				echo "目标不是目录不能创建!!";     //输出错误信息
				return;                           //退出函数
			}
			if(!file_exists($dirTo)) {                 //如果目标目录不存在则创建它
				mkdir($dirTo);                    //使用mkdir()函数创建一个空目录
			}
			if($dir_handle=@opendir($dirSrc)) {                 //打开源目录，返回目录指针
				while($filename=readdir($dir_handle)) {         //循环遍历目录中的文件
					if($filename!="." && $filename!="..") {     //去掉.和..目录
						$subSrcFile=$dirSrc."/".$filename;     //获取源目录中子目录文件名
						$subToFile=$dirTo."/".$filename;      //获取目标目录中子目录文件名
						if(is_dir($subSrcFile))                     //判断子文件是否是目录
							$this->copyDir($subSrcFile, $subToFile); //调用自己复制子目录
						if(is_file($subSrcFile))                    //判断子文件是否是文件
							copy($subSrcFile, $subToFile);        //直接复制到目标位置
					}
				}
				closedir($dir_handle);                            //关闭目录资源
			}
		}
	}
?>
