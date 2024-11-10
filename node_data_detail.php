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

$device_id = $_GET["deveui"];
$node_name = $_GET["node_name"];
$endDate = $_GET["enddate"];

?>
<!DOCTYPE html>

<html>
<head>
<title>ZAPSRMS</title>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body bgcolor="#ffffff"  topmargin="0">
<form name="form1">

<Table width=100%>
<tr  background="webimg/table_top_blue.jpg">
	<td height=30 colspan=6><center><font color="white"><?echo $node_name;?> 데이터 보기</font></td>
</tr>


<!--
id
devEUI
nodeName
applicationID
applicationName
gwName
rssi
loraSNR
frequency
fCnt
fPort
temperature
humidity
currents
relay
sentDate
receiveDate
-->

<?
$aryDay = array();
$aryTemp = array();
$aryHumi = array();
$aryCurrent = array();
$aryRelay = array();

//$endDate = date("Y-m-d h:i:s");
$startDate = date("Y-m-d", strtotime($endDate." -1 month"));
//echo $startDate . "~" . $endDate . "<br>";

$sqlUser = " select * from node_receivelog where devEUI = '".$device_id."' AND sentDate >= '".$startDate."' AND sentDate <= '".$endDate."'  order by sentDate asc ";
$rs_list 	= query( $sqlUser ); 

$aryDay[0] = "";
$aryTemp[0] = 0;
$aryHumi[0] = 0;
$aryCurrent[0] = 0;
$aryRelay[0] = 0;
	
$cnt = 1;
while( $rw_list =  $rs_list ->fetch_array() ) {
	$idx = $rw_list[idx];
	$devEUI = $rw_list[devEUI];
	$temperature = $rw_list[temperature];
	$humidity = $rw_list[humidity];
	$currents = $rw_list[currents];
	$relay = $rw_list[relay];
	$sentDate = $rw_list[sentDate];
	$receiveDate = $rw_list[receiveDate];
	
	$splitDay = explode (" ", $sentDate);
	
	$aryDay[$cnt] = $splitDay[0]; //$sentDate;
	$aryTemp[$cnt] = $temperature;
	$aryHumi[$cnt] = $humidity;
	$aryCurrent[$cnt] = $currents;
	$aryRelay[$cnt] = $relay * 100;
	
	$cnt = $cnt + 1;
	
}	

for($i = 0; $i < $cnt; $i++){ 
	
	if($i < $cnt){
		$txtChart_Temp = $txtChart_Temp . "['" . $aryDay[$i] . "', " . $aryTemp[$i] .  ", " . $aryHumi[$i] . "], ";
		$txtChart_Humi = $txtChart_Humi . "['" . $aryDay[$i] . "', " . $aryHumi[$i] . "], ";
		$txtChart_Curr = $txtChart_Curr . "['" . $aryDay[$i] . "', " . $aryCurrent[$i] .  ", " . $aryRelay[$i] . "], ";
		$txtChart_Relay = $txtChart_Relay . "['" . $aryDay[$i] . "', " . $aryRelay[$i] . "], ";
	}else{
		$txtChart_Temp = $txtChart_Temp . "['" . $aryDay[$i] . "', " . $aryTemp[$i] .  ", " . $aryHumi[$i] . "] ";
		$txtChart_Humi = $txtChart_Humi . "['" . $aryDay[$i] . "', " . $aryHumi[$i] . "] ";
		$txtChart_Curr = $txtChart_Curr . "['" . $aryDay[$i] . "', " . $aryCurrent[$i] .  ", " . $aryRelay[$i] . "] ";
		$txtChart_Relay = $txtChart_Relay . "['" . $aryDay[$i] . "', " . $aryRelay[$i] . "] ";
	}
}
$title_temp = "온도/습도 [" . $startDate . " ~ " . $endDate . "]";
$title_current = "전력량/스위치 [" . $startDate . " ~ " . $endDate . "]";
?>
</Table>
</form>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawVisualization);

    function drawVisualization() {
        
        var data = google.visualization.arrayToDataTable([
         ['일자', '온도','습도'], <?echo $txtChart_Temp;?>
      	]);

		var options = {
      		title : '<?echo $title_temp;?>',
      		vAxis: {title: '온도'},
      		hAxis: {title: '일자',textStyle: { fontSize: 10 }},
      		seriesType: 'bars',
      		series: {0: {type: 'line'},1: {type: 'line'}}
    	};
    	
    	var chart = new google.visualization.ComboChart(document.getElementById('chart_Temp'));
    	chart.draw(data, options);
    	
    	
    	
    	var data2 = google.visualization.arrayToDataTable([
         ['일자', '전력량','스위치'], <?echo $txtChart_Curr;?>
      	]);

		var options2 = {
      		title : '<?echo $title_current;?>',
      		vAxis: {title: '전력량'},
      		hAxis: {title: '일자',textStyle: { fontSize: 10 }},
      		seriesType: 'bars',
      		series: {0: {type: 'line'},1: {type: 'line'}}
    	};
    	
    	var chart2 = new google.visualization.ComboChart(document.getElementById('chart_Current'));
    	chart2.draw(data2, options2);
    	
    	
    	
}
</script>

<table width="100%">
<tr><td>
<div id="chart_Temp" style="width: 100%; height: 300px;"></div>
</td></tr>
<tr><td>
<div id="chart_Current" style="width: 100%; height: 300px;"></div>
</td></tr>
</table>




</body>
</html>
  		
  		
  		
  		
  		
  		
