<?php

include 'config.php';

$num = $_GET['q'];
$item = $_GET['g'];

/* Query SQL Server for the login of the user accessing the
database. */
$tsql = "INSERT INTO [esc_v20].[dbo].[SpecialOrders]
           ([Store_ID]
           ,[CustNum]
           ,[ItemNum]
           ,[Quan]
           ,[AmountPaid]
           ,[Status]
           ,[PO_Number]
           ,[Preorder])
     VALUES
           ('1'
           ,'".$num."'
           ,'".$item."'
           ,'1'
           ,'0'
           ,'O'
           ,'0'
           ,0)";
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

/* Retrieve and display the results of the query. */
echo "Successful. Added Item Number ".$item." for Customer Number ".$num.".</br>";
echo "<form><input type=\"button\" Value=\"Complete\" onclick=\"refresh()\">";


?>