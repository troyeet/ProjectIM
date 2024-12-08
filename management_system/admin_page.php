<?php
session_start();
include 'server/connection.php';

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'a') {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['user_id'];

// Fetch admin details (optional)
$query_admin = "SELECT * FROM users WHERE user_id = '$admin_id' AND user_type = 'a'";
$result_admin = mysqli_query($conn, $query_admin);
if (!$result_admin || mysqli_num_rows($result_admin) != 1) {
    echo "Admin not found!";
    exit();
}

// Fetch search term
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$sql = "SELECT students_id, student_name, course, block FROM students";
if ($searchTerm) {
    $sql .= " WHERE student_name LIKE '%" . $conn->real_escape_string($searchTerm) . "%' 
              OR course LIKE '%" . $conn->real_escape_string($searchTerm) . "%' 
              OR block LIKE '%" . $conn->real_escape_string($searchTerm) . "%'";
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

    <div class="nav">
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search...">
            <button id="searchBtn">Search</button>
            <div id="suggestionsBox" class="suggestions" style="display: none;"></div>
        </div>

        <div class="user-account">
            <a href="Logout.php">Logout</a>
        </div>
    </div>

    <div class="profile">
        <div class="welcome">Welcome, ADMIN!</div>
    </div>

    <div class="add-student-btn">
      <a href="add_student_admin.php" class="add-btn">Add Student</a> 
    </div>

    <table>
        <thead>
            <tr>
                <th>View</th>
                <th>Student name</th>
                <th>Course & Block</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><a href='view_student.php?id=" . $row['students_id'] . "'>View</a></td>";
                    echo "<td>" . $row['student_name'] . "</td>";
                    echo "<td>" . $row['course'] . " " . $row['block'] . "</td>";
                    echo "<td><a href='update_student.php?id=" . $row['students_id'] . "' class='update-btn'>Update</a>
                          <a href='delete_student.php?id=" . $row['students_id'] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No students found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <footer>
        &copy; 2024 Student Management System. All rights reserved.
    </footer>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("searchInput");
        const suggestionsBox = document.getElementById("suggestionsBox");
        const searchBtn = document.getElementById("searchBtn");

        let activeIndex = -1;

        const highlightText = (text, term) => {
            const regex = new RegExp(`(${term})`, 'gi');
            return text.replace(regex, "<strong>$1</strong>");
        };

        searchInput.addEventListener("input", async () => {
            const searchTerm = searchInput.value.trim();
            activeIndex = -1;

            if (searchTerm.length >= 2) {
                const response = await fetch(`search_suggestions.php?term=${searchTerm}`);
                const suggestions = await response.json();

                if (suggestions.length > 0) {
                    suggestionsBox.innerHTML = suggestions.map(suggestion => 
                        `<div class="suggestion-item" data-id="${suggestion.id}">
                            ${highlightText(suggestion.name, searchTerm)}
                        </div>`
                    ).join('');
                    suggestionsBox.style.display = 'block';
                } else {
                    suggestionsBox.innerHTML = `<div class="suggestion-item">No results found</div>`;
                    suggestionsBox.style.display = 'block';
                }
            } else {
                suggestionsBox.style.display = 'none';
            }
        });

        searchInput.addEventListener("keydown", (e) => {
            const items = document.querySelectorAll(".suggestion-item");
            if (e.key === "ArrowDown") {
                activeIndex = (activeIndex + 1) % items.length;
                setActive(items);
            } else if (e.key === "ArrowUp") {
                activeIndex = (activeIndex - 1 + items.length) % items.length;
                setActive(items);
            } else if (e.key === "Enter" && activeIndex >= 0) {
                items[activeIndex].click();
            }
        });

        const setActive = (items) => {
            items.forEach((item, index) => {
                item.classList.toggle("active", index === activeIndex);
            });
        };

        suggestionsBox.addEventListener("click", (e) => {
            const selectedSuggestion = e.target.closest(".suggestion-item");
            if (selectedSuggestion) {
                const studentId = selectedSuggestion.getAttribute('data-id');
                window.location.href = `view_student.php?id=${studentId}`;
            }
        });

        searchBtn.addEventListener("click", () => {
            const searchTerm = searchInput.value.trim();
            if (searchTerm) {
                window.location.href = `admin_page.php?search=${searchTerm}`;
            }
        });

        document.addEventListener("click", (e) => {
            if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.style.display = 'none';
            }
        });
    });
    </script>
</body>
</html>
