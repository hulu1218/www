<?php
     	/* �����ڸýű������õ����������Զ����ص�ǰ�ű�����Ŀ¼�¶�Ӧ������ƵĽű��ļ� */
	function __autoload($className){
		include $className."_class.php";
	}
	isset($_GET["filename"]) or die("���ص��ļ��������ڣ�");  //�ж��Ƿ��ļ����ƴ��ݹ���
	!empty($_GET["filename"]) or die("�ļ���Ϊ��");          //�жϴ��ݹ������ļ������Ƿ�Ϊ��

	$file=new Filec($_GET["filename"]);                   //�����ļ����ƴ����ļ�����
	$file->download();	                               //�����ļ������е����ط���ʵ������
?>
