<?php
// Koneksi ke database menggunakan PDO
try {
    // Perhatikan password: jika di PHPMyAdmin tidak ada password, kosongkan ''.
    $pdo = new PDO('mysql:host=localhost;dbname=sql_injection_demo', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Cek apakah form sudah disubmit
if (isset($_POST['submit'])) {
    // Mengambil dan membersihkan inputan dari user
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Menggunakan prepared statement untuk menghindari SQL Injection
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username AND password = :password');

        // Bind parameter
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        // Eksekusi statement
        $stmt->execute();

        // Cek hasil login
        if ($stmt->rowCount() > 0) {
            echo "<h2>Login Berhasil!</h2>";
        } else {
            echo "<h2>Login Gagal! Username atau Password salah.</h2>";
        }
    } else {
        echo "<h2>Harap isi Username dan Password!</h2>";
    }
}
?>

<!-- Form Login Aman -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Aman</title>
</head>
<body>
    <h2>Form Login Aman</h2>
    <form method="post" action="">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>
