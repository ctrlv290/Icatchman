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



$ref_useridx = $_POST["ref_useridx"]; 
$client_id = $_POST["client_id"]; 
$site_id = $_POST["site_id"]; 


$arrayClient = explode ("/", $client_id);
$arraySite = explode ("/", $site_id);



$today = date("Y-m-d");
$sqlData = " insert into client_list set ref_useridx = '$ref_useridx',
										regday = '$today',
										client_id = '$arrayClient[0]',
										client_name = '$arrayClient[1]',
										site_idx = '$arraySite[0]',
										site_name = '$arraySite[1]' ";
$resultID = query( $sqlData );

$nodeidx = 0;
if ($resultID){
	$nodeidx = dbinstance()->insert_id;
	echo "<script>alert('등록 성공!');history.back();</script>";
}


?>

<html>
<head>
<meta http-equiv="refresh" content="0; url=client_list.php" />
</head>
<body><center>
<h2>잠시 기다려 주세요.</h2>
</body>
</html>


  		
  		
  		
  		
  		
  		
