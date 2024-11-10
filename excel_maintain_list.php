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

$get_pconum = $_GET["pco_num"]; //시리얼번호
$get_nodeidx = $_GET["nodeidx"];

$n_syear = $_GET["n_syear"];
$n_smonth = $_GET["n_smonth"];
$n_sday = $_GET["n_sday"];
$n_eyear = $_GET["n_eyear"];
$n_emonth = $_GET["n_emonth"];
$n_eday = $_GET["n_eday"];

$get_nodeidx = $_GET["targetidx"];
$fs_day = $_GET["startDay"];
$es_day = $_GET["endDay"];

?>

<?
header( "Content-type: application/vnd.ms-excel" ); 
header( "Content-type: application/vnd.ms-excel; charset=utf-8");
header( "Content-Disposition: attachment; filename = 유지보수내역.xls" ); 
header( "Content-Description: PHP4 Generated Data" );
?>

<?
// 테이블 상단 만들기
$EXCEL_STR = "
<table border='1'>
<tr>
   <td>장비명</td>
	<td>보드번호</td>
	<td>등록일자</td>
	<td>등록자</td>
	<td>상캡</td>
	<td>원형캡</td>
	<td>하커버</td>
	<td>상부<br>팬모터</td>
	<td>동기<br>모터</td>
	<td>거미줄<br>제거</td>
	<td>원형<br>철판</td>
	<td>하부<br>모터</td>
	<td>펜</td>
	<td>레듀샤</td>
	<td>커팅날</td>
	<td>누전<br>차단기</td>
	<td>일반<br>램프</td>
	<td>LED</td>
	<td>UV</td>
	<td>정기<br>점검</td>
	<td>기타<br>점검</td>
</tr>";
//위에 talbe은 자신이 가져올 값들의 컬럼 명이 되겠다.

$nowtoday = date("Y-m-d");
$sqlMaintain = " select * from maintain where node_idx = '".$get_nodeidx."'  AND n_day >= '".$fs_day."' AND n_day <='".$es_day."' order by idx desc ";
$rs_maintain 	= query( $sqlMaintain );

$cnt = 0;
while( $rw_maintain =  $rs_maintain ->fetch_array() ) {
	$idx = $rw_maintain['idx'];
	$node_idx = $rw_maintain['node_idx'];
	$node_id = $rw_maintain['node_id']; //보드번호
	$node_name = $rw_maintain['node_name']; //장비명
	$site_idx = $rw_maintain['site_idx'];
	$site_name = $rw_maintain['site_name']; //사이트명
	$cap_top = $rw_maintain['cap_top']; //상캡
	$cap_round = $rw_maintain['cap_round']; //원형캡
	$cap_bottom = $rw_maintain['cap_bottom']; //하커버
	$motor_top = $rw_maintain['motor_top']; //상부팬모터
	$motor_sinc = $rw_maintain['motor_sinc']; //동기모터
	$motor_spider = $rw_maintain['motor_spider']; //거미줄제거
	$round_pan = $rw_maintain['round_pan']; //원형철판
	$motor_bottom = $rw_maintain['motor_bottom']; //하부모터
	$plasticfan = $rw_maintain['plasticfan']; //플라스틱펜
	$reducer = $rw_maintain['reducer']; //레듀샤
	$cutting = $rw_maintain['cutting']; //커팅날
	$breaker = $rw_maintain['breaker']; //누전차단기
	$lamp_normal = $rw_maintain['lamp_normal']; //일반램프
	$lamp_led = $rw_maintain['lamp_led']; //LED
	$lamp_uv = $rw_maintain['lamp_uv']; //UV
	$as_normal = $rw_maintain['as_normal']; //정기점검
	$as_etc = $rw_maintain['as_etc']; //기타점검
	$pic1 = $rw_maintain['pic1'];
	$pic2 = $rw_maintain['pic2'];
	$n_day = $rw_maintain['n_day']; //등록일자
	$n_time = $rw_maintain['n_time']; //시간
	$content = $rw_maintain['content'];
	$useridx = $rw_maintain['useridx'];
	$username = $rw_maintain['username'];
	$m_day = $rw_maintain['m_day'];
	
	
	
 	

	 	$EXCEL_STR .= "
	 	<tr>
   		<td>".$node_name."</td>
		<td>".$node_id."</td>
		<td>".$n_day."</td>
		<td>".$username."</td>
		<td>".$cap_top."</td>
		<td>".$cap_round."</td>
		<td>".$cap_bottom."</td>
		<td>".$motor_top."</td>
		<td>".$motor_sinc."</td>
		<td>".$motor_spider."</td>
		<td>".$round_pan."</td>
		<td>".$motor_bottom."</td>
		<td>".$plasticfan."</td>
		<td>".$reducer."</td>
		<td>".$cutting."</td>
		<td>".$breaker."</td>
		<td>".$lamp_normal."</td>
		<td>".$lamp_led."</td>
		<td>".$lamp_uv."</td>
		<td>".$as_normal."</td>
		<td>".$as_etc."</td>
		</tr>
   		";

	
}


$EXCEL_STR .= "</table>";


echo "<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'> ";
echo $EXCEL_STR;
?>

  		
  		
  		
  		
  		
  		
