<?php
// controllers/EnrollmentController.php

require_once '../config/Database.php';
require_once '../models/Enrollment.php';

class EnrollmentController {
    private $enrollmentModel;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 0) {
            header('Location: ../views/auth/login.php');
            exit();
        }

        $db = Database::getInstance();
        $this->enrollmentModel = new Enrollment($db);
    }

    public function enroll() {
        $course_id = $_GET['id'] ?? 0;

        if ($course_id > 0) {
            if ($this->enrollmentModel->enroll($course_id, $_SESSION['user_id'])) {
                $_SESSION['success'] = 'Đăng ký khóa học thành công!';
            } else {
                $_SESSION['error'] = 'Bạn đã đăng ký khóa học này rồi!';
            }
        }

        header("Location: ../views/courses/detail.php?id=$course_id");
        exit();
    }
}
?>