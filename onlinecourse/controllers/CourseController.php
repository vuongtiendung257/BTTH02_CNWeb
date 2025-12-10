<?php
class CourseController extends Controller {

    // Danh sách khóa học + tìm kiếm + lọc
    public function index() {
        $courseModel = $this->model("Course");

        $keyword = $_GET['keyword'] ?? "";
        $category = $_GET['category'] ?? "";

        $courses = $courseModel->getAllCourses($keyword, $category);

        $this->view("courses/index", [
            "title" => "Danh sách khóa học",
            "courses" => $courses
        ]);
    }

    // Chi tiết khóa học
    public function detail($id) {
        $course = $this->model("Course")->getCourseById($id);
        $lessons = $this->model("Course")->getLessons($id);

        // Kiểm tra đã đăng ký chưa
        $enrollModel = $this->model("Enrollment");
        $isEnrolled = $enrollModel->isEnrolled($id, $_SESSION['user']['id']);

        $this->view("courses/detail", [
            "course" => $course,
            "lessons" => $lessons,
            "isEnrolled" => $isEnrolled
        ]);
    }
}
