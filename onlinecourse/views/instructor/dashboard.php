

<?php
// views/instructor/dashboard.php

session_start();

// Kiểm tra quyền truy cập giảng viên
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 1) {
    // Nếu chưa đăng nhập hoặc không phải giảng viên → về login
    header("Location: ../../index.php?page=login");
    exit();
}

// Loại bỏ xử lý logout riêng vì giờ header đã link trực tiếp đến index.php?page=logout

// Các require controller như cũ
require_once '../../controllers/CourseController.php';
$controller = new CourseController();

require_once '../../controllers/LessonController.php';
$lessonController = new LessonController();

require_once '../../controllers/MaterialController.php';
$materialController = new MaterialController();

$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'edit':
        $controller->edit($id);
        break;
    case 'update':
        $controller->update($id);
        break;
    case 'delete':
        $controller->delete($id);
        break;
    case 'lessons_manage':
        $lessonController->manage($_GET['course_id'] ?? 0);
        break;
    case 'lesson_create':
        $lessonController->create($_GET['course_id'] ?? 0);
        break;
    case 'lesson_store':
        $lessonController->store($_GET['course_id'] ?? 0);
        break;
    case 'lesson_edit':
        $lessonController->edit($_GET['id'] ?? 0);
        break;
    case 'lesson_update':
        $lessonController->update($_GET['id'] ?? 0);
        break;
    case 'lesson_delete':
        $lessonController->delete($_GET['id'] ?? 0);
        break;
    case 'material_upload':
        $materialController->uploadForm($_GET['lesson_id'] ?? 0);
        break;
    case 'material_store':
        $materialController->store($_GET['lesson_id'] ?? 0);
        break;
    case 'material_delete':
        $materialController->delete($_GET['id'] ?? 0);
        break;
    case 'index':
    default:
        $controller->index();
        break;
}
?>