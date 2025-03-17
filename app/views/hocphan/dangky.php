<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// Kiểm tra xem sinh viên đã đăng nhập chưa
if (!isset($_SESSION['MaSV'])) {
    header("Location: ../../views/login.php");
    exit();
}

$MaSV = $_SESSION['MaSV'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaHP = $_POST['MaHP'];

    $database = new Database();
    $conn = $database->getConnection();

    // Kiểm tra xem sinh viên đã đăng ký học phần này chưa
    $sql = "SELECT * FROM ChiTietDangKy WHERE MaSV = :MaSV AND MaHP = :MaHP";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaSV', $MaSV);
    $stmt->bindParam(':MaHP', $MaHP);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Bạn đã đăng ký học phần này trước đó!";
        exit();
    }

    // Đăng ký học phần
    $sql = "INSERT INTO ChiTietDangKy (MaSV, MaHP) VALUES (:MaSV, :MaHP)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaSV', $MaSV);
    $stmt->bindParam(':MaHP', $MaHP);

    if ($stmt->execute()) {
        echo "Đăng ký thành công!";
        header("Location: hocphan.php");
    } else {
        echo "Lỗi khi đăng ký!";
    }
}
?>
