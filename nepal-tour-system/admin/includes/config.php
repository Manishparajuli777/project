<?php
// Nepal Tourism Management System - Database Configuration

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'nepal_tourism_db');

try {
    $dbh = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false
        )
    );
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}

// System Constants
define('SITE_NAME', 'Nepal Tourism Management System');
define('SITE_TAGLINE', 'Explore the Wonders of Nepal');
define('CURRENCY', 'NPR');
define('CURRENCY_SYMBOL', 'Rs ');
?>
