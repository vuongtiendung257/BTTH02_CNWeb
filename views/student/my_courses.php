<h1>Khóa học của tôi</h1>
<h2>📚 Khóa học của tôi</h2>

<?php if (empty($courses)): ?>
    <p>Bạn chưa đăng ký khóa học nào.</p>
<?php else: ?>
<table border="1" width="100%" cellpadding="10">
    <tr>
        <th>Tên khóa học</th>
        <th>Tiến độ</th>
        <th>Hành động</th>
    </tr>

    <?php foreach ($courses as $c): ?>
    <tr>
        <td><?= $c['title'] ?></td>
        <td><?= $c['progress'] ?>%</td>
        <td>
            <a href="index.php?controller=enrollment&action=progress&course_id=<?= $c['id'] ?>">
                Xem tiến độ
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>

<div class="my-courses-list">
    <?php if (!empty($data['enrolled_courses'])): ?>
        <?php foreach ($data['enrolled_courses'] as $course): ?>
            <div class="course-progress-card">
                
                <img 
                    src="/assets/uploads/courses/<?= htmlspecialchars($course['image'] ?? 'default_course.jpg') ?>" 
                    alt="<?= htmlspecialchars($course['title']) ?>" 
                    class="course-card-image"
                >
                
                <div class="card-content">
                    <h2><?= htmlspecialchars($course['title']) ?></h2>
                    <p class="instructor-info">Giảng viên: **<?= htmlspecialchars($course['instructor_name']) ?>**</p>
                    
                    <div class="progress-section">
                        <div class="progress-percent">
                            Tiến độ: **<?= $course['progress'] ?>%** <?php if ($course['status'] == 'completed'): ?>
                                <span class="status-completed">(Đã hoàn thành)</span>
                            <?php endif; ?>
                        </div>

                        <div class="progress-bar-bg">
                            <div 
                                class="progress-bar" 
                                style="width: <?= $course['progress'] ?>%;"
                            ></div>
                        </div>
                    </div>
                    
                    <a 
                        href="/lesson/view/<?= $course['id'] ?>" 
                        class="btn-continue-course"
                    >
                        <?= $course['status'] == 'completed' ? 'Xem lại khóa học' : 'Tiếp tục học' ?> <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

            </div>
        <?php endforeach; ?>

    <?php else: ?>
        <div class="no-courses">
            <p>Bạn chưa đăng ký khóa học nào. <a href="/courses">Khám phá các khóa học ngay!</a></p>
        </div>
    <?php endif; ?>
</div>

<style>
/* CSS cơ bản cho My Courses */
.my-courses-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-top: 20px;
}

.course-progress-card {
    display: flex;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    background-color: #fff;
}

.course-card-image {
    width: 200px; /* Nhỏ hơn một chút so với ví dụ trước */
    height: 150px;
    object-fit: cover;
}

.card-content {
    padding: 15px 20px;
    flex-grow: 1;
}

.card-content h2 {
    margin-top: 0;
    font-size: 1.5em;
    color: #007bff; /* Tông màu xanh cho tiêu đề */
}

.instructor-info {
    font-size: 0.9em;
    color: #777;
    margin-bottom: 10px;
}

.progress-section {
    margin: 10px 0;
    padding: 10px;
    border-radius: 6px;
    background-color: #f5f5f5;
}

.progress-percent {
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
    font-size: 0.95em;
}

.status-completed {
    color: #198754; /* Xanh lá cây */
}

.progress-bar-bg {
    background-color: #e9ecef;
    border-radius: 5px;
    overflow: hidden;
    height: 8px;
}

.progress-bar {
    background-color: #28a745; /* Màu xanh lá cây cho tiến độ */
    height: 100%;
    transition: width 0.4s ease;
}

.btn-continue-course {
    display: inline-block;
    background-color: #007bff;
    color: white;
    padding: 8px 15px;
    text-decoration: none;
    border-radius: 4px;
    margin-top: 15px;
    font-size: 0.9em;
}

.no-courses {
    padding: 20px;
    text-align: center;
    border: 1px dashed #ccc;
    border-radius: 6px;
}
</style>