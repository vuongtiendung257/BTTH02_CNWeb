<?php
// controllers/MaterialController.php

require_once dirname(__DIR__) . '/config/Database.php';
require_once dirname(__DIR__) . '/models/Material.php';
require_once dirname(__DIR__) . '/models/Lesson.php';

class MaterialController {
    private $db;
    private $materialModel;
    private $lessonModel;
    private $instructorId;

    public function __construct() {
        // session_start();

        // Giả lập giảng viên (giữ giống các controller khác)
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 1) {
            $_SESSION['user_id'] = 4;
            $_SESSION['role'] = 1;
            $_SESSION['fullname'] = 'Nguyễn Văn Tuấn';
        }

        $this->instructorId = $_SESSION['user_id'];
        $this->db = Database::getInstance();
        $this->materialModel = new Material($this->db);
        $this->lessonModel = new Lesson($this->db);
    }

    // Kiểm tra bài học có thuộc khóa của giảng viên không
    private function verifyLessonOwnership($lesson_id) {
        $lesson = $this->lessonModel->getById($lesson_id);
        if (!$lesson) return false;

        $stmt = $this->db->prepare("SELECT id FROM courses WHERE id = ? AND instructor_id = ?");
        $stmt->execute([$lesson['course_id'], $this->instructorId]);
        return $stmt->fetch() !== false;
    }

    // Form upload tài liệu cho bài học
    public function uploadForm($lesson_id) {
        if (!$this->verifyLessonOwnership($lesson_id)) {
            $_SESSION['error'] = 'Không có quyền truy cập bài học này!';
            header('Location: dashboard.php');
            exit();
        }

        $lesson = $this->lessonModel->getById($lesson_id);
        $materials = $this->materialModel->getByLessonId($lesson_id);

        require dirname(__DIR__) . '/views/instructor/materials/upload.php';
    }

    // Xử lý upload file
    public function store($lesson_id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['material_file'])) {
        if (!$this->verifyLessonOwnership($lesson_id)) {
            $_SESSION['error'] = 'Không có quyền!';
            header("Location: dashboard.php?action=material_upload&lesson_id=$lesson_id");
            exit();
        }

        $file = $_FILES['material_file'];
        $allowed_types = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'zip', 'txt'];
        $max_size = 20 * 1024 * 1024; // 20MB

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // DEBUG CHI TIẾT - SẼ HIỂN THỊ LUÔN TRÊN TRANG
        // $_SESSION['debug'] = "File name: " . $file['name'] . "<br>";
        // $_SESSION['debug'] .= "File size: " . $file['size'] . " bytes<br>";
        // $_SESSION['debug'] .= "Error code: " . $file['error'] . "<br>";
        // $_SESSION['debug'] .= "Extension: " . $ext . "<br>";

        if ($file['error'] !== 0) {
            $_SESSION['error'] = 'Lỗi upload PHP: mã lỗi ' . $file['error'];
        } elseif (!in_array($ext, $allowed_types)) {
            $_SESSION['error'] = 'Loại file không được phép!';
        } elseif ($file['size'] > $max_size) {
            $_SESSION['error'] = 'File quá lớn!';
        } else {
            $upload_dir = dirname(__DIR__, 2) . '/assets/uploads/materials/';
            $_SESSION['debug'] .= "Upload dir: " . $upload_dir . "<br>";

            if (!is_dir($upload_dir)) {
                $_SESSION['debug'] .= "Thư mục không tồn tại, đang tạo...<br>";
                if (!mkdir($upload_dir, 0777, true)) {
                    $_SESSION['error'] = 'Không thể tạo thư mục upload!';
                }
            }

            if (is_dir($upload_dir) && !is_writable($upload_dir)) {
                $_SESSION['error'] = 'Thư mục không có quyền ghi! (permission denied)';
            } else {
                $filename = $file['name'];
                $file_path = $upload_dir . $filename;

                // $_SESSION['debug'] .= "Đang di chuyển file đến: " . $file_path . "<br>";

                if (move_uploaded_file($file['tmp_name'], $file_path)) {
                    // copy($file['name'], $file_path);
                    $data = [
                        'lesson_id' => $lesson_id,
                        'filename' => $file['name'],
                        'file_path' => 'assets/uploads/materials/' . $filename,
                        'file_type' => $ext
                    ];

                    if ($this->materialModel->create($data)) {
                        $_SESSION['success'] = 'Upload thành công!';
                    } else {
                        $_SESSION['error'] = 'Lưu DB thất bại!';
                        unlink($file_path);
                    }
                } else {
                    $_SESSION['error'] = 'move_uploaded_file thất bại! (có thể do quyền hoặc đường dẫn)';
                }
            }
        }

    }

    header("Location: dashboard.php?action=material_upload&lesson_id=$lesson_id");
    exit();
}
    // Xóa tài liệu
    public function delete($material_id) {
        $material = $this->materialModel->getById($material_id);
        if (!$material || !$this->verifyLessonOwnership($material['lesson_id'])) {
            $_SESSION['error'] = 'Không có quyền!';
            header('Location: dashboard.php');
            exit();
        }

        // Xóa file thật
        if (file_exists(dirname(__DIR__, 2) . '/' . $material['file_path'])) {
            unlink(dirname(__DIR__, 2) . '/' . $material['file_path']);
        }

        if ($this->materialModel->delete($material_id)) {
            $_SESSION['success'] = 'Xóa tài liệu thành công!';
        } else {
            $_SESSION['error'] = 'Xóa thất bại!';
        }

        header("Location: dashboard.php?action=material_upload&lesson_id={$material['lesson_id']}");
        exit();
    }
}
?>