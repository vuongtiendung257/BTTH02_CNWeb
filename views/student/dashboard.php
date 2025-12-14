<h1>Chào mừng, **<?= htmlspecialchars($_SESSION['user_fullname'] ?? 'Học viên') ?>**!</h1>
<p>Đây là bảng điều khiển tổng quan về hành trình học tập của bạn.</p>

<div class="dashboard-stats">
    <div class="stat-card">
        <h3>Tổng số khóa học</h3>
        <p class="stat-number"><?= $data['total_courses'] ?? 0 ?></p>
        <a href="/my-courses">Xem tất cả</a>
    </div>
    <div class="stat-card">
        <h3>Khóa học đã hoàn thành</h3>
        <p class="stat-number"><?= $data['completed_courses'] ?? 0 ?></p>
        <a href="/my-courses?status=completed">Xem chứng chỉ</a>
    </div>
    <div class="stat-card">
        <h3>Tiến độ chung</h3>
        <p class="stat-number">
             <?php 
                $avg_progress = 0; 
                if ($data['total_courses'] > 0) {
                   // Giả định logic tính trung bình đã có
                   $avg_progress = 55; // Ví dụ
                }
             ?>
             <?= $avg_progress ?>% 
        </p>
        <a href="/my-courses">Theo dõi chi tiết</a>
    </div>
</div>

<div class="dashboard-recent-courses">
    <h2>Khóa học đang học gần đây</h2>
    <?php if (!empty($data['recent_courses'])): ?>
        <div class="recent-course-list">
            <?php foreach ($data['recent_courses'] as $course): ?>
                <div class="recent-course-item">
                    <h4><?= htmlspecialchars($course['title']) ?></h4>
                    <div class="progress-info">
                        Tiến độ: **<?= $course['progress'] ?>%**
                        <div class="progress-bar-bg">
                            <div class="progress-bar" style="width: <?= $course['progress'] ?>%;"></div>
                        </div>
                    </div>
                    <a href="/course/detail/<?= $course['id'] ?>" class="btn-continue">Tiếp tục học</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Bạn chưa có khóa học nào đang học. <a href="/courses">Bắt đầu khóa học đầu tiên!</a></p>
    <?php endif; ?>
</div>

<style>
.dashboard-stats {
    display: flex;
    gap: 20px;
    margin-bottom: 40px;
}
.stat-card {
    flex: 1;
    background: #f7f7f7;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
}
.stat-card h3 {
    margin-top: 0;
    color: #555;
}
.stat-number {
    font-size: 2.5em;
    font-weight: bold;
    color: #007bff;
    margin: 10px 0;
}
.recent-course-item {
    padding: 15px;
    border: 1px solid #eee;
    margin-bottom: 10px;
    border-left: 5px solid #28a745;
    background: #fff;
}
.progress-bar-bg {
    background-color: #e9ecef;
    border-radius: 5px;
    overflow: hidden;
    height: 10px;
    margin-top: 5px;
}
.progress-bar {
    background-color: #28a745;
    height: 100%;
    transition: width 0.4s ease;
}
.btn-continue {
    display: inline-block;
    background-color: #007bff;
    color: white;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 10px;
}
</style>