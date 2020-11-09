<?php

$con=mysqli_connect("192.168.3.180:3306","pau","Jordan02sql","testdb");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM ingredients");

echo "<table border='1'>
<tr>
<th>Nom</th>
<th>Categoria</th>
<th>Unitat</th>
<th>Preu</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['nom'] . "</td>";
echo "<td>" . $row['categoria'] . "</td>";
echo "<td>" . $row['unitat'] . "</td>";
echo "<td>" . $row['preu'] . "</td>";
echo "</tr>";
}
echo "</table>";

mysqli_close($con);

?>