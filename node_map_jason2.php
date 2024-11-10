<?
//<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
include ("dbcon_pharmcle.php");

$pco_num = $_POST['pco_num'];



$endln = ',';

	
$sql = " select * from node_list where  pco_num = '$pco_num' ";
$rs_list 	= query( $sql ); 
$num_results = $rs_list->num_rows;
		
	
	$rowcnt=0;
	
	while( $rw_list =  $rs_list ->fetch_array() ) {
  		$rowcnt = $rowcnt +1;
  		
  		$idx =  $rw_list[idx];
		$node_num =  $rw_list[node_num];
		$node_name =  $rw_list[node_name];
		$current =  $rw_list[current];
		$relay =  $rw_list[relay];
		$latitude =  $rw_list[latitude];
		$longitude =  $rw_list[longitude];
		$working =  $rw_list[working];
  		
  		echo $idx . $endln ;
  		echo $node_num .$endln ;
  		echo $node_name .$endln ;
  		echo $current .$endln ;
  		echo $relay .$endln ;
  		echo $latitude .$endln ;
  		echo $longitude .$endln ;
  		echo $working . '/' ;

  	}
  	
  	
?>
