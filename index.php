<?php
session_start();
require_once 'app/models/SinhVien.php';

// Kiểm tra nếu chưa đăng nhập, chuyển hướng về login.php
if (!isset($_SESSION['MaSV'])) {
    header("Location: app/views/login.php");
    exit();
}

$sinhVienModel = new SinhVien();
$students = $sinhVienModel->getAllStudents();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Sinh Viên</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { width: 80%; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f4f4f4; }
        img { width: 80px; height: 80px; border-radius: 5px; }
        .actions a { margin-right: 10px; text-decoration: none; color: blue; }
        .btn-add { background: #28a745; color: white; padding: 10px; text-decoration: none; display: inline-block; margin-bottom: 10px; }
        nav { margin-bottom: 20px; }
        nav a { margin: 0 15px; text-decoration: none; font-weight: bold; }
        .logout-btn { background: red; color: white; padding: 5px 10px; text-decoration: none; border: none; cursor: pointer; }
        .logout-btn:hover { background: darkred; }
    </style>
</head>
<body>
    <div class="container">
        <h2>TRANG QUẢN LÝ SINH VIÊN</h2>
        <nav>
            <a href="index.php">Trang chủ</a>
            <a href="app/views/hocphan/hocphan.php">Đăng Ký Học Phần</a>
            <a href="app/views/logout.php" class="logout-btn">Đăng Xuất</a>
        </nav>
        <p>Xin chào, <?= $_SESSION['MaSV'] ?>!</p>
        <a href="app/views/sinhvien/add.php" class="btn-add">Thêm Sinh Viên</a>
        <table>
            <tr>
                <th>Mã SV</th>
                <th>Họ Tên</th>
                <th>Giới Tính</th>
                <th>Ngày Sinh</th>
                <th>Hình</th>
                <th>Ngành</th>
                <th>Hành động</th>
            </tr>
            <?php foreach ($students as $student) { ?>
                <tr>
                    <td><?= $student['MaSV'] ?></td>
                    <td><?= $student['HoTen'] ?></td>
                    <td><?= $student['GioiTinh'] ?></td>
                    <td><?= $student['NgaySinh'] ?></td>
                    <td><img src="<?= $student['Hinh'] ?>" alt="Ảnh sinh viên"></td>
                    <td><?= $student['MaNganh'] ?></td>
                    <td class="actions">
                        <a href="app/views/sinhvien/edit.php?id=<?= $student['MaSV'] ?>">Edit</a>
                        <a href="app/views/sinhvien/details.php?id=<?= $student['MaSV'] ?>">Details</a>
                        <a href="app/views/sinhvien/delete.php?id=<?= $student['MaSV'] ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
