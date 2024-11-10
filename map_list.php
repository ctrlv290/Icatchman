<!DOCTYPE html>
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
$site_name = $_GET["sitename"];

if($get_pconum < 0 ){
	$sqlUser = " select * from node_list order by node_id asc ";
}else{
	$sqlUser = " select * from node_list where pco_num = '".$get_pconum."' order by node_id asc ";
}
	
$rs_list 	= query( $sqlUser ); 
$cnt = 1;
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
	$cnt = $cnt + 1;
}
?>
<html>
<head>
<title>ZAPSRMS</title>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyAv-vd99KkN9lYipP7j6STcUpf7L3IOm9Q"></script>
<!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAv-vd99KkN9lYipP7j6STcUpf7L3IOm9Q&callback=initMap" async defer></script>-->



<script type="text/javascript">
      function initialize() {
        var mapLocation = new google.maps.LatLng('36.322473', '127.412501'); // 지도에서 가운데로 위치할 위도와 경도
        var markLocation1 = new google.maps.LatLng('36.322473', '127.412501'); // 마커가 위치할 위도와 경도
        var markLocation2 = new google.maps.LatLng('37.322473', '127.9');
        
        var locations = [
      ['Bondi Beach', 36.322473, 127.412501, 4],
      ['Coogee Beach', 37.322473, 127.9, 5],
      ['Cronulla Beach', 37.5, 127.9, 3],
      ['Manly Beach',37.9, 127.9, 2],
      ['Maroubra Beach', 37.95,127.9, 1]
    ];
    
    
        var mapOptions = {
          center: mapLocation, // 지도에서 가운데로 위치할 위도와 경도(변수)
          zoom: 18, // 지도 zoom단계
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map-canvas"),mapOptions);
         
        var size_x = 60; // 마커로 사용할 이미지의 가로 크기
        var size_y = 60; // 마커로 사용할 이미지의 세로 크기
         
        // 마커로 사용할 이미지 주소
        var image = new google.maps.MarkerImage( 'http://www.larva.re.kr/home/img/boximage3.png',
                            new google.maps.Size(size_x, size_y),
                            '',
                            '',
                            new google.maps.Size(size_x, size_y));
         
        /* 
        var marker1;
        marker1 = new google.maps.Marker({
               position: markLocation1, // 마커가 위치할 위도와 경도(변수)
               map: map,
               icon: image, // 마커로 사용할 이미지(변수)
//             info: '말풍선 안에 들어갈 내용',
               title: '마커1' // 마커에 마우스 포인트를 갖다댔을 때 뜨는 타이틀
        });
        
        var marker2;
        marker2 = new google.maps.Marker({
               position: markLocation2, // 마커가 위치할 위도와 경도(변수)
               map: map,
               icon: image, // 마커로 사용할 이미지(변수)
//             info: '말풍선 안에 들어갈 내용',
               title: '마커2' // 마커에 마우스 포인트를 갖다댔을 때 뜨는 타이틀
        });
        
        
         
        var content = "이곳은 서대전네거리역이다! <br/> 지하철 타러 가자~"; // 말풍선 안에 들어갈 내용
         
        // 마커를 클릭했을 때의 이벤트. 말풍선 뿅~
        var infowindow = new google.maps.InfoWindow({ content: content});
 
        google.maps.event.addListener(marker1, "click", function() {
            infowindow.open(map,marker);
        });
        
        google.maps.event.addListener(marker2, "click", function() {
            infowindow.open(map,marker);
        });
        */
        
        
        var marker, i;

    	for (i = 0; i < locations.length; i++) {  
			marker = new google.maps.Marker({
        	position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        	map: map
      	});

      	google.maps.event.addListener(marker, 'click', (function(marker, i) {
        	return function() {
          		infowindow.setContent(locations[i][0]);
          		infowindow.open(map, marker);
        		}
      		})(marker, i));
    	}
         
 
         
      }
      google.maps.event.addDomListener(window, 'load', initialize);
</script>


<!--
<script type="text/javascript">
  function initialize() {
    var locations = [
      ['Bondi Beach', -33.890542, 151.274856, 4],
      ['Coogee Beach', -33.923036, 151.259052, 5],
      ['Cronulla Beach', -34.028249, 151.157507, 3],
      ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
      ['Maroubra Beach', -33.950198, 151.259302, 1]
    ];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
}


function loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&' + 'callback=initialize';
  document.body.appendChild(script);
}

window.onload = loadScript;

</script>
-->

</head>
<body bgcolor="#ffffff"  topmargin="0">

<div id="map-canvas" style="width: 100%; height: 800px"></div>

</body>
</html>
  		
  		
  		
  		
  		
  		
