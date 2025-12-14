<?php include '../layouts/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Thêm bài học mới cho khóa: <?= htmlspecialchars($course['title'] ?? 'N/A') ?></h2>

    <form action="dashboard.php?action=lesson_store&course_id=<?= $courseId ?>" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label fw-bold">Tiêu đề bài học <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Nội dung bài học (HTML được phép)</label>
            <textarea name="content" id="content" class="form-control" rows="10"></textarea>
            <small class="text-muted">Bạn có thể dùng thẻ &lt;p&gt;, &lt;h3&gt;, &lt;ul&gt;, &lt;code&gt;... để định dạng</small>
        </div>

        <div class="mb-3">
            <label for="video_url" class="form-label">Link video YouTube (tùy chọn)</label>
            <input type="url" name="video_url" id="video_url" class="form-control" 
                   placeholder="https://www.youtube.com/watch?v=... hoặc https://youtu.be/...">
        </div>

        <div class="mb-3">
            <label for="order_num" class="form-label">Thứ tự hiển thị</label>
            <input type="number" name="order_num" id="order_num" class="form-control" value="0" min="0">
            <small class="text-muted">Số càng lớn càng hiển thị sau</small>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success btn-lg me-3">Thêm bài học</button>
            <a href="dashboard.php?action=lessons_manage&course_id=<?= $courseId ?>" class="btn btn-secondary btn-lg">Quay lại</a>
        </div>
    </form>
</div>

<?php include '../layouts/footer.php'; ?>