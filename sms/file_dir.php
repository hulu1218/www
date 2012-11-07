<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php 
  abstract class  FileDir{
	   protected $name;
	   protected $basename;
	   protected $type;
	   protected $size;
	   protected $ctime;
	   protected $mtime;
	   protected $atime;
	   protected $able;
	     function _construct($filename){
			    $this->basename = basename($filename);
				$this->ctime = getDateTime($filename,"c");
				$this->mtime = getDateTime($filename,"m");
				$this->atime = getDateTime($filename,"a");
				$this->able = $this->fileable($filename);
				
			 
			 }
	   public function getName(){
					return $this->name;
					}
	   public function getBaseName(){
		            return $this->basename;
		   }	
	    public function getSize(){
			        return $this->size;
					
			}	   	 
	  public function getCtime(){
		            return $this->ctime;
		           
				   } 
	  
	  public function getMtime(){
		            return $this->mtime;
		              }
      public function getAtime(){
		             return $this->atime;
		       
		   }		
		   
		 abstract function delfile();
		 abstract function copyfile($dfile);  
		 public function movefile($newName){
			 
			 if(rename($this->name,$newName)){
				 $this->name = $newName;
				 return true;
				 }
				 else 
				 
				 {return false;}
			 }	
			 
		protected function toSize($bytes){
			 if($bytes>=pow(2,40)){
				 $return = round($bytes/pow(1024 , 4),2);
				 $sufffix = "TB";
				 }
			else if ($bytes>=pow(2,30)){
				$return = round($bytes/pow(1024,3),2);
				$sufffix="GB";
				
				}
				else if ($bytes>=pow(2,20)){
				$return = round($bytes/pow(1024,2),2);
				$sufffix="MB";
				
				}else if ($bytes>=pow(2.10)){
				$return = round($bytes/pow(1024,1),2);
				$sufffix="KB";
				
				}
				else {
					$return=$bytes;
					$sufffix="bytes";
					}
					
					return $return."".$sufffix;
			}	 
			
			
			protected function getDateTime($filename,$cate="m"){
				
				 date_default_timeZone_set("etc/GMT-8");
				 switch($cate){
					 case "m":
					 return date("Y-M-j h:i:s" ,filetime($filename));
					 break;
					  case "c":
					 return date("Y-M-j h:i:s" ,filetime($filename));
					 break;
					 
					  case "a":
					 return date("Y-M-j h:i:s" ,filetime($filename));
					 break;
					 default:
					 return "00000000000000000000";
					 
					 }
				
					}
				protected function fileAble(){
					$read = 0;
					$write= 0;
					$exe =0;
					if(is_readable($this->name)){
						$read= 4;
				   if(is_writeable($hits->name)){
					    $write =2;
					   }		
				    if(is_executable($this->name)){
						$exe=1;
						return $read + $write +$exe;
						}
						function _toString(){
							$fileContent = "";
							$fileContent = "filename :".$this->getName()."";
							$fileContent.=   "filetype:".$this->getType()."";
							$fileContent.=   "filesize:".$this->getSize()."";
							$fileContent.="fileable :".$this->getAble()."";
							$fileContent.="filectime :".$this->getCtime()."";
							$fileContent.="filemtime :".$this->getMtime()."";
							$fileContent.="fileatime :".$this->getAtime()."";
							return $fileContent;
							}		
						}
					
				}		  
	  }


?>
</body>
</html>