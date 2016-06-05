<?php

$server ='SERVERNAME';
$connection = array("DATABASE"=>"esc_v20","UID"=>"USERNAME","PWD"=>"PASSWORD","ReturnDatesAsStrings"=>true);
/* Connect using SQL Server Authentication. */
$conn = sqlsrv_connect( $server, $connection);
if( $conn === false )
{
     echo "Unable to connect.</br>";
     die( print_r( sqlsrv_errors(), true));
}

?>