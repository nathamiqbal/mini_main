<?php
// Database connection settings
$servername = "localhost";
$username = "natha";
$password = "Natha&2020";
$dbname = "Assistance";

// Create a new user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $age = $_POST["age"];
    $caretaker = $_POST["caretaker"];
    $phone = $_POST["phone"];
    $emergency = $_POST["emergency"];

    // Create a new database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (name, age, caretaker_name, phone, emergency_contact) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisss", $name, $age, $caretaker, $phone, $emergency);

    // Execute the statement
    if ($stmt->execute()) {
        $message = "User created successfully.";
    } else {
        $error = "Error creating user: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
</head>
<body>
    <h1>Sign Up</h1>

    <?php
    // Show error or success message
    if (isset($error)) {
        echo "<p style='color: red'>$error</p>";
    } else if (isset($message)) {
        echo "<p style='color: green'>$message</p>";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="age">Age:</label>
        <input type="number" name="age" required><br>

        <label for="caretaker">Caretaker Name:</label>
        <input type="text" name="caretaker" required><br>

        <label for="phone">Phone:</label>
        <input type="tel" name="phone" required><br>

        <label for="emergency">Emergency Contact:</label>
        <input type="tel" name="emergency" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <input type="submit" value="Sign Up">
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
</body>
</html>
