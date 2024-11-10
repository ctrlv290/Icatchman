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

$get_pconum = $_GET["pco_num"]; //시리얼번호

$today = date("Y-m-d");
$aryDay = explode ("-", $today);
$nowY = $aryDay[0] * 1;
$nowM = $aryDay[1] * 1;
$nowD = $aryDay[2] * 1;
$nowtoday = $nowY ."-". $nowM ."-".$nowD;

?>




<html>
<head>
<title>ZAPSRMS</title>
</head>
<body bgcolor="#ffffff"  topmargin="0">
<form name="form1">

<Table width=100%>
<tr  background="webimg/table_top_blue.jpg">
	<td height=30 colspan=14><center><font color="white">노드 점검 [<?echo $nowtoday;?>]</font></td>
</tr>
<tr>
	<td height=30 colspan=14 align="right">
		<a href="excel_node_check.php?pco_num=<?echo $get_pconum;?>" style="text-decoration:none"><img src="webimg/excel_icon.jpg" border=0 width="100" height="25"></a>
	</td>
</tr>
<!--
<tr>
	<td align="left" colspan=8>
	<select name="pco_num" style="height:25pt; width:300px;">
		<option value="0">없음</option>
	<?
	if($level == 9){
		$sqlUser = " select * from site_list ";
	}else{
		$sqlUser = " select * from site_list where useridx = '". $useridx . "' ";
	}
	$rs_list 	= query( $sqlUser ); 
	while( $rw_list =  $rs_list ->fetch_array() ) {
		$pco_num = $rw_list[siteidx];
		$sitename = $rw_list[sitename];
	
		?>
		<option value="<?echo $pco_num;?>"><?echo $sitename;?></option>
		<?
	}	
	?>
	</select>
	<input type="button" value="사이트적용" onclick="UpdateSite(this.form);" style="color:white; width:100pt;height:25pt;background-color:#9D00BD;font-size:15px;">
	&nbsp;
	<?
	if($level == 9){
	?>
		<input type="button" value="노드삭제하기" onclick="DeleteNode(this.form);" style="color:white; width:100pt;height:25pt;background-color:#CA1F00;font-size:15px;">
	<?
	}
	?>
	</td>
	
	<td align="right" colspan=7>
	<input type="button" value="노드 운용 ON" onclick="UpdateUseOn(this.form);" style="color:white; width:100pt;height:25pt;background-color:#0078B8;font-size:15px;">
	<input type="button" value="노드 운용 OFF" onclick="UpdateUseOff(this.form);" style="color:white; width:100pt;height:25pt;background-color:#7E7E7E;font-size:15px;">
	</td>
</tr>
-->


<tr  background="webimg/table_top_back.jpg">
	<td width="10%"><center>최종전송시간</td>
	<td width="5%"><center>보드번호</td>
	<td width="10%"><center>경과시간</td>
	<td width="5%"><center>장비번호</td>
	<td width="8%"><center>사이트명</td>
	<td width="5%"><center>온도</td>
	<td width="5%"><center>습도</td>
	<td width="5%"><center>전력값</td>
	<td width="5%"><center>릴레이</td>
	<td width="5%"><center>사용여부</td>
	<td width="8%"><center>구동시작일자</td>
	<td width="8%"><center>구동종료일자</td>
	<td width="8%"><center>시작시간</td>
	<td width="8%"><center>종료시간</td>
</tr>
<?

if($get_pconum < 0 ){
	//$sqlUser = " select * from node_list order by node_id asc ";
	$sqlUser = " select * from node_list where working = '1' order by node_id asc ";
}else{
	$sqlUser = " select * from node_list where pco_num = '".$get_pconum."' AND working = '1' order by node_id asc ";
}

//$sqlUser = " select * from node_list where working = '1' order by node_id asc ";	
$rs_list 	= query( $sqlUser ); 
$cnt = 1;
$todayCheck = date("Y-m-d h:i:s");
$last_pconum = -1;
$last_bgcolor= "#EEFAFC";
while( $rw_list =  $rs_list ->fetch_array() ) {
	$node_idx = $rw_list[idx];
	$node_num = $rw_list[node_num]; //시리얼번호
	$node_id = $rw_list[node_id]; //보드번호
	$node_name = $rw_list[node_name]; //장비번호
	$pco_num = $rw_list[pco_num]; //사이트명
	$temperature = $rw_list[temperature];
	$humidity = $rw_list[humidity];
	$current = $rw_list[current];
	$relay = $rw_list[relay];
	$sentDate = $rw_list[sentDate];
	$receiveDate = $rw_list[receiveDate];
	$latitude = $rw_list[latitude];
	$longitude = $rw_list[longitude];
	$working = $rw_list[working];
	$instant_switch = $rw_list[instant_switch];
	$interval = $rw_list[interval];
	$date_on = $rw_list[date_on];
	$date_off = $rw_list[date_off];
	$time_on = $rw_list[time_on];
	$time_off = $rw_list[time_off];
	$control_at = $rw_list[control_at];
	
	$sqlPCO = " select sitename from site_list where siteidx = '". $pco_num . "' ";
	$rs_pco 	= query( $sqlPCO ); 
	while( $rw_pco =  $rs_pco ->fetch_array() ) {
		$site_name = $rw_pco[sitename];
	}

	/*
	$restcnt = $cnt % 2;
	if($restcnt == 0){
		$bgcolor = "#f8f8f8";
	}else{
		$bgcolor = "#ffffff";
	}
	*/
	
	if($pco_num == $last_pconum){
		$bgcolor = $last_bgcolor;
	}else{
		if($last_bgcolor == "#EEFAFC"){
			$last_bgcolor = "#ffffff";
		}else{
			$last_bgcolor = "#EEFAFC";
		}
		$bgcolor = $last_bgcolor;
	}
	$last_pconum = $pco_num;
	
	if($working == 0){
		$pwr_img = "webimg/power_off.jpg";
	}else{
		$pwr_img = "webimg/power_on.jpg";
	}

	if($relay == 0){
		$relay_text = "<font color=red>OFF</font>";
	}else{
		$relay_text = "<font color=blue>ON</font>";
	}
	
 

	$start = strtotime($sentDate);
	$end = strtotime($todayCheck);
	$count = $end - $start; // 종료일 - 시작일
	$GapDay = intval($count/86400); //day
	$GapTime = intval(($count % 86400) / 3600); // time
	
	
 
	if(($GapDay >0 && $GapTime > 0) || ($current < 230)){
		if($GapDay >0 && $GapTime > 0){
			$bgcolor = "#FCE2E2";
		}else{
			$bgcolor = "#FAE361";
		}
	?>
	<tr bgcolor='<?echo $bgcolor;?>'>
	<td height="30"><center><?echo $sentDate;?></td> <!--최종전송시간 -->
	<td><center><a href="node_modify.php?node_idx=<?echo $node_idx;?>" style="text-decoration:none"><font color="black"><?echo $node_id;?></font></a></td> <!--보드번호 -->
	<td><center><?echo $GapDay;?>일 / <?echo $GapTime;?>시간</td> <!--최종전송시간 -->
	<td><center><a href="node_list.php?pco_num=<?echo $pco_num;?>&sitename=<?echo $site_name;?>" style="text-decoration:none"><span style="color:black;font-size:13pt;"><?echo $node_name;?></td> <!--장비번호 -->
	<td><center><?echo $site_name;?></td> <!--사이트명 -->
	<td align="right"><?echo $temperature;?></td> <!--온도 -->
	<td align="right"><?echo $humidity;?></td> <!--습도 -->
	<td align="right"><b><?echo $current;?></b></td> <!--전력값 -->
	<td><center><?echo $relay_text;?></td> <!--릴레이 -->
	<td><center><img src="<?echo $pwr_img;?>" border=0 width="15" height="15"></td> <!--사용여부 -->
	<td><center><?echo $date_on;?></td> <!--구동시작일자 -->
	<td><center><?echo $date_off;?></td> <!--구동종료일자 -->
	<td><center><?echo $time_on;?></td> <!--시작시간 -->
	<td><center><?echo $time_off;?></td> <!--종료시간 -->
	</tr>
	<?
	$cnt = $cnt + 1;
	}
	
}	
?>
</Table>
</form>


<script type="text/javascript">
<!--

function CheckAllBox(thisform)
{

	var check = thisform.checkB[0];
	if(check.checked == true){ 
		for( var i=0; i<thisform.checkB.length; i++) 
		{ 
			thisform.checkB[i].checked = false; 
		} 
	
	}else{
		for( var i=0; i<thisform.checkB.length; i++) 
		{ 
			thisform.checkB[i].checked = true; 
		} 
	}
}


function DeleteNode(thisform)
{
	var con_test = confirm("정말 삭제 하시겠습니까? \n삭제 후 복원이 불가능합니다.");
	if(con_test == false){
  		return;
	}

        //'확인' 버튼을 클릭했을 때 실행되는 메서드
    var devidx = "";
    var usevalue = "";
        
	for( var i=0; i<thisform.checkB.length; i++) 
	{ 
		var check = thisform.checkB[i]; 
		if(check.checked == true){ 
			devidx = devidx + check.value + ',';
			usevalue = usevalue + '1,';
		}
	} 
	//alert(devidx + "\n" +usevalue);
		
	var form = document.createElement("form");
	form.setAttribute("charset", "UTF-8");
	form.setAttribute("method", "Post"); // Get 또는 Post 입력
	form.setAttribute("action", "node_delete_array.php");

	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "device");
	hiddenField.setAttribute("value", devidx);
	form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "get_pconum");
	hiddenField.setAttribute("value", "<?echo $get_pconum;?>");
	form.appendChild(hiddenField);
	
	var sel_pco = thisform.pco_num.value;
	
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "sel_pconum");
	hiddenField.setAttribute("value", sel_pco);
	form.appendChild(hiddenField);
	
	document.body.appendChild(form);

	form.submit();

}

function UpdateSite(thisform)
{
        //'확인' 버튼을 클릭했을 때 실행되는 메서드
    var devidx = "";
    var usevalue = "";
        
	for( var i=0; i<thisform.checkB.length; i++) 
	{ 
		var check = thisform.checkB[i]; 
		if(check.checked == true){ 
			devidx = devidx + check.value + ',';
			usevalue = usevalue + '1,';
		}
	} 
	//alert(devidx + "\n" +usevalue);
		
	var form = document.createElement("form");
	form.setAttribute("charset", "UTF-8");
	form.setAttribute("method", "Post"); // Get 또는 Post 입력
	form.setAttribute("action", "node_update_site.php");

	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "device");
	hiddenField.setAttribute("value", devidx);
	form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "get_pconum");
	hiddenField.setAttribute("value", "<?echo $get_pconum;?>");
	form.appendChild(hiddenField);
	
	var sel_pco = thisform.pco_num.value;
	
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "sel_pconum");
	hiddenField.setAttribute("value", sel_pco);
	form.appendChild(hiddenField);
	
	document.body.appendChild(form);

	form.submit();

}

function UpdateUseOn(thisform)
{
        //'확인' 버튼을 클릭했을 때 실행되는 메서드
    var devidx = "";
        
	for( var i=0; i<thisform.checkB.length; i++) 
	{ 
		var check = thisform.checkB[i]; 
		if(check.checked == true){ 
			devidx = devidx + check.value + ',';
		}
	} 
	//alert(devidx + "\n" +usevalue);
		
	var form = document.createElement("form");
	form.setAttribute("charset", "UTF-8");
	form.setAttribute("method", "Post"); // Get 또는 Post 입력
	form.setAttribute("action", "node_update_useon.php");

	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "device");
	hiddenField.setAttribute("value", devidx);
	form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "get_pconum");
	hiddenField.setAttribute("value", "<?echo $get_pconum;?>");
	form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "onoff");
	hiddenField.setAttribute("value", "1");
	form.appendChild(hiddenField);
	
	document.body.appendChild(form);

	form.submit();

}

function UpdateUseOff(thisform)
{
    var devidx = "";
        
	for( var i=0; i<thisform.checkB.length; i++) 
	{ 
		var check = thisform.checkB[i]; 
		if(check.checked == true){ 
			devidx = devidx + check.value + ',';
		}
	} 
	//alert(devidx + "\n" +usevalue);
		
	var form = document.createElement("form");
	form.setAttribute("charset", "UTF-8");
	form.setAttribute("method", "Post"); // Get 또는 Post 입력
	form.setAttribute("action", "node_update_useon.php");

	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "device");
	hiddenField.setAttribute("value", devidx);
	form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "get_pconum");
	hiddenField.setAttribute("value", "<?echo $get_pconum;?>");
	form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "onoff");
	hiddenField.setAttribute("value", "0");
	form.appendChild(hiddenField);
	
	document.body.appendChild(form);

	form.submit();

}

</script>


</body>
</html>
  		
  		
  		
  		
  		
  		
