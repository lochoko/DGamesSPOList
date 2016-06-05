<?php

include 'config.php';
/*
$q = $_GET['q'];
$g = $_GET['g'];

$q = str_replace("%20", " ", $q);
$g = str_replace("%20", " ", $g);*/
$height = 0;
$table = "";
$row = 0;


$today = mktime(0,0,0, date("m"), date("d"), date("Y")); 
$newdate = mktime(0, 0, 0, date("m")-6, date("d"),  date("Y"));
 
$tsql = "SELECT SpecialOrders.[DateTime]
      ,SpecialOrders.[CustNum]
      ,SpecialOrders.[ItemNum]
      ,SpecialOrders.[Status]
      ,SpecialOrders.[PO_Number]
      ,SpecialOrders.[Preorder]
	  ,Customer.First_Name
	  ,Customer.Last_Name
  FROM SpecialOrders
  INNER JOIN Customer
  ON SpecialOrders.CustNum = Customer.CustNum
  WHERE SpecialOrders.[DateTime] < Convert(datetime, '".date('Y-m-d', $newdate)."') AND SpecialOrders.[Preorder] = '0' AND SpecialOrders.[Status] = 'O'";
 
 
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

/* Retrieve and display the results of the query. */

echo "<br>&nbsp;&nbsp;&nbsp;<b><u>List of Games to be removed from the list.</b></u><br>";

echo "&nbsp;<table id=\"gamelist\" style=\"width: 98%; top: 45px; margin: 0 auto;\">
<tbody>
<tr>
<th>Date & Time</th>
<th>Customer</th>
<th>Number</th>
<th>Game</th>
<th>Status</th>
<th>PO Number</th>
<th>Preorder</th>
</tr>";

while ($row = sqlsrv_fetch_array($stmt)) {

$tsql2 = "SELECT [ItemName] FROM [esc_v20].[dbo].[Inventory] where [ItemNum] LIKE '".$row[2]."'";

$game = sqlsrv_query( $conn, $tsql2);
$gamea = sqlsrv_fetch_array($game);
  
echo "<tr>";
echo "<td>".$row[0]."</td>";
echo "<td>".$row[6]." ".$row[7]."</td>";
echo "<td>".$row[1]."</td>";
echo "<td>".$gamea[0]."</td>";
echo "<td>".$row[3]."</td>";
echo "<td>".$row[4]."</td>";
echo "<td>".$row[5]."</td></tr>";

sqlsrv_free_stmt( $cust);
sqlsrv_free_stmt( $game);
}

echo "</tbody></table>&nbsp;";
/* Free statement and connection resources. */
sqlsrv_free_stmt( $stmt);

sqlsrv_close( $conn);

echo "<a href=\"#\" onClick=\"SPOCleanup(3);\">Continue?</a>"; ?>

