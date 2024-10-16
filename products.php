<?php
session_start();
$products = json_decode(file_get_contents('product.json'), true);

if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $_SESSION['cart'][$productId] = (isset($_SESSION['cart'][$productId]) ? $_SESSION['cart'][$productId] : 0) + $quantity;
    header('Location: products.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Каталог товарів</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Каталог товарів</h1>
        <?php foreach ($products as $product): ?>
            <div class="product">
                <h2><?php echo $product['name']; ?></h2>
                <p><?php echo $product['description']; ?></p>
                <p>Ціна: <?php echo $product['price']; ?> грн</p>
                <form method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="number" name="quantity" value="1" min="1" style="width: 50px;">
                    <button type="submit" name="add_to_cart">Додати до кошика</button>
                </form>
            </div>
        <?php endforeach; ?>
        <a href="cart.php">Переглянути кошик</a>
    </div>
</body>
</html>