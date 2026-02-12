<?php
// Wipe all packages so admin can add fresh ones later.
// WARNING: This deletes data. Use after install.
require_once __DIR__ . '/admin/includes/config.php';

try {
    $sql = "TRUNCATE TABLE tbltourpackages";
    $dbh->exec($sql);
    echo "<p>All packages removed from tbltourpackages.</p>";
    echo "<p><a href='admin/'>Go to Admin Panel</a></p>";
} catch (PDOException $e) {
    echo "<p style='color:red'>Error: " . htmlentities($e->getMessage()) . "</p>";
}

?>
