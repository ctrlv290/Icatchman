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

$node_idx = $_GET["node_idx"]; //시리얼번호

$sqlUser = " select * from node_list where idx = '".$node_idx."' ";
$rs_list 	= query( $sqlUser );
while( $rw_list =  $rs_list ->fetch_array() ) {
	$node_idx = $rw_list[idx];
	$node_num = $rw_list[node_num]; //시리얼번호
	$node_id = $rw_list[node_id]; //보드번호
	$node_name = $rw_list[node_name]; //장비번호
	$pco_num = $rw_list[pco_num]; //사이트명
	$channel = $rw_list[channel];
	$node_lon = $rw_list[longitude];
	$node_lat = $rw_list[latitude];
}
?>

<!DOCTYPE html>
<html>
<head>


<head>
<body onload="initialize()">
<form action="node_modify_recv.php" method="POST" enctype="multipart/form-data"  name="form1">
<input type="hidden" name="node_idx" value="<?echo $node_idx;?>">
<input type="hidden" name="pco_num" value="<?echo $pco_num;?>">
<table>
<tr background="webimg/table_top_back.jpg">
<td colspan=2 height="30"><center>노드 수정하기</td>
</tr>
<tr bgcolor = "#ffffff">
<td height="40" width="200" align="right">보드 시리얼번호</td>
<td width="600"><input type="text" name="node_num" value="<?echo $node_num;?>" size="50" style="height:20pt;" readonly="readonly"></td>

<!-- 5/31 Time set button -->
<td><center><input type="button"  value="time set" onclick="TimeSet(this.form);"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40" align="right">노드이름(보드식별자)</td>
<td><input type="text" name="node_id" value="<?echo $node_id;?>" size="50" style="height:20pt;" ></td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40" align="right">장착 장비명</td>
<td><input type="text" name="node_name" value="<?echo $node_name;?>" size="50" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40" align="right">사이트 이름</td>
<?
$sqlUser = " select * from site_list where siteidx = '". $pco_num . "' ";
	$rs_list 	= query( $sqlUser );
	while( $rw_list =  $rs_list ->fetch_array() ) {
		$sitename = $rw_list[sitename];
	}
?>
<td><input type="text" name="pco_num" value="<?echo $sitename;?>" size="50" style="height:20pt;" readonly="readonly"></td>
</tr>


<tr bgcolor = "#ffffff">
<td height="40" align="right">로라 채널</td>

<td>
	<select name="channel" style="height:25pt; width:80%;">
	<?
		for($i = 1 ; $i<=9; $i++){
			if($i == $channel){
			?><option value="<?echo $i;?>" selected="selected">채널<?echo $i;?></option>
			<?
			}else{
			?><option value="<?echo $i;?>">채널<?echo $i;?></option>
			<?
			}
		}
	?>
	</select>
</td>
</tr>


<tr bgcolor = "#f8f8f8">
<td height="40" align="right">보드 위치</td>
<td><input type="text" id="lat" name="lat" value="(<?echo $node_lat;?>,<?echo $node_lon;?>)" size="20" readonly  style="height:20pt; width:100%;"></td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40"> </td>
<td>
<div id="map_canvas" style="width: 100%; height: 400px"></div>

</td>
</tr>



<tr>
<td colspan="2" height="40" valign=middle><center><input type="submit" name="submit" value=" 수정하기 " style="font-size:12pt; color:white; width:200pt; height:25pt; background-color:#0078B8;"></td>
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

/*
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
*/

function initialize() {
	var myLatlng = new google.maps.LatLng(<?echo $node_lat;?>,<?echo $node_lon;?>);
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

function TimeSet(thisform)
		{
		var con_test = confirm("time set?");
			if(con_test == false){
	  		return;
			}
			var node_num = thisform.value;
			var form = document.createElement("form");
			form.setAttribute("charset", "UTF-8");
			form.setAttribute("method", "Post"); // Get 또는 Post 입력
			form.setAttribute("action", "node_timeset.php");

			var hiddenField = document.createElement("input");
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", "node_num");
			hiddenField.setAttribute("value","<?echo $node_num;?>");
			form.appendChild(hiddenField);

			var hiddenField = document.createElement("input");
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", "channel");
			hiddenField.setAttribute("value", "<?echo $channel;?>");
			form.appendChild(hiddenField);

			var hiddenField = document.createElement("input");
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", "pco_num");
			hiddenField.setAttribute("value", "<?echo $pco_num;?>");
			form.appendChild(hiddenField);

			document.body.appendChild(form);

			form.submit();
	}

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAv-vd99KkN9lYipP7j6STcUpf7L3IOm9Q&callback=initMap" async defer></script>



</body>
</html>
