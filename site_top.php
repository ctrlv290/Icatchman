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

$pco_num = $_GET["site_idx"];
$sitename = $_GET["sitename"];
?>

<html>
<head>
<title>ZAPSRMS</title>
</head>
<body bgcolor="#A2A2A2" topmargin=5>
<table>
<tr>
<td><span style="color:white;font-size:12pt;"><b><font color="black">[<?echo $sitename;?>] &nbsp;</span></td>
<td width=20> &nbsp;</td>
<td><a href="node_list.php?pco_num=<?echo $pco_num;?>&sitename=<?echo $sitename;?>" target="sitemain" style="text-decoration:none"><span style="color:white;font-size:12pt;">■ 리스트 보기 &nbsp;</span></td>
<td width=15> &nbsp;</td>
<td><a href="https://icatchman.com:3000/map/?pco_num=<?echo $pco_num;?>&site_name=<?echo $sitename;?>" target="sitemain" style="text-decoration:none"><span style="color:white;font-size:12pt;">■ 지도 보기 &nbsp;</span></td>
<td width=15> &nbsp;</td>
<?
if($level >= 2){
?>
<td><a href="node_manage.php?pco_num=<?echo $pco_num;?>" target="sitemain"  style="text-decoration:none"><span style="color:white;font-size:12pt;">■ 노드 관리 &nbsp;</span></td>
<td width=15> &nbsp;</td>
<?
}
?>

<td><a href="maintain_list.php?pco_num=<?echo $pco_num;?>&sitename=<?echo $sitename;?>" target="sitemain" style="text-decoration:none"><span style="color:white;font-size:12pt;">■ 유지 보수 &nbsp;</span></td>
<td width=15> &nbsp;</td>


</tr>
</table>

		
		
</body>
</html>



  		
  		
  		
  		
  		
  		
