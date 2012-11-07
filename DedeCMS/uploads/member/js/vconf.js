/**
 * @fileoverview ����֤�� ��֤�������ö�����validator.js���ʵ�ֱ���֤
 * @author xs | zhenhau1@staff.sina.com.cn
**/
(function(){

	// �ж������ղ���
	//д��onReady�¼�������Ϊ�жϺ��������������ִ������ÿ���뵱ǰ���ÿ�ܲ���һ�ף��߼�ִ��˳���б仯��
	//�����������ַ�����֤$('year')��Ϊnull
	onReady(function(){
	    var yearNode = $("year");
	    var monthNode = $("month");
	    var dayNode = $("day");
	    var MonHead = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	    var birthday = {
	        YYYYMMDDstart: function(year, month, day){
	    		if(!yearNode) return;
	    	
	            yearNode.options.add(new Option("��ѡ��", ""));
	            monthNode.options.add(new Option("--", ""));
	            dayNode.options.add(new Option("--", ""));
	//            monthNode.options.add(new Option("--", "00"));
	            dayNode.options.add(new Option("--", "00"));
	            
	            //�ȸ�������������  
	            var y = new Date().getFullYear();
	            for (var i = (y - 109); i < (y + 1); i++) //�Խ���Ϊ׼����ʾǰ30��֮���20��  
	            {
	                yearNode.options.add(new Option("" + i + "", i));
	            }
	            //���·ݵ�������  
	            for (var i = 1,j=1; i < 13; i++) {
					  if (j < 10) {
	                    j = "0" + j;
	                }
	                monthNode.options.add(new Option("" + i + "", j));
					j++;
	            }
	            
	            yearNode.value = year; //��ȡ����ǰ���
	            monthNode.value = month; // ��ȡ����ǰ�·�
	            var n = MonHead[new Date().getMonth()];
	            if (new Date().getMonth() == 1 && this.IsPinYear(year)) {
	                n++;
	            }
	            this.writeDay(n); //������������Author:meizz  
	             // ��ȡ����ǰ����
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
    //����

	
	/**
	* SSO check user exist
	* author lijun
	* date 2007.5.8
	* last modify by xs | zhenhau1@staff.sina.com.cn
	*/
	var checkUrl = "/signup/check_user.php";
	var checkDomainUrl = "/signup/check_domain.php";
	var memberYes = "�û����ѱ�ע��";
	var memberNo = "�û�������";
	var error = "�첽ͨ�Ŵ���";
	var defer = "���Ĳ�������Ƶ�������Ժ����ԡ�";
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
	 * �ж��û����Ƿ����ظ��������Ѿ����뷽��
	 */	
	function checkUsername(e, v) {
		checkUserExist('othermail', e.value, function(from, responseText){
			if(from == 'othermail'){
				var msg = "";
				if(responseText.search("no")>=0){
					msg = 'hide';
				}else if(responseText.search("yes")>=0){
					msg = '����ע��';
				}else if(responseText.search("defer")>=0){
					msg = '���Ĳ�������Ƶ�������Ժ����ԡ�';
				}else{
					msg = '�첽ͨ�Ŵ���';
				}
				v.showErr(e, msg);
			}
		});
	}
	function $E(id){
		return document.getElementById("id");
	}
	/**
	 * �ж��û����Ƿ����ظ��������Ѿ����뷽��
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
					msg = '���������ѱ�ռ��';
				}else if(responseText.search("defer")>=0){
					msg = '���Ĳ�������Ƶ�������Ժ����ԡ�';
				}else{
					msg = '�첽ͨ�Ŵ���';
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
						document.getElementById("com_tip").innerHTML = "����ע��";
						document.getElementById("typecn").checked = false;
						document.getElementById("typecn").disabled = "true";
						document.getElementById("typecn").className = "notifyType cursorDft";
						document.getElementById("cnname").className = "email_name_disabled fb";
						document.getElementById("cnlocation").className = "location_disabled";
						document.getElementById("cn_tip").className = "info_disabled";
						document.getElementById("cn_tip").innerHTML = "�ѱ�ע��";
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
						document.getElementById("com_tip").innerHTML = "�ѱ�ע��";
						document.getElementById("typecom").checked = false;
						document.getElementById("typecn").disabled = "";
						document.getElementById("typecn").className = "notifyType";
						document.getElementById("cnname").className = "email_name fb";
						document.getElementById("cnlocation").className = "location";
						document.getElementById("cn_tip").className = "info";
						document.getElementById("cn_tip").innerHTML = "����ע��";
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
						document.getElementById("com_tip").innerHTML = "����ע��";
						document.getElementById("typecom").checked = false;
						document.getElementById("typecn").disabled = "";
						document.getElementById("typecn").className = "notifyType";
						document.getElementById("cnname").className = "email_name fb";
						document.getElementById("cnlocation").className = "location";
						document.getElementById("cn_tip").className = "info";
						document.getElementById("cn_tip").innerHTML = "����ע��";
						document.getElementById("comname").innerHTML = value;
						document.getElementById("cnname").innerHTML = value;
						document.getElementById("typecn").checked = false;
						document.getElementById("emailname").parentNode.parentNode.className = "input";
					}
					if(atext[3] == "yes" && atext[1] == "yes"){
						msg = '����ע��';
						v.showErr(e, msg);
					}
				}else if(responseText.search("yes")>=0 && atext.length == 1){
					msg = '����ע��';
					v.showErr(e, msg);
				}else if(responseText.search("defer")>=0){
					msg = '���Ĳ�������Ƶ�������Ժ����ԡ�';
					v.showErr(e, msg);
				}else{
					msg = '�첽ͨ�Ŵ���';
					v.showErr(e, msg);
				}
			}
		});
	}

	/**
	 *  ͨ�� Ajax �ж������Ƿ����ظ��������Ѿ����뷽��
	 */
	function checkDomain(e, v) {
		checkDomainExist('sinauser', e.value, function(from, responseText){
			if(from == 'sinauser'){
				var msg = "";
				if(responseText.search("no")>=0){
					msg = 'hide';
				}else if(responseText.search("yes")>=0){
					msg = '�����ѱ���';
				}else{
					msg = '�첽ͨ�Ŵ���';
				}
				v.showErr(e, msg);
			}
		});
	}
	
	/**
	 *  ��������ǿ�ȷ���1
	 */
	function CharMode(iN) {
		if (iN >= 65 && iN <= 90) return 2;
		if (iN >= 97 && iN <= 122) return 4;
		else return 1;
	}
	
	/**
	 *  ��������ǿ�ȷ���2
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
	 * ������֤
	 * @return {Boolean} ����������֤���
	 */
	function checkDate(e, v){
		var yearNode = $('year');
		var monthNode = $('month');
		var dayNode = $('day');
		
		if(yearNode.value==""){
			v.showErr(e, "��ѡ���������");
			return true;
		}
		if(monthNode.value==""){
			v.showErr(e, "��ѡ�������·�");
			return true;
		}
		if(dayNode.value==""){
			v.showErr(e, "��ѡ����������");
			return true;
		}

		if(yearNode.value>new Date().getFullYear()||(yearNode.value==new Date().getFullYear() && monthNode.value>(new Date().getMonth()+1))||(yearNode.value==new Date().getFullYear()&& monthNode.value==(new Date().getMonth()+1)&&dayNode.value>(new Date().getDate()))){
			v.showErr(e, "���ղ�Ӧ���ڵ�ǰ����");
			return true;
		}
		return false;
	}
	
	
	/**
	 * ����֤�� ��֤�������ö���
	 */
	var conf = {
		/**
		 *  �����ύʱִ�еĺ���
		 */
		//'submitFn': function(el){
			
		//},
		/**
		 *  ��ȡ����ʱִ�еĺ���
		 *  �����ж�ǿ����Ҫ����ӦHTML�ṹ֧��
		 */
		'focusFn': function(el, v){
			var alt = el.alt;
			var arg = /focusFn{([^}].+?)}/.exec(alt);
			arg = (arg == null) ? false : arg[1];
			$removeClassName($(arg), 'hide');
		},
		'����': {						
			msg: '{name}����ӦΪ{range}λ'
		},
		'��ͬ': {						
			msg: '{name}��һ��'
		},
		'֧�����벻ͬ������': {						
			msg: 'Ϊ���������ʽ�ȫ��֧������͵�¼���벻����ͬ',
	        fn : function(e, v){
				var val = e.value;
				if(!val) return '';
				return ($('password').value == $('paypassword').value)?this.msg:'';
	        }
		},
		"������": {
			msg: '������{name}',
			fn:  function(e, v){
				var val = e.value;
				if(e.id == "checkName" || e.id == "changeName"){
					val = document.getElementById("emailname").value;
				}
				return (val!="�����ʾ��֤��" && /./.test(val)) ? 'clear' : this.msg;
			}
		},
		"������sel": {
			msg: '��ѡ��{name}',
			reg: /./
		},
		"ȫ����": {
			msg: '{name}����Ϊȫ����',
			reg: /[^\d]+/
		},
		"������": {
			msg: '{name}����������',
			reg: /^[^\d]+$/
		},
		"�пո�": {
			msg: '{name}���ܰ����ո��',
			reg: /^[^ ��]+$/
		},
		"�����ַ": {
			msg: '�����ַ��ʽ����ȷ',
			reg: /^[0-9a-z][_.0-9a-z-]{0,31}@([0-9a-z][0-9a-z-]{0,30}\.){1,4}[a-z]{2,4}$/
		},
		"�ֻ�����": {
			msg: '{name}����ȷ',
			reg: /^1(3\d{1}|5[389])\d{8}$/
		},
		"֤������": {
			msg: '{name}����ȷ',
			reg: /^(d){5,18}$/
		},
		"�д�д": {
			msg: '{name}�����д�д��ĸ',
			reg: /[A-Z]/,
			regFlag: true
		},
		"��ȫ��": {
			msg: '{name}���ܰ���ȫ���ַ�',
			reg: /[\uFF00-\uFFFF]/,
			regFlag: true
		},
		"��β�����ǿո�": {
			msg: '��β�����ǿո�',
			reg: /(^\s+)|(\s+$)/,
			regFlag: true
		},
		"���ַ�": {
			msg: '{name}���ܰ��������ַ�',
			reg: />|<|,|\[|\]|\{|\}|\?|\/|\+|=|\||\'|\\|\"|:|;|\~|\!|\@|\#|\*|\$|\%|\^|\&|\(|\)|`/i ,
			regFlag : true
		},
		"���ַ�pwd": {
			msg: '��������ʹ�������ַ�',
			reg:/[\w\~\!\@\#\$\%\^\&\*\(\)\+\`\-\=\[\]\\\{\}\|\;\'\:\"\,\.\/\<\>\?]/i,
			regFlag : false
		},
		"ȫ�����ַ�": {
			msg: '{name}���ܰ��������ַ�',
			reg: />|<|,|\[|\]|\{|\}|\?|\/|\+|=|\||\'|\\|\"|:|;|\~|\!|\@|\#|\*|\$|\%|\^|\&|\(|\)|\-|\��|\.|`/i ,
			regFlag : true
		},
		"������": {
			msg: '{name}��֧������',
			reg: /[\u4E00-\u9FA5]/i,
			regFlag : true
		},
		"�����ַ�": {
			msg: '{name}��֧�������ַ�',
			reg: /[^a-zA-Z\.��\u4E00-\u9FA5\uFE30-\uFFA0]/i,
			regFlag : true
		},
		"�»���": {
			msg: '�»��߲��������',
			fn:  function(e, v){
				var val = e.value;
				return (val.slice(val.length-1)=="_") ? this.msg : '';
			}
		},
		"��β�������»���": {
			msg: '��β�������»���',
			reg: /(^_+)|(_+$)/,
			regFlag: true
		},
		"���»���": {
			msg: '���ܰ����»���',
			fn:  function(e, v){
				var val = e.value;
				return (val.search("_") >= 0) ? this.msg : '';
			}
		},
		"��Ϊ��": {
			fn:  function(e, v){
				if(!e.value){
					e.style.background = '';
					return 'custom';
				}else { 
					return ''; 
				}
			}
		},
		"������ĸ": {
			msg: '���ܰ������ֺ�Ӣ����ĸ������ַ�',
			reg: /[^0-9a-zA-Z]/i,
			regFlag : true
		},
		"������ĸ����": {
			msg: '���ܰ������֡�Ӣ����ĸ�ͺ���������ַ�',
			reg: /[^0-9a-zA-Z\u4E00-\u9FA5]/,
			regFlag : true
		},
		"������ĸ���Ŀո��»���": {
			msg: '���ܰ���ȫ���ַ�',
			reg: /[^0-9a-zA-Z\u4E00-\u9FA5\_\ ]/,
			regFlag : true
		},
		"����������": {
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
							return '����������������ֱ��<a href=\'http://life.sina.com.cn/invitfriend/login\'>��¼</a>';
						}else {
							return '����������������ֱ��<a href=\'http://life.sina.com.cn/passport/login\'>��¼</a>';
						}
					}else if ( entry == "fzonline") {
						return '����������������ֱ��<a href=\'http://passport.fzplay.com.cn/login.php\'>��¼</a>';
					}else if ( entry == "miniblog") {
						var miniblog_mail = document.getElementById("username").value;
						return '����������������ֱ��<a href=\'http://weibo.com/login.php?email=' + miniblog_mail + '\'>��¼</a>';
					}else if ( entry == 'webuc'){
						return 	'ʹ�����������ֱ��<a href=\'http://login.sina.com.cn/signup/signin.php?entry=' + document.getElementById("entry").value + '\'>��¼</a>';
					}else {
						return '����������������ֱ��<a href=\'http://login.sina.com.cn/signup/signin.php?entry=' + document.getElementById("entry").value + '\'>��¼</a>';
					}
				}else {
					return '';
				}
			}
			//msg: '����������ֱ��<a href=\'http://login.sina.com.cn/hd/signin.php?entry=' + document.getElementById("entry") + '\'>��¼</a>',
			//reg:  /^[0-9a-z][_.0-9a-z-]{0,31}@((sina|vip\.sina|2008.sina|staff\.sina)\.){1}(cn|com|com\.cn){1}$/,
			//regFlag : true
		},
		"��ѡ��": {
			msg: '��ѡ��{name}',
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
			"��ѡ��": {
			msg: '��ѡ��{name}',
			fn: function(e,v) {
				switch (e.type.toLowerCase()) {
					case 'select-one':
							return e.value ? 'clear': this.msg;
					default:
						return 'clear';
				}
			}
		},
		"����": {
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
		"�ж�ǿ��": {
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
		"�ж�ǿ��2": {
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
		"�ж���֤��": {
			fn: function(e,v) {
				if (/^[0-9a-zA-Z]/.test(e.value)) {
					if (/[^0-9a-zA-Z]/.test(e.value)) return "��֤�����";
				}else if (/^[\u4E00-\u9FA5]/.test(e.value)) {
					if (/[^\u4E00-\u9FA5]/.test(e.value)) return "��֤�����";
				}
				return "";
			}
		},
		"����": { fn: checkUsername },
		"����ע������": { fn: checkFreemail },
		"������": { fn: checkDomain },
		"��֤����": { fn: checkDate },
		"�����ַ�" : {
			msg : '���벻��Ϊ�����ַ�',
			fn : function(e,v) {
				var n = '012345678909876543210';
				var c = 'abcdefghijklmnopqrstuvwxyzyxwvutsrqponmlkjihgfedcba';
				var el = e;
				c += c.toUpperCase();
				if(n.indexOf(el.value) != -1 || c.indexOf(el.value) != -1){
					return '���벻��Ϊ�����ַ�';
				}else if(el.value.match(/^(\d+)([a-zA-Z]+)$/)){
					var arrStr = el.value.match(/^(\d+)([a-zA-Z]+)$/);
					if(n.indexOf(arrStr[1]) != -1 && c.indexOf(arrStr[2]) != -1){return '���벻��Ϊ�����ַ�';}else{return false;}
				}else if(el.value.match(/^([a-zA-Z]+)(\d+)$/)){
					var arrStr = el.value.match(/^([a-zA-Z]+)(\d+)$/);
					if(c.indexOf(arrStr[1]) != -1 && n.indexOf(arrStr[2]) != -1){return '���벻��Ϊ�����ַ�';}else{return false;}
				}else{
					return false;
				}
			}
		},
		"�ظ��ַ�" : {
			msg : '���벻��ȫΪ��ͬ�ַ�',
			fn : function(e,v) {
				var newStr = e.value.replace(/(.)\1+/,'a');
				if(newStr.length == 1){
					return '���벻��ȫΪ��ͬ�ַ�';
				}else{
					return false;
				}
			}
		}	
	}
	
	//ע��ȫ��conf����
	if (window.$vconf == null) window.$vconf = conf;
})();
