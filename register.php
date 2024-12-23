<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email']; // Ambil email dari form
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Gunakan prepared statement untuk mencegah SQL injection
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        // Register berhasil, langsung ke login
        $_SESSION['username'] = $username;
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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

        h1 {
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
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 93%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Register</h1>
    <!-- Form register -->
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required> <!-- Tambahkan input email -->
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Daftar</button>
    </form>
</body>
</html