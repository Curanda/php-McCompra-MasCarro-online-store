<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['outOfStockItems'])) {
    $_SESSION['outOfStockItems'] = array();
}

if (isset($_POST['product_id']) && isset($_POST['product_name']) && isset($_POST['product_price']) && isset($_POST['max_quantity'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $max_quantity = $_POST['max_quantity'];
    
    if (!isset($_SESSION['order'])) {
        $_SESSION['order'] = array(
            $product_id => array(
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => 1,
                'max_quantity' => $max_quantity
            )
        );
    } else {
        if (isset($_SESSION['order'][$product_id])) {
            if ($_SESSION['order'][$product_id]['quantity'] < $max_quantity) {
                $_SESSION['order'][$product_id]['quantity']++;
            }
            if ($_SESSION['order'][$product_id]['quantity'] >= $max_quantity) {
                if (!in_array($product_id, $_SESSION['outOfStockItems'])) {
                    $_SESSION['outOfStockItems'][] = $product_id;
                }
            }
        } else {
            $_SESSION['order'][$product_id] = array(
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => 1,
                'max_quantity' => $max_quantity
            );
        }
    }
}

if (isset($_POST['increaseQuantity'])) {
    $product_id = $_POST['increaseQuantity'];
    if ($_SESSION['order'][$product_id]['quantity'] < $_SESSION['order'][$product_id]['max_quantity']) {
        $_SESSION['order'][$product_id]['quantity']++;
    } else {
        array_push($_SESSION['outOfStockItems'], $_SESSION['order'][$product_id]);
    }

    if (isset($_SESSION['user'])) {
        header('Location: indexLoggedIn.php?view=order');
    } else {
        header('Location: index.php?view=order');
    }
    exit;
}

if (isset($_POST['decreaseQuantity'])) {
    $product_id = $_POST['decreaseQuantity'];
    
    if ($_SESSION['order'][$product_id]['quantity'] > 1) {
        $_SESSION['order'][$product_id]['quantity']--;
    } else {
        unset($_SESSION['order'][$product_id]);
    }
    
    if (in_array($product_id, $_SESSION['outOfStockItems'])) {
        $key = array_search($product_id, $_SESSION['outOfStockItems']);
        unset($_SESSION['outOfStockItems'][$key]);
    }
    if (isset($_SESSION['user'])) {
        header('Location: indexLoggedIn.php?view=order');
    } else {
        header('Location: index.php?view=order');
    }
    exit;
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

        $sqlUpdate = "UPDATE products SET stock = CASE ";
        foreach ($_SESSION['order'] as $product_id => $product_data) {
            $quantity = $product_data['quantity'];
            $sqlUpdate .= "WHEN id = $product_id THEN stock - $quantity ";
        }
        $sqlUpdate .= "ELSE stock END WHERE id IN (" . implode(',', array_keys($_SESSION['order'])) . ")";
        
        if (!mysqli_query($conn, $sqlUpdate)) {
            $_SESSION['order_error1'] = "There was an error updating the stock: ". $conn->error;
            header('Location: indexLoggedIn.php?view=order');
            exit;
        }

        $sql = "INSERT INTO orders (userId, products, name, lastname, address, city, postalCode, phone, email, status, total) 
        VALUES ('$userId', '$products', '$name', '$lastname', '$address', '$city', '$postalCode', '$phone', '$email', '$status', '$total')";


        if (mysqli_query($conn, $sql)) {
            unset($_SESSION['order_error']);
            $_SESSION['last_order_id'] = $conn->insert_id;
            header('Location: indexLoggedIn.php?view=orderconfirmed');
            unset($_SESSION['order']);
            exit;
        } else {
            $_SESSION['order_error'] = "There was an error sending the order but the items were reserved: please inquire by email or phone" . $conn->error;
            header('Location: indexLoggedIn.php?view=order');
            exit;
        }

    } catch (Exception $e) {
        error_log("Order Error: " . $e->getMessage()); 
        $_SESSION['order_error'] = $e->getMessage();
        header('Location: indexLoggedIn.php?view=order');
        exit;
    }
}

if (isset($_POST['redirect'])) {
    if (isset($_SESSION['user'])) {
        header('Location: indexLoggedIn.php?view=' . $_POST['redirect']);
    } else {
        header('Location: index.php?view=' . $_POST['redirect']);
    }
    exit;
}

exit;
?>