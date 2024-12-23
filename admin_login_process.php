<?php
session_start();
include 'db.php'; // Pastikan Anda menghubungkan ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek username dan password (ini hanya contoh, pastikan untuk menggunakan hashing untuk password)
    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        // Verifikasi password
        if (password_verify($password, $admin['password'])) {
            // Set session
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: admin_dashboard.php"); // Arahkan ke dashboard admin
            exit();
        } else {
            $_SESSION['login_error'] = "Password salah!";
            header("Location: admin_login.php"); // Kembali ke halaman login
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Username tidak ditemukan!";
        header("Location: admin_login.php"); // Kembali ke halaman login
        exit();
    }
}
?>