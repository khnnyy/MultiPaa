<?php
include "db_conn.php";
$patient_id = $_GET["patient_id"];

if (isset($_POST["submit"])) {


  $patient_name = $_POST['patient_name'];

  $sql = "UPDATE `patients` SET `name`='$patient_name' WHERE patient_id = $patient_id";

  $result = mysqli_query($conn, $sql);

  if ($result) {
    header("Location: home.php?msg=Data updated successfully");
  } else {
    echo "Failed: " . mysqli_error($conn);
  }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration | GreenCare</title>
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

        .registration-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(76, 175, 80, 0.1);
            padding: 2.5rem;
            margin-top: 3rem;
            max-width: 600px;
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.8rem 2rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
        }

        .btn-danger {
            padding: 0.8rem 2rem;
            transition: all 0.3s ease;
        }

        .form-label {
            font-weight: 500;
            color: var(--primary-color);
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
        }
    </style>
    <script>
        function combineNames() {
            const lastName = document.getElementById("lastName").value.trim();
            const firstName = document.getElementById("firstName").value.trim();
            const middleInitial = document.getElementById("middleInitial").value.trim();
            const patientName = `${lastName}, ${firstName} ${middleInitial}`;
            document.getElementById("patient_name").value = patientName.toUpperCase();
        }
    </script>
</head>
<body>
    <?php include 'includes/header.php'?>
    
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="registration-card">
                <h2 class="text-center mb-4">
                    <i class="fas fa-user-plus me-2"></i>Patient Registration
                </h2>
                <form method="POST" onsubmit="combineNames()">
                    <div class="mb-4 position-relative">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control py-2" id="lastName" placeholder="Enter last name" required>
                    </div>

                    <div class="mb-4 position-relative">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control py-2" id="firstName" placeholder="Enter first name" required>
                    </div>

                    <div class="mb-4 position-relative">
                        <label for="middleInitial" class="form-label">Middle Initial</label>
                        <input type="text" class="form-control py-2" id="middleInitial" placeholder="Enter middle initial" maxlength="1">
                        <i class="fas fa-initial input-icon"></i>
                    </div>

                    <input type="hidden" id="patient_name" name="patient_name" required>

                    <div class="d-flex justify-content-between mt-5">
                        <button type="submit" class="btn btn-primary" name="submit">
                            <i class="fas fa-check-circle me-2"></i>Submit
                        </button>
                        <a href="view.php" class="btn btn-danger">
                            <i class="fas fa-times-circle me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>