<?php
session_start();
require_once 'db_connection.php';
require_once 'functions.php';

$_SESSION['searchResults'];

if (isset($_POST['searchButton'])) {
    $search = $_POST['search'];
    $sql = "SELECT * FROM products WHERE name LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $_SESSION['searchResults'] = $products;
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?view=search');
    } else {
        header('Location: indexLoggedIn.php?view=search');
    }
    exit();
}

function displaySearchResults() {
    $products = $_SESSION['searchResults'];
    $str = '<div class="flex justify-start items-start flex-col">
                <h1 class="text-lg font-semibold text-[#346734]">Search Results</h1>
                <hr class="border-[#346734] w-full mb-4" />
                <div class="flex flex-row flex-wrap justify-start items-start gap-4">';
    foreach ($products as $product) {
        $str .= renderProductCard($product);
    }
    $str .= '</div></div>';
    return $str;
}

?>

