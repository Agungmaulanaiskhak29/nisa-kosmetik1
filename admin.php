<?php
session_start();
include ' db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT orders.id, users.username, products.name, orders.quantity, orders.order_date 
        FROM orders 
        JOIN users ON orders.user_id = users.id 
        JOIN products ON orders.product_id = products.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Lihat Pesanan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Pesanan</h2>
    <table>
        <tr>
            <th>ID Pesanan</th>
            <th>Username</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Tanggal Pesanan</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo $row['order_date']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="logout.php">Logout</a>
</body>
</html>