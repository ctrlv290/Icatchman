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
$refidx = $_SESSION['refidx'];

if($level < 3){
	echo "<script>alert('관리 권한이 없습니다.');history.back();</script>"; //"<meta http-equiv='refresh' content='0;url=login.php'>";
	exit;
}

?>
<html>
<head>
<title>ZAPSRMS</title>
</head>
<body bgcolor="#ffffff"  topmargin="0">
<form action="client_list_create_recv.php" method="POST" enctype="multipart/form-data"  name="form1">
<input type="hidden" name="ref_useridx" value="<?echo $useridx;?>">
<Table width=100%>
<tr  background="webimg/table_top_blue.jpg">
	<td height=30 colspan=4><center><font color="white">고객 등록하기</font></td>
</tr>
<tr  background="webimg/table_top_back.jpg">
	<td height=30  width="50%"><center>고객 아이디</td>
	<td width="50%"><center>적용 사이트</td>
</tr>
<tr>
	<td height=30  width="50%"><center>
	<select name="client_id" style="height:25pt; width:90%;">
		<?
		$sqlUser = " select * from userinfo where level = '0' ";
		$rs_list 	= query( $sqlUser ); 
		while( $rw_list =  $rs_list ->fetch_array() ) {
			$client_id = $rw_list[useridx];
			$userid = $rw_list[userid];
			$username = $rw_list[username];
	
			?>
			<option value="<?echo $client_id;?>/<?echo $username;?>"><?echo $username;?> (<?echo $userid;?>)</option>
			<?
		}	
		?>
	</select>
	</td>
	<td width="50%"><center>
	<select name="site_id" style="height:25pt; width:90%;">
		<?
		if($level == 9){
			$sqlUser = " select * from site_list ";
		}else{
			$sqlUser = " select * from site_list where useridx = '". $useridx . "' ";
		}
		$rs_list 	= query( $sqlUser ); 
		while( $rw_list =  $rs_list ->fetch_array() ) {
			$site_idx = $rw_list[siteidx];
			$sitename = $rw_list[sitename];
	
			?>
			<option value="<?echo $site_idx;?>/<?echo $sitename;?>"><?echo $sitename;?></option>
			<?
		}	
		?>
	</select>
	</td>
</tr>
<tr>
	<td height=30 colspan=4><center><input type="submit" name="submit" value=" 등록하기 " style="font-size:12pt; color:white; width:200pt; height:25pt; background-color:#0078B8;"></td>
</tr>
</table>
</form>



<br>
<Table width=100%>
<tr  background="webimg/table_top_blue.jpg">
	<td height=30 colspan=5><center><font color="white">고객 목록</font></td>
</tr>
<tr  background="webimg/table_top_back.jpg">
	<td height=30 width="8%"><center>#</td>
	<td width="8%"><center></td>
	<td width="28%"><center>등록 일자</td>
	<td width="28%"><center>고객 이름</td>
	<td width="28%"><center>사이트 이름</td>
</tr>
<?
$sqlUser = " select * from client_list where ref_useridx = '". $useridx . "' order by clientidx asc ";
$rs_list 	= query( $sqlUser ); 
$cnt = 1;
while( $rw_list =  $rs_list ->fetch_array() ) {
	$clientidx = $rw_list[clientidx];
	$regday = $rw_list[regday];
	$ref_useridx = $rw_list[ref_useridx];
	$client_id = $rw_list[client_id];	
	$client_name = $rw_list[client_name];
	$site_idx = $rw_list[site_idx];
	$site_name = $rw_list[site_name];
	$restcnt = $cnt % 2;
	if($restcnt == 0){
		$bgcolor = "#f8f8f8";
	}else{
		$bgcolor = "#ffffff";
	}

	?>
	<tr bgcolor='<?echo $bgcolor;?>'>
	<td height=30><center><?echo $cnt;?></td>
	<!--
	<td><center><a href="client_list_delete.php?idx=<?echo $clientidx;?>"><img src="webimg/icon_sub.jpg" border=0 width=25 height=25></a></td>
	-->

	<td><center><a href=""><img src="webimg/icon_sub.jpg" border=0 width=25 height=25 onclick="DeleteClient('<?echo $clientidx;?>');"></td>

	<td><center><?echo $regday;?></td>
	<td><center><?echo $client_name;?></td>
	<td><center><?echo $site_name;?></td>
	</tr>
	<?
	$cnt = $cnt + 1;
}	
?>
</Table>


<script type="text/javascript">
<!--

function DeleteClient(idx)
{
	//alert("devidx:" +idx);
	
	var con_test = confirm("정말 삭제 하시겠습니까? \n삭제 후 복원이 불가능합니다.");
	if(con_test){
  		var form = document.createElement("form");
		form.setAttribute("charset", "UTF-8");
		form.setAttribute("method", "Post"); // Get 또는 Post 입력
		form.setAttribute("action", "client_list_delete.php");

		var hiddenField = document.createElement("input");
		hiddenField.setAttribute("type", "hidden");
		hiddenField.setAttribute("name", "idx");
		hiddenField.setAttribute("value", idx);
		form.appendChild(hiddenField);
	
		document.body.appendChild(form);

		form.submit();
	}
	
	
}

</script>



</body>
</html>
  		
  		
  		
  		
  		
  		
