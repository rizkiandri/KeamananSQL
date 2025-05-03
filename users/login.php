<?php
// Koneksi ke database melalui PHPMyAdmin (localhost)
$host = "localhost";
$user = "root"; // User default di PHPMyAdmin lokal
$pass = "";     // Biasanya kosong di PHPMyAdmin lokal (kecuali kamu set password)
$dbname = "sql_injection_demo";

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Cek jika form disubmit
if (isset($_POST['submit'])) {
    // Mengambil data dari form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Gunakan prepared statement untuk keamanan
    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        // Bind parameter
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);

        // Eksekusi query
        mysqli_stmt_execute($stmt);

        // Ambil hasilnya
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            echo "<h2>Login Berhasil!</h2>";
        } else {
            echo "<h2>Login Gagal!</h2>";
        }

        // Tutup statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal menyiapkan statement: " . mysqli_error($conn);
    }
}

// Tutup koneksi
mysqli_close($conn);
?>

<!-- Form Login -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Aman</title>
</head>
<body>
    <h2>Form Login Aman</h2>
    <form method="post" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>