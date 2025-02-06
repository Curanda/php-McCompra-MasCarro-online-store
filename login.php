<?php
session_start();
require_once 'db_connection.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    $password = trim($_POST['password']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (strlen(trim($_POST['password'])) < 8) {
        $_SESSION['login_error'] = 'Password must be at least 8 characters long';
        header('Location: index.php');
        exit;
    } 
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['login_error'] = 'Invalid email address';
        header('Location: index.php');
        exit;
    }



    loginUser($email, $password);
}



function loginUser($email, $password) {
        $user = verifyLogin($email, $password);
        $_SESSION['login_error'] = null;

        if ($user) {
            $_SESSION['login_error'] = null;
            $_SESSION['user'] = $user;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['userName'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['stayLoggedIn'] = isset($_POST['stayLoggedIn']) ? true : false;
            $_SESSION['history'] = $user['history'];
            if (isset($_POST['stayLoggedIn'])) {
                $mccompracookie = ['username'=>$user['userName'],'email' => $email, 'password' => $password];
                setcookie('mccompracookie', json_encode($mccompracookie), time() + (30 * 24 * 60 * 60), "/");
            }
            header('Location: indexLoggedIn.php');
            exit;
        } else {
            $_SESSION['login_error'] = 'Invalid username or password';
            header('Location: index.php');
            exit;
        }
}

function verifyLogin($email, $password) {
    global $conn;
    
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);
    
    $query = "SELECT password FROM users WHERE email = '$email'";
    $result = $conn->query($query);
    $hashedPassword = $result->fetch_assoc();
    $query = password_verify($password, $hashedPassword['password']) ? "SELECT * FROM users WHERE email = '$email'" : null;
    $result = $conn->query($query);

    if ($result->num_rows === 1) {
        return $result->fetch_assoc();
    }

    $_SESSION['login_error'] = 'Invalid username or password';
    return null;
}

?>