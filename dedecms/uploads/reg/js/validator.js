/**
 * @fileoverview ����֤��
 * @author xs | zhenhau1@staff.sina.com.cn
 * @version 0.1
 */
(function(){

    /**
     * @constructor
     * @param {Object} ����֤�� ���캯��
     * @author xs
     */
    var $vdt = function(config){
		/**
		* ��ָ�룬��ǰ��
		* @type {Object}
		*/	
        var me = this;
		
		/**
		* �����ö���, ���е���֤������ʾ��Ϣ���Ǵ������ȡ
		* @type {Object}
		*/			
        this.opt = config;

		/**
		* �����ý���ʱ����ʽ����
		* @type {String}
		*/		
		this.focFun = function(node) {
			me.setState(node, 1);
		};
		/**
		* ��֤����ʱ����ʽ����
		* @type {String}
		*/			
        this.errFun = function(node) {
			me.setState(node, 2);
		};
		/**
		* ��֤��ȷʱ����ʽ����
		* @type {String}
		*/
        this.finFun = function(node) {
			me.setState(node, 0);
		};

		/**
		* �ָ�����
		* @type {String}
		*/
		var splitSign = ':';
		
		/**
		 * ���ñ������ʽ
         * @param {Object} ������
         * @param {Num} ״̬���� 0-Ĭ�� 1-�� 2-��
		 */
		this.setState = function(node, type) {
			var input = node;
			while(node && node != document) {
				if(node.tagName.toLowerCase() == "span" && hasClass(node, "input")) {
					switch(type) {
						case 0:
							$removeClassName(node, "inputGreen");
							$removeClassName(node, "inputRed");
							return;
						case 1:
							$removeClassName(node, "inputRed");
							$addClassName(node, "inputGreen");
							return;
						case 2:
							$removeClassName(node, "inputGreen");
							$addClassName(node, "inputRed");
							return;
						default:
							$removeClassName(node, "inputGreen");
							$removeClassName(node, "inputRed");
							return;
					}
				}
				node = node.parentNode;
			}
		};
		
	   /**
		 * Ĭ����֤����(������֤ģʽ)
         * @param {Object} ������
         * @param {Object} Validator ����ʵ��
		 */
		this.defaultRegFn = function(e, v){
			//trace( 'regFlag:'+ this.regFlag +' ||' +this.reg + '|this.reg.test('+e.value+'):' + this.reg.test(e.value));
			var val = e.value;
			if(e.id == "checkName" || e.id == "changeName"){
				val = document.getElementById("emailname").value;
			}
			if(this.regFlag) {
				return this.reg.test(val) ? this.msg : '';
			}else {
				return !this.reg.test(val) ? this.msg : '';
			}
        };

	   /**
		 * Ĭ����֤����(��Χ��֤ģʽ)
         * @param {Object} ������
         * @param {Object} Validator ����ʵ��
		 */
		this.defaultRangeFn = function(e, v){
			var len = e.value.getBytes();
			if(e.id=='password' || e.id=='password2'){
				len = e.value.length;
			}
			if(e.id == "checkName" || e.id == "changeName"){
				len = document.getElementById("emailname").value.getBytes();
			}
			if(!len) return '';
			var alt = (e.alt || e.getAttribute("alt"));
			var range =  /����{(.+?)}/.exec(alt)[1];
			var l = range.split('-')[0];
			var r = range.split('-')[1];
			if(len < l || len > r) return this.msg.replace('{range}', range);
			return '';
        };

	   /**
		 * Ĭ����֤����(��֤�Ƿ���Ŀ��ֵ��ͬ[һ������ȷ������])
         * @param {Object} ������
         * @param {Object} Validator ����ʵ��
		 */
		this.defaultSameFn = function(e, v){
			var val = e.value;
			if(!val) return '';
			var alt = (e.alt || e.getAttribute("alt"));
			var id =  /��ͬ{(.+?)}/.exec(alt)[1];
			if(!$(id)) return '';
			return ($(id).value != val)?this.msg:'';
        };
        
        /**
         * ���ʼ�������ݱ���Ϊ������Ҫ��֤�Ķ�������¼�
         * @param {String} ��id
         */
        this.init = function(id){
			var fm = $(id);
			if(!fm) {
				alert('�� [' + id + '] δ�ҵ���');
				return;
			}
            var fe = fm.elements;
            var fl = fe.length;
            for (var i = 0; i < fl; i++) {
                var cur = fe[i];
                var alt = ((cur.alt || cur.getAttribute("alt")) + '');
                if (alt.indexOf(splitSign) != -1) {
                    cur.onfocus = this.chkFocus;
                    cur.onblur = this.check;
					/**
					 * ��������룬�����Ӱ����붯�����¼��������ж�����ǿ��
					 */
					if (cur.id.toLowerCase() == "password") {
						cur.onkeydown = this.chkKeyboard;
						cur.onkeyup = this.chkKeyboard;
					}
					if (cur.id.toLowerCase() == "door") {
						cur.value = "�����ʾ��֤��";
						cur.style.color = "#999999";
					}
					/**
					 * ��ǰ��ָ�봫�ݸ���������Ա����
					 * @type {Object}
					 */
                    cur.v = this;
                }
            }
//						if($('mailTypeValue').value == "comcn"){
//							document.getElementById("checkName").onclick = this.checkButton;
//						}
						if(document.getElementById("regmail") != null && document.getElementById("regmail").value == "regmail"){
							document.getElementById("checkName").onclick = this.checkButton;
						}
			fm.v = this;
            fm.onsubmit = this.checkSubmit;
        };


        /**
         * �жϵ�ǰ��Ҫʹ�ù���Ķ���
         * @param {String} altֵ�е�ǰ������
         * @param {Object} ��ǰ�������ö���
         */
		this.getCur = function(c, conf){
			var cur = conf[c];
			if (c.indexOf('����')!=-1){
				cur = conf['����'];
				cur.fn = this.defaultRangeFn;
			}
			if (c.indexOf('��ͬ')!=-1){
				cur = conf['��ͬ'];
				cur.fn = this.defaultSameFn;
			}
			if(!cur) return null;
			if (!cur.fn) cur.fn = this.defaultRegFn;
			return cur;
		};
        
        /**
         * ���ݶ���alt���Բ������ü�config�����ý��б�Ԫ����֤
         * @param {Object} fireFox ���¼�Դ(��ʱû�õ�)
         * @param {Object} ���ָ���ı�����
         */		
        this.check = function(e, el){
            var el = el || this;
//						if($('mailTypeValue').value == "comcn"){
//							if(e != "submit" && document.getElementById("emailname").parentNode.parentNode.className == "input"){
//								if(el.id == "emailname" || el.id == "changeName" || el.id == "checkName"){
//									return false;
//								}
//							}
//						}
						if(document.getElementById("regmail") != null && document.getElementById("regmail").value == "regmail"){
							if(e != "submit" && document.getElementById("emailname").parentNode.parentNode.className == "input"){
								if(el.id == "emailname" || el.id == "changeName" || el.id == "checkName"){
									return false;
								}
							}
							if(el.id == "emailname" && document.getElementById("check").style.display == "none" && (document.getElementById("mailTypeValue").value == "**" || document.getElementById("mailTypeValue").value == "cn")){
								return false;
							}
						}
            var v = el.v;
            var o = v.opt;
            var alt = el.alt || el.getAttribute('alt');
            var args = alt.split(splitSign)[1].split('/');
            var l = args.length;
            for (var i = 0; i < l; i++) {
                var c = args[i];
				var cur = v.getCur(c, o);
                if (cur) {
					try {
						trace(cur.fn);
						var result = cur.fn(el, v);
						if(result == 'custom'){
							break;
						}
						if(result){
							v.showErr(el, result);
							if(result == 'clear') continue;
							return false;
						}
					}catch (e) {
						return false;
					}
                }
            }
			if(result == 'clear') {
				v.showErr(el, result);
			}else {
				if(el.id != "emailname" && el.id != "checkName" && el.id != "changeName"){
					v.showErr(el,'hide');
				}
			}
			return true;
        };
				this.checkButton = function(e, el){
						if(document.getElementById("emailname").parentNode.parentNode.className == "input"){
							return;
						}
						var el = el || this;
            var v = el.v;
            var o = v.opt;
            var alt = el.alt || el.getAttribute('alt');
            var args = alt.split(splitSign)[1].split('/');
            var l = args.length;
            for (var i = 0; i < l; i++) {
                var c = args[i];
				var cur = v.getCur(c, o);
                if (cur) {
					try {
						trace(cur.fn);
						var result = cur.fn(el, v);
						if(result == 'custom'){
							break;
						}
						if(result){
							v.showErr(el, result);
							if(result == 'clear') continue;
							return false;
						}
					}catch (e) {
						return false;
					}
                }
            }
			if(result == 'clear') {
				v.showErr(el, result);
			}else {
				if(el.id != "emailname" && el.id != "checkName" && el.id != "changeName"){
					v.showErr(el,'hide');
				}
			}
			return true;
        };
        /**
         * �����ȡ����ʱִ�е��¼�
         */
        this.chkFocus = function(){
			if(this.type == 'password' || this.type == 'text') {
				me.focFun(this);
			}
			if(document.getElementById("regmail") != null && document.getElementById("regmail").value == "regmail"){
				if(this.id == 'password'|| this.id == 'changeName'){
					if(document.getElementById("typecom").checked == false && document.getElementById("typecn").checked == false){
						document.getElementById("tip_top").innerHTML = "<span style='color:#ff0000'>&nbspѡ��һ�������õ�������</span>";
					}
				}
			}
            var el = this;
            var v = el.v;
			var cur = v.opt;
            alt = el.alt || el.getAttribute('alt');
			try{
				if(alt.indexOf('focusFn')!= -1){
					//alert(cur.focusFn);
					if(cur.focusFn) cur.focusFn(el, v);
				}
				try {
					me.showErr(el, "clear");
					if (el.id == "password") {
						if (!$isVisible($("passW"))) $show($("passW"));
					}
					if (el.id == "door") {
						if (el.value == "�����ʾ��֤��") {
							el.value = "";
							el.style.color = "#000000";
						}
						if (!$isVisible($("door_img"))) {
							$show($("door_img"));
							con_code();
						}
					}
				}catch (e) {}
			}catch(e){ alert(e.description);}
        };
		
		/**
         * �����������ʱִ�е��¼�
         */
		this.chkKeyboard = function(){
            var el = this;
            var v = el.v;
			var cur = v.opt;
            alt = el.alt || el.getAttribute('alt');
			try{
				if(alt.indexOf('keyFn') != -1) {
					var arg = /keyFn{([^}].+?)}/.exec(alt);
					arg = (arg == null) ? false : arg[1];
					var args = arg.split('/');
					var l = args.length;
					for (var i = 0; i < l; i++) {
						var c = args[i];
						var cur = v.getCur(c, cur);
						if (cur) {
							try {
								trace(cur.fn);
								if(cur.fn) cur.fn(el, v);
							}catch (e) {
								return false;
							}
						}
					}
				}
			}catch(e){ alert(e.description);}
        };

        /**
         * �ύʱ������������Ҫ��֤��Ԫ�ض����һ�飬�Ա�֤����ȫ���ϸ�
         */
        this.checkSubmit = function(e){
			var fm = this;
			var v   = fm.v;
			var fe = fm.elements;
			var fl = fe.length;
			var flag = true;
			try{
				for (var i = 0; i < fl; i++) {
						var cur = fe[i];
						if(cur.id == "changeName"){
							continue;
						}
						if(cur.id == "checkName"){
							continue;
						}
						var alt = ((cur.alt || cur.getAttribute("alt")) + '');
						if (alt.indexOf(splitSign) != -1){
							if (!$isVisible(cur) && cur.id != "selectQid") continue;
							if (v.opt.submitFn){
								if(v.opt.submitFn(cur)){
									flag = true;
									continue;
								}
							}
							if (!v.check(e, cur)) {
								flag = false;
							}
						}
				}
				if(document.getElementById("regmail") != null && document.getElementById("regmail").value == "regmail"){
					if(document.getElementById("register").style.display == ""){
						var alt = [];
						alt[0] = "������";
						alt[1] = "������/����{4-16}/��β�������»���/ȫ�����ַ�/ȫ����/�»���/������/��ȫ��/�пո�/�д�д/����ע������/errArea{usernametip}";
						var name = alt[0];
						var args = alt[1];
						var msg = "����ѡ��һ��������";
						/**
								 *  ����alt�������жϴ�����ʾ�������
								 */
						var eid, errArea ;
						if(args.indexOf('errArea')!=-1) var eid = /errArea{(.+?)}/.exec(alt)[1];
						try {
							$(eid).innerHTML = "";
							e.errNode = null;
						}catch (e) {}
						errArea = $(eid) ? $(eid) : e.parentNode;
									if (!e.errNode) {
											var etips = $C('span');
											errArea.appendChild(etips);
											e.errNode = etips;
									}else {
											var etips = e.errNode;
									}
								/**
								 *  ����msg�ж��Ƿ���ʾ������ʾ
								 */
						switch(msg) {
							case "hide":
								etips.innerHTML = '<span class="inputacc"><span class="yes"></span></span>';
								if(e.type == 'password' || e.type == 'text') {
									this.finFun(e);
								}
								return;
							case "custom":
								etips.innerHTML = "";
								//errArea.removeChild(e.errNode);
								//e.errNode = null;
								return;
							case "clear":
								etips.innerHTML = "";
								return;
							default:
								etips.innerHTML = '<span class="inputacc link"><span class="error"></span><span class="red">'+ msg +'</span></span>';
								if(e.type == 'password' || e.type == 'text') {
									if(e.id == 'emailname'){
										if(document.getElementById("register").style.display == ""){
											document.getElementById("register").style.display = "none";
										}
										if(document.getElementById("msg").style.display == "none"){
											document.getElementById("msg").style.display = ""
										}
									}
									this.errFun(e);
									try {
										if (e.id == "password") $hide($("passW"));
									}catch (e) {}
								}
						}
						flag = false;
					}
				}
			}catch(e){ 
				flag = false;
			};

			if(null != document.getElementById ('province' )){
				var auto_p = document.getElementById ('province' ) ;
				var auto_t = document.getElementById ('autoModels' ) ;
				var auto_n = document.getElementById ('autoNick' ) ;
				var auto_pocine = document.getElementById ('perror' ) ;
				var auto_pocino = document.getElementById ('pok' ) ;
				var auto_mocine = document.getElementById ('merror' ) ;
				var auto_mocino = document.getElementById ('mok' ) ;

				var auto_pstyle = document.getElementById ('provincetip' ) ;
				var auto_tstyle = document.getElementById ('autoModelstip' ) ;
				var auto_nstyle = document.getElementById ('checkResult' ) ;
				
				auto_pstyle.style.color="#666";
				auto_tstyle.style.color="#666";
				auto_nstyle.style.color="#666";

				if(auto_p.value == 0){
					auto_pstyle.style.color="#CC0000";
					auto_pocino.style.display="none";
					auto_pocine.style.display="inline-block";
					flag = false;
				} else {
					auto_pocine.style.display="none";
					auto_pocino.style.display="inline-block";
				}
				if(auto_t.value == 0){
					auto_tstyle.style.color="#CC0000";
					auto_mocine.style.display="inline-block";
					auto_mocino.style.display="none";
					flag = false;
				}else{
					auto_mocino.style.display="inline-block";
					auto_mocine.style.display="none";
				}
				if(auto_n.value == ""){
					auto_nstyle.innerHTML="<span class=error></span>��̳��ʾ��������";
					auto_nstyle.style.color="#CC0000";
					flag = false;	
				}else{
					auto_nstyle.innerHTML="��̳��ʾ������<span class=yes></span>";
				}

			}

			if(!flag){
				alert("����д����Ϣ���������ҳ����ָ��ģ�");
				flag = false;
			}
			if(flag && document.getElementById("regmail") != null && document.getElementById("regmail").value == "regmail"){
					var _ua = window.navigator.userAgent.toLowerCase();
					var $IE = /msie/.test(_ua);
					var val;
					if($IE){
						val = document.getElementById("fullname").innerText;
					}else{
						val = document.getElementById("fullname").textContent;
					}
					var flag = val.substr(val.length-1,val.length);
					fm.username.value = fm.user_name.value;
					if(flag == "m"){
						fm.mailType.value = "**";
					}else if(flag == "n"){
						fm.mailType.value = "cn";
					}
			}
			return flag;
        };
		
        /**
         * ���ݴ���������ʾ��Ӧ�Ĵ�����ʾ
         */					
        this.showErr = function(e, msg){
			var alt	= (e.alt || e.getAttribute("alt")).split(splitSign);
			var name = alt[0];
			var args   = alt[1];
			var msg = msg.replace('{name}', name);
			/**
	         *  ����alt�������жϴ�����ʾ�������
	         */
			var eid, errArea ;
			if(args.indexOf('errArea')!=-1) var eid = /errArea{(.+?)}/.exec(alt)[1];
			try {
				$(eid).innerHTML = "";
				e.errNode = null;
			}catch (e) {}
			errArea = $(eid) ? $(eid) : e.parentNode;
            if (!e.errNode) {
                var etips = $C('span');
                errArea.appendChild(etips);
                e.errNode = etips;
            }else {
                var etips = e.errNode;
            }
	        /**
	         *  ����msg�ж��Ƿ���ʾ������ʾ
	         */
			switch(msg) {
				case "hide":
					etips.innerHTML = '<span class="inputacc"><span class="yes"></span></span>';
					if(e.type == 'password' || e.type == 'text') {
						this.finFun(e);
					}
					return;
				case "custom":
					etips.innerHTML = "";
					//errArea.removeChild(e.errNode);
					//e.errNode = null;
					return;
				case "clear":
					etips.innerHTML = "";
					return;
				default:
					etips.innerHTML = '<span class="inputacc link"><span class="error"></span><span class="red">'+ msg +'</span></span>';
					if(e.type == 'password' || e.type == 'text') {
						if(e.id == 'emailname'){
							if(document.getElementById("register").style.display == ""){
								document.getElementById("register").style.display = "none";
							}
							if(document.getElementById("msg").style.display == "none"){
								document.getElementById("msg").style.display = ""
							}
						}
						this.errFun(e);
						try {
							if (e.id == "password") $hide($("passW"));
						}catch (e) {}
					}
					return;
			}
        };
    };

	/**
	 *  ע��ȫ�ֶ���
	 */	
    if (window.Validator == null) window.Validator = $vdt;
})();
