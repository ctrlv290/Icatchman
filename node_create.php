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
<body  onload="initialize()">
<form action="node_create_recv.php" method="POST" enctype="multipart/form-data"  name="form1">

<table>
<tr background="webimg/table_top_back.jpg">
<td colspan=2 height="30"><center>장비(노드) 등록하기</td>
</tr>
<tr bgcolor = "#ffffff">
<td height="40" width="200" align="right">RMS보드 시리얼번호</td>
<td width="600"><input type="text" name="node_num" value="" size="50" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40" align="right">RMS보드번호</td>
<td><input type="text" name="node_id" value="" size="50" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40" align="right">장비명(장비번호)</td>
<td><input type="text" name="node_name" value="" size="50" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40" align="right">장비타입</td>
<td><select id="dtype" name="dtype" style="height:25pt; width:80%;">
		<option value="아이잽프로">아이잽프로</option>
		<option value="토네이도">토네이도</option>
	</select>
</td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40" align="right">장비설치일자</td>
<td><input type="text" name="deviceday" value="" size="50" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40" align="right">RMS설치일자</td>
<td><input type="text" name="installday" value="" size="50" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40" align="right">가로등번호</td>
<td><input type="text" name="lampnum" value="" size="50" style="height:20pt;"></td>
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

<tr bgcolor = "#f8f8f8">
<td height="40" align="right">설치장소</td>
<td><input type="text" name="address" value="" style="height:20pt; width:100%;"></td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40" align="right">보드 위치(GPS)</td>
<td><input type="text" id="lat" name="lat" value="보드 위치를 클릭해 주세요." size="20" readonly  style="height:20pt; width:100%;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40"> </td>
<td>
<div id="map_canvas" style="width: 100%; height: 400px"></div>

</td>
</tr>

<tr>
<td colspan="2" height="40" valign=middle><center><input type="submit" name="submit" value=" 등록하기 " style="font-size:12pt; color:white; width:200pt; height:25pt; background-color:#0078B8;"></td>
</tr>


</table>
</form>


<script>
	/*
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8
        });
      }
    */

var map;


var jsonPcoNum = eval('<?=json_encode($arry_pconum)?>');
var jsonLon = eval('<?=json_encode($arry_lon)?>');
var jsonLat = eval('<?=json_encode($arry_lat)?>');


function chageSiteSelect(){
	var numSelect = document.getElementById("id_pconum");
	var idx = numSelect.selectedIndex;
	//alert("selectedIndex:" +idx);
	//alert(jsonPcoNum[idx] + " / " + jsonLat[idx] + " / " + jsonLon[idx]);

	var myLatlng = new google.maps.LatLng(jsonLat[idx],jsonLon[idx]);
	var myOptions = {
	zoom: 18,
	center: myLatlng,
	mapTypeId: google.maps.MapTypeId.ROADMAP
	}

	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

	//클릭했을 때 이벤트
	google.maps.event.addListener(map, 'click',
		function(event) {
			placeMarker(event.latLng);
			infowindow.setContent("latLng: " + event.latLng); // 인포윈도우 안에 클릭한 곳위 좌표값을 넣는다.
			infowindow.setPosition(event.latLng);             // 인포윈도우의 위치를 클릭한 곳으로 변경한다.

			document.getElementById("lat").value = event.latLng;
		}
	);
	//클릭 했을때 이벤트 끝


	//인포윈도우의 생성
 	var infowindow = new google.maps.InfoWindow(
 		{ content: '클릭으로 위치를 지정해주세요.', size: new google.maps.Size(50,50), position: myLatlng }
 	);

 	infowindow.open(map);

}


function initialize() {
	var myLatlng = new google.maps.LatLng(37.20959739504577,126.97947084903717);
	var myOptions = {
			zoom: 18,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
	}

	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

	//클릭했을 때 이벤트
	google.maps.event.addListener(map, 'click',
		function(event) {
			placeMarker(event.latLng);
			infowindow.setContent("latLng: " + event.latLng); // 인포윈도우 안에 클릭한 곳위 좌표값을 넣는다.
			infowindow.setPosition(event.latLng);             // 인포윈도우의 위치를 클릭한 곳으로 변경한다.

			document.getElementById("lat").value = event.latLng;
		}
	);
	//클릭 했을때 이벤트 끝


	//인포윈도우의 생성
 	var infowindow = new google.maps.InfoWindow(
 		{ content: '클릭으로 위치를 지정해주세요.', size: new google.maps.Size(50,50), position: myLatlng }
 	);

 	infowindow.open(map);


} // function initialize() 함수 끝

// 마커 생성 합수
function placeMarker(location)
{
var clickedLocation = new google.maps.LatLng(location);
var marker = new google.maps.Marker({       position: location,        map: map   });
map.setCenter(location);
}

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAv-vd99KkN9lYipP7j6STcUpf7L3IOm9Q&callback=initMap" async defer></script>



</body>
</html>
