<?php
include 'server/connection.php';

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch student details
    $sql = "SELECT * FROM students WHERE students_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Student not found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        header {
            text-align: center;
            background-color: #007bff;
            color: white;
            padding: 20px 0;
            font-size: 24px;
            font-weight: 600;
        }
        .container {
            width: 50%;
            margin: 30px auto;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        button, a {
            text-decoration: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            font-weight: 600;
            color: white;
            text-align: center;
            transition: background-color 0.3s;
        }
        button {
            background-color: #007bff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        a {
            background-color: #6c757d;
            display: inline-block;
        }
        a:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <header>Update Student</header>
    <div class="container">
        <form action="update_student_process.php" method="POST">
            <input type="hidden" name="students_id" value="<?php echo $student['students_id']; ?>">

            <div class="form-group">
                <label for="student_name">Student Name:</label>
                <input type="text" name="student_name" id="student_name" value="<?php echo $student['student_name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select name="gender" id="gender" required>
                    <option value="Male" <?php echo $student['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo $student['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" value="<?php echo $student['address']; ?>" required>
            </div>

            <div class="form-group">
                <label for="birth_date">Birth Date:</label>
                <input type="date" name="birth_date" id="birth_date" value="<?php echo $student['birth_date']; ?>" required>
            </div>

            <div class="form-group">
                <label for="course">Course:</label>
                <input type="text" name="course" id="course" value="<?php echo $student['course']; ?>" required>
            </div>

            <div class="form-group">
                <label for="block">Block:</label>
                <input type="text" name="block" id="block" value="<?php echo $student['block']; ?>" required>
            </div>

            <div class="buttons">
                <button type="submit">Update</button>
                <button type="submit">Cancel</button>
            </div>
        </form>
    </div>
</body>
</html>
