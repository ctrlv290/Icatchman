<?php
//<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
include ("dbcon_pharmcle.php");

$pco_num = isset($_GET['pco_num'])?$_GET['pco_num']:'0001';


?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">

	<style>
		@import url(https://fonts.googleapis.com/css?family=Open+Sans);

		body{ font-family: 'Open Sans',serif; }
	</style>

</head>

<title>ZAPSRMS(Mobile)</title>
<!---
<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
--->
<body>
<center>
<form action="mb_login_ok.php" method="POST">
<table width="100%">
<tr>
<td colspan=2 align="center"><img src="zapsrms2.jpg" border=0 width="100%"></td>
</tr>
<tr>
<td width="45%" height="30" align="right" bgcolor="#A8E3FC">ID&nbsp;</td>
<td width="55%" align="left" bgcolor="#E4E4E4"><center><input type="text" name="userid" value="" style="border: 0px; height:25px; width:98%; background-color: #f9ffb5;"></td>
</tr>
<tr>
<td colspan=2  height="2" align="center" bgcolor="white"> </td>
</tr>
<tr>
<td width="45%"  height="30" align="right" bgcolor="#A8E3FC">PWD&nbsp;</td>
<td width="55%" align="left" bgcolor="#E4E4E4"><center><input type="password" name="passwd" value="" style="border: 0px; height:25px; width:98%; background-color: #f9ffb5;"></td>
</tr>
<tr>
<td colspan=2  height="5" align="center" bgcolor="white"> </td>
</tr>
<tr>
<td colspan=2  height="30" align="center">
<input type="submit" value="LogIn" style="color:white; width:50pt; height:24pt; background-color:#0078B8";">
</td>
</tr>
</table>
</form>


</body>
</html>
