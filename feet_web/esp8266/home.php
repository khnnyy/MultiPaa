<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GreenCare Diagnostics</title>
  
  <!-- Bootstrap CSS -->
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
      display: flex;
      flex-direction: column;
    }

    .navbar {
      background: var(--primary-color) !important;
      box-shadow: 0 2px 15px rgba(76, 175, 80, 0.2);
    }

    .brand-text {
      font-weight: 700;
      color: white !important;
      letter-spacing: 1.5px;
    }

    .hero-section {
      background: linear-gradient(rgba(76, 175, 80, 0.9), rgba(76, 175, 80, 0.8)),
                  url('https://images.unsplash.com/photo-1581595218870-97cfe169ec4e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
      background-size: cover;
      background-position: center;
      color: white;
      border-radius: 15px;
      padding: 4rem 2rem;
      margin-top: 2rem;
      box-shadow: 0 10px 30px rgba(76, 175, 80, 0.2);
    }

    .feature-card {
      background: white;
      border: none;
      border-radius: 15px;
      transition: transform 0.3s ease;
      box-shadow: 0 5px 15px rgba(76, 175, 80, 0.1);
    }

    .feature-card:hover {
      transform: translateY(-10px);
    }

    .btn-custom {
      background: var(--primary-color);
      border: none;
      padding: 1rem 2.5rem;
      font-size: 1.1rem;
      transition: all 0.3s ease;
    }

    .btn-custom:hover {
      background: var(--primary-hover);
      transform: translateY(-2px);
    }

    .icon-wrapper {
      width: 80px;
      height: 80px;
      background: rgba(76, 175, 80, 0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
    }

    .feature-icon {
      font-size: 2rem;
      color: var(--primary-color);
    }
  </style>
</head>

<body>
  <?php include "includes/header.php" ?>

  <!-- Hero Section -->
  <div class="container mt-5">
    <div class="hero-section text-center">
      <h1 class="display-4 fw-bold mb-4">Welcome to MultiPaa Diagnostics</h1>
      <p class="lead mb-5">Precision in every test, care in every result</p>
      <div class="d-flex justify-content-center gap-4">
        <a href="patient_form.php" class="btn btn-light btn-lg px-5 py-3 fw-bold">
          <i class="fas fa-user-plus me-2"></i>New Patient
        </a>
        <a href="view.php" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold">
          <i class="fas fa-list-ul me-2"></i>View Records
        </a>
      </div>
    </div>

    <!-- Features Section -->
    <div class="row g-5 mt-5 mb-5">
      <div class="col-md-4">
        <div class="feature-card text-center p-4">
          <div class="icon-wrapper">
            <i class="feature-icon fas fa-vial"></i>
          </div>
          <h3 class="mb-3">Advanced Testing</h3>
          <p class="text-muted">State-of-the-art laboratory equipment for accurate results</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center p-4">
          <div class="icon-wrapper">
            <i class="feature-icon fas fa-clock"></i>
          </div>
          <h3 class="mb-3">Quick Results</h3>
          <p class="text-muted">Fast turnaround time with secure online reporting</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center p-4">
          <div class="icon-wrapper">
            <i class="feature-icon fas fa-shield-alt"></i>
          </div>
          <h3 class="mb-3">Secure Records</h3>
          <p class="text-muted">HIPAA-compliant patient data management system</p>
        </div>
      </div>
    </div>
  </div>

  <?php include "includes/footer.php" ?>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>