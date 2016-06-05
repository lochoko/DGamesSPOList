<?PHP

include 'config.php';

$q = $_GET['q'];

$q = ltrim($q, "uU");


$tsql = "SELECT ItemName
	     FROM Inventory
		 WHERE ItemNum = '".$q."'";

//echo $q."<br>".$tsql."<br>";
		 
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt);

echo "Search for ".$row[0].", UPC: ".$q."<br>";

$gamename = $row[0];

$gamename = str_replace("'","\'",$gamename);

$gamename = str_replace("\"","\'\'",$gamename);

$tsql = "SELECT SpecialOrderID,
			    DateTime,
			    CustNum
		 FROM SpecialOrders
		 WHERE ItemNum = '".$q."' AND PreOrder = '0' AND Status = 'O' ORDER BY DateTime";
	 
//echo $tsql."<br>";

sqlsrv_free_stmt( $stmt);

$stmt = sqlsrv_query( $conn, $tsql);

if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

echo "<table style=\"width: 98%; top: 45px; margin: 0 auto;\"> 
<tbody>
<tr>
<th>Date & Time</th>
<th>Customer Number</th>
<th>Customer Name</th>
<th>Close</th>
</tr>";


while ($row = sqlsrv_fetch_array($stmt)) {

$cust = sqlsrv_query( $conn, "SELECT First_Name, Last_Name FROM Customer WHERE CustNum = '".$row[2]."'");
$custname = sqlsrv_fetch_array($cust);

$custname[0] = str_replace("'","\'",$custname[0]);
$custname[0] = str_replace("\"","\'\'",$custname[0]);

$custname[1] = str_replace("'","\'",$custname[1]);
$custname[1] = str_replace("\"","\'\'",$custname[1]);

echo "<tr>";
echo "<td>".$row[1]."</td>";
echo "<td>".$row[2]."</td>";
echo "<td>".$custname[0]." ".$custname[1]."</td>";
echo "<td><a href=\"#\" onClick=\"closeSPO('".$row[0]."','".$custname[0]." ".$custname[1]."','".$gamename."','UPC')\">Close SPO</a></td>";
echo "</th>";
}
echo "</table>";
	


sqlsrv_free_stmt( $stmt);

sqlsrv_close( $conn);	
?>