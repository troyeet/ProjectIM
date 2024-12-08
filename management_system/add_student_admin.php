<?php
include 'server/connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $studentName = $_POST['student_name'];
    $gender = $_POST['gender'];
    $birthDate = $_POST['birth_date'];
    $address = $_POST['address'];
    $course = $_POST['course'];
    $block = $_POST['block'];
    $status = $_POST['status'];
    $dateOfEntry = date('Y-m-d H:i:s'); // Get the current timestamp

    // Prepare the SQL query to insert the new student
    $sql = "INSERT INTO students (student_name, gender, birth_date, address, course, block, status, date_of_entry) 
            VALUES ('$studentName', '$gender', '$birthDate', '$address', '$course', '$block', '$status', '$dateOfEntry')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Redirect to the student list page after successful insertion
        header("Location: admin_page.php"); 
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="css/addStudentAdmin.css">
</head>
<body>

    <!-- Header -->
    <header>
        Add New Student
    </header>


    <!-- Add Student Form -->
    <div class="form-container">
        <form method="POST" action="add_student.php">
            <label for="student_name">Student Name:</label>
            <input type="text" id="student_name" name="student_name" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Transgender">Transgender</option>
                <option value="Bisexual">Bisexual</option>
                <option value="not to be specified">Not to be specified</option>
            </select>

            <label for="birth_date">Birth Date:</label>
            <input type="date" id="birth_date" name="birth_date" required>

            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea>

            <label for="course">Course:</label>
            <input type="text" id="course" name="course" required>

            <label for="block">Block:</label>
            <input type="text" id="block" name="block" required>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="r">Regular</option>
                <option value="i">Irregular</option>
                <option value="g">Graduate</option>
            </select>
            <button type="submit" class="btn">Add Student</button>
            
            <div class="submit">
            <a href="admin_page.php" class="btn">Cancel</a> 
            </div>
        </form>
    </div>

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

<?php
// Close connection
$conn->close();
?>
