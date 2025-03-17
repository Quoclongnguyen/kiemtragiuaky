<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Kiểm tra nếu sinh viên đã đăng nhập
if (isset($_SESSION['MaSV'])) {
    header("Location: ../../index.php");
    exit();
}

// Xử lý đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['MaSV'];

    $database = new Database();
    $conn = $database->getConnection();

    $sql = "SELECT * FROM SinhVien WHERE MaSV = :MaSV";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaSV', $MaSV);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION['MaSV'] = $MaSV;
        header("Location: ../../index.php");
        exit();
    } else {
        $error = "Mã sinh viên không hợp lệ!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        form { width: 300px; margin: auto; padding: 20px; border: 1px solid #ccc; background: #f9f9f9; }
        input { width: 100%; padding: 10px; margin: 10px 0; }
        button { background: #28a745; color: white; padding: 10px; border: none; cursor: pointer; }
        button:hover { background: #218838; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>ĐĂNG NHẬP</h2>
    <form action="" method="POST">
        <label>Mã SV:</label>
        <input type="text" name="MaSV" required>
        <button type="submit">Đăng Nhập</button>
    </form>
    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
    <br>
    <a href="../../index.php">Quay lại</a>
</body>
</html>
