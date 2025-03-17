<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// Kiểm tra xem sinh viên đã đăng nhập chưa
if (!isset($_SESSION['MaSV'])) {
    header("Location: ../../views/login.php");
    exit();
}

$MaSV = $_SESSION['MaSV'];
$database = new Database();
$conn = $database->getConnection();

// Lấy danh sách học phần đã đăng ký
$sqlRegistered = "SELECT hocphan.MaHP, hocphan.TenHP, hocphan.SoTinChi
                  FROM HocPhan hocphan
                  JOIN ChiTietDangKy chiTiet ON hocphan.MaHP = chiTiet.MaHP
                  WHERE chiTiet.MaSV = :MaSV";
$stmtRegistered = $conn->prepare($sqlRegistered);
$stmtRegistered->bindParam(':MaSV', $MaSV);
$stmtRegistered->execute();
$registeredHocPhans = $stmtRegistered->fetchAll(PDO::FETCH_ASSOC);

// Lấy tất cả các học phần
$sqlAll = "SELECT MaHP, TenHP, SoTinChi FROM HocPhan";
$stmtAll = $conn->prepare($sqlAll);
$stmtAll->execute();
$allHocPhans = $stmtAll->fetchAll(PDO::FETCH_ASSOC);

// Đăng ký học phần
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['MaHP'])) {
    $MaHP = $_POST['MaHP'];

    // Kiểm tra nếu sinh viên đã đăng ký học phần này
    $sqlCheck = "SELECT * FROM ChiTietDangKy WHERE MaSV = :MaSV AND MaHP = :MaHP";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bindParam(':MaSV', $MaSV);
    $stmtCheck->bindParam(':MaHP', $MaHP);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() > 0) {
        echo "Bạn đã đăng ký học phần này rồi!";
        exit();
    }

    // Thêm học phần vào ChiTietDangKy
    $sqlInsert = "INSERT INTO ChiTietDangKy (MaSV, MaHP) VALUES (:MaSV, :MaHP)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bindParam(':MaSV', $MaSV);
    $stmtInsert->bindParam(':MaHP', $MaHP);

    if ($stmtInsert->execute()) {
        echo "Đăng ký học phần thành công!";
        header("Location: hocphan.php");
        exit();
    } else {
        echo "Lỗi khi đăng ký học phần!";
    }
}

// Hủy đăng ký học phần
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['MaHPDelete'])) {
    $MaHP = $_POST['MaHPDelete'];

    $sqlDelete = "DELETE FROM ChiTietDangKy WHERE MaSV = :MaSV AND MaHP = :MaHP";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bindParam(':MaSV', $MaSV);
    $stmtDelete->bindParam(':MaHP', $MaHP);

    if ($stmtDelete->execute()) {
        echo "Hủy đăng ký học phần thành công!";
        header("Location: hocphan.php");
        exit();
    } else {
        echo "Lỗi khi hủy đăng ký học phần!";
    }
}

// Xóa tất cả học phần đã đăng ký
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteAll'])) {
    $sqlDeleteAll = "DELETE FROM ChiTietDangKy WHERE MaSV = :MaSV";
    $stmtDeleteAll = $conn->prepare($sqlDeleteAll);
    $stmtDeleteAll->bindParam(':MaSV', $MaSV);

    if ($stmtDeleteAll->execute()) {
        echo "Đã xóa tất cả học phần đã đăng ký!";
        header("Location: hocphan.php");
        exit();
    } else {
        echo "Lỗi khi xóa tất cả học phần!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký Học Phần</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { width: 80%; margin: auto; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f4f4f4; }
        .btn-register { background: #28a745; color: white; padding: 5px 10px; text-decoration: none; border: none; cursor: pointer; }
        .btn-register:hover { background: #218838; }
        .btn-back { background: #007bff; color: white; padding: 5px 10px; text-decoration: none; border: none; cursor: pointer; }
        .btn-back:hover { background: #0056b3; }
        .btn-delete-all { background: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border: none; cursor: pointer; }
        .btn-delete-all:hover { background: #c82333; }
    </style>
</head>
<body>
    <h2>Danh Sách Học Phần Đã Đăng Ký</h2>
    <table>
        <tr>
            <th>Mã HP</th>
            <th>Tên Học Phần</th>
            <th>Số Tín Chỉ</th>
            <th>Hành Động</th>
        </tr>
        <?php foreach ($registeredHocPhans as $hocphan) { ?>
            <tr>
                <td><?= $hocphan['MaHP'] ?></td>
                <td><?= $hocphan['TenHP'] ?></td>
                <td><?= $hocphan['SoTinChi'] ?></td>
                <td>
                    <form action="hocphan.php" method="POST">
                        <input type="hidden" name="MaHPDelete" value="<?= $hocphan['MaHP'] ?>">
                        <button type="submit" class="btn-register">Hủy Đăng Ký</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <h2>Danh Sách Tất Cả Học Phần</h2>
    <table>
        <tr>
            <th>Mã HP</th>
            <th>Tên Học Phần</th>
            <th>Số Tín Chỉ</th>
            <th>Hành Động</th>
        </tr>
        <?php foreach ($allHocPhans as $hocphan) { ?>
            <tr>
                <td><?= $hocphan['MaHP'] ?></td>
                <td><?= $hocphan['TenHP'] ?></td>
                <td><?= $hocphan['SoTinChi'] ?></td>
                <td>
                    <form action="hocphan.php" method="POST">
                        <input type="hidden" name="MaHP" value="<?= $hocphan['MaHP'] ?>">
                        <button type="submit" class="btn-register">Đăng Ký</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <form action="hocphan.php" method="POST">
        <button type="submit" name="deleteAll" class="btn-delete-all">Xóa Tất Cả Học Phần</button>
    </form>

    <br>
    <a href="../../index.php" class="btn-back">Quay lại</a>
</body>
</html>
