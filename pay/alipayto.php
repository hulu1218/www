<?php
/*
 *���ܣ�������Ʒ�й���Ϣ��ȷ�϶���֧�������߹������ҳ��
 *��ϸ����ҳ���ǽӿ����ҳ�棬����֧��ʱ��URL
 *�汾��3.0
 *�޸����ڣ�2010-06-22
 '˵����
 '���´���ֻ��Ϊ�˷����̻����Զ��ṩ���������룬�̻����Ը����Լ���վ����Ҫ�����ռ����ĵ���д,����һ��Ҫʹ�øô��롣
 '�ô������ѧϰ���о�֧�����ӿ�ʹ�ã�ֻ���ṩһ���ο���

*/

////////////////////ע��/////////////////////////
//��ҳ�����ʱ���֡����Դ�����ο���http://club.alipay.com/read-htm-tid-8681712.html
//Ҫ���ݵĲ���Ҫô������Ϊ�գ�Ҫô�Ͳ�Ҫ���������������ؿؼ���URL�����
/////////////////////////////////////////////////

require_once("alipay_config.php");
require_once("class/alipay_service.php");

/*���²�������Ҫͨ���µ�ʱ�Ķ������ݴ���������*/
//�������
$out_trade_no = date(Ymdhms);	//�������վ����ϵͳ�е�Ψһ������ƥ��
$subject      = $_POST['aliorder'];		//�������ƣ���ʾ��֧��������̨��ġ���Ʒ���ơ����ʾ��֧�����Ľ��׹���ġ���Ʒ���ơ����б��
$body         = $_POST['alibody'];		//����������������ϸ��������ע����ʾ��֧��������̨��ġ���Ʒ��������
$total_fee    = $_POST['alimoney'];		//�����ܽ���ʾ��֧��������̨��ġ�Ӧ���ܶ��

//��չ���ܲ�������������ǰ
$pay_mode	  = $_POST['pay_bank'];
if ($pay_mode == "directPay") {
	$paymethod    = "directPay";	//Ĭ��֧����ʽ���ĸ�ֵ��ѡ��bankPay(����); cartoon(��ͨ); directPay(���); CASH(����֧��)
	$defaultbank  = "";
}
else {
	$paymethod    = "bankPay";		//Ĭ��֧����ʽ���ĸ�ֵ��ѡ��bankPay(����); cartoon(��ͨ); directPay(���); CASH(����֧��)
	$defaultbank  = $pay_mode;		//Ĭ���������ţ������б��http://club.alipay.com/read.php?tid=8681379
}

//��չ���ܲ�������������
$encrypt_key  = '';					//������ʱ�������ʼֵ
$exter_invoke_ip = '';				//�ͻ��˵�IP��ַ����ʼֵ
if($antiphishing == 1){
    $encrypt_key = query_timestamp($partner);
	$exter_invoke_ip = '';			//��ȡ�ͻ��˵�IP��ַ�����飺��д��ȡ�ͻ���IP��ַ�ĳ���
}

//��չ���ܲ�����������
$extra_common_param = '';			//�Զ���������ɴ���κ����ݣ���=��&�������ַ��⣩��������ʾ��ҳ����
$buyer_email		= '';			//Ĭ�����֧�����˺�

/////////////////////////////////////////////////

//����Ҫ����Ĳ�������
$parameter = array(
        "service"         => "create_direct_pay_by_user",	//�ӿ����ƣ�����Ҫ�޸�
        "payment_type"    => "1",               			//�������ͣ�����Ҫ�޸�

        //��ȡ�����ļ�(alipay_config.php)�е�ֵ
        "partner"         => $partner,
        "seller_email"    => $seller_email,
        "return_url"      => $return_url,
        "notify_url"      => $notify_url,
        "_input_charset"  => $_input_charset,
        "show_url"        => $show_url,

        //�Ӷ��������ж�̬��ȡ���ı������
        "out_trade_no"    => $out_trade_no,
        "subject"         => $subject,
        "body"            => $body,
        "total_fee"       => $total_fee,

        //��չ���ܲ�������������ǰ
        "paymethod"	      => $paymethod,
        "defaultbank"	  => $defaultbank,

        //��չ���ܲ�������������
        "anti_phishing_key"=> $encrypt_key,
		"exter_invoke_ip" => $exter_invoke_ip,

        //��չ���ܲ�����������(��Ҫʹ�ã���ȡ����������ע��)
        //$royalty_type   => "10",	  //������ͣ�����Ҫ�޸�
        //$royalty_parameters => "111@126.com^0.01^����עһ|222@126.com^0.01^����ע��",
        /*�����Ϣ��������Ҫ����̻���վ���������̬��ȡÿ�ʽ��׵ĸ������տ��˺š��������������˵�������ֻ������10��
	�����Ϣ����ʽΪ���տEmail_1^���1^��ע1|�տEmail_2^���2^��ע2
        */

        //��չ���ܲ��������Զ��峬ʱ(��Ҫʹ�ã���ȡ������һ��ע��)���ù���Ĭ�ϲ���ͨ������ϵ�ͻ�������ѯ
        //$it_b_pay	      => "1c",	  //��ʱʱ�䣬����Ĭ����15�졣�˸�ֵ��ѡ��1h(1Сʱ),2h(2Сʱ),3h(3Сʱ),1d(1��),3d(3��),7d(7��),15d(15��),1c(����)

		//��չ���ܲ��������Զ������
		"buyer_email"	 => $buyer_email,
        "extra_common_param" => $extra_common_param
);

//����������
$alipay = new alipay_service($parameter,$security_code,$sign_type);


//���ĳ�GET��ʽ����
$url = $alipay->create_url();
$sHtmlText = "<a href=".$url."><img border='0' src='images/alipay.gif' /></a>";
echo "<script>window.location =\"$url\";</script>"; 


//POST��ʽ���ݣ��õ����ܽ���ַ�������ȡ������һ�е�ע��
//$sHtmlText = $alipay->build_postform();

?>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
        <title>֧������ʱ֧��</title>
        <style type="text/css">
            .font_content{
                font-family:"����";
                font-size:14px;
                color:#FF6600;
            }
            .font_title{
                font-family:"����";
                font-size:16px;
                color:#FF0000;
                font-weight:bold;
            }
            table{
                border: 1px solid #CCCCCC;
            }
        </style>
    </head>
    <body>

        <table align="center" width="350" cellpadding="5" cellspacing="0">
            <tr>
                <td align="center" class="font_title" colspan="2">����ȷ��</td>
            </tr>
            <tr>
                <td class="font_content" align="right">�����ţ�</td>
                <td class="font_content" align="left"><?php echo $out_trade_no; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">�����ܽ�</td>
                <td class="font_content" align="left"><?php echo $total_fee; ?></td>
            </tr>
            <tr>
                <td align="center" colspan="2"><?php echo $sHtmlText; ?></td>
            </tr>
        </table>
    </body>
</html>
