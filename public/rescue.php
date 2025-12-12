<?php
// rescue.php - Bypass Laravel to wipe the DB
try {
    // 1. Get credentials directly from Vercel Environment
    $host = getenv('POSTGRES_HOST');
    $dbname = getenv('POSTGRES_DATABASE');
    $user = getenv('POSTGRES_USER');
    $password = getenv('POSTGRES_PASSWORD');

    if (!$host) {
        die("Error: Could not read Environment Variables. Are you sure they are set in Vercel?");
    }

    // 2. Connect directly using PDO (No Laravel)
    $dsn = "pgsql:host=$host;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to database successfully...<br>";

    // 3. The Nuclear Wipe (Raw SQL)
    // This drops the entire schema and recreates it. Cleaner than dropping tables.
    $pdo->exec("DROP SCHEMA public CASCADE;");
    $pdo->exec("CREATE SCHEMA public;");
    $pdo->exec("GRANT ALL ON SCHEMA public TO public;");

    echo "<h1>SUCCESS! Database wiped clean.</h1>";
    echo "<p>The 'Ghost Tables' are gone.</p>";
    echo "<p>Now you can click this link to run the migrations: <a href='/fix-db'>/nuke-db</a></p>";

} catch (PDOException $e) {
    echo "<h1>Error</h1>";
    echo "Message: " . $e->getMessage();
}
?>