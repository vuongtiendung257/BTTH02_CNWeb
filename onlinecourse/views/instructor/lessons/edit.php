<?php include '../layouts/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Sửa bài học: <?= htmlspecialchars($lesson['title']) ?></h2>

    <form action="dashboard.php?action=lesson_update&id=<?= $lesson['id'] ?>" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label fw-bold">Tiêu đề bài học <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control" 
                   value="<?= htmlspecialchars($lesson['title']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Nội dung bài học</label>
            <textarea name="content" id="content" class="form-control" rows="10"><?= htmlspecialchars($lesson['content']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="video_url" class="form-label">Link video YouTube</label>
            <input type="url" name="video_url" id="video_url" class="form-control" 
                   value="<?= htmlspecialchars($lesson['video_url'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="order_num" class="form-label">Thứ tự hiển thị</label>
            <input type="number" name="order_num" id="order_num" class="form-control" 
                   value="<?= $lesson['order_num'] ?>" min="0">
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success btn-lg me-3">Cập nhật bài học</button>
            <a href="dashboard.php?action=lessons_manage&course_id=<?= $lesson['course_id'] ?>" 
               class="btn btn-secondary btn-lg">Quay lại</a>
        </div>
    </form>
</div>

<?php include '../layouts/footer.php'; ?>