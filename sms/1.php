



<html>
             <?php
               $a=123;
			  $b="string";
			   $bool=true;
			  var_dump($a);
			  var_dump($b);
			  var_dump($bool);
			  echo 'this is a simple string';
			  echo 'this is a \'simple\' string';
			  echo 'this \n is \r a \t simple string \\';
			  echo 'this is a thing';
			 
			  $arr=array('foo'=>'bar',12=>true);
			  print_r($arr['foo']);
			  
			  			 ?>
             
   <?php 
      class Person{
		  var $name;
		  	  function say(){
				  echo "doing foo";
				  }
		       function kill(){
				   $name='gim';
				   echo $name;
				   echo "m babay";
				   }
		  }
		  $p = new Person;
		  $p->name='tom';
		  $p->say();
		  $p->kill();
		  
		  $mysql = mysql_connect("localhost","root","");
		  var_dump($mysql);
		  
		  $foo = '100page';
		  $foo +=2;
		  $f00 +=1.3;
		  $foo = null + '10little';
		  echo $foo;
		  $foo = 10;
		  $bar = (boolean) $foo;
		  echo $bar;
		  $str = '123.abc';
		  
		  $int = intval($str);
		  echo $int;
		  define ("con" , 100);
		  echo con;
		  define ("son" ,true);
           echo son;
		  define('greeting' , 'hello ,you' , true);
		  echo Greeting;
		  if(defined("con")){
			  echo con;
			  } 
			  
		echo ".PHP_OS.";
		$a = 10;
		$b =$a++;
		echo $a ,$b;	
		$c = 10;
		$d =++$c;
		echo $c ,$d;  
		
		$admin ="admin";
		$password = "password";
		if( $admin ="admin" && $password = "password"){
			echo "all r right";
			}
	 $a=20;
	 $b=30;
	 $v =$a & $b;
	 echo $v;		
	
	 $num =10;
	 is_int($num) and ++$num;
	 echo $num+=10;
	 var_dump($num);
	 $_POST[action]=10;
	 $action = (empty($_POST[action]))? "default":$_POST[action];
	 echo "$action";
	 
	 
    date_default_timezone_set("ETC/GMT-8");
	echo '当前时间'.date("Y-M-D",time())."";
	$hour = date("H");
	if($hour < 6){
		echo "good morning";
		}
		else if($hour<9){
		echo 	"good good";
			}
			else if($hour<12){
				echo "asdad";
				}
				else {
					echo "go hell";
					}
	
	
   ?>
   
   <?php
         $week = date("D");
		 echo $week;
		 switch($week){
			 case "MON":
			   echo "1";
			   break;
			  case "TUE":
			  echo "2";
			  break ;
			  case "Fri":
			  echo "happy";
			  break;
			 
			 
			 }
   
   ?>

      <?php 
	     $sex="man";
		  $age = 15;
		  if($sex ="man"){
			  if($age > 60){
				echo "he is an old man";
				  }
				  else {
					 echo "this guy need ".(60-$age)." to exit;               ";
					  }
				  
			  
			  }





?>

<title>简单的计算器</title>

<?php 
      if(isset($_POST["num1"]) && isset($_POST["num2"])){
		  if(empty($POST["num1"])){
			  echo "<font color='red'>num1 is empty</font>";
			  unset($_POST["sub"]);
			   }
		  if(empty($POST["num2"])){
			  echo "<font color='red'>num2 is empty</font>";
			  unset($_POST["sub"]);
			   }	   
		  $oper = $_POST["oper"];
		  $num1 = $_POST["num1"];
		  $num2 = $_POST["num2"];
		   if ($oper = "/"  | $oper = "%"){
			   
			   
			   if($num2 ==0){
				   echo "<font color='red'> no 0 </font>";
				   unset($_POST[sub]);
				   }
			   }
		  
		  }



?>
        </html>
