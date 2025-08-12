<?php
$folder = __DIR__ . '/updatecore';
$files = glob($folder . '/*.json');
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <title>Admin - Comenzi Florărie</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #fafafa; }
    .order { background: white; padding: 15px; margin-bottom: 15px; border-radius: 8px; box-shadow: 0 0 5px #ccc; }
  </style>
</head>
<body>
  <h1>Comenzi primite</h1>
  <?php
  if (empty($files)) {
    echo "<p>Nu există comenzi.</p>";
  } else {
    foreach ($files as $file) {
      $content = file_get_contents($file);
      $order = json_decode($content, true);
      echo "<div class='order'>";
      echo "<strong>Nume:</strong> " . htmlspecialchars($order['name']) . "<br>";
      echo "<strong>Email:</strong> " . htmlspecialchars($order['email']) . "<br>";
      echo "<strong>Telefon:</strong> " . htmlspecialchars($order['phone']) . "<br>";
      echo "<strong>Floare:</strong> " . htmlspecialchars($order['flowerType']) . "<br>";
      echo "<strong>Mesaj:</strong> " . nl2br(htmlspecialchars($order['message'])) . "<br>";
      echo "<small><em>Data comenzii: " . htmlspecialchars($order['timestamp']) . "</em></small>";
      echo "</div>";
    }
  }
  ?>
</body>
</html>
