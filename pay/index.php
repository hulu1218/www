<?php
/*
	*���ܣ����ٸ������ģ��ҳ
	*��ϸ����ҳ������Բ��漰�����ﳵ���̡���ֵ���̵�ҵ�����̣�ֻ��Ҫʵ������ܹ����ٸ�������ҵĸ���ܡ�
	*�汾��3.1
	*���ڣ�2010-08-05
	*˵����
	*���´���ֻ��Ϊ�˷����̻����Զ��ṩ���������룬�̻����Ը����Լ���վ����Ҫ�����ռ����ĵ���д,����һ��Ҫʹ�øô��롣
	*�ô������ѧϰ���о�֧�����ӿ�ʹ�ã�ֻ���ṩһ���ο���
*/

require_once("alipay_config.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML XMLNS:CC><HEAD><TITLE>֧���� - ����֧�� ��ȫ���٣�</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META content=���Ϲ���/����֧��/��ȫ֧��/��ȫ����/�����ȫ/֧��,��ȫ/֧����/��ȫ,֧��/��ȫ������/֧��, 
name=description ���� ����,�տ� ����,ó�� ����ó��.>
<META content=���Ϲ���/����֧��/��ȫ֧��/��ȫ����/�����ȫ/֧��,��ȫ/֧����/��ȫ,֧��/��ȫ������/֧��, name=keywords 
���� ����,�տ� ����,ó�� ����ó��.><LINK href="images/layout.css" 
type=text/css rel=stylesheet>

<SCRIPT language=JavaScript>
<!-- 
  //��������Ҽ���Ctrl+N��Shift+F10��F11��F5ˢ�¡��˸�� 
  //Author: William 2010-3-31 -->
function document.oncontextmenu(){event.returnValue=false;}//��������Ҽ� 
function window.onhelp(){return false} //����F1���� 
function document.onkeydown() 
{ 
  if ((window.event.altKey)&& 
      ((window.event.keyCode==37)||   //���� Alt+ ����� �� 
       (window.event.keyCode==39)))   //���� Alt+ ����� �� 
  { 
     alert("��׼��ʹ��ALT+�����ǰ���������ҳ��"); 
     event.returnValue=false; 
  } 
     /* ע���⻹�������������� Alt+ ������� 
     ��Ϊ Alt+ ��������������ʱ����ס Alt �����ţ� 
     �������������������η�����ʧЧ�ˡ�*/ 
  if ((event.keyCode==116)||                 //���� F5 ˢ�¼� 
      (event.ctrlKey && event.keyCode==82)){ //Ctrl + R 
     event.keyCode=0; 
     event.returnValue=false; 
     } 
  if (event.keyCode==122){event.keyCode=0;event.returnValue=false;}  //����F11 
  if (event.ctrlKey && event.keyCode==78) event.returnValue=false;   //���� Ctrl+n 
  if (event.shiftKey && event.keyCode==121)event.returnValue=false;  //���� shift+F10 
  if (window.event.srcElement.tagName == "A" && window.event.shiftKey)  
      window.event.returnValue = false;             //���� shift ���������¿�һ��ҳ 
  if ((window.event.altKey)&&(window.event.keyCode==115))             //����Alt+F4 
  { 
      window.showModelessDialog("about:blank","","dialogWidth:1px;dialogheight:1px"); 
      return false; 
  } 
} 



<!-- 
  //У������� 
  //Author: William 2010-3-31 -->
function CheckForm()
{
	if (document.alipayment.aliorder.value.length == 0) {
		alert("��������Ʒ����.");
		document.alipayment.aliorder.focus();
		return false;
	}
	if (document.alipayment.alimoney.value.length == 0) {
		alert("�����븶����.");
		document.alipayment.alimoney.focus();
		return false;
	}
	if (document.alipayment.buyer_mail.value.length == 0) {
		alert("�����븶���Ϣ.");
		document.alipayment.alimoney.focus();
		return false;
	}

}  

<!-- 
  //����������ʾ
  //Author: William 2010-3-31 -->
function glowit(which){
if (document.all.glowtext[which].filters[0].strength==2)
document.all.glowtext[which].filters[0].strength=1
else
document.all.glowtext[which].filters[0].strength=2
}
function glowit2(which){
if (document.all.glowtext.filters[0].strength==2)
document.all.glowtext.filters[0].strength=1
else
document.all.glowtext.filters[0].strength=2
}
function startglowing(){
if (document.all.glowtext&&glowtext.length){
for (i=0;i<glowtext.length;i++)
eval('setInterval("glowit('+i+')",150)')
}
else if (glowtext)
setInterval("glowit2(0)",150)
}
if (document.all)
window.onload=startglowing


</SCRIPT>
</HEAD>
<style>
<!--
#glowtext{
filter:glow(color=red,strength=2);
width:100%;
}
-->
</style>
<BODY text=#000000 bgColor=#ffffff leftMargin=0 topMargin=4>
<CENTER>

<TABLE cellSpacing=0 cellPadding=0 width=760 border=0>
  <TBODY>
  <TR>
    <TD class=title>֧������ʱ���ʸ������ͨ��</TD>
  </TR></TBODY>
</TABLE><BR>
<FORM name=alipayment onSubmit="return CheckForm();" action=alipayto.php 
method=post target="_blank">
<table>
 <tr>
   <td>
     <TABLE cellSpacing=0 cellPadding=0 width=740 border=0>
        <TR>
          <TD class=form-left>�տ��</TD>
          <TD class=form-star>* </TD>
          <TD class=form-right><?php echo $mainname; ?></TD>
        </TR>
        <TR>
          <TD colspan="3" align="center"><HR width=600 SIZE=2 color="#999999"></TD>
        </TR>
        <TR>
          <TD class=form-left>���⣺ </TD>
          <TD class=form-star>* </TD>
          <TD class=form-right><INPUT size=30 name=aliorder maxlength="200"><span>�磺7��5�ն����</span></TD>
        </TR>
        <TR>
          <TD class=form-left>����� </TD>
          <TD class=form-star>*</TD>
          <TD class=form-right><INPUT 
            onkeypress="return regInput(this,/^\d*\.?\d{0,2}$/,String.fromCharCode(event.keyCode))" 
            onpaste="return regInput(this,/^\d*\.?\d{0,2}$/,window.clipboardData.getData('Text'))" 
            ondrop="return regInput(this,/^\d*\.?\d{0,2}$/,&#9;event.dataTransfer.getData('Text'))" 
            maxLength=10 size=30 name=alimoney  onfocus="if(Number(this.value)==0){this.value='';}" value="00.00"/>
            <span>�磺112.21</span></TD>
        </TR>
        <TR>
          <TD class=form-left>��ע��</TD>
          <TD class=form-star></TD>
          <TD class=form-right><TEXTAREA name=alibody rows=2 cols=40 wrap="physical"></TEXTAREA><BR>
          ������ϵ��������ƷҪ�������ȡ�100�����ڣ�</TD>
        </TR>
        <TR>
          <TD class=form-left>֧����ʽ��</TD>
          <TD class=form-star></TD>
          <TD class=form-right>
               <table>
                 <tr>
                   <td><input type="radio" name="pay_bank" value="directPay" checked><img src="images/alipay_1.gif" border="0"/></td>
                 </tr>
                 <tr>
                   <td><input type="radio" name="pay_bank" value="ICBCB2C"/><img src="images/ICBC_OUT.gif" border="0"/></td>
                   <td><input type="radio" name="pay_bank" value="CMB"/><img src="images/CMB_OUT.gif" border="0"/></td>
                   <td><input type="radio" name="pay_bank" value="CCB"/><img src="images/CCB_OUT.gif" border="0"/></td>
                   <td><input type="radio" name="pay_bank" value="BOCB2C"><img src="images/BOC_OUT.gif" border="0"/></td>
                 </tr>
                 <tr>
                   <td><input type="radio" name="pay_bank" value="ABC"/><img src="images/ABC_OUT.gif" border="0"/></td>
                   <td><input type="radio" name="pay_bank" value="COMM"/><img src="images/COMM_OUT.gif" border="0"/></td>
                   <td><input type="radio" name="pay_bank" value="SPDB"/><img src="images/SPDB_OUT.gif" border="0"/></td>
                   <td><input type="radio" name="pay_bank" value="GDB"><img src="images/GDB_OUT.gif" border="0"/></td>
                 </tr>
                 <tr>
                   <td><input type="radio" name="pay_bank" value="CITIC"/><img src="images/CITIC_OUT.gif" border="0"/></td>
                   <td><input type="radio" name="pay_bank" value="CEBBANK"/><img src="images/CEB_OUT.gif" border="0"/></td>
                   <td><input type="radio" name="pay_bank" value="CIB"/><img src="images/CIB_OUT.gif" border="0"/></td>
                   <td><input type="radio" name="pay_bank" value="SDB"><img src="images/SDB_OUT.gif" border="0"/></td>
                 </tr>
                 <tr>
                   <td><input type="radio" name="pay_bank" value="CMBC"/><img src="images/CMBC_OUT.gif" border="0"/></td>
                   <td><input type="radio" name="pay_bank" value="HZCBB2C"/><img src="images/HZCB_OUT.gif" border="0"/></td>
                   <td><input type="radio" name="pay_bank" value="SHBANK"/><img src="images/SHBANK_OUT.gif" border="0"/></td>
                   <td><input type="radio" name="pay_bank" value="NBBANK "><img src="images/NBBANK_OUT.gif" border="0"/></td>
                 </tr>
                 <tr>
                   <td><input type="radio" name="pay_bank" value="SPABANK"/><img src="images/SPABANK_OUT.gif" border="0"/></td>
                   <td><input type="radio" name="pay_bank" value="BJRCB"/><img src="images/BJRCB_OUT.gif" border="0"/></td>
                   <td><input type="radio" name="pay_bank" value="ICBCBTB"/><img src="images/ENV_ICBC_OUT.gif" border="0"/></td>
                   <td><input type="radio" name="pay_bank" value="CCBB2B"/><img src="images/ENV_CCB_OUT.gif" border="0"/></td>
                 </tr>
                 <tr>
                   <td><input type="radio" name="pay_bank" value="SPDBB2B"/><img src="images/ENV_SPDB_OUT.gif" border="0"/></td>
                   <td><input type="radio" name="pay_bank" value="ABCBTB"/><img src="images/ENV_ABC_OUT.gif" border="0"/></td>
				   <td></td>
				   <td></td>
                 </tr>
               </table>
          </TD>
        </TR>
         <TR>
          <TD class=form-left></TD>
          <TD class=form-star></TD>
          <TD class=form-right><INPUT type=image 
            src="images/button_sure.gif" value=ȷ�϶��� 
            name=nextstep></TD>
        </TR>
</TABLE>
   </td>
   <td vAlign=top width=205 style="font-size:12px;font-family:'����'">
   <span id="glowtext">С��ʿ��</span>
   <fieldset>
      <P class=STYLE1>��ͨ��Ϊ<a href="<?php echo $show_url; ?>" target="_blank"><strong><?php echo $mainname; ?></strong></a>�ͻ�ר�ã�����֧�����������֧��ǰ�뱾��վ���һ�¡�</P>
      <P class="style2">�������<a href="<?php echo $show_url; ?>" target="_blank"><strong><?php echo $mainname; ?></strong></a>ȷ�Ϻö����ͻ�����ٸ�������ڿ��ٸ���ͨ����ġ����⡱��������������������ͱ�ע��������Ӧ�Ķ�����Ϣ��</P>
      <P class="style2 style3">&nbsp;</P>
      </fieldset>
   </td>
 </tr>
</table>

</FORM>

<TABLE cellSpacing=1 width=760 border=0>
  <TR>
    <TD><FONT class=note-help>�������������򡱰�ť������ʾ���Ѿ����ܡ�֧��������Э�顱��ͬ�������ҹ������Ʒ�� 
      <BR>
      �������β�����������Ʒ��¼���ϣ��������ҵ�˵���ͽ��ܵĸ��ʽ�����ұ���е���Ʒ��Ϣ��ȷ��¼�����Σ� 
  </FONT>
 </TD>
 </TR>
</TABLE>

<TABLE cellSpacing=0 cellPadding=0 width=760 align=center border=0>
  <TR align=middle>
    <TD class="txt12 lh15"><A href="http://china.alibaba.com/" 
      target=_blank>����Ͱ����¹�˾</A> | ֧������Ȩ���� 2004-2012</TD>
  </TR>
  <TR align=middle>
    <TD class="txt12 lh15"><IMG alt="֧����ͨ��������Ȩ����ȫ��֤�� " 
      src="images/logo_vbvv.gif" border=0><BR>֧����ͨ��������Ȩ����ȫ 
  ��֤��
    </TD>
  </TR>
</TABLE>
</BODY></HTML>
