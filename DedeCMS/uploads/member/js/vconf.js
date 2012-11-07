/**
 * @fileoverview 表单验证类 验证规则配置对象，与validator.js配合实现表单验证
 * @author xs | zhenhau1@staff.sina.com.cn
**/
(function(){

	// 判断年月日部分
	//写在onReady事件里是因为判断和年月日下拉部分代码所用框架与当前所用框架不是一套，逻辑执行顺序有变化，
	//考过来用这种方法保证$('year')不为null
	onReady(function(){
	    var yearNode = $("year");
	    var monthNode = $("month");
	    var dayNode = $("day");
	    var MonHead = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	    var birthday = {
	        YYYYMMDDstart: function(year, month, day){
	    		if(!yearNode) return;
	    	
	            yearNode.options.add(new Option("请选择", ""));
	            monthNode.options.add(new Option("--", ""));
	            dayNode.options.add(new Option("--", ""));
	//            monthNode.options.add(new Option("--", "00"));
	            dayNode.options.add(new Option("--", "00"));
	            
	            //先给年下拉框赋内容  
	            var y = new Date().getFullYear();
	            for (var i = (y - 109); i < (y + 1); i++) //以今年为准，显示前30年之后的20年  
	            {
	                yearNode.options.add(new Option("" + i + "", i));
	            }
	            //赋月份的下拉框  
	            for (var i = 1,j=1; i < 13; i++) {
					  if (j < 10) {
	                    j = "0" + j;
	                }
	                monthNode.options.add(new Option("" + i + "", j));
					j++;
	            }
	            
	            yearNode.value = year; //获取到当前年份
	            monthNode.value = month; // 获取到当前月份
	            var n = MonHead[new Date().getMonth()];
	            if (new Date().getMonth() == 1 && this.IsPinYear(year)) {
	                n++;
	            }
	            this.writeDay(n); //赋日期下拉框Author:meizz  
	             // 获取到当前日期
				 dayNode.value = day;
	        },
	        YYYYDD: function(str){
				monthNode.selectedIndex=0;
	            var MMvalue = monthNode.options[monthNode.selectedIndex].value;
	            if (MMvalue == "") {
	                this.optionsClear(dayNode);
	                return;
	            }
	            var n = MonHead[MMvalue - 1];
	            if (MMvalue == 2 && this.IsPinYear(str)) {
	                n++;
	            }
	            this.writeDay(n);
	            
	        },
	        MMDD: function(str){
	            var YYYYvalue = yearNode.options[yearNode.selectedIndex].value;
	            if (YYYYvalue == "") {
	                this.optionsClear(dayNode);
	                return;
	            }
	            var n = MonHead[str - 1];
	            if (str == 2 && this.IsPinYear(YYYYvalue)) {
	                n++;
	            }
	            this.writeDay(n);
	        },
	        writeDay: function(n){
	            this.optionsClear(dayNode);
	            for (var i = 1, j = 1; i < (n + 1); i++) {
	            
	                if (j < 10) {
	                    j = "0" + j;
	                }
	                dayNode.options.add(new Option("" + i + "", j));
	                j++;
	            }
	        },
	        IsPinYear: function(year){
	            return (0 == year % 4 && (year % 100 != 0 || year % 400 == 0));
	        },
	        optionsClear: function(e){
	            for (var i = e.options.length; i > 0; i--) {
	                e.remove(i);
	            }
	        }
	    };
	    
	    $addEvent2(yearNode, function(){
	    	birthday.YYYYDD(yearNode.value);
	    }, 'change');
	    $addEvent2(monthNode, function(){
	    	birthday.MMDD(monthNode.value);
	    }, 'change');
	    //init
    	birthday.YYYYMMDDstart();
    });
    //生日

	
	/**
	* SSO check user exist
	* author lijun
	* date 2007.5.8
	* last modify by xs | zhenhau1@staff.sina.com.cn
	*/
	var checkUrl = "/signup/check_user.php";
	var checkDomainUrl = "/signup/check_domain.php";
	var memberYes = "用户名已被注册";
	var memberNo = "用户名可用";
	var error = "异步通信错误";
	var defer = "您的操作过于频繁，请稍后再试。";
	var type1 = "freemail",type2 = "vipmail",type3 = "sinauser",type4 = "2008mail";
	
	/* ajax engine */
	function ajaxCheck(url,from,name, callBack) {
		var XHR;
		var date = new Date();
		var parameter = "from=" + from + "&name=" + name + "&timeStamp= " + date.getTime();
		try {
			try{
				XHR=new ActiveXObject("Microsoft.XMLHTTP");
			}catch(e){
					try{
						XHR=new XMLHttpRequest();
					} catch (e){ }
			}
			XHR.open("POST",url);
			XHR.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			XHR.onreadystatechange = function(){
				if(XHR.readyState==4) {
					if(XHR.status==200) {
						if(callBack) callBack(from,XHR.responseText);
					}
				}
			}
			XHR.send(parameter);
		}catch (e) {
			alert(e.toString());
		}
	}
	
	/* checkUserExist */
	function checkUserExist(from,name, callBack) {
		ajaxCheck(checkUrl,from,name, callBack);
	}				
	function checkDomainExist(from,name,callBack) {
		ajaxCheck(checkDomainUrl,from,name,callBack);
	}

	/**
	 * 判断用户名是否有重复，上面已经引入方法
	 */	
	function checkUsername(e, v) {
		checkUserExist('othermail', e.value, function(from, responseText){
			if(from == 'othermail'){
				var msg = "";
				if(responseText.search("no")>=0){
					msg = 'hide';
				}else if(responseText.search("yes")>=0){
					msg = '己被注册';
				}else if(responseText.search("defer")>=0){
					msg = '您的操作过于频繁，请稍后再试。';
				}else{
					msg = '异步通信错误';
				}
				v.showErr(e, msg);
			}
		});
	}
	function $E(id){
		return document.getElementById("id");
	}
	/**
	 * 判断用户名是否有重复，上面已经引入方法
	 */	
	function checkFreemail(e, v) {
		var mailType = '';
		if(!e.value && _initing){
			_initing = false;
			return ;
		}
		_initing = false;
		switch($('mailTypeValue').value){
		case '**':
			mailType = 'freemail';
			break;
		case 'cn':
			mailType = 'cnmail';
			break;
//		case 'comcn':
//			mailType = 'regmail';
//			break;
		}
		var value;
		if(e.id == "checkName" || e.id == "changeName"){
			value = document.getElementById("emailname").value;
		}else{
			value = e.value;
		}
		if(document.getElementById("regmail") != null && document.getElementById("regmail").value == "regmail"){
			mailType = "regmail";
		}
		checkUserExist(mailType, value, function(from, responseText){
			if(from == 'freemail' || from == 'cnmail'){
				var msg = "";
				if(responseText.search("no")>=0){
					msg = 'hide';
				}else if(responseText.search("yes")>=0){
					msg = '该邮箱名已被占用';
				}else if(responseText.search("defer")>=0){
					msg = '您的操作过于频繁，请稍后再试。';
				}else{
					msg = '异步通信错误';
				}
				v.showErr(e, msg);
			}
			var atext = responseText.split(" ");
			if(from == "regmail"){
				var msg = "";
				if(atext.length > 1){
					if(atext[3] == "no" && atext[1] == "yes"){
						document.getElementById("msg").style.display = "none";
						document.getElementById("register").style.display = "";
						document.getElementById("typecom").disabled = "";
						document.getElementById("typecom").checked = false;
						document.getElementById("typecom").style.className = "notifyType";
						document.getElementById("comname").className = "email_name fb";
						document.getElementById("comlocation").className = "location";
						document.getElementById("com_tip").className = "info";
						document.getElementById("com_tip").innerHTML = "可以注册";
						document.getElementById("typecn").checked = false;
						document.getElementById("typecn").disabled = "true";
						document.getElementById("typecn").className = "notifyType cursorDft";
						document.getElementById("cnname").className = "email_name_disabled fb";
						document.getElementById("cnlocation").className = "location_disabled";
						document.getElementById("cn_tip").className = "info_disabled";
						document.getElementById("cn_tip").innerHTML = "已被注册";
						document.getElementById("comname").innerHTML = value;
						document.getElementById("cnname").innerHTML = value;
						document.getElementById("emailname").parentNode.parentNode.className = "input";
					}
					if(atext[3] == "yes" && atext[1] == "no"){
						document.getElementById("msg").style.display = "none";
						document.getElementById("register").style.display = "";
						document.getElementById("typecom").disabled = "true";
						document.getElementById("typecom").className = "notifyType cursorDft";
						document.getElementById("comname").className = "email_name_disabled fb";
						document.getElementById("comlocation").className = "location_disabled";
						document.getElementById("com_tip").className = "info_disabled";
						document.getElementById("com_tip").innerHTML = "已被注册";
						document.getElementById("typecom").checked = false;
						document.getElementById("typecn").disabled = "";
						document.getElementById("typecn").className = "notifyType";
						document.getElementById("cnname").className = "email_name fb";
						document.getElementById("cnlocation").className = "location";
						document.getElementById("cn_tip").className = "info";
						document.getElementById("cn_tip").innerHTML = "可以注册";
						document.getElementById("comname").innerHTML = value;
						document.getElementById("cnname").innerHTML = value;
						document.getElementById("typecn").checked = false;
						document.getElementById("emailname").parentNode.parentNode.className = "input";
					}
					if(atext[3] == "no" && atext[1] == "no"){
						document.getElementById("msg").style.display = "none";
						document.getElementById("register").style.display = "";
						document.getElementById("typecom").disabled = "";
						document.getElementById("typecom").className = "notifyType";
						document.getElementById("comname").className = "email_name fb";
						document.getElementById("comlocation").className = "location";
						document.getElementById("com_tip").className = "info";
						document.getElementById("com_tip").innerHTML = "可以注册";
						document.getElementById("typecom").checked = false;
						document.getElementById("typecn").disabled = "";
						document.getElementById("typecn").className = "notifyType";
						document.getElementById("cnname").className = "email_name fb";
						document.getElementById("cnlocation").className = "location";
						document.getElementById("cn_tip").className = "info";
						document.getElementById("cn_tip").innerHTML = "可以注册";
						document.getElementById("comname").innerHTML = value;
						document.getElementById("cnname").innerHTML = value;
						document.getElementById("typecn").checked = false;
						document.getElementById("emailname").parentNode.parentNode.className = "input";
					}
					if(atext[3] == "yes" && atext[1] == "yes"){
						msg = '己被注册';
						v.showErr(e, msg);
					}
				}else if(responseText.search("yes")>=0 && atext.length == 1){
					msg = '己被注册';
					v.showErr(e, msg);
				}else if(responseText.search("defer")>=0){
					msg = '您的操作过于频繁，请稍后再试。';
					v.showErr(e, msg);
				}else{
					msg = '异步通信错误';
					v.showErr(e, msg);
				}
			}
		});
	}

	/**
	 *  通过 Ajax 判断域名是否有重复，上面已经引入方法
	 */
	function checkDomain(e, v) {
		checkDomainExist('sinauser', e.value, function(from, responseText){
			if(from == 'sinauser'){
				var msg = "";
				if(responseText.search("no")>=0){
					msg = 'hide';
				}else if(responseText.search("yes")>=0){
					msg = '域名已被用';
				}else{
					msg = '异步通信错误';
				}
				v.showErr(e, msg);
			}
		});
	}
	
	/**
	 *  计算密码强度方法1
	 */
	function CharMode(iN) {
		if (iN >= 65 && iN <= 90) return 2;
		if (iN >= 97 && iN <= 122) return 4;
		else return 1;
	}
	
	/**
	 *  计算密码强度方法2
	 */
	function bitTotal(num) {
		var modes = 0;
		for (var i=0;i<3;i++) {
			if (num & 1) modes++;
			num >>>= 1;
		}
		return modes;
	}
	
	/**
	 * 生日验证
	 * @return {Boolean} 返回生日验证结果
	 */
	function checkDate(e, v){
		var yearNode = $('year');
		var monthNode = $('month');
		var dayNode = $('day');
		
		if(yearNode.value==""){
			v.showErr(e, "请选择生日年份");
			return true;
		}
		if(monthNode.value==""){
			v.showErr(e, "请选择生日月份");
			return true;
		}
		if(dayNode.value==""){
			v.showErr(e, "请选择生日日期");
			return true;
		}

		if(yearNode.value>new Date().getFullYear()||(yearNode.value==new Date().getFullYear() && monthNode.value>(new Date().getMonth()+1))||(yearNode.value==new Date().getFullYear()&& monthNode.value==(new Date().getMonth()+1)&&dayNode.value>(new Date().getDate()))){
			v.showErr(e, "生日不应大于当前日期");
			return true;
		}
		return false;
	}
	
	
	/**
	 * 表单验证类 验证规则配置对象
	 */
	var conf = {
		/**
		 *  当表单提交时执行的函数
		 */
		//'submitFn': function(el){
			
		//},
		/**
		 *  获取焦点时执行的函数
		 *  其中判断强度需要有相应HTML结构支持
		 */
		'focusFn': function(el, v){
			var alt = el.alt;
			var arg = /focusFn{([^}].+?)}/.exec(alt);
			arg = (arg == null) ? false : arg[1];
			$removeClassName($(arg), 'hide');
		},
		'长度': {						
			msg: '{name}长度应为{range}位'
		},
		'相同': {						
			msg: '{name}不一致'
		},
		'支付密码不同于密码': {						
			msg: '为保护您的资金安全，支付密码和登录密码不能相同',
	        fn : function(e, v){
				var val = e.value;
				if(!val) return '';
				return ($('password').value == $('paypassword').value)?this.msg:'';
	        }
		},
		"无内容": {
			msg: '请输入{name}',
			fn:  function(e, v){
				var val = e.value;
				if(e.id == "checkName" || e.id == "changeName"){
					val = document.getElementById("emailname").value;
				}
				return (val!="点此显示验证码" && /./.test(val)) ? 'clear' : this.msg;
			}
		},
		"无内容sel": {
			msg: '请选择{name}',
			reg: /./
		},
		"全数字": {
			msg: '{name}不能为全数字',
			reg: /[^\d]+/
		},
		"有数字": {
			msg: '{name}不能有数字',
			reg: /^[^\d]+$/
		},
		"有空格": {
			msg: '{name}不能包含空格符',
			reg: /^[^ 　]+$/
		},
		"邮箱地址": {
			msg: '邮箱地址格式不正确',
			reg: /^[0-9a-z][_.0-9a-z-]{0,31}@([0-9a-z][0-9a-z-]{0,30}\.){1,4}[a-z]{2,4}$/
		},
		"手机号码": {
			msg: '{name}不正确',
			reg: /^1(3\d{1}|5[389])\d{8}$/
		},
		"证件号码": {
			msg: '{name}不正确',
			reg: /^(d){5,18}$/
		},
		"有大写": {
			msg: '{name}不能有大写字母',
			reg: /[A-Z]/,
			regFlag: true
		},
		"有全角": {
			msg: '{name}不能包含全角字符',
			reg: /[\uFF00-\uFFFF]/,
			regFlag: true
		},
		"首尾不能是空格": {
			msg: '首尾不能是空格',
			reg: /(^\s+)|(\s+$)/,
			regFlag: true
		},
		"怪字符": {
			msg: '{name}不能包含特殊字符',
			reg: />|<|,|\[|\]|\{|\}|\?|\/|\+|=|\||\'|\\|\"|:|;|\~|\!|\@|\#|\*|\$|\%|\^|\&|\(|\)|`/i ,
			regFlag : true
		},
		"怪字符pwd": {
			msg: '密码请勿使用特殊字符',
			reg:/[\w\~\!\@\#\$\%\^\&\*\(\)\+\`\-\=\[\]\\\{\}\|\;\'\:\"\,\.\/\<\>\?]/i,
			regFlag : false
		},
		"全部怪字符": {
			msg: '{name}不能包含特殊字符',
			reg: />|<|,|\[|\]|\{|\}|\?|\/|\+|=|\||\'|\\|\"|:|;|\~|\!|\@|\#|\*|\$|\%|\^|\&|\(|\)|\-|\—|\.|`/i ,
			regFlag : true
		},
		"有中文": {
			msg: '{name}不支持中文',
			reg: /[\u4E00-\u9FA5]/i,
			regFlag : true
		},
		"特殊字符": {
			msg: '{name}不支持特殊字符',
			reg: /[^a-zA-Z\.·\u4E00-\u9FA5\uFE30-\uFFA0]/i,
			regFlag : true
		},
		"下划线": {
			msg: '下划线不能在最后',
			fn:  function(e, v){
				var val = e.value;
				return (val.slice(val.length-1)=="_") ? this.msg : '';
			}
		},
		"首尾不能是下划线": {
			msg: '首尾不能是下划线',
			reg: /(^_+)|(_+$)/,
			regFlag: true
		},
		"有下划线": {
			msg: '不能包含下划线',
			fn:  function(e, v){
				var val = e.value;
				return (val.search("_") >= 0) ? this.msg : '';
			}
		},
		"可为空": {
			fn:  function(e, v){
				if(!e.value){
					e.style.background = '';
					return 'custom';
				}else { 
					return ''; 
				}
			}
		},
		"数字字母": {
			msg: '不能包含数字和英文字母以外的字符',
			reg: /[^0-9a-zA-Z]/i,
			regFlag : true
		},
		"数字字母中文": {
			msg: '不能包含数字、英文字母和汉字以外的字符',
			reg: /[^0-9a-zA-Z\u4E00-\u9FA5]/,
			regFlag : true
		},
		"数字字母中文空格下划线": {
			msg: '不能包含全角字符',
			reg: /[^0-9a-zA-Z\u4E00-\u9FA5\_\ ]/,
			regFlag : true
		},
		"非新浪邮箱": {
			fn: function(e,v) {
				var reg = /^[0-9a-z][_.0-9a-z-]{0,31}@((sina|vip\.sina|2008.sina|staff\.sina)\.){1}(cn|com|com\.cn){1}$/;
				if(reg.test(e.value)) {
					var entry = document.getElementById("entry").value;
					if ( entry == "client") {
						var url = location.href;
						var es=/invit=/;
						es.exec(url);
						var invite = RegExp.rightContext;
						if( invite == "1") {
							return '您有新浪邮箱吗？请直接<a href=\'http://life.sina.com.cn/invitfriend/login\'>登录</a>';
						}else {
							return '您有新浪邮箱吗？请直接<a href=\'http://life.sina.com.cn/passport/login\'>登录</a>';
						}
					}else if ( entry == "fzonline") {
						return '您有新浪邮箱吗？请直接<a href=\'http://passport.fzplay.com.cn/login.php\'>登录</a>';
					}else if ( entry == "miniblog") {
						var miniblog_mail = document.getElementById("username").value;
						return '您有新浪邮箱吗？请直接<a href=\'http://weibo.com/login.php?email=' + miniblog_mail + '\'>登录</a>';
					}else if ( entry == 'webuc'){
						return 	'使用新浪邮箱可直接<a href=\'http://login.sina.com.cn/signup/signin.php?entry=' + document.getElementById("entry").value + '\'>登录</a>';
					}else {
						return '您有新浪邮箱吗？请直接<a href=\'http://login.sina.com.cn/signup/signin.php?entry=' + document.getElementById("entry").value + '\'>登录</a>';
					}
				}else {
					return '';
				}
			}
			//msg: '新浪邮箱请直接<a href=\'http://login.sina.com.cn/hd/signin.php?entry=' + document.getElementById("entry") + '\'>登录</a>',
			//reg:  /^[0-9a-z][_.0-9a-z-]{0,31}@((sina|vip\.sina|2008.sina|staff\.sina)\.){1}(cn|com|com\.cn){1}$/,
			//regFlag : true
		},
		"无选中": {
			msg: '请选择{name}',
			fn: function(e,v) {
				switch (e.type.toLowerCase()) {
					case 'checkbox':
						return e.checked ? 'clear' : this.msg;
					case 'radio':
						var radioes = document.getElementsByName(e.name);
						for(var i=0; i<radioes.length; i++) {
							if(radioes[i].checked) return 'clear';
						}
						return this.msg;
					default:
						return 'clear';
				}
			}
		},
			"无选择": {
			msg: '请选择{name}',
			fn: function(e,v) {
				switch (e.type.toLowerCase()) {
					case 'select-one':
							return e.value ? 'clear': this.msg;
					default:
						return 'clear';
				}
			}
		},
		"条款": {
			msg: '{name}',
			fn: function(e,v) {
				switch (e.type.toLowerCase()) {
					case 'checkbox':
						return e.checked ? 'clear' : this.msg;
					case 'radio':
						var radioes = document.getElementsByName(e.name);
						for(var i=0; i<radioes.length; i++) {
							if(radioes[i].checked) return 'clear';
						}
						return this.msg;
					default:
						return 'clear';
				}
			}
		},
		"判断强度": {
			fn: function(e,v) {
				for (var i=1;i<=3;i++) {
					try {
						$removeClassName($("passW" + i), "passWcurr");
					}catch (e) {}
				}
				var password = e.value;
				var Modes = 0;
				var n = password.length;
				for (var i=0;i<n;i++) {
					Modes |= CharMode(password.charCodeAt(i));
				}
				var btotal = bitTotal(Modes);
				if (n >= 10) btotal++;
				switch(btotal) {
					case 1:
						try {
							$addClassName($("passW1"), "passWcurr");
						}catch (e) {}
						return;
					case 2:
						try {
							$addClassName($("passW2"), "passWcurr");
						}catch (e) {}
						return;
					case 3:
						try {
							$addClassName($("passW3"), "passWcurr");
						}catch (e) {}
						return;
					case 4:
						try {
							$addClassName($("passW3"), "passWcurr");
						}catch (e) {}
						return;
					default:
						return;
				}
			}
		},
		"判断强度2": {
			fn: function(e,v) {
				for (var i=4;i<=6;i++) {
					try {
						$removeClassName($("passW" + i), "passWcurr");
					}catch (e) {}
				}
				var password = e.value;
				var Modes = 0;
				var n = password.length;
				for (var i=0;i<n;i++) {
					Modes |= CharMode(password.charCodeAt(i));
				}
				var btotal = bitTotal(Modes);
				if (n >= 10) btotal++;
				switch(btotal) {
					case 1:
						try {
							$addClassName($("passW4"), "passWcurr");
						}catch (e) {}
						return;
					case 2:
						try {
							$addClassName($("passW5"), "passWcurr");
						}catch (e) {}
						return;
					case 3:
						try {
							$addClassName($("passW6"), "passWcurr");
						}catch (e) {}
						return;
					case 4:
						try {
							$addClassName($("passW6"), "passWcurr");
						}catch (e) {}
						return;
					default:
						return;
				}
			}
		},
		"判断验证码": {
			fn: function(e,v) {
				if (/^[0-9a-zA-Z]/.test(e.value)) {
					if (/[^0-9a-zA-Z]/.test(e.value)) return "验证码错误";
				}else if (/^[\u4E00-\u9FA5]/.test(e.value)) {
					if (/[^\u4E00-\u9FA5]/.test(e.value)) return "验证码错误";
				}
				return "";
			}
		},
		"排重": { fn: checkUsername },
		"邮箱注册排重": { fn: checkFreemail },
		"查域名": { fn: checkDomain },
		"验证生日": { fn: checkDate },
		"连续字符" : {
			msg : '密码不能为连续字符',
			fn : function(e,v) {
				var n = '012345678909876543210';
				var c = 'abcdefghijklmnopqrstuvwxyzyxwvutsrqponmlkjihgfedcba';
				var el = e;
				c += c.toUpperCase();
				if(n.indexOf(el.value) != -1 || c.indexOf(el.value) != -1){
					return '密码不能为连续字符';
				}else if(el.value.match(/^(\d+)([a-zA-Z]+)$/)){
					var arrStr = el.value.match(/^(\d+)([a-zA-Z]+)$/);
					if(n.indexOf(arrStr[1]) != -1 && c.indexOf(arrStr[2]) != -1){return '密码不能为连续字符';}else{return false;}
				}else if(el.value.match(/^([a-zA-Z]+)(\d+)$/)){
					var arrStr = el.value.match(/^([a-zA-Z]+)(\d+)$/);
					if(c.indexOf(arrStr[1]) != -1 && n.indexOf(arrStr[2]) != -1){return '密码不能为连续字符';}else{return false;}
				}else{
					return false;
				}
			}
		},
		"重复字符" : {
			msg : '密码不能全为相同字符',
			fn : function(e,v) {
				var newStr = e.value.replace(/(.)\1+/,'a');
				if(newStr.length == 1){
					return '密码不能全为相同字符';
				}else{
					return false;
				}
			}
		}	
	}
	
	//注册全局conf对象
	if (window.$vconf == null) window.$vconf = conf;
})();
