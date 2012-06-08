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
   
  
	<link type="text/css" href="css/demos.css" rel="stylesheet" />
<link type="text/css" href="css/global.css" rel="stylesheet" />
	
	<script type="text/javascript">
	$(function() {
		$("#resizable").resizable();
	});
	</script>
	<script type="text/javascript">
	$(function() {
		
		var name = $("#name"),
			email = $("#email"),
			password = $("#password"),
			allFields = $([]).add(name).add(email).add(password),
			tips = $("#validateTips");

		function updateTips(t) {
			tips.text(t).effect("highlight",{},1500);
		}

		function checkLength(o,n,min,max) {

			if ( o.val().length > max || o.val().length < min ) {
				o.addClass('ui-state-error');
				updateTips("Length of " + n + " must be between "+min+" and "+max+".");
				return false;
			} else {
				return true;
			}

		}

		function checkRegexp(o,regexp,n) {

			if ( !( regexp.test( o.val() ) ) ) {
				o.addClass('ui-state-error');
				updateTips(n);
				return false;
			} else {
				return true;
			}

		}
		
		$("#dialog").dialog({
			bgiframe: true,
			autoOpen: false,
			height: 300,
			modal: true,
			buttons: {
				'Create an account': function() {
					var bValid = true;
					allFields.removeClass('ui-state-error');

					bValid = bValid && checkLength(name,"username",3,16);
					bValid = bValid && checkLength(email,"email",6,80);
					bValid = bValid && checkLength(password,"password",5,16);

					bValid = bValid && checkRegexp(name,/^[a-z]([0-9a-z_])+$/i,"Username may consist of a-z, 0-9, underscores, begin with a letter.");
					// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
					bValid = bValid && checkRegexp(email,/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,"eg. ui@jquery.com");
					bValid = bValid && checkRegexp(password,/^([0-9a-zA-Z])+$/,"Password field only allow : a-z 0-9");
					
					if (bValid) {
						$('#users tbody').append('<tr>' +
							'<td>' + name.val() + '</td>' + 
							'<td>' + email.val() + '</td>' + 
							'<td>' + password.val() + '</td>' +
							'</tr>'); 
						$(this).dialog('close');
					}
				},
				Cancel: function() {
					$(this).dialog('close');
				}
			},
			close: function() {
				allFields.val('').removeClass('ui-state-error');
			}
		});
		
		
		
		$('#create-user').click(function() {
			$('#dialog').dialog('open');
		})
		$('#testsms').click(function() {
			$('#sms').dialog('open');
		})
		.hover(
			function(){ 
				$(this).addClass("ui-state-hover"); 
			},
			function(){ 
				$(this).removeClass("ui-state-hover"); 
			}
		).mousedown(function(){
			$(this).addClass("ui-state-active"); 
		})
		.mouseup(function(){
				$(this).removeClass("ui-state-active");
		});

	});
	</script>
</head>
<body>


<div class="demo">
	
<div id="resizable" class="ui-widget-content">
	<h3 class="ui-widget-header">九天国际短息发送系统</h3>
    <form action="test.php" method="post">
    
    <h3 class="ui-widget-header">请输入手机号码：</h3><textarea name="phone"  ></textarea>
    <h3 class="ui-widget-header">请输入短信内容：</h3><textarea name="content" class="form2"></textarea>
    <input type="submit" name="sure" value="确定发送" class="ui-button ui-state-default ui-corner-all" onclick="test.php"/>
   <button id="create-user" class="ui-button ui-state-default ui-corner-all">Create new user</button>
      
    </form>
       
</div>


</div><!-- End demo -->





</body>
</html>
