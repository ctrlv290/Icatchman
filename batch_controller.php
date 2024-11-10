<?php
require ('phpMQTT.php');
include ("dbcon_pharmcle.php");
require "autoload.php";

use GuzzleHttp\Client;

if(!isset($_GET['type']) || $_GET['type']=='' || !isset($_POST['pco_id']) || $_POST['pco_id'] == '') exit;

$app_id = intval($_POST['pco_id']);

$apiclient = new Client([
	'base_uri' => 'https://icatchman.com:3000/node-List/',
	'timeout'  => 2.0,
]);


switch($_GET['type']){
//	case 'set-relay':
//		if(isset($_POST['relay']) && $_POST['relay'] ==1 )
//			$data = 'AQ==';
//		else
//			$data = 'AA==';
//
//		$port = 96;
//		break;
	case 'relay-on':
		$data = 'AQ==';
		$port = 96;
		break;
	case 'relay-off':
		$data = 'AA==';
		$port = 96;
		break;
	case 'set-sched':
		$start = dechex(strtotime("$_POST[dtfrom] $_POST[timestart]:01:01"));
		$end = dechex(strtotime("$_POST[dtto] $_POST[timeend]:01:01"));

		$data = base64_encode(pack('H*',$start.$end));
		$port = 95;
		break;
	case 'reset-sched':
		$start = dechex(0);
		$end = dechex(0);

		$data = base64_encode(pack('H*',$start.$end));
		$port = 95;
		break;
	default:
		break;
}

$envs = file_exists(".mqttenv.local")?json_decode(file_get_contents(".mqttenv.local"),true): json_decode(file_get_contents(".mqttenv"),true);
//error_log('AAAAAAAA');
//error_log(print_r($envs,1));

//
//$server = $envs['mqtt']['host'];     // change if necessary
//$port = $envs['mqtt']['port'];                     // change if necessary
//$username = $envs['mqtt']['username'];                   // set your username
//$password = "";                   // set your password
$client_id = "pharmcle-batch-controller"; // make sure this is unique for connecting to sever - you could use uniqid()



//$message = "{\"confirmed\": true,\"data\": \"$data\",\"devEUI\": \"\",\"fPort\": $port,\"reference\": \"string\"}";

//error_log($message);
//error_log($envs['mqtt']['pub_prefix']);


### currently no wildcard supported for mqtt publish, so retrieve all nodeid from table

$sql = "select node_num,idx from node_list,channel where  pco_num = '$_POST[pco_id]' and working=1";
$rs_list 	= query( $sql );
$result = array();


$mqtt = new Bluerhinos\phpMQTT($envs['mqtt']['host'], $envs['mqtt']['port'], $client_id);
if ($mqtt->connect(true, NULL, $envs['mqtt']['username'], $envs['mqtt']['password'])) {


	while( $rw_list =  $rs_list ->fetch_array() ) {
		$mqtt->publish(
			$envs['mqtt']['pub_prefix'] . "/$rw_list[2]/node/$rw_list[0]/tx",
			"{\"confirmed\": false,\"data\": \"$data\",\"devEUI\": \"$rw_list[0]\",\"fPort\": $port,\"reference\": \"string\"}",
			1);

		if($_GET['type'] === 'set-sched'){
			$response = $apiclient->patch($rw_list[1],[
				"form_params"=> [
					"dateOn"=>$_POST['dtfrom'],
					"dateOff"=>$_POST['dtto'],
					"timeOn"=>$_POST['timestart'],
					"timeOff"=>$_POST['timeend'],
					"controlAt"=>(new Datetime())->format('Y-m-d H:i:s')
				]
			]);
		}

//		$result[] = ;
	}
	$mqtt->close();
	echo "Control data sent to all nodes !!";
} else {
	echo "Error sending control data - Timeout!!";
}
