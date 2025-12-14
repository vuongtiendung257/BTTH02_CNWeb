<?php
// controllers/CourseController.php

require_once 'models/Course.php';
require_once 'models/Category.php';
require_once 'models/Enrollment.php';
// Giả định có View class để render
// require_once 'core/View.php'; 

class CourseController {
    public function index() {
        $courseModel = new Course();
        $categoryModel = new Category();

        // 1. Lấy tham số tìm kiếm và lọc
        $search = $_GET['search'] ?? null;
        $category_id = $_GET['category_id'] ?? null;

        // 2. Lấy dữ liệu
        $courses = $courseModel->getAllCourses($search, $category_id);
        $categories = $categoryModel->getAllCategories();

        // 3. Truyền dữ liệu ra View
        $data = [
            'courses' => $courses,
            'categories' => $categories,
            'current_search' => $search,
            'current_category_id' => $category_id
        ];

        // Giả định hàm View::render sẽ tải view và truyền data
        // View::render('courses/index', $data);
        include 'views/courses/index.php';
    }

    public function detail($id) {
        $courseModel = new Course();
        $enrollmentModel = new Enrollment();
        $student_id = $_SESSION['user_id'] ?? null; 
        
        // 1. Lấy chi tiết khóa học và bài học
        $course = $courseModel->getCourseDetail($id);
        $lessons = $courseModel->getLessonsByCourse($id);
        
        if (!$course) {
            // Chuyển hướng hoặc hiển thị lỗi 404
            // header('Location: /404'); exit;
        }

        // 2. Kiểm tra trạng thái đăng ký
        $is_enrolled = false;
        if ($student_id && $_SESSION['user_role'] == 0) {
            $is_enrolled = $enrollmentModel->isEnrolled($id, $student_id);
        }

        // 3. Truyền dữ liệu ra View
        $data = [
            'course' => $course,
            'lessons' => $lessons,
            'is_enrolled' => $is_enrolled
        ];

        // View::render('courses/detail', $data);
        include 'views/courses/detail.php';
    }
}