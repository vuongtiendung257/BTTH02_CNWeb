<?php include '../layouts/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý bài học - Khóa: <?= htmlspecialchars($course['title']) ?></h2>
        <a href="dashboard.php" class="btn btn-secondary">← Quay lại danh sách khóa học</a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <a href="dashboard.php?action=lesson_create&course_id=<?= $courseId ?>" class="btn btn-success mb-3">
        + Thêm bài học mới
    </a>

    <?php if (empty($lessons)): ?>
        <div class="alert alert-info">
            Khóa học này chưa có bài học nào. Hãy thêm bài học đầu tiên!
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Thứ tự</th>
                        <th>Tiêu đề bài học</th>
                        <th>Video URL</th>
                        <th>Nội dung tóm tắt</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lessons as $lesson): ?>
                        <tr>
                            <td><strong><?= $lesson['order_num'] ?></strong></td>
                            <td><?= htmlspecialchars($lesson['title']) ?></td>
                            <td>
                                <?php if (!empty($lesson['video_url'])): ?>
                                    <a href="<?= htmlspecialchars($lesson['video_url']) ?>" target="_blank" class="text-decoration-none">
                                        Xem video ↗
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Không có</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= htmlspecialchars(substr(strip_tags($lesson['content']), 0, 100)) ?>
                                <?= strlen(strip_tags($lesson['content'])) > 100 ? '...' : '' ?>
                            </td>
                            <td>
                                <a href="dashboard.php?action=lesson_edit&id=<?= $lesson['id'] ?>" 
                                   class="btn btn-sm btn-warning">Sửa</a>
                                <a href="dashboard.php?action=lesson_delete&id=<?= $lesson['id'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Xóa bài học này? Tài liệu đính kèm cũng sẽ bị xóa!')">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include '../layouts/footer.php'; ?>