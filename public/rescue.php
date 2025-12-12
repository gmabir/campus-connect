<?php
// public/rescue.php
$host = getenv('POSTGRES_HOST');
$dbname = getenv('POSTGRES_DATABASE');
$user = getenv('POSTGRES_USER');
$password = getenv('POSTGRES_PASSWORD');

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->exec("DROP SCHEMA public CASCADE; CREATE SCHEMA public;");
    echo "<h1>SUCCESS! Database Wiped.</h1>";
} catch (Exception $e) {
    echo "<h1>Error: " . $e->getMessage() . "</h1>";
}
?>