<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint System Home</title>
    <!-- Add Bootstrap CSS and JS links here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        /* General body styling */
        body {
            background-image: url('background-image.jpg'); /* Replace with your background image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #ffffff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding-top: 56px; /* Offset to ensure navbar doesn't overlap content */
        }

        /* Navbar styling */
        .navbar {
            background-color: #007bff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: bold;
            color: #fff !important;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 500;
            transition: color 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: #ffd700 !important;
        }

        /* Container styling */
        .content-container {
            max-width: 600px;
            padding: 60px 30px;
            background-color: rgba(0, 0, 0, 0.8); /* Darkened, semi-transparent background */
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
            text-align: center;
            color: #f1f1f1;
            margin: 0 auto;
        }

        h2 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #ffd700;
        }

        p {
            font-size: 1.1rem;
            margin-bottom: 30px;
        }

        /* Button styling */
        .btn-custom {
            background-color: #ffd700;
            color: #333;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 25px;
            transition: background-color 0.3s;
            box-shadow: 0 4px 8px rgba(255, 215, 0, 0.4);
        }

        .btn-custom:hover {
            background-color: #ffcc00;
            color: #000;
        }
    </style>
</head>
<body>
    <!-- Full-width Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Complaint System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="user_login.php">User Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user_register.php">User Signup</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_login.php">Admin Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content-container mt-5">
        <h2>Welcome to the Complaint System</h2>
        <p>Submit your complaints and track their status efficiently and transparently.</p>
        <a href="user_register.php" class="btn btn-custom">Get Started</a>
    </div>
</body>
</html>
