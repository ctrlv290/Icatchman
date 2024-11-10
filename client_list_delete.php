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


$client_idx = $_POST["idx"];
echo "client_idx: " . $client_idx;

$sqlProject = " delete from client_list where  clientidx = '".$client_idx."' ";
$resultID 	= query( $sqlProject );


if ($resultID){
	$nodeidx = dbinstance()->insert_id;
	echo "<script>alert('삭제되었습니다!');</script>";
}


?>


<html>
<head>
<meta http-equiv="refresh" content="3; url=client_list.php" />
</head>
<body><center>
<h2>Please wait moments.</h2>
</body>
</html>

  		
  		
  		
  		
  		
  		
