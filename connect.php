<?

$hostname = "localhost";
$user = "ibookuni_ibu";
$database = "ibookuni_ibu";
$password = "+/6NQ)2}({}K";

$db_handle = mysql_connect($hostname,$user,$password);
$db_found = mysql_select_db($database, $db_handle);

?>