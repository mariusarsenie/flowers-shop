<?php
session_start();

$products = [
    1 => ['name' => 'Buchet Trandafiri', 'price' => 80],
    2 => ['name' => 'Lalele Colorate', 'price' => 60],
    3 => ['name' => 'Orhidee Elegantă', 'price' => 100],
];

if (empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit;
}

// Salvăm comanda într-un fișier JSON în folderul updatecore
if (!is_dir('updatecore')) {
    mkdir('updatecore', 0755, true);
}

$order = [
    'timestamp' => date('Y-m-d H:i:s'),
    'customerName' => 'Client anonim',  // aici poți adăuga formular de completat
    'phone' => '',
    'address' => '',
    'orderItems' => [],
    'total' => 0
];

foreach ($_SESSION['cart'] as $pid => $qty) {
    if (!isset($products[$pid])) continue;
    $product = $products[$pid];
    $order['orderItems'][] = [
        'id' => $pid,
        'name' => $product['name'],
        'price' => $product['price'],
        'qty' => $qty
    ];
    $order['total'] += $product['price'] * $qty;
}

// creăm un nume unic pentru fișier
$filename = 'updatecore/order_'.time().'_'.rand(1000,9999).'.json';
file_put_contents($filename, json_encode($order, JSON_PRETTY_PRINT));

unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
<meta charset="UTF-8" />
<title>Comandă finalizată</title>
<style>
body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 40px; text-align: center; }
.container { max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 12px rgba(0,0,0,0.1);}
h1 { color: #27ae60; }
a {
  text-decoration: none;
  color: #2980b9;
  font-weight: bold;
}
a:hover {
  text-decoration: underline;
}
</style>
</head>
<body>

<div class="container">
<h1>Mulțumim pentru comandă!</h1>
<p>Comanda ta a fost înregistrată cu succes.</p>
<a href="index.php">Înapoi la catalog</a>
</div>

</body>
</html>
