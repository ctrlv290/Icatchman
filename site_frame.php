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

$sitename = $_GET["sitename"];
$pco_num = $_GET["pco_num"]; // site_idx == pco_num
?>

<html>
<head>
<title>ZAPSRMS</title>

<frameset rows="32,*" frameborder="0">
  	<frame src="site_top.php?site_idx=<?echo $pco_num;?>&sitename=<?echo $sitename;?>" name="sitetop"  scrolling="no">
  	<frame src="node_list.php?pco_num=<?echo $pco_num;?>&sitename=<?echo $sitename;?>" name="sitemain"  scrolling="yes">
</frameset>


</head>
<body></body>
</html>



  		
  		
  		
  		
  		
  		
