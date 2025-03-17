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

    // Kiểm tra xem có file ảnh không
    if (isset($_FILES["Hinh"]) && $_FILES["Hinh"]["error"] == 0) {
        // Thư mục lưu ảnh
        $uploadDir = "../../../uploads/";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Xử lý upload ảnh
        $fileName = basename($_FILES["Hinh"]["name"]);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES["Hinh"]["tmp_name"], $filePath)) {
            echo "Ảnh đã tải lên thành công!<br>";
            $Hinh = "uploads/" . $fileName;
        } else {
            echo "Lỗi khi tải ảnh!<br>";
            exit();
        }
    } else {
        echo "Không có ảnh hoặc lỗi tải ảnh!<br>";
        exit();
    }

    // Kết nối database
    $database = new Database();
    $conn = $database->getConnection();

    $sql = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
            VALUES (:MaSV, :HoTen, :GioiTinh, :NgaySinh, :Hinh, :MaNganh)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':MaSV', $MaSV);
    $stmt->bindParam(':HoTen', $HoTen);
    $stmt->bindParam(':GioiTinh', $GioiTinh);
    $stmt->bindParam(':NgaySinh', $NgaySinh);
    $stmt->bindParam(':Hinh', $Hinh);
    $stmt->bindParam(':MaNganh', $MaNganh);

    if ($stmt->execute()) {
        echo "Thêm sinh viên thành công!";
        header("Location: ../../../index.php");
    } else {
        echo "Lỗi khi thêm sinh viên!";
        print_r($stmt->errorInfo()); // In lỗi SQL nếu có
    }
}
?>
