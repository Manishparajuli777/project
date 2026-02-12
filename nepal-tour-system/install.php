<?php
// Simple installer: creates database and imports includes/database-setup.sql
set_time_limit(0);
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'nepal_tourism_db';

try {
    $pdo = new PDO("mysql:host=$DB_HOST;charset=utf8mb4", $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$DB_NAME` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<p>Database <strong>$DB_NAME</strong> created or already exists.</p>";

    $pdo->exec("USE `$DB_NAME`");

    $sqlFile = __DIR__ . '/includes/database-setup.sql';
    if (!file_exists($sqlFile)) {
        throw new Exception('SQL file not found: ' . $sqlFile);
    }

    $sql = file_get_contents($sqlFile);
    $lines = explode("\n", $sql);
    $clean = '';

    foreach ($lines as $line) {
        $trim = trim($line);
        if ($trim === '' || strpos($trim, '--') === 0 || strpos($trim, '#') === 0) {
            continue;
        }
        $clean .= $line . "\n";
    }

    $statements = array_filter(array_map('trim', explode(';', $clean)));
    $ok = 0;
    $failed = 0;

    foreach ($statements as $stmt) {
        try {
            $pdo->exec($stmt);
            $ok++;
        } catch (Exception $e) {
            $failed++;
        }
    }

    echo "<p>Imported SQL statements: $ok successful" . ($failed ? ", $failed skipped" : "") . ".</p>";
    echo "<p>Installation complete. Remove or secure <strong>install.php</strong> after use.</p>";
    echo "<p>No sample tour packages were inserted. Add packages from the admin panel.</p>";
    echo "<p><a href='user/'>Open user portal</a> | <a href='admin/'>Open admin panel</a></p>";
} catch (Exception $e) {
    echo '<p style="color:red">Error: ' . htmlentities($e->getMessage()) . '</p>';
}
?>
