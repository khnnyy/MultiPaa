<?php
session_start();

$data = [
    "tempL" => isset($_SESSION['tempL']) ? $_SESSION['tempL'] : 'N/A',
    "tempR" => isset($_SESSION['tempR']) ? $_SESSION['tempR'] : 'N/A',

    "hrL" => isset($_SESSION['hrL']) ? $_SESSION['hrL'] : 'N/A',
    "hrR" => isset($_SESSION['hrR']) ? $_SESSION['hrR'] : 'N/A',

    "spo2L" => isset($_SESSION['spo2L']) ? $_SESSION['spo2L'] : 'N/A',
    "spo2R" => isset($_SESSION['spo2R']) ? $_SESSION['spo2R'] : 'N/A',

    "gsrL" => isset($_SESSION['gsrL']) ? $_SESSION['gsrL'] : 'N/A',
    "gsrR" => isset($_SESSION['gsrR']) ? $_SESSION['gsrR'] : 'N/A',

    "bodyweight" => isset($_SESSION['bodyweight']) ? $_SESSION['bodyweight'] : 'N/A',
];

header('Content-Type: application/json');
echo json_encode($data);
?>
