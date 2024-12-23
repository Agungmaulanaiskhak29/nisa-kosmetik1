<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit();
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Pengguna tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-bottom: 20px; /* Menambahkan jarak di bawah form */
        }

        input[type="text"],
        input[type="password"] {
            width: 93%;
            padding: 10px;
            margin: 10px 0;
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

        .message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Login Pengguna</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && $result->num_rows == 0): ?>
        <div class="message">Pengguna tidak ditemukan!</div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && !password_verify($password, $user['password'])): ?>
        <div class="message">Password salah!</div>
    <?php endif; ?>
    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
</body>
</html>