<?php
include "db_conn.php";

$tempR = $hrR  = $spo2R  = $bodyWeight  = $gsrR = $datetime = $patient_name = null;
$tempL = $hrL  = $spo2L = $gsrL = null;
if (isset($_GET["diagnostic_id"])) {
    $diagnostic_id = $_GET["diagnostic_id"];

    $sql = "SELECT * FROM feet_diagnostics WHERE diagnostic_id= $diagnostic_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
        
    $patient_id = $row["patient_id"];
    $tempRight = $row["tempR"];
    $heartrateRight = $row["hrR"];
    $bloodsatRight = $row["spo2R"];
    $gsrRight = $row["gsrR"];

    $bodyweightRight = $row["bodyweight"];

    $datetime = $row["datetime"];
        
    $tempLeft = $row["tempL"];
    $heartrateLeft = $row["hrL"];
    $bloodsatLeft = $row["spo2L"];
    $gsrLeft = $row["gsrL"];

    $sql = "SELECT name FROM patients WHERE patient_id= $patient_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $patient_name = $row["name"];
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #4CAF50;
            --primary-100: #E8F5E9;
            --surface-color: #FFFFFF;
            --border-radius: 20px;
            --shadow-sm: 0 4px 24px rgba(76, 175, 80, 0.08);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9f5eb 100%);
            color: #1A1A1A;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .patient-card {
            background: var(--surface-color);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            padding: 2rem;
            position: sticky;
            top: 2rem;
            height: min-content;
        }

        .patient-avatar {
            width: 80px;
            height: 80px;
            background: var(--primary-100);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .patient-meta {
            display: grid;
            gap: 1.2rem;
            padding: 1rem 0;
            border-top: 1px solid rgba(76, 175, 80, 0.1);
            border-bottom: 1px solid rgba(76, 175, 80, 0.1);
            margin: 1.5rem 0;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .meta-icon {
            width: 36px;
            height: 36px;
            background: var(--primary-100);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
        }

        /* New Sensor Card Styles */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .sensor-card {
            background: var(--surface-color);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            padding: 1.5rem;
            transition: transform 0.3s ease;
        }

        .sensor-card:hover {
            transform: translateY(-3px);
        }

        .sensor-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .sensor-icon {
            width: 40px;
            height: 40px;
            background: rgba(76, 175, 80, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sensor-title {
            font-size: 1.3rem;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .reading-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .reading-item {
            padding: 1rem;
            background: rgba(76, 175, 80, 0.05);
            border-radius: 8px;
        }

        .reading-label {
            display: block;
            color: #718096;
            margin-bottom: 0.5rem;
        }

        .reading-value {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .reading-unit {
            color: #a0aec0;
            font-size: 0.9rem;
            margin-left: 0.25rem;
        }

        .body-weight-card {
            grid-column: 1 / -1;
            background: rgba(76, 175, 80, 0.1);
        }

        .comparison-chart {
            height: 300px;
            background: var(--primary-100);
            border-radius: 16px;
            margin: 2rem 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
        }

        .main-content {
            background: var(--surface-color);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            padding: 2rem;
        }
    </style>
</head>

<body>
    <?php include "includes/header.php"; ?>

    <div class="dashboard-container">
        <!-- Patient Sidebar (Unchanged) -->
        <aside class="patient-card">
            <div class="patient-avatar">
                <i class="fas fa-user-injured fa-2x" style="color: var(--primary-color);"></i>
            </div>
            
            <h3 class="mb-0"><?php echo $patient_name; ?></h3>
            <p class="text-muted mb-0">Patient Analysis Report</p>

            <div class="patient-meta">
                <div class="meta-item">
                    <div class="meta-icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div>
                        <div class="text-sm text-muted">Patient ID</div>
                        <div class="fw-500"><?php echo $patient_id; ?></div>
                    </div>
                </div>

                <div class="meta-item">
                    <div class="meta-icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div>
                        <div class="text-sm text-muted">Diagnostic ID</div>
                        <div class="fw-500"><?php echo $diagnostic_id; ?></div>
                    </div>
                </div>

                <div class="meta-item">
                    <div class="meta-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="text-sm text-muted">Recorded At</div>
                        <div class="fw-500"><?php echo $datetime; ?></div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button class="btn btn-outline-primary w-100">
                    <i class="fas fa-download me-2"></i>Export Report
                </button>
            </div>
        </aside>
        <!-- Main Content -->
        <main class="main-content">
            <div class="sensor-title">
            <i class="bi bi-clipboard2-pulse-fill"></i>Foot Sensor Readings
            </div>
            
            <div class="card-grid">
                <!-- Temperature Card -->
                <div class="sensor-card">
                    <div class="sensor-title">
                        <div class="sensor-icon">
                            <i class="fas fa-thermometer-half"></i>
                        </div>
                        <h5 class="mb-0">Temperature</h5>
                    </div>
                    <div class="reading-group">
                        <div class="reading-item">
                            <span class="reading-label">Left Foot</span>
                            <span class="reading-value">
                                <?php echo $tempLeft; ?>
                                <span class="reading-unit">°C</span>
                            </span>
                        </div>
                        <div class="reading-item">
                            <span class="reading-label">Right Foot</span>
                            <span class="reading-value">
                                <?php echo $tempRight; ?>
                                <span class="reading-unit">°C</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Heart Rate Card -->
                <div class="sensor-card">
                    <div class="sensor-title">
                        <div class="sensor-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h5 class="mb-0">Heart Rate</h5>
                    </div>
                    <div class="reading-group">
                        <div class="reading-item">
                            <span class="reading-label">Left Foot</span>
                            <span class="reading-value">
                                <?php echo $heartrateLeft; ?>
                                <span class="reading-unit">bpm</span>
                            </span>
                        </div>
                        <div class="reading-item">
                            <span class="reading-label">Right Foot</span>
                            <span class="reading-value">
                                <?php echo $heartrateRight; ?>
                                <span class="reading-unit">bpm</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Blood Saturation Card -->
                <div class="sensor-card">
                    <div class="sensor-title">
                        <div class="sensor-icon">
                            <i class="fas fa-tint"></i>
                        </div>
                        <h5 class="mb-0">Blood Saturation</h5>
                    </div>
                    <div class="reading-group">
                        <div class="reading-item">
                            <span class="reading-label">Left Foot</span>
                            <span class="reading-value">
                                <?php echo $bloodsatLeft; ?>
                                <span class="reading-unit">%</span>
                            </span>
                        </div>
                        <div class="reading-item">
                            <span class="reading-label">Right Foot</span>
                            <span class="reading-value">
                                <?php echo $bloodsatRight; ?>
                                <span class="reading-unit">%</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- GSR Card -->
                <div class="sensor-card">
                    <div class="sensor-title">
                        <div class="sensor-icon">
                            <i class="fas fa-wave-square"></i>
                        </div>
                        <h5 class="mb-0">GSR</h5>
                    </div>
                    <div class="reading-group">
                        <div class="reading-item">
                            <span class="reading-label">Left Foot</span>
                            <span class="reading-value">
                                <?php echo $gsrLeft; ?>
                                <span class="reading-unit">µS</span>
                            </span>
                        </div>
                        <div class="reading-item">
                            <span class="reading-label">Right Foot</span>
                            <span class="reading-value">
                                <?php echo $gsrRight; ?>
                                <span class="reading-unit">µS</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Body Weight Card -->
                <!-- Body Weight Card -->
                <div class="sensor-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="sensor-title mb-0">
                            <div class="sensor-icon">
                                <i class="fas fa-weight-hanging"></i>
                            </div>
                            <h5 class="mb-0">Body Weight</h5>
                        </div>
                        <div class="text-end">
                            <div class="reading-value">
                                <?php echo $bodyWeight; ?>
                                <span class="reading-unit">kg</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php include "includes/footer.php" ?>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>