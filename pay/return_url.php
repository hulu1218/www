<?php
/*
	*���ܣ���������ת��ҳ�棨����ҳ��
	*�汾��3.0
	*���ڣ�2010-05-21
	'˵����
	'���´���ֻ��Ϊ�˷����̻����Զ��ṩ���������룬�̻����Ը����Լ���վ����Ҫ�����ռ����ĵ���д,����һ��Ҫʹ�øô��롣
	'�ô������ѧϰ���о�֧�����ӿ�ʹ�ã�ֻ���ṩһ���ο���
	
*/
///////////ҳ�湦��˵��///////////////
//��ҳ����ڱ������Բ���
//��ҳ�����������ҳ��������֧����������ͬ�����ã��ɵ�����֧����ɺ����ʾ��Ϣҳ���硰����ĳĳĳ���������ٽ����֧���ɹ�����
//�ɷ���HTML������ҳ��Ĵ���Ͷ���������ɺ�����ݿ���³������
//��ҳ�����ʹ��PHP�������ߵ��ԣ�Ҳ����ʹ��д�ı�����log_result���е��ԣ��ú����ѱ�Ĭ�Ϲرգ���alipay_notify.php�еĺ���return_verify
//TRADE_FINISHED(��ʾ�����Ѿ��ɹ�������Ϊ��ͨ��ʱ���ʵĽ���״̬�ɹ���ʶ);
//TRADE_SUCCESS(��ʾ�����Ѿ��ɹ�������Ϊ�߼���ʱ���ʵĽ���״̬�ɹ���ʶ);
///////////////////////////////////

require_once("class/alipay_notify.php");
require_once("alipay_config.php");

//����֪ͨ������Ϣ
$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);
//����ó�֪ͨ��֤���
$verify_result = $alipay->return_verify();

if($verify_result) {

    //��֤�ɹ�
    //��ȡ֧������֪ͨ���ز���
    $dingdan           = $_GET['out_trade_no'];    //��ȡ������
    $total_fee         = $_GET['total_fee'];	    //��ȡ�ܼ۸�
    $sOld_trade_status = "0";		    //��ȡ�̻����ݿ��в�ѯ�õ��ñʽ��׵�ǰ�Ľ���״̬

    /*���裺
	sOld_trade_status="0";��ʾ����δ����
	sOld_trade_status="1";��ʾ���׳ɹ���TRADE_FINISHED/TRADE_SUCCESS����
    */

    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {

        //���붩��������ɺ�����ݿ���³�����룬����ر�֤echo��������Ϣֻ��success
        //Ϊ�˱�֤�����ظ����ã����ظ�ִ�����ݿ���³������жϸñʽ���״̬�Ƿ��Ƕ���δ����״̬
        if ($sOld_trade_status < 1) {
            //���ݶ����Ÿ��¶������Ѷ�������ɽ��׳ɹ�
        }        
    }
    else {
      echo "trade_status=".$_GET['trade_status'];
    }
}
else {
    //��֤ʧ��
    //��Ҫ���ԣ��뿴alipay_notify.phpҳ���return_verify�������ȶ�sign��mysign��ֵ�Ƿ���ȣ����߼��$veryfy_result��û�з���true
    echo "fail";
}
?>
<html>
    <head>
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
                <td align="center" class="font_title" colspan="2">֪ͨ����</td>
            </tr>
            <tr>
                <td class="font_content" align="right">֧�������׺ţ�</td>
                <td class="font_content" align="left"><?php echo $_GET['trade_no']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">�����ţ�</td>
                <td class="font_content" align="left"><?php echo $_GET['out_trade_no']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">�����ܽ�</td>
                <td class="font_content" align="left"><?php echo $_GET['total_fee']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">��Ʒ���⣺</td>
                <td class="font_content" align="left"><?php echo $_GET['subject']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">��Ʒ������</td>
                <td class="font_content" align="left"><?php echo $_GET['body']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">����˺ţ�</td>
                <td class="font_content" align="left"><?php echo $_GET['buyer_email']; ?></td>
            </tr>
            <tr>
                <td class="font_content" align="right">����״̬��</td>
                <td class="font_content" align="left"><?php echo $_GET['trade_status']; ?></td>
            </tr>
        </table>
    </body>
</html>