<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

require('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaint_text = $_POST['complaint_text'];
    $user_id = $_SESSION['user_id'];

    // Server-side validation for character limit
    if (strlen($complaint_text) > 500) {
        $_SESSION['status'] = "Complaint text exceeds the 500 character limit.";
        $_SESSION['status_type'] = "danger";
    } else {
        $query = "INSERT INTO complaints (user_id, complaint_text) VALUES ($user_id, '$complaint_text')";

        if (mysqli_query($conn, $query)) {
            $_SESSION['status'] = "Complaint submitted successfully!";
            $_SESSION['status_type'] = "success";
        } else {
            $_SESSION['status'] = "Error submitting complaint. Please try again.";
            $_SESSION['status_type'] = "danger";
        }

        // Redirect to avoid form resubmission on page refresh
        header("Location: user_complaints.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Complaints</title>
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
        .complaints-container {
            max-width: 600px;
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
            display: block;
            text-align: left;
            margin-top: 10px;
            color: #ddd;
        }

        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: none;
            border-radius: 5px;
            outline: none;
            background-color: #333;
            color: #fff;
        }

        .character-count {
            text-align: right;
            font-size: 0.9rem;
            color: #ddd;
        }

        .error-message {
            color: #ff4c4c;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .btn-submit {
            background-color: #ffd700;
            color: #333;
            font-weight: bold;
            padding: 10px 20px;
            width: 100%;
            border: none;
            border-radius: 25px;
            transition: background-color 0.3s;
            box-shadow: 0 4px 8px rgba(255, 215, 0, 0.4);
            margin-top: 15px;
        }

        .btn-submit:hover {
            background-color: #ffcc00;
            color: #000;
        }

        .logout-link {
            color: #ffd700;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
            display: inline-block;
        }

        .logout-link:hover {
            color: #ffcc00;
        }
    </style>
    <script>
        function updateCharacterCount() {
            const maxChars = 500;
            const complaintText = document.getElementById("complaint_text").value;
            const remainingChars = maxChars - complaintText.length;
            const characterCount = document.getElementById("characterCount");
            
            characterCount.textContent = `${remainingChars} characters remaining`;

            // If character limit is exceeded, disable submit button and show error
            const submitButton = document.getElementById("submitButton");
            if (remainingChars <= 0) {
                characterCount.style.color = "#ff4c4c";
                submitButton.disabled = true;
            } else {
                characterCount.style.color = "#ddd";
                submitButton.disabled = false;
            }
        }

        function validateForm() {
            const complaintText = document.getElementById("complaint_text").value;
            if (complaintText.length > 500) {
                alert("Complaint text exceeds the 500 character limit.");
                return false;
            }
            return true;
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
                        <a class="nav-link" href="user_logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Complaints Container -->
    <div class="complaints-container mt-5">
        <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
        
        <!-- Alert Message -->
        <?php if (isset($_SESSION['status'])): ?>
            <div class="alert alert-<?php echo $_SESSION['status_type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['status']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['status']); unset($_SESSION['status_type']); ?>
        <?php endif; ?>

        <!-- Complaint Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
            <label for="complaint_text">Complaint:</label>
            <textarea id="complaint_text" name="complaint_text" rows="4" oninput="updateCharacterCount()" required></textarea>
            <p class="character-count" id="characterCount">500 characters remaining</p>

            <input type="submit" value="Submit Complaint" class="btn-submit" id="submitButton">
        </form>

        <a href="user_logout.php" class="logout-link">Logout</a>
    </div>
</body>
</html>
