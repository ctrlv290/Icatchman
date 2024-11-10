<?php

session_start();
if(!isset($_SESSION['useridx']) || !isset($_SESSION['userid'])) {
	echo "<meta http-equiv='refresh' content='0;url=login.php'>";
	exit;
}

$useridx = $_SESSION['useridx'];
$userid = $_SESSION['userid'];
$level = $_SESSION['level'];
$username = $_SESSION['username'];

//<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
include ("dbcon_pharmcle.php");
require ('phpMQTT.php');
### define environment variables ###
//$THIS_PAGE='/zapsrms/node_list.php?pco_num=0001';
$THIS_PAGE = $_SERVER['REQUEST_URI'];
$DETAIL_PAGE = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . ':3000';
####################################


## check if web or android/ios webview and attach params
$check_app = "";

if ((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false)) {
        $check_app="?app=y";
}
//For Android
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "com.company.app" || isset($_GET['android'])) {
		$check_app="?app=y";
}

## read environment : check interval limit in minutes
$envs = file_exists(".mqttenv.local")?json_decode(file_get_contents(".mqttenv.local"),true): json_decode(file_get_contents(".mqttenv"),true);

$interval_limit = $envs["interval_limit"];
$time_differ = $envs["time_differ"] * 60 * 60;

if(isset($_GET['ajax']) && $_GET['ajax'] == "Y"){
	if(isset($_GET['data']) && $_GET['data'] == 'all') $data = true; else $data = false;
	echo node_list(true, $data);
	exit;
} else {
	$DATA = node_list();
}


## send message instead of hyperlink if android
$nativeMessage="";

if(isset($_GET['android'])) {
$nativeMessage = <<<EOF

 $('.detail-node').click(function(e){
     e.preventDefault();
    	data = $(this).data('nodedata');

    	window.postMessage(data);
 //	return false;
 });
EOF;

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
.dtpicker {
font-size:0.5rem !important;
height:1.2rem !important;
width:65% !important;
}
.tmpicker {
font-size:0.5rem;
height:2rem;
display:inline;
width:33%;
border:1px solid black;

}
th.rbd, td.rbd {
  border-right: 1px solid #e1e1e1 !important;
}
.titlebox {
	border:1px solid black;
	background-color: #236184;
	text-align:center;
	vertical-align:middle;
	height:3em;
}

.titletext {
	font-family: gulim;
	font-size:2em;
	color:white;
	font-weight:bolder;
}
    </style>

</head>

<title>ZAPS RMS</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.min.css" />
<body>
<div class="container" style="display:block;">
<div style="margin:10px 0;">&nbsp;</div>
	<div class='titlebox'><span class='titletext'>$_GET[sitename]</span></div>
  <!-- Modal Structure -->
  <div id="modal1" class="modal" style="max-height:100%;width:90%;">
    <div class="modal-content" style="padding:5px;">
      <h5>Batch Controller</h5>
      <div style="font-weight:bold;color:red">[Caution]: <span style="font-weight:bold;color:black;">Operation will take effect on all nodes in the group</span></div>
    </div>
    <form id="batch_control" method="post">
    <input type="hidden" name="pco_id" value="$_GET[pco_num]">
    <table class="striped centered" style="font-size:0.5em;">
    <tr>
		<td class="rbd">INSTANT<br>SWITCH</td>
		<td colspan="2">
<!-- Switch -->
  <!--<div class="switch">-->
    <!--<label>-->
      <!--&nbsp;-->
      <!--<input id='set-relay' name='relay' class="button-set" type="checkbox" value="1">-->
      <!--<span class="lever"></span>-->
      <!--&nbsp;-->
    <!--</label>-->
  <!--</div>-->
  		<div id='relay-off' class="btn-floating waves-effect waves-light grey button-set"><i class="material-icons medium black-text">stop</i></div>
		<div id='relay-on' class="btn-floating waves-effect waves-light red button-set" style="margin-left:1rem;"><i class="material-icons medium white-text">play_arrow</i></div>

		</td>
		<!--<td><div id='set-relay' class="button-set waves-effect waves-light btn btn-small tyny">SET</div></td>    -->
	</tr>
	<tr style="display:none;">
	<td class="rbd">
		RESET<br> SCHEDULE
	</td>
	<td colspan="2">
		<div id='reset-sched' class="red darken-1 button-set waves-effect waves-light btn">RESET</div>
	</td>
</tr>
    <tr>
		<td class="rbd">
		SCHED.<br>SET<br>

		</td>
		<td style="text-align:left;">

		<input class="dtpicker" name="dtfrom">
                                            <Select class="tmpicker" name="timestart">
                                            	<Option value="" disabled selected>ST</Option>
                                                <Option value='00'>00</Option>
                                                <Option value='01'>01</Option>
                                                <Option value='02'>02</Option>
                                                <Option value='03'>03</Option>
                                                <Option value='04'>04</Option>
                                                <Option value='05'>05</Option>
                                                <Option value='06'>06</Option>
                                                <Option value='07'>07</Option>
                                                <Option value='08'>08</Option>
                                                <Option value='09'>09</Option>
                                                <Option value='10'>10</Option>
                                                <Option value='11'>11</Option>
                                                <Option value='12'>12</Option>
                                                <Option value='13'>13</Option>
                                                <Option value='14'>14</Option>
                                                <Option value='15'>15</Option>
                                                <Option value='16'>16</Option>
                                                <Option value='17'>17</Option>
                                                <Option value='18'>18</Option>
                                                <Option value='19'>19</Option>
                                                <Option value='20'>20</Option>
                                                <Option value='21'>21</Option>
                                                <Option value='22'>22</Option>
                                                <Option value='23'>23</Option>
                                            </Select>
		<input class="dtpicker" name="dtto">
                                            <Select class="tmpicker" name="timeend">
                                            	<Option value="" disabled selected>ED</Option>
                                                <Option value='00'>00</Option>
                                                <Option value='01'>01</Option>
                                                <Option value='02'>02</Option>
                                                <Option value='03'>03</Option>
                                                <Option value='04'>04</Option>
                                                <Option value='05'>05</Option>
                                                <Option value='06'>06</Option>
                                                <Option value='07'>07</Option>
                                                <Option value='08'>08</Option>
                                                <Option value='09'>09</Option>
                                                <Option value='10'>10</Option>
                                                <Option value='11'>11</Option>
                                                <Option value='12'>12</Option>
                                                <Option value='13'>13</Option>
                                                <Option value='14'>14</Option>
                                                <Option value='15'>15</Option>
                                                <Option value='16'>16</Option>
                                                <Option value='17'>17</Option>
                                                <Option value='18'>18</Option>
                                                <Option value='19'>19</Option>
                                                <Option value='20'>20</Option>
                                                <Option value='21'>21</Option>
                                                <Option value='22'>22</Option>
                                                <Option value='23'>23</Option>
                                            </Select>


		</td>
		<td><div id='set-sched' class="button-set waves-effect waves-light btn btn-small tyny">SET</div></td>
	</tr>
	</tbody>
	</table>
	</form>
    <div class="modal-footer">
      <a href="#" class="modal-action modal-close waves-effect waves-green btn black">CLOSE</a>
    </div>
  </div>
EOF;



$FOOTER = <<<EOF2
          <div class="footer-copyright">
            <div class="row valign-wrapper">
            <div class="col s3">
             <!-- Modal Trigger -->
			  <a class="waves-effect waves-light modal-trigger" href="#modal1">
            	<i style="color:grey; text-shadow: 2px 2px black;" class="material-icons small">settings</i>
              </a>
            </div>
            <div class="col s9 right-align">© 2017 All rights reserved to Pharmcle Inc.</div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.min.js"></script>
<script>
// creates modal instance
$('.modal').modal();
// creates multiple datetime instances
// flatpickr(".dtpicker",{enableTime: true,dateFormat: "Y-m-d H:i"});
flatpickr(".dtpicker",{clickOpens:true});

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
	$nativeMessage

	$('.button-set').click(function(e){
		// e.preventDefault();

			  var id = $(this).attr('id');

			  if(id === 'set-sched') {
			      var dtfrom = $("input[name=dtfrom]").val();
			      var dtto = $("input[name=dtto]").val();
			      var timestart = $("select[name=timestart]").val();
			      var timeend = $("select[name=timeend]").val();
			      if(!dtfrom || !dtto || !timestart || !timeend) {
			          alert(' fill up the schedule!!');
			          return;
			      } else {
			          if(dtfrom >= dtto) {
			              alert('start date should be earlier than end date!');
			              return;
			          }

			          // if(timestart >= timeend) {
			          //     alert('on time should be earlier than off time!');
			          //     return;
			          //
			          // }
			      }
			  }

              var posting = $.post( "batch_controller.php?type=" + id, $( "#batch_control" ).serialize() );

                // Put the results in a div
               posting.done(function( data ) {
					Materialize.toast(data, 3000) // 4000 is the duration of the toast
                });
	});
});
</script>
</body>
</html>
EOF2;


echo $HTML . "<ul class='collection'>" . $DATA  . "</ul>" . $FOOTER;


function node_list($ajax = false, $data=false) {
	global $DETAIL_PAGE, $check_app;

	$pco_num = $_GET['pco_num'];

	$sql = "select * from node_list where  pco_num = '$pco_num' ";

	$rs_list 	= query( $sql );
	$num_results = $rs_list->num_rows;

	$DATA = "";
	$arr = array();
	while( $rw_list =  $rs_list ->fetch_array() ) {
		$idx =  $rw_list['idx'];
		$node_name = $rw_list['node_name'];
		$channel = $rw_list['channel'];
		$node_id = $rw_list['node_id']>''? "Node " . $rw_list['node_id']: "";

		$node_num =  $rw_list['node_num'];
		$pco_num =  $rw_list['pco_num'];
		$temperature =  $rw_list['temperature'];
		$humidity =  $rw_list['humidity'];
		$current =  $rw_list['current'];
		$current2 =  $rw_list['current2'];
		$current3 =  $rw_list['current3'];
		$relay =  $rw_list['relay'] == 1?'ON':'OFF';

		$latitude =  $rw_list['latitude'];
		$longitude =  $rw_list['longitude'];

		$check_time = array();
		$working_stat = true;
		if($rw_list['sentDate'] == '0000-00-00 00:00:00' && $rw_list['receiveDate'] == '0000-00-00 00:00:00'){
			$regday = "Never seen";
			$working_stat = false;
		}
		else{
			$check_time = sent_time_check($rw_list);
			$regday = $check_time[0];
			$working_stat = $check_time[1];
			$lasttime =  $check_time[2];
			//$current = ($check_time[2])?0:$current;
			//$current = $current;
		}

//		error_log($node_name . $node_num . $current . ' ' . $date->format('YmdHis') . ' ' . $regday);
//		error_log($date );
//		error_log($rw_list['sentDate'] . " " . $date->format('Y-m-d H:i:s'));
		$working = $rw_list['working'];

//		if($working == 0) {
//			$stat_color = 'grey';
//			$current_color = "black";
//		} else {
//			if(!$working_stat) {
//				$stat_color = "red darken-1";
//			} else {
//				if($relay == 'ON') {
////					if( $current < 400)
//					if( $current < 230)
//						$stat_color = "yellow darken-1";
//					else
//						$stat_color = "green darken-1";
//				} else {
//					$stat_color = "red darken-1";
//				}
//			}
//			$current_color = "white";
//		}

//6/25 램프 구성 수정 단순 on/off
		// if($working == 1){
		// 	if($relay == 'ON') {
		// 		if($working_stat){
		// 			if($lasttime < 24){
		// 				if($current < 10){
		// 					$stat_color="red darken-1";
		// 				}else if($current >= 10 && $current <= 230){
		// 					$stat_color="yellow darken-1";
		// 				}else if($current > 230){
		// 					$stat_color="green darken-1";
		// 				}
		// 			}else{
		// 				$stat_color="red darken-1";
		// 			}
		//
		// 		}else{
		// 			$stat_color="blue darken-1";
		// 		}
		//
		// 	}else{
		// 		$stat_color="orange darken-1";
		// 	}
		//
		// 	$current_color = "white";
		// }else{
		// 	$stat_color="grey";
		// 	$current_color = "black";
		// }

		//6/26 램프 구성 수정 단순 on/off
		if($working == 1){
				if($current < 100){
					$stat_color="red darken-1";
						}else if($current >= 100){
						$stat_color="green darken-1";
						}
			$current_color = "white";
		}else{
			$stat_color="grey";
			$current_color = "black";
		}

		// 6/26 3채널 화먼출력 if문 주석처리
		// if($working == 1){
		// 	if($relay == 'ON') {
		// 		if($working_stat){
		// 			if($lasttime < 24){
		// 				if($current2 < 10){
		// 					$stat_color2="red darken-1";
		// 				}else if($current2 >= 10 && $current2 <= 230){
		// 					$stat_color2="yellow darken-1";
		// 				}else if($current2 > 230){
		// 					$stat_color2="green darken-1";
		// 				}
		// 			}else{
		// 				$stat_color2="red darken-1";
		// 			}
		// 		}else{
		// 			$stat_color2="blue darken-1";
		// 		}
		// 	}else{
		// 		$stat_color2="orange darken-1";
		// 	}
		// 	$current_color2 = "white";
		// }else{
		// 	$stat_color2="grey";
		// 	$current_color2 = "black";
		// }
		//
		// if($working == 1){
		// 	if($relay == 'ON') {
		// 		if($working_stat){
		// 			if($lasttime < 24){
		// 				if($current3 < 10){
		// 					$stat_color3="red darken-1";
		// 				}else if($current3 >= 10 && $current3 <= 230){
		// 					$stat_color3="yellow darken-1";
		// 				}else if($current3 > 230){
		// 					$stat_color3="green darken-1";
		// 				}
		// 			}else{
		// 				$stat_color3="red darken-1";
		// 			}
		// 		}else{
		// 			$stat_color3="blue darken-1";
		// 		}
		// 	}else{
		// 		$stat_color3="orange darken-1";
		// 	}
		// 	$current_color3 = "white";
		// }else{
		// 	$stat_color3="grey";
		// 	$current_color3 = "black";
		// }

// 5/27 3채널 화먼출력 if문 주석처리
//	if ($channel == 1){

// 7/9 최하위권한 current 노출 가림
	$DATA .= "
<li class='collection-item hoverable'>
<a class='black-text detail-node' href='${DETAIL_PAGE}/detail/$node_num$check_app' data-nodedata='$node_name;$node_id;$latitude;$longitude;$node_num'>
<div class='row' style='margin-bottom:5px;'>
<span class='col s9'>
<div><h6 id='node-name-$idx' class='blue-text text-darken-4'>$node_name</h6></div>
<div class='smalltext fontgrey'>&nbsp;$node_id</div>
<div class='tinytext'>Last seen: <span class='tinytext' id='regday-$idx'>$regday</span></div>
</span>
<span class='col s1 valign_wrapper'>
		<div id='stat-color-$idx' class='z-depth-2 stat-circle $stat_color right'><div>
		<div id='current-$idx' class='current-color-$idx' style='line-height:40px;margin-top:10px;font-size:20px;color:$current_color'>$current</div>
		<div class='current-color-$idx' style='line-height:12px;;font-size:12px;color:$current_color'>mAh</div></div></div>
</span>
<span class='badge col s2 right-align'>
<i class='material-icons medium right-align'>chevron_right</i>
</span>
</div>
</a>
</li>
";


// 5/27 3채널 화먼출력 if문 주석처리
// }else{
// $DATA .= "
// <li class='collection-item hoverable'>
// 	<a class='black-text detail-node' href='${DETAIL_PAGE}/detail/$node_num$check_app' data-nodedata='$node_name;$node_id;$latitude;$longitude;$node_num'>
// 	<div class='row' style='margin-bottom:5px;'>
// 	<span class='col s9'>
// 	<div><h6 id='node-name-$idx' class='blue-text text-darken-4'>$node_name</h6></div>
// 	<div class='smalltext fontgrey'>&nbsp;$node_id</div>
// 	<div class='tinytext'>Last seen: <span class='tinytext' id='regday-$idx'>$regday</span></div>
// 	</span>
// 		<span class='col s1 valign_wrapper'>
// 				<div id='stat-color-$idx' class='z-depth-2 stat-circle $stat_color right'><div><div id='current-$idx' class='current-color-$idx' style='line-height:40px;margin-top:10px;font-size:20px;color:$current_color'>$current</div><div class='current-color-$idx' style='line-height:1px;;font-size:12px;color:$current_color'>mAh</div></div></div>
// 		 </span>
// 		 <span class='col s1 valign_wrapper'>
// 				<div id='stat-color-$idx' class='z-depth-2 stat-circle $stat_color2 right'><div><div id='current-$idx' class='current-color-$idx' style='line-height:40px;margin-top:10px;font-size:20px;color:$current_color2'>$current2</div><div class='current-color-$idx' style='line-height:1px;;font-size:12px;color:$current_color2'>mAh</div></div></div>
// 		 </span>
// 		 <span class='col s1 valign_wrapper'>
// 				<div id='stat-color-$idx' class='z-depth-2 stat-circle $stat_color3 right'><div><div id='current-$idx' class='current-color-$idx' style='line-height:40px;margin-top:10px;font-size:20px;color:$current_color3'>$current3</div><div class='current-color-$idx' style='line-height:1px;;font-size:12px;color:$current_color3'>mAh</div></div></div>
// 		 </span>
// 		<span class='badge col s2 right-align'>
// 	<!--	<i class='material-icons medium right-align'>chevron_right</i> -->
// 		</span>
// 	</div>
// 	</a>
// 	</li>
// 	";
// 	}
//	$ARR[] = array('idx'=>$idx, 'temperature'=>$temperature, 'current'=>$current, 'humidity'=>$humidity, 'relay'=>$relay, 'regday'=>$regday, 'working'=>$working, 'stat_color'=>$stat_color, 'current_color'=>$current_color);


if($data)
	$ARR[] = array('idx'=>$idx, 'nodenum'=>$node_num, 'nodeid'=>$node_id, 'nodename'=>$node_name, 'latitude'=>$latitude, 'longitude'=>$longitude, 'current'=>$current, 'relay'=>$relay, 'regday'=>$regday, 'working'=>$working, 'stat_color'=>$stat_color, 'current_color'=>$current_color, 'current_color2'=>$current_color2,'current_color3'=>$current_color3);
else
	$ARR[] = array('idx'=>$idx, 'current'=>$current, 'relay'=>$relay, 'regday'=>$regday, 'working'=>$working, 'stat_color'=>$stat_color, 'current_color'=>$current_color, 'current_color2'=>$current_color2,'current_color3'=>$current_color3);
}

	if($ajax)  return json_encode($ARR); else return $DATA;
}

function sent_time_check($result) {
	global $interval_limit, $time_differ;

	$dateDevice = $result['sentDate'];
	$dateServer = $result['receiveDate'];


	$date_on = $result["date_on"];
	$date_off = $result["date_off"];

	$currentDate = date("Y-m-d");
	// on/off time saved as local timezone (so i had to convert current hour to local format to compare)
	$timeOn = $result['time_on'];
	$timeOff = $result['time_off'];

	// currently time is in UTC
	date_default_timezone_set("UTC");

	$currentTime = time();

	$currentHour = date('H',$currentTime + $time_differ);

	$deviceTimeStamp = strtotime($dateDevice);
	$serverTimeStamp = strtotime($dateServer);


	if($date_on <= $currentDate && $date_off >= $currentDate) $working_stat = true; else $working_stat = false;

	$lasttime = ($currentTime - $serverTimeStamp)/(60*60); // seconds to hours

//	$timestamp = strtotime($date);

	## check sentDate exceeds interval limit (in minutes


//	if(abs($currentTime - $deviceTimeStamp) > $interval_limit * 60 ){
//
//		$longago = true;
//		if($currentHour >= $timeOn && $currentHour <= $timeOff){
//			$working_stat = false;
//		}
//
//		else{
//			$working_stat = true;
//		}
//
//	}
//
//	else{
//		$longago = false;
//		$working_stat = true;
//	}


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

//		return array($diff . " " . $strTime[$i] . "(s) ago ", $working_stat, $longago);
	return array($diff . " " . $strTime[$i] . "(s) ago ", $working_stat, $lasttime);
//	} elseif ($dateDevice != '0000-00-00 00:00:00') {

//	} else {

//	}
}
