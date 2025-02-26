<?php
include "db_conn.php";

// Set the number of records per page
$records_per_page = 10;

// Get the current page number from the query string, default to 1 if not set
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;

// Initialize search name variable
$search_name = '';
if (isset($_POST["search"])) {
    // Get the combined patient name and convert it to uppercase
    $search_name = strtoupper(trim($_POST['search_name']));
}

// Prepare SQL statement for pagination
$sql = "SELECT * FROM `patients`";

// If a search term is provided, modify the SQL query
if ($search_name) {
    $sql .= " WHERE `name` LIKE '%$search_name%'";
}

$sql .= " LIMIT $offset, $records_per_page";

$result = mysqli_query($conn, $sql);
if ($result) {
    $patients = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "Failed: " . mysqli_error($conn);
}

// Prepare the SQL query for counting total records
$count_sql = "SELECT COUNT(*) as total FROM `patients`";
if ($search_name) {
    $count_sql .= " WHERE `name` LIKE '%$search_name%'";
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

        .search-box {
            max-width: 600px;
            margin: 2rem auto;
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.1);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color)!important;
            border-color: var(--primary-color) !important;
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

        .modal-header {
            background-color: var(--primary-color);
            color: white;
        }

        .patient-header {
            background: white;
            padding: 1.5rem;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.1);
            margin: 2rem 0;
        }
        .patient-title {
            color: var(--primary-color);
            font-size: 1.4rem;
        }

        .text-primary {
            color: var(--primary-color)!important;
        }

                .patient-header i {
            color: var(--primary-color);
            transition: color 0.3s ease;
        }

        /* If you want hover effects */
        .patient-header i:hover {
            color: var(--primary-hover);
        }
    </style>
    <title>Patient Records | GreenCare</title>
</head>

<body>
    <?php include "includes/header.php"; ?>

    <div class="container py-4">
    <!-- Centered Patient Header -->
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="patient-header text-center mb-4 mx-auto">
                <div class="d-flex flex-column align-items-center">
                    <h3 class="text-primary mb-3 fw-bold">
                        <i class="fas fa-user-injured me-2"> Patient Registry</i>
                    </h3>
                    <form method="POST" class="search-form w-100">
                        <div class="input-group">
                            <input type="text" class="form-control py-2" 
                                   placeholder="Search patient name..." 
                                   name="search_name" required>
                            <button class="btn btn-primary px-4" type="submit" name="search">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Rest of your content remains here -->
    <div class="card shadow-sm border-0">
    <!-- ... -->

        <!-- Patient Table -->
        <div class="card shadow-sm border-0">
            <table class="table table-hover text-center mb-0">
                <thead class="table-success">
                    <tr>
                        <th scope="col">Patient ID</th>
                        <th scope="col">Patient Name</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php if ($patients): ?>
                        <?php foreach ($patients as $row): ?>
                            <tr>
                                <td class="align-middle"><?php echo $row["patient_id"] ?></td>
                                <td class="align-middle"><?php echo $row["name"] ?></td>
                                <td class="align-middle">
                                    <!-- Diagnosis Modal Trigger -->
                                    <a href="#" class="text-decoration-none" title="Diagnose" data-bs-toggle="modal" 
                                       data-bs-target="#confirmDiagnosisModal<?php echo $row['patient_id']; ?>">
                                        <i class="fas fa-stethoscope action-icon"></i>
                                    </a>

                                    <!-- Diagnosis Modal -->
                                    <div class="modal fade" id="confirmDiagnosisModal<?php echo $row['patient_id']; ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Retrieve Diagnostic Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Verify the device has completed diagnostics and is ready for data retrieval.</p>
                                                    <p><strong>Proceed with data retrieval for this patient?</strong></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <a href="post_data.php?patient_id=<?php echo $row['patient_id']; ?>" 
                                                            class="btn btn-primary">Confirm Retrieval</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Other Actions -->
                                    <a href="patient_records.php?patient_id=<?php echo $row["patient_id"] ?>" 
                                       class="text-decoration-none" title="View Records">
                                        <i class="fas fa-file-medical action-icon"></i>
                                    </a>
                                    <a href="edit.php?patient_id=<?php echo $row["patient_id"] ?>" 
                                       class="text-decoration-none" title="Edit">
                                        <i class="fas fa-edit action-icon"></i>
                                    </a>
                                    <a href="#" class="text-decoration-none" title="Delete" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteConfirmationModal"
                                        data-patient-id="<?php echo $row['patient_id']; ?>">
                                            <i class="fas fa-trash-alt action-icon"></i>
                                    </a>
                                </td>
                                <div class="modal fade" id="deleteConfirmationModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Confirm Deletion</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to permanently delete this patient record?</p>
                                            <p>This action cannot be undone.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <a id="confirmDeleteButton" href="#" class="btn btn-danger">Delete Permanently</a>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="py-4 text-muted">No patient records found.</td>
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
                            <a class="page-link" href="?page=<?php echo $current_page - 1; ?>&search_name=<?php echo $search_name; ?>">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo $current_page == $i ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&search_name=<?php echo $search_name; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if ($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $current_page + 1; ?>&search_name=<?php echo $search_name; ?>">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
    <?php include "includes/footer.php" ?>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the modal element
        const deleteModal = document.getElementById('deleteConfirmationModal');
        
        // Add event listener for when the modal is shown
        deleteModal.addEventListener('show.bs.modal', function(event) {
            // Get the button that triggered the modal
            const triggerButton = event.relatedTarget;
            
            // Extract patient ID from data-patient-id attribute
            const patientId = triggerButton.getAttribute('data-patient-id');
            
            // Update the delete button's href
            const confirmDeleteButton = document.getElementById('confirmDeleteButton');
            confirmDeleteButton.href = `delete.php?patient_id=${patientId}`;
        });
    });
    </script>
</body>
</html>


