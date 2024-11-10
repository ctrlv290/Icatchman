<?
include ("dbcon_pharmcle.php");

session_start();
if(!isset($_SESSION['useridx']) || !isset($_SESSION['userid'])) {
	echo "<meta http-equiv='refresh' content='0;url=login.php'>";
	exit;
}

$useridx = $_SESSION['useridx'];
$userid = $_SESSION['userid'];
$level = $_SESSION['level'];
$username = $_SESSION['username'];
$refidx = $_SESSION['refidx'];

if($level < 9){
	echo "<script>alert('관리 권한이 없습니다.');history.back();</script>"; //"<meta http-equiv='refresh' content='0;url=login.php'>";
	exit;
}

?>
<html>
<head>
<title>ZAPSRMS</title>
</head>
<body bgcolor="#ffffff"  topmargin="0">
<form action="chargeip_create_recv.php" method="POST" enctype="multipart/form-data"  name="form1">
<Table width=100%>
<tr  background="webimg/table_top_blue.jpg">
	<td height=30 colspan=4><center><font color="white">담당자 등록하기</font></td>
</tr>
<tr  background="webimg/table_top_back.jpg">
	<td height=30  width="25%"><center>담당자 이름</td>
	<td width="25%"><center>담당자 연락처</td>
	<td width="25%"><center>담당자 이메일</td>
	<td width="25%"><center>기타</td>
</tr>
<tr>
	<td height=30  width="25%"><center><input type="text" name="name" value="" style="height:20pt; width:100%;"></td>
	<td width="25%"><center><input type="text" name="phone" value="" style="height:20pt; width:100%;"></td>
	<td width="25%"><center><input type="text" name="email" value="" style="height:20pt; width:100%;"></td>
	<td width="25%"><center><input type="text" name="descript" value="" style="height:20pt; width:100%;"></td>
</tr>
<tr>
	<td height=30 colspan=4><center><input type="submit" name="submit" value=" 등록하기 " style="font-size:12pt; color:white; width:200pt; height:25pt; background-color:#0078B8;"></td>
</tr>
</table>
</form>



<br>
<Table width=100%>
<tr  background="webimg/table_top_blue.jpg">
	<td height=30 colspan=5><center><font color="white">담당자 목록</font></td>
</tr>
<tr  background="webimg/table_top_back.jpg">
	<td height=30 width="8%"><center>#</td>
	<td width="23%"><center>담당자 이름</td>
	<td width="23%"><center>담당자 연락처</td>
	<td width="23%"><center>담당자 이메일</td>
	<td width="23%"><center>기타</td>
</tr>
<?
$sqlUser = " select * from chargeinfo order by chargeidx asc ";
$rs_list 	= query( $sqlUser ); 
$cnt = 1;
while( $rw_list =  $rs_list ->fetch_array() ) {
	$chargeidx = $rw_list[chargeidx];
	$regday = $rw_list[regday];
	$name = $rw_list[name];	
	$phone = $rw_list[phone];
	$email = $rw_list[email];
	$descript = $rw_list[descript];
	$restcnt = $cnt % 2;
	if($restcnt == 0){
		$bgcolor = "#f8f8f8";
	}else{
		$bgcolor = "#ffffff";
	}

	?>
	<tr bgcolor='<?echo $bgcolor;?>'>
	<td height=30><center><?echo $cnt;?></td>
	<td><center><?echo $name;?></td>
	<td><center><?echo $phone;?></td>
	<td><center><?echo $email;?></td>
	<td><center><?echo $descript;?></td>
	</tr>
	<?
	$cnt = $cnt + 1;
}	
?>
</Table>







</body>
</html>
  		
  		
  		
  		
  		
  		
