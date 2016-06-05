<?php

include 'config.php';

$q = $_GET['q'];

/* Query SQL Server for the login of the user accessing the
database. */
$tsql = "SELECT [First_Name]
      ,[Last_Name]
   FROM [esc_v20].[dbo].[Customer]
  where [CustNum]='".$q."'";
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

/* Retrieve and display the results of the query. */
$row = sqlsrv_fetch_array($stmt);
echo "&nbsp;<b><u>Step 2: Confirm the information below is correct.</b></u>&nbsp;<br>";
echo "&nbsp;Phone #: ".$q."</br>";
echo "&nbsp;First Name: ".$row[0]."</br>";
echo "&nbsp;Last Name: ".$row[1]."</br>";
echo "<form>&nbsp;<input type=\"button\" Value=\"Correct User\" onclick=\"step2()\">&nbsp;<input type=\"button\" Value=\"Incorrect User\" onclick=\"refresh()\"></form>";
/* Free statement and connection resources. */
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);

?>