<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title></title>
<?php
//���ã���������Ϊgb2312���ԣ��Ѵ�ҳ�������ˣ���dl_liuyan_save.php���е���
include("../../inc/config.php");
include ("inc.php");
	$mobile=$_GET['mobile'];
	$msg=$_GET['msg'];
	$tourl=$_GET['tourl'];
	
	$result = sendSMS(smsusername,smsuserpass,$mobile,$msg,apikey_mobile_msg);
	//echo $result."<br>";	
echo "<script>alert('ok');location.href='$tourl'</script>";
?>