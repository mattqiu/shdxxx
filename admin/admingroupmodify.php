<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
function checkform(){
if (document.form1.groupname.value==""){
    alert("用户组名称不能为空！");
    document.form1.groupname.focus();
    return false;
}
}
function CheckAll(form){
	for (var i=0;i<form.elements.length;i++){
	var e = form.elements[i];
	if (e.Name != "chkAll"){
	e.checked = form.chkAll.checked;
	}
	}
}
</script>
</head>
<body>
<?php
if (!isset($_GET["id"])){
showmsg('少ID参数！') ;
}
$id=$_GET["id"];
//checkid($id);
$sql="Select * from zzcms_admingroup where id='$id'";
$rs = mysql_query($sql,$conn); 
$row= mysql_num_rows($rs);
if (!$row){
echo "暂无信息";
}else{
$row= mysql_fetch_array($rs);
?>
<div class="admintitle">修改管理员组</div>
<form name="form1" method="post" action="admingroupsave.php" onSubmit="return checkform()">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="24%"  align="right" class="border">管理组名称</td>
      <td width="76%" class="border"> <input name="groupname" type="text" value="<?php echo $row['groupname']?>" maxlength="30">      </td>
    </tr>
    <tr> 
      <td height="11" align="right" class="border">招商</td>
      <td height="11" class="border"> 
	  <input name="config[]" type="checkbox" id="zs" value="zs" <?php if(str_is_inarr($row["config"],'zs')=='yes'){echo "checked";}?>>
        <label for="zs">招商信息管理</label> 
        <input name="config[]" type="checkbox" id="zsclass" value="zsclass" <?php if(str_is_inarr($row["config"],'zsclass')=='yes') { echo"checked";}?>>
        <label for="zsclass">招商/代理类别管理 </label>
        <input name="config[]" type="checkbox" id="zskeyword" value="zskeyword" <?php if(str_is_inarr($row["config"],'zskeyword')=='yes') { echo"checked";}?>>
        <label for="zskeyword">招商/代理关键字管理 </label></td>
    </tr>
    <tr> 
      <td height="22" align="right" class="border">代理</td>
      <td height="22" class="border">
	  <input name="config[]" type="checkbox" id="dl" value="dl" <?php if(str_is_inarr($row["config"],'dl')=='yes'){ echo"checked";}?>>
         <label for="dl">代理信息管理</label> </td>
    </tr>
    <tr> 
      <td height="11" align="right" class="border">展会</td>
      <td height="11" class="border"> 
	  <input name="config[]" type="checkbox" id="zh" value="zh" <?php if(str_is_inarr($row["config"],'zh')=='yes') { echo"checked";}?>>
         <label for="zh">展会信息管理 </label>
        <input name="config[]" type="checkbox"  id="zhclass" value="zhclass" <?php if(str_is_inarr($row["config"],'zhclass')=='yes') { echo"checked";}?>>
         <label for="zhclass">展会类别管理</label></td>
    </tr>
    <tr> 
      <td height="22" align="right" class="border">资讯</td>
      <td height="22" class="border"> 
	  <input name="config[]" type="checkbox"  id="zx" value="zx" <?php if(str_is_inarr($row["config"],'zx')=='yes') { echo"checked";}?>>
        <label for="zx">资讯信息管理</label> 
        <input name="config[]" type="checkbox"  id="zxclass" value="zxclass" <?php if(str_is_inarr($row["config"],'zxclass')=='yes') { echo"checked";}?>>
        <label for="zxclass">资讯类别管理 </label> 
        <input name="config[]" type="checkbox" id="zxpinglun"  value="zxpinglun" <?php if(str_is_inarr($row["config"],'zxpinglun')=='yes') { echo"checked";}?>>
        <label for="zxpinglun">资讯信息评论管理 </label> 
        <input name="config[]" type="checkbox"  id="zxtag" value="zxtag" <?php if(str_is_inarr($row["config"],'zxtag')=='yes') { echo"checked";}?>>
        <label for="zxtag">资讯信息广告标签管理</label> </td>
    </tr>
    <tr> 
      <td align="right"  class="border">广告</td>
      <td  class="border"><input name="config[]" type="checkbox" id="adv"  value="adv" <?php if(str_is_inarr($row["config"],'adv')=='yes') { echo"checked";} ?>>
        <label for="adv">广告管理 </label>
        <input name="config[]" type="checkbox" id="advclass"  value="advclass" <?php if(str_is_inarr($row["config"],'advclass')=='yes') { echo"checked";} ?>>
        <label for="advclass">广告类别管理</label> 
        <input name="config[]" type="checkbox" id="advtext" value="advtext" <?php if(str_is_inarr($row["config"],'advtext')=='yes'){ echo"checked";} ?>>
        <label for="advtext">用户审请的文字广告管理</label></td>
    </tr>
    <tr> 
      <td align="right"  class="border">用户</td>
      <td  class="border">
	  <input name="config[]" type="checkbox" id="userreg" value="userreg" <?php if(str_is_inarr($row["config"],'userreg')=='yes') { echo"checked";} ?>>
        <label for="userreg">注册用户管理 </label>
        <input name="config[]" type="checkbox"  id="usernoreg" value="usernoreg" <?php if(str_is_inarr($row["config"],'usernoreg')=='yes') { echo"checked";} ?>>
        <label for="usernoreg">未注册用户管理 </label>
        <input name="config[]" type="checkbox" id="userclass"  value="userclass" <?php if(str_is_inarr($row["config"],'userclass')=='yes') { echo"checked";} ?>>
        <label for="userclass">用户类别管理 </label>
        <input name="config[]" type="checkbox"  id="usergroup" value="usergroup" <?php if(str_is_inarr($row["config"],'usergroup')=='yes') { echo"checked";} ?>>
        <label for="usergroup">用户组管理 </label>
        <input name="config[]" type="checkbox" id="guestbook" value="guestbook" <?php if(str_is_inarr($row["config"],'guestbook')=='yes') { echo"checked";} ?>>
        <label for="guestbook">用户留言本管理</label></td>
    </tr>
    <tr> 
      <td align="right"  class="border">用户信息</td>
      <td  class="border"> 
<input name="config[]" type="checkbox"  id="licence" value="licence" <?php if(str_is_inarr($row["config"],'licence')=='yes'){ echo"checked";} ?>>
        <label for="licence">用户资质管理 </label>
<input name="config[]" type="checkbox" id="badusermessage" value="badusermessage" <?php if(str_is_inarr($row["config"],'badusermessage')=='yes'){ echo"checked";} ?>>
        <label for="badusermessage">不良用户操作记录管理 </label>
        <input name="config[]" type="checkbox"  id="fankui" value="fankui" <?php if(str_is_inarr($row["config"],'fankui')=='yes') { echo"checked";} ?>>
       <label for="fankui"> 用户反馈信息管理</label></td>
    </tr>
    <tr> 
      <td align="right"  class="border">文件</td>
      <td  class="border">
	  <input name="config[]" type="checkbox" id="uploadfiles"  value="uploadfiles" <?php if(str_is_inarr($row["config"],'uploadfiles')=='yes') { echo"checked";} ?>>
       <label for="uploadfiles"> 上传文件管理 </label></td>
    </tr>
    <tr> 
      <td align="right"  class="border">发信功能</td>
      <td  class="border">
	  <input name="config[]" type="checkbox" id="zsclass" value="sendmessage" <?php if(str_is_inarr($row["config"],'sendmessage')=='yes') { echo"checked";} ?>>
        <label for="sendmessage">在线发信息管理</label> 
        <input name="config[]" type="checkbox"  id="sendmail" value="sendmail" <?php if(str_is_inarr($row["config"],'sendmail')=='yes'){ echo"checked";} ?>>
        <label for="sendmail">在线发邮件管理 </label>
        <input name="config[]" type="checkbox" id="sendsms" value="sendsms" <?php if(str_is_inarr($row["config"],'sendsms')=='yes'){ echo"checked";} ?>>
        <label for="sendsms">在线发手机短信管理</label> </td>
    </tr>
    <tr> 
      <td align="right"  class="border">网站信息 </td>
      <td  class="border">
	  <input name="config[]" type="checkbox" id="announcement"  value="announcement" <?php if(str_is_inarr($row["config"],'announcement')=='yes'){ echo"checked";} ?>>
         <label for="announcement">网站公告管理</label> 
        <input name="config[]" type="checkbox"  id="helps" value="helps" <?php if(str_is_inarr($row["config"],'helps')=='yes') { echo"checked";} ?>>
       <label for="helps"> 网站使用帮助信息管理</label> 
        <input name="config[]" type="checkbox" id="bottomlink"  value="bottomlink" <?php if(str_is_inarr($row["config"],'bottomlink')=='yes') { echo"checked";} ?>>
       <label for="bottomlink"> 网站底部链接信息管理</label> 
        <input name="config[]" type="checkbox" id="friendlink" value="friendlink" <?php if(str_is_inarr($row["config"],'friendlink')=='yes') { echo"checked";} ?>>
       <label for="friendlink"> 友情链接管理</label></td>
    </tr>
    <tr> 
      <td align="right"  class="border">网站配置</td>
      <td  class="border">
	  <input name="config[]" type="checkbox"  id="siteconfig" value="siteconfig" <?php if(str_is_inarr($row["config"],'siteconfig')=='yes') { echo"checked";} ?>>
        <label for="siteconfig">网站配置管理 </label>
        <input name="config[]" type="checkbox" id="label"  value="label" <?php if(str_is_inarr($row["config"],'label')=='yes') { echo"checked";} ?>>
        <label for="label">网站模板/标签管理</label></td>
    </tr>
    <tr> 
      <td align="right"  class="border">管理员</td>
      <td  class="border">
	  <input name="config[]" type="checkbox" id="adminmanage"  value="adminmanage" <?php if(str_is_inarr($row["config"],'adminmanage')=='yes') { echo"checked";} ?>>
       <label for="adminmanage"> 管理员管理 </label>
        <input name="config[]" type="checkbox" id="admingroup"  value="admingroup" <?php if(str_is_inarr($row["config"],'admingroup')=='yes'){ echo"checked";} ?>>
       <label for="admingroup"> 管理员分组管理</label></td>
    </tr>
    <tr> 
      <td align="right" class="border">
<input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
        全部选择<br>
        (再次点击可以取消全选)</td>
      <td class="border"> <input name="id" type="hidden" id="id" value="<?php echo $row["id"] ?>"> 
        <input name="action" type="hidden" id="action" value="modify"> <input name="Save" type="submit" id="Save" value="修改">      </td>
    </tr>
  </table>
</form>
<?php
}
?>
</body>
</html>