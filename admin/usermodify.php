<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/js/timer.js"></script>
<script language = "JavaScript" src="/js/gg.js"></script>
<script>
function  CheckNum(){ 
//定义正则表达式部分
var strP=/^\d+$/;
if(!strP.test(document.myform.totleRMB.value)) {
alert("充值数必需为数字！"); 
document.myform.imgwidth.focus(); 
return false; 
}
if(!strP.test(document.myform.elite.value)) {
alert("推荐值必需为数字！"); 
document.myform.elite.focus(); 
return false; 
}
}
</script> 
<body>
<?php
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
$FoundErr=0;
$id=trim($_REQUEST["id"]);
if ($id=="") {
	$FoundErr=1;
	$errmsg="<li>参数不足！</li>";
}else{
	$sql="select * from zzcms_user where id='$id'";
	$rs=mysql_query($sql);
	$row=mysql_num_rows($rs);
	if (!$row){
	$FoundErr=1;
	$errmsg=$errmsg . "<li>找不到指定的用户！</li>";
	}else{
		$row=mysql_fetch_array($rs);
		if ($action=="modify") {
			checkadminisdo("userreg");
			$password=trim($_POST["password"]);
			$sex=trim($_POST["sex"]);
			$email=trim($_POST["email"]);
			$homepage=trim($_POST["homepage"]);	
			$comane=trim($_POST["comane"]);
			$oldcomane=trim($_POST["oldcomane"]);
			$gsjj=trim($_POST["gsjj"]);
			$img=trim($_POST["img"]);
			$oldimg=trim($_POST["oldimg"]);
			$flv=trim($_POST["flv"]);
			$address=trim($_POST["address"]);
			$somane=trim($_POST["somane"]);
			$phone=trim($_POST["phone"]);
			$mobile=trim($_POST["mobile"]);
			$fox=trim($_POST["fox"]);
			$qq=trim($_POST["qq"]);
			$oldqq=trim($_POST["oldqq"]);
			if(!empty($_POST['qqid'])){
			$qqid=$_POST['qqid'][0];
			}else{
			$qqid=0;
			}
			$passed=trim($_POST["passed"]);
			$renzheng=trim($_POST["renzheng"]);
			$oldrenzheng=trim($_POST["oldrenzheng"]);
			$lockuser=trim($_POST["lockuser"]);
			$groupid=trim($_POST["groupid"]);
			$oldgroupid=trim($_POST["oldgroupid"]);
			$totleRMB=trim($_POST["totleRMB"]);
			$startdate=trim($_POST["startdate"]);
			$enddate=trim($_POST["enddate"]);
			$elite=trim($_POST["elite"]);
			if ($elite==""){
			$elite=0;
			}elseif($elite>255){
			$elite=255;	
			}elseif ($elite<0){
			$elite=0;
			}
			
			if ($lockuser=="") {
				$FoundErr=1;
				$errmsg=$errmsg . "<li>用户状态不能为空！</li>";
			}
			if ($FoundErr==0){
			mysql_query("update zzcms_user set sex='$sex',email='$email',homepage='$homepage',comane='$comane',content='$gsjj' where id='$id'");
			mysql_query("update zzcms_user set img='$img',flv='$flv',address='$address',somane='$somane',phone='$phone' where id='$id' ");	
			mysql_query("update zzcms_user set mobile='$mobile',fox='$fox',qq='$qq',passed='$passed',renzheng='$renzheng',lockuser='$lockuser' where id='$id' ");	
			mysql_query("update zzcms_user set groupid='$groupid',totleRMB='$totleRMB',startdate='$startdate',enddate='$enddate',elite='$elite' where id='$id' ");	
				
				if ($password!="") {
				mysql_query("update zzcms_user set password='".md5($password)."',passwordtrue='$password' where id='$id' ");
				}
				if ($qqid==0) {
				mysql_query("update zzcms_user set qqid='' where id='$id' ");
				}
				if ($groupid!=$oldgroupid){
					mysql_query("Update zzcms_main set groupid=" . $groupid . " where editor='" . $row["username"] . "'");	
				}
				if ($qq<>$oldqq) {
				mysql_query("Update zzcms_main set qq='" . $qq . "' where editor='" . $row["username"] . "'");
				}
				if ($comane<>$oldcomane){
				mysql_query("Update zzcms_main set comane='" . $comane ."' where editor='" . $row["username"] . "'");
				}
				if ($renzheng<>$oldrenzheng) {
				mysql_query("Update zzcms_main set renzheng=" . $renzheng . " where editor='" . $row["username"] . "'");
				}	
				if ($oldimg<>$img && $oldimg<>"/image/nopic.gif"){
				$f='../'.substr($oldimg,1);
				if (file_exists($f)){
				unlink($f);
				}
				$fs='../'.substr(str_replace(".","_small.",$oldimg),1);
				if (file_exists($fs)){
				unlink($fs);		
				}
				}			
				echo "<script>alert('修改成功');history.back()</script>";	
			}
		}
	}
}
if ($FoundErr==1) {
WriteErrMsg($errmsg);
}else{
?>
<div class="admintitle">修改注册用户信息</div>
<FORM name="myform" action="?" method="post">
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr> 
      <td height="30" colspan="2" class="userbar"><strong>用户信息</strong></td>
    </tr>
    <tr> 
      <td width="20%" align="right" class="border">用户名：</td>
      <td width="80%" class="border"><?php echo $row["username"]?></td>
    </tr>
    <tr> 
      <td align="right" class="border">密码：</td>
      <td class="border"> <input name="password"  type="text"  size="30" maxLength="16">
        (如不改密码，这里空出) </td>
    </tr>
    <tr> 
      <td align="right" class="border">联系人：</td>
      <td class="border"> <input name="somane" value="<?php echo $row["somane"]?>" size="30" maxLength="50"></td>
    </tr>
    <tr> 
      <td align="right" class="border">性别：</td>
      <td class="border"> <input type="radio" value="1" name="sex" <?php if ($row["sex"]==1) { echo "checked";}?>>
        男 
        <input type="radio" value="0" name="sex" <?php if ($row["sex"]==0 ){ echo "checked";}?>>
        女</td>
    </tr>
    <tr> 
      <td align="right" class="border">手机：</td>
      <td class="border"><input name=mobile id="mobile" value="<?php echo $row["mobile"]?>" size="30" maxLength="50"></td>
    </tr>
    <tr> 
      <td align="right" class="border">E-mail：</td>
      <td class="border"> <input name="email" value="<?php echo $row["email"]?>" size="30" maxLength="50">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">QQ<strong>：</strong></td>
      <td class="border"><input name="qq" id="qq" value="<?php echo $row["qq"]?>" size="30" maxLength="50"> 
        <input name="oldqq" type="hidden" id="oldqq" value="<?php echo $row["qq"]?>"></td>
    </tr>
    <tr> 
      <td align="right" class="border">QQ绑定登录网站：</td>
      <td class="border"> 
        <?php 
	  if ($row["qqid"]<>""){
	  ?>
        <input name="qqid[]" type="checkbox" id="qqid[]" value="1" checked>
        (已绑定。点击可取消绑定) 
        <?php
		}else{
		echo "未绑定QQ登录";
		}
		?>      </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name=Submit2   type=submit id="Submit2" value="保存修改结果"></td>
    </tr>
    <tr> 
      <td colspan="2" class="userbar"><strong>公司信息</strong> </td>
    </tr>
    <tr> 
      <td align="right" class="border">公司名称：</td>
      <td class="border"> <input name="comane" value="<?php echo $row["comane"]?>" size="30"> 
        <input name="oldcomane" type="hidden" id="oldcomane" value="<?php echo $row["comane"]?>"></td>
    </tr>
    <tr> 
      <td align="right" class="border">公司简介：</td>
      <td class="border"> <textarea name="gsjj" cols="80" rows="10" id="gsjj"><?php echo $row["content"]?></textarea>      </td>
    </tr>
    <tr> 
      <td align="right" class="border">公司形象图片：
        <input name="img" type="hidden" id="img" value="<?php echo $row["img"]?>">
        <input name="oldimg" type="hidden" id="oldimg" value="<?php echo $row["img"]?>">
      </td>
      <td class="border">

	  <table width="140" height="140" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
        <tr>
          <td align="center" bgcolor="#FFFFFF" id="showimg" onClick="openwindow('/uploadimg_form.php',400,300)"><?php
				  if($row["img"]<>"" && $row["img"]<>"/image/nopic.gif"){
				  echo "<img src='".$row["img"]."' border=0 width=120/><br>点击可更换图片";
				  }else{
				  echo "<input name='Submit2' type='button'  value='上传图片'/>";
				  }
				  ?>
          </td>
        </tr>
      </table></td>
    </tr>
    <tr> 
      <td align="right" class="border">公司形象视频：</td>
      <td class="border"><input name="flv" id="flv" value="<?php echo $row["flv"]?>" size="30"></td>
    </tr>
    <tr> 
      <td align="right" class="border">公司主页：</td>
      <td class="border"><input  maxlength="100" size="30" name="homepage" value="<?php echo $row["homepage"]?>"></td>
    </tr>
    <tr> 
      <td align="right" class="border">详细地址：</td>
      <td class="border"> <input name="address" value="<?php echo $row["address"]?>" size="30" maxLength="50"></td>
    </tr>
    <tr> 
      <td align="right" class="border">联系电话：</td>
      <td class="border"> <input name=phone value="<?php echo $row["phone"]?>" size="30" maxLength="50"></td>
    </tr>
    <tr> 
      <td align="right" class="border">传真：</td>
      <td class="border"> <input name=fox value="<?php echo $row["fox"]?>" size="30" maxLength="50"></td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name=Submit3   type=submit id="Submit3" value="保存修改结果"></td>
    </tr>
    <tr  > 
      <td height="30" colspan="2" class="userbar"><strong>用户权限</strong></td>
    </tr>
    <tr> 
      <td align="right" class="border">是否审核：</td>
      <td class="border"><input type="radio" name="passed" value="0" <?php if ($row["passed"]==0) { echo "checked";}?>>
        未审核 
        <input type="radio" name="passed" value="1" <?php if ($row["passed"]==1) { echo "checked";}?>>
        已审核</td>
    </tr>
    <tr> 
      <td align="right" class="border">用户状态：</td>
      <td class="border"> <input type="radio" name="lockuser" value="0" <?php if ($row["lockuser"]==0) { echo "checked";}?>>
        正常 
        <input type="radio" name="lockuser" value="1" <?php if ($row["lockuser"]==1) { echo "checked";}?>>
        锁定</td>
    </tr>
    <tr> 
      <td align="right" class="border">是否认证：</td>
      <td class="border"><input type="radio" name="renzheng" value="0" <?php if ($row["renzheng"]==0) { echo "checked";}?>>
        未认证 
        <input type="radio" name="renzheng" value="1" <?php if ($row["renzheng"]==1) { echo "checked";}?>>
        已认证 
        <input name="oldrenzheng" type="hidden" id="oldrenzheng" value="<?php echo $row["renzheng"]?>"></td>
    </tr>
    <tr> 
      <td align="right" class="border">所属用户组：</td>
      <td class="border"> <select name="groupid">
          <?php
			$rsn=mysql_query("select * from zzcms_usergroup order by groupid asc");
			$r=mysql_num_rows($rsn);
			if ($r){
			while ($r=mysql_fetch_array($rsn)){
				if ($r["groupid"]==$row["groupid"]){
			 	echo "<option value='".$r["groupid"]."' selected>".$r["groupname"]."</option>";
				}else{
				echo "<option value='".$r["groupid"]."' >".$r["groupname"]."</option>";
				}
			}
			}
			?>
        </select> <input name="oldgroupid" type="hidden" id="oldgroupid" value="<?php echo $row["groupid"]?>">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">充费：</td>
      <td class="border"> <input name="totleRMB" type="text" id="totleRMB" value="<?php if ($row["totleRMB"]<>"") {echo  $row["totleRMB"]; }else{ echo "0"; }?>" size="10" onBlur="CheckNum()">
        金币</td>
    </tr>
    <tr> 
      <td align="right" class="border">会员期限：</td>
      <td class="border"> <input name="startdate" type="text" id="startdate" value="<?php if ($row["startdate"]<>"") {echo  $row["startdate"]; }else{ echo date('Y-m-d'); }?>" size="15" onFocus="JTC.setday(this)">
        至 
        <input name="enddate" type="text" id="enddate" value="<?php if ($row["enddate"]<>"") {echo  $row["enddate"]; }else{ echo date('Y-m-d',time()+365*24*3600); }?>" size="15" onFocus="JTC.setday(this)">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">置顶值：</td>
      <td height="20" class="border"><input name="elite" id="elite" value="<?php echo $row["elite"]?>" size="4" maxLength="4" onBlur="CheckNum()">
        （设值范围 1-255，数值越大排位越靠顶部） </td>
    </tr>
    <tr> 
      <td height="20" align="center" class="border">&nbsp;</td>
      <td height="20" class="border"><input name="action" type="hidden" id="Action2" value="modify"> 
        <input name=Submit   type=submit id="Submit" value="保存修改结果"> <input name="id" type="hidden" id="id" value="<?php echo $row["id"]?>"></td>
    </tr>
    <tr> 
      <td height="40" colspan="2" align="center">&nbsp;</td>
    </tr>
  </TABLE>
</form>
<?php
}
mysql_close($conn);
?>