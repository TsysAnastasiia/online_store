<?php
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Ваш кошик порожній.";
    exit;
}

$products = json_decode(file_get_contents('product.json'), true);
$cart = $_SESSION['cart'];
$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Кошик покупок</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Кошик покупок</h1>
        <ul>
            <?php foreach ($cart as $id => $quantity): ?>
                <?php
                $product = array_filter($products, fn($p) => $p['id'] == $id);
                $product = reset($product);
                $total += $product['price'] * $quantity;
                ?>
                <li><?php echo $product['name']; ?> - <?php echo $quantity; ?> шт - <?php echo $product['price'] * $quantity; ?> грн</li>
            <?php endforeach; ?>
        </ul>
        <h2>Всього: <?php echo $total; ?> грн</h2>
        <form action="checkout.php" method="POST">
            <button type="submit">Оформити замовлення</button>
        </form>
        <a href="products.php">Продовжити покупки</a>
    </div>
</body>
</html>