<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "ujian5";

// Membuat koneksi
$conn = new mysqli($server, $user, $pass, $db);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['full_name']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $product = htmlspecialchars($_POST['product']);
    $payment = htmlspecialchars($_POST['payment_method']);

    if (empty($name) || empty($email) || empty($address) || empty($product) || empty($payment)) {
        echo "Semua kolom wajib diisi!";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email tidak valid!";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO orders (name, email, address, product, payment) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $address, $product, $payment);

    if ($stmt->execute()) {
        echo "Pesanan berhasil diterima!";
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
