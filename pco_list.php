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
<body bgcolor="#ffffff"  topmargin="0">
      
<Table width=100%>
<tr  background="webimg/table_top_blue.jpg">
	<td height=30 colspan=8><center><font color="white">사용자 목록</font></td>
</tr>
<tr  background="webimg/table_top_back.jpg">
	<td height=30 width="20%"><center>고유 번호</td>
	<td width="20%"><center>등록 일자</td>
	<td width="20%"><center>사용자 아이디</td>
	<td width="20%"><center>사용자 이름</td>
	<td width="20%"><center>접속 권한</td>
</tr>
<?
$sqlUser = " select * from userinfo where level < 8 ";
$rs_list 	= query( $sqlUser ); 
$cnt = 0;
while( $rw_list =  $rs_list ->fetch_array() ) {
		$t_useridx = $rw_list[useridx];
		$t_userid = $rw_list[userid];
		$t_password = $rw_list[password];
		$t_username = $rw_list[username];
		$i_level = $rw_list[level];
		$t_regday = $rw_list[regday];
		$t_etc = $rw_list[etc];
		$restcnt = $cnt % 2;
		if($restcnt == 0){
			$bgcolor = "#f8f8f8";
		}else{
			$bgcolor = "#ffffff";
		}
		
		$t_level = "없음";
		if($i_level == 0){
			$t_level = "고객";
		}else if($i_level == 1){
			$t_level = "담당자";
		}else if($i_level == 2){
			$t_level = "관리자";
		}else if($i_level == 3){
			$t_level = "책임관리자";
		}
		?>
		<tr bgcolor='<?echo $bgcolor;?>'>
		<td height=30><center><a href="pco_modify.php?useridx=<?echo $t_useridx;?>" style="text-decoration:none"><font color="black"><?echo $t_useridx;?></td>
		<td ><center><center><a href="pco_modify.php?useridx=<?echo $t_useridx;?>" style="text-decoration:none"><font color="black"><?echo $t_regday;?></td>
		<td ><center><center><a href="pco_modify.php?useridx=<?echo $t_useridx;?>" style="text-decoration:none"><font color="black"><?echo $t_userid;?></td>
		<td ><center><center><a href="pco_modify.php?useridx=<?echo $t_useridx;?>" style="text-decoration:none"><font color="black"><?echo $t_username;?></td>
		<td ><center><center><a href="pco_modify.php?useridx=<?echo $t_useridx;?>" style="text-decoration:none"><font color="black"><?echo $t_level;?></td>
		</tr>
		<?
}	
?>
</Table>







</body>
</html>
  		
  		
  		
  		
  		
  		
