<?php
// viewOrders.php

$folder = __DIR__ . '/updatecore';

if (!is_dir($folder)) {
    echo "<p>Nu există comenzi.</p>";
    exit;
}

$files = glob($folder . '/order_*.json');
if (!$files) {
    echo "<p>Nu există comenzi.</p>";
    exit;
}

echo "<h1>Comenzi primite</h1>";
echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse:collapse; width: 100%;'>";
echo "<tr><th>Data</th><th>Nume</th><th>Telefon</th><th>Adresă</th><th>Produse</th></tr>";

foreach ($files as $file) {
    $json = file_get_contents($file);
    $order = json_decode($json, true);
    if (!$order) continue;

    echo "<tr>";
    echo "<td>" . htmlspecialchars($order['timestamp']) . "</td>";
    echo "<td>" . htmlspecialchars($order['customerName']) . "</td>";
    echo "<td>" . htmlspecialchars($order['phone']) . "</td>";
    echo "<td>" . nl2br(htmlspecialchars($order['address'])) . "</td>";

    echo "<td><ul>";
    foreach ($order['orderItems'] as $item) {
        echo "<li>" . htmlspecialchars($item['qty']) . " x " . htmlspecialchars($item['name']) . " @ " . htmlspecialchars($item['price']) . " RON</li>";
    }
    echo "</ul></td>";

    echo "</tr>";
}

echo "</table>";
?>
