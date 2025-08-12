<?php
// saveOrder.php

header('Content-Type: text/plain; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo "Date comanda invalide.";
    exit;
}

$name = trim($data['name'] ?? '');
$phone = trim($data['phone'] ?? '');
$address = trim($data['address'] ?? '');
$orderItems = $data['items'] ?? [];

if (!$name || !$phone || !$address || empty($orderItems)) {
    http_response_code(400);
    echo "Date comanda incomplete.";
    exit;
}

$order = [
    'timestamp' => date('Y-m-d H:i:s'),
    'customerName' => $name,
    'phone' => $phone,
    'address' => $address,
    'orderItems' => []
];

foreach ($orderItems as $id => $item) {
    $order['orderItems'][] = [
        'id' => $id,
        'name' => $item['name'],
        'qty' => intval($item['qty']),
        'price' => floatval($item['price'])
    ];
}

$folder = __DIR__ . '/updatecore';
if (!is_dir($folder)) {
    mkdir($folder, 0755, true);
}

$filename = $folder . '/order_' . time() . '_' . bin2hex(random_bytes(4)) . '.json';

file_put_contents($filename, json_encode($order, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "Comanda a fost primită cu succes! Mulțumim, $name.";
?>
