<?php
session_start();
include 'server/connection.php';

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'u') {
    // Redirect to login page if not logged in or not an admin
    header("Location: login.php");
    exit();
}

// Get the logged-in user's ID
$admin_id = $_SESSION['user_id'];

// Fetch the admin details (optional, if you want to display admin info)
$query_admin = "SELECT * FROM users WHERE user_id = '$admin_id' AND user_type = 'u'";
$result_admin = mysqli_query($conn, $query_admin);

if ($result_admin && mysqli_num_rows($result_admin) == 1) {
    $admin = mysqli_fetch_assoc($result_admin);
} else {
    echo "users not found!";
    exit();
}




// Check if there's a search term
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Modify the SQL query to include the search filter
$sql = "SELECT students_id, student_name, course, status, block FROM students";
if ($searchTerm) {
    $sql .= " WHERE student_name LIKE '%" . $conn->real_escape_string($searchTerm) . "%' OR course LIKE '%" . $conn->real_escape_string($searchTerm) . "%' OR block LIKE '%" . $conn->real_escape_string($searchTerm) . "%'";
}


$result = $conn->query($sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="css/userpage.css">
</head>
<body>


    <!-- Navigation Bar -->
    <div class="nav">
    <div class="profile">
        <div class="welcome">
            Welcome, User!
        </div>
    </div>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search...">
            <button id="searchBtn">Search</button>
        </div>

        <div class="user-account">
            <a href="logout.php">Logout</a>
        </div>
    </div>

    

    <!-- Add Student Button -->
    <div class="add-student-btn">
      <a href="add_student.php" class="add-btn">Add Student</a> <!-- Link to add_student.php -->
    </div>


    <!-- Table Section -->
    <table>
    <thead>
        <tr>
            <th>View</th>
            <th>Student name</th>
            <th>Course & Block</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            // Output data for each student
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><a href='user_view_student.php?id=" . $row['students_id'] . "'>View</a></td>";
                echo "<td>" . $row['student_name'] . "</td>";
                echo "<td>" . $row['course'] . " " . $row['block'] . "</td>";
                echo "<td>";
                
                // Check the status and display corresponding text
                if ($row['status'] == 'r') {
                    echo "Regular";
                } elseif ($row['status'] == 'i') {
                    echo "Irregular";
                } elseif ($row['status'] == 'g') {
                    echo "Graduate";
                } else {
                    echo "Unknown"; // In case there is an unexpected value
                }

                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No students found</td></tr>";
        }
        ?>
    </tbody>
</table>

    <!-- Footer -->
    <footer>
        &copy; 2024 Student Management System. All rights reserved.
    </footer>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const searchBtn = document.getElementById("searchBtn");
        const searchInput = document.getElementById("searchInput");

        searchBtn.addEventListener("click", () => {
            const searchTerm = searchInput.value;
            window.location.href = `?search=${searchTerm}`; // Reload the page with the search query
        });

        // Optional: Add event listener for Enter key to trigger search
        searchInput.addEventListener("keydown", (e) => {
            if (e.key === "Enter") {
                searchBtn.click();
            }
        });
    });
    </script>

</body>
</html>
