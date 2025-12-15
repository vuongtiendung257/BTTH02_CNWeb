

<?php
// views/instructor/dashboard.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra quyền truy cập giảng viên
// Loại bỏ xử lý logout riêng vì giờ header đã link trực tiếp đến index.php?page=logout

// Các require controller như cũ
require_once '../../views/layouts/header.php';

require_once '../../controllers/CourseController.php';
$controller = new CourseController();

require_once '../../controllers/EnrollmentController.php';
$EnrollmentController = new EnrollmentController();

$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'search':
        $controller->search();
        break;
    case 'detail':
        $controller->detail();
        break;
    case 'enroll':
        $EnrollmentController->enroll();
        break;
    default:
        $controller->studentDashboard();
        break;
}

require_once '../../views/layouts/footer.php';
?>