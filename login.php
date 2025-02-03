<?php
session_start();
require_once 'db_connection.php';
require_once 'functions.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    echo $email;
    loginUser($email, $password);
}



function loginUser($email, $password) {
    if (!empty($email) && !empty($password)) {
        $user = verifyLogin($email, $password);

        if ($user) {
            $_SESSION['user'] = $user;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['userName'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['stayLoggedIn'] = isset($_POST['stayLoggedIn']) ? true : false;
            $_SESSION['history'] = $user['history'];
            echo "User ID: " . $_SESSION['user_id'];                    
            header('Location: indexLoggedIn.php');
            exit;
        } else {
            $_SESSION['login_error'] = 'Invalid username or password';
            header('Location: index.php');
            exit;
        }
    }
}

function verifyLogin($email, $password) {
    global $conn;
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);
    
    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($query);
    
    if ($result->num_rows === 1) {
        return $result->fetch_assoc();
    }
    return null;
}


?>