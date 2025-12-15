<?php
// controllers/CourseController.php

require_once dirname(__DIR__) . '/config/Database.php';
require_once dirname(__DIR__) . '/models/Course.php';
require_once dirname(__DIR__) . '/models/Enrollment.php';


class CourseController {
    private $db;
    private $courseModel;

    public function __construct() {
        // session_start();

        // Giả lập nếu cần (có thể bỏ nếu dashboard.php đã làm)
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['user_id'] = 4;
            $_SESSION['role'] = 1;
        }

        $this->db = Database::getInstance();  // dùng singleton của bạn
        $this->courseModel = new Course($this->db);
    }

    public function index() {
        $courses = $this->courseModel->getMyCourses($_SESSION['user_id']);
        require dirname(__DIR__) . '/views/instructor/my_courses.php';
    }

    public function create() {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY name");
        $categories = $stmt->fetchAll();
        require dirname(__DIR__) . '/views/instructor/course/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'category_id' => (int)$_POST['category_id'],
                'price' => (float)$_POST['price'],
                'duration_weeks' => (int)$_POST['duration_weeks'],
                'level' => $_POST['level'],
                'image' => 'default.jpg'
            ];

            if ($this->courseModel->create($data, $_SESSION['user_id'])) {
                $_SESSION['success'] = 'Tạo khóa học thành công!';
            } else {
                $_SESSION['error'] = 'Tạo thất bại!';
            }
            header('Location: ../instructor/dashboard.php');
            exit();
        }
    }

    public function edit($id) {
        $course = $this->courseModel->getById($id, $_SESSION['user_id']);
        if (!$course) {
            $_SESSION['error'] = 'Không có quyền truy cập!';
            header('Location: ../instructor/dashboard.php');
            exit();
        }
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY name");
        $categories = $stmt->fetchAll();
        require dirname(__DIR__) . '/views/instructor/course/edit.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'category_id' => (int)$_POST['category_id'],
                'price' => (float)$_POST['price'],
                'duration_weeks' => (int)$_POST['duration_weeks'],
                'level' => $_POST['level'],
                'image' => 'default.jpg'
            ];

            if ($this->courseModel->update($id, $data, $_SESSION['user_id'])) {
                $_SESSION['success'] = 'Cập nhật thành công!';
            } else {
                $_SESSION['error'] = 'Cập nhật thất bại!';
            }
            header('Location: ../instructor/dashboard.php');
            exit();
        }
    }

    public function delete($id) {
        if ($this->courseModel->delete($id, $_SESSION['user_id'])) {
            $_SESSION['success'] = 'Xóa thành công!';
        } else {
            $_SESSION['error'] = 'Xóa thất bại!';
        }
            header('Location: ../instructor/dashboard.php');
        exit();
    }
   public function studentDashboard() {
        $courses = $this->courseModel->getAll();
        $categories = $this->courseModel->getCategories();
        require dirname(__DIR__) . '/views/courses/manage.php';
    }


    // Tìm kiếm khóa học (học viên)
    public function search() {
        $keyword = $_GET['keyword'] ?? '';
        $categoryId = $_GET['category_id'] ?? null;

        $courses = $this->courseModel->search($keyword, $categoryId);
        $categories = $this->courseModel->getCategories();

        require dirname(__DIR__) . '/views/courses/manage.php';
    }

    // Xem chi tiết khóa học (học viên)
    // Chi tiết khóa học (học viên)
    public function detail()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?page=student/dashboard");
            exit;
        }

        $course = $this->courseModel->getDetailWithLessons($id);

        if (!$course) {
            echo "<p>Khóa học không tồn tại.</p>";
            return;
        }

        require dirname(__DIR__) . '/views/courses/detail.php';
    }


}
?>