<?php
include ("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>后前管理首页</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top"> 
      <table width="100%" border="0" cellpadding="10" cellspacing="0">
        <tr> 
          <td class="border" style="font-size:14px;line-height:25px;"> 
<?php
echo  "请先看看下面是否有需要您处理的工作。<br>";			
function checkisendsever()
{
//到期的招商产品取消推荐
mysql_query("update zzcms_main set elite=0 where eliteendtime< '".date('Y-m-d H:i:s')."'");
//检查到期的vip用户
$sql="select groupid,enddate,username from zzcms_user where groupid>1 and enddate<'".date('Y-m-d H:i:s')."'";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if ($row){
while($row=mysql_fetch_array($rs)){
		mysql_query("update zzcms_user set groupid=1 where username='".$row["username"]."'"); 
		mysql_query("Update zzcms_main set groupid=1 where editor='" . $row["username"] . "'");
		mysql_query("Update zzcms_main set elite=0 where editor='" . $row["username"] . "'");	
}
}
echo "已完成";
}

$sql="select id from zzcms_user where passed=0";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
echo "待审注册用户 ".$row." 条 [ <a href='usermanage.php?shenhe=no'>查看</a> ]<br>";

$sql="select id from zzcms_main where passed=0";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
echo "待审招商信息 ".$row." 条 [ <a href='zs_manage.php?shenhe=no'>查看</a> ]<br>";

$sql="select id from zzcms_dl where passed=0";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
echo "待审代理信息 ".$row." 条 [ <a href='dl_manage.php?shenhe=no'>查看</a> ]<br>";

$sql="select id from zzcms_zx where passed=0";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
echo "待审资讯信息 ".$row." 条 [ <a href='zx_manage.php?shenhe=no'>查看</a> ]<br>";

$sql="select id from zzcms_pinglun where passed=0";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
echo "待审评论信息 ".$row." 条 [ <a href='pinglun_manage.php?shenhe=no'>查看</a> ]<br>";

$sql="select id from zzcms_link where passed=0";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
echo "待审友情链接 ".$row." 个 [ <a href='linkmanage.php?shenhe=no'>查看</a> ]<br>";

$sql="select id from zzcms_textadv where passed=0";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
echo "待审文字广告 ".$row." 个 [ <a href='ad_user_manage.php?shenhe=no'>查看</a> ]<br>";

$sql="select id from zzcms_licence where passed=0";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
echo "待审资质证书 ".$row." 个 [ <a href='licence.php?shenhe=no'>查看</a> ]<br>";

$sql="select id from zzcms_ad where endtime< '".date('Y-m-d H:i:s')."'";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
echo "已到期的广告 ".$row." 条 [ <a href='ad_manage.php?action=showendtime'>查看</a> ]<br>";

$sql="select id from zzcms_usermessage where reply is null";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
echo "未回复的反馈 ".$row." 条 [ <a href='usermessage.php?reply=no'>查看</a> ]<br>";

$sql="select id from zzcms_bad";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
echo "不良操作记录 ".$row." 条 [ <a href='showBad.php'>查看</a> ]<br>";
?> </td>
        </tr>
        <tr>
          <td class="border" style="font-size:14px;line-height:25px;">
<?php 
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if ($action=="check") {
checkisendsever();
}else{
?>
<a href="?action=check">检查处理到期的注册用户，到期的招商产品取消推荐</a>
<?php
}
mysql_close($conn);
?>	 
		  </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
