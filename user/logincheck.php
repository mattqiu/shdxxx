<?php
if(!isset($_SESSION)){session_start();} 
ob_start();//打开缓冲区，可以setcookie
include("../inc/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="template/<?php echo siteskin?>/style.css" rel="stylesheet" type="text/css">
</head>
<body>
正在登录中，请稍候……
<?php
include '../3/ucenter_api/config.inc.php';//集成ucenter
include '../3/ucenter_api/uc_client/client.php';//集成ucenter
$ip=getip();
define('trytimes',10);//可尝试登录次数
define('jgsj',10*60);//间隔时间，秒
$sql="select * from zzcms_login_times where ip='$ip' and count>=".trytimes." and unix_timestamp()-unix_timestamp(sendtime)<".jgsj." ";
$rs = mysql_query($sql); 
$row= mysql_num_rows($rs);
if ($row){
$jgsj=jgsj/60;
showmsg("密码错误次数过多，请于".$jgsj."分钟后再试！");
}
checkyzm($_POST["yzm"]);
$go=0;
$username=nostr(trim($_POST["username"]));
$password=md5(trim($_POST["password"]));
$fromurl=@$_POST["fromurl"];
$CookieDate=@$_POST["CookieDate"][0];
if ($CookieDate=="") {
$CookieDate=0;
}

$sql="select * from zzcms_user where username='".$username."' and  password='".$password."' ";
$rs = mysql_query($sql,$conn); 
$row= mysql_num_rows($rs);
if(!$row){
	$sql="select * from zzcms_usernoreg where username='".$username."' ";
	$rs = mysql_query($sql,$conn); 
	//$row= mysql_num_rows($rs);
	$row= mysql_fetch_array($rs);
		if(!$row){
		//记录登录次数
		$sqln="select * from zzcms_login_times where ip='$ip'";
		$rsn = mysql_query($sqln); 
		$rown= mysql_num_rows($rsn);
			if ($rown){
				$rown= mysql_fetch_array($rsn);	
				if ($rown['count']>=trytimes && strtotime(date("Y-m-d H:i:s"))-strtotime($rown['sendtime'])>jgsj){//15分钟前登录过的归0
				mysql_query("UPDATE zzcms_login_times SET count = 0 WHERE ip='$ip'");
				}
			mysql_query("UPDATE zzcms_login_times SET count = count+1,sendtime='".date('Y-m-d H:i:s')."' WHERE ip='$ip'");//有记录的更新
			}else{
			mysql_query("INSERT INTO zzcms_login_times (count,sendtime,ip)VALUES(1,'".date('Y-m-d H:i:s')."','$ip')");
			}
		
		$sqln="select * from zzcms_login_times where ip='$ip'";
		$rsn = mysql_query($sqln); 
		$rown= mysql_fetch_array($rsn);
		$count=	$rown['count'];
		$trytimes=trytimes-$count;
		echo "<script>alert('用户名或密码错误！你还可以尝试 $trytimes 次');history.back()</script>";
		}else{
		$emailsite="http://mail.".substr($row['email'],strpos($row['email'],"@")+1)."";
		echo "<div class='box' style='font-size:14px;margin:50px 0'><ul style='background-color:#FFFFFF;padding:10px'><li><b>您的帐号尚未激活！</b></li>";
		echo "<li><form name='form1' method='post' action='/reg/sendmailagain.php'>帐号需要激活后才能使用，激活邮件已发送到您注册帐号时所填写的邮箱 <input type='text' name='newemail' value='".$row['email']."'><input type='hidden' name='username' value='".$username."'><input type='submit' name='Submit' value='重发'> 请登录到您的邮箱查收 。</form></li>";
		echo "<li style='padding:20px'><input type='button' class='button_big' value='点击登录您的邮箱'  onclick='window.open('".$emailsite."')'/></li></ul></div>";
		}
}else{
	$sql=$sql."and lockuser=0 ";
	$rs = mysql_query($sql,$conn); 
	//$row= mysql_num_rows($rs);
	$row= mysql_fetch_array($rs);
		if(!$row){
		echo "<script>alert('用户被锁定！');history.go(-1)</script>";
		}else{
		mysql_query("UPDATE zzcms_user SET showlogintime = lastlogintime WHERE username='".$username."'");//更新上次登录时间
		mysql_query("UPDATE zzcms_user SET showloginip = loginip WHERE username='".$username."'");//更新上次登录IP
		mysql_query("UPDATE zzcms_user SET logins = logins+1 WHERE username='".$username."'");
		mysql_query("UPDATE zzcms_user SET loginip = '".getip()."' WHERE username='".$username."'");//更新最后登录IP
		if (strtotime(date("Y-m-d H:i:s"))-strtotime($row['lastlogintime'])>86400){
		mysql_query("UPDATE zzcms_user SET totleRMB = totleRMB+".jf_login." WHERE username='".$username."'");//登录时加积分
		mysql_query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime) values('$username','每天登录用户中心送积分','+".jf_login."','','".date('Y-m-d H:i:s')."')");//记录积分
		}
		mysql_query("UPDATE zzcms_user SET lastlogintime = '".date('Y-m-d H:i:s')."' WHERE username='".$username."'");//更新最后登录时间
		
		if ($CookieDate==1){
		setcookie("UserName",$username,time()+3600*24*365,"/");
		setcookie("PassWord",$password,time()+3600*24*365,"/");
		}
		elseif($CookieDate==0){
		setcookie("UserName",$username,time()+3600*24,"/");
		setcookie("PassWord",$password,time()+3600*24,"/");
		}
		//集成ucenter
if (bbs_set=='Yes'){	
	list($uid, $username, $password, $email) = uc_user_login($_POST['username'], $_POST['password']);
	setcookie('Example_auth', '', -86400);
	if($uid > 0) {
		//用户登录成功，设置 Cookie，加密直接用 uc_authcode 函数，用户使用自己的函数
		setcookie('Example_auth', uc_authcode($uid."\t".$username, 'ENCODE'));
		//生成同步登录的代码
		$ucsynlogin = uc_user_synlogin($uid);
		echo '同时登录论坛成功'.$ucsynlogin;//必须输出，否则不同步
		
	} elseif($uid == -1) {
		echo '用户不存在,或者被删除';
	} elseif($uid == -2) {
		echo '密码错';
	} else {
		echo '未定义';
	}
}	
//end

		if ($fromurl != "" && $fromurl != siteurl."/" && strpos($fromurl,'userregcheckemail.php')==false && strpos($fromurl,'userreg.htm')==false && strpos($fromurl,'userreg.php')==false  && $fromurl != siteurl."reg/userregpost.php" && $fromurl != siteurl."one/getpassword.php"
) {//从邮箱验证地址中传过来的值，不要返回到邮箱
		echo "<script>location.href='".$fromurl."';</script>";
		}else{
		echo "<script>location.href='/user/login.php';</script>";
		}
		}
}
session_write_close();				
?>