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

?>
<html>
<head>
<title>ZAPSRMS</title>
</head>
<body bgcolor="#ffffff"  topmargin="0">
<form name="form1">

<Table width=100%>
<tr  background="webimg/table_top_blue.jpg">
	<td height=30 colspan=23><center><font color="white">유지 보수 목록</font></td>
</tr>

<tr>
<td align="left" colspan=23  bgcolor = "#f8f8f8"><center>
	<table width="100%" border="1" cellspacing="0"  cellspacing="1">
	<tr><td bgcolor="black"><center><font color="white">장비로 찾기</td></tr>
	<tr>
	<td>
		<table width="99%">
		<tr>
		<td>
		<select name="select_node" style="height:25pt; width:300px;">
		<?
		$sqlUser = " select * from node_list where pco_num = '".$get_pconum."' order by node_id asc ";
		$rs_list 	= query( $sqlUser );
		while( $rw_list =  $rs_list ->fetch_array() ) {
			$node_idx = $rw_list[idx];
			$node_name = $rw_list[node_name]; //장비번호
			?>
			<option value="<?echo $node_idx;?>"><?echo $node_name;?></option>
			<?
		}
		?>
		</select>
		<?
		if($level > 1){
		?>
		<input type="button" value="유지보수 등록하기" onclick="CreateMaintain(this.form);" style="color:white; width:100pt;height:25pt;background-color:#9D00BD;font-size:15px;">
		<?
		}
		?>
		</td>
		<td height="40"><center>시작일자</td>
		<td>
		<select name="n_syear" style="height:25pt;">
		<? 
		$today = date("Y-m-d");
		$aryDay = explode ("-", $today);
		$nowY = $aryDay[0];
		$nowM = $aryDay[1];
		$nowD = $aryDay[2];


		for($i = 2018; $i<=2030; $i++){ 
			if($i == $nowY){
			?><option value="<?echo $i;?>"  selected="selected"><?echo $i;?></option><?
			}else{
			?><option value="<?echo $i;?>"><?echo $i;?></option><?
			}
		}  
		?>
		</select>년 &nbsp;

		<select name="n_smonth" style="height:25pt;">
		<? 
		for($i = 1; $i<=12; $i++){ 
			if($i == $nowM){
			?><option value="<?echo $i;?>"  selected="selected"><?echo $i;?></option><?
			}else{
			?><option value="<?echo $i;?>"><?echo $i;?></option><?
			}
		}  
		?>
		</select>월 &nbsp;

		<select name="n_sday" style="height:25pt;">
		<? 
		for($i = 1; $i<=31; $i++){ 
			if($i == $nowD){
			?><option value="<?echo $i;?>"  selected="selected"><?echo $i;?></option><?
			}else{
			?><option value="<?echo $i;?>"><?echo $i;?></option><?
			} 
		}  
		?>
		</select>일 &nbsp;

		</td>
	
		<td width="50"><center><b>~</td>
		<td height="40"><center>종료일자</td>
		<td>
		<select name="n_eyear" style="height:25pt;">
		<? 
		for($i = 2018; $i<=2030; $i++){ 
			if($i == $nowY){
			?><option value="<?echo $i;?>"  selected="selected"><?echo $i;?></option><?
			}else{
			?><option value="<?echo $i;?>"><?echo $i;?></option><?
			}
		}  
		?>
		</select>년 &nbsp;

		<select name="n_emonth" style="height:25pt;">
		<? 
		for($i = 1; $i<=12; $i++){ 
			if($i == $nowM){
			?><option value="<?echo $i;?>"  selected="selected"><?echo $i;?></option><?
			}else{
			?><option value="<?echo $i;?>"><?echo $i;?></option><?
			}
		}  
		?>
		</select>월 &nbsp;

		<select name="n_eday" style="height:25pt;">
		<? 
		for($i = 1; $i<=31; $i++){ 
			if($i == $nowD){
			?><option value="<?echo $i;?>"  selected="selected"><?echo $i;?></option><?
			}else{
			?><option value="<?echo $i;?>"><?echo $i;?></option><?
			} 
		}  
		?>
		</select>일 &nbsp;
		</td>
		<td height="40" valign=middle><center>
		<input type="button" value="유지보수 기록보기" onclick="ListMaintain(this.form);" style="color:white; width:100pt;height:25pt;background-color:#058E7D;font-size:15px;">
		</td>
		</tr>
		</table>
	</td>
	</tr>
	</table>
	
	
</td>
</tr>


<tr>
<td align="cneter" colspan=23><cneter>
	<table width="100%" border="1" cellspacing="0"  cellspacing="1">
	<tr><td bgcolor="black"><center><font color="white">업무내용으로 찾기</td></tr>
	<tr>
	<td>
		<form action="maintain_create_recv.php" method="POST" enctype="multipart/form-data"  name="form1">
		<table width="90%">
		<tr>
		<td height="40"><input type="checkbox" name="cap_top" value="1">상캡</td>
		<td height="40"><input type="checkbox" name="cap_round" value="1">원형캡</td>
		<td height="40"><input type="checkbox" name="cap_bottom" value="1">하커버</td>
		<td height="40"><input type="checkbox" name="motor_top" value="1">상부팬모터</td>
		<td height="40"><input type="checkbox" name="motor_sinc" value="1">동기모터</td>
		<td height="40"><input type="checkbox" name="motor_spider" value="1">거미줄제거기</td>
		<td height="40"><input type="checkbox" name="round_pan" value="1">원형철판</td>
		<td height="40"><input type="checkbox" name="motor_bottom" value="1">모터</td>
		<td height="40"><input type="checkbox" name="plasticfan" value="1">플라스틱휀</td>
		<td height="40"><input type="checkbox" name="reducer" value="1">레두샤(리듀서)</td>
		<td height="40"><input type="checkbox" name="cutting" value="1">커팅날</td>
		<td height="40"><input type="checkbox" name="breaker" value="1">누전차단기</td>
		<td height="40"><input type="checkbox" name="lamp_normal" value="1">일반램프</td>
		<td height="40"><input type="checkbox" name="lamp_led" value="1">LED램프</td>
		<td height="40"><input type="checkbox" name="lamp_uv" value="1">UVLED램프</td>
		</tr>
		</table>
	
		<table>
		<tr bgcolor = "#f8f8f8">
		<td height="40"><center>시작일자</td>
		<td>
		<select name="syear" style="height:25pt;">
		<? 
		$today = date("Y-m-d");
		$aryDay = explode ("-", $today);
		$nowY = $aryDay[0];
		$nowM = $aryDay[1];
		$nowD = $aryDay[2];


		for($i = 2018; $i<=2030; $i++){ 
			if($i == $nowY){
			?><option value="<?echo $i;?>"  selected="selected"><?echo $i;?></option><?
			}else{
			?><option value="<?echo $i;?>"><?echo $i;?></option><?
			}
		}  
		?>
		</select>년 &nbsp;

		<select name="smonth" style="height:25pt;">
		<? 
		for($i = 1; $i<=12; $i++){ 
			if($i == $nowM){
			?><option value="<?echo $i;?>"  selected="selected"><?echo $i;?></option><?
			}else{
			?><option value="<?echo $i;?>"><?echo $i;?></option><?
			}
		}  
		?>
		</select>월 &nbsp;

		<select name="sday" style="height:25pt;">
		<? 
		for($i = 1; $i<=31; $i++){ 
			if($i == $nowD){
			?><option value="<?echo $i;?>"  selected="selected"><?echo $i;?></option><?
			}else{
			?><option value="<?echo $i;?>"><?echo $i;?></option><?
			} 
		}  
		?>
		</select>일 &nbsp;

		</td>
	
		<td width="50"><center><b>~</td>
		<td height="40"><center>종료일자</td>
		<td>
		<select name="eyear" style="height:25pt;">
		<? 
		for($i = 2018; $i<=2030; $i++){ 
			if($i == $nowY){
			?><option value="<?echo $i;?>"  selected="selected"><?echo $i;?></option><?
			}else{
			?><option value="<?echo $i;?>"><?echo $i;?></option><?
			}
		}  
		?>
		</select>년 &nbsp;

		<select name="emonth" style="height:25pt;">
		<? 
		for($i = 1; $i<=12; $i++){ 
			if($i == $nowM){
			?><option value="<?echo $i;?>"  selected="selected"><?echo $i;?></option><?
			}else{
			?><option value="<?echo $i;?>"><?echo $i;?></option><?
			}
		}  
		?>
		</select>월 &nbsp;

		<select name="eday" style="height:25pt;">
		<? 
		for($i = 1; $i<=31; $i++){ 
			if($i == $nowD){
			?><option value="<?echo $i;?>"  selected="selected"><?echo $i;?></option><?
			}else{
			?><option value="<?echo $i;?>"><?echo $i;?></option><?
			} 
		}  
		?>
		</select>일 &nbsp;
		</td>
		<td height="40" valign=middle><center>
		<!--<input type="submit" name="submit" value=" 검색하기 " style="font-size:12pt; color:white; width:100pt; height:25pt; background-color:#0078B8;">-->
		<input type="button" value="검색하기" onclick="SearchMaintain(this.form);" style="color:white; width:100pt;height:25pt;background-color:#0078B8;font-size:15px;">
		</td>
		</tr>
		</table>
		</form>
	</td>
	</tr>
	</table>
</td>
</tr>


<!--
idx
node_idx
node_id //보드번호
node_name //장비명
site_idx
site_name //사이트명
cap_top //상캡
cap_round //원형캡
cap_bottom //하커버
motor_top //상부팬모터
motor_sinc //동기모터
motor_spider //거미줄제거
round_pan //원형철판
motor_bottom //하부모터
plasticfan //플라스틱펜
reducer //레듀샤
cutting //커팅날
breaker //누전차단기
lamp_normal //일반램프
lamp_led //LED
lamp_uv //UV
as_normal //정기점검
as_etc //기타점검
pic1
pic2
n_day //등록일자
n_time //시간
content
useridx
username
m_day
<tr  background="webimg/table_top_back2.jpg" height="64">
-->


<tr>
	<td height=30 colspan=22> </td>
</tr>

<tr  bgcolor="silver" height="">
	<td height=30 width="3%"><center><span onclick="CheckAllBox(document.form1);">선택</span></td>
	<td width="5%"><center><span style="font-size:10pt;">장비명</td>
	<td width="5%"><center><span style="font-size:10pt;">보드번호</td>
	<td width="9%"><center><span style="font-size:10pt;">등록일자</td>
	<td width="5%"><center><span style="font-size:10pt;">등록자</td>
	<td width="4%"><center><span style="font-size:10pt;">상캡</td>
	<td width="4%"><center><span style="font-size:10pt;">원형캡</td>
	<td width="4%"><center><span style="font-size:10pt;">하커버</td>
	<td width="4%"><center><span style="font-size:10pt;">상부<br>팬모터</td>
	<td width="4%"><center><span style="font-size:10pt;">동기<br>모터</td>
	<td width="4%"><center><span style="font-size:10pt;">거미줄<br>제거</td>
	<td width="4%"><center><span style="font-size:10pt;">원형<br>철판</td>
	<td width="4%"><center><span style="font-size:10pt;">하부<br>모터</td>
	<td width="4%"><center><span style="font-size:10pt;">펜</td>
	<td width="4%"><center><span style="font-size:10pt;">레듀샤</td>
	<td width="4%"><center><span style="font-size:10pt;">커팅날</td>
	<td width="4%"><center><span style="font-size:10pt;">누전<br>차단기</td>
	<td width="4%"><center><span style="font-size:10pt;">일반<br>램프</td>
	<td width="4%"><center><span style="font-size:10pt;">LED</td>
	<td width="4%"><center><span style="font-size:10pt;">UV</td>
	<td width="4%"><center><span style="font-size:10pt;">정기<br>점검</td>
	<td width="4%"><center><span style="font-size:10pt;">기타<br>점검</td>
	<td width="5%"><center><span style="font-size:10pt;">사진<br>(전/후)</td>
</tr>
<?
$nowtoday = date("Y-m-d");
/*
$nowY = $aryDay[0] * 1;
$nowM = $aryDay[1] * 1;
$nowD = $aryDay[2] * 1;
$nowtoday = $nowY ."-". $nowM ."-".$nowD;
*/
$sqlMaintain = " select * from maintain where site_idx = '".$get_pconum."' AND n_day = '".$nowtoday."' order by idx asc ";
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
	
	if($cap_top == 1){$cap_top="check_on.png";}else{$cap_top="check_off.png";}
	if($cap_round == 1){$cap_round="check_on.png";}else{$cap_round="check_off.png";}
	if($cap_bottom == 1){$cap_bottom="check_on.png";}else{$cap_bottom="check_off.png";}
	if($motor_top == 1){$motor_top="check_on.png";}else{$motor_top="check_off.png";}
	if($motor_sinc == 1){$motor_sinc="check_on.png";}else{$motor_sinc="check_off.png";}
	if($motor_spider == 1){$motor_spider="check_on.png";}else{$motor_spider="check_off.png";}
	if($round_pan == 1){$round_pan="check_on.png";}else{$round_pan="check_off.png";}
	if($motor_bottom == 1){$motor_bottom="check_on.png";}else{$motor_bottom="check_off.png";}
	if($plasticfan == 1){$plasticfan="check_on.png";}else{$plasticfan="check_off.png";}
	if($reducer == 1){$reducer="check_on.png";}else{$reducer="check_off.png";}
	if($cutting == 1){$cutting="check_on.png";}else{$cutting="check_off.png";}
	if($breaker == 1){$breaker="check_on.png";}else{$breaker="check_off.png";}
	if($lamp_normal == 1){$lamp_normal="check_on.png";}else{$lamp_normal="check_off.png";}
	if($lamp_led == 1){$lamp_led="check_on.png";}else{$lamp_led="check_off.png";}
	if($lamp_uv == 1){$lamp_uv="check_on.png";}else{$lamp_uv="check_off.png";}
	if($as_normal == 1){$as_normal="check_on.png";}else{$as_normal="check_off.png";}
	if($as_etc == 1){$as_etc="check_on.png";}else{$as_etc="check_off.png";}
	if($pic1 == "pic_none.jpg"){$pic1="check_off.png";}else{$pic1="check_on.png";}
	if($pic2 == "pic_none.jpg"){$pic2="check_off.png";}else{$pic2="check_on.png";}
	
	$restcnt = $cnt % 2;
	if($restcnt == 0){
		$bgcolor = "#ffffff";
	}else{
		$bgcolor = "#f8f8f8";
	}
	$cnt = $cnt + 1;
	?>
	<tr  bgcolor="<?echo $bgcolor;?>" height="25">
	<td height=30><center><input type="checkbox" name="checkB" value="<?echo $node_idx;?>"></td>
	<td><center><span style="font-size:10pt;"><a href="maintain_show_detail.php?nodeidx=<?echo $node_idx;?>&maintainidx=<?echo $idx;?>" style="text-decoration:none" target="_new"><font color="black"><?echo $node_name;?></a></td> <!--장비명 -->
	<td><center><span style="font-size:10pt;"><?echo $node_id;?></td> <!--보드번호 -->
	<td><center><span style="font-size:10pt;"><?echo $n_day;?> <?echo $n_time;?></td> <!--등록일자 -->
	<td><center><span style="font-size:10pt;"><?echo $username;?></td> <!--등록자 -->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $cap_top;?>" border=0 width="25" height="25"></td> <!--상캡 -->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $cap_round;?>" border=0 width="25" height="25"></td> <!--원형캡 -->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $cap_bottom;?>" border=0 width="25" height="25"></td> <!--하커버 -->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $motor_top;?>" border=0 width="25" height="25"></td> <!--상부팬모터 -->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $motor_sinc;?>" border=0 width="25" height="25"></td> <!--동기모터 -->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $motor_spider;?>" border=0 width="25" height="25"></td> <!--거미줄제거 -->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $round_pan;?>" border=0 width="25" height="25"></td> <!--원형철판 -->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $motor_bottom;?>" border=0 width="25" height="25"></td> <!--하부모터 -->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $plasticfan;?>" border=0 width="25" height="25"></td> <!--펜 -->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $reducer;?>" border=0 width="25" height="25"></td> <!--레듀샤 -->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $cutting;?>" border=0 width="25" height="25"></td> <!--커팅날 -->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $breaker;?>" border=0 width="25" height="25"></td> <!--누전차단기 -->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $lamp_normal;?>" border=0 width="25" height="25"></td> <!--일반램프 -->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $lamp_led;?>" border=0 width="25" height="25"></td> <!--LED -->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $lamp_uv;?>" border=0 width="25" height="25"></td> <!--UV -->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $as_normal;?>" border=0 width="25" height="25"></td> <!--정기 점검-->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $as_etc;?>" border=0 width="25" height="25"></td> <!--기타 점검-->
	<td><center><span style="font-size:10pt;"><img src="webimg/<?echo $pic1;?>" border=0 width="25" height="25"><img src="webimg/<?echo $pic2;?>" border=0 width="25" height="25"></td> <!--사진(전/후) -->
	</tr>
	<?
}
	
?>

</Table>
</form>



<script type="text/javascript">
<!--

function CreateMaintain(thisform)
{
    
		
	var form = document.createElement("form");
	form.setAttribute("charset", "UTF-8");
	form.setAttribute("method", "Get"); // Get 또는 Post 입력
	form.setAttribute("action", "maintain_create.php");
	
	var sel_node = thisform.select_node.value;
	
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "nodeidx");
	hiddenField.setAttribute("value", sel_node);
	form.appendChild(hiddenField);
	
	document.body.appendChild(form);

	form.submit();

}

function ListMaintain(thisform)
{
    
		
	var form = document.createElement("form");
	form.setAttribute("charset", "UTF-8");
	form.setAttribute("method", "Get"); // Get 또는 Post 입력
	form.setAttribute("action", "maintain_list_node.php");
	
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "pco_num");
	hiddenField.setAttribute("value", "<?echo $get_pconum;?>");
	form.appendChild(hiddenField);
	
	var sel_node = thisform.select_node.value;
	
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "nodeidx");
	hiddenField.setAttribute("value", sel_node);
	form.appendChild(hiddenField);
	
	var sel_syear = thisform.n_syear.value;
	var sel_smonth = thisform.n_smonth.value;
	var sel_sday = thisform.n_sday.value;
	var sel_eyear = thisform.n_eyear.value;
	var sel_emonth = thisform.n_emonth.value;
	var sel_eday = thisform.n_eday.value;
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "n_syear"); hiddenField.setAttribute("value", sel_syear); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "n_smonth"); hiddenField.setAttribute("value", sel_smonth); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "n_sday"); hiddenField.setAttribute("value", sel_sday); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "n_eyear"); hiddenField.setAttribute("value", sel_eyear); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "n_emonth"); hiddenField.setAttribute("value", sel_emonth); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "n_eday"); hiddenField.setAttribute("value", sel_eday); form.appendChild(hiddenField);
	
	
	document.body.appendChild(form);

	form.submit();

}

function SearchMaintain(thisform)
{
    
		
	var form = document.createElement("form");
	form.setAttribute("charset", "UTF-8");
	form.setAttribute("method", "Post"); // Get 또는 Post 입력
	form.setAttribute("action", "maintain_list_option.php");
	
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "pco_num");
	hiddenField.setAttribute("value", "<?echo $get_pconum;?>");
	form.appendChild(hiddenField);
	
	var sel_cap_top = 0; if(thisform.cap_top.checked){ sel_cap_top = 1; }
	var sel_cap_round = 0; if(thisform.cap_round.checked){ sel_cap_round = 1; }
	var sel_cap_bottom = 0; if(thisform.cap_bottom.checked){ sel_cap_bottom = 1; }
	var sel_motor_top = 0; if(thisform.motor_top.checked){ sel_motor_top = 1; }
	var sel_motor_sinc = 0; if(thisform.motor_sinc.checked){ sel_motor_sinc = 1; }
	var sel_motor_spider = 0; if(thisform.motor_spider.checked){ sel_motor_spider = 1; }
	var sel_round_pan = 0; if(thisform.round_pan.checked){ sel_round_pan = 1; }
	var sel_motor_bottom = 0; if(thisform.motor_bottom.checked){ sel_motor_bottom = 1; }
	var sel_plasticfan = 0; if(thisform.plasticfan.checked){ sel_plasticfan = 1; }
	var sel_reducer = 0; if(thisform.reducer.checked){ sel_reducer = 1; }
	var sel_cutting = 0; if(thisform.cutting.checked){ sel_cutting = 1; }
	var sel_breaker = 0; if(thisform.breaker.checked){ sel_breaker = 1; }
	var sel_lamp_normal = 0; if(thisform.lamp_normal.checked){ sel_lamp_normal = 1; }
	var sel_lamp_led = 0; if(thisform.lamp_led.checked){ sel_lamp_led = 1; }
	var sel_lamp_uv = 0; if(thisform.lamp_uv.checked){ sel_lamp_uv = 1; }
	
	
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "cap_top"); hiddenField.setAttribute("value", sel_cap_top); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "cap_round"); hiddenField.setAttribute("value", sel_cap_round); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "cap_bottom"); hiddenField.setAttribute("value", sel_cap_bottom); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "motor_top"); hiddenField.setAttribute("value", sel_motor_top); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "motor_sinc"); hiddenField.setAttribute("value", sel_motor_sinc); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "motor_spider"); hiddenField.setAttribute("value", sel_motor_spider); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "round_pan"); hiddenField.setAttribute("value", sel_round_pan); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "motor_bottom"); hiddenField.setAttribute("value", sel_motor_bottom); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "plasticfan"); hiddenField.setAttribute("value", sel_plasticfan); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "reducer"); hiddenField.setAttribute("value", sel_reducer); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "cutting"); hiddenField.setAttribute("value", sel_cutting); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "breaker"); hiddenField.setAttribute("value", sel_breaker); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "lamp_normal"); hiddenField.setAttribute("value", sel_lamp_normal); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "lamp_led"); hiddenField.setAttribute("value", sel_lamp_led); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "lamp_uv"); hiddenField.setAttribute("value", sel_lamp_uv); form.appendChild(hiddenField);
	
	

	
	var sel_syear = thisform.syear.value;
	var sel_smonth = thisform.smonth.value;
	var sel_sday = thisform.sday.value;
	var sel_eyear = thisform.eyear.value;
	var sel_emonth = thisform.emonth.value;
	var sel_eday = thisform.eday.value;
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "syear"); hiddenField.setAttribute("value", sel_syear); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "smonth"); hiddenField.setAttribute("value", sel_smonth); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "sday"); hiddenField.setAttribute("value", sel_sday); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "eyear"); hiddenField.setAttribute("value", sel_eyear); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "emonth"); hiddenField.setAttribute("value", sel_emonth); form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input"); hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "eday"); hiddenField.setAttribute("value", sel_eday); form.appendChild(hiddenField);
	
	
	document.body.appendChild(form);

	form.submit();

}

function UpdateUseOn(thisform)
{
        //'확인' 버튼을 클릭했을 때 실행되는 메서드
    var devidx = "";
        
	for( var i=0; i<thisform.checkB.length; i++) 
	{ 
		var check = thisform.checkB[i]; 
		if(check.checked == true){ 
			devidx = devidx + check.value + ',';
		}
	} 
	//alert(devidx + "\n" +usevalue);
		
	var form = document.createElement("form");
	form.setAttribute("charset", "UTF-8");
	form.setAttribute("method", "Post"); // Get 또는 Post 입력
	form.setAttribute("action", "node_update_useon.php");

	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "device");
	hiddenField.setAttribute("value", devidx);
	form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "get_pconum");
	hiddenField.setAttribute("value", "<?echo $get_pconum;?>");
	form.appendChild(hiddenField);
	
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "onoff");
	hiddenField.setAttribute("value", "1");
	form.appendChild(hiddenField);
	
	document.body.appendChild(form);

	form.submit();

}

function CheckAllBox(thisform)
{
	//alert("CheckAllBox");
	
	var check = thisform.checkB[0];
	if(check.checked == true){ 
		for( var i=0; i<thisform.checkB.length; i++) 
		{ 
			thisform.checkB[i].checked = false; 
		} 
	
	}else{
		for( var i=0; i<thisform.checkB.length; i++) 
		{ 
			thisform.checkB[i].checked = true; 
		} 
	}
}

</script>


</body>
</html>
  		
  		
  		
  		
  		
  		
