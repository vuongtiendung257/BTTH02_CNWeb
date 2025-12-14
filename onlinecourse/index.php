<?php
// index.php - Router đơn giản (hỗ trợ register + login)

session_start();

require_once __DIR__ . '/controllers/AuthController.php';

$controller = new AuthController();

if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case 'register':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->register();
            } else {
                require_once __DIR__ . '/views/auth/register.php';
            }
            break;

        case 'login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->login();      // hàm login sẽ thêm sau
            } else {
                require_once __DIR__ . '/views/auth/login.php';
            }
            break;
        
        case 'home':
            require_once __DIR__ . '/views/layouts/header.php';
            echo "<h2>Chào mừng đến với hệ thống!</h2>";
            echo "<p>Đây là trang chủ.</p>";
            require_once __DIR__ . '/views/layouts/footer.php';
            break;

        case 'logout':
            session_destroy();
            header("Location: index.php?page=home");
            exit;
        
            case 'student/dashboard':
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 0) {
                header("Location: index.php?page=login");
                exit;
            }
            require_once __DIR__ . '/views/layouts/header.php';
            echo "<h2>Dashboard Học viên</h2>";
            echo "<p>Xin chào học viên " . htmlspecialchars($_SESSION['fullname']) . "!</p>";
            echo "<p>Đây là khu vực dành cho học viên.</p>";
            require_once __DIR__ . '/views/layouts/footer.php';
            break;

        case 'instructor/dashboard':
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
                header("Location: index.php?page=login");
                exit;
            }
            require_once __DIR__ . '/views/layouts/header.php';
            echo "<h2>Dashboard Giảng viên</h2>";
            echo "<p>Xin chào giảng viên " . htmlspecialchars($_SESSION['fullname']) . "!</p>";
            echo "<p>Đây là khu vực quản lý khóa học của bạn.</p>";
            require_once __DIR__ . '/views/layouts/footer.php';
            break;

        case 'admin/dashboard':
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
                header("Location: index.php?page=login");
                exit;
            }
            require_once __DIR__ . '/views/layouts/header.php';
            echo "<h2>Dashboard Quản trị viên</h2>";
            echo "<p>Xin chào admin " . htmlspecialchars($_SESSION['fullname']) . "!</p>";
            echo "<p>Đây là khu vực quản trị hệ thống.</p>";
            require_once __DIR__ . '/views/layouts/footer.php';
            break;

        default:
            echo "Trang chủ<br>";
            echo "<a href='index.php?page=register'>Đăng ký</a> | ";
            echo "<a href='index.php?page=login'>Đăng nhập</a>";
            break;
    }
} else {
    // Trang mặc định
    echo "Trang chủ<br>";
    echo "<a href='index.php?page=register'>Đăng ký</a> | ";
    echo "<a href='index.php?page=login'>Đăng nhập</a>";
}