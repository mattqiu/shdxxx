<?php
include("../inc/conn.php");
include("check.php");
//此页不能且不需要链接CSS文件，否则生成的下载文件打开时会提示少CSS文件。
$founderr=0;
$ErrMsg="";
if (check_user_power("dls_download")=="no"){
$founderr=1;
$ErrMsg=$ErrMsg."您所在的用户组没有下载代理信息的权限！<br><input  type=button value=升级成VIP会员 onclick=\"location.href='/one/vipuser.php'\"/>";
}

$id="";
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$id.($_POST['id'][$i].',');
    }
	$id=substr($id,0,strlen($id)-1);//去除最后面的","
}

if (strpos($id,',')==0){
$founderr=1;
$ErrMsg="<li>操作失败！至少要选中两条信息才能下载。</li>";
}

if ($founderr==1){
WriteErrMsg($ErrMsg);
}else{

if (isset($_POST['FileExt'])){
$FileExt=$_POST['FileExt'];
}else{
$FileExt="xls";
}
if ($FileExt=="xls"){
header("Content-type:application/vnd.ms-excel;");
header("Content-Disposition:filename=".$username."下载于".date('Y-m-d H:i:s').".xls");
}elseif ($FileExt=="doc"){
header("Content-type:application/vnd.ms-word;");
header("Content-Disposition:filename=".$username."下载于".date('Y-m-d H:i:s').".doc");
}

if (strpos($id,",")!==false){
$sql="select * from zzcms_dl where passed=1 and saver='".$username."' and id in (". $id .") order by id desc";
}else{
$sql="select * from zzcms_dl where passed=1 and saver='".$username."' and id='$id' ";
}	
$rs=mysql_query($sql);
$table="<table width=100% cellspacing=0 cellpadding=0 border=1>";
$table=$table."<tr>";
$table=$table."<td align=center  bgcolor=#dddddd><b>电话</b></td>";
$table=$table."<td align=center  bgcolor=#dddddd><b>代理产品</b></td>";
$table=$table."<td align=center  bgcolor=#dddddd><b>代理人</b></td>";
$table=$table."<td align=center  bgcolor=#dddddd><b>代理介绍</b></td>";
$table=$table."<td align=center  bgcolor=#dddddd><b>发布时间</b></td>";
$table=$table."</tr>";
while ($row=mysql_fetch_array($rs)){
$table=$table."<tr>";
$table=$table."<td>".$row['tel']."</td>";
$table=$table."<td>".$row['cp']."</td>";
$table=$table."<td>".$row['dlsname']."</td>";
$table=$table."<td>".$row['content']."</td>";
$table=$table."<td>".$row['sendtime']."</td>";
$table=$table."</tr>";
}
$table=$table."</table>";
echo $table;
}
?>