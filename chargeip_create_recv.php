<?
include ("dbcon_pharmcle.php");

	
$name = $_POST["name"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$descript = $_POST["descript"];


$today = date("Y-m-d");
$sqlData = " insert into chargeinfo set name = '$name',
										phone = '$phone',
										email = '$email',
										descript = '$descript' ";
$resultID = query( $sqlData );

$ipmidx = 0;
if ($resultID){
	$ipmidx = dbinstance()->insert_id;
	
}

?>

<html>
<head>
<meta http-equiv="refresh" content="0; url=chargeip_list.php" />
</head>
<body><center>
<h2>잠시 기다려 주세요.</h2>
</body>
</html>


  		
  		
  		
  		
  		
  		
