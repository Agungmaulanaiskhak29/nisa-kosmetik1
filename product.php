<?php
include 'db.php'; // Menghubungkan ke database

// Mengambil data produk dari database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Kosmetik</title>
    <link rel="stylesheet" href="styles.css"> <!-- Tambahkan CSS jika perlu -->
</head>
<body>
    <h1>Daftar Produk Kosmetik</h1>
    <div class="product-list">
        <?php
        if ($result->num_rows > 0) {
            // Menampilkan data produk
            while($row = $result->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<h2>" . $row['name'] . "</h2>";
                echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "'>";
                echo "<p>Harga: Rp " . number_format($row['price'], 2, ',', '.') . "</p>";
                echo "<p>Stok: " . $row['quantity'] . "</p>";
                echo "<a href='edit_product.php?id=" . $row['id'] . "'>Edit</a>"; // Tautan untuk edit
                echo "</div>";
            }
        } else {
            echo "Tidak ada produk yang tersedia.";
        }
        ?>
    </div>
</body>
</html>

<?php
$conn->close(); // Menutup koneksi
?>