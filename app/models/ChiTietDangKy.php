<?php
class ChiTietDangKy {
    private $conn;
    private $table = 'ChiTietDangKy';

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    // Lấy các học phần đã đăng ký của sinh viên
    public function getRegisteredSubjects($MaSV) {
        $query = "SELECT * FROM " . $this->table . " WHERE MaSV = :MaSV";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':MaSV', $MaSV);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Đăng ký học phần
    public function registerSubject($MaSV, $MaHP) {
        $query = "INSERT INTO " . $this->table . " (MaSV, MaHP) VALUES (:MaSV, :MaHP)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':MaSV', $MaSV);
        $stmt->bindParam(':MaHP', $MaHP);
        return $stmt->execute();
    }

    // Hủy đăng ký học phần
    public function unregisterSubject($MaSV, $MaHP) {
        $query = "DELETE FROM " . $this->table . " WHERE MaSV = :MaSV AND MaHP = :MaHP";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':MaSV', $MaSV);
        $stmt->bindParam(':MaHP', $MaHP);
        return $stmt->execute();
    }

    // Xóa tất cả học phần đã đăng ký
    public function deleteAllRegistrations($MaSV) {
        $query = "DELETE FROM " . $this->table . " WHERE MaSV = :MaSV";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':MaSV', $MaSV);
        return $stmt->execute();
    }
}
?>
