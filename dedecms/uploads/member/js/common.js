/**
 * @fileoverview  ����������
 * @author xs | zhenhau1@staff.sina.com.cn
 */

/**
 *  debug box
 */
function trace(txt) {
	return;
	if(!$('debugbox')) {
		var debug = $C('textarea');
		debug.id = 'debugbox';
		debug.rows = '20';
		debug.cols = '150';
		document.body.appendChild(debug);
	}else{
		var debug = $('debugbox');
	}
	debug.value += (txt + ' \n--------------------------------------------------\n\n');
}

/**
 * ��Function�������bind����
 * @param {Object} Ŀ��󶨶���
 */
Function.prototype.bind = function(object) {
	var __method = this;
	return function() {
		__method.apply(object, arguments);
	}
};

/**
 * ��String�������getBytes�������Ի�ȡʵ���ֽڳ���(������2�ֽ�)
 */
String.prototype.getBytes = function() {
	return this.replace(/[^\x00-\xff]/ig,"oo").length;
};

/**
 * ��ָ���ڵ��ϰ���Ӧ���¼�
 * @method $addEvent2
 * @param {String} elm ��Ҫ�󶨵Ľڵ�id
 * @param {Function} func �¼�����ʱ��Ӧ�ĺ���
 * @param {String} evType �¼���������:click, mouseover
 * @global $addEvent2
 * @update 2008-2-28
 * @author	Stan | chaoliang@staff.sina.com.cn
 *					FlashSoft | fangchao@staff.sina.com.cn
 *					xs | zhenhau1@staff.sina.com.cn
 * @example
 * 		//�����testEle��alert "clicked"
 * 		$addEvent2("testEle",function () {
 * 			alert("clicked")
 * 		},'click');
 */
function $addEvent2(elm, func, evType, useCapture) {
	var elm = $(elm);
	if(!elm) return;
	var useCapture = useCapture || false;
	var evType = evType || 'click';
	if (elm.addEventListener) {
		elm.addEventListener(evType, func, useCapture);
		return true;
	}
	else if (elm.attachEvent) {
		var r = elm.attachEvent('on' + evType, func);
		return true;
	}
	else {
		elm['on' + evType] = func;
	}
};

/**
 * ��IE���������contains����
 * @example obj.contains(obj);
 */
if(!(/msie/).test(navigator.userAgent.toLowerCase())) {
	if(typeof(HTMLElement) != "undefined") {
		HTMLElement.prototype.contains = function (obj) {
			while(obj != null && typeof(obj.tagName) != "undefind") {
				if(obj == this) return true;
				obj = obj.parentNode;
			}
			return false;
		};
	}
}

/**
 * document.getElementById �Ŀ�ݷ�ʽ
 * @param {String} id�ִ�
 */
function $(oID) {
	var node = typeof oID == "string" ? document.getElementById(oID) : oID;
	if (node != null) {
		return node;
	}
	return null;
}

/**
 * document.createElement �Ŀ�ݷ�ʽ
 * @param {String} tagName�ִ�
 */
function $C(tagName){
    return document.createElement(tagName);
}

/**
 * �ж�ĳ�ַ����Ƿ���Ŀ��������
 * @param {String}  Ŀ��ؼ���
 * @param {Array}   Ŀ������
 * @param {Boolean}   �Ƿ�ȫ��(����ȫ��ͬ)
 */
function $inArr(key, arr, same) {
	if(!same) return arr.join(' ').indexOf(key) != -1;
	for (var i=0, l = arr.length; i< l ; i++) if(arr[i]==key) return true;
	return false;
}

/**
 * Ϊ������� className
 * @param {Object} ��Ҫ���className�Ľڵ�
 * @param {String}  Ҫ��ӵ� className
 */
function $addClassName(el, cls) {
	var el = $(el);
	if(!el) return;
	var clsNames = el.className.split(/\s+/);
	if(!$inArr(cls, clsNames, true)) el.className += ' '+cls;
};

/**
 * Ϊ����ɾ�� className
 * @param {Object} ��Ҫɾ��className�Ľڵ�
 * @param {String}  Ҫɾ���� className
 */
function $removeClassName(el, cls) {
	var el = $(el);
	if(!el) return;
	el.className = el.className.replace(new RegExp("(^|\\s+)" + cls + "(\\s+|$)"), ' ');
};

/**
 * �ж϶����Ƿ���ڸ� className
 * @param {Object} ��Ҫ�ж�className�Ľڵ�
 * @param {String}  Ҫ�жϵ� className
 */
function hasClass(node, className) {
	var elementClassName = node.className;
	return (elementClassName.length > 0 && (elementClassName == className || new RegExp("(^|\\s)" + className + "(\\s|$)").test(elementClassName)));
}

/**
 * ȡ��Ԫ�ص�Left
 * @param {Object} ��Ҫȡֵ��Ԫ�ؽڵ�
 */
function getLeft(node) {
	var obj = node;
	var aLeft = obj.offsetLeft;
	while(obj = obj.offsetParent) {
		aLeft += obj.offsetLeft;
	}
	return aLeft;
}

/**
 * ȡ��Ԫ�ص�Top
 * @param {Object} ��Ҫȡֵ��Ԫ�ؽڵ�
 */
function getTop(node) {
	var obj = node;
	var aTop = obj.offsetTop;
	while(obj = obj.offsetParent) {
		aTop += obj.offsetTop;
	}
	return aTop;
}

/**
 * ��ȡ��ǰ������Ӧ�õ���ʽ
 * @param {Object} Ŀ�����
 * @param {String}  ��Ҫ��ȡ����ʽ����
 */
function GetCurrentStyle(el, prop) {
	if (el.currentStyle) {
		return el.currentStyle[prop];
	}else if (window.getComputedStyle) {
		prop = prop.replace(/([A-Z])/g, "-$1");
		prop = prop.toLowerCase();
		return window.getComputedStyle(el, "").getPropertyValue(prop);
	}
	return null;
}

/**
 * �л�HTMLԪ����ʾ/����״̬
 * @param {String} Ԫ��id
 * @param {String} Ԫ�� display ״̬�ַ� ( 'none' , 'block', '');
 */
function $toggle(el, flag){
	var el = $(el);
	if(!el) return;
	var curState = GetCurrentStyle(el, 'display');
	if(typeof flag == 'undefined') flag = (curState == 'none' ? 'block' : 'none');
	el.style.display = flag;
}

/**
 * ��ʾһ��HTMLԪ��
 * @param {String} Ԫ��id
 */
function $show(el){
	$toggle(el, '');
}

/**
 * ����һ��HTMLԪ��
 * @param {String} Ԫ��id
 */
function $hide(el){
	$toggle(el, 'none');
}

/**
 * �ж�Ԫ���Ƿ�ɼ�
 * @param {Object} Ҫ�жϵ�ҳ��Ԫ��
 */
function $isVisible(el){
	while(el && el != document) {
		if (GetCurrentStyle(el, 'visibility') == 'hidden' || GetCurrentStyle(el, 'display') == 'none') return false;
		el = el.parentNode;
    }
	return true;
}

/**
 * ���ĵ������ִ��һ�κ���
 * @param {Function} Ҫִ�еĺ���
 */
function onReady(fn) {
	if (typeof fn != "function") return;
	if (window.addEventListener) {
		window.addEventListener("load", fn, false);
	}else {
		window.attachEvent("onload", fn);
	}
}