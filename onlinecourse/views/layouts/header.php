<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Giả lập fullname nếu chưa có (tránh lỗi null)
$fullname = $_SESSION['fullname'] ?? 'Giảng viên';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giảng Viên - Quản Lý Khóa Học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .alert { border-radius: 8px; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="dashboard.php">Dashboard Giảng Viên</a>
            <div class="navbar-nav ms-auto">
                <span class="nav-item text-white me-3">
                    Xin chào, <strong><?= htmlspecialchars($fullname) ?></strong>
                </span>
                <a class="btn btn-outline-light btn-sm" href="?action=logout">Đăng xuất</a>
            </div>
        </div>
    </nav>
    <div class="container mt-4 mb-5">