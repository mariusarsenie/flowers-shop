<?php
session_start();

$products = [
    1 => ['name' => 'Buchet Trandafiri', 'price' => 80, 'img' => 'trandafiri.jpg', 'desc' => 'Buchet de trandafiri roșii, 12 fire.'],
    2 => ['name' => 'Lalele Colorate', 'price' => 60, 'img' => 'lalele.jpg', 'desc' => 'Lalele colorate pentru orice ocazie.'],
    3 => ['name' => 'Orhidee Elegantă', 'price' => 100, 'img' => 'orhidee.jpg', 'desc' => 'Orhidee albă în ghiveci decorativ.'],
];

$id = (int)($_GET['id'] ?? 0);
if (!isset($products[$id])) {
    header("Location: index.php");
    exit;
}

$product = $products[$id];

// adăugare în coș
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 0;
    }
    $_SESSION['cart'][$id]++;
    header("Location: product.php?id=$id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
<meta charset="UTF-8" />
<title><?php echo htmlspecialchars($product['name']); ?></title>
<style>
body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 30px; }
.container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
h1 { text-align: center; }
img { max-width: 100%; border-radius: 10px; }
.btn {
  background-color: #27ae60;
  color: white;
  padding: 10px 18px;
  border-radius: 8px;
  border: none;
  cursor: pointer;
  font-weight: bold;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  transition: background-color 0.3s ease;
  margin-top: 15px;
  display: block;
  width: 100%;
}
.btn:hover {
  background-color: #1e8449;
}
.back-link {
  display: inline-block;
  margin-bottom: 15px;
  color: #2980b9;
  text-decoration: none;
  font-weight: bold;
}
.back-link:hover {
  text-decoration: underline;
}
.cart-link {
  position: fixed;
  top: 20px; right: 20px;
  background: #2980b9;
  color: white;
  padding: 12px 20px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: bold;
  box-shadow: 0 4px 6px rgba(0,0,0,0.15);
}
</style>
</head>
<body>

<a href="cart.php" class="cart-link">Coș (<?php echo array_sum($_SESSION['cart'] ?? []); ?>)</a>

<div class="container">
<a href="index.php" class="back-link">&larr; Înapoi la catalog</a>
<h1><?php echo htmlspecialchars($product['name']); ?></h1>
<img src="<?php echo $product['img']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
<p><?php echo htmlspecialchars($product['desc']); ?></p>
<p><b>Preț: <?php echo $product['price']; ?> RON</b></p>

<form method="post" action="">
    <button type="submit" class="btn">Adaugă în coș</button>
</form>
</div>

</body>
</html>
