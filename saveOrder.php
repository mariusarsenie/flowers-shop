<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order = [
        'name' => trim($_POST['name']),
        'email' => trim($_POST['email']),
        'phone' => trim($_POST['phone']),
        'flowerType' => trim($_POST['flowerType']),
        'message' => trim($_POST['message']),
        'timestamp' => date('Y-m-d H:i:s')
    ];

    $json = json_encode($order, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    $folder = __DIR__ . '/updatecore';

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $filename = $folder . '/order_' . time() . '.json';

    file_put_contents($filename, $json);

    header('Location: thankyou.html');
    exit();
}
?>
