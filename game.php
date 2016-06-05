<?php

include 'config.php';

$q = $_GET['q'];
$g = $_GET['g'];

$q = str_replace("%20", " ", $q);
$g = str_replace("%20", " ", $g);
$height = 0;
$table = "";

/* Query SQL Server for the login of the user accessing the database. */

if ($q == ".") {
$tsql = "SELECT [ItemNum]
      ,[ItemName]
	  ,[ItemDesc1]
      ,[Cat_ID]
      ,[In_Stock]
      ,[Used_In_Stock]
	  ,[Used_Price]
   FROM [esc_v20].[dbo].[Inventory]
  where [ItemName] LIKE '%".$g."%' ORDER BY [ItemName]";
 }
 else {
 $tsql = "SELECT [ItemNum]
      ,[ItemName]
	  ,[ItemDesc1]
      ,[Cat_ID]
      ,[In_Stock]
      ,[Used_In_Stock]
	  ,[Used_Price]
   FROM [esc_v20].[dbo].[Inventory]
  where [Cat_ID] LIKE '%".$q."%' and [ItemName] LIKE '%".$g."%' ORDER BY [ItemName]";
 }
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

/* Retrieve and display the results of the query. */

while ($row = sqlsrv_fetch_array($stmt)) {

if ($row[4] > 0 AND $row[5] > 0) {
$table = $table."<tr style=\"background-color: lightyellow;\">";
}
elseif ($row[4] > 0){
$table = $table."<tr style=\"background-color: lightgreen;\">";
}
elseif ($row[5] > 0) {
$table = $table."<tr style=\"background-color: lightblue;\">";
}
else {
$table = $table."<tr>";
}

$edited = str_replace("'","\'",$row[1]);

$edited = str_replace("\"","\'\'",$edited);

$table = $table."<td>".$row[0]."</td>";
$table = $table."<td><a href=\"#\" onClick=\"startPre('".$row[0]."','".$edited."')\">".$row[1]."</a></td>";
$table = $table."<td>".$row[2]."</td>";
$table = $table."<td>".$row[3]."</td>";
$table = $table."<td>".$row[4]."</td>";
$table = $table."<td>".$row[5]."</td>";
$table = $table."<td style=\"text-align: right;\">".substr($row[6], 0, -2)."</td>";

$height = $height + 1;
}

$height = ($height * 20) + 40;

echo "<table style=\"position: absolute; float: left; top: 13px; right: 4px; width: 30%; font-size: 12px;\"><tr><td>Not In Stock</td><td style=\"background-color: lightblue;\">Have Used</td><td style=\"background-color: lightgreen;\">Have New</td><td style=\"background-color: lightyellow;\">Have Both New & Used</td></tr></table>";
echo "<br>&nbsp;&nbsp;&nbsp;<b><u>Step 4: Click the Link for the game you are looking for, OR go back to Step 3 and Search again.</b></u><br>";

echo "&nbsp;<table style=\"width: 98%; top: 45px; margin: 0 auto;\">
<tr>
<th>UPC</th>
<th>Game Title</th>
<th>Item Description</th>
<th>System</th>
<th>In Stock</th>
<th>Used In Stock</th>
<th>Used Price</th>
</tr>";
echo $table;
echo "</table>&nbsp;";
/* Free statement and connection resources. */
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);

?>