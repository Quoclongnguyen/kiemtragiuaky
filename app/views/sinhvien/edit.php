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
    <title>Sửa Thông Tin Sinh Viên</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        form { width: 50%; margin: auto; padding: 20px; border: 1px solid #ccc; background: #f9f9f9; }
        input, select { width: 100%; padding: 10px; margin: 5px 0; }
        button { background: #007bff; color: white; padding: 10px; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h2>Sửa Thông Tin Sinh Viên</h2>
    <form action="update.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="MaSV" value="<?= $student['MaSV'] ?>">

        <label>Họ Tên:</label>
        <input type="text" name="HoTen" value="<?= $student['HoTen'] ?>" required>

        <label>Giới Tính:</label>
        <select name="GioiTinh">
            <option value="Nam" <?= ($student['GioiTinh'] == "Nam") ? "selected" : "" ?>>Nam</option>
            <option value="Nữ" <?= ($student['GioiTinh'] == "Nữ") ? "selected" : "" ?>>Nữ</option>
        </select>

        <label>Ngày Sinh:</label>
        <input type="date" name="NgaySinh" value="<?= $student['NgaySinh'] ?>" required>

        <label>Ảnh Hiện Tại:</label><br>
        <img src="../../../<?= $student['Hinh'] ?>" width="100"><br><br>

        <label>Chọn Ảnh Mới (nếu muốn thay đổi):</label>
        <input type="file" name="Hinh" accept="image/*">

        <label>Ngành:</label>
        <select name="MaNganh">
            <option value="CNTT" <?= ($student['MaNganh'] == "CNTT") ? "selected" : "" ?>>Công nghệ thông tin</option>
            <option value="QTKD" <?= ($student['MaNganh'] == "QTKD") ? "selected" : "" ?>>Quản trị kinh doanh</option>
        </select>

        <button type="submit">Cập Nhật</button>
    </form>
</body>
</html>
