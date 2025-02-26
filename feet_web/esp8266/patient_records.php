<?php
include "db_conn.php";

// Check if patient_id is set
if (!isset($_GET["patient_id"])) {
    echo "Patient not found.";
    exit;
}

$patient_id = intval($_GET["patient_id"]); // Ensure the patient_id is an integer for security
$records_per_page = 10;

// Get the current page number
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;

// Initialize date variable
$date = '';
if (isset($_POST["search"])) {
    $date = trim($_POST['search_date']);
} elseif (isset($_GET["search_date"])) {
    $date = trim($_GET['search_date']); // Retain search date on pagination links
}

// Fetch patient name
$patient_name = '';
$sql = "SELECT `name` FROM `patients` WHERE `patient_id` = $patient_id";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $patient_row = mysqli_fetch_assoc($result);
    $patient_name = $patient_row['name'];
} else {
    echo "Patient not found.";
    exit;
}

// Prepare SQL statement for pagination
$sql = "SELECT `diagnostic_id`, `datetime` FROM `feet_diagnostics` WHERE `patient_id` = $patient_id";
if ($date) {
    $sql .= " AND `datetime` LIKE '%$date%'";
}
$sql .= " LIMIT $offset, $records_per_page";

$result = mysqli_query($conn, $sql);
if ($result) {
    $diagnostic = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "Failed: " . mysqli_error($conn);
    exit;
}

// Get the total number of records for pagination
$count_sql = "SELECT COUNT(*) as total FROM `feet_diagnostics` WHERE `patient_id` = $patient_id";
if ($date) {
    $count_sql .= " AND `datetime` LIKE '%$date%'";
}
$count_result = mysqli_query($conn, $count_sql);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $records_per_page);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #4CAF50;
            --primary-hover: #45a049;
            --background-light: #f8f9fa;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9f5eb 100%);
            min-height: 100vh;
        }

        .patient-header {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.1);
            margin: 2rem 0;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color)!important;
            border: var(--primary-color)!important;
            padding: 0.6rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover)!important;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(76, 175, 80, 0.05);
        }

        .table thead {
            background-color: var(--primary-color);
            color: green;
        }

        .action-icon {
            color: var(--primary-color);
            transition: all 0.2s ease;
            margin: 0 0.8rem;
        }

        .action-icon:hover {
            color: var(--primary-hover);
            transform: scale(1.2);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .pagination .page-link {
            color: var(--primary-color);
        }

        .pagination .page-link:hover {
            color: var(--primary-hover);
        }

        .patient-name {
            color: var(--primary-color);
            font-size: 1.4rem;
        }
    </style>
    <title>Diagnostic Records | GreenCare</title>
</head>

<body>
    <?php include "includes/header.php"; ?>

    <div class="container py-4">
        <div class="patient-header">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <span class="patient-name">
                        PATIENT: <strong><?php echo htmlspecialchars($patient_name); ?></strong>
                    </span>
                </div>
                <div class="col-md-5">
                    <form method="POST" class="d-flex align-items-center gap-2">
                        <div class="position-relative flex-grow-1">
                            <input type="date" class="form-control py-2" id="search_date" name="search_date" 
                                   value="<?php echo htmlspecialchars($date); ?>" required>
                            <i class="fas fa-calendar-day position-absolute end-0 top-50 translate-middle-y me-3 text-secondary"></i>
                        </div>
                        <button type="submit" class="btn btn-primary" name="search">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <table class="table table-hover text-center mb-0">
                <thead class="table-success">
                    <tr>
                        <th scope="col">Diagnostic ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php if ($diagnostic): ?>
                        <?php foreach ($diagnostic as $row): 
                            $formatted_datetime = date("Y-m-d H:i:s", strtotime($row["datetime"])); ?>
                            <tr>
                                <td class="align-middle"><?php echo htmlspecialchars($row["diagnostic_id"]); ?></td>
                                <td class="align-middle"><?php echo $formatted_datetime; ?></td>
                                <td class="align-middle">
                                    <a href="diagnose.php?diagnostic_id=<?php echo $row["diagnostic_id"]; ?>" 
                                       class="text-decoration-none" title="View Records">
                                        <i class="fas fa-file-medical action-icon"></i>
                                    </a>
                                    <a href="#" class="text-decoration-none" title="Delete" 
                                       data-bs-toggle="modal" 
                                       data-bs-target="#deleteDiagnosticModal"
                                       data-diagnostic-id="<?php echo $row['diagnostic_id']; ?>">
                                        <i class="fas fa-trash-alt action-icon"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="py-4 text-muted">No diagnostic records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php if ($current_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $current_page - 1; ?>&patient_id=<?php echo $patient_id; ?>&search_date=<?php echo htmlspecialchars($date); ?>">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo $current_page == $i ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&patient_id=<?php echo $patient_id; ?>&search_date=<?php echo htmlspecialchars($date); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $current_page + 1; ?>&patient_id=<?php echo $patient_id; ?>&search_date=<?php echo htmlspecialchars($date); ?>">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteDiagnosticModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to permanently delete this diagnostic record?</p>
                    <p>This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a id="confirmDiagnosticDelete" href="#" class="btn btn-danger">Delete Permanently</a>
                </div>
            </div>
        </div>
    </div>

    <?php include "includes/footer.php" ?>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteDiagnosticModal');
        
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const triggerButton = event.relatedTarget;
            const diagnosticId = triggerButton.getAttribute('data-diagnostic-id');
            const confirmDelete = document.getElementById('confirmDiagnosticDelete');
            confirmDelete.href = `delete.php?diagnostic_id=${diagnosticId}`;
        });
    });
    </script>
</body>
</html>
