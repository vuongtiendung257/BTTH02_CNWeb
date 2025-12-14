<?php
// controllers/CourseController.php

require_once dirname(__DIR__) . '/config/Database.php';
require_once dirname(__DIR__) . '/models/Course.php';
require_once dirname(__DIR__) . '/models/Enrollment.php';  // cần cho phần student

class CourseController {
    private $db;
    private $courseModel;

    public function __construct() {
        session_start();  // Bật session (cần thiết cho cả instructor và student)

        $this->db = Database::getInstance();
        $this->courseModel = new Course($this->db);
    }

    // ==================== PHẦN GIẢNG VIÊN (Instructor) ====================

    // Danh sách khóa học của giảng viên
    public function myCourses() {
        // Kiểm tra role giảng viên
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
            header('Location: ../views/auth/login.php');
            exit();
        }

        $courses = $this->courseModel->getMyCourses($_SESSION['user_id']);
        require dirname(__DIR__) . '/views/instructor/my_courses.php';
    }

    public function create() {
        if ($_SESSION['role'] != 1) {
            header('Location: ../views/auth/login.php');
            exit();
        }

        $stmt = $this->db->query("SELECT * FROM categories ORDER BY name");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require dirname(__DIR__) . '/views/instructor/course/create.php';
    }

    public function store() {
        if ($_SESSION['role'] != 1 || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ../views/auth/login.php');
            exit();
        }

        $data = [
            'title'          => trim($_POST['title']),
            'description'    => trim($_POST['description']),
            'category_id'    => (int)$_POST['category_id'],
            'price'          => (float)$_POST['price'],
            'duration_weeks' => (int)$_POST['duration_weeks'],
            'level'          => $_POST['level'],
            'image'          => 'default.jpg'
        ];

        if ($this->courseModel->create($data, $_SESSION['user_id'])) {
            $_SESSION['success'] = 'Tạo khóa học thành công!';
        } else {
            $_SESSION['error'] = 'Tạo khóa học thất bại!';
        }

        header('Location: ../instructor/dashboard.php');
        exit();
    }

    public function edit($id) {
        if ($_SESSION['role'] != 1) {
            header('Location: ../views/auth/login.php');
            exit();
        }

        $course = $this->courseModel->getById($id, $_SESSION['user_id']);
        if (!$course) {
            $_SESSION['error'] = 'Không tìm thấy khóa học hoặc bạn không có quyền!';
            header('Location: ../instructor/dashboard.php');
            exit();
        }

        $stmt = $this->db->query("SELECT * FROM categories ORDER BY name");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require dirname(__DIR__) . '/views/instructor/course/edit.php';
    }

    public function update($id) {
        if ($_SESSION['role'] != 1 || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ../views/auth/login.php');
            exit();
        }

        $data = [
            'title'          => trim($_POST['title']),
            'description'    => trim($_POST['description']),
            'category_id'    => (int)$_POST['category_id'],
            'price'          => (float)$_POST['price'],
            'duration_weeks' => (int)$_POST['duration_weeks'],
            'level'          => $_POST['level'],
            'image'          => 'default.jpg'
        ];

        if ($this->courseModel->update($id, $data, $_SESSION['user_id'])) {
            $_SESSION['success'] = 'Cập nhật thành công!';
        } else {
            $_SESSION['error'] = 'Cập nhật thất bại!';
        }

        header('Location: ../instructor/dashboard.php');
        exit();
    }

    public function delete($id) {
        if ($_SESSION['role'] != 1) {
            header('Location: ../views/auth/login.php');
            exit();
        }

        if ($this->courseModel->delete($id, $_SESSION['user_id'])) {
            $_SESSION['success'] = 'Xóa khóa học thành công!';
        } else {
            $_SESSION['error'] = 'Xóa thất bại hoặc bạn không có quyền!';
        }

        header('Location: ../instructor/dashboard.php');
        exit();
    }

    // ==================== PHẦN HỌC VIÊN & PUBLIC (Student/Public) ====================

    // Danh sách khóa học công khai (public + tìm kiếm + lọc)
    public function publicIndex() {
        $search = $_GET['search'] ?? '';
        $category_id = $_GET['category'] ?? null;

        $courses = $this->courseModel->getAllCourses($search, $category_id);

        $stmt = $this->db->query("SELECT * FROM categories ORDER BY name");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require dirname(__DIR__) . '/views/courses/index.php';
    }

    // Chi tiết khóa học công khai
    public function publicDetail($id = null) {
        $id = $id ?? $_GET['id'] ?? 0;
        if ($id <= 0) {
            $_SESSION['error'] = 'ID khóa học không hợp lệ!';
            header('Location: publicIndex.php');
            exit();
        }

        $course = $this->courseModel->getDetail($id);
        if (!$course) {
            $_SESSION['error'] = 'Khóa học không tồn tại hoặc chưa được duyệt!';
            header('Location: publicIndex.php');
            exit();
        }

        $enrolled_count = $this->courseModel->countEnrollments($id);
        $lesson_count = $this->courseModel->countLessons($id);

        $is_enrolled = false;
        if (isset($_SESSION['user_id']) && $_SESSION['role'] == 0) {
            $enrollmentModel = new Enrollment($this->db);
            $is_enrolled = $enrollmentModel->isEnrolled($id, $_SESSION['user_id']);
        }

        require dirname(__DIR__) . '/views/courses/detail.php';
    }
    public function dashboard() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 0) {
        header('Location: /auth/login');
        exit;
    }

    require 'app/views/student/dashboard.php';
}
}
?>