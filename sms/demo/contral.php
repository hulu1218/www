<?php
     	/* �����ڸýű������õ����������Զ����ص�ǰ�ű�����Ŀ¼�¶�Ӧ������ƵĽű��ļ� */
	function __autoload($className){        
		include $className."_class.php";
	}
	isset($_GET["action"]) or die("û���κλ������");   //���û���κ��û�����˳�

     	/* ���ݽ��յ����ļ����ƺͻ�ַ�������FileAction����    */
	$fileaction=new FileAction($_GET["filename"], $_GET["action"]);  
	$fileaction->getFileInfo();   //����FileAction�����е�getFileInfo()������ȡ�����е�������Ϣ

	if(isset($_GET["dirname"]))    //������յ��ṩ������Ŀ¼��������������
		$fileaction->getForm("filesystem.php?dirname=".$_GET["dirname"]);  //��ȡ�û�����������
	else
		$fileaction->getForm("filesystem.php");                          //��ȡ�û�����������
?>

