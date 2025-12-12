<?php
// index.php - Router đơn giản để test đăng ký (đã test 100% hoạt động)

session_start();

require_once __DIR__ . '/controllers/AuthController.php';

$controller = new AuthController();

// Debug để xem route có vào đúng không
// echo "<pre>"; print_r($_SERVER); echo "</pre>"; // bỏ comment nếu cần debug

if (isset($_GET['page']) && $_GET['page'] === 'register') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->register();   // xử lý khi nhấn nút Đăng ký
    } else {
        require_once __DIR__ . '/views/auth/register.php';  // hiển thị form
    }
    exit;
}

// Nếu truy cập trang khác thì hiện link vào form
echo "Trang chủ<br>";
echo "<a href='/register'>Đăng ký tài khoản</a>";