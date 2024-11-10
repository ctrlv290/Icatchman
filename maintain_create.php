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


$nodeidx = $_GET["nodeidx"];

$sqlUser = " select * from node_list where idx = '".$nodeidx."' ";
$rs_list 	= query( $sqlUser ); 
$cnt = 1;
while( $rw_list =  $rs_list ->fetch_array() ) {
	$node_idx = $rw_list[idx];
	$node_num = $rw_list[node_num]; //시리얼번호
	$node_id = $rw_list[node_id]; //보드번호
	$node_name = $rw_list[node_name]; //장비번호
	$pco_num = $rw_list[pco_num]; //사이트명
	
	$sqlPCO = " select sitename from site_list where siteidx = '". $pco_num . "' ";
	$rs_pco 	= query( $sqlPCO ); 
	while( $rw_pco =  $rs_pco ->fetch_array() ) {
		$site_name = $rw_pco[sitename];
		$siteidx = $rw_pco[siteidx];
	}
}


?>
<!DOCTYPE html>
<html>
<head>

    
<head>
<body>
<form action="maintain_create_recv.php" method="POST" enctype="multipart/form-data"  name="form1">

<input type="hidden" name="useridx" value="<?echo $useridx;?>">
<input type="hidden" name="nodeidx" value="<?echo $nodeidx;?>">
<input type="hidden" name="node_id" value="<?echo $node_id;?>">
<input type="hidden" name="node_name" value="<?echo $node_name;?>">
<input type="hidden" name="site_name" value="<?echo $site_name;?>">
<input type="hidden" name="site_idx" value="<?echo $pco_num;?>">

<table>
<tr background="webimg/table_top_back.jpg">
<td colspan=2 height="30"><center>유지보수 등록하기</td>
</tr>

<tr bgcolor = "#ffffff">
<td colspan="2" height="40" valign=middle><center><b>보드번호[<?echo $node_id;?>] / 장비명[<?echo $node_name;?>] / 사이트명[<?echo $site_name;?>]</td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40" width="100"><center>담당 관리자</td>
<td><?echo $username;?></td>
</tr>


<tr bgcolor = "#ffffff">
<td height="40"><center>사출물</td>
<td>
	<table>
	<tr><td height="40"><center><input type="checkbox" name="cap_top" value="1" style="width:30pt;height30pt;"></td><td>상캡</td></tr>
	<tr><td height="40"><center><input type="checkbox" name="cap_round" value="1" style="width:30pt;height30px;"></td><td>원형캡</td></tr>
	<tr><td height="40"><center><input type="checkbox" name="cap_bottom" value="1" style="width:30pt;height30px;"></td><td>하커버</td></tr>
	</table>
</td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40"><center>상부 모듈</td>
<td>
	<table>
	<tr><td height="40"><center><input type="checkbox" name="motor_top" value="1" style="width:30pt;height30pt;"></td><td>상부팬모터</td></tr>
	<tr><td height="40"><center><input type="checkbox" name="motor_sinc" value="1" style="width:30pt;height30pt;"></td><td>동기모터</td></tr>
	<tr><td height="40"><center><input type="checkbox" name="motor_spider" value="1" style="width:30pt;height30pt;"></td><td>거미줄제거기</td></tr>
	</table>
</td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40"><center>하부 모듈</td>
<td>
	<table>
	<tr><td height="40"><center><input type="checkbox" name="round_pan" value="1" style="width:30pt;height30pt;"></td><td>원형철판</td></tr>
	<tr><td height="40"><center><input type="checkbox" name="motor_bottom" value="1" style="width:30pt;height30pt;"></td><td>모터</td></tr>
	<tr><td height="40"><center><input type="checkbox" name="plasticfan" value="1" style="width:30pt;height30pt;"></td><td>플라스틱휀</td></tr>
	<tr><td height="40"><center><input type="checkbox" name="reducer" value="1" style="width:30pt;height30pt;"></td><td>레두샤(리듀서)</td></tr>
	</table>
</td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40"><center>기타 부품</td>
<td>
	<table>
	<tr><td height="40"><center><input type="checkbox" name="cutting" value="1" style="width:30pt;height30pt;"></td><td>커팅날</td></tr>
	<tr><td height="40"><center><input type="checkbox" name="breaker" value="1" style="width:30pt;height30pt;"></td><td>누전차단기</td></tr>
	<tr><td height="40"><center><input type="checkbox" name="lamp_normal" value="1" style="width:30pt;height30pt;"></td><td>일반램프</td></tr>
	<tr><td height="40"><center><input type="checkbox" name="lamp_led" value="1" style="width:30pt;height30pt;"></td><td>LED램프</td></tr>
	<tr><td height="40"><center><input type="checkbox" name="lamp_uv" value="1" style="width:30pt;height30pt;"></td><td>UVLED램프</td></tr>
	</table>
</td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40"><center>점검</td>
<td>
	<table>
	<tr><td height="40"><center><input type="checkbox" name="as_normal" value="1" style="width:30pt;height30pt;"></td><td>정기 점검</td></tr>
	<tr><td height="40"><center><input type="checkbox" name="as_etc" value="1" style="width:30pt;height30pt;"></td><td>기타 점검</td></tr>
	</table>
</td>
</tr>




<tr bgcolor = "#f8f8f8">
<td height="40"><center>처리일자</td>
<td>
<select name="nyear" style="height:25pt;">
<? 
$today = date("Y-m-d");
$aryDay = explode ("-", $today);
$nowY = $aryDay[0];
$nowM = $aryDay[1];
$nowD = $aryDay[2];


for($i = 2018; $i<2030; $i++){ 
	if($i == $nowY){
	?><option value="<?echo $i;?>"  selected="selected"><?echo $i;?></option><?
	}else{
	?><option value="<?echo $i;?>"><?echo $i;?></option><?
	}
}  
?>
</select>년 &nbsp;

<select name="nmonth" style="height:25pt;">
<? 
for($i = 1; $i<12; $i++){ 
	if($i == $nowM){
	?><option value="<?echo $i;?>"  selected="selected"><?echo $i;?></option><?
	}else{
	?><option value="<?echo $i;?>"><?echo $i;?></option><?
	}
}  
?>
</select>월 &nbsp;

<select name="nday" style="height:25pt;">
<? 
for($i = 1; $i<31; $i++){ 
	if($i == $nowD){
	?><option value="<?echo $i;?>"  selected="selected"><?echo $i;?></option><?
	}else{
	?><option value="<?echo $i;?>"><?echo $i;?></option><?
	} 
}  
?>
</select>일 &nbsp;

</td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40"><center>기타사항</td>
<td><textarea name="content" cols="100%" rows="8" ></textarea></td>
</tr>


<tr bgcolor = "#f8f8f8">
<td height="40">사진1</td>
<td><input type="file" name="fileToUpload1" id="fileToUpload1"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40">사진2</td>
<td><input type="file" name="fileToUpload2" id="fileToUpload2"></td>
</tr>


<tr>
<td colspan="2" height="40" valign=middle><center><input type="submit" name="submit" value=" 등록하기 " style="font-size:12pt; color:white; width:200pt; height:25pt; background-color:#0078B8;"></td>
</tr>

</table>
</form>



</body>
</html>
  		
  		
  		
  		
  		
  		
