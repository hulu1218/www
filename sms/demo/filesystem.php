<html>
	<head><title>�ļ�Ŀ¼����ϵͳ</title></head>
	<body bgcolor="#fafad2" link="#4C4C99" vlink="#4C4C99" alink="#4C4C99">
	<center><h1>�ļ�Ŀ¼����ϵͳ</h1></center>
	<?php
         	/* �����ڸýű����õ����������Զ����ص�ǰ�ű�����Ŀ¼�¶�Ӧ������ƵĽű��ļ� */
		function __autoload($className){
			include $className."_class.php";
		}
         	/* ������յ��˻�ַ��������ȵ���FileAction�����е�option�������д��� */
		if(isset($_POST["action"])){
			$fileaction=new FileAction($_POST["filename"], $_POST["action"]); 
			$fileaction->option(); 
		}
         	/* ������յ���Ŀ¼��������ݽ��յ���Ŀ¼���ƴ����ļ�ϵͳ���� */
		if(isset($_GET["dirname"])) {	
			$fs=new FileSystem($_GET["dirname"]);
		}else{        //����Ĭ�ϴ�����ǰĿ¼���ļ�ϵͳ����
			$fs=new FileSystem();
		}
		echo "<hr>";                               //���һ���ָ���
		$fs->getMenu();                            //�����ļ�ϵͳ�еķ�����ȡ�˵�
		echo "<hr>";                               //�ٴ����һ���ָ���
		$fs->fileList();                             //�����ļ�ϵͳ�еķ�����ȡ�ļ�Ŀ¼�б�
		echo '<br><font size=2 color="#005500">';
		echo $fs->getDirInfo();                //�����ļ�ϵͳ�еķ�����ȡ�ļ���Ŀ¼����
		echo $fs->getDiskSpace();             //�����ļ�ϵͳ�еķ�����ȡ���̿ռ�ʹ�����
		echo "</font>"
	?>

	<hr>
	<center>���ߣ������ �汾��1.0 ��дʱ�䣺2009-01-16</center>
	</body>
</html>

