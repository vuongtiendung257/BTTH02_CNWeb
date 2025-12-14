<?php include '../layouts/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Chỉnh sửa khóa học: <?= htmlspecialchars($course['title']) ?></h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="dashboard.php?action=update&id=<?= $course['id'] ?>" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label fw-bold">Tiêu đề khóa học <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control" 
                   value="<?= htmlspecialchars($course['title']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea name="description" id="description" class="form-control" rows="6">
<?= htmlspecialchars($course['description'] ?? '') ?>
            </textarea>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">-- Chọn danh mục --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" 
                        <?= ($course['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <label for="price" class="form-label">Giá (VNĐ)</label>
                <input type="number" name="price" id="price" class="form-control" min="0" 
                       value="<?= $course['price'] ?>">
            </div>
            <div class="col-md-4">
                <label for="duration_weeks" class="form-label">Thời lượng (tuần)</label>
                <input type="number" name="duration_weeks" id="duration_weeks" class="form-control" min="1" 
                       value="<?= $course['duration_weeks'] ?>">
            </div>
            <div class="col-md-4">
                <label for="level" class="form-label">Mức độ</label>
                <select name="level" id="level" class="form-select">
                    <option value="Beginner" <?= $course['level'] == 'Beginner' ? 'selected' : '' ?>>Beginner</option>
                    <option value="Intermediate" <?= $course['level'] == 'Intermediate' ? 'selected' : '' ?>>Intermediate</option>
                    <option value="Advanced" <?= $course['level'] == 'Advanced' ? 'selected' : '' ?>>Advanced</option>
                </select>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success btn-lg me-3">Cập nhật khóa học</button>
            <a href="dashboard.php" class="btn btn-secondary btn-lg">Quay lại</a>
        </div>
    </form>
</div>

<?php include '../layouts/footer.php'; ?>