<?php
//<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
include ("dbcon_pharmcle.php");

if(isset($_GET['ajax']) && $_GET['ajax'] == "Y"){
	echo node_list(true);
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
    </style>
    
</head>

<title>ZAPS RMS</title> 
<!--
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
-->
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />-->
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css" />-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">

<body>
<div class="container">
<div style="margin:10px 0;">&nbsp;</div>
EOF;



$FOOTER = <<<EOF2
          <div class="footer-copyright">
            <div class="container">
            © 2017 All rights reverved to Pharmcle Inc.
            <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
            </div>
          </div>
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
            cb(this.responseText);
          } else {
            cb('error');
          }
        }
      };
      xhr.ontimeout = function(e) {
        console.error(e);
        cb(false);
      };

      xhr.onerror = function(e) {
        console.error(e);
        cb(false);
      };
    }
  }
};


	setInterval(function(){
ajax({
  url: '/zapsrms/node_list.php?pco_num=0001&ajax=Y&t=' + Math.random()
}).done(function(response) {
//  console.log(response);
	datagroup = JSON.parse(response);

	datagroup.map(function(data, index) {
//	    console.log(data);
 			document.getElementById('current-' + data.idx ).innerText = data.current;
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
	});
})
	    
//	    var getting = $.get('http://icatchman.com/zapsrms/node_list.php?pco_num=0001&ajax=Y');
//	  	var identifier;
//	    getting.done(function(data){
//
//	        data2 = JSON.parse(data);
//
//	    	$.each(data2, function(index, val){
//	    	    $('#current-' + val.idx).text(val.current);
//	    	    $('.current-color-' + val.idx).css('color', val.stat_color);
//	    	    $('#stat-color-' + val.idx).removeClass('green').removeClass('yellow').removeClass('grey').removeClass('red').removeClass('darken-1').addClass(val.stat_color);
//	    	    $('#regday-' + val.idx).text(val.regday);
//	    	});
//	    })
	 }, 10000);
	
	function send_signal(node_num) {
	    
	    window.postMessage(node_num);
	    
	 	return false;
	}

//		setInterval(function(){
//		    location.reload();
//		},10000);
</script>
</body>
</html>
EOF2;


echo $HTML . "<ul class='collection'>" . $DATA  . "</ul>" . $FOOTER;


function node_list($ajax = false) {
	$pco_num = $_GET['pco_num'];

	$sql = "select * from node_list where  pco_num = '$pco_num' ";

	$rs_list 	= query( $sql );
	$num_results = $rs_list->num_rows;

	$DATA = "";
	$arr = array();
	while( $rw_list =  $rs_list ->fetch_array() ) {
		$idx =  $rw_list['idx'];
		$node_name = $rw_list['node_name'];
		$node_num =  $rw_list['node_num'];
		$pco_num =  $rw_list['pco_num'];
		$temperature =  $rw_list['temperature'];
		$humidity =  $rw_list['humidity'];
		$current =  $rw_list['current'];
		$relay =  $rw_list['relay'] == 1?'ON':'OFF';

		$latitude =  $rw_list['latitude'];
		$longitude =  $rw_list['longitude'];

		$date = new DateTime($rw_list['sentDate'], new DateTimeZone('UTC'));
		$date->setTimezone(new DateTimeZone('Asia/Seoul'));

		$regday = timeago($date->format('Y-m-d H:i:s'));
//		error_log($date );
//		error_log($rw_list['sentDate'] . " " . $date->format('Y-m-d H:i:s'));
		$working = $rw_list['working'];

		if($working == 0) {
			$stat_color = 'grey';
			$current_color = "black";
		} else {
			if($relay == 'ON') {
				if( $current < 350)
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
	<a class='black-text' href='http://www.icatchman.com:3000/detail/$node_num' onClick='return send_signal(\"$node_num\");'>
	<div class='row' style='margin-bottom:5px;'>
	<span class='col s9'>
	<div><h5 id='node-name-$idx' class='blue-text text-darken-4'>$node_name</h5></div>
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
	$ARR[] = array('idx'=>$idx, 'current'=>$current, 'relay'=>$relay, 'regday'=>$regday, 'working'=>$working, 'stat_color'=>$stat_color, 'current_color'=>$current_color);
	}

	if($ajax)  return json_encode($ARR); else return $DATA;
}


function timeago($date) {

	$timestamp = strtotime($date);

	$strTime = array("second", "minute", "hour", "day", "month", "year");
	$length = array("60","60","24","30","12","10");

	$currentTime = time();
	if($currentTime >= $timestamp) {
		$diff     = time()- $timestamp;
		for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
			$diff = $diff / $length[$i];
		}

		$diff = round($diff);

		return $diff . " " . $strTime[$i] . "(s) ago ";
	}
}
