<?php
$host = "localhost";
$db_name = "car_app";
$username = "root";
$password = "";

try {
    $connection = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
}
catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}
