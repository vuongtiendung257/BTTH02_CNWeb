<!-- views/auth/login.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 80px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        input { width: 100%; padding: 10px; box-sizing: border-box; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../layouts/header.php'; ?>
    <h2>Đăng nhập</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="error"><?php echo htmlspecialchars(urldecode($_GET['error'])); ?></p>
    <?php endif; ?>

    <form action="index.php?page=login" method="POST">
        <div class="form-group">
            <label>Email hoặc Tên đăng nhập</label>
            <input type="text" name="login" required placeholder="Email hoặc username">
        </div>

        <div class="form-group">
            <label>Mật khẩu</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Đăng nhập</button>
    </form>

    <p>Chưa có tài khoản? <a href="index.php?page=register">Đăng ký</a></p>
    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>