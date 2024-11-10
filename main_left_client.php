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
<body bgcolor="#454f54"  topmargin="30">

<font color=white>■ 사이트 리스트</font></a>
<br>

<table>
<?

$sqlClient = " select * from client_list where client_id = '". $useridx . "' ";
$rs_cs_list 	= query( $sqlClient );
while( $rw_cs_list =  $rs_cs_list ->fetch_array() ) {
	$ref_useridx = $rw_cs_list[ref_useridx];
	$client_id = $rw_cs_list[client_id];
	$client_name = $rw_cs_list[client_name];
	$site_idx = $rw_cs_list[site_idx];
	$site_name = $rw_cs_list[site_name];


	$sqlUser = " select * from site_list where siteidx = '". $site_idx . "' ";
	$rs_list 	= query( $sqlUser );
	while( $rw_list =  $rs_list ->fetch_array() ) {
		$pco_num = $rw_list[siteidx];
		$sitename = $rw_list[sitename];

		?>
		<tr>
		<td width=10>&nbsp;</td>
		<td height=30><center>
			<font color=white>► <?echo $sitename;?></font><br>
			<table>
			<tr><td width=15>&nbsp;</td>
		    	<td><a href="node_list.php?pco_num=<?echo $pco_num;?>&sitename=<?echo $sitename;?>" target="mainbody" style="text-decoration:none"><span style="color:white;font-size:11pt;">- 리스트 보기</span></a></td>
			</tr>
			<tr><td width=15>&nbsp;</td>
		    	<td><a href="https://www.icatchman.com:3000/map/?pco_num=<?echo $pco_num;?>&sitename=<?echo $sitename;?>" target="mainbody" style="text-decoration:none"><span style="color:white;font-size:11pt;">- 지도 보기</span></a></td>
			</tr>
			<tr><td width=15>&nbsp;</td>
		    	<td><a href="maintain_list.php?pco_num=<?echo $pco_num;?>&sitename=<?echo $sitename;?>" target="mainbody" style="text-decoration:none"><span style="color:white;font-size:12pt;">- 유지 보수</span></a></td>
			</tr>
			</table>
			<br>
		</td>
		</tr>
		<?
	}
}
?>
</table>

<font color="#3D9ACF">--------------------------</font>
<br>

</body>
</html>
