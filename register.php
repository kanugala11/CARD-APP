
<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username === '' || $password === '') {
        echo "Please fill all fields.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "Username already exists. <a href='register.php'>Try again</a>";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $ins->bind_param("ss", $username, $hash);
            if ($ins->execute()) {
                echo "Registration successful. <a href='login.php'>Login here</a>";
            } else {
                echo "Error: " . $conn->error;
            }
            $ins->close();
        }
        $stmt->close();
    }
}
?>
<!-- ...existing HTML... -->
<h2>Register</h2>
<form method="POST" action="">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Register">
</form>

<p>Already have an account? <a href="login.php">Login here</a></p>