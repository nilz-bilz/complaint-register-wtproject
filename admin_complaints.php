<!-- admin_complaints.php -->
<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

require('config.php');

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM complaints WHERE id = $delete_id";
    mysqli_query($conn, $delete_query);
    header("Location: admin_complaints.php");
    exit();
}

// Handle mark as read/unread action
if (isset($_GET['toggle_read_id'])) {
    $toggle_read_id = intval($_GET['toggle_read_id']);
    $current_status_query = "SELECT status FROM complaints WHERE id = $toggle_read_id";
    $result = mysqli_query($conn, $current_status_query);
    $current_status = mysqli_fetch_assoc($result)['status'];

    $new_status = $current_status === 'read' ? 'unread' : 'read';
    $toggle_status_query = "UPDATE complaints SET status = '$new_status' WHERE id = $toggle_read_id";
    mysqli_query($conn, $toggle_status_query);

    header("Location: admin_complaints.php");
    exit();
}

// Fetch complaints from the database
$query = "SELECT complaints.*, users.username FROM complaints JOIN users ON complaints.user_id = users.id ORDER BY complaints.timestamp DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Complaint Dashboard</title>
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
            max-width: 800px;
            width: 100%;
            padding: 40px 30px;
            background-color: rgba(0, 0, 0, 0.8); /* Darkened, semi-transparent background */
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
            color: #f1f1f1;
            margin: 0 auto;
            text-align: center;
        }

        h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #ffd700;
            margin-bottom: 20px;
        }

        /* Table styling with internal scroll */
        .table-container {
            max-height: 400px;
            overflow-y: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #444;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Styling for read complaints */
        .read-complaint {
            color: #888;
        }

        /* Icon button styling */
        .action-icon {
            cursor: pointer;
            font-size: 1.2rem;
            margin-right: 10px;
        }
        .icon-read {
            color: #ffd700;
        }
        .icon-delete {
            color: red;
        }
        .icon-read:hover, .icon-delete:hover {
            opacity: 0.8;
        }

        /* Logout link styling */
        .logout-link {
            color: #ffd700;
            text-decoration: none;
            font-weight: bold;
            display: block;
            margin-top: 20px;
        }

        .logout-link:hover {
            color: #ffcc00;
        }
    </style>
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
                        <a class="nav-link" href="admin_logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Complaints Container -->
    <div class="complaints-container mt-5">
        <h2>Welcome, Admin <?php echo $_SESSION['admin_username']; ?></h2>
        
        <!-- Table with Scrollable Container -->
        <div class="table-container">
            <table>
                <tr>
                    <th>User</th>
                    <th>Complaint</th>
                    <th>Timestamp</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr class="<?php echo $row['status'] === 'read' ? 'read-complaint' : ''; ?>">
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['complaint_text']); ?></td>
                        <td><?php echo htmlspecialchars($row['timestamp']); ?></td>
                        <td>
                            <!-- Toggle Read/Unread Button -->
                            <a href="?toggle_read_id=<?php echo $row['id']; ?>" class="action-icon icon-read" title="Toggle Read/Unread">
                                <?php echo $row['status'] === 'read' ? '&#10004' : '👁'; ?>
                            </a>
                            <!-- Delete Button -->
                            <a href="?delete_id=<?php echo $row['id']; ?>" class="action-icon icon-delete" title="Delete" onclick="return confirm('Are you sure you want to delete this complaint?');">🗑️</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <a href="admin_logout.php" class="logout-link">Logout</a>
    </div>
</body>
</html>
