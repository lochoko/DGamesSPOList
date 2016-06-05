<?PHP

include 'config.php';

$q = $_GET['q'];

$today = date('Y-m-d', mktime(0,0,0, date("m"), date("d"), date("Y"))); 

$tsql ="UPDATE SpecialOrders
SET  SpecialOrders.DateTime = getdate(), SpecialOrders.Status = 'O' 
WHERE SpecialOrders.SpecialOrderID = ".$q;

$stmt = sqlsrv_query($conn, $tsql);

if( $stmt === false ) {
     echo "Error in executing query.<br>";
     die( print_r( sqlsrv_errors(), true));
}
 
 echo "Done. Re-opened the Special Order and set to today's date.<br><br><a href=\"#\" onClick=\"searchID(document.getElementById('SPOID').value);\">Go Back</a>";
 
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);

?>