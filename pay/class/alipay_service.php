<?php
/**
 *������alipay_service
 *���ܣ�֧�����ⲿ����ӿڿ���
 *��ϸ����ҳ��������������Ĵ����ļ�������Ҫ�޸�
 *�汾��3.1
 *�޸����ڣ�2010-07-26
 '˵����
 '���´���ֻ��Ϊ�˷����̻����Զ��ṩ���������룬�̻����Ը����Լ���վ����Ҫ�����ռ����ĵ���д,����һ��Ҫʹ�øô��롣
 '�ô������ѧϰ���о�֧�����ӿ�ʹ�ã�ֻ���ṩһ���ο���

*/

require_once("alipay_function.php");

class alipay_service {

    var $gateway;			//���ص�ַ
    var $security_code;		//��ȫУ����
    var $mysign;			//���ܽ����ǩ�������
    var $sign_type;			//��������
    var $parameter;			//��Ҫ���ܵĲ�������
    var $_input_charset;    //�ַ������ʽ

    /**���캯��
	*�������ļ�������ļ��г�ʼ������
	*$parameter ��Ҫ���ܵĲ�������
	*$security_code ��ȫУ����
	*$sign_type ��������
    */
    function alipay_service($parameter,$security_code,$sign_type) {
        $this->gateway	      = "https://www.alipay.com/cooperate/gateway.do?";
        $this->security_code  = $security_code;
        $this->sign_type      = $sign_type;
        $this->parameter      = para_filter($parameter);

        //�趨_input_charset��ֵ,Ϊ��ֵ�������Ĭ��ΪGBK
        if($parameter['_input_charset'] == '')
            $this->parameter['_input_charset'] = 'GBK';

        $this->_input_charset   = $this->parameter['_input_charset'];

        //���ǩ�����
        $sort_array   = arg_sort($this->parameter);    //�õ�����ĸa��z�����ļ��ܲ�������
        $this->mysign = build_mysign($sort_array,$this->security_code,$this->sign_type);
    }

    /********************************************************************************/

    /**��������URL��GET��ʽ����
	*return ����url
     */
    function create_url() {
        $url         = $this->gateway;
        $sort_array  = array();
        $sort_array  = arg_sort($this->parameter);
        $arg         = create_linkstring_urlencode($sort_array);	//����������Ԫ�أ����ա�����=����ֵ����ģʽ�á�&���ַ�ƴ�ӳ��ַ���
        
		//�����ص�ַ���Ѿ�ƴ�ӺõĲ��������ַ�����ǩ�������ǩ�����ͣ�ƴ�ӳ�������������url
        $url.= $arg."&sign=" .$this->mysign ."&sign_type=".$this->sign_type;
        return $url;
    }

    /********************************************************************************/

    /**����Post���ύHTML��POST��ʽ����
	*return ���ύHTML�ı�
     */
    function build_postform() {

        $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$this->gateway."_input_charset=".$this->parameter['_input_charset']."' method='post'>";

        while (list ($key, $val) = each ($this->parameter)) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }

        $sHtml = $sHtml."<input type='hidden' name='sign' value='".$this->mysign."'/>";
        $sHtml = $sHtml."<input type='hidden' name='sign_type' value='".$this->sign_type."'/></form>";

        $sHtml = $sHtml."<input type='button' name='v_action' value='֧����ȷ�ϸ���' onClick='document.forms[\"alipaysubmit\"].submit();'>";
        return $sHtml;
    }
    /********************************************************************************/

}
?>