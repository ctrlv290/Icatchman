<?
include ("dbcon_pharmcle.php");
session_start();
if(!isset($_SESSION['useridx']) || !isset($_SESSION['userid'])) {
	echo "<meta http-equiv='refresh' content='0;url=login.php'>";
	exit;
}
$level = $_SESSION['level'];



$useridx = $_POST["useridx"];
$username = $_POST["username"];
$mididx = $_POST["mididx"];
$sitename = $_POST["sitename"];
$descript = $_POST["descript"];
$chargeip = $_POST["chargeip"];
$chargephone = $_POST["chargephone"];
$clientname = $_POST["clientname"];
$clientphone = $_POST["clientphone"];
$clientemail = $_POST["clientemail"];
$clientaddr = $_POST["clientaddr"];
$Position = $_POST["lat"];
$Position = str_replace("(", "", $Position); 
$Position = str_replace(")", "", $Position);
$aryPos = explode (",", $Position);
$lat = $aryPos[0];
$lon = $aryPos[1];


$chargeidx = $_POST["chargeidx"];
$sqlUser = " select * from userinfo where useridx='".$chargeidx."'";
$rs_list 	= query( $sqlUser ); 

while( $rw_list =  $rs_list ->fetch_array() ) {
	$chargeip = $rw_list[username];	
	$chargephone = $rw_list[phone];
}

$sqlUser = " select * from userinfo where useridx = '". $mididx ."' ";
	$rs_list 	= query( $sqlUser ); 
	while( $rw_list =  $rs_list ->fetch_array() ) {
		$m_useridx = $rw_list[useridx];
		$m_username = $rw_list[username];
	}
	
/*
if($level == 9){
	$sqlUser = " select * from userinfo where useridx = '". $useridx ."' ";
	$rs_list 	= query( $sqlUser ); 
	while( $rw_list =  $rs_list ->fetch_array() ) {
		$t_useridx = $rw_list[useridx];
		$username = $rw_list[username];
	}
}
*/





$today = date("Y-m-d");
$sqlData = " insert into site_list set useridx = '$useridx',
										username = '$username',
										mididx = '$m_useridx',
										midname = '$m_username',
										sitename = '$sitename',
										descript = '$descript',
										regday = '$today',
										chargeip = '$chargeip',
										chargephone = '$chargephone',
										clientname = '$clientname', 
										clientphone = '$clientphone', 
										clientemail = '$clientemail', 
										clientaddr = '$clientaddr',
										lon = '$lon', 
										lat = '$lat' ";
$resultID = query( $sqlData );

$ipmidx = 0;
if ($resultID){
	$ipmidx = dbinstance()->insert_id;
	
}

//$re_url = "ipm_show.php?user_idx=" . $user_idx . "&ipmidx=" . $ipmidx;
$re_url = "site_list.php";

//echo $re_url;
?>

<html>
<head>
<meta http-equiv="refresh" content="0; url=site_list.php" />
</head>
<body><center>
<h2>잠시 기다려 주세요.</h2>
</body>
</html>


  		
  		
  		
  		
  		
  		
