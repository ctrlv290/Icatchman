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

$pco_num = $_POST["pco_num"]; //사이트명
$lat = $_POST["lat"];
$lon = $_POST["lon"];
$channel = $_POST["channel"];




// 저장될 디렉토리
$upfile_dir = "./data";

//CSV데이타 추출시 한글깨짐방지
setlocale(LC_CTYPE, 'ko_KR.eucKR'); // CSV 한글 깨짐 문제
    
//장시간 데이터 처리될경우
set_time_limit(0);

$upfile_name = $_FILES['upfile']['name']; // 파일이름
$upfile_type = $_FILES['upfile']['type']; // 확장자
$upfile_size = $_FILES['upfile']['size']; // 파일크기
$upfile_tmp  = $_FILES['upfile']['tmp_name']; // 임시 디렉토리에 저장된 파일명
//echo "upfile_name = ". $upfile_name ."<br>";
//echo "upfile_type = ". $upfile_type ."<br>";
//echo "upfile_size = ". $upfile_size ."<br>";
//echo "upfile_tmp  = ". $upfile_tmp ."<br>";
$uploadfile = $uploaddir . $_FILES['userfile']['name'];

//echo "uploadfile  = ". $uploadfile ."<br>";


//확장자 확인
if(preg_match("/(\.(csv|CSV))$/i",$upfile_name)) {
	//echo "확장자확인 OK / upfile_name: " . $upfile_name . "<br>";
	
} else {
    echo ("<script>window.alert('업로드를 할수 없는 파일 입니다.\\n\\r확장자가 csv 인경우만 업로드가 가능합니다.'); history.go(-1) </script>");
    exit;
}


if ($upfile_name){
	//echo "폴더내에 동일한 파일이 있는지 검사하고 있으면 삭제 <br>";
	
	
    //폴더내에 동일한 파일이 있는지 검사하고 있으면 삭제
    if (file_exists("{$upfile_dir}/{$upfile_name}") ) { 
    	unlink("{$upfile_dir}/{$upfile_name}"); 
    	//echo "동일파일 검사 삭제 <br>";
    }else{
    	//echo "동일파일 없음. <br>";
    }
    
    /*
    if (!$upfile) {
        echo ("<script>window.alert('지정된 용량(2M)을 초과'); history.go(-1) </ script>");
        exit;
    }
    */
    
    
    //$filesize = $upfile_size;
    /*
    if ( strlen($upfile_size) < 7 ) {
        $filesize = sprintf("%0.2f KB", $upfile_size/1000);
    } else{
        $filesize = sprintf("%0.2f MB", $upfile_size/1000000);
    }
    */
    
	$target_file = "temp_device.csv";
	if (move_uploaded_file($upfile_tmp,$target_file)) {
    	//echo "디렉토리에 복사 성공. <br>";
    } else {
    	//echo "디렉토리에 복사 실패. <br>";
    	
    }
}else{
	//echo "upfile_name ERROR:" . $upfile_name . "<br>";
}



// 저장된 파일을 읽어 들인다
$csvLoad  = file($target_file);

// 행으로 나누어서 배열에 저장
$csvArray = explode("\r\n",implode($csvLoad));        // 문장의 끝라인은 \r\n 입니다. (2014-11-14 RYO)
$arrayCount = count($csvArray);
//echo "csvArray Count:" . $arrayCount . "<br>";
//echo $csvArray[0] . "<br>";

/*
$node_num = "node_num"; //RMS시리얼번호
$node_id = "node_id"; //RMS보드번호
$node_name = "node_name"; //장비번호
$installday = "installday"; //RMS설치일자
$lampnum = "lampnum"; //가로등번호
//$pco_num = "pco_num"; //사이트명
//$channel = "channel"; //로라 채널
//$lat = "";
//$lon = "";
$dtype = "dtype"; //장비종류
$deviceday = "deviceday"; //장비설치일자
$address = "address"; //장비설치주소
*/

$total_count = $arrayCount - 1;
$reg_count = 0;
for($i=1; $i < $arrayCount; $i++){
	
    $field     = explode(",",addslashes($csvArray[$i])); // 각 행을 콤마를 기준으로 각 필드에 나누고 DB입력시 에러가 없게 하기위해서 addslashes함수를 이용해 \를 붙입니다
    //$value = iconv("euc-kr", "utf-8", $value);  // CSV 한글 깨짐 문제
    
    $node_num = $field[0]; //RMS시리얼번호
    $node_id = $field[1]; //RMS보드번호
    $node_name = $field[2]; //장비번호(장비명)
    $installday = $field[3]; //RMS설치일자
    $lampnum = $field[4]; //가로등번호
    $dtype = $field[5]; //장비종류
    $deviceday = $field[6]; //장비설치일자
    $address = $field[7]; //장비설치주소

    //echo $i.": ".$node_num."/".$node_id."/".$node_name."/".$installday."/".$lampnum."/".$dtype."/".$deviceday."/".$address."<br>";
    
    
    //기존자료 중복체크
    $query_check = "select * from node_list where node_name='".$node_name."' and pco_num='".$pco_num."' ";
    $result_check = query( $query_check );
    $result_cnt = 0;
	while( $rw_list =  $result_check ->fetch_array() ) {
		$result_cnt = $result_cnt + 1;
	}

    if($result_cnt > 0) { // 자료 있을때
    	echo ("<script>window.alert('".$node_name." 같은 이름의 장비가 있습니다.'); </script>");
        
    } else { 
    	// php쿼리문을 이용해서 입력한다.
        $today = date("Y-m-d");
		$sqlData = " insert into node_list set node_num = '$node_num',
												node_id = '$node_id',
												node_name = '$node_name',
												pco_num = '$pco_num',
												channel = '$channel',
												longitude = '$lon', 
												latitude = '$lat',
												installday = '$installday',
												lampnum = '$lampnum',
												dtype = '$dtype',
												deviceday = '$deviceday',
												address = '$address' ";
		$resultID = query( $sqlData );
		
		$reg_count = $reg_count + 1;
    }
    
}

// 입력이 된후 업로드된 파일을 삭제한다
//unlink("{$upfile_dir}/{$upfile_name}");
unlink($target_file);

$strAlert = "총 ".$total_count."개 중 ".$reg_count."개 장비 등록 성공!";
echo "<script>alert('".$strAlert."');</script>";

$re_url ="node_manage.php?pco_num=".$pco_num;

?>



<html>
<head>
<meta http-equiv="refresh" content="0; url=<?echo $re_url;?>" />
</head>
<body><center>
<h2>잠시 기다려 주세요.</h2>
</body>
</html>


  		
  		
  		
  		
  		
  		
