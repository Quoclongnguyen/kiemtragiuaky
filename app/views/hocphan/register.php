<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['MaSV'])) {
    header("Location: ../../views/login.php");
    exit();
}

$MaSV = $_SESSION['MaSV'];
$database = new Database();
$conn = $database->getConnection();

// Lấy danh sách học phần đã đăng ký
$sqlAll = "SELECT MaHP, TenHP, SoTinChi FROM HocPhan";
$stmtAll = $conn->prepare($sqlAll);
$stmtAll->execute();
$allHocPhans = $stmtAll->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký Học Phần</title>
</head>
<body>
    <h2>Danh Sách Học Phần Đã Đăng Ký</h2>
    <table>
        <tr>
            <th>Mã HP</th>
            <th>Tên Học Phần</th>
            <th>Số Tin Chỉ</th>
            <th>Hành Động</th>
        </tr>
        <?php foreach ($allHocPhans as $hocphan): ?>
            <tr>
                <td><?= $hocphan['MaHP'] ?></td>
                <td><?= $hocphan['TenHP'] ?></td>
                <td><?= $hocphan['SoTinChi'] ?></td>
                <td>
                    <form action="register.php" method="POST">
                        <input type="hidden" name="MaHP" value="<?= $hocphan['MaHP'] ?>">
                        <button type="submit" class="btn-register">Đăng Ký</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="../../index.php" class="btn-back">Quay lại</a>
</body>
</html>
