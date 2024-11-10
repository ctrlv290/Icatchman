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

$node_num = $_POST["node_num"];
$channel = $_POST["channel"];
$pco_num = $_POST["pco_num"];

$envs = file_exists(".mqttenv.local")?json_decode(file_get_contents(".mqttenv.local"),true): json_decode(file_get_contents(".mqttenv"),true);
$client_id = "pharmcle-node-timeset";
$mqtt = new Bluerhinos\phpMQTT($envs['mqtt']['host'], $envs['mqtt']['port'], $client_id);
$data = base64_encode(pack('H*',dechex(time())));
if ($mqtt->connect(true, NULL, $envs['mqtt']['username'], $envs['mqtt']['password'])) {
  $mqtt->publish(
    $envs['mqtt']['pub_prefix'] . "/$channel/node/$node_num/tx",
    "{\"confirmed\": true,\"data\": \"$data\",\"devEUI\": \"$node_num\",\"fPort\": 94,\"reference\": \"string\"}",
    1);
  }
$re_url = "node_manage.php?pco_num=" . $pco_num;
?>

<html>
<head>
<meta http-equiv="refresh" content="0; url=<?echo $re_url;?>" />
</head>
<body><center>
<h2>잠시 기다려 주세요.</h2>
</body>
</html>
