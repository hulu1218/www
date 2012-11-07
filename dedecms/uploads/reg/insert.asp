<html>
<!--
1，Response.Redirect函数
2，Meta中的REFRESH
3，输出Javascript函数

一、利用Response.Redirect(URL)

例：Response.Redirect("index.asp")

二、利用HTML标记(META中的REFRESH属性)


<HTML>
<HEAD>
<META HTTP-EQUIV="REFRESH" CONTENT="5; URL=index.asp">
</HEAD>
<BODY>
</BODY>
</HTML>

注：这里的CONTENT="5 的意思是说5秒以后跳转。


三、输出JAVASCRIPT函数

举例如下：

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
'有两种添加的方法，1。上面的方法用insert语句进行插入相对于第二种方法运行速度要快。2。增加数据库记录用到rs.addnew,rs.update两个函数
set rs=server.createobject("adodb.recordset")'创建recordset对象'
sqlstr="select * from guestbook"'guestbook为数据库中的一个表'
rs.open sqlstr,conn,1,3'表示打开数据库的方式'
rs.addnew'新增一条记录'
rs("name")=name '将name的值传入name字段'
rs("tel")=tel
rs("email")=email
rs("company")=company
rs.update '刷新数据库'

rs.close            '这几句话是用来关闭数据库，顺序不能颠倒'
conn.close
set conn=nothing
set rs=nothing

response.write "记录添加成功!"
Response.Redirect("index.asp")
%>

</body>

</html>
