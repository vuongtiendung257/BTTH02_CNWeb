<?php
session_start();
// Nếu là giảng viên → chuyển về dashboard instructor
if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
    header('Location: ../instructor/dashboard.php');
    exit();
}
// Nếu là học viên hoặc chưa login → OK, tiếp tục
?>
<?php include '../layouts/header.php'; ?>
<?php
// Đầu file app/views/courses/index.php
$courses = $courses ?? [];      // Tránh undefined
$categories = $categories ?? []; 
?>
<div class="container py-5">
    <h1 class="text-center mb-5 fw-bold">Danh sách khóa học</h1>

    <!-- Form tìm kiếm + lọc -->
    <form method="GET" class="mb-5">
        <div class="row g-3 justify-content-center">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-lg" placeholder="Tìm kiếm khóa học..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select form-select-lg">
                    <option value="">Tất cả danh mục</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= ($_GET['category'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-lg w-100">Tìm kiếm</button>
            </div>
        </div>
    </form>

    <!-- Danh sách khóa học -->
    <?php if (empty($courses)): ?>
        <div class="text-center py-5">
            <h4 class="text-muted">Không có khóa học nào phù hợp.</h4>
            <p>Thử thay đổi từ khóa tìm kiếm hoặc bộ lọc danh mục.</p>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($courses as $course): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="../assets/uploads/courses/default.jpg" class="card-img-top" alt="Khóa học" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold"><?= htmlspecialchars($course['title']) ?></h5>
                            <p class="card-text text-muted small">
                                <i class="bi bi-person-fill"></i> <?= htmlspecialchars($course['instructor_name']) ?>
                            </p>
                            <p class="card-text text-muted small">
                                <i class="bi bi-tag-fill"></i> <?= htmlspecialchars($course['category_name']) ?>
                            </p>
                            <div class="mt-auto">
                                <p class="card-text fw-bold text-primary fs-4 mb-2"><?= number_format($course['price']) ?> ₫</p>
                                <p class="card-text text-muted small mb-3"><?= $course['duration_weeks'] ?> tuần • <?= $course['level'] ?></p>
                                <a href="detail.php?id=<?= $course['id'] ?>" class="btn btn-primary w-100">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include '../layouts/footer.php'; ?>