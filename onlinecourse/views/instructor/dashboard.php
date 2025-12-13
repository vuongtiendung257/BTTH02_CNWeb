<?php
// views/instructor/dashboard.php - Trang dashboard + router cho giảng viên

session_start();

// Giả lập đăng nhập giảng viên (sẽ bỏ khi có Auth thật)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 1) {
    $_SESSION['user_id'] = 4;  // gv_tuan
    $_SESSION['role'] = 1;
    $_SESSION['fullname'] = 'Nguyễn Văn Tuấn';
}

// Xử lý logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: dashboard.php');
    exit();
}

require_once '../../controllers/CourseController.php';

$controller = new CourseController();

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
    case 'index':
    default:
        $controller->index();
        break;
}
?>