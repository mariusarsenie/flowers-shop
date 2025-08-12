<?php
$dir = __DIR__ . '/updatecore';

if (!is_dir($dir)) {
    echo "Folderul 'updatecore' nu există.";
    exit;
}

$files = array_diff(scandir($dir), ['.', '..']);
if (empty($files)) {
    echo "Nu există comenzi.";
    exit;
}

echo "<h1>Comenzi primite</h1>";
echo "<table border='1' cellpadding='10' cellspacing='0'>";
echo "<tr><th>Data / Ora</th><th>Nume client</th><th>Telefon</th><th>Adresă</th><th>Produse</th></tr>";

foreach ($files as $file) {
    $path = $dir . '/' . $file;
    $content = file_get_contents($path);
    $order = json_decode($content, true);

    if (!$order) continue;

    echo "<tr>";
    echo "<td>" . htmlspecialchars($order['timestamp']) . "</td>";
    echo "<td>" . htmlspecialchars($order['customerName']) . "</td>";
    echo "<td>" . htmlspecialchars($order['phone']) . "</td>";
    echo "<td>" . nl2br(htmlspecialchars($order['address'])) . "</td>";

    echo "<td>";
    foreach ($order['orderItems'] as $item) {
        echo htmlspecialchars($item['name']) . " x " . intval($item['qty']) . "<br>";
    }
    echo "</td>";

    echo "</tr>";
}

echo "</table>";
?>
