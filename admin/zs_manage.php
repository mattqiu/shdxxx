<?php
include("admin.php");
include("../inc/fy.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="/js/gg.js"></script>
<?php
$action=isset($_REQUEST["action"])?$_REQUEST["action"]:'';
$page=isset($_GET["page"])?$_GET["page"]:1;
$shenhe=isset($_REQUEST["shenhe"])?$_REQUEST["shenhe"]:'';
$keyword=isset($_REQUEST["keyword"])?$_REQUEST["keyword"]:'';
$kind=isset($_REQUEST["kind"])?$_REQUEST["kind"]:'editor';
$b=isset($_REQUEST["b"])?$_REQUEST["b"]:'';
$showwhat=isset($_REQUEST["showwhat"])?$_REQUEST["showwhat"]:'';

if ($action=="pass"){
checkadminisdo("zs");
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$_POST['id'][$i];
	$sql="select passed from zzcms_main where id ='$id'";
	$rs = mysql_query($sql); 
	$row = mysql_fetch_array($rs);
		if ($row['passed']=='0'){
		mysql_query("update zzcms_main set passed=1 where id ='$id'");
		}else{
		mysql_query("update zzcms_main set passed=0 where id ='$id'");
		}
	}
}else{
echo "<script>alert('操作失败！至少要选中一条信息。');history.back()</script>";
}
echo "<script>location.href='?keyword=".$keyword."&page=".$page."'</script>";	
}
?>
</head>
<body>
<div class="admintitle">招商信息管理</div>
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr> 
    <td class="border">
<form name="form1" method="post" action="?">
        <input type="radio" name="kind" value="editor" <?php if ($kind=="editor") { echo "checked";}?>>
        按发布人 
        <input type="radio" name="kind" value="proname" <?php if ($kind=="proname") { echo "checked";}?>>
        按产品名称 
        <input name="keyword" type="text" id="keyword" size="25" value="<?php echo  $keyword?>">
        <input type="submit" name="Submit" value="查寻">
        <a href="?showwhat=elite">固顶的信息</a> <a href="?showwhat=vip">VIP会员的信息</a> 
         
      </form>
		</td>
    </tr>
    <tr>
    <td class="border">
	<table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF" style="color:#cccccc">
        <tr>
          <td>
    <?php	
$sql="select * from zzcms_zsclass where parentid='A' order by xuhao";
$rs = mysql_query($sql); 
$row = mysql_num_rows($rs);
if (!$row){
echo '暂无分类';
}else{
while($row = mysql_fetch_array($rs)){
echo "<a href=?b=".$row['classzm'].">";  
	if ($row["classzm"]==$b) {
	echo "<b>".$row["classname"]."</b>";
	}else{
	echo $row["classname"];
	}
	echo "</a> | ";  
 }
} 
 ?>		  
          </td>
        </tr>
      </table> </td>
    </tr>
  </table>

<?php
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select count(*) as total from zzcms_main where id<>0  ";
$sql2='';
if ($shenhe=="no") {  		
$sql2=$sql2." and passed=0 ";
}
if ($b<>"") {
$sql2=$sql2." and bigclasszm='".$b."' ";
}
if ($keyword<>"") {
	switch ($kind){
	case "editor";
	$sql2=$sql2. " and editor like '%".$keyword."%' ";
	break;
	case "proname";
	$sql2=$sql2. " and proname like '%".$keyword."%'";
	break;
	default:
	$sql2=$sql2. " and editor like '%".$keyword."%'";
	}
}
if ($showwhat=="elite" ){		
	$sql2=$sql2." and elite<>0 ";
}
if ($showwhat=="vip" ){		
	$sql2=$sql2." and editor in(select username from zzcms_user where groupid>1) ";
}
$rs = mysql_query($sql.$sql2); 
$row = mysql_fetch_array($rs);
$totlenum = $row['total'];
$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_main where id<>0 ";
$sql=$sql.$sql2;
$sql=$sql . " order by id desc limit $offset,$page_size";
$rs = mysql_query($sql); 
if(!$totlenum){
echo "暂无信息";
}else{
?>
<form name="myform" id="myform" method="post" action="">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td> 
        <input type="submit" onClick="myform.action='?action=pass'" value="【取消/审核】选中的信息">
         <input type="submit" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" value="删除选中的信息">
        <input name="pagename" type="hidden"  value="zs_manage.php?b=<?php echo $b?>&shenhe=<?php echo $shenhe?>&page=<?php echo $page ?>"> 
        <input name="tablename" type="hidden"  value="zzcms_main"> </td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
    <tr> 
      <td width="5%" height="25" align="center" class="border"><label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label></td>
      <td width="5%" height="25" align="center" class="border">图片</td>
      <td width="10%" height="25" align="center" class="border">产品名称</td>
      <td width="10%" align="center" class="border">类别</td>
      <td width="5%" height="25" align="center" class="border">发布人</td>
      <td width="5%" align="center" class="border">发布时间</td>
      <td width="5%" align="center" class="border">信息状态</td>
      <td width="5%" align="center" class="border">操作</td>
    </tr>
    <?php
while($row = mysql_fetch_array($rs)){
?>
    <tr onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)" bgcolor="#FFFFFF"> 
      <td align="center" class="docolor"> <input name="id[]" type="checkbox" id="id2" value="<?php echo $row["id"]?>"></td>
      <td align="center" ><a href="<?php echo $row["img"]?>" target="_blank"><img src="<?php echo getsmallimg($row['img'])?>" width="60"></a></td>
      <td align="center" ><a href="<?php echo getpageurlzs($row["editor"]) ?>" target="_blank">
        <?php  echo $row["proname"]?>
        </a></td>
      <td align="center"><a href="?b=<?php echo $row["bigclasszm"]?>" ><?php echo $row["bigclasszm"]?></a></td>
      <td align="center"><a href="usermanage.php?keyword=<?php echo $row["editor"]?>" ><?php echo $row["editor"]?></a><br> 
      userid:<?php echo $row["userid"]?></td>
      <td align="center" title="<?php echo $row["sendtime"]?>"><?php echo $row["sendtime"]?>      </td>
      <td align="center"> 
        <?php if ($row["passed"]==1) { echo "已审核";} else {echo "<font color=red>未审核</font>";}?>      </td>
      <td align="center" class="docolor"><a href="zs_modify.php?id=<?php echo $row["id"] ?>&page=<?php echo $page ?>">修改</a></td>
    </tr>
    <?php
 }
 ?>
  </table>
      <div class="border"> <input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
        <label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label> 
        <input type="submit" onClick="myform.action='?action=pass'" value="【取消/审核】选中的信息"> 
        <input type="submit" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" value="删除选中的信息">
      </div>
</form>
<div class="border center"><?php echo showpage_admin()?></div>
<?php
}
mysql_close($conn);
?>
</body>
</html>