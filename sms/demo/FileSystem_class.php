<?php
     	/* 文件名：FileSystem_class.php                               */
     	/* 文件系统操作类，声明了和文件系统操作相关的属性和处理方法 */
	class FileSystem {
		private $serverpath;         //保存web服务器的文档根目录
		private $path;              //保存当前文件系统所操作的目录
		private $pagepath;          //当前脚本页面所在目录
		private $prevpath;          //保存所操作页面的上一级目录
		private $files=array();       //保存当前所操作目录下的文件和目录对象的数组
		private $filenum=0;         //用于统计当前所操作目录下的文件对象的个数
		private $dirnum=0;         //用于统计当前所操作目录下的目录对象的个数

      		/* 构造方法，在创建文件系统对象时，初使化文件系统对象的成员属性      */
         	/* 参数path：需要提供所操作目录的目录位置名称，默认为当前目录        */
		function __construct($path=".") {
			$this->serverpath = $_SERVER["DOCUMENT_ROOT"]."/"; //初使化Web服务器根目录
			$this->path=$path;                                   //初使化用户所操作目录
			$this->prevpath=dirname($path);                       //初使化当前脚本所在目录
			$this->pagepath=dirname($_SERVER["SCRIPT_FILENAME"]);  //初使化上一级目录
			$dir_handle=opendir($path);                //打开文件系统所要处理的目录
			while($file=readdir($dir_handle)) {           //遍历目录下的所有对象
				if($file!="." && $file!="..") {           //去掉目录下当前目录和上一级目录
					$filename=$path."/".$file;         //将目录名和当前目录下的文件名相连
					if(is_dir($filename)){            //如果遍历的是目录
						$tmp=new Dirc($filename);  //创建一个目录对象
						$this->dirnum++;          //将统计目录数的成员属性值自加1
					}
					if(is_file($filename)){            //如果遍历的是文件
						$tmp=new Filec($filename);  //创建一个文件对象
						$this->filenum++;          //将统计文件数所成员属性值自加1
					}
					array_push($this->files, $tmp);  //将遍历出来的文件和目录对象都压入数组
				}
			}
			closedir($dir_handle);  			    //关闭目录资源指针
		}

		public function getServerPath() {               //访问该方法获取Web服务器文档根目录
			return $this->serverpath;
		}

		public function getPagePath(){                //访问该方法获取当前脚本所在的目录
			return $this->pagepath;
		}

		public function getPrevPath(){                //访问该方法获取所操作目录的上一级目录
			return $this->prevpath;
		}
		
		public function getDirInfo(){     //访问该方法获取所操作目录下的文件和目录对象的个数
			$str="本目录下共有文件<b>".($this->dirnum+$this->filenum)."</b>个，";
			$str.="其中目录<b>".$this->dirnum."</b>个,";
			$str.="文件<b>".$this->filenum."</b>个。";
			return $str;
		}
		
		public function getDiskSpace() {  //访问该方法获取所操作目录所在的磁盘空间使用信息
			$totalSpace=round(disk_total_space($this->prevpath)/pow(1024,2),2);
			$freeSpace=round(disk_free_space($this->prevpath)/pow(1024,2),2);
			$usedSpace=$totalSpace-$freeSpace;		
			$str="所在分区的总大小：<b>".$totalSpace."</b>MB，";
			$str.="已用：<b>".$usedSpace."</b>MB，";
			$str.="可用：<b>".$freeSpace."</b>MB。";
			return $str;             //返回磁盘空间使用的信息字符串
		} 
 
		public function getMenu() {    //访问该方法获取文件系统的操作菜单
			$menu='<a href="contral.php?action=upload&dirname='.$this->path.'">上传文件</a>||';
			$menu.='<a href="contral.php?action=adddir&dirname='.$this->path.'">新建文件夹</a>||';
			$menu.='<a href="contral.php?action=addfile&dirname='.$this->path.'">创建文件</a>||';
			$menu.='<a href="filesystem.php?dirname='.$this->getPrevPath().'">上级目录</a>||';
			$menu.='<a href="filesystem.php?dirname='.$this->getPagePath().'">开始目录</a>||';
			$menu.='<a href="filesystem.php?dirname='.$this->getServerPath().'">文档根目录</a>';
			echo $menu;           //输出文件系统操作菜单
		}
         	/* 访问该方法获取文件系统所操作目录下的文件和目录对象列表，以表格形式输出 */
		public function fileList(){  
			echo '<table border="0" cellspacing="1" cellpadding="1" width="100%">';
			echo '<tr bgcolor="#b0c4de">';
			echo '<th>类型</th> <th>名称</th> <th>大小</th> <th>修改时间</th> <th>操作</th>';
			echo '</tr>';
			if(is_array($this->files)) {          //判断所操作的目录下是否有文件或是目录存在
				$trcolor="#dddddd";          //初使用化单行背景颜色
				foreach($this->files as $file) {  //遍历数组输出目录和文件信息
					if($trcolor=="#dddddd")  //设置单双行交替背景颜色
						$trcolor="#ffffff";
					else
						$trcolor="#dddddd";
					echo '<tr style="font-size:14px;" bgcolor='.$trcolor.'>';
					echo '<td>'.$file->getType().'</td>';         //输出文件类型
					echo '<td>'.$file->getBaseName().'</td>';     //输出文件名称
					echo '<td>'.$file->getSize().'</td>';          //输出文件大小
					echo '<td>'.$file->getMtime().'</td>';        //输出文件的最后修改时间
					echo '<td>'.$this->operate("contral.php",$file).'</td>'; //输出文件的操作选项
					echo '</tr>';
				}
			}
			echo '</table>';
		}

         	/* 访问该方法获取文件系统中单个文件或目录对象的操作选项             */
         	/* 参数cpage：提供一个控制脚本，当用户进行某项操作时转向的处理页面  */
         	/* 参数file：提供一个文件或目录对象 */
		private function operate($cpage, $file) {
			list($maintype,$subtype)=explode("/",$file->getType());   //将文件的MIME类型分离
			$query='filename='.$file->getName().'&dirname='.$this->path;      //获取查询字符串
			$operstr='<a href="'.$cpage.'?action=copy&'.$query.'"> 复制 </a>';     //获取复制链接
			$operstr.='/<a href="'.$cpage.'?action=rename&'.$query.'"> 重命名 </a>'; //重命名链接
			$operstr.='/<a href="'.$cpage.'?action=delete&'.$query.'"> 删除 </a>';    //删除链接
			switch($maintype){       //根据文件的类型设置文件对象所特有的某项操作
				case 'directory':      //如果是目录类型则提供进入目录的操作链接
					$operstr.='/<a href="filesystem.php?dirname='.$file->getName().'"> 进入 </a>';
					break;
				case 'text':          //如果是文本文件则提供可编辑和下载的操作链接
					$operstr.='/<a href="'.$cpage.'?action=edit&'.$query.'"> 编辑 </a>';
					$operstr.='/<a href="download.php?filename='.$file->getName().'"> 下载</a>';
					break;
				case 'image':         //如果是图像文件则提供可下载和预览的操作链接
					$operstr.='/<a href="'.$file->getName().'"> 预览 </a>';
					$operstr.='/<a href="download.php?filename='.$file->getName().'"> 下载</a>';
					break;
				default:            //其他的文件类型都提供下载的功能
					$operstr.='/<a href="download.php?filename='.$file->getName().'"> 下载</a>';
			}
			return $operstr;		    //返回单个文件或目录对象的所有操作选项字符串
		}
	}
?>
