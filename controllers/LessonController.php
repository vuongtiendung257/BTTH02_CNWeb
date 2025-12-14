<?php
// controllers/LessonController.php

require_once 'models/Lesson.php';
require_once 'models/Enrollment.php';
require_once 'models/Course.php'; 

class LessonController {

    public function viewLesson($lesson_id) {
        // 1. Kiểm tra Quyền (Học viên và đã đăng ký khóa học)
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 0) {
            // header('Location: /login'); exit;
        }
        $student_id = $_SESSION['user_id'];
        $lessonModel = new Lesson();
        $enrollmentModel = new Enrollment();

        // Lấy chi tiết bài học
        $lesson = $lessonModel->getLessonDetail($lesson_id);
        if (!$lesson) { /* 404 */ }
        
        $course_id = $lesson['course_id'];
        
        // Kiểm tra học viên đã đăng ký khóa học chưa
        if (!$enrollmentModel->isEnrolled($course_id, $student_id)) {
            // Chuyển hướng về trang chi tiết khóa học và yêu cầu đăng ký
            // header('Location: /course/detail/' . $course_id . '?message=not_enrolled'); exit;
        }

        // 2. Lấy các thông tin cần thiết
        $materials = $lessonModel->getMaterialsByLesson($lesson_id);
        $all_lessons = (new Course())->getLessonsByCourse($course_id); // Lấy danh sách bài học để hiển thị sidebar

        // 3. Logic Cập nhật Tiến độ (Tự động update khi xem)
        $total_lessons = $lessonModel->countLessonsInCourse($course_id);
        
        // Dùng Session để theo dõi các bài đã xem (Đơn giản hóa logic bài tập)
        if (!isset($_SESSION['completed_lessons'])) {
            $_SESSION['completed_lessons'] = [];
        }
        
        // Đánh dấu bài học này đã hoàn thành (unique list)
        $key = $student_id . '_' . $course_id . '_' . $lesson_id;
        $_SESSION['completed_lessons'][$key] = true; 
        
        $completed_count = 0;
        foreach ($all_lessons as $l) {
            $check_key = $student_id . '_' . $course_id . '_' . $l['id'];
            if (isset($_SESSION['completed_lessons'][$check_key])) {
                $completed_count++;
            }
        }
        
        // Tính và cập nhật % tiến độ vào DB
        $progress_percent = $total_lessons > 0 ? floor(($completed_count / $total_lessons) * 100) : 0;
        $enrollmentModel->updateProgress($course_id, $student_id, $progress_percent);


        // 4. Truyền dữ liệu ra View
        $data = [
            'lesson' => $lesson,
            'materials' => $materials,
            'all_lessons' => $all_lessons,
            'course_id' => $course_id,
            'progress' => $progress_percent // Để hiển thị tiến độ mới nhất
        ];

        // View::render('student/course_progress', $data);
        include 'views/student/course_progress.php';
    }
}