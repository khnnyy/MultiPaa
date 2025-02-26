<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GreenCare Diagnostics</title>

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
    }

    header {
      background: var(--primary-color);
      box-shadow: 0 2px 15px rgba(76, 175, 80, 0.2);
      padding: 1.2rem 0;
      position: relative;
      z-index: 1000;
    }

    .brand-text {
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      font-size: 1.5rem;
      letter-spacing: 1.2px;
      color: white;
      text-decoration: none;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
    }

    .brand-text:hover {
      color: #e8f5e9;
      transform: translateY(-1px);
    }

    .brand-icon {
      font-size: 1.8rem;
      margin-right: 0.8rem;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <header>
    <div class="container">
      <nav class="d-flex justify-content-between align-items-center">
        <!-- Brand Logo with Icon -->
        <a href="home.php" class="brand-text">
          <i class="fas fa-hospital-alt brand-icon"></i>
          MultiPaa Diagnostics
        </a>
        
        <!-- Navigation Links -->
        <div class="d-flex gap-4">
          <a href="patient_form.php" class="text-white text-decoration-none fw-medium">
            <i class="fas fa-user-plus me-2"></i>New Patient
          </a>
          <a href="view.php" class="text-white text-decoration-none fw-medium">
            <i class="fas fa-list-ul me-2"></i>View Records
          </a>
        </div>
      </nav>
    </div>
  </header>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

