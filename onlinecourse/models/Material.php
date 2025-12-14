<?php
class Material {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getByLessonId($lesson_id) {
        $stmt = $this->db->prepare("SELECT * FROM materials WHERE lesson_id = ? ORDER BY uploaded_at DESC");
        $stmt->execute([$lesson_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM materials WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO materials (lesson_id, filename, file_path, file_type, uploaded_at) 
                                    VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([
            $data['lesson_id'],
            $data['filename'],
            $data['file_path'],
            $data['file_type']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM materials WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>