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
$refidx = $_SESSION['refidx'];



$useridx = $_POST["useridx"];
$username = $_POST["username"];
$userid = $_POST["userid"];
$pwd = $_POST["pwd"];
$pwdcnf = $_POST["pwdcnf"];
$contact = $_POST["contact"];
$email = $_POST["email"];
$level = $_POST["level"];
$description = $_POST["description"];

if($pwd != $pwdcnf){
	echo "<script>alert('비밀번호가 일치하지 않습니다.');history.back();</script>";
	exit;
}


$today = date("Y-m-d");
$sqlData = " insert into userinfo set userid = '$userid',
										password = '$pwd',
										username = '$username',
										level = '$level',
										regday = '$today',
										refidx = '$useridx',
										description = '$description', 
										phone = '$contact', 
										email = '$email' ";
$resultID = query( $sqlData );

if ($resultID){
	$nodeidx = dbinstance()->insert_id;
	echo "<script>alert('사용자 등록 성공!');</script>";
}
?>

<html>
<head>
<meta http-equiv="refresh" content="0; url=pco_list.php" />
</head>
<body><center>
<h2>Please wait moments.</h2>
</body>
</html>


  		
  		
  		
  		
  		
  		
