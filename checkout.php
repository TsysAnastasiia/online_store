<?php
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Ваш кошик порожній.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Збір даних з форми
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $total = 0;

    // Обчислення загальної суми
    foreach ($_SESSION['cart'] as $id => $quantity) {
        $products = json_decode(file_get_contents('product.json'), true);
        $product = array_filter($products, fn($p) => $p['id'] == $id);
        $product = reset($product);
        $total += $product['price'] * $quantity;
    }

    // Збереження замовлення в файл
    $orderData = [
        'name' => $name,
        'address' => $address,
        'phone' => $phone,
        'total' => $total,
        'products' => $_SESSION['cart'],
        'timestamp' => date('Y-m-d H:i:s')
    ];

    file_put_contents('orders.txt', json_encode($orderData) . PHP_EOL, FILE_APPEND);
    
    $_SESSION['cart'] = []; // Очищення кошика після замовлення
    echo "Дякуємо за ваше замовлення!";
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Оформлення замовлення</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Оформлення замовлення</h1>
        <form method="POST">
            <input type="text" name="name" placeholder="Ваше ім'я" required>
            <input type="text" name="address" placeholder="Адреса доставки" required>
            <input type="text" name="phone" placeholder="Телефон" required>

            <button type="submit">Підтвердити замовлення</button>
        </form>
    </div>
</body>
</html>