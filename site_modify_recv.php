<?
include ("dbcon_pharmcle.php");

$siteidx = $_POST["siteidx"];
$sitename = $_POST["sitename"];
$descript = $_POST["descript"];
$useridx = $_POST["useridx"];
$chargeidx = $_POST["chargeidx"];
$clientname = $_POST["clientname"];
$clientphone = $_POST["clientphone"];
$clientemail = $_POST["clientemail"];
$clientaddr = $_POST["clientaddr"];

$sqlUser = " select * from userinfo where useridx='".$useridx."'";
$rs_list 	= query( $sqlUser ); 

while( $rw_list =  $rs_list ->fetch_array() ) {
	$r_username = $rw_list[username];	
}



$sqlUser = " select * from userinfo where useridx='".$chargeidx."'";
$rs_list 	= query( $sqlUser ); 

while( $rw_list =  $rs_list ->fetch_array() ) {
	$chargeip = $rw_list[username];	
	$chargephone = $rw_list[phone];
}

$Position = $_POST["lat"];
$Position = str_replace("(", "", $Position); 
$Position = str_replace(")", "", $Position);
$aryPos = explode (",", $Position);
$lat = $aryPos[0];
$lon = $aryPos[1];

$sqlData = " update site_list set useridx = '$useridx',
									username = '$r_username',
									sitename = '$sitename',
									descript = '$descript',
									chargeip = '$chargeip',
									chargeidx = '$chargeidx',
									chargephone = '$chargephone',
									clientname = '$clientname', 
									clientphone = '$clientphone', 
									clientemail = '$clientemail', 
									clientaddr = '$clientaddr',
									lon = '$lon', 
									lat = '$lat' where siteidx = '$siteidx'  ";
$resultID = query( $sqlData );



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


  		
  		
  		
  		
  		
  		
