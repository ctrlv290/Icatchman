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
<form action="site_create_recv.php" method="POST" enctype="multipart/form-data"  name="form1">
<input type="hidden" name="useridx" value="<?echo $useridx;?>">
<input type="hidden" name="username" value="<?echo $username;?>">

<table>
<tr background="webimg/table_top_back.jpg">
<td colspan=2 height="30"><center>사이트 등록하기</td>
</tr>
<tr bgcolor = "#ffffff">
<td height="40" width="100">사이트 이름</td>
<td width="500"><input type="text" name="sitename" value="" size="50" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40">사이트 설명</td>
<td><input type="text" name="descript" value="" size="100" style="height:20pt;"></td>
</tr>

<?
if($level == 9){
?>
<tr bgcolor = "#D1D1D1">
<td height="40">관리자 이름</td>
<td>
<select name="mididx" style="height:20pt; width:95%;">
<?
$sqlUser = " select * from userinfo where level >= 2 and level < 3 ";
$rs_list 	= query( $sqlUser ); 
$cnt = 0;
while( $rw_list =  $rs_list ->fetch_array() ) {
		$t_useridx = $rw_list[useridx];
		$t_username = $rw_list[username];
		?>
		<option value="<?echo $t_useridx;?>"><?echo $t_username;?> </option>
		<?
}	
	
?>
</select>
</td>
</tr>
<?
}
?>

<tr bgcolor = "#ffffff">
<td height="40">담당자 이름</td>
<td>
<select name="chargeidx" style="height:20pt; width:95%;">
<?
/*
$sqlUser = " select * from chargeinfo order by chargeidx asc ";
$rs_list 	= query( $sqlUser ); 
$cnt = 1;
$set_phone = "";

while( $rw_list =  $rs_list ->fetch_array() ) {
	$c_chargeidx = $rw_list[chargeidx];
	$c_name = $rw_list[name];	
	$c_phone = $rw_list[phone];
	$set_phone = $c_phone;
	
	if($c_chargeidx == $chargeidx){
	?>
	<option value="<?echo $c_chargeidx;?>"  selected="selected"><?echo $c_name;?> [<?echo $set_phone;?>]<?echo $c_chargeidx;?>/<?echo $chargeidx;?></option>
	<?
	}else{
	?>
	<option value="<?echo $c_chargeidx;?>"><?echo $c_name;?> [<?echo $set_phone;?>]<?echo $c_chargeidx;?>/<?echo $chargeidx;?></option>
	<?
	}
}
*/

$sqlUser = " select * from userinfo where level >= 1 and level <=2 ";
$rs_list 	= query( $sqlUser ); 
$cnt = 0;
while( $rw_list =  $rs_list ->fetch_array() ) {
		$t_useridx = $rw_list[useridx];
		$t_username = $rw_list[username];
		?>
		<option value="<?echo $t_useridx;?>"><?echo $t_username;?> </option>
		<?
}	

?>
</select>
</td>
</tr>

<!--
<tr bgcolor = "#ffffff">
<td height="40">담당자 이름</td>
<td><input type="text" name="chargeip" value="" size="20" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40">담당자 연락처</td>
<td><input type="text" name="chargephone" value="" size="20" style="height:20pt;"></td>
</tr>
--->


<tr bgcolor = "#f8f8f8">
<td height="40">고객 이름</td>
<td><input type="text" name="clientname" value="" size="20" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40">고객 연락처</td>
<td><input type="text" name="clientphone" value="" size="20" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40">고객 이메일</td>
<td><input type="text" name="clientemail" value="" size="20" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40">고객 주소</td>
<td><input type="text" name="clientaddr" value="" size="100" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40">사이트 위치</td>
<td><input type="text" id="lat" name="lat" value="사이트 위치를 클릭해 주세요." size="20" readonly  style="height:20pt; width:100%;"></td>
</tr>

<tr bgcolor = "#ffffff">
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
function initialize() {
var myLatlng = new google.maps.LatLng(37.20959739504577,126.97947084903717); 
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
 { content: '위치를 지정해주세요.',
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
  		
  		
  		
  		
  		
  		
