<!DOCTYPE html>
<html><body>
<?php
include "db_conn.php";

$sql = "SELECT foot_id, patient_name, sensor_value FROM foot_Data ORDER BY foot_id DESC";

echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <td>Foot ID</td> 
        <td>Patient Name</td> 
        <td>Sensor Values</td> 
      </tr>';
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_id = $row["foot_id"];
        $row_name = $row["patient_name"];
        $row_value = $row["sensor_value"];  
        echo '<tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_name . '</td> 
                <td>' . $row_value . '</td> 
              </tr>';
    }
    $result->free();
}

$conn->close();
?> 
</table>
</body>
</html>