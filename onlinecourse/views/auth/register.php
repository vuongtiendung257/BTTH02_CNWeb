<?php
// views/auth/register.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="auth-page">

<div class="auth-wrapper">
    <div class="auth-container" id="authBox">

        <!-- ================= FORM REGISTER ================= -->
        <div class="auth-form register-form">
            <h2 class="auth-title">Đăng ký tài khoản</h2>

            <!-- Thông báo thành công (hiếm khi hiển thị ở đây vì sẽ auto redirect, nhưng vẫn giữ để an toàn) -->
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success" style="margin-bottom: 20px; border-radius: 8px;">
                    <i class="fas fa-check-circle"></i>
                    <?= htmlspecialchars($_SESSION['success_message']) ?>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <!-- Thông báo lỗi -->
            <?php if (isset($_SESSION['register_errors'])): ?>
                <div class="alert alert-danger" style="margin-bottom: 20px; border-radius: 8px;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <ul class="mb-0" style="padding-left: 20px; margin-top: 8px;">
                        <?php foreach ($_SESSION['register_errors'] as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php unset($_SESSION['register_errors']); ?>
            <?php endif; ?>

            <form action="index.php?page=register" method="POST">
                <div class="form-group">
                    <input 
                        name="fullname" 
                        type="text" 
                        value="<?= htmlspecialchars($_SESSION['old_input']['fullname'] ?? '') ?>"
                        required
                    >
                    <label>Họ và tên</label>
                    <span class="input-icon"><i class="fa fa-user"></i></span>
                </div>

                <div class="form-group">
                    <input 
                        name="username" 
                        type="text" 
                        value="<?= htmlspecialchars($_SESSION['old_input']['username'] ?? '') ?>"
                        required
                    >
                    <label>Tên đăng nhập</label>
                    <span class="input-icon"><i class="fa fa-id-badge"></i></span>
                </div>

                <div class="form-group">
                    <input 
                        name="email" 
                        type="email" 
                        value="<?= htmlspecialchars($_SESSION['old_input']['email'] ?? '') ?>"
                        required
                    >
                    <label>Email</label>
                    <span class="input-icon"><i class="fa fa-envelope"></i></span>
                </div>

                <div class="form-group">
                    <input 
                        name="password" 
                        type="password" 
                        required
                    >
                    <label>Mật khẩu</label>
                    <span class="input-icon"><i class="fa fa-lock"></i></span>
                </div>

                <div class="form-group">
                    <input 
                        name="confirm_password" 
                        type="password" 
                        required
                    >
                    <label>Xác nhận mật khẩu</label>
                    <span class="input-icon"><i class="fa fa-lock"></i></span>
                </div>

                <button type="submit" class="btn-auth">Đăng ký</button>
            </form>

            <div class="auth-link">
                Đã có tài khoản?
                <a href="index.php?page=login">Đăng nhập</a>
            </div>
        </div>

        <!-- ================= VISUAL ================= -->
        <div class="auth-visual">
            <!-- 📌 ẢNH BÊN PHẢI (minh họa học tập) -->
            <img src="assets/images/chismos.jpg" alt="Study">

            <div class="auth-visual-text">
                <h3>Online Course</h3>
                <p>Học tập mọi lúc, mọi nơi</p>
            </div>
        </div>

    </div>
</div>

<footer>
    © 2025 - Online Course
</footer>

<!-- JS -->
<script src="assets/js/auth.js"></script>

<?php
// Xóa dữ liệu cũ sau khi đã sử dụng
unset($_SESSION['old_input']);
?>

</body>
</html>