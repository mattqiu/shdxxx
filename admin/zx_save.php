<?php
include("admin.php");
checkadminisdo("zx");
if (isset($_POST["page"])){//只从修改页传来的值
$page=$_POST["page"];
}else{
$page=1;
}

$bigclassid=trim($_POST["bigclassid"]);
$rs = mysql_query("select * from zzcms_zxclass where classid=".$bigclassid.""); 
$row= mysql_fetch_array($rs);
$bigclassname=$row["classname"];

$smallclassid=trim($_POST["smallclassid"]);
if ($smallclassid==""){
$smallclassid=0;
}
if ($smallclassid!=0){
$rs = mysql_query("select * from zzcms_zxclass where classid=".$smallclassid.""); 
$row= mysql_fetch_array($rs);
$smallclassname=$row["classname"];
}else{
$smallclassname="";
}

$title=trim($_POST["title"]);
$link=addhttp(trim($_POST["link"]));
$laiyuan=trim($_POST["laiyuan"]);
$content=str_replace("'","",stripfxg(trim($_POST["content"])));
$img=trim($_POST["img"]);

//---保存内容中的远程图片，并替换内容中的图片地址
$msg='';
$imgs=getimgincontent($content,2);
if (is_array($imgs)){
foreach ($imgs as $value) {
	if (substr($value,0,4) == "http"){
	$img_bendi=grabimg($value,"");//如果是远程图片保存到本地
	if($img_bendi):$msg=$msg.  "远程图片：".$value."已保存为本地图片：".$img_bendi."<br>";else:$msg=$msg. "false";endif;
	$img_bendi=substr($img_bendi,strpos($img_bendi,"/uploadfiles"));//在grabimg函数中$img被加了zzcmsroo。这里要去掉
	$content=str_replace($value,$img_bendi,$content);//替换内容中的远程图片为本地图片
	}
}
}
//---end
if ($img==''){//放到内容下面，避免多保存一张远程图片
$img=getimgincontent($content);
}

if ($img<>''){
	if (substr($img,0,4) == "http"){//$img=trim($_POST["img"])的情况下，这里有可能是远程图片地址
		$img=grabimg($img,"");//如果是远程图片保存到本地
		if($img):$msg=$msg. "远程图片已保存到本地：".$img."<br>";else:$msg=$msg. "false";endif; 
		$img=substr($img,strpos($img,"/uploadfiles"));//在grabimg函数中$img被加了zzcmsroo。这里要去掉 
	}
		
	$imgsmall=str_replace(siteurl,"",getsmallimg($img));
	if (file_exists(zzcmsroot.$imgsmall)===false && file_exists(zzcmsroot.$img)!==false){//小图不存在，且大图存在的情况下，生成缩略图
	makesmallimg($img);//同grabimg一样，函数里加了zzcmsroot
	}	
}


$keywords=trim($_POST["keywords"]);
if ($keywords=="" ){
$keywords=$title;
}
$description=trim($_POST["description"]);
if (isset($_POST["elite"])){
$elite=$_POST["elite"];
	if ($elite>255){
	$elite=255;
	}elseif ($elite<0){
	$elite=0;
	}
}else{
$elite=0;
}

$groupid=trim($_POST["groupid"]);
$jifen_info=trim($_POST["jifen"]);

if(!empty($_POST['passed'])){
$passed=$_POST['passed'][0];
}else{
$passed=0;
}

if ($_REQUEST["action"]=="add"){
//判断是不是重复信息,为了修改信息时不提示这段代码要放到添加信息的地方
//$sql="select title,editor from zzcms_zx where title='".$title."'";
//$rs = mysql_query($sql); 
//$row= mysql_fetch_array($rs);
//if ($row){
//showmsg('此信息已存在，请不要发布重复的信息！','zx_add.php');
//}

$isok=mysql_query("Insert into zzcms_zx(bigclassid,bigclassname,smallclassid,smallclassname,title,link,laiyuan,keywords,description,content,img,groupid,jifen,elite,passed,sendtime) values('$bigclassid','$bigclassname','$smallclassid','$smallclassname','$title','$link','$laiyuan','$keywords','$description','$content','$img','$groupid','$jifen_info','$elite','$passed','".date('Y-m-d H:i:s')."')");  

$id=mysql_insert_id();
		
}elseif ($_REQUEST["action"]=="modify"){
$id=$_POST["id"];
$isok=mysql_query("update zzcms_zx set bigclassid='$bigclassid',bigclassname='$bigclassname',smallclassid='$smallclassid',smallclassname='$smallclassname',title='$title',link='$link',laiyuan='$laiyuan',keywords='$keywords',description='$description',content='$content',img='$img',groupid='$groupid',jifen='$jifen_info',sendtime='".date('Y-m-d H:i:s')."',elite='$elite',passed='$passed' where id='$id'");	
}

setcookie("zxbigclassid",$bigclassid);
setcookie("zxsmallclassid",$smallclassid);
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center" class="left-title"><?php
	if ($_REQUEST["action"]=="add") {
      echo "添加 ";
	  }else{
	  echo"修改";
	  }
	  if ($isok){
	  echo"成功";
	  }else{
	  echo "失败";
	  }
     ?></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="#FFFFFF"> 
          <td width="20%" align="right" bgcolor="#FFFFFF">名称：</td>
          <td width="80%"><?php echo $title?></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="right" bgcolor="#FFFFFF">是否推荐：</td>
          <td> 
            <?php if ($elite<>0){echo "是" ;}else{ echo "否" ;}?>
          </td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="right" bgcolor="#FFFFFF">类别：</td>
          <td><?php echo $bigclassname.">".$smallclassname?></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25%" align="center" class="border"><a href="zx_add.php">继续添加</a></td>
          <td width="25%" align="center" class="border"><a href="zx_manage.php?b=<?php echo $_REQUEST["bigclassid"]?>&page=<?php echo $page?>">返回</a><a href="zx_manage.php?b=<?php echo $_REQUEST["bigclassid"]?>&page=<?php echo $page?>"></a></td>
          <td width="25%" align="center" class="border"><a href="zx_modify.php?id=<?php echo $id?>">修改</a></td>
          <td width="25%" align="center" class="border"><a href="<?php echo getpageurl("zx",$id)?>" target="_blank">预览</a></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<?php 
if ($msg<>'' ){echo "<div class='border'>" .$msg."</div>";}
mysql_close($conn);
?>
</body>
</html>