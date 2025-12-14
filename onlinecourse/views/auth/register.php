<?php
// views/auth/register.php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        input { width: 100%; padding: 10px; box-sizing: border-box; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <?php
    if (isset($_SESSION['user_id'])) 
        {
        header("Location: index.php?page=home");
        exit;
    }
    ?>


    <h2>Đăng ký tài khoản</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="error" style="color: red;">
            <?php echo htmlspecialchars(urldecode($_GET['error'])); ?>
        </p>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <p class="success">Đăng ký thành công! Vui lòng <a href="index.php?page=login">đăng nhập</a>.</p>
    <?php endif; ?>

    <form action="index.php?page=register" method="POST">
        <div class="form-group">
            <label>Họ và tên</label>
            <input type="text" name="fullname" required>
        </div>

        <div class="form-group">
            <label>Tên đăng nhập</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Mật khẩu</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Xác nhận mật khẩu</label>
            <input type="password" name="confirm_password" required>
        </div>

        <button type="submit">Đăng ký</button>
    </form>

    <p>Đã có tài khoản? <a href="index.php?page=login">Đăng nhập</a></p>

</body>
</html>