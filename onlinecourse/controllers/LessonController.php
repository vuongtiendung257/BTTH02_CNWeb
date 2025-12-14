<?php
// controllers/LessonController.php

require_once dirname(__DIR__) . '/config/Database.php';
require_once dirname(__DIR__) . '/models/Lesson.php';

class LessonController {
    private $db;
    private $lessonModel;
    private $courseModel;
    private $courseId;
    private $instructorId;

    public function __construct() {


        $this->instructorId = $_SESSION['user_id'];
        $this->db = Database::getInstance();
        $this->lessonModel = new Lesson($this->db);
        $this->courseModel = new Course($this->db);
    }

    // Kiểm tra khóa học có thuộc về giảng viên không (bảo mật)
    private function verifyCourseOwnership($course_id) {
        $stmt = $this->db->prepare("SELECT id FROM courses WHERE id = ? AND instructor_id = ?");
        $stmt->execute([$course_id, $this->instructorId]);
        return $stmt->fetch() !== false;
    }

    // Danh sách bài học của một khóa
    public function manage($course_id) {
        $this->courseId = $course_id;

        if (!$this->verifyCourseOwnership($course_id)) {
            $_SESSION['error'] = 'Bạn không có quyền truy cập khóa học này!';
            header('Location: ../instructor/dashboard.php');
            exit();
        }

        $course_stmt = $this->db->prepare("SELECT title FROM courses WHERE id = ?");
        $course_stmt->execute([$course_id]);
        $course = $course_stmt->fetch();

        $lessons = $this->lessonModel->getByCourseId($course_id);
        $courseId = $course_id;  

        require '../instructor/lessons/manage.php';
    }

    // Form tạo bài học mới
    public function create($course_id) {
        $this->courseId = $course_id;

        if (!$this->verifyCourseOwnership($course_id)) {
            $_SESSION['error'] = 'Không có quyền!';
            header('Location: ../instructor/dashboard.php');
            exit();
        }
        $course = $this->courseModel->getById($course_id, $this->instructorId);
        $courseId = $course_id;  
        require '../instructor/lessons/create.php';
    }

    // Xử lý lưu bài học mới
    public function store($course_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->verifyCourseOwnership($course_id)) {
                $_SESSION['error'] = 'Không có quyền!';
                header('Location: ../instructor/dashboard.php');
                exit();
            }

            $data = [
                'course_id' => $course_id,
                'title' => trim($_POST['title']),
                'content' => $_POST['content'],
                'video_url' => trim($_POST['video_url']),
                'order' => (int)$_POST['order_num']
            ];

            if ($this->lessonModel->create($data)) {
                $_SESSION['success'] = 'Thêm bài học thành công!';
            } else {
                $_SESSION['error'] = 'Thêm bài học thất bại!';
            }
            header("Location: dashboard.php?action=lessons_manage&course_id=$course_id");
            exit();
        }
    }

    // Form sửa bài học
    public function edit($lesson_id) {
        $lesson = $this->lessonModel->getById($lesson_id);

        if (!$lesson) {
            $_SESSION['error'] = 'Bài học không tồn tại!';
            header('Location: ../instructor/dashboard.php');
            exit();
        }

        // Kiểm tra quyền qua course
        if (!$this->verifyCourseOwnership($lesson['course_id'])) {
            $_SESSION['error'] = 'Không có quyền!';
            header('Location: ../instructor/dashboard.php');
            exit();
        }

        $this->courseId = $lesson['course_id'];
        $course = $this->courseModel->getById($this->courseId, $this->instructorId);
        $courseId = $this->courseId;
        require '../instructor/lessons/edit.php';
    }

    // Cập nhật bài học
    public function update($lesson_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lesson = $this->lessonModel->getById($lesson_id);
            if (!$lesson || !$this->verifyCourseOwnership($lesson['course_id'])) {
                $_SESSION['error'] = 'Không có quyền!';
                header('Location: ../instructor/dashboard.php');
                exit();
            }

            $data = [
                'title' => trim($_POST['title']),
                'content' => $_POST['content'],
                'video_url' => trim($_POST['video_url']),
                'order' => (int)$_POST['order_num']
            ];

            if ($this->lessonModel->update($lesson_id, $data)) {
                $_SESSION['success'] = 'Cập nhật bài học thành công!';
            } else {
                $_SESSION['error'] = 'Cập nhật thất bại!';
            }

            header("Location: dashboard.php?action=lessons_manage&course_id={$lesson['course_id']}");
            exit();
        }
    }

    // Xóa bài học
    public function delete($lesson_id) {
        $lesson = $this->lessonModel->getById($lesson_id);
        if (!$lesson || !$this->verifyCourseOwnership($lesson['course_id'])) {
            $_SESSION['error'] = 'Không có quyền!';
            header('Location: ../instructor/dashboard.php');
            exit();
        }

        if ($this->lessonModel->delete($lesson_id)) {
            $_SESSION['success'] = 'Xóa bài học thành công!';
        } else {
            $_SESSION['error'] = 'Xóa thất bại!';
        }

        header("Location: dashboard.php?action=lessons_manage&course_id={$lesson['course_id']}");
        exit();
    }
}
?>