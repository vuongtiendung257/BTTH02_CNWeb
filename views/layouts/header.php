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
    <title>Đăng kí khóa học online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .alert { border-radius: 8px; }
    </style>
</head>
<body class="bg-light">
    
    <div class="container mt-4 mb-5">