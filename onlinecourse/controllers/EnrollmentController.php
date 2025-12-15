<?php
require_once dirname(__DIR__) . '/config/Database.php';
require_once dirname(__DIR__) . '/models/Enrollment.php';

class EnrollmentController {
    private $db;
    private $enrollmentModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = Database::getInstance();
        $this->enrollmentModel = new Enrollment($this->db);
    }

    // POST: đăng ký khóa học
    public function enroll() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: dashboard.php");
            exit;
        }

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 0) {
            header("Location: ../../index.php?page=login");
            exit;
        }

        $courseId  = $_POST['course_id'] ?? null;
        $studentId = $_SESSION['user_id'];

        if (!$courseId) {
            $_SESSION['error'] = "Thiếu thông tin khóa học";
            header("Location: dashboard.php");
            exit;
        }

        if ($this->enrollmentModel->enrollCourse($courseId, $studentId)) {
            $_SESSION['success'] = "Đăng ký khóa học thành công!";
        } else {
            $_SESSION['error'] = "Bạn đã đăng ký khóa học này!";
        }

        header("Location: dashboard.php");
        exit;
    }
    
     public function isEnrolled($studentId, $courseId) {
        $stmt = $this->db->prepare(
            "SELECT id FROM enrollments 
             WHERE student_id = ? AND course_id = ?"
        );
        $stmt->execute([$studentId, $courseId]);
        return $stmt->fetch() ? true : false;
    }

}
