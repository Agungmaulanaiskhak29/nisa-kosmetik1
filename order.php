<?php
session_start();
include 'db.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$product_id = null; // Inisialisasi variabel $product_id
$product = null; // Inisialisasi variabel $product
$total_price = 0; // Inisialisasi total harga
$quantity = 1; // Inisialisasi kuantitas default

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity']; // Ambil kuantitas dari input

    // Cek ketersediaan produk
    $sql = "SELECT quantity, image_url, name, price FROM products WHERE id='$product_id'";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();

    if ($product && $product['quantity'] >= $quantity) {
        // Hitung total harga
        $total_price = $product['price'] * $quantity;

        // Memastikan address, payment_method, dan shipping_method ada
        if (isset($_POST['address']) && isset($_POST['payment_method']) && isset($_POST['shipping_method'])) {
            $address = $_POST['address'];
            $payment_method = $_POST['payment_method'];
            $shipping_method = $_POST['shipping_method']; // Ambil metode pengiriman

            // Simpan pesanan ke database
            $sql = "INSERT INTO orders (user_id, product_id, quantity, address, payment_method, shipping_method) VALUES ('$user_id', '$product_id', '$quantity', '$address', '$payment_method', '$shipping_method')";
            if ($conn->query($sql) === TRUE) {
                // Kurangi jumlah produk yang dipesan dari stok
                $new_quantity = $product['quantity'] - $quantity;
                $sql_update = "UPDATE products SET quantity='$new_quantity' WHERE id='$product_id'";
                $conn->query($sql_update);

                echo "Pesanan berhasil! Terima kasih telah berbelanja.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Alamat, metode pembayaran, dan metode pengiriman harus diisi.";
        }
    } else {
        echo "Stok tidak cukup untuk produk ini.";
    }
} else {
    echo "Metode permintaan tidak valid.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Anda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 20px;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px; /* Atur lebar maksimum form */
            margin: 0 auto; /* Pusatkan form */
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center; /* Pusatkan judul */
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%; /* Lebar penuh */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            width: 100%; /* Lebar penuh */
        }

        input[type="submit"]:hover {
            background-color: #218838; /* Warna saat hover */
        }

        h3 {
            margin-top: 20px;
            color: #555;
            text-align: center; /* Pusatkan judul detail produk */
        }

        img {
            max-width: 200px; /* Atur lebar maksimum gambar */
            max-height: 200px; /* Atur tinggi maksimum gambar */
            display: block;
            margin: 10px auto; /* Pusatkan gambar */
        }

        a {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            text-align: center; /* Pusatkan link */
        }

        a:hover {
            text-decoration: underline;
        }

        .total-price {
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<form method="POST" action="">
    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">

    <label for="address">Alamat Pengiriman:</label>
    <input type="text" name="address" required><br><br>

    <label for="shipping_method">Metode Pengiriman:</label>
    <select name="shipping_method" required>
        <option value="Jnt_Express">Jnt Express</option>
        <option value="Jne_express">Jne Ekspres</option>
    </select><br><br>

    <label for="payment_method">Metode Pembayaran:</label>
    <select name="payment_method" required>
        <option value="transfer">Transfer Rekening Bank</option>
        <option value="e-wallet">E-Wallet</option>
    </select><br><br>

    <label for="quantity">Jumlah:</label>
    <input type="text" name="quantity" required><br><br>

    <input type="submit" value="Pesan">
</form>

<?php if ($product): ?>
    <h3>Detail Produk yang Dipesan</h3>
    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Gambar Produk">
    <p>Nama Produk: <?php echo htmlspecialchars($product['name']); ?></p>
    <p>Jumlah: <?php echo htmlspecialchars($quantity); ?></p>
    <div class="total-price">Total Harga: Rp <?php echo number_format($total_price, 0, ',', '.'); ?></div>
<?php endif; ?>
<a href="https://wa.me/085725875104" target="_blank">Hubungi Kami di WhatsApp</a><br>
<a href="index.php">Kembali ke Daftar Produk</a>
</body>
</html>