<?php
session_start();
include 'db.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data produk
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nisa Kosmetik</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h2 {
            color: #555;
            margin-top: 20px;
        }

        a {
            display: block;
            text-align: center;
            margin: 10px 0;
            text-decoration: none;
            color: #007BFF;
        }

        a:hover {
            text-decoration: underline;
        }

        .product-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .product {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            width: 200px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .product img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .product h3 {
            font-size: 1.2em;
            color: #333;
            margin: 10px 0;
        }

        .product p {
            font-size: 1em;
            color: #555;
        }

        .product form {
            margin-top: 10px;
        }

        .product input[type="number"] {
            width: 60px;
            padding: 5px;
            margin-right: 5px;
        }

        .product button {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            cursor: pointer;
        }

        .product button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Selamat Datang di Toko Nisa Kosmetik</h1>
    <a href="logout.php">Logout</a>
    <h2>Daftar Produk</h2>
    <div class="product-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product">
                <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" />
                <h3><?php echo $row['name']; ?></h3>
                <p>Harga: Rp <?php echo number_format($row['price'], 2, ',', '.'); ?></p>
                <form method="POST" action="order.php">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <input type="number" name="quantity" min="1" max="<?php echo $row['quantity']; ?>" value="1" required>
                    <button type="submit">Pesan</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>