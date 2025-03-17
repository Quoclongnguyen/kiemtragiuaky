<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['MaSV'];
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    $database = new Database();
    $conn = $database->getConnection();

    // Lấy ảnh cũ nếu không chọn ảnh mới
    $sql = "SELECT Hinh FROM SinhVien WHERE MaSV = :MaSV";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaSV', $MaSV);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    $Hinh = $student['Hinh'];

    // Nếu có ảnh mới, tải lên
    if (isset($_FILES["Hinh"]) && $_FILES["Hinh"]["error"] == 0) {
        $uploadDir = "../../../uploads/";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES["Hinh"]["name"]);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES["Hinh"]["tmp_name"], $filePath)) {
            $Hinh = "uploads/" . $fileName;
        } else {
            echo "Lỗi khi tải ảnh!";
            exit();
        }
    }

    // Cập nhật thông tin sinh viên
    $sql = "UPDATE SinhVien SET HoTen=:HoTen, GioiTinh=:GioiTinh, NgaySinh=:NgaySinh, Hinh=:Hinh, MaNganh=:MaNganh WHERE MaSV=:MaSV";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':MaSV', $MaSV);
    $stmt->bindParam(':HoTen', $HoTen);
    $stmt->bindParam(':GioiTinh', $GioiTinh);
    $stmt->bindParam(':NgaySinh', $NgaySinh);
    $stmt->bindParam(':Hinh', $Hinh);
    $stmt->bindParam(':MaNganh', $MaNganh);

    if ($stmt->execute()) {
        echo "Cập nhật thành công!";
        header("Location: ../../../index.php");
    } else {
        echo "Lỗi khi cập nhật!";
        print_r($stmt->errorInfo()); // In lỗi SQL nếu có
    }
}
?>
