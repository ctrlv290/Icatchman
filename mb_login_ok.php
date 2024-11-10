<?
include ("dbcon_pharmcle.php");

$userid = $_POST["userid"];
$passwd = $_POST["passwd"];


$sqlUser = " select * from userinfo where userid = '$userid' AND password = '$passwd' ";
$rs_list 	= query( $sqlUser ); 
$cnt = 0;
while( $rw_list =  $rs_list ->fetch_array() ) {
		$useridx = $rw_list[useridx];
		$userid = $rw_list[userid];
		$username = $rw_list[username];
		$level = $rw_list[level];
		$refidx = $rw_list[refidx];
		$cnt = $cnt + 1;
}

if($cnt > 0){
	session_start();
	$_SESSION['useridx'] = $useridx;
	$_SESSION['userid'] = $userid;
	$_SESSION['username'] = $username;
	$_SESSION['level'] = $level;
	$_SESSION['refidx'] = $refidx;
	
	setcookie('useridx_ck', $useridx, time() + 86400);
	
	echo "<meta http-equiv='refresh' content='0;url=mb_main_left.php'>";
	exit;
	
}else{
	echo "<script>alert('아이디 또는 패스워드가 잘못되었습니다.');history.back();</script>"; //"<meta http-equiv='refresh' content='0;url=login.php'>";
	exit;
}

?>

  		
  		
  		
  		
  		
  		
