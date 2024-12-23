<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php"); // Arahkan ke halaman login jika belum login
    exit();
}

include 'db.php'; // Pastikan Anda menghubungkan ke database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Nisa Kosmetik</title>
    <link rel="stylesheet" href="style.css"> <!-- Jika Anda ingin menggunakan file CSS terpisah -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 20px;
        }

        .dashboard-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        h2 {
            color: #555;
            margin-top: 20px;
        }

        p {
            margin: 10px 0;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"] {
            width: 18%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, <?php echo $_SESSION['admin_username']; ?>!</p>
        <a href="logout.php">Logout</a>

        <h2 id="users">Daftar Pengguna</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Ambil data pengguna dari database
                $sql = "SELECT * FROM users"; // Pastikan Anda memiliki tabel 'users'
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['email']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada pengguna ditemukan .</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h2 id="products">Daftar Produk</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Ambil data produk dari database
                $sql = "SELECT * FROM products"; // Pastikan Anda memiliki tabel 'products'
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>Rp " . number_format($row['price'], 2, ',', '.') . "</td>
                                <td>{$row['quantity']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada produk ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h2>Daftar Pesanan</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>ID Pengguna</th>
                    <th>ID Produk</th>
                    <th>Jumlah</th>
                    <th>Alamat</th>
                    <th>Metode Pembayaran</th>
                    <th>Metode Pengiriman</th>
                    <th>Tanggal Pesanan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Ambil data pesanan dari database
                $sql = "SELECT * FROM orders"; // Pastikan Anda memiliki tabel 'orders'
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['user_id']}</td>
                                <td>{$row['product_id']}</td>
                                <td>{$row['quantity']}</td>
                                <td>{$row['address']}</td>
                                <td>{$row['payment_method']}</td>
                                <td>{$row['shipping_method']}</td>
                                <td>{$row['order_date']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Tidak ada pesanan ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>