<?PHP

include 'config.php';

$newdate = date('Y-m-d', mktime(0, 0, 0, date("m")-6, date("d"),  date("Y")));
 
$tsql = "UPDATE SpecialOrders 
SET SpecialOrders.Status = 'C' 
WHERE SpecialOrders.[DateTime] < Convert(datetime, '".$newdate."') AND SpecialOrders.[Preorder] = '0' AND SpecialOrders.[Status] = 'O'";

  
$stmt = sqlsrv_query($conn, $tsql);

if( $stmt === false ) {
     echo "Error in executing query.<br>";
     die( print_r( sqlsrv_errors(), true));
}
 
 echo "Done. Closed all Special Orders that were older than ".$newdate.".";
 
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);

?>