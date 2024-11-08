<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('config.php');

    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Insert user into the database
        $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

        if (mysqli_query($conn, $query)) {
            $_SESSION['status'] = "Registration successful! Please log in.";
            $_SESSION['status_type'] = "success";
            header("Location: user_login.php");
            exit();
        } else {
            $_SESSION['status'] = "Error: Could not complete registration.";
            $_SESSION['status_type'] = "danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Signup</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
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
        .signup-container {
            max-width: 400px;
            width: 100%;
            padding: 40px 30px;
            background-color: rgba(0, 0, 0, 0.8); /* Darkened, semi-transparent background */
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
            text-align: center;
            color: #f1f1f1;
            margin: 0 auto;
        }

        h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #ffd700;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            text-align: left;
            color: #ddd;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 5px;
            border: none;
            border-radius: 5px;
            outline: none;
            background-color: #333;
            color: #fff;
        }

        .error-message {
            color: #ff4c4c;
            font-size: 0.9rem;
            margin-top: 5px;
            text-align: left;
        }

        .btn-signup {
            background-color: #ffd700;
            color: #333;
            font-weight: bold;
            padding: 10px 20px;
            width: 100%;
            border: none;
            border-radius: 25px;
            transition: background-color 0.3s;
            box-shadow: 0 4px 8px rgba(255, 215, 0, 0.4);
            margin-top: 10px;
        }

        .btn-signup:hover {
            background-color: #ffcc00;
            color: #000;
        }

        .login-link {
            color: #ffd700;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link:hover {
            color: #ffcc00;
        }
    </style>
    <script>
        function validateForm() {
            let isValid = true;

            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;

            const usernameError = document.getElementById("usernameError");
            const passwordError = document.getElementById("passwordError");

            const usernameRegex = /^[a-z0-9]+$/;
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/;

            // Clear previous error messages
            usernameError.textContent = "";
            passwordError.textContent = "";

            // Username validation
            if (!usernameRegex.test(username)) {
                usernameError.textContent = "Username can only contain lowercase letters and numbers.";
                isValid = false;
            }

            // Password validation
            if (!passwordRegex.test(password)) {
                passwordError.textContent = "Password must be 8-20 characters, include at least one uppercase, one lowercase, one number, and one special character.";
                isValid = false;
            }

            return isValid;
        }
    </script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Complaint System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    <li class="nav-item">
                        <a class="nav-link" href="user_login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Signup Container -->
    <div class="signup-container mt-5">
        <h2>User Registration</h2>

        <!-- Display Success or Error Message -->
        <?php if (isset($_SESSION['status'])): ?>
            <div class="alert alert-<?php echo $_SESSION['status_type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['status']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['status']); unset($_SESSION['status_type']); ?>
        <?php endif; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <p id="usernameError" class="error-message"></p>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <p id="passwordError" class="error-message"></p>

            <input type="submit" name="register" value="Sign Up" class="btn-signup">
        </form>

        <p>Already have an account? <a href="user_login.php" class="login-link">Login here</a></p>
    </div>
</body>
</html>
