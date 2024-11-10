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

?>

<html>
<head>
<title>ZAPSRMS</title>
</head>
<body>
<center><img src="webimg/big_front.jpg" border=0>
</body>
</html>



  		
  		
  		
  		
  		
  		
