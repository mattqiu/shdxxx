<?php
include("../inc/conn.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<title>修改资质证书</title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<script src="/js/gg.js" type="text/javascript"></script>
<script language = "JavaScript">
function CheckForm(){
if (document.myform.title.value==""){
    alert("证件名称不能为空！");
	document.myform.title.focus();
	return false;
  }
  if (document.myform.img.value==""){
    alert("请上传证件图片！");
	return false;
  }
}
</script>
</head>
<body>
<div class="main">
<?php
include("top.php");
?>
<div class="pagebody">
<div class="left">
<?php
include("left.php");
?>
</div>
<div class="right">
<div class="content">
<div class="admintitle">修改资质证书</div>
<?php
if (isset($_GET["id"])){
$id=$_GET["id"];
checkid($id);
}else{
$id=0;
}

$sql="select * from zzcms_licence where id='$id'";
$rs = mysql_query($sql); 
$row = mysql_fetch_array($rs);
if ($row["editor"]<>$username) {
markit();
mysql_close($conn);
showmsg('非法操作！警告：你的操作已被记录！小心封你的用户及IP！');
}
?>
<FORM name="myform" action="licence_save.php?action=modify" method="post" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
    <tr> 
      <td width="15%" height="50" align="right" class="border"> 资质证书：<br>
        <input name="img" type="hidden" id="img" value="<?php echo $row["img"]?>">
        <input name="oldimg" type="hidden" id="oldimg" value="<?php echo $row["img"]?>">
        <input name="id" type="hidden" id="id" value="<?php echo $row["id"]?>">
       </td>
      <td width="85%" height="50" class="border"> 
              <table width="120" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                <tr> 
                  <td align="center" bgcolor="#FFFFFF" id="showimg" onClick="openwindow('/uploadimg_form.php',400,300)"> 
                    <?php
				  if($row["img"]<>""){
				  echo "<img src='".$row["img"]."' border=0 width=120 /><br>点击可更换图片";
				  }else{
				  echo "<input name='Submit2' type='button'  value='上传图片'/>";
				  }
				  ?>
                  </td>
                </tr>
              </table>
	        </td>
    </tr>
    <tr> 
      <td align="right" class="border2">证件名称：</td>
      <td height="30" class="border2">
<input name="title" type="text" id="title" class="biaodan" value="<?php echo $row["title"]?>"> </td>
    </tr>
    <tr> 
      <td class="border">&nbsp;</td>
      <td height="30" class="border"><input name=Submit   type=submit class="buttons" id="Submit" value="保存修改结果"></td>
    </tr>
  </table>
</form>
</div> 
</div>
</div>
</div>
</body>
</html>