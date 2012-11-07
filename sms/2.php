<html>
<?php 
 function test($n){
	 echo $n;
	     if ($n>0)
			 
			 test($n-1);
			 else 
			 echo $n;
			 
	 }
	 test(10);
?>
<?php 
$a="hello";

function printa(){
	$a="mysql";
    global $a;
	
	
	echo $a;
	
	}
    echo $a;
	printa();


?>
<?php 

   function total ($b=3,$c=5,$a)
{
	echo $a ."+". $b ."+".$c ."=".($a+$b+$c);
	 
	
	}
total(1);

?>
<?php 

$str ="lamp";
$str1 ="lampbrother";
$strc =strcmp($str,$str1);
switch ($strc){
	case 1:
	echo "str > str1";
	break;
	case -1:
	echo "str < str1";
	break;
	case 0:
	echo "str = str1";
	break;
	
	default:
	echo "str <> str1";
	
	
	}





?>
<?php 

function p(){
	return 1;
	
	}

  if (p()){
	  echo "false";
	  }
	  else {echo "true";}
?>
  
  
  
  <?php 
     $contact = array (
	     array(1,'berry','12','gmail'),
		 array(2,'jim','13','163mail'),
		  array(3,'jim','13','163mail'),
		   array(4,'jim','13','163mail'),
		    array(5,'jim','13','163mail')
	  
	 
	 
	 );
   echo "<table align='center'  bgcolor='#FF0000' border='1' width='600'>";
   echo "<caption><h1>信息列表</h1></caption>";
   echo "<tr bgcolor='#0000FF'>";
   echo '<th>bianhao</th><th>name</th><th>age</th><th>mail</th>';
   for ($row=0;$row<count($contact);$row++){
	   
	   echo '</tr>';
	   for ($col=0;$col<count($contact[$row]);$col++ ){
		   echo '<td>'.$contact[$row][$col].'</td>';
		   
		   }
	   echo '</tr>';
	   }
  
  
  
  echo '</table>'
  
  ?>
  <?php 
    $contact = array(
	  'market' =>array(array(1,"berry","010123","gnail"),
	                   array(2,"jim","456789","163mail"),
					   array(3,"tudou","48951","hotmail")),
	  'product' => array(
	                    array(4,"sally","456789","qqcom"),
						array(5,"tianya","753951","jetmail"),
						array(6,"getmai","852951","foxmail")

),     
      'finace' =>array (
	                    array(7,"hsgdk","78965413",'hkhk'),
						array(8,"yhhfgg","752159","opkhr"),
						array(9,"yhgfr","75158","hkhkhk")
	  
	  )
	  
	  
	
	);
	 foreach($contact as $sector =>$table){
		
		  echo "<table align='center' border='1' bgcolor='#00FF00' width='600'>";
		  echo "<caption><h1>$sector</h1></caption>";
		  echo "<tr bgcolor='#FFFF00'>";
		   echo "<th>id</th><th>name</th><th>phone</th><th>mail</th>" ;
		   echo "</tr>";
		   foreach($table as $row){
			   echo "<tr>";
			   foreach($row as $col){
				   
				   echo "<td>$col</td>";
				   
				   }
			   
			   
			   }
		}
    
  
  ?>

</html>