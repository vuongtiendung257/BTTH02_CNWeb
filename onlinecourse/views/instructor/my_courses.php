<?php include '../layouts/header.php'; ?>

<h2 class="mb-4">Khóa học của tôi</h2>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<a href="dashboard.php?action=create" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Tạo khóa học mới
</a>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-primary">
            <tr>
                <th>STT</th>
                <th>Tiêu đề</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>Thời lượng</th>
                <th>Mức độ</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($courses)): ?>
                <tr><td colspan="7" class="text-center text-muted py-4">Bạn chưa tạo khóa học nào.</td></tr>
            <?php else: ?>
                <?php foreach ($courses as $index => $course): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><strong><?= htmlspecialchars($course['title']) ?></strong></td>
                    <td><?= htmlspecialchars($course['category_name'] ?? 'N/A') ?></td>
                    <td><?= number_format($course['price']) ?> ₫</td>
                    <td><?= $course['duration_weeks'] ?> tuần</td>
                    <td>
                        <span class="badge bg-<?= $course['level'] == 'Beginner' ? 'info' : ($course['level'] == 'Intermediate' ? 'warning' : 'danger') ?>">
                            <?= $course['level'] ?>
                        </span>
                    </td>
                    <td>
                        <a href="dashboard.php?action=edit&id=<?= $course['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                        <a href="dashboard.php?action=delete&id=<?= $course['id'] ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Xóa khóa học này? Dữ liệu bài học và tài liệu sẽ mất!')">Xóa</a>
                        <a href="lessons.php?course_id=<?= $course['id'] ?>" class="btn btn-sm btn-info">Bài học</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../layouts/footer.php'; ?>