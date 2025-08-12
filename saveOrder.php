<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['customerName'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $orderData = $_POST['orderData'] ?? '';

    if (!$name || !$phone || !$address || !$orderData) {
        http_response_code(400);
        echo "Date incomplete.";
        exit;
    }

    $orderItems = json_decode($orderData, true);
    if (!$orderItems) {
        http_response_code(400);
        echo "Date comanda invalide.";
        exit;
    }

    $order = [
        'timestamp' => date('Y-m-d H:i:s'),
        'customerName' => $name,
        'phone' => $phone,
        'address' => $address,
        'orderItems' => $orderItems
    ];

    $folder = __DIR__ . '/updatecore';
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }

    $filename = $folder . '/order_' . time() . '_' . bin2hex(random_bytes(4)) . '.json';
    file_put_contents($filename, json_encode($order, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    // După salvare, poți redirecționa clientul sau afisa un mesaj:
    echo "<h2>Comanda a fost primită cu succes!</h2>";
    echo "<p>Mulțumim, $name! Vom lua legătura cu tine în curând.</p>";
    echo '<p><a href="index.html">Înapoi la catalog</a></p>';
} else {
    http_response_code(405);
    echo "Metodă nepermisă.";
}
?>
