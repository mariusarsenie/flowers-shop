<?php
session_start();

$products = [
    1 => ['name' => 'Buchet Trandafiri', 'price' => 80, 'img' => 'trandafiri.jpg', 'desc' => 'Buchet de trandafiri roșii, 12 fire.'],
    2 => ['name' => 'Lalele Colorate', 'price' => 60, 'img' => 'lalele.jpg', 'desc' => 'Lalele colorate pentru orice ocazie.'],
    3 => ['name' => 'Orhidee Elegantă', 'price' => 100, 'img' => 'orhidee.jpg', 'desc' => 'Orhidee albă în ghiveci decorativ.'],
];

// elimină produs
if (isset($_GET['remove'])) {
    $rem = (int)$_GET['remove'];
    if (isset($_SESSION['cart'][$rem])) {
        unset($_SESSION['cart'][$rem]);
    }
    header("Location: cart.php");
    exit;
}

// actualizează cantități
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['qty'] as $pid => $qty) {
        $pid = (int)$pid;
        $qty = (int)$qty;
        if ($qty <= 0) {
            unset($_SESSION['cart'][$pid]);
        } else {
            $_SESSION['cart'][$pid] = $qty;
        }
    }
    header("Location: cart.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="ro">
<head>
<meta charset="UTF-8" />
<title>Coșul tău</title>
<style>
body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 30px; }
.container { max-width: 700px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
h1 { text-align: center; }
table { width: 100%; border-collapse: collapse; margin-bottom: 20px;}
th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: center; }
input.qty {
    width: 50px;
    text-align: center;
    border-radius: 6px;
    border: 1px solid #ccc;
    padding: 5px;
}
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
}
.btn:hover {
  background-color: #1e8449;
}
.remove-link {
  color: red;
  font-weight: bold;
  text-decoration: none;
  cursor: pointer;
}
.remove-link:hover {
  text-decoration: underline;
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
</style>
</head>
<body>

<div class="container">
<a href="index.php" class="back-link">&larr; Înapoi la catalog</a>
<h1>Coșul tău</h1>

<?php if(empty($_SESSION['cart'])): ?>
    <p>Coșul este gol.</p>
<?php else: ?>
<form method="post" action="">
<table>
    <thead>
        <tr>
            <th>Produs</th>
            <th>Preț</th>
            <th>Cantitate</th>
            <th>Subtotal</th>
            <th>Șterge</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $total = 0;
    foreach ($_SESSION['cart'] as $pid => $qty):
        if (!isset($products[$pid])) continue;
        $prod = $products[$pid];
        $subtotal = $prod['price'] * $qty;
        $total += $subtotal;
    ?>
        <tr>
            <td><?php echo htmlspecialchars($prod['name']); ?></td>
            <td><?php echo $prod['price']; ?> RON</td>
            <td><input type="number" min="0" name="qty[<?php echo $pid; ?>]" value="<?php echo $qty; ?>" class="qty"></td>
            <td><?php echo $subtotal; ?> RON</td>
            <td><a href="cart.php?remove=<?php echo $pid; ?>" class="remove-link">X</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<p><b>Total: <?php echo $total; ?> RON</b></p>

<button type="submit" class="btn">Actualizează coș</button>
</form>

<form method="post" action="checkout.php" style="margin-top:20px;">
    <button type="submit" class="btn">Finalizează comanda</button>
</form>

<?php endif; ?>
</div>

</body>
</html>
