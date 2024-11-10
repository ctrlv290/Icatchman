<?
	//DB: wonderswing / atom!@4416
	$db =  new mysqli( "localhost", "pharmcle", "pharmcle-4416", "pharmcle" );

        if ($db->connect_errno) {
            echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
            echo $db->host_info . "\n";
        }

function query($sql) {
   global $db;

   
   if (!$result = $db->query( $sql )) {
     echo 'Unable to connect to database !<br>' . $db->errno . ' <- 오류번호<hr>' . $sql . '<hr>' . $db->connect_error . '<br>';
     }

    return $result;

}

function dbinstance() {
    global $db;
    return $db;
}
