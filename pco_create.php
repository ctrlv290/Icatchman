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
?>
<!DOCTYPE html>
<html>
<head>
 
<head>
<body>
<form action="pco_create_recv.php" method="POST" enctype="multipart/form-data"  name="form1">
<input type="hidden" name="useridx" value="<?echo $user_idx;?>">
<table>
<tr background="webimg/table_top_back.jpg">
<td colspan=2 height="30"><center>사용자 등록하기</td>
</tr>
<tr bgcolor = "#ffffff">
<td height="40" width="100" align=right>사용자 이름</td>
<td width="500"><input type="text" name="username" value="" size="30" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40" align=right>사용 아이디</td>
<td><input type="text" name="userid" value="" size="30" style="height:20pt;">(영문)</td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40" align=right>패스워드</td>
<td><input type="password" name="pwd" value="" size="30" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40" align=right>패스워드 확인</td>
<td><input type="password" name="pwdcnf" value="" size="30" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40" align=right>연락처</td>
<td><input type="text" name="contact" value="" size="30" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#f8f8f8">
<td height="40" align=right>이메일</td>
<td><input type="text" name="email" value="" size="70" style="height:20pt;"></td>
</tr>

<tr bgcolor = "#ffffff">
<td height="40" align=right>소속</td>
<td><input type="text" name="description" value="" size="70" style="height:20pt;"></td>
</tr>


<tr bgcolor = "#f8f8f8">
<td height="40" align=right>권한설정</td>
<td>
	<select name="level" style="height:20pt; width:95%;">
		<option value="0">고객</option>
		<option value="1">담당자</option>
		<option value="2">관리자</option>
		<option value="3">책임관리자</option>
	</select>
</td>
</tr>

<tr>
<td colspan="2" height="40" valign=middle><center><input type="submit" name="submit" value=" 사용자 등록하기 " style="font-size:12pt; color:white; width:200pt; height:25pt; background-color:#0078B8;"></td>
</tr>

</table>
</form>


</body>
</html>
  		
  		
  		
  		
  		
  		
