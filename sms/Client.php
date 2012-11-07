<?php
define('SMS_PATH', str_replace('Client.php', '', str_replace('\\', '/', __FILE__)));
require_once(SMS_PATH.'nusoap/nusoap.php');

/**
 梦网短信平台
 */
class Client{
	/**
	 * 用户名
	 */
	var $userName;
	
	/**
	 * 密码
	 */
	var $userPass;
	
	//子端口号码，不带请填星号{*} 长度由账号类型定4-6位，通道号总长度不能超过20位。如：10657****主通道号，3321绑定的扩展端口，主+扩展+子端口总长度不能超过20位。
	var $pszSubPort;
	
	/**
	 * webservice客户端
	 */
	var $soap;
	
	/**
	 * 默认命名空间
	 */
	var $namespace = 'http://tempuri.org/';
	
	/**
	 * 往外发送的内容的编码,默认为 UTF-8
	 */
	var $outgoingEncoding = "UTF-8";
	
	/**
	 * 往外发送的内容的编码,默认为 UTF-8
	 */
	var $incomingEncoding = 'UTF-8';
	
	var $status = array(
		"-1" => "参数为空。信息、电话号码等有空指针，登陆失败",
		"-2" => "电话号码个数超过100",
		"-10" => "申请缓存空间失败",
		"-11" => "电话号码中有非数字字符",
		"-12" => "有异常电话号码",
		"-13" => "电话号码个数与实际个数不相等",
		"-14" => "实际号码个数超过100",
		"-101" => "发送消息等待超时",
		"-102" => "发送或接收消息失败",
		"-103" => "接收消息超时",
		"-200" => "其他错误",
		"-999" => "web服务器内部错误",
		"-10001" => "用户登陆不成功",
		"-10002" => "提交格式不正确",
		"-10003" => "用户余额不足",
		"-10004" => "手机号码不正确",
		"-10005" => "计费用户帐号错误",
		"-10006" => "计费用户密码错",
		"-10007" => "账号已经被停用",
		"-10008" => "账号类型不支持该功能",
		"-10009" => "其它错误",
		"-10010" => "企业代码不正确",
		"-10011" => "信息内容超长",
		"-10012" => "不能发送联通号码",
		"-10013" => "操作员权限不够",
		"-10014" => "费率代码不正确",
		"-10015" => "服务器繁忙",
		"-10016" => "企业权限不够",
		"-10017" => "此时间段不允许发送",
		"-10018" => "经销商用户名或密码错",
		"-10019" => "手机列表或规则错误",
		"-10021" => "没有开停户权限",
		"-10022" => "没有转换用户类型的权限",
		"-10023" => "没有修改用户所属经销商的权限",
		"-10024" => "经销商用户名或密码错",
		"-10025" => "操作员登陆名或密码错误",
		"-10026" => "操作员所充值的用户不存在",
		"-10027" => "操作员没有充值商务版的权限",
		"-10028" => "该用户没有转正不能充值",
		"-10029" => "此用户没有权限从此通道发送信息",
		"-10030" => "不能发送移动号码",
		"-10031" => "手机号码(段)非法",
		"-10032" => "用户使用的费率代码错误",
		"-10033" => "非法关键词"
	);
	
	/**
	 * @param string $url 			接口地址
	 * @param string $serialNumber 	用户名
	 * @param string $password		密码
	 * @param string $timeout		连接超时时间，默认0，为不超时
	 * @param string $response_timeout		信息返回超时时间，默认30
	 * 
	 * 
	 */
	function Client($url,$userName,$userPass,$timeout = 0, $response_timeout = 30)
	{
		$this->userName = $userName;
		$this->userPass = $userPass;
		
		/**
		 * 初始化 webservice 客户端
		 */	
		$this->soap = new nusoap_client($url,true,false,false,false,false,$timeout,$response_timeout); 
		$this->soap->soap_defencoding = $this->outgoingEncoding;
		$this->soap->decode_utf8 = false;			
	}

	/**
	 * 设置发送内容 的字符编码
	 * @param string $outgoingEncoding 发送内容字符集编码
	 */
	function setOutgoingEncoding($outgoingEncoding)
	{
		$this->outgoingEncoding =  $outgoingEncoding;
		$this->soap->soap_defencoding = $this->outgoingEncoding;
		
	}
	
	/**
	 * 设置接收内容 的字符编码
	 * @param string $incomingEncoding 接收内容字符集编码
	 */
	function setIncomingEncoding($incomingEncoding)
	{
		$this->incomingEncoding =  $incomingEncoding;
		$this->soap->xml_encoding = $this->incomingEncoding;
	}
	
	function setNameSpace($ns)
	{
		$this->namespace = $ns;
	}
	
	function getError()
	{		
		return $this->soap->getError();
	}
	
	/**
	 * 发送短信
	 * @return int 操作结果状态码
	*/
	function sendSMS($mobiles,$msg)
	{
		$result = array("status"=>false,"msg"=>"发送成功");
		
		if (empty($this->pszSubPort)){
			$this->pszSubPort = '*';
		}
		
		$params = array(
			'userId'=>$this->userName,
			'password'=>$this->userPass,
			'pszMobis'=>implode(",",$mobiles),
			'pszMsg'=>$msg,
			'iMobiCount'=>count($mobiles),
			'pszSubPort'=>$this->pszSubPort
		);
		
		$response = $this->soap->call("MongateCsSpSendSmsNew",$params,$this->namespace);
		$statusCode = $response['MongateCsSpSendSmsNewResult'];
		
		if(isset($this->status[$statusCode]))
		{
				$result['status'] = false;
				$result['msg'] = $this->status[$statusCode];
		}
		elseif(strlen($statusCode) >= 20 && abs(intval($statusCode)) > 999)
		{
				$result['status'] = true;
				$result['msg'] = "发送成功";
		}
		
		return $result;
	}
}
?>
