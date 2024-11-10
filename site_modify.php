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

$site_idx = $_GET['site_idx'];

$sqlUser = " select * from site_list where siteidx = '". $site_idx . "' ";
$rs_list 	= query( $sqlUser ); 
$cnt = 1;
while( $rw_list =  $rs_list ->fetch_array() ) {
	$siteidx = $rw_list[siteidx];
	$t_useridx = $rw_list[useridx];
	$username = $rw_list[username];	
	$sitename = $rw_list[sitename];
	$descript = $rw_list[descript];
	$regday = $rw_list[regday];
	$chargeip = $rw_list[chargeip];	
	$chargeidx = $rw_list[chargeidx];	
	$chargephone = $rw_list[chargephone];	
	$clientname = $rw_list[clientname];
	$clientphone = $rw_list[clientphone];
	$clientemail = $rw_list[clientemail];
	$clientaddr = $rw_list[clientaddr];
	$lon = $rw_list[lon];
	$lat = $rw_list[lat];
}


if($level == 9 || $t_useridx == $useridx){
	//	
}else{
	echo "<script>alert('수정 권한이 없습니다.');history.back();</script>"; //"<meta http-equiv='refresh' content='0;url=login.php'>";
	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    
</head>
<body  onload="initialize()">
<form action="site_modify_recv.php" method="POST" enctype="multipart/form-data"  name="form1">
<input type="hidden" name="siteidx" value="<?echo $siteidx;?>">

<table>
<tr background="webimg/table_top_back.jpg">
<td colspan=2 height="30"><center>사이트 수정하기</td>
</tr>
<tr bgcolor = "#ffffff">
<td height="40" width="100">사이트 이름</td>
<td width="500"><input type="text" name="sitename" value="<?echo $sitename;?>" size="50" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40">사이트 설명</td>
<td><input type="text" name="descript" value="<?echo $descript;?>" size="100" style="height:20pt;"></td>
</tr>



<tr bgcolor = "#ffffff">
<td height="40">관리자 이름</td>
<td>
<select name="useridx" style="height:20pt; width:95%;">
<?
$sqlUser = " select * from userinfo where level > 0 order by username asc ";
$rs_list 	= query( $sqlUser ); 
$cnt = 1;
$set_phone = "";

while( $rw_list =  $rs_list ->fetch_array() ) {
	$r_useridx = $rw_list[useridx];
	$c_name = $rw_list[username];	
	$c_phone = $rw_list[phone];
	$set_phone = $c_phone;
	
	if($t_useridx == $r_useridx){
	?>
	<option value="<?echo $r_useridx;?>"  selected="selected"><?echo $c_name;?> [<?echo $set_phone;?>]</option>
	<?
	}else{
	?>
	<option value="<?echo $r_useridx;?>"><?echo $c_name;?> [<?echo $set_phone;?>]</option>
	<?
	}
}
	
?>
</select>
</td>
</tr>




<tr bgcolor = "#ffffff">
<td height="40">담당자 이름</td>
<td>
<select name="chargeidx" style="height:20pt; width:95%;">
<?
$sqlUser = " select * from userinfo  where level > 0  order by username asc ";
$rs_list 	= query( $sqlUser ); 
$cnt = 1;
$set_phone = "";

while( $rw_list =  $rs_list ->fetch_array() ) {
	$r_useridx = $rw_list[useridx];
	$c_name = $rw_list[username];	
	$c_phone = $rw_list[phone];
	$set_phone = $c_phone;
	
	if($chargeidx == $r_useridx){
	?>
	<option value="<?echo $r_useridx;?>"  selected="selected"><?echo $c_name;?> [<?echo $set_phone;?>] </option>
	<?
	}else{
	?>
	<option value="<?echo $r_useridx;?>"><?echo $c_name;?> [<?echo $set_phone;?>] </option>
	<?
	}
}
	
?>
</select>
</td>
</tr>
<!---
<tr bgcolor = "#f8f8f8">
<td height="40">담당자 연락처</td>
<td><input type="text" name="chargephone" value="<?echo $set_phone;?>" size="20" style="height:20pt;"></td>
</tr>
--->
<tr bgcolor = "#f8f8f8">
<td height="40">고객 이름</td>
<td><input type="text" name="clientname" value="<?echo $clientname;?>" size="20" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40">고객 연락처</td>
<td><input type="text" name="clientphone" value="<?echo $clientphone;?>" size="20" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40">고객 이메일</td>
<td><input type="text" name="clientemail" value="<?echo $clientemail;?>" size="20" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40">고객 주소</td>
<td><input type="text" name="clientaddr" value="<?echo $clientaddr;?>" size="100" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40">사이트 위치</td>
<td><input type="text" id="lat" name="lat" value="(<?echo $lat;?>,<?echo $lon;?>)" size="20" readonly  style="height:20pt; width:100%;"></td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40"> </td>
<td>
<div id="map_canvas" style="width: 100%; height: 400px"></div>

</td>
</tr>


<tr>
<td colspan="2" height="40" valign=middle><center><input type="submit" name="submit" value=" 수정하기 " style="font-size:12pt; color:white; width:200pt; height:25pt; background-color:#006C45;"></td>
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
function initialize() {
var myLatlng = new google.maps.LatLng(<?echo $lat;?>,<?echo $lon;?>); 
var myOptions = {   
zoom: 18,     
center: myLatlng,
mapTypeId: google.maps.MapTypeId.ROADMAP
} 

map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

//클릭했을 때 이벤트
google.maps.event.addListener(map, 'click', function(event) {
placeMarker(event.latLng);
infowindow.setContent("latLng: " + event.latLng); // 인포윈도우 안에 클릭한 곳위 좌표값을 넣는다.
infowindow.setPosition(event.latLng);             // 인포윈도우의 위치를 클릭한 곳으로 변경한다.

document.getElementById("lat").value = event.latLng;


});
//클릭 했을때 이벤트 끝


//인포윈도우의 생성
 var infowindow = new google.maps.InfoWindow(
 { content: '<?echo $sitename;?>',
 size: new google.maps.Size(50,50),
 position: myLatlng 
 });  
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
  		
  		
  		
  		
  		
  		
