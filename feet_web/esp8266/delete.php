<?php
include "db_conn.php";
$patient_id = $_GET["patient_id"];
$sql = "DELETE FROM `patients` WHERE patient_id = $patient_id";
$result = mysqli_query($conn, $sql);

if ($result) {
  header("Location: view.php?msg=Data deleted successfully");
} else {
  echo "Failed: " . mysqli_error($conn);
}