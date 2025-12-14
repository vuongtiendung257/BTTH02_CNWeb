<?php include '../layouts/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Upload tài liệu cho bài học: <?= htmlspecialchars($lesson['title']) ?></h2>

    <a href="dashboard.php?action=lessons_manage&course_id=<?= $lesson['course_id'] ?>" class="btn btn-secondary mb-3">
        ← Quay lại quản lý bài học
    </a>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5>Upload tài liệu mới</h5>
        </div>
        <div class="card-body">
            <form action="dashboard.php?action=material_store&lesson_id=<?= $lesson['id'] ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="material_file" class="form-label">Chọn file (PDF, DOC, PPT, ZIP... tối đa 20MB)</label>
                    <input type="file" name="material_file" id="material_file" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Upload tài liệu</button>
            </form>
        </div>
    </div>

    <h4>Danh sách tài liệu hiện có</h4>
    <?php if (empty($materials)): ?>
        <p class="text-muted">Chưa có tài liệu nào.</p>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($materials as $mat): ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?= htmlspecialchars($mat['filename']) ?></strong>
                        <small class="text-muted d-block">(<?= strtoupper($mat['file_type']) ?>, uploaded <?= date('d/m/Y H:i', strtotime($mat['uploaded_at'])) ?>)</small>
                    </div>
                    <div>
                        <a href="/onlinecourse/<?= htmlspecialchars($mat['file_path']) ?>" class="btn btn-sm btn-primary" target="_blank">
                            Tải xuống
                        </a>
                        <a href="dashboard.php?action=material_delete&id=<?= $mat['id'] ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Xóa tài liệu này?')">Xóa</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include '../layouts/footer.php'; ?>