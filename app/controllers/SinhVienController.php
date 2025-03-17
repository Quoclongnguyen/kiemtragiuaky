<?php
require_once __DIR__ . '/../models/SinhVien.php';

class SinhVienController {
    public function index() {
        $sinhVien = new SinhVien();
        $students = $sinhVien->getAllStudents();
        include __DIR__ . '/../views/sinhvien/index.php';
    }
}
?>
