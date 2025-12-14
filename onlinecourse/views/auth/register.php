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

            <form>
                <div class="form-group">
                    <input type="text" required>
                    <label>Họ và tên</label>
                    <span class="input-icon"><i class="fa fa-user"></i></span>
                </div>

                <div class="form-group">
                    <input type="text" required>
                    <label>Tên đăng nhập</label>
                    <span class="input-icon"><i class="fa fa-id-badge"></i></span>
                </div>

                <div class="form-group">
                    <input type="email" required>
                    <label>Email</label>
                    <span class="input-icon"><i class="fa fa-envelope"></i></span>
                </div>

                <div class="form-group">
                    <input type="password" required>
                    <label>Mật khẩu</label>
                    <span class="input-icon"><i class="fa fa-lock"></i></span>
                </div>

                <div class="form-group">
                    <input type="password" required>
                    <label>Xác nhận mật khẩu</label>
                    <span class="input-icon"><i class="fa fa-lock"></i></span>
                </div>

                <button class="btn-auth">Đăng ký</button>
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

</body>
</html>