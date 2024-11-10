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


$node_idx = $_POST["node_idx"];
$node_num = $_POST["node_num"]; //시리얼번호
$node_id = $_POST["node_id"];   //보드이름
$node_name = $_POST["node_name"]; //장비번호
$pco_num = $_POST["pco_num"];
$channel = $_POST["channel"];

$Position = $_POST["lat"];
$Position = str_replace("(", "", $Position); 
$Position = str_replace(")", "", $Position);
$aryPos = explode (",", $Position);
$lat = $aryPos[0];
$lon = $aryPos[1];




$sqlData = " update node_list set node_id = '$node_id',
									node_name = '$node_name',
									channel = '$channel',
									latitude = '$lat',
									longitude = '$lon' where idx = '$node_idx'  ";
$resultID = query( $sqlData );


$re_url = "node_modify.php?node_idx=" . $node_idx;


$nodeidx = 0;
if ($resultID){
	$nodeidx = dbinstance()->insert_id;
	echo "<script>alert('노드 수정 성공!');</script>";
}


?>

<html>
<head>
<meta http-equiv="refresh" content="0; url=<?echo $re_url;?>" />
</head>
<body><center>
<h2>잠시 기다려 주세요.</h2>
</body>
</html>


  		
  		
  		
  		
  		
  		
