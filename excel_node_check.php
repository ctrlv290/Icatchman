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
$file_name ="노드점검_".$today;
?>

<?
header( "Content-type: application/vnd.ms-excel" ); 
header( "Content-type: application/vnd.ms-excel; charset=utf-8");
header( "Content-Disposition: attachment; filename = ".$file_name.".xls" ); 
header( "Content-Description: PHP4 Generated Data" );
?>

<?
// 테이블 상단 만들기
$EXCEL_STR = "
<table border='1'>
<tr>
   <td>최종전송시간</td>
	<td>보드번호</td>
	<td>경과시간</td>
	<td>장비번호</td>
	<td>사이트명</td>
	<td>온도</td>
	<td>습도</td>
	<td>전력값</td>
	<td>릴레이</td>
	<td>사용여부</td>
	<td>구동시작일자</td>
	<td>구동종료일자</td>
	<td>시작시간</td>
	<td>종료시간</td>
</tr>";
//위에 talbe은 자신이 가져올 값들의 컬럼 명이 되겠다.



if($get_pconum < 0 ){
	//$sqlUser = " select * from node_list order by node_id asc ";
	$sqlUser = " select * from node_list where working = '1' order by node_id asc ";
}else{
	$sqlUser = " select * from node_list where pco_num = '".$get_pconum."' AND working = '1' order by node_id asc ";
}
$rs_list 	= query( $sqlUser ); 

$todayCheck = date("Y-m-d h:i:s");
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

	if($relay == 0){
		$relay_text = "OFF";
	}else{
		$relay_text = "ON";
	}
	
 

	$start = strtotime($sentDate);
	$end = strtotime($todayCheck);
	$count = $end - $start; // 종료일 - 시작일
	$GapDay = intval($count/86400); //day
	$GapTime = intval(($count % 86400) / 3600); // time
	
	
 	
	if(($GapDay >0 && $GapTime > 0) || ($current < 230)){
	 	$EXCEL_STR .= "
	 	<tr>
   		<td>".$sentDate."</td>
   		<td>".$node_id."</td>
   		<td>".$GapDay."일/".$GapTime."시간</td>
   		<td>".$node_name."</td>
   		<td>".$site_name."</td>
   		<td>".$temperature."</td>
   		<td>".$humidity."</td>
   		<td>".$current."</td>
   		<td>".$relay_text."</td>
   		<td>".$working."</td>
   		<td>".$date_on."</td>
   		<td>".$date_off."</td>
   		<td>".$time_on."</td>
   		<td>".$time_off."</td>
    	</tr>
   		";
	}
	
}


$EXCEL_STR .= "</table>";


echo "<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'> ";
echo $EXCEL_STR;
?>

  		
  		
  		
  		
  		
  		
