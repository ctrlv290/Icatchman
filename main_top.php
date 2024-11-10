<?
session_start();
if(!isset($_SESSION['useridx']) || !isset($_SESSION['userid'])) {
	echo "<meta http-equiv='refresh' content='0;url=login.php'>";
	exit;
}

$useridx = $_SESSION['useridx'];
$userid = $_SESSION['userid'];
$level = $_SESSION['level'];
$username = $_SESSION['username'];

$useridx_ck = $_COOKIE['useridx_ck'];

?>

<html>
<head><head>
<body topmargin="0"  leftmargin="0"  rightmargin="0">

<table width="100%"  border=0 cellpadding=0 cellspacing=0>
<tr>
<td background="webimg/back_top_small.jpg" cellpadding="0" cellspacing="0" align=left width="170">
<img src="webimg/logo_top_small2.jpg" width="167" height="50" border=0>
</td>
<td background="webimg/back_top_small.jpg" cellpadding="0" cellspacing="0" align=right>
<font color=white>
사용자: <?echo $username;?>
&nbsp;
</font>
</td>
<td background="webimg/back_top_small.jpg" cellpadding="0" cellspacing="0" align=left width="130">
<a href="login_out.php" target="_parent"><img src="webimg/logout.jpg" width="128" height="50" border=0></a>
</td>
</tr>
</table>


</body>
</html>
  		
  		
  		
  		
  		
  		
