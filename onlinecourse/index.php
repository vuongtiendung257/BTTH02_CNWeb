<?php
// index.php – Router chính

session_start();

/*
|--------------------------------------------------------------------------
| REQUIRE FILES
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/helpers/auth.php';
require_once __DIR__ . '/controllers/AuthController.php';

$authController = new AuthController();

/*
|--------------------------------------------------------------------------
| ROUTER
|--------------------------------------------------------------------------
*/
$page = $_GET['page'] ?? 'home';

switch ($page) {

    /*
    |--------------------------------------------------------------------------
    | AUTH
    |--------------------------------------------------------------------------
    */
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->register();
        } else {
            $hideHeader = true;
            require_once __DIR__ . '/views/layouts/header.php';
            require_once __DIR__ . '/views/auth/register.php';
            require_once __DIR__ . '/views/layouts/footer.php';
        }
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        } else {
            $hideHeader = true;
            require_once __DIR__ . '/views/layouts/header.php';
            require_once __DIR__ . '/views/auth/login.php';
            require_once __DIR__ . '/views/layouts/footer.php';
        }
        break;

    case 'logout':
        session_unset();
        session_destroy();
        header("Location: index.php?page=login");
        exit;

    /*
    |--------------------------------------------------------------------------
    | HOME
    |--------------------------------------------------------------------------
    */
    case 'home':
        require_once __DIR__ . '/views/layouts/header.php';
        echo "<h2>Chào mừng đến với hệ thống!</h2>";
        echo "<p>Đây là trang chủ.</p>";
        require_once __DIR__ . '/views/layouts/footer.php';
        break;

    /*
    |--------------------------------------------------------------------------
    | STUDENT
    |--------------------------------------------------------------------------
    */
    case 'student/dashboard':
        requireRole(0);
        require_once __DIR__ . '/views/layouts/header.php';
        echo "<h2>Dashboard Học viên</h2>";
        echo "<p>Xin chào " . htmlspecialchars($_SESSION['fullname']) . "!</p>";
        require_once __DIR__ . '/views/layouts/footer.php';
        break;

    /*
    |--------------------------------------------------------------------------
    | INSTRUCTOR
    |--------------------------------------------------------------------------
    */
    case 'instructor/dashboard':
        header("Location: views/instructor/dashboard.php");
        break;

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    case 'admin/dashboard':
        requireRole(2);
        require_once __DIR__ . '/views/layouts/header.php';
        echo "<h2>Dashboard Admin</h2>";
        echo "<p>Xin chào " . htmlspecialchars($_SESSION['fullname']) . "!</p>";
        require_once __DIR__ . '/views/layouts/footer.php';
        break;

    /*
    |--------------------------------------------------------------------------
    | 404
    |--------------------------------------------------------------------------
    */
    default:
        require_once __DIR__ . '/views/layouts/header.php';
        echo "<h2>404 - Trang không tồn tại</h2>";
        require_once __DIR__ . '/views/layouts/footer.php';
        break;
}