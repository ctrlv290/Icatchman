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

<?
if ($level == 9){
?>

<a href="https://icatchman.com:8080/" target="mainbody"  style="text-decoration:none"><font color="white">■ LoRa Server</font></a>
<br><br>

<a href="pco_create.php" target="mainbody"  style="text-decoration:none"><font color="#C1FAFE">■ 사용자 등록하기</font></a>
<br><br>

<a href="pco_list.php" target="mainbody"  style="text-decoration:none"><font color="#C1FAFE">■ 사용자 목록보기</font></a>
<br><br>

<a href="site_list.php" target="mainbody"  style="text-decoration:none"><font color="#C1FAFE">■ 사이트 전체보기</font></a>
<br><br>

<!--
<a href="chargeip_list.php" target="mainbody"  style="text-decoration:none"><font color="#C1FAFE">■ 담당자 등록/목록</font></a>
<br><br>
-->

<a href="node_manage.php?pco_num=-1" target="mainbody"  style="text-decoration:none"><font color="#C1FAFE">■ 노드 관리(전체)</font></a>
<br><br>

<font color="#3D9ACF">------------------------</font>
<br>
<br>
<?
}
?>


<?
if($level > 2){
?>
<a href="node_create.php" target="mainbody"  style="text-decoration:none"><font color="#FFEC00">■ 장비(노드)등록하기</font></a>
<br><br>

<a href="node_batch_reg.php" target="mainbody"  style="text-decoration:none"><font color="#FFEC00">■ 장비 일괄 등록하기</font></a>
<br><br>

<a href="node_manage.php?pco_num=0" target="mainbody"  style="text-decoration:none"><font color="#FFEC00">■ 노드 사이트적용</font></a>
<br><br>

<a href="site_create.php" target="mainbody"  style="text-decoration:none"><font color="#FFEC00">■ 사이트 등록하기</font></a>
<br><br>

<a href="client_create.php" target="mainbody"  style="text-decoration:none"><font color="#FFEC00">■ 고객 등록하기</font></a>
<br><br>

<a href="client_list.php" target="mainbody"  style="text-decoration:none"><font color="#FFEC00">■ 고객 관리하기</font></a>
<br><br>


<font color="#3D9ACF">------------------------</font>
<br><br>
<?
}
?>

<?
if($level >= 3){
?>
<a href="node_check.php?pco_num=-1" target="mainbody"  style="text-decoration:none"><font color="#FFEC00">■ 노드 상황 점검</font></a>
<br><br>
<?
}
?>

<a href="site_list.php" target="mainbody"  style="text-decoration:none"><font color=white>■ 사이트 리스트</font></a>
<br>
<br>
<table>
<?
if($level == 0){
	$sqlUser = " select * from site_list where useridx = '". $refidx . "' ";
}else if($level > 0 && $level <= 3){
	$sqlUser = " select * from site_list where useridx = '". $useridx . "' or  chargeidx = '". $useridx . "'  or  mididx = '". $useridx . "' ";
}else if($level == 9){
	$sqlUser = " select * from site_list ";
}
$rs_list 	= query( $sqlUser ); 
while( $rw_list =  $rs_list ->fetch_array() ) {
	$pco_num = $rw_list[siteidx];
	$sitename = $rw_list[sitename];
	
	?>
	<tr>
	<td width=10>&nbsp;</td>
	<td height=30 align="left">
		<a href="site_frame.php?sitename=<?echo $sitename;?>&pco_num=<?echo $pco_num;?>" target="mainbody" style="text-decoration:none"><font color=white>► <?echo $sitename;?></font></a><br>
		
		<br>
	</td>
	</tr>
	<?
}	
?>
</table>

<font color="#3D9ACF">------------------------</font>
<br>

</body>
</html>



  		
  		
  		
  		
  		
  		
