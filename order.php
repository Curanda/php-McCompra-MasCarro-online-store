<?php
session_start();
require_once 'db_connection.php';

if (isset($_POST['product_id']) && isset($_POST['product_name']) && isset($_POST['product_price'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    
    if (!isset($_SESSION['order'])) {
        $_SESSION['order'] = array(
            $product_id => array(
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => 1
            )
        );
    } else {
        if (isset($_SESSION['order'][$product_id])) {
            $_SESSION['order'][$product_id]['quantity']++;
        } else {
            $_SESSION['order'][$product_id] = array(
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => 1
            );
        }
    }
}

if (isset($_POST['increaseQuantity'])) {
    $product_id = $_POST['increaseQuantity'];
    $_SESSION['order'][$product_id]['quantity']++;
    header('Location: indexLoggedIn.php?view=order');
    exit;
}

if (isset($_POST['decreaseQuantity'])) {
    $product_id = $_POST['decreaseQuantity'];
    if ($_SESSION['order'][$product_id]['quantity'] > 1) {
        $_SESSION['order'][$product_id]['quantity']--;
        header('Location: indexLoggedIn.php?view=order');
        exit;
    } else {
        unset($_SESSION['order'][$product_id]);
        header('Location: indexLoggedIn.php?view=order');
        exit;
    }
}

if (isset($_POST['checkout'])) {
    global $conn;
    $_SESSION['order_error'] = null;
    if (!$conn) {
        $_SESSION['order_error'] = "Failed to connect to database";
        header('Location: indexLoggedIn.php?view=order');
        exit;
    }

    try {
        $userId = $_SESSION['user_id'];
        $name = trim($_POST['name']);
        $lastname = trim($_POST['lastname']);
        $address = trim($_POST['address']);
        $city = trim($_POST['city']);
        $postalCode = trim($_POST['postalCode']);
        $phone = trim($_POST['phone']);
        $email = $_SESSION['email'];
        $products = json_encode($_SESSION['order']);
        $total = floatval($_POST['total']);
        $status = 'pending';

        $sql = "INSERT INTO orders (userId, products, name, lastname, address, city, postalCode, phone, email, status, total) 
        VALUES ('$userId', '$products', '$name', '$lastname', '$address', '$city', '$postalCode', '$phone', '$email', '$status', '$total')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['last_order_id'] = $conn->insert_id;
            header('Location: indexLoggedIn.php?view=orderconfirmed');
            unset($_SESSION['order']);
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            header('Location: indexLoggedIn.php?view=order');
            exit;
        }

    } catch (Exception $e) {
        error_log("Order Error: " . $e->getMessage());
        $_SESSION['order_error'] = "Failed to process order. Please try again.";
        header('Location: indexLoggedIn.php?view=order');
        exit;
    }
}

exit;
?>