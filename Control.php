<?php
// Start a session
session_start();

// Database connection configuration
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'innocent'; // Change this to your database name

// Create a database connection
$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

// Check if the connection was successful
if (!$connection) {
    die("No connection: " . mysqli_connect_error());
}

// Function to validate user credentials
function authenticateUser($username, $password, $connection) {
    $sql = "SELECT * FROM table5 WHERE username='$username' AND Password='$password'";
    $result = mysqli_query($connection, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        return true; // Authentication successful
    } else {
        return false; // Authentication failed
    }
}

// Login logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['LOGIN'])) {
    $username = $_POST['username'];
    $Password = $_POST['Password'];
    
    if (authenticateUser($username, $Password, $connection)) {
        $_SESSION['username'] = $username;
        header("Location: Website.html");
        exit();
    } else {
        echo "Wrong username or password";
    }
}

// Registration logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['REGISTER'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $Password = $_POST['Password'];
    
    // Check if the username or email is already taken
    $checkSql = "SELECT * FROM table5 WHERE username='$username' OR email='$email'";
    $checkResult = mysqli_query($connection, $checkSql);
    
    if (mysqli_num_rows($checkResult) > 0) {
        echo "username or email already exists";
    } else {
        // Insert the new user into the database
        $insertSql = "INSERT INTO table5 (fullname, username, email, contact, Password) VALUES ('$fullname', '$username', '$email', '$contact', '$Password')";
        if (mysqli_query($connection, $insertSql)) {
            $_SESSION['username'] = $username;
            header("Location: Login.html");
            exit();
        } else {
            echo "Sign up failed";
        }
    }
}
?>
