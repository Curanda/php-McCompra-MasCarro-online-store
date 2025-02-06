<?php
session_start();
require_once 'db_connection.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['createLogin_error'] = 'Invalid email address';
        header('Location: index.php');
        exit;
    }
    if (strlen($password) < 8) {
        $_SESSION['createLogin_error'] = 'Password must be at least 8 characters long';
        header('Location: index.php');
        exit;
    }
    if (strlen($name) < 3) {
        $_SESSION['createLogin_error'] = 'Name must be at least 3 characters long';
        header('Location: index.php');
        exit;
    }
    if (strlen($name) > 20) {
        $_SESSION['createLogin_error'] = 'Name must be shorter than 20 characters';
        header('Location: index.php');
        exit;
    }

    $existingUser = verifyUserExists($email);
    if ($existingUser) {
        $_SESSION['createLogin_error'] = 'User already exists';
        header('Location: index.php');
        exit;
    }

    $userId = createUser($name, $email, $password);
    if ($userId) {
        $_SESSION['createLogin_error'] = null;
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['history'] = '';
        header('Location: indexLoggedIn.php');
        exit;
    }

    $_SESSION['createLogin_error'] = 'Failed to create user';
    header('Location: index.php');
    exit;
}

function verifyUserExists($email) {
    global $conn;
    $email = $conn->real_escape_string($email);
    
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($query);
    
    if ($result->num_rows === 1) {
        return $result->fetch_assoc();
    }
    return null;
}

function createUser($name, $email, $password) {
    global $conn;

    $password = password_hash($password, PASSWORD_DEFAULT);

    $name = $conn->real_escape_string($name);
    $history = $conn->real_escape_string('');
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    $query = "INSERT INTO users (userName, history, email, password) VALUES ('$name', '$history', '$email', '$password')";
    $conn->query($query);

    return $conn->insert_id;
}



?>