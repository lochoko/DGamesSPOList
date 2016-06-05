<?PHP

include 'config.php';

$g = $_GET['g'];
$q = $_GET['q'];


$cust = sqlsrv_query( $conn, "SELECT First_Name, Last_Name FROM Customer WHERE CustNum = '".$q."'");
$custname = sqlsrv_fetch_array($cust);

echo "Games on the Special Order list for ".$custname[0]." ".$custname[1]."<br>";

$custname[0] = str_replace("'","\'",$custname[0]);
$custname[0] = str_replace("\"","\'\'",$custname[0]);

$custname[1] = str_replace("'","\'",$custname[1]);
$custname[1] = str_replace("\"","\'\'",$custname[1]);


//echo $g."<br>";

if ($g == "C") {
$tsql = "SELECT SpecialOrderID, 
		 SpecialOrders.DateTime, 
		 SpecialOrders.ItemNum, 
		 SpecialOrders.Status,
		 Inventory.ItemName
		 FROM SpecialOrders
  		 INNER JOIN Inventory
  		 ON SpecialOrders.ItemNum = Inventory.ItemNum
		 WHERE SpecialOrders.CustNum = '".$q."' AND SpecialOrders.PreOrder = '0' ORDER BY Inventory.ItemName";
} elseif ($g == "O") {
$tsql = "SELECT SpecialOrderID, 
		 SpecialOrders.DateTime, 
		 SpecialOrders.ItemNum, 
		 SpecialOrders.Status,
		 Inventory.ItemName
		 FROM SpecialOrders
  		 INNER JOIN Inventory
  		 ON SpecialOrders.ItemNum = Inventory.ItemNum
		 WHERE SpecialOrders.CustNum = '".$q."' AND SpecialOrders.PreOrder = '0' AND SpecialOrders.Status = 'O' ORDER BY Inventory.ItemName";
}
//echo $tsql."<br>";
		 
$stmt = sqlsrv_query( $conn, $tsql);

echo "&nbsp;<table style=\"width: 98%; top: 45px; margin: 0 auto;\">
<tr>
<th>Date & Time</th>
<th>Item Number</th>
<th>Item Name</th>
<th>Status</th>
<th>Update SPO</th>
</tr>";

while ($row = sqlsrv_fetch_array($stmt)) {

//$game = sqlsrv_query( $conn, "SELECT ItemName FROM Inventory WHERE ItemNum = '".$row[2]."'");
//$gamename = sqlsrv_fetch_array($game);

echo "<tr>";
echo "<td>".$row[1]."</td>";
echo "<td>".$row[2]."</td>";
echo "<td>".$row[4]."</td>";
if ($row[3] == "O") {
	echo "<td>Open</td>";
	echo "<td><a href=\"#\" onClick=\"closeSPO('".$row[0]."','".$custname[0]." ".$custname[1]."','".$row[4]."','ID')\">Close SPO</a></td>";
} else {
	echo "<td>Closed</td>";
	echo "<td><a href=\"#\" onClick=\"openSPO('".$row[0]."','".$custname[0]." ".$custname[1]."','".$row[4]."','ID')\">Re-open SPO</a></td>";
}

echo "</tr>";

}

?>