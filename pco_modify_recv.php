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


$r_useridx = $_POST["useridx"];
$r_username = $_POST["username"];
$r_userid = $_POST["userid"];
$r_pwd = $_POST["pwd"];
$r_pwdcnf = $_POST["pwdcnf"];
$r_contact = $_POST["contact"];
$r_email = $_POST["email"];
$r_level = $_POST["level"];
$r_description = $_POST["description"];

if($r_pwd != $r_pwdcnf){
	echo "<script>alert('비밀번호가 일치하지 않습니다.');history.back();</script>";
	exit;
}

$today = date("Y-m-d");
$sqlData = " update userinfo set userid = '$r_userid',
								password = '$r_pwd',
								username = '$r_username',
								level = '$r_level',
								description = '$r_description',
								phone = '$r_contact',
								email = '$r_email',
								modiday = '$today' where useridx = '$r_useridx'  ";
$resultID = query( $sqlData );




$sqlUser = " select * from userinfo where useridx = '". $r_useridx . "' ";
$rs_list 	= query( $sqlUser ); 
$cnt = 0;
while( $rw_list =  $rs_list ->fetch_array() ) {
		$t_useridx = $rw_list[useridx];
		$t_userid = $rw_list[userid];
		$t_password = $rw_list[password];
		$t_username = $rw_list[username];
		$t_level = $rw_list[level];
		$t_regday = $rw_list[regday];
		$t_etc = $rw_list[etc];
		$t_phone = $rw_list[phone];
		$t_email = $rw_list[email];
		$t_description = $rw_list[description];
}

?>

<!DOCTYPE html>
<html>
<head>
 
<head>
<body>
<form action="pco_modify_recv.php" method="POST" enctype="multipart/form-data"  name="form1">
<input type="hidden" name="useridx" value="<?echo $t_useridx;?>">
<table>
<tr background="webimg/table_top_back.jpg">
<td colspan=2 height="30"><center>사용자 정보 수정하기</td>
</tr>
<tr bgcolor = "#ffffff">
<td height="40" width="100" align=right>사용자 이름</td>
<td width="500"><input type="text" name="username" value="<?echo $t_username;?>" size="30" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40" align=right>사용 아이디</td>
<td><input type="text" name="userid" value="<?echo $t_userid;?>" size="30" style="height:20pt;">(영문)</td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40" align=right>패스워드</td>
<td><input type="password" name="pwd" value="<?echo $t_password;?>" size="30" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40" align=right>패스워드 확인</td>
<td><input type="password" name="pwdcnf" value="" size="30" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40" align=right>연락처</td>
<td><input type="text" name="contact" value="<?echo $t_phone;?>" size="30" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40" align=right>이메일</td>
<td><input type="text" name="email" value="<?echo $t_email;?>" size="70" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40" align=right>소속</td>
<td><input type="text" name="description" value="<?echo $t_description;?>" size="70" style="height:20pt;"></td>
</tr>


<tr bgcolor = "#f8f8f8">
<td height="40" align=right>권한설정</td>
<td>
	<select name="level" style="height:20pt; width:95%;">
		<?
		if($t_level == 0){
		?>
		<option value="0" selected="selected">고객</option>
		<option value="1">담당자</option>
		<option value="2">관리자</option>
		<option value="3">책임관리자</option>
		<?
		}else if($t_level == 1){
		?>
		<option value="0">고객</option>
		<option value="1" selected="selected">담당자</option>
		<option value="2">관리자</option>
		<option value="3">책임관리자</option>
		<?
		}else if($t_level == 2){
		?>
		<option value="0">고객</option>
		<option value="1">담당자</option>
		<option value="2" selected="selected">관리자</option>
		<option value="3">책임관리자</option>
		<?
		}else if($t_level == 3){
		?>
		<option value="0">고객</option>
		<option value="1">담당자</option>
		<option value="2">관리자</option>
		<option value="3" selected="selected">책임관리자</option>
		<?
		}else{
		?>
		<option value="0">고객</option>
		<option value="1">담당자</option>
		<option value="2">관리자</option>
		<option value="3">책임관리자</option>
		<?
		}
		?>
	</select>
</td>
</tr>

<tr>
<td colspan="2" height="40" valign=middle><center><input type="submit" name="submit" value=" 사용자 정보 수정하기 " style="font-size:12pt; color:white; width:200pt; height:25pt; background-color:#0078B8;"></td>
</tr>

</table>
</form>


</body>
</html>
  		
  		
  		
  		
  		
  		
