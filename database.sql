-- ==========================================
-- TẠO DATABASE
-- ==========================================
CREATE DATABASE IF NOT EXISTS onlinecourse
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE onlinecourse;

-- ==========================================
-- 1. Bảng users
-- ==========================================
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    role INT NOT NULL DEFAULT 0,                    -- 0: học viên, 1: giảng viên, 2: admin
    status TINYINT DEFAULT 1 COMMENT '1: hoạt động, 0: bị khóa',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ==========================================
-- 2. Bảng categories
-- ==========================================
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ==========================================
-- 3. Bảng courses
-- ==========================================
CREATE TABLE courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    instructor_id INT NOT NULL,
    category_id INT NOT NULL,
    price DECIMAL(10,2) DEFAULT 0.00,
    duration_weeks INT DEFAULT 0,
    level VARCHAR(50) DEFAULT 'Beginner',
    image VARCHAR(255) DEFAULT NULL,
    status VARCHAR(50) DEFAULT 'pending' COMMENT 'draft, pending, approved',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (instructor_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- ==========================================
-- 4. Bảng enrollments
-- ==========================================
CREATE TABLE enrollments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    student_id INT NOT NULL,
    enrolled_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT 'active',
    progress INT DEFAULT 0,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (course_id, student_id)
);

-- ==========================================
-- 5. Bảng lessons
-- ==========================================
CREATE TABLE lessons (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT,
    video_url VARCHAR(255),
    order_num INT NOT NULL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- ==========================================
-- 6. Bảng materials
-- ==========================================
CREATE TABLE materials (
    id INT PRIMARY KEY AUTO_INCREMENT,
    lesson_id INT NOT NULL,
    filename VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_type VARCHAR(50) NOT NULL,
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
);

-- ==========================================
-- RESET DATA (đã sửa để chạy được 100%)
-- ==========================================
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE materials;
TRUNCATE TABLE lessons;
TRUNCATE TABLE enrollments;
TRUNCATE TABLE courses;
TRUNCATE TABLE categories;
TRUNCATE TABLE users;

SET FOREIGN_KEY_CHECKS = 1;

-- ==========================================
-- INSERT 34 USERS
-- ==========================================
INSERT INTO users (username, email, password, fullname, role, status) VALUES
('superadmin', 'super@sys.vn', '123456', 'Quản trị hệ thống', 2, 1),
('admin1', 'admin1@sys.vn', '123456', 'Admin Hỗ trợ', 2, 1),
('admin2', 'admin2@sys.vn', '123456', 'Admin Nội dung', 2, 1),
('gv_tuan', 'tuan@edu.vn', '123456', 'Nguyễn Văn Tuấn', 1, 1),
('gv_minh', 'minh@edu.vn', '123456', 'Trần Minh Hoàng', 1, 1),
('gv_thuy', 'thuy@edu.vn', '123456', 'Lê Thị Thúy', 1, 1),
('gv_khanh', 'khanh@edu.vn', '123456', 'Phạm Ngọc Khánh', 1, 1),
('gv_lan', 'lan@edu.vn', '123456', 'Đặng Thị Lan', 1, 1),
('hv_anh', 'anh@st.vn', '123456', 'Nguyễn Văn Anh', 0, 1),
('hv_bao', 'bao@st.vn', '123456', 'Trần Bảo Nam', 0, 1),
('hv_chau', 'chau@st.vn', '123456', 'Lê Ngọc Châu', 0, 1),
('hv_dung', 'dung@st.vn', '123456', 'Phạm Minh Dũng', 0, 1),
('hv_hoa', 'hoa@st.vn', '123456', 'Hoàng Thị Hoa', 0, 1),
('hv_kien', 'kien@st.vn', '123456', 'Vũ Minh Kiên', 0, 1),
('hv_linh', 'linh@st.vn', '123456', 'Nguyễn Thùy Linh', 0, 1),
('hv_manh', 'manh@st.vn', '123456', 'Trịnh Văn Mạnh', 0, 1),
('hv_ngoc', 'ngoc@st.vn', '123456', 'Phạm Bảo Ngọc', 0, 1),
('hv_phuc', 'phuc@st.vn', '123456', 'Đỗ Hoàng Phúc', 0, 1),
('hv_quynh', 'quynh@st.vn', '123456', 'Lý Thị Quỳnh', 0, 1),
('hv_son', 'son@st.vn', '123456', 'Cao Thái Sơn', 0, 1),
('hv_thanh', 'thanh@st.vn', '123456', 'Ngô Văn Thành', 0, 1),
('hv_tien', 'tien@st.vn', '123456', 'Bùi Minh Tiến', 0, 1),
('hv_van', 'van@st.vn', '123456', 'Lại Thị Vân', 0, 1),
('hv_xuan', 'xuan@st.vn', '123456', 'Đinh Văn Xuân', 0, 1),
('hv_yen', 'yen@st.vn', '123456', 'Trần Thị Yến', 0, 1),
('hv_zung', 'zung@st.vn', '123456', 'Hà Văn Dũng', 0, 1),
('hv_thao', 'thao@st.vn', '123456', 'Đỗ Phương Thảo', 0, 1),
('hv_khoa', 'khoa@st.vn', '123456', 'Mạc Đăng Khoa', 0, 1),
('hv_hung', 'hung@st.vn', '123456', 'Nguyễn Hoàng Hùng', 0, 1),
('hv_nhi', 'nhi@st.vn', '123456', 'Lê Ngọc Nhi', 0, 1),
('hv_tuananh', 'tuananh@st.vn', '123456', 'Trần Tuấn Anh', 0, 1),
('hv_binh', 'binh@st.vn', '123456', 'Phạm Văn Bình', 0, 1),
('hv_viet', 'viet@st.vn', '123456', 'Ngô Quốc Việt', 0, 1),
('hv_tam', 'tam@st.vn', '123456', 'Trần Thanh Tâm', 0, 1);

-- ==========================================
-- INSERT 12 CATEGORIES
-- ==========================================
INSERT INTO categories (name, description) VALUES
('Lập trình Web', 'HTML, CSS, JavaScript, PHP, Laravel, Node.js'),
('Lập trình Mobile', 'Android, iOS, Flutter, React Native'),
('Khoa học dữ liệu & AI', 'Python, Machine Learning, Deep Learning'),
('Thiết kế đồ họa & UI/UX', 'Photoshop, Illustrator, Figma'),
('Digital Marketing', 'SEO, Google Ads, Facebook Ads, Content'),
('Kỹ năng mềm & Phát triển bản thân', 'Giao tiếp, Lãnh đạo, Quản lý thời gian'),
('Ngoại ngữ', 'Tiếng Anh, Tiếng Nhật, Tiếng Hàn'),
('Tin học văn phòng', 'Excel, Word, PowerPoint nâng cao'),
('An ninh mạng & DevOps', 'Cyber Security, Docker, Kubernetes'),
('Blockchain & Crypto', 'Ethereum, Solidity, DeFi'),
('Lập trình Game', 'Unity, Unreal Engine'),
('Kinh doanh Online', 'Shopee, TikTok Shop, Dropshipping');

-- ==========================================
-- INSERT 23 COURSES
-- ==========================================
INSERT INTO courses (title, description, instructor_id, category_id, price, duration_weeks, level, status) VALUES
('Laravel 10 từ Zero đến Hero', 'Xây dựng website hoàn chỉnh với Laravel', 4, 1, 1200000, 12, 'Intermediate', 'approved'),
('ReactJS & Redux nâng cao', 'Xây dựng SPA mạnh mẽ với React', 4, 1, 1500000, 10, 'Advanced', 'approved'),
('HTML & CSS Responsive', 'Thiết kế web đẹp trên mọi thiết bị', 5, 1, 500000, 6, 'Beginner', 'approved'),
('NodeJS & Express Fullstack', 'Backend với Node.js và MongoDB', 4, 1, 1300000, 8, 'Intermediate', 'approved'),
('Flutter - App đa nền tảng', 'Xây dựng iOS & Android bằng Dart', 6, 2, 1800000, 14, 'Intermediate', 'approved'),
('Android Kotlin hiện đại', 'Lập trình Android chuyên nghiệp', 6, 2, 1400000, 12, 'Beginner', 'approved'),
('Python Data Science & Pandas', 'Phân tích dữ liệu chuyên sâu', 7, 3, 1600000, 10, 'Intermediate', 'approved'),
('Machine Learning thực chiến', 'Dự đoán & phân loại với Scikit-learn', 7, 3, 2200000, 12, 'Advanced', 'approved'),
('Photoshop từ cơ bản đến pro', 'Chỉnh sửa ảnh chuyên nghiệp', 8, 4, 600000, 6, 'Beginner', 'approved'),
('Figma UI/UX Design chuyên sâu', 'Thiết kế giao diện đẹp & thân thiện', 8, 4, 800000, 8, 'Intermediate', 'approved'),
('SEO & Content Marketing 2025', 'Chiến lược SEO mới nhất', 5, 5, 1000000, 8, 'Intermediate', 'approved'),
('Facebook Ads & TikTok Ads', 'Chạy quảng cáo hiệu quả', 5, 5, 1200000, 6, 'Beginner', 'approved'),
('Tiếng Anh giao tiếp thực chiến', 'Nói tiếng Anh tự tin trong 90 ngày', 8, 7, 900000, 10, 'Beginner', 'approved'),
('Excel nâng cao & Power Query', 'Xử lý dữ liệu lớn với Excel', 5, 8, 500000, 5, 'Intermediate', 'approved'),
('Linux Server & DevOps', 'Quản trị máy chủ và container', 6, 9, 1800000, 10, 'Advanced', 'approved'),
('Blockchain & Smart Contract', 'Xây dựng DApp trên Ethereum', 4, 10, 2000000, 10, 'Advanced', 'approved'),
('Unity 2D & 3D Game Development', 'Tạo game chuyên nghiệp với Unity', 7, 11, 1700000, 12, 'Intermediate', 'approved'),
('VueJS 3 Composition API', 'Framework frontend hiện đại', 4, 1, 1100000, 8, 'Intermediate', 'approved'),
('Docker & Kubernetes thực chiến', 'Triển khai ứng dụng container', 6, 9, 1900000, 8, 'Advanced', 'approved'),
('Cyber Security cho người mới', 'Bảo mật thông tin cơ bản', 6, 9, 1300000, 8, 'Beginner', 'approved'),
('Kinh doanh Online với Shopee', 'Bán hàng triệu đô trên Shopee', 5, 12, 900000, 8, 'Beginner', 'approved'),
('JavaScript ES6+ Masterclass', 'Hiểu sâu về JS hiện đại', 4, 1, 800000, 6, 'Intermediate', 'approved'),
('Deep Learning với TensorFlow', 'Xây dựng mạng nơ-ron sâu', 7, 3, 2500000, 14, 'Advanced', 'approved');

-- ==========================================
-- INSERT 35 ENROLLMENTS
-- ==========================================
INSERT INTO enrollments (course_id, student_id, status, progress) VALUES
(1, 9, 'active', 35), (1, 10, 'active', 80), (1, 11, 'completed', 100),
(2, 12, 'active', 15), (2, 13, 'active', 60), (2, 14, 'dropped', 5),
(3, 15, 'active', 90), (3, 16, 'completed', 100), (3, 17, 'active', 40),
(4, 18, 'active', 25), (4, 19, 'active', 70),
(5, 20, 'active', 55), (5, 21, 'completed', 100),
(6, 22, 'active', 10), (6, 23, 'active', 30),
(7, 24, 'active', 45), (7, 25, 'active', 85),
(8, 26, 'active', 20), (8, 27, 'active', 65),
(9, 28, 'completed', 100), (9, 29, 'active', 15),
(10, 30, 'active', 50), (10, 31, 'active', 90),
(11, 32, 'active', 30), (11, 33, 'active', 75),
(12, 34, 'dropped', 0), (13, 9, 'active', 60),
(14, 10, 'active', 80), (15, 11, 'active', 25),
(16, 12, 'active', 40), (17, 13, 'completed', 100),
(18, 14, 'active', 10), (19, 15, 'active', 70), (20, 16, 'active', 95);

-- ==========================================
-- INSERT 23 LESSONS
-- ==========================================
INSERT INTO lessons (course_id, title, content, video_url, order_num) VALUES
(1, 'Cài đặt Laravel 10', 'Hướng dẫn cài Laravel mới nhất', 'https://youtu.be/7v6K3dP6vE0', 1),
(1, 'Cấu trúc dự án Laravel', 'Giải thích MVC trong Laravel', 'https://youtu.be/2vK0y9r3r3c', 2),
(1, 'Routing & Controller', 'Cách định tuyến và xử lý request', 'https://youtu.be/3kL9mZ9pQ8Y', 3),
(2, 'ReactJS - JSX & Component', 'Hiểu về JSX và component', 'https://youtu.be/9kL5y9k9q9k', 1),
(2, 'State & Props', 'Quản lý dữ liệu trong React', 'https://youtu.be/9kL5y9k9q9k', 2),
(3, 'HTML5 Semantic Tags', 'Sử dụng thẻ semantic đúng chuẩn', 'https://youtu.be/4tK9mZ9pQ8Y', 1),
(3, 'CSS Flexbox & Grid', 'Thiết kế layout hiện đại', 'https://youtu.be/5uL9mZ9pQ8Y', 2),
(4, 'Cài đặt NodeJS & Express', 'Khởi tạo dự án backend', 'https://youtu.be/6vK9mZ9pQ8Y', 1),
(5, 'Flutter - Widget cơ bản', 'Hiểu về widget trong Flutter', 'https://youtu.be/7wK9mZ9pQ8Y', 1),
(6, 'Kotlin - Biến & Kiểu dữ liệu', 'Cú pháp Kotlin cơ bản', 'https://youtu.be/8xL9mZ9pQ8Y', 1),
(7, 'Python - Pandas DataFrame', 'Làm việc với dữ liệu bảng', 'https://youtu.be/9yL9mZ9pQ8Y', 1),
(8, 'Machine Learning - Linear Regression', 'Mô hình hồi quy tuyến tính', 'https://youtu.be/0zL9mZ9pQ8Y', 1),
(9, 'Photoshop - Layer & Mask', 'Sử dụng layer và mask', 'https://youtu.be/1aL9mZ9pQ8Y', 1),
(10, 'Figma - Auto Layout', 'Thiết kế responsive với Figma', 'https://youtu.be/2bL9mZ9pQ8Y', 1),
(11, 'SEO On-page & Off-page', 'Chiến lược SEO hiệu quả', 'https://youtu.be/3cL9mZ9pQ8Y', 1),
(12, 'Facebook Ads - Tạo chiến dịch', 'Cách chạy quảng cáo Facebook', 'https://youtu.be/4dL9mZ9pQ8Y', 1),
(13, 'Tiếng Anh - Phát âm chuẩn', 'Luyện phát âm IPA', 'https://youtu.be/5eL9mZ9pQ8Y', 1),
(14, 'Excel - VLOOKUP & INDEX-MATCH', 'Tra cứu dữ liệu nâng cao', 'https://youtu.be/6fL9mZ9pQ8Y', 1),
(15, 'Linux - Cài đặt Ubuntu Server', 'Thiết lập máy chủ Linux', 'https://youtu.be/7gL9mZ9pQ8Y', 1),
(16, 'Blockchain - Hiểu về Hash', 'Khái niệm Hash trong blockchain', 'https://youtu.be/8hL9mZ9pQ8Y', 1),
(17, 'Unity - Cài đặt & Tạo Scene', 'Bắt đầu với Unity', 'https://youtu.be/9iL9mZ9pQ8Y', 1),
(18, 'VueJS 3 - Composition API', 'Học Composition API', 'https://youtu.be/0jL9mZ9pQ8Y', 1),
(19, 'Docker - Tạo Dockerfile', 'Viết Dockerfile đầu tiên', 'https://youtu.be/1kL9mZ9pQ8Y', 1);

-- ==========================================
-- INSERT 8 MATERIALS
-- ==========================================
INSERT INTO materials (lesson_id, filename, file_path, file_type) VALUES
(1, 'laravel_install_guide.pdf', 'assets/uploads/materials/laravel_install.pdf', 'pdf'),
(1, 'laravel_project_structure.png', 'assets/uploads/materials/laravel_structure.png', 'image'),
(2, 'react_jsx_cheatsheet.pdf', 'assets/uploads/materials/react_jsx.pdf', 'pdf'),
(3, 'html5_semantic_tags.html', 'assets/uploads/materials/semantic_tags.html', 'code'),
(5, 'flutter_widget_catalog.pdf', 'assets/uploads/materials/flutter_widgets.pdf', 'pdf'),
(9, 'photoshop_layer_mask.zip', 'assets/uploads/materials/photoshop_layer.zip', 'zip'),
(11, 'seo_checklist_2025.pdf', 'assets/uploads/materials/seo_checklist.pdf', 'pdf'),
(19, 'docker_basics.pdf', 'assets/uploads/materials/docker_basics.pdf', 'pdf');

-- Bật lại kiểm tra khóa ngoại
SET FOREIGN_KEY_CHECKS = 1;