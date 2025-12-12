<?php
// index.php - Router tạm thời để test form đăng ký

session_start();

// Route đơn giản nhất
if (isset($_GET['page']) && $_GET['page'] === 'register') {
    require_once __DIR__ . '/views/auth/register.php';
    exit;
}

// Trang mặc định (nếu chưa có)
echo "Xin chào! Để xem form đăng ký, truy cập: <a href='index.php?page=register'>Đăng ký</a>";