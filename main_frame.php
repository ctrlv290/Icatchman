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

$kind = $_GET['kind'];
?>

<html>
<head>
<title>ZAPSRMS</title>

<?
if($level > 1){
?>
<frameset rows="50,*" frameborder="0" name="parent">
	<frame src="main_top.php" name="maintop"  scrolling="">
	<frameset cols="200,*" frameborder="0">
  		<frame src="main_left.php" name="mainleft"  scrolling="yes">
  		<frame src="main_body.php" name="mainbody"  scrolling="yes">
  	</frameset>
</frameset>
<?
}else{
?>
<frameset rows="50,*" frameborder="0" name="parent">
	<frame src="main_top.php" name="maintop"  scrolling="">
	<frameset cols="200,*" frameborder="0">
  		<frame src="main_left_client.php" name="mainleft"  scrolling="yes">
  		<frame src="main_body.php" name="mainbody"  scrolling="yes">
  	</frameset>
</frameset>
<?
}
?>

</head>
<body></body>
</html>



  		
  		
  		
  		
  		
  		
