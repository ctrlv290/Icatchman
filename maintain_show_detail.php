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
$maintainidx = $_GET["maintainidx"];

$sqlUser = " select * from node_list where idx = '".$nodeidx."' ";
$rs_list 	= query( $sqlUser ); 
$cnt = 1;
while( $rw_list =  $rs_list ->fetch_array() ) {
	$node_idx = $rw_list[idx];
	$node_num = $rw_list[node_num]; //시리얼번호
	$node_id = $rw_list[node_id]; //보드번호
	$node_name = $rw_list[node_name]; //장비번호
	$pco_num = $rw_list[pco_num]; //사이트명
	$lat = $rw_list[latitude];
	$lon = $rw_list[longitude];
	$installday = $rw_list[installday];
	$lampnum = $rw_list[lampnum];
}



$sqlPCO = " select * from site_list where siteidx = '". $pco_num . "' ";
$rs_pco 	= query( $sqlPCO ); 
while( $rw_pco =  $rs_pco ->fetch_array() ) {
	$site_name = $rw_pco[sitename];
	$siteidx = $rw_pco[siteidx];
	$c_name = $rw_pco[c_name]; // 고객사 담당자
	$phone = $rw_pco[phone]; //고객 담당자 휴대폰
	$clientname = $rw_pco[clientname]; //고객사명
	$clientphone = $rw_pco[clientphone]; //고객사 전화
	$clientemail = $rw_pco[clientemail]; //고객 이메일
	$clientaddr = $rw_pco[clientaddr]; //고객사 주소
	$username = $rw_pco[username]; // 판매사
	$chargeip = $rw_pco[chargeip]; //담당자
	$chargephone = $rw_pco[chargephone]; //담당자 연락처
}


?>
<!DOCTYPE html>
<html>
<head>
<title>ZAPSRMS</title>
</head>
<body  onload="initialize()">
<table width="800" border="0" cellspacing="0" cellpadding="0" >
<tr bgcolor="#005699">
<td colspan="4" height="30"><center><h2><font color="white">장 비 관 리 대 장 [<?echo $node_name;?>]</h2></td>
</tr>
<!--
<tr>
<td height="30" width="100"><center>장비번호 :</td><td width="300"><?echo $node_name;?></td><td width="100"><center>장비명 :</td><td width="300"><?echo $node_name;?></td>
</tr>
-->
<tr>
<td height="30" width="100"><center>관리부서 :</td><td width="300"><?echo $clientname;?></td><td width="100"><center>담당자 :</td><td width="300"><?echo $c_name;?></td>
</tr>
</table>

	
<table width="800" border="1" cellspacing="0" cellpadding="1" boglor="black">
<tr>
<td width="100" bgcolor="#DFDFDF"><center>설치일</td><td width="300"><center><?echo $installday;?></td>
<td width="100" bgcolor="#DFDFDF"><center>가로등번호</td><td width="300"><center><?echo $lampnum;?></td>
</tr>
<tr>
<td width="100" bgcolor="#DFDFDF"><center>판매사</td><td width="300"><center><?echo $username;?></td>
<td width="100" bgcolor="#DFDFDF"><center>담당자</td><td width="300"><center><?echo $chargeip;?></td>
</tr>
<tr>
<td width="100" bgcolor="#DFDFDF"><center>전화번호</td><td width="300"><center><?echo $phone;?></td>
<td width="100" bgcolor="#DFDFDF"><center>휴대폰</td><td width="300"><center><?echo $chargephone;?></td>
</tr>

<?
$sqlMaintain = " select * from maintain where idx = '".$maintainidx."' ";
$rs_maintain 	= query( $sqlMaintain );
$cnt = 0;
while( $rw_maintain =  $rs_maintain ->fetch_array() ) {
	$idx = $rw_maintain['idx'];
	$node_idx = $rw_maintain['node_idx'];
	$node_id = $rw_maintain['node_id']; //보드번호
	$node_name = $rw_maintain['node_name']; //장비명
	$site_idx = $rw_maintain['site_idx'];
	$site_name = $rw_maintain['site_name']; //사이트명
	$cap_top = $rw_maintain['cap_top']; //상캡
	$cap_round = $rw_maintain['cap_round']; //원형캡
	$cap_bottom = $rw_maintain['cap_bottom']; //하커버
	$motor_top = $rw_maintain['motor_top']; //상부팬모터
	$motor_sinc = $rw_maintain['motor_sinc']; //동기모터
	$motor_spider = $rw_maintain['motor_spider']; //거미줄제거
	$round_pan = $rw_maintain['round_pan']; //원형철판
	$motor_bottom = $rw_maintain['motor_bottom']; //하부모터
	$plasticfan = $rw_maintain['plasticfan']; //플라스틱펜
	$reducer = $rw_maintain['reducer']; //레듀샤
	$cutting = $rw_maintain['cutting']; //커팅날
	$breaker = $rw_maintain['breaker']; //누전차단기
	$lamp_normal = $rw_maintain['lamp_normal']; //일반램프
	$lamp_led = $rw_maintain['lamp_led']; //LED
	$lamp_uv = $rw_maintain['lamp_uv']; //UV
	$as_normal = $rw_maintain['as_normal']; //정기점검
	$as_etc = $rw_maintain['as_etc']; //기타점검
	$pic1 = $rw_maintain['pic1'];
	$pic2 = $rw_maintain['pic2'];
	$width1 = $rw_maintain['width1'];
	$height1 = $rw_maintain['height1'];
	$width2 = $rw_maintain['width2'];
	$height2 = $rw_maintain['height2'];
	$n_day = $rw_maintain['n_day']; //등록일자
	$n_time = $rw_maintain['n_time']; //시간
	$content = $rw_maintain['content'];
	$useridx = $rw_maintain['useridx'];
	$username = $rw_maintain['username'];
	$m_day = $rw_maintain['m_day'];
	
	if($width1 >= $height1){ //가로
		$pic_rate1 = $height1 / $width1;
		$width1 = 350; 
		$height1 = 350 * $pic_rate1;
	}else{//세로
		$pic_rate1 = $width1 / $height1;
		$height1 = 400; 
		$width1 = 400 * $pic_rate1;
	}
	
	if($width2 >= $height2){ //가로
		$pic_rate2 = $height2 / $width2;
		$width2 = 350; 
		$height2 = 350 * $pic_rate1;
	}else{//세로
		$pic_rate2 = $width2 / $height2;
		$height2 = 400; 
		$width2 = 400 * $pic_rate2;
	}
	
	if($cap_top == 1){$cap_top="check_on.png";}else{$cap_top="check_off.png";}
	if($cap_round == 1){$cap_round="check_on.png";}else{$cap_round="check_off.png";}
	if($cap_bottom == 1){$cap_bottom="check_on.png";}else{$cap_bottom="check_off.png";}
	if($motor_top == 1){$motor_top="check_on.png";}else{$motor_top="check_off.png";}
	if($motor_sinc == 1){$motor_sinc="check_on.png";}else{$motor_sinc="check_off.png";}
	if($motor_spider == 1){$motor_spider="check_on.png";}else{$motor_spider="check_off.png";}
	if($round_pan == 1){$round_pan="check_on.png";}else{$round_pan="check_off.png";}
	if($motor_bottom == 1){$motor_bottom="check_on.png";}else{$motor_bottom="check_off.png";}
	if($plasticfan == 1){$plasticfan="check_on.png";}else{$plasticfan="check_off.png";}
	if($reducer == 1){$reducer="check_on.png";}else{$reducer="check_off.png";}
	if($cutting == 1){$cutting="check_on.png";}else{$cutting="check_off.png";}
	if($breaker == 1){$breaker="check_on.png";}else{$breaker="check_off.png";}
	if($lamp_normal == 1){$lamp_normal="check_on.png";}else{$lamp_normal="check_off.png";}
	if($lamp_led == 1){$lamp_led="check_on.png";}else{$lamp_led="check_off.png";}
	if($lamp_uv == 1){$lamp_uv="check_on.png";}else{$lamp_uv="check_off.png";}
	if($as_normal == 1){$as_normal="check_on.png";}else{$as_normal="check_off.png";}
	if($as_etc == 1){$as_etc="check_on.png";}else{$as_etc="check_off.png";}
	//if($pic1 == "pic_none.jpg"){$pic1="check_off.png";}else{$pic1="check_on.png";}
	//if($pic2 == "pic_none.jpg"){$pic2="check_off.png";}else{$pic2="check_on.png";}
}	
	
?>
<tr>
<td width="100" bgcolor="#DFDFDF"><center>처리일자</td>
<td colspan=3>
<?echo $n_day;?> <?echo $n_time;?>
</td>
</tr>
<tr>
<td width="100" bgcolor="#DFDFDF"><center>처리업무</td>
<td colspan=3>
<img src="webimg/<?echo $cap_top;?>" border=0 width="25" height="25">상캡
<img src="webimg/<?echo $cap_round;?>" border=0 width="25" height="25">원형캡
<img src="webimg/<?echo $cap_bottom;?>" border=0 width="25" height="25">하커버
<img src="webimg/<?echo $motor_top;?>" border=0 width="25" height="25">상부팬모터
<img src="webimg/<?echo $motor_sinc;?>" border=0 width="25" height="25">동기모터
<img src="webimg/<?echo $motor_spider;?>" border=0 width="25" height="25">거미줄제거
<img src="webimg/<?echo $round_pan;?>" border=0 width="25" height="25">원형철판
<img src="webimg/<?echo $motor_bottom;?>" border=0 width="25" height="25">하부모터
<br>
<img src="webimg/<?echo $plasticfan;?>" border=0 width="25" height="25">플라스틱펜
<img src="webimg/<?echo $reducer;?>" border=0 width="25" height="25">레듀샤
<img src="webimg/<?echo $cutting;?>" border=0 width="25" height="25">커팅날
<img src="webimg/<?echo $breaker;?>" border=0 width="25" height="25">누전차단기
<img src="webimg/<?echo $lamp_normal;?>" border=0 width="25" height="25">일반램프
<img src="webimg/<?echo $lamp_led;?>" border=0 width="25" height="25">LED
<img src="webimg/<?echo $lamp_uv;?>" border=0 width="25" height="25">UV
<br>
<img src="webimg/<?echo $as_normal;?>" border=0 width="25" height="25">정기점검
<img src="webimg/<?echo $as_etc;?>" border=0 width="25" height="25">기타점검
</td>
</tr>
<tr>
<td width="100" bgcolor="#DFDFDF"><center>내용</td>
<td colspan=3 height="100">
<?echo $content;?>
</td>
</tr>
<tr>
<td width="100" bgcolor="#DFDFDF"><center>사진</td>
<td colspan=3><center>
	<table width=100%><tr>
	<td width="50%" height="400" width="350"><center><img src="<?echo $pic1;?>" width="<?echo $width1;?>" height="<?echo $height1;?>" border="0"></td>
	<td width="50%" height="400" width="350"><center><img src="<?echo $pic2;?>" width="<?echo $width2;?>" height="<?echo $height2;?>"  border="0"></td>
	</tr></table>
</td>
</tr>
<tr>
<td width="100" bgcolor="#DFDFDF"><center>설치장소</td>
<td colspan=3><center>
<div id="map_canvas" style="width: 100%; height: 200px"></div>
</td>
</tr>
<tr>
<td colspan=4><center>
	<table width=100%>
	<tr>
	<td align="left"><span style="font-size:9pt;"><i>본 문서는 저작권법의 보호를 받습니다. (주)팜클</td>
	<td align="right">
	<input type="button" value="Print" onclick="window.print()" />
	</td>
	</tr>
</td>
</tr>
</table>


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
zoom: 15,     
center: myLatlng,
mapTypeId: google.maps.MapTypeId.ROADMAP,
panControl:false,
zoomControl:true,
mapTypeControl:false,
scaleControl:true,
streetViewControl:false,
overviewMapControl:false,
rotateControl:false

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
 { content: '<?echo $node_name;?>',
 size: new google.maps.Size(50,50),
 position: myLatlng 
 });  
 infowindow.open(map);


} // function initialize() 함수 끝

// 마커 생성 합수
function placeMarker(location)
{ 
//var clickedLocation = new google.maps.LatLng(location);
//var marker = new google.maps.Marker({       position: location,        map: map   });
//map.setCenter(location);
}

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAv-vd99KkN9lYipP7j6STcUpf7L3IOm9Q&callback=initMap" async defer></script>


</body>
</html>
  		
  		
  		
  		
  		
  		
