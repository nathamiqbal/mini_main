<?php
// Database connection settings
$servername = "localhost";
$username = "natha";
$password = "Natha&2020";
$dbname = "Assistance";

// Authenticate user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];

    // Create a new database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE name = ? AND email = ?");
    $stmt->bind_param("ss", $name, $email);

    // Execute the statement
    $stmt->execute();

    // Store the result
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found, redirect to the dashboard or home page
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or email.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <?php
    // Show error message
    if (isset($error)) {
        echo "<p style='color: red'>$error</p>";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <input type="submit" value="Login">
    </form>

    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
</body>
</html>
