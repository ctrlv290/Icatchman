<?
include ("dbcon_pharmcle.php");
require ('phpMQTT.php');
require "autoload.php";

session_start();
if(!isset($_SESSION['useridx']) || !isset($_SESSION['userid'])) {
	echo "<meta http-equiv='refresh' content='0;url=login.php'>";
	exit;
}

$useridx = $_SESSION['useridx'];
$userid = $_SESSION['userid'];
$level = $_SESSION['level'];
$username = $_SESSION['username'];



$node_num = $_POST["node_num"]; //시리얼번호
$node_id = $_POST["node_id"]; //보드번호
$node_name = $_POST["node_name"]; //장비번호
$installday = $_POST["installday"]; //RMS설치일자
$lampnum = $_POST["lampnum"]; //가로등번호
$pco_num = $_POST["pco_num"]; //사이트명
$channel = $_POST["channel"]; //로라 채널
$Position = $_POST["lat"];
$Position = str_replace("(", "", $Position);
$Position = str_replace(")", "", $Position);
$aryPos = explode (",", $Position);
$lat = $aryPos[0];
$lon = $aryPos[1];

$dtype = $_POST["dtype"]; //장비종류
$deviceday = $_POST["deviceday"]; //장비설치일자
$address = $_POST["address"]; //장비설치주소


$today = date("Y-m-d");
$sqlData = " insert into node_list set node_num = '$node_num',
										node_id = '$node_id',
										node_name = '$node_name',
										pco_num = '$pco_num',
										channel = '$channel',
										longitude = '$lon',
										latitude = '$lat',
										installday = '$installday',
										lampnum = '$lampnum',
										dtype = '$dtype',
										deviceday = '$deviceday',
										address = '$address' ";
$resultID = query( $sqlData );

// 5/27 node등록 시 set time 설정 코드 추가
$envs = file_exists(".mqttenv.local")?json_decode(file_get_contents(".mqttenv.local"),true): json_decode(file_get_contents(".mqttenv"),true);
$nodeidx = 0;
if ($resultID){
	$nodeidx = dbinstance()->insert_id;
	echo "<script>alert('노드 등록 성공!');history.back();</script>";
	$client_id = "pharmcle-node-timeset";
	$mqtt = new Bluerhinos\phpMQTT($envs['mqtt']['host'], $envs['mqtt']['port'], $client_id);
	$data = base64_encode(pack('H*',dechex(time())));
	if ($mqtt->connect(true, NULL, $envs['mqtt']['username'], $envs['mqtt']['password'])) {
		$mqtt->publish(
			$envs['mqtt']['pub_prefix'] . "/$channel/node/$node_num/tx",
			"{\"confirmed\": false,\"data\": \"$data\",\"devEUI\": \"$node_num\",\"fPort\": 94,\"reference\": \"string\"}",
			1);
		}
}
?>

<html>
<head>
<meta http-equiv="refresh" content="0; url=node_create.php" />
</head>
<body><center>
<h2>잠시 기다려 주세요.</h2>
</body>
</html>
