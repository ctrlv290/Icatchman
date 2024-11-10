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
?>
<!DOCTYPE html>
<html>
<head>


<head>
<body>
<form action="node_batch_reg_ok.php" method="POST" enctype="multipart/form-data"  name="form1">

<table width="600">
<tr background="webimg/table_top_back.jpg">
<td colspan=2 height="30"><center>장비 일괄 등록하기</td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40" align="right">사이트 이름</td>
<td>
	<select id="id_pconum" name="pco_num" style="height:25pt; width:80%;" onchange="chageSiteSelect()">
		<option value="0">없음</option>
	<?
	if($level == 9){
		$sqlUser = " select * from site_list ";
		$rs_list 	= query( $sqlUser );
	}else{
		$sqlUser = " select * from site_list where useridx = '". $useridx . "' ";
		$rs_list 	= query( $sqlUser );
	}
	//$sqlUser = " select * from site_list where useridx = '". $useridx . "' ";
	//$rs_list 	= query( $sqlUser ); 
	
	$arry_pconum = array();
	$arry_lon = array();
	$arry_lat = array();
	
	$arry_pconum[0] = 0;
	$arry_lon[0] = 0;
	$arry_lat[0] = 0;

	$arryCnt = 1;
	while( $rw_list =  $rs_list ->fetch_array() ) {
		$pco_num = $rw_list[siteidx];
		$sitename = $rw_list[sitename];
	
		$site_addr = $rw_list[clientaddr];
		$site_lon = $rw_list[lon];
		$site_lat = $rw_list[lat];
		
		$arry_pconum[$arryCnt] = $pco_num;
		$arry_lon[$arryCnt] = $site_lon;
		$arry_lat[$arryCnt] = $site_lat;

		$arryCnt = $arryCnt + 1;

		?>
		<option value="<?echo $pco_num;?>"><?echo $sitename;?> (<?echo $site_addr;?>)</option>
		<?
	}	
	?>
	</select>
</td>
</tr>


<tr bgcolor = "#ffffff">
<td height="40" align="right">GPS</td>

<td>
	<input type="text" name="lat" id="lat" readonly style="width:200px; height:25px;">
	<input type="text" name="lon" id="lon" readonly style="width:200px; height:25px;">
</td>
</tr>


<tr bgcolor = "#f8f8f8">
<td height="40" align="right">로라 채널</td>

<td>
	<select name="channel" style="height:25pt; width:80%;">
		<option value="1">채널1 (사용중)</option>
		<option value="2">채널2 (대기중)</option>
		<option value="3">채널3 (대기중)</option>
		<option value="4">채널4 (대기중)</option>
		<option value="5">채널5 (대기중)</option>
		<option value="6">채널6 (대기중)</option>
		<option value="7">채널7 (대기중)</option>
		<option value="8">채널8 (대기중)</option>
		<option value="9">채널9 (대기중)</option>
	</select>
</td>
</tr>



<tr bgcolor = "#ffffff">
<td height="40" align="right">파일선택(cvs)</td>

<td>
	<input type="file" name="upfile" id="upfile" style="width:300px; height:25px;">
</td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40" align="right"></td>

<td><a href="device_up_sample.csv" style="text-decoration:none; color:black;">샘플파일 다운로드</a>
</td>
</tr>

<tr>
<td colspan="2" height="40" valign=middle><center><input type="submit" name="submit" value=" 등록하기 " style="font-size:12pt; color:white; width:200pt; height:25pt; background-color:#0078B8;"></td>
</tr>

</table>
</form>


<script>
var jsonPcoNum = eval('<?=json_encode($arry_pconum)?>');
var jsonLon = eval('<?=json_encode($arry_lon)?>');
var jsonLat = eval('<?=json_encode($arry_lat)?>');


function chageSiteSelect(){
	var numSelect = document.getElementById("id_pconum");
	var idx = numSelect.selectedIndex;
	//alert("[selectedIndex:" +idx + "]" + jsonPcoNum[idx] + " / " + jsonLat[idx] + " / " + jsonLon[idx]);
	
	document.getElementById("lat").value = jsonLat[idx];
	document.getElementById("lon").value = jsonLon[idx];
		
}
</script>


</body>
</html>
  		
  		
  		
  		
  		
  		
