<?php
// controllers/EnrollmentController.php

require_once 'models/Enrollment.php';

class EnrollmentController {

    // ... (Phương thức enroll() ) ...
    
    public function myCourses()
{
    if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? -1) != 0) {
        die('Bạn chưa đăng nhập với vai trò học viên');
    }

    $student_id = $_SESSION['user_id'];
    $enrollmentModel = new Enrollment();

    $enrolled_courses = $enrollmentModel->getAllEnrolledCoursesWithProgress($student_id);

    // 🔥 CÁCH ĐƠN GIẢN NHẤT
    require 'views/student/my_courses.php';
}

    // ... (Phương thức enroll() ) ...

    public function enroll() {
        // 1. Kiểm tra Quyền và Phương thức
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 0 || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            // Trả về lỗi
            // header('Location: /'); exit;
        }

        $course_id = $_POST['course_id'] ?? null;
        $student_id = $_SESSION['user_id'];

        if (!$course_id || !is_numeric($course_id)) {
            // Xử lý lỗi
        }

        $enrollmentModel = new Enrollment();

        // 2. Đăng ký khóa học
        $success = $enrollmentModel->createEnrollment((int)$course_id, $student_id);

        if ($success) {
            // Chuyển hướng về trang "Khóa học của tôi" kèm thông báo thành công
            header('Location: /my-courses?message=success');
        } else {
            // Chuyển hướng về trang chi tiết khóa học kèm thông báo lỗi
            header('Location: /course/detail/' . $course_id . '?message=fail');
        }
        exit;
    }
    
}