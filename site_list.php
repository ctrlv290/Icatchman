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

?>
<html>
<head>
<title>ZAPSRMS</title>
</head>
<body bgcolor="#ffffff"  topmargin="0">
  
<Table width=100%>
<tr  background="webimg/table_top_blue.jpg">
	<td height=30 colspan=12><center><font color="white">사이트 목록</font></td>
</tr>

<tr  background="webimg/table_top_back.jpg">
	<td height=30 width="5%"><center>#</td>
	<td width="5%"><center></td>
	<td width="15%"><center>사이트 이름</td>
	<td width="8%"><center>등록 일자</td>
	<td width="4%"><center>책임관리자</td>
	<td width="4%"><center>관리자</td>
	<td width="4%"><center>담당자</td>
	<td width="10%"><center>담당자 연락처</td>
	<td width="10%"><center>고객 이름</td>
	<td width="10%"><center>고객 연락처</td>
	<td width="10%"><center>고객 이메일</td>
	<td width="15%"><center>고객 주소</td>
</tr>
<?
/*
if($level == 9){
	$sqlUser = " select * from site_list order by siteidx asc ";
}else{
	$sqlUser = " select * from site_list where useridx = '". $useridx . "' ";
}
*/

$sqlUser = " select * from site_list order by siteidx asc ";
$rs_list 	= query( $sqlUser ); 
$cnt = 1;
while( $rw_list =  $rs_list ->fetch_array() ) {
	$pco_num = $rw_list[siteidx];
	$siteidx = $rw_list[siteidx];
	$t_useridx = $rw_list[useridx];
	$username = $rw_list[username];	
	$mididx = $rw_list[mididx];
	$midname = $rw_list[midname];
	$sitename = $rw_list[sitename];
	$descript = $rw_list[descript];
	$regday = $rw_list[regday];
	$chargeip = $rw_list[chargeip];	
	$chargephone = $rw_list[chargephone];	
	$clientname = $rw_list[clientname];
	$clientphone = $rw_list[clientphone];
	$clientemail = $rw_list[clientemail];
	$clientaddr = $rw_list[clientaddr];
	$lon = $rw_list[lon];
	$lat = $rw_list[lat];
	$restcnt = $cnt % 2;
	if($restcnt == 0){
		$bgcolor = "#f8f8f8";
	}else{
		$bgcolor = "#ffffff";
	}

	?>
	<tr bgcolor='<?echo $bgcolor;?>'>
	<td height=30><center><?echo $cnt;?></td>
	<td><center><a href="site_modify.php?site_idx=<?echo $siteidx;?>"><img src="webimg/icon_modify.png" border=0 width="18" height="18"></a>&nbsp;<a href="site_frame.php?sitename=<?echo $sitename;?>&pco_num=<?echo $siteidx;?>"><img src="webimg/icon_project.png" border=0 width="18" height="18"></a></td>
	<td><center><?echo $sitename;?></td>
	<td><center><?echo $regday;?></td>
	<td><center><?echo $username;?></td>
	<td><center><?echo $midname;?></td>
	<td><center><?echo $chargeip;?></td>
	<td><center><?echo $chargephone;?></td>
	<td><center><?echo $clientname;?></td>
	<td><center><?echo $clientphone;?></td>
	<td><center><?echo $clientemail;?></td>
	<td><center><?echo $clientaddr;?></td>
	</tr>
	<?
	$cnt = $cnt + 1;
}	
?>
</Table>







</body>
</html>
  		
  		
  		
  		
  		
  		
