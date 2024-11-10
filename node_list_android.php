<?php
//<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
include ("dbcon_pharmcle.php");

### define environment variables ###
//$THIS_PAGE='/zapsrms/node_list.php?pco_num=0001';
$THIS_PAGE = $_SERVER['REQUEST_URI'];
$DETAIL_PAGE = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . ':3000';
####################################

if(isset($_GET['ajax']) && $_GET['ajax'] == "Y"){
	if(isset($_GET['data']) && $_GET['data'] == 'all') $data = true; else $data = false;
	echo node_list(true, $data);
	exit;
} else {
	$DATA = node_list();
}

$HTML=<<<EOF
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
      @import url(https://fonts.googleapis.com/css?family=Open+Sans);

		body{ font-family: 'Open Sans',serif; }
		.tinytext {font-size:10px;}
		.smalltext {font-size:11px;}
		.badge-margin { padding:4px;margin:3px 0;}
		.fontgrey {color:grey;}
.stat-circle {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  /*font-size: 50px;*/
  /*color: #fff;*/
  line-height: 35px;
  text-align: center;
  /*background: #000*/
}		
.on-top {
	opacity:1;
	display:inline;
	z-index:999;
	position:fixed;
	background-position: 0 -328px;
	bottom:0;
}    
    </style>

</head>

<title>ZAPS RMS</title> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
<body>
<div class="container" style="display:block;">
<div style="margin:10px 0;">&nbsp;</div>
EOF;



$FOOTER = <<<EOF2
          <div class="footer-copyright">
            <div class="container">
            © 2017 All rights reserved to Pharmcle Inc.
            <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
            </div>
          </div>
          <div class="on-top">&nbsp;</div>
</div>

<!--<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
<script>
function ajax(options) {
  var xhr = new XMLHttpRequest();
  var opts = Object.assign({
    withCredentials: false,
    method: 'GET'
  }, options);
  xhr.withCredentials = options.withCredentials;
  xhr.open(opts.method, opts.url);
  xhr.setRequestHeader('Accept', 'text/plain');
  xhr.send(null);
  return {
    done: function(cb) {
      xhr.onreadystatechange = function onStateChange() {
        if (this.readyState === 4) {
          if (this.status >= 200 && this.status < 300) {

			var response = this.responseText;

			datagroup = JSON.parse(response);

			datagroup.map(function(data, index) {

 			document.getElementById('current-' + data.idx ).innerText = data.current;
// 			$('#current-'+data.idx).text(data.current);
 			var current_style = document.getElementsByClassName('current-color-' + data.idx)
 			for (var i=0; i< current_style.length; i++){
 			    current_style[i].style.color = data.current_color;
 			}
 			var target = document.getElementById('stat-color-' + data.idx).classList;
 			target.remove("green");
 			target.remove("yellow");
 			target.remove("red");
 			target.remove("grey");
 			target.remove('darken-1');
 			var classToAdd = data.stat_color.split(' '); 
// 			target.add(data.stat_color);
			target.add(classToAdd[0]);
			target.add(classToAdd[1]);
 			document.getElementById('regday-'+data.idx).innerText = data.regday;
// 			            cb(this.responseText);
	});
          } else {
            cb('error');
          }
        }
      };
      xhr.ontimeout = function(e) {
//          alert(e);
//        console.error(e);
        cb(false);
      };

      xhr.onerror = function(e) {
//          alert(e);
//        console.error(e);
        cb(false);
      };
    }
  }
};
	setInterval(function(){

ajax({
  url: '$THIS_PAGE&ajax=Y&t=' + Math.random()
})
.done(function(response) {
	    })
	 }, 10000);

$(document).ready(function(){
$('.detail-node').click(function(e){
    e.preventDefault();
   	data = $(this).data('nodedata');
	
   	window.postMessage(data);
//	return false;   
});    
});

</script>
</body>
</html>
EOF2;


echo $HTML . "<ul class='collection'>" . $DATA  . "</ul>" . $FOOTER;


function node_list($ajax = false, $data=false) {
	global $DETAIL_PAGE;

	$pco_num = $_GET['pco_num'];

	$sql = "select * from node_list where  pco_num = '$pco_num' ";

	$rs_list 	= query( $sql );
	$num_results = $rs_list->num_rows;

	$DATA = "";
	$arr = array();
	while( $rw_list =  $rs_list ->fetch_array() ) {
		$idx =  $rw_list['idx'];
		$node_name = $rw_list['node_name'];

		$node_id = $rw_list['node_id']>''? "Node " . $rw_list['node_id']: "";

		$node_num =  $rw_list['node_num'];
		$pco_num =  $rw_list['pco_num'];
		$temperature =  $rw_list['temperature'];
		$humidity =  $rw_list['humidity'];
		$current =  $rw_list['current'];
		$relay =  $rw_list['relay'] == 1?'ON':'OFF';

		$latitude =  $rw_list['latitude'];
		$longitude =  $rw_list['longitude'];

		if($rw_list['sentDate'] == '0000-00-00 00:00:00' && $rw_list['receiveDate'] == '0000-00-00 00:00:00')
			$regday = "Never seen";
		else
			$regday = timeago($rw_list['sentDate'], $rw_list['receiveDate']);
//		error_log($node_name . $node_num . $current . ' ' . $date->format('YmdHis') . ' ' . $regday);
//		error_log($date );
//		error_log($rw_list['sentDate'] . " " . $date->format('Y-m-d H:i:s'));
		$working = $rw_list['working'];

		if($working == 0) {
			$stat_color = 'grey';
			$current_color = "black";
		} else {
			if($relay == 'ON') {
				if( $current < 400)
					$stat_color = "yellow darken-1";
				else
					$stat_color = "green darken-1";
			} else {
				$stat_color = "red darken-1";
			}
			$current_color = "white";
		}
		$DATA .= "
	<li class='collection-item hoverable'>
	<a class='black-text detail-node' href='${DETAIL_PAGE}/detail/$node_num' data-nodedata='$node_name;$node_id;$latitude;$longitude;$node_num'>
	<div class='row' style='margin-bottom:5px;'>
	<span class='col s9'>
	<div><h6 id='node-name-$idx' class='blue-text text-darken-4'>$node_name</h6></div>
	<div class='smalltext fontgrey'>&nbsp;$node_id</div>
	<div class='tinytext'>Last seen: <span class='tinytext' id='regday-$idx'>$regday</span></div>
	</span>
	<span class='col s1 valign_wrapper'>
  		<div id='stat-color-$idx' class='z-depth-2 stat-circle $stat_color right'><div><div id='current-$idx' class='current-color-$idx' style='line-height:40px;margin-top:10px;font-size:20px;color:$current_color'>$current</div><div class='current-color-$idx' style='line-height:12px;;font-size:12px;color:$current_color'>mAh</div></div></div>
	</span>
	<span class='badge col s2 right-align'>
	<i class='material-icons medium right-align'>chevron_right</i>
	</span>
	</div>
	</a>
	</li>
";
//	$ARR[] = array('idx'=>$idx, 'temperature'=>$temperature, 'current'=>$current, 'humidity'=>$humidity, 'relay'=>$relay, 'regday'=>$regday, 'working'=>$working, 'stat_color'=>$stat_color, 'current_color'=>$current_color);
	if($data)
		$ARR[] = array('idx'=>$idx, 'nodenum'=>$node_num, 'nodeid'=>$node_id, 'nodename'=>$node_name, 'latitude'=>$latitude, 'longitude'=>$longitude, 'current'=>$current, 'relay'=>$relay, 'regday'=>$regday, 'working'=>$working, 'stat_color'=>$stat_color, 'current_color'=>$current_color);
	else
		$ARR[] = array('idx'=>$idx, 'current'=>$current, 'relay'=>$relay, 'regday'=>$regday, 'working'=>$working, 'stat_color'=>$stat_color, 'current_color'=>$current_color);
	}

	if($ajax)  return json_encode($ARR); else return $DATA;
}


function timeago($dateDevice, $dateServer) {

	// currently time is in UTC
	date_default_timezone_set("UTC");

	$currentTime = time();
	$deviceTimeStamp = strtotime($dateDevice);
	$serverTimeStamp = strtotime($dateServer);

//	$timestamp = strtotime($date);

	$strTime = array("second", "minute", "hour", "day", "month", "year");
	$length = array("60","60","24","30","12","10");

//	$currentTime = time();
	$timestamp = 0;
	if( $currentTime >= $deviceTimeStamp) {
		if($currentTime <= $deviceTimeStamp + 60*60*24*30)
			// within month, use device time
			$timestamp = $deviceTimeStamp;
		elseif($currentTime > $deviceTimeStamp + 60*60*24*30 && $deviceTimeStamp > 0)
			// seen more than a months ago or wrong device time, so use server time instead
			$timestamp = $serverTimeStamp;
		else
			$timestamp = $serverTimeStamp;

	} else
		$timestamp = $serverTimeStamp;  // device time is wrong, use server time instead


//	if($currentTime >= $timestamp) {
//	if($currentTime >= $deviceTimeStamp) {
//		$diff     = time()- $deviceTimeStamp;
		$diff   = $currentTime - $timestamp;
		for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
			$diff = $diff / $length[$i];
		}

		$diff = round($diff);

		return $diff . " " . $strTime[$i] . "(s) ago ";
//	} elseif ($dateDevice != '0000-00-00 00:00:00') {

//	} else {

//	}
}
