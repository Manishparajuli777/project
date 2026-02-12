<?php
// Map package names to new SVG images and update the DB.
require_once __DIR__ . '/admin/includes/config.php';

$map = [
    'Kathmandu Valley Tour' => 'kathmandu.svg',
    'Everest Base Camp Trek' => 'everest.svg',
    'Pokhara Adventure Package' => 'pokhara.svg',
    'Annapurna Circuit Trek' => 'annapurna.svg',
    'Chitwan Jungle Safari' => 'chitwan.svg',
    'Langtang Valley Trek' => 'langtang.svg',
    'Nagarkot Sunrise & Sunset' => 'nagarkot.svg',
    'Manali-Leh Highway Tour' => 'manali-leh.svg',
    'Rara Lake Trek' => 'rara.svg',
    'Ilam Tea Garden Tour' => 'ilam.svg'
];

$updated = 0;
foreach($map as $name => $file) {
    $sql = "UPDATE tbltourpackages SET PackageImage = :file WHERE PackageName = :name";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':file', $file, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    if($stmt->execute()) $updated += $stmt->rowCount();
}

echo "<p>Updated images for packages. Rows affected: " . intval($updated) . "</p>";
echo "<p>Verify images in admin/packageimages/ and open <a href='user/'>User portal</a>.</p>";
?>