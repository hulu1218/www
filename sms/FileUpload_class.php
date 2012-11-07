<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>                 
                                 

                     <?php 
					    include 'file_class.php';
						include 'dirc_class.php';
						include 'file_dir.php';
						include 'filec_class.php';
					            class FileUpload{
									private $filePath;
									private $fileField;
									private $originName;
									private $tmpFileName;
									private $fileType;
									private $fileSize;
									private $newFileName;
									private $allowType= array('txt','html','php','js','css','jpg','gif','png','doc','swf','rar','zip');
									private $maxSize = 1000000000;
									private $isUserDefName = false;
									private $isRandName = false;
									private $randName ;
									private $errorNum=0;
									private $isCoverMode = true;
									function _construct($options=array()){
										
										$this->setOptions($options);
										
										
										}
									function uploadFile($filefield){
										
										$this->setOption('errorNum', 0);
										$this->setOption('field',$field);
										 
										$this->setFiles();
										$this->checkValid();
										$this->checkFilePath();
										$this->setNewFileName();
										if($this->errorNum<0)
										return $this->errorNum;
										return $this->copyfile();
										
										}
									private function setOption($options = array()){
										
										foreach($iotions as $key =>$val){
											if(!in_array($key,array('filePath','fileField','originName','allowType','maxSize','isUserDefName','userDefName','isRandName','randName')))
											continue;
											$this->setOption($key,$val);
											
											}
										
										}	
									
									private function setFiles(){
										
										if($this->getFileErrorFromFILES()!=0){
											$this->setOption('errorNum',-1);
											return $this->setOption('originName',$this->getFileNameFromFILES());
											$this->setOption('TtmpFileName',$this->getTmpFileNameFromFILES());
											$this->setOption('fileType',$this->getFileTypeFromFILES());
											$this->setOption('fileSize',$this->getFileSizeFrimFILES());
											}
										}
										private function setNewFileName(){
											if($this->isRandName==false && $this->isUserDefName==false){
												$this->setOption('mewFileName',$this->originName);
												
												
												}
											else if($this->isRandName==true &&$this->isUserDefName== false){
												$this->setOption('newFileName',$this->proRandName().".".$this->fileType);
												
												}
											else if($this->isRandName==false && $this->isUserDefName==true){
												$this->setOption('newFileName',$this->userDefName);
												}	
												else {
													$this->setOption('errorNum',-4);
													}
											}
										private function checkValid(){
											$this->checkFileSize();
											$this->checkFileType();
											
											
											}
										private function checkFileType(){
											if(!in_array($this->fileType,$this->allowType)){
												
												$this->setOption('errornum',-2);
												return $this->errorNum;
												}
											
											}		
										private function cehckFileSize(){
											
											if($this->fileSize->$this->maxSize){
												
												$this->setOption('errotNum',-3);
												return $this->errorNum;
												
												}
											
											}
										private function checkFilePath(){
											
											if(!file_exists($this->filePath)){
												if($this->isCoverModer){
													$this->makePath();
													
													}
													else{
														$this->setOption('errorNum',-6);
														}
												
												}
											
											
											}		
										private function proName(){
											$tmpStr = 'abcdefghijklmnopqrstuvwxyz123456789';
											$str="";
										for($i=0,$i<8,$i++){
											$num = rand(0,strlen($tmpStr));
											$str.=$tmpStr[$num];



											}
											return $str;	
											}	
											
										private function makePath(){
											if(!@mkdir($this->filePath,0755)){
												$this->setOption('errorNum',-7);
												
												}
											
											
											}	
										private function copyFile(){
											$filePath=$this->filePath;
											if($filePath[strlen($filePath)-1]!='/'){
												$filePath.='/';
												
												
												}
											
											$filePath.=$this->newFileName;
											if(!@move_uploaded_file($this->tmpFileName,$filePath)){
												
												$this->setOption('errorNum',-5);
												
												}
												return $this->errorNum;
											}
										private function getFileErrorFromFILES(){
											return $this->fileField['error'];
											
											}	
										private function getFileTypeFromFILES(){
										$str =	$this->fileField['name'];
										$aryStr =  spilt('\.',$str);
										$ret = strtolower($aryStr[count($aryStr)-1]);
											return $ret;
											
											
											}	
										private function getFileSizeFromFILES(){
											return $this->fileField['size'];
											
											
											}		
										public function getErrorMsg(){
											$str="上传文件出错:";
											switch ($this->errorNum){
												case -1:
												$str.="unknown";
												break;
												case -2:
												$str.="unallowed";
												break;
												case -3:
												$str.="toomuch";
												break;
												case -4:
												$str.="error while creating";
												break;
												case -5:
												$str.="failed to upload";
												break;
												case -6:
												$str.="dir not exist";
												break;
												case -7:
												$str.="failed to create dir";
												break;
											
												
												
												
												}
											
											return $str;
											}	
									}







?>
</body>
</html>