<?PHP

include 'config.php';

$q = $_GET['q'];
$s = $_GET['s'];


$tsql = "UPDATE SpecialOrders 
SET SpecialOrders.Status = 'C' 
WHERE SpecialOrders.SpecialOrderID = ".$q;

$stmt = sqlsrv_query($conn, $tsql);

if( $stmt === false ) {
     echo "Error in executing query.<br>";
     die( print_r( sqlsrv_errors(), true));
}


if ($s == "ID") {
echo "Done. Closed the Special Order.<br><br><a href=\"#\" onClick=\"searchID(document.getElementById('SPOID').value);\">Go Back</a>";
} elseif ($s == "UPC") {
echo "Done. Closed the Special Order.<br><br><a href=\"#\" onClick=\"searchSPO(document.getElementById('SPOUPC').value);\">Go Back</a>";
} 
 
 
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);

?>