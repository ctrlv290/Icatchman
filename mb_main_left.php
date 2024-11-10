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
<center>

<table width="100%">
<tr><td>

<?
if ($level == 9){
?>

<a href="https://icatchman.com:8080/"   style="text-decoration:none"><font color="white">■ LoRa Server</font></a>
<br><br>

<a href="pco_create.php"   style="text-decoration:none"><font color="#C1FAFE">■ 사용자 등록하기</font></a>
<br><br>

<a href="pco_list.php"   style="text-decoration:none"><font color="#C1FAFE">■ 사용자 목록보기</font></a>
<br><br>

<a href="site_list.php"   style="text-decoration:none"><font color="#C1FAFE">■ 사이트 전체보기</font></a>
<br><br>

<!--
<a href="chargeip_list.php"   style="text-decoration:none"><font color="#C1FAFE">■ 담당자 등록/목록</font></a>
<br><br>
-->

<a href="node_manage.php?pco_num=-1"   style="text-decoration:none"><font color="#C1FAFE">■ 노드 관리(전체)</font></a>
<br><br>

<font color="#3D9ACF">--------------------------</font>
<br>
<br>
<?
}
?>


<?
if($level > 2){
?>
<a href="node_create.php"   style="text-decoration:none"><font color="#FFEC00">■ 노드 등록하기</font></a>
<br><br>

<a href="node_manage.php?pco_num=0"   style="text-decoration:none"><font color="#FFEC00">■ 노드 사이트적용</font></a>
<br><br>

<a href="site_create.php"   style="text-decoration:none"><font color="#FFEC00">■ 사이트 등록하기</font></a>
<br><br>

<a href="client_create.php"   style="text-decoration:none"><font color="#FFEC00">■ 고객 등록하기</font></a>
<br><br>

<a href="client_list.php"   style="text-decoration:none"><font color="#FFEC00">■ 고객 관리하기</font></a>
<br><br>

<font color="#3D9ACF">--------------------------</font>
<br><br>
<?
}
?>

<a href="site_list.php"   style="text-decoration:none"><font color=white>■ 사이트 리스트</font></a>
<br>

<table width="100%">
<?
if($level == 0){
	$sqlUser = " select * from site_list where useridx = '". $refidx . "' ";
}else if($level > 0 && $level <= 3){
	$sqlUser = " select * from site_list where useridx = '". $useridx . "' ";
}else if($level == 9){
	$sqlUser = " select * from site_list ";
}
$rs_list 	= query( $sqlUser ); 
while( $rw_list =  $rs_list ->fetch_array() ) {
	$pco_num = $rw_list[siteidx];
	$sitename = $rw_list[sitename];
	
	?>
	<tr>
	<td width="10">&nbsp;</td>
	<td height=30><center>
		<table  width="100%">
		<tr><td>
		<font color=white>► <?echo $sitename;?></font><br>
		</td></tr>
		</table>
		
		<table  width="100%">
		<tr><td width=15>&nbsp;</td>
		    <td><a href="node_list.php?pco_num=<?echo $pco_num;?>&sitename=<?echo $sitename;?>"  style="text-decoration:none"><span style="color:white;font-size:11pt;">- 리스트 보기</span></a></td>
		</tr>
		<tr><td width=15>&nbsp;</td>
		    <td><a href="mapview.php?pco_num=<?echo $pco_num;?>&sitename=<?echo $sitename;?>"  style="text-decoration:none"><span style="color:white;font-size:11pt;">- 지도 보기</span></a></td>
		</tr>
		
		<?
		if($level == 9){
		?>
		<tr><td width=15>&nbsp;</td>
		    <td><a href="maintain_list.php?pco_num=<?echo $pco_num;?>&sitename=<?echo $sitename;?>" style="text-decoration:none"><span style="color:white;font-size:11pt;">- 유지 보수</span></a></td>
		</tr>
		<?
		}
		?>
		
		<?
		if($level > 2){
		?>
		<tr><td width=15>&nbsp;</td>
		    <td><a href="node_manage.php?pco_num=<?echo $pco_num;?>"   style="text-decoration:none"><span style="color:#FFEC00;font-size:11pt;">- 노드 관리</span></a></td>
		</tr>
		<?
		}
		?>
		</table>
		<br>
	</td>
	</tr>
	<?
}	
?>
</table>

<font color="#3D9ACF">--------------------------</font>
<br>




</td></tr>
</table>





</body>
</html>



  		
  		
  		
  		
  		
  		
