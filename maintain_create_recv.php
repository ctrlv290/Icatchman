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


$node_idx = $_POST['nodeidx'];
$node_id = $_POST['node_id'];// 보드번호
$node_name = $_POST['node_name'];// 장비명
$site_name = $_POST['site_name']; // 사이트명	

$cap_top = $_POST['cap_top'];
$cap_round = $_POST['cap_round'];
$cap_bottom = $_POST['cap_bottom'];
if($cap_top == null){ $cap_top = 0; }
if($cap_round == null){ $cap_round = 0; }
if($cap_bottom == null){ $cap_bottom = 0; }
/*
echo "cap_top:" . $cap_top . "<br>";
echo "cap_round:" . $cap_round . "<br>";
echo "cap_bottom:" . $cap_bottom . "<br>";
echo "<br>";
*/

$motor_top = $_POST['motor_top']; // 상부팬모터	
$motor_sinc = $_POST['motor_sinc']; // 동기모터	
$motor_spider = $_POST['motor_spider']; // 거미줄제거
if($motor_top == null){ $motor_top = 0; }
if($motor_sinc == null){ $motor_sinc = 0; }
if($motor_spider == null){ $motor_spider = 0; }	
/*
echo "motor_top:" . $motor_top . "<br>";
echo "motor_sinc:" . $motor_sinc . "<br>";
echo "motor_spider:" . $motor_spider . "<br>";	
echo "<br>";
*/

$round_pan = $_POST['round_pan']; // 원형철판
$motor_bottom = $_POST['motor_bottom']; // 하부모터	
$plasticfan = $_POST['plasticfan']; // 플라스틱펜	
$reducer = $_POST['reducer']; // 레듀샤	
if($round_pan == null){ $round_pan = 0; }
if($motor_bottom == null){ $motor_bottom = 0; }
if($plasticfan == null){ $plasticfan = 0; }
if($reducer == null){ $reducer = 0; }
/*
echo "round_pan:" . $round_pan . "<br>";
echo "motor_bottom:" . $motor_bottom . "<br>";
echo "plasticfan:" . $plasticfan . "<br>";
echo "reducer:" . $reducer . "<br>";
echo "<br>";
*/

$cutting = $_POST['cutting']; // 커팅날	
$breaker = $_POST['breaker']; // 누전차단기	
$lamp_normal = $_POST['lamp_normal']; // 일반램프	
$lamp_led = $_POST['lamp_led']; // LED	
$lamp_uv = $_POST['lamp_uv']; // UV	
if($cutting == null){ $cutting = 0; }
if($breaker == null){ $breaker = 0; }
if($lamp_normal == null){ $lamp_normal = 0; }
if($lamp_led == null){ $lamp_led = 0; }
if($lamp_uv == null){ $lamp_uv = 0; }
/*
echo "cutting:" . $cutting . "<br>";
echo "breaker:" . $breaker . "<br>";
echo "lamp_normal:" . $lamp_normal . "<br>";
echo "lamp_led:" . $lamp_led . "<br>";
echo "lamp_uv:" . $lamp_uv . "<br>";
echo "<br>";
*/

$as_normal = $_POST['as_normal']; // 정기점검	
$as_etc = $_POST['as_etc']; // 기타점검	
if($as_normal == null){ $as_normal = 0; }
if($as_etc == null){ $as_etc = 0; }
/*
echo "as_normal:" . $as_normal . "<br>";
echo "as_etc:" . $as_etc . "<br>";
echo "<br>";
*/

$nyear = $_POST['nyear'];
$nmonth = $_POST['nmonth'];
$nday = $_POST['nday'];
$n_day = $nyear ."-". $nmonth ."-". $nday; // 등록일자	

$today = date("Y-m-d-H-i-s");
$aryDay = explode ("-", $today);
$nowH = $aryDay[3];
$nowM = $aryDay[4];
$nowS = $aryDay[5];

$n_time = $nowH .":". $nowM .":". $nowS; // 시간	
$m_day = $n_day; //
			
$useridx = $_POST['useridx']; 
$content = $_POST['content'];
$site_idx = $_POST['site_idx'];
$username = $username; 



$getTime = date("Ymdhis");
$target_dir = "picture/" . $site_idx;

if(!file_exists($target_dir)){
	mkdir($target_dir, 0777, true);
	chmod($target_dir, 0777);
}

//$file_nameNow1 = $_FILES['fileToUpload1']['name'];
$file_name1 = $useridx . "_" . $getTime .  "_1.jpg";
$tmp_file1 = $_FILES['fileToUpload1']['tmp_name'];
$file_path1 = $target_dir. '/'.$file_name1;


//$file_nameNow2 = $_FILES['fileToUpload2']['name'];
$file_name2 = $useridx . "_" . $getTime .  "_2.jpg";
$tmp_file2 = $_FILES['fileToUpload2']['tmp_name'];
$file_path2 = $target_dir. '/'.$file_name2;


$pandan_save = 0;
if (move_uploaded_file($tmp_file1, $file_path1)){
	//chmod($file_path1, 0777);
	$pandan_save = $pandan_save + 1;
	
	$imginfo1 = getimagesize($file_path1);
	$width1 = $imginfo1[0];
	$height1 = $imginfo1[1];
	
}else{
	$file_path1 = "pic_none.jpg";
	$width1 = "250";
	$height1 = "250";
}

if (move_uploaded_file($tmp_file2, $file_path2)){
	//chmod($file_path1, 0777);
	$pandan_save = $pandan_save + 1;
	
	$imginfo2 = getimagesize($file_path2);
	$width2 = $imginfo2[0];
	$height2 = $imginfo2[1];
	
}else{
	$file_path2 = "pic_none.jpg";
	$width2 = "250";
	$height2 = "250";
}
/*
echo "file_path1:" . $file_path1 . "<br>";
echo "file_path2:" . $file_path2 . "<br>";
*/

$sqlData = " insert into maintain set   node_idx = '$node_idx',
										node_id = '$node_id',
										node_name = '$node_name',
										site_idx = '$site_idx',
										site_name = '$site_name',	
										cap_top = '$cap_top',
										cap_round = '$cap_round',	
										cap_bottom = '$cap_bottom',	
										motor_top = '$motor_top',	
										motor_sinc = '$motor_sinc',	
										motor_spider = '$motor_spider',	
										round_pan = '$round_pan',
										motor_bottom = '$motor_bottom',	
										plasticfan = '$plasticfan',	
										reducer = '$reducer',	
										cutting = '$cutting',
										breaker = '$breaker',	
										lamp_normal = '$lamp_normal',	
										lamp_led = '$lamp_led',
										lamp_uv = '$lamp_uv',
										as_normal = '$as_normal',	
										as_etc = '$as_etc',	
										pic1 = '$file_path1',
										pic2 = '$file_path2',
										width1 = '$width1',
										height1 = '$height1',
										width2 = '$width2',
										height2 = '$height2',
										n_day = '$n_day',
										n_time = '$n_time',
										content = '$content',
										useridx = '$useridx',
										username = '$username',
										m_day = '$m_day' "; 

$resultID = query( $sqlData );
$idx = 0;
if ($resultID){
	//$idx = dbinstance()->insert_id;
	echo "<script>alert('등록 성공!');</script>";
	?>
	<html>
	<head>
	<meta http-equiv="refresh" content="0; url=maintain_list.php?pco_num=<?echo $site_idx;?>&sitename=<?echo site_name;?>" />
	</head>
	<body><center>
	<h2>잠시 기다려 주세요.</h2>
	</body>
	</html>
	<?
}else{
	echo "<script>alert('등록 실패!');history.back();</script>";
}


?>

<!--
<html>
<head>
<meta http-equiv="refresh" content="0; url=node_create.php" />
</head>
<body><center>
<h2>잠시 기다려 주세요.</h2>
</body>
</html>
-->

  		
  		
  		
  		
  		
  		
