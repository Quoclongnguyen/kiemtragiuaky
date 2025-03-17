<?php
require_once __DIR__ . '/../../config/database.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Sinh Viên</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        form { width: 50%; margin: auto; padding: 20px; border: 1px solid #ccc; background: #f9f9f9; }
        input, select { width: 100%; padding: 10px; margin: 5px 0; }
        button { background: #28a745; color: white; padding: 10px; border: none; cursor: pointer; }
        button:hover { background: #218838; }
    </style>
</head>
<body>
    <h2>Thêm Sinh Viên</h2>
    <form action="store.php" method="POST" enctype="multipart/form-data">
        <label>Mã Sinh Viên:</label>
        <input type="text" name="MaSV" required>

        <label>Họ Tên:</label>
        <input type="text" name="HoTen" required>

        <label>Giới Tính:</label>
        <select name="GioiTinh">
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
        </select>

        <label>Ngày Sinh:</label>
        <input type="date" name="NgaySinh" required>

        <label>Chọn Hình Ảnh:</label>
        <input type="file" name="Hinh" accept="image/*" required>

        <label>Ngành:</label>
        <select name="MaNganh">
            <option value="CNTT">Công nghệ thông tin</option>
            <option value="QTKD">Quản trị kinh doanh</option>
        </select>

        <button type="submit">Thêm Sinh Viên</button>
    </form>
</body>
</html>
