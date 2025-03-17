<?php
require_once __DIR__ . '/../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

if (isset($_GET['id'])) {
    $MaSV = $_GET['id'];
    $sql = "SELECT * FROM SinhVien WHERE MaSV = :MaSV";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaSV', $MaSV);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        echo "Không tìm thấy sinh viên!";
        exit();
    }
} else {
    echo "Mã sinh viên không hợp lệ!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi Tiết Sinh Viên</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { width: 50%; margin: auto; padding: 20px; border: 1px solid #ccc; background: #f9f9f9; }
        img { width: 150px; height: 150px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chi Tiết Sinh Viên</h2>
        <p><strong>Mã SV:</strong> <?= $student['MaSV'] ?></p>
        <p><strong>Họ Tên:</strong> <?= $student['HoTen'] ?></p>
        <p><strong>Giới Tính:</strong> <?= $student['GioiTinh'] ?></p>
        <p><strong>Ngày Sinh:</strong> <?= $student['NgaySinh'] ?></p>
        <p><strong>Ngành:</strong> <?= $student['MaNganh'] ?></p>
        <p><strong>Ảnh:</strong></p>
        <img src="../../../<?= $student['Hinh'] ?>" alt="Ảnh sinh viên">
        <br><br>
        <a href="../../../index.php">Quay lại</a>
    </div>
</body>
</html>
