<?php
// Clear package images: deletes image files (except placeholder.svg) and clears DB entries
require_once __DIR__ . '/admin/includes/config.php';

$dir = __DIR__ . '/admin/packageimages/';
$keeps = ['placeholder.svg', '.gitkeep', '.htaccess'];
$deleted = 0;

if (is_dir($dir)) {
    $files = scandir($dir);
    foreach ($files as $f) {
        if ($f === '.' || $f === '..') continue;
        if (in_array($f, $keeps)) continue;
        $path = $dir . $f;
        if (is_file($path)) {
            @unlink($path);
            $deleted++;
        }
    }
}

try {
    $stmt = $dbh->prepare("UPDATE tbltourpackages SET PackageImage = ''");
    $stmt->execute();
    $rows = $stmt->rowCount();
    echo "<p>Cleared PackageImage field for $rows packages.</p>";
} catch (Exception $e) {
    echo "<p style=\"color:red\">DB error: " . htmlentities($e->getMessage()) . "</p>";
}

echo "<p>Deleted $deleted image files from admin/packageimages/ (placeholder.svg preserved).</p>";
echo "<p><a href='admin/'>Open Admin Panel</a> | <a href='user/'>Open User Portal</a></p>";

?>
