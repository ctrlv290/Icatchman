<?
include ("dbcon_pharmcle.php");


$getTime = date("Ymdhis");
$site_idx = 1;
$user_idx = 22;

echo $getTime;


$target_dir = "picture/" . $site_idx;

if(!file_exists($target_dir)){
	mkdir($target_dir, 0777, true);
	chmod($target_dir, 0777);
}

//$file_nameNow1 = $_FILES['fileToUpload1']['name'];
//$file_name1 = $getTime . "_" . $file_nameNow1;
$file_name1 = $user_idx . "_" . $getTime .  "_1.jpg";

$tmp_file1 = $_FILES['fileToUpload1']['tmp_name'];
$file_path1 = $target_dir. '/'.$file_name1;


//$file_nameNow2 = $_FILES['fileToUpload2']['name'];
//$file_name2 = $getTime . "_" . $file_nameNow2;
$file_name2 = $user_idx . "_" . $getTime .  "_2.jpg";

$tmp_file2 = $_FILES['fileToUpload2']['tmp_name'];
$file_path2 = $target_dir. '/'.$file_name2;


$pandan_save = 0;
if (move_uploaded_file($tmp_file1, $file_path1)){
	//chmod($file_path1, 0777);
	$pandan_save = $pandan_save + 1;
}

if (move_uploaded_file($tmp_file2, $file_path2)){
	//chmod($file_path1, 0777);
	$pandan_save = $pandan_save + 1;
}


if($pandan_save == 2){
	?>
	<script>
	alert('Success!');
	history.back();
	</script>
	<?
}else{
	?>
	<script>
	alert('Fail!');
	history.back();
	</script>
	<?
}

?>

  		
  		
  		
  		
  		
  		
