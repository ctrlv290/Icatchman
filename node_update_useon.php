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


$device = $_POST["device"];
$get_pconum = $_POST["get_pconum"];
$onoff = $_POST["onoff"];


$arrayDevidx = explode (",", $device);
$cntResult = count($arrayDevidx); 

/*
echo "device: ". $device ."<br>";
echo "get_pconum: ". $get_pconum ."<br>";
echo "sel_pconum: ". $sel_pconum ."<br>";
*/

for($i = 0; $i < $cntResult; $i++){
	$sqlDevice = " update node_list set working = '$onoff'  where idx = '$arrayDevidx[$i]' ";
	$updateResult1 	= query( $sqlDevice );
}


$re_url = "node_manage.php?pco_num=" . $get_pconum ;

//echo "re_url: ". $re_url ."<br>";

?>

<html>
<head>
<meta http-equiv="refresh" content="0; url=<?echo $re_url;?>" />
</head>
<body><center>
<h2>Please wait moments.</h2>
</body>
</html>

  		
  		
  		
  		
  		
  		
