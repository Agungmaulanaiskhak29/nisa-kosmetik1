<?php
include 'db.php'; // Menghubungkan ke database

// Memeriksa apakah ada ID produk yang diberikan
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mengambil data produk berdasarkan ID
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Produk tidak ditemukan.";
        exit;
    }
} else {
    echo "ID produk tidak diberikan.";
    exit;
}

// Memproses form jika ada data yang dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image = $_POST['image']; // Anda bisa menambahkan upload gambar di sini

    // Update data produk
    $sql = "UPDATE products SET name='$name', price='$price', quantity='$quantity', image='$image' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Produk berhasil diperbarui.";
        header("Location: products.php"); // Redirect ke halaman produk
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
</head>
<body>
    <h1>Edit Produk</h1>
    <form method="POST" action="">
        <label for="name">Nama Produk:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" required><br><br>

        <label for="price">Harga:</label><br>
        <input type="number" id="price" name="price" value="<?php echo $product['price']; ?>" required><br><br>

        <label for="quantity">Stok:</label><br>
        <input type="number" id="quantity" name="quantity" value="<?php echo $product['quantity']; ?>" required><br><br>

        <label for="image">Gambar URL:</label><br>
        <input type="text" id="image" name="image" value="<?php echo $product['image']; ?>"><br><br>

        <input type="submit" value="Perbarui Produk">
    </form>
</body>
</html>

<?php
$conn->close(); // Menutup koneksi
?>