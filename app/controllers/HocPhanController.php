<?php
require_once __DIR__ . '/../models/HocPhan.php';
require_once __DIR__ . '/../models/ChiTietDangKy.php'; // Đảm bảo bạn đã tạo mô hình này cho bảng ChiTietDangKy

class HocPhanController {
    // Hiển thị danh sách học phần
    public function index() {
        $hocPhan = new HocPhan();
        $chiTietDangKy = new ChiTietDangKy();

        // Lấy tất cả học phần và học phần đã đăng ký
        $allSubjects = $hocPhan->getAllSubjects();
        $registeredSubjects = $chiTietDangKy->getRegisteredSubjects($_SESSION['MaSV']);

        // Xử lý đăng ký học phần
        if (isset($_POST['register'])) {
            $MaSV = $_SESSION['MaSV'];
            $MaHP = $_POST['MaHP'];
            $this->registerSubject($MaSV, $MaHP);
        }

        // Xử lý hủy đăng ký học phần
        if (isset($_POST['unregister'])) {
            $MaSV = $_SESSION['MaSV'];
            $MaHP = $_POST['MaHP'];
            $this->unregisterSubject($MaSV, $MaHP);
        }

        // Xử lý xóa tất cả học phần đã đăng ký
        if (isset($_POST['deleteAll'])) {
            $MaSV = $_SESSION['MaSV'];
            $this->deleteAllSubjects($MaSV);
        }

        include __DIR__ . '/../views/hocphan/index.php'; // Truyền dữ liệu ra view
    }

    // Đăng ký học phần
    private function registerSubject($MaSV, $MaHP) {
        $chiTietDangKy = new ChiTietDangKy();
        $result = $chiTietDangKy->registerSubject($MaSV, $MaHP);
        if ($result) {
            echo "Đăng ký học phần thành công!";
        } else {
            echo "Có lỗi khi đăng ký học phần!";
        }
    }

    // Hủy đăng ký học phần
    private function unregisterSubject($MaSV, $MaHP) {
        $chiTietDangKy = new ChiTietDangKy();
        $result = $chiTietDangKy->unregisterSubject($MaSV, $MaHP);
        if ($result) {
            echo "Hủy đăng ký học phần thành công!";
        } else {
            echo "Có lỗi khi hủy đăng ký học phần!";
        }
    }

    // Xóa tất cả học phần đã đăng ký
    private function deleteAllSubjects($MaSV) {
        $chiTietDangKy = new ChiTietDangKy();
        $result = $chiTietDangKy->deleteAllRegistrations($MaSV);
        if ($result) {
            echo "Đã xóa tất cả học phần đăng ký!";
        } else {
            echo "Có lỗi khi xóa tất cả học phần!";
        }
    }
}
?>
