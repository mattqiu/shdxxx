<?php
//if(@$_SERVER['HTTP_REFERER']==''){//禁止从外部直接打开
//header("Location:".@$fromurl); exit;
//}
?>
<div class="menu">
  <div class="system_logo"></div>
  <div id="tabs"> 
    <ul>
      <li><a href="zs.php" target="_self"><span>商机信息</span></a></li>
      <li><a href="dls_message_manage.php"  target="_self"><span>查看留言</span></a></li>
      <li><a href="adv2.php"  target="_self"><span>广告设置</span></a></li>
      <li><a href="licence.php" target="_self"><span>公司资质</span></a></li>
      <li><a href="pay_manage.php" target="_self"><span>财务管理</span></a></li>
      <li><a href="manage.php"  target="_self"><span>会员资料</span></a></li>
      <li><a href="managepwd.php"  target="_self"><span>修改密码</span></a></li>
    </ul>
	</div>
</div>
<div style="clear:both"></div>
<div class="userbar"> <span style="float:right"> [ <a href="/<?php echo getpageurl3("index")?>" target="_top"><img src="/image/home.gif" border="0"> 
  网站首页</a> 
  <?php
echo " | <a href='".getpageurlzs(@$username)."'  target='_blank'><img src='/image/pic.gif' border='0'> 我的商机</a>";	
		?>
        | <a href='/one/help.php#64' target='blank'><img src="/image/ico6.gif" width="11" height="13" border="0"> 
        操作说明</a> | <a href="logout.php" target="_top"><img src="/image/ding.gif" width="11" height="13" border="0"> 
        安全退出</a> ] </span>
		您好！<strong><?php echo @$_COOKIE["UserName"];?></strong>( <?php echo ShowUserSf();?>) 
<?php
function ShowUserSf(){
	if (@$_COOKIE["UserName"]<>"" ){
		$sql="select groupname,grouppic from zzcms_usergroup where groupid=(select groupid from zzcms_user where username='".$_COOKIE["UserName"]."')";
        $rs=mysql_query($sql);
		$row=mysql_fetch_array($rs);
		$rownum=mysql_num_rows($rs);
		if ($rownum){
        $str= "<b>".$row["groupname"]."</b><img src='../".$row["grouppic"]."'> " ;
		}
 		   
		$sql="select groupid,totleRMB,startdate,enddate from zzcms_user where username='" .$_COOKIE["UserName"]. "'";
        $rs=mysql_query($sql);
		$row=mysql_fetch_array($rs);
		$rownum=mysql_num_rows($rs);
		if ($rownum){
			if ($row["groupid"]>1){
			$str=$str . " 服务时间：".$row["startdate"]." 至 ".$row["enddate"];
			}elseif ($row["groupid"]==1){
			$str=$str . "<a href='/one/vipuser.php' target='_blank'>查看我的权限</a>";
			}
		}else{
			$str="用户不存在！";
		}		
		
	}else{
	$str="您尚未登录";
	}
echo $str;			 
}
?>		
</div>