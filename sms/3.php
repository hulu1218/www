<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>

<?php
        class person {
			   private $name;
			   private $age;
			   private $sex;
			    function __construct($name='',$age=1,$sex="男"){
					$this->name=$name;
					$this->age=$age;
					$this->sex=$sex;
					
					
					
					
					}
			 
			    public function getNmae(){
					
					return $this->name;
					
					}
					
			public function setNmae($name){
				return $this->name=$name;
				
				
				}	
				
				function say(){
					
					echo "我的名字叫 ".$this->name." 今年".$this->age." 是个".$this->sex."";
					
					}	
			}
 
  $person1 = new person("王五","2","女");
  $person1->say();
  
?>
  
</body>
</html>