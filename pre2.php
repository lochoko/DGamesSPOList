<?php

include 'config.php';

$today = date('Y-m-d', mktime(0,0,0, date("m"), date("d"), date("Y"))); 
$newdate = date('Y-m-d', mktime(0, 0, 0, date("m")-6, date("d"),  date("Y")));


$tsql ="UPDATE SpecialOrders
  SET  SpecialOrders.DateTime = getdate()
  FROM SpecialOrders
  JOIN Customer ON SpecialOrders.CustNum = Customer.CustNum
  WHERE SpecialOrders.[DateTime] < Convert(datetime, '".$newdate."') AND SpecialOrders.[Preorder] = '0' AND SpecialOrders.[Status] = 'O' and Customer.Fax LIKE '.'";
 
//echo $tsql."<br>";
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false ) {
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}
 
 echo "Done. Employee Special Orders older than ".$newdate." have been changed to ".$today.".";
 
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);

//CONVERT(datetime, '".$today."')
  ?>