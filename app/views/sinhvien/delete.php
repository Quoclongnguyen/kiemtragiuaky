<?php
require_once __DIR__ . '/../../config/database.php';

if (isset($_GET['id'])) {
    $MaSV = $_GET['id'];

    $database = new Database();
    $conn = $database->getConnection();

    // Lấy đường dẫn ảnh để xóa
    $sql = "SELECT Hinh FROM SinhVien WHERE MaSV = :MaSV";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaSV', $MaSV);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        // Xóa ảnh khỏi thư mục
        $imagePath = "../../../" . $student['Hinh'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // Xóa ảnh khỏi thư mục
        }

        // Xóa sinh viên khỏi database
        $sql = "DELETE FROM SinhVien WHERE MaSV = :MaSV";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':MaSV', $MaSV);

        if ($stmt->execute()) {
            echo "Xóa sinh viên thành công!";
            header("Location: ../../../index.php");
        } else {
            echo "Lỗi khi xóa sinh viên!";
        }
    } else {
        echo "Không tìm thấy sinh viên!";
    }
} else {
    echo "Mã sinh viên không hợp lệ!";
}
?>
