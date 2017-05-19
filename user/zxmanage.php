<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>资讯管理</title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="/js/gg.js"></script>
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
<div class="admintitle">
<span>
<form name="form1" method="post" action="?">标题： <input name="keyword" type="text" id="keyword"> <input type="submit" name="Submit" value="查找"></form>
</span>
资讯信息管理</div>
<?php
if (isset($_GET["bigclassid"])){
$bigclassid=$_GET["bigclassid"];
}else{
$bigclassid="";
}

if (isset($_POST["keyword"])){ 
$keyword=trim($_POST["keyword"]);
}else{
$keyword="";
}	

if( isset($_GET["page"]) && $_GET["page"]!="") {
    $page=$_GET['page'];
}else{
    $page=1;
}

$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select count(*) as total from zzcms_zx where editor='".$username."' ";
$sql2='';
if ($bigclassid!=""){
checkid($bigclassid);
$sql2=$sql2." and bigclassid='".$bigclassid."' ";
}

if ($keyword!=""){
$sql2=$sql2." and title like '%".$keyword."%' ";
}
$sql=$sql.$sql2;
$rs = mysql_query($sql); 
$row = mysql_fetch_array($rs);
$totlenum = $row['total'];
$totlepage=ceil($totlenum/$page_size);

$sql="select id,bigclassid,smallclassid,bigclassname,smallclassname,title,sendtime,passed,hit from zzcms_zx where editor='".$username."' ";	
$sql=$sql.$sql2;
$sql=$sql . " order by id desc limit $offset,$page_size";
$rs = mysql_query($sql); 
if(!$totlenum){
echo "暂无信息";
}else{
?>
<form name="myform" method="post" action="del.php">
        <table width="100%" border="0" cellpadding="5" cellspacing="1" class="bgcolor">
          <tr> 
            <td width="20%" height="25" class="border">标题</td>
            <td width="10%" align="center" class="border">所属类别</td>
            <td width="10%" align="center" class="border">更新时间</td>
            <td width="5%" align="center" class="border">审核状态</td>
            <td width="5%" align="center" class="border">点击</td>
            <td width="5%" align="center" class="border">操作</td>
            <td width="5%" align="center" class="border">删除</td>
          </tr>
          <?php
while($row = mysql_fetch_array($rs)){
?>
          <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
            <td><a href="<?php echo getpageurl("zx",$row["id"])?>" target="_blank"><?php echo $row["title"]?></a>            </td>
            <td> 
			<a href="?bigclassid=<?php echo $row["bigclassid"]?>"><?php echo $row["bigclassname"]?></a> 
              - <?php echo $row["smallclassname"]?>            </td>
            <td align="center"><?php echo $row["sendtime"]?></td>
            <td align="center"> 
              <?php 
	if ($row["passed"]==1 ){ echo "<font color='green'>已审核</font>";}else{ echo "<font color=red>待审</font>";}
	  ?>            </td>
            <td align="center"><?php echo $row["hit"]?>次</td>
            <td align="center"> 
			
              <a href="zxmodify.php?id=<?php echo $row["id"]?>&page=<?php echo $page?>&bigclassid=<?php echo $bigclassid?>">修改</a></td>
            <td align="center"><input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>" /></td>
          </tr>
          <?php
}
?>
        </table>

<div class="fenyei">
<?php echo showpage("yes")?> 
 <input name="chkAll" type="checkbox" id="chkAll" onclick="CheckAll(this.form)" value="checkbox" />
          <label for="chkAll">全选</label>
<input name="submit"  type="submit" class="buttons"  value="删除" onClick="return ConfirmDel()"> 
<input name="pagename" type="hidden" id="page2" value="zxmanage.php?page=<?php echo $page ?>"> 
<input name="tablename" type="hidden" id="tablename" value="zzcms_zx"> 
</div>
  </form>
<?php
}
mysql_close($conn);
?>
</div>
</div>
</div>
</div>
</body>
</html>