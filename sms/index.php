<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


	<title>jQuery UI Dialog - Modal form</title>
	<link type="text/css" href="css/ui.all.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
	<script type="text/javascript" src="ui/ui.core.js"></script>
	<script type="text/javascript" src="ui/ui.draggable.js"></script>
	<script type="text/javascript" src="ui/ui.resizable.js"></script>
	<script type="text/javascript" src="ui/ui.dialog.js"></script>
	<script type="text/javascript" src="ui/effects.core.js"></script>
	<script type="text/javascript" src="ui/effects.highlight.js"></script>
	<script type="text/javascript" src="external/bgiframe/jquery.bgiframe.js"></script>
    <script src="src/bgiframe.js" type="text/javascript"></script>
 
   <script src="src/weebox.js" type="text/javascript"></script>
   <link href="src/weebox.css" rel="stylesheet" type="text/css">
   
  
	<link type="text/css" href="css/demos.css" rel="stylesheet" />
<link type="text/css" href="css/global.css" rel="stylesheet" />
	
    
    
    
	<script type="text/javascript">
	$(function() {
		$("#resizable").resizable();
	});
	</script>
<?php 
$res = $_GET[res];
if ($res){
	echo " <script>
	
	alert('$res')
	</script>";}


?>

</head>
<body>


<div class="demo">

<div id="resizable" class="ui-widget-content">
	<h3 class="ui-widget-header">九天国际短息发送系统</h3>
    <form action="test.php" method="post">
    
    <h3 class="ui-widget-header">请输入手机号码：</h3><textarea name="phone"  ></textarea>
    <h3 class="ui-widget-header">请输入短信内容：</h3><textarea name="content" class="form2"></textarea>
    <input type="submit" name="sure" value="确定发送" class="ui-button ui-state-default ui-corner-all" onclick="test.php"/>
   
      
    </form>
       
</div>


 

</body>
</html>
