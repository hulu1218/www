<html>
<!--
1��Response.Redirect����
2��Meta�е�REFRESH
3�����Javascript����

һ������Response.Redirect(URL)

����Response.Redirect("index.asp")

��������HTML���(META�е�REFRESH����)


<HTML>
<HEAD>
<META HTTP-EQUIV="REFRESH" CONTENT="5; URL=index.asp">
</HEAD>
<BODY>
</BODY>
</HTML>

ע�������CONTENT="5 ����˼��˵5���Ժ���ת��


�������JAVASCRIPT����

�������£�

Response.write("<!--<SCRIPT LANGUAGE=""JavaScript"">")
Response.write("location.href=index.asp")
Response.write("</SCRIPT>-->
<!--")
-->
<head>

<title></title>

</head>

<body>
<%
dbpath=server.mappath("demo.mdb")  
set conn=server.createobject("adodb.connection")  
conn.open "provider=microsoft.jet.oledb.4.0;data source=" & dbpath 
name=request.form("name")
tel=request.form("tel")
message=request.form("message") 
'exec="insert into guestbook(name,tel,message)values('"+name+"',"+tel+",'"+message+"')"
'conn.execute exec
'��������ӵķ�����1������ķ�����insert�����в�������ڵڶ��ַ��������ٶ�Ҫ�졣2���������ݿ��¼�õ�rs.addnew,rs.update��������
set rs=server.createobject("adodb.recordset")'����recordset����'
sqlstr="select * from guestbook"'guestbookΪ���ݿ��е�һ����'
rs.open sqlstr,conn,1,3'��ʾ�����ݿ�ķ�ʽ'
rs.addnew'����һ����¼'
rs("name")=name '��name��ֵ����name�ֶ�'
rs("tel")=tel
rs("email")=email
rs("company")=company
rs.update 'ˢ�����ݿ�'

rs.close            '�⼸�仰�������ر����ݿ⣬˳���ܵߵ�'
conn.close
set conn=nothing
set rs=nothing

response.write "��¼��ӳɹ�!"
Response.Redirect("index.asp")
%>

</body>

</html>
