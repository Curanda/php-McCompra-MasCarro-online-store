<?php
session_start();
require_once 'functions.php';

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

exit;
?>