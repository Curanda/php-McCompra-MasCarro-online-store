<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mccompra_mascarro";
global $conn;


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_errno == 1049) {
    $connTemp = openTempConnection($servername, $username, $password);
    createDB($connTemp);
    createTables($connTemp);
    insertData($connTemp);
    mysqli_close($connTemp);
    $conn = openConnection($servername, $username, $password, $dbname);
} else if ($conn->connect_error) {
    exit("Database connection error");
}

function openTempConnection($servername, $username, $password) {
    $connTemp = new mysqli($servername, $username, $password);
    return $connTemp;
}

function openConnection($servername, $username, $password, $dbname) {
    $conn = new mysqli($servername, $username, $password, $dbname);
    return $conn;
}

function createDB($connTemp) {
    $sql = "CREATE DATABASE IF NOT EXISTS mccompra_mascarro CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    mysqli_query($connTemp, $sql) or exit("Database creation failed");
}

function createTables($connTemp) {
    $sql = "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        userName VARCHAR(255) NOT NULL,
        history TEXT,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        INDEX (userName)
    )";
    mysqli_query($connTemp, $sql) or exit("Table creation failed");

    $sql = "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        category VARCHAR(255) NOT NULL,
        subcategory VARCHAR(255) NOT NULL,
        imageURL VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        stock INT NOT NULL,
        FOREIGN KEY (category) REFERENCES categories(category),
        FOREIGN KEY (subcategory) REFERENCES subcategories(subcategory)
    )";
    mysqli_query($connTemp, $sql) or exit("Table creation failed");

    $sql = "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        userId INT NOT NULL,
        products INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        lastname VARCHAR(255) NOT NULL,
        address VARCHAR(255) NOT NULL,
        city VARCHAR(255) NOT NULL,
        postalCode VARCHAR(10) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        email VARCHAR(255) NOT NULL,
        status VARCHAR(20) NOT NULL,
        total DECIMAL(10,2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (userId) REFERENCES users(id),
        FOREIGN KEY (email) REFERENCES users(email)
    )";
    mysqli_query($connTemp, $sql) or exit("Table creation failed");

    $sql = "CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category VARCHAR(255) NOT NULL UNIQUE,
        INDEX (category)
    )";
    mysqli_query($connTemp, $sql) or exit("Table creation failed");

    $sql = "CREATE TABLE IF NOT EXISTS subcategories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category VARCHAR(255) NOT NULL,
        subcategory VARCHAR(255) NOT NULL UNIQUE,
        imageURL VARCHAR(255) NOT NULL,
        INDEX (subcategory),
        FOREIGN KEY (category) REFERENCES categories(category)
    )";
    mysqli_query($connTemp, $sql) or exit("Table creation failed");
}

function insertData($connTemp) {
    $sql = "INSERT INTO users (userName, history, email, password) VALUES ('admin', '', 'admin@gmail.com', 'admin')";
    mysqli_query($connTemp, $sql) or exit("Data insertion failed");

    $sql = "INSERT INTO categories (category) VALUES ('Quantum Harmonizing'), ('Void Anchoring & Stabilization'), ('Temporal Flux & Phasing'), ('Molecular Binding & Fusion')";
    mysqli_query($connTemp, $sql) or exit("Data insertion failed");

    $sql = "INSERT INTO subcategories (category, subcategory, imageURL) VALUES ('Quantum Harmonizing', 'Small Harmonizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum1.png?raw=true'), ('Quantum Harmonizing', 'Medium Harmonizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum2.png?raw=true'), ('Quantum Harmonizing', 'Large Harmonizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum3.png?raw=true')";
    mysqli_query($connTemp, $sql) or exit("Data insertion failed");

    $sql = "INSERT INTO products (name, category, subcategory, imageURL, description, price, stock) VALUES ('Small Harmonizer', 'Quantum Harmonizing', 'Small Harmonizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum1.png?raw=true', 'This is a small harmonizer', 100, 100)";
    mysqli_query($connTemp, $sql) or exit("Data insertion failed");
}

?> 