CREATE DATABASE IF NOT EXISTS lecture_platform
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE lecture_platform;

-- جدول المستخدمين (المحاضرين / الطلاب)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول المحاضرات
CREATE TABLE lectures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    instructor VARCHAR(100) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    duration INT NOT NULL, -- مدة المحاضرة بالدقائق
    location VARCHAR(100) NOT NULL,
    image VARCHAR(100) DEFAULT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول الاستفسارات والتواصل
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- بيانات أولية للمحاضرات
INSERT INTO lectures (title, instructor, subject, duration, location, image, description) VALUES
('مقدمة في الذكاء الاصطناعي', 'د. أحمد سليمان', 'علوم الحاسوب', 90, 'قاعة 101 - كلية العلوم', 'ai.jpg', 'محاضرة شاملة تغطي أساسيات الذكاء الاصطناعي وتعلم الآلة مع تطبيقات عملية.'),
('تطوير تطبيقات الويب الحديثة', 'م. سارة محمود', 'هندسة البرمجيات', 120, 'المختبر المركزي', 'web.jpg', 'شرح أساسيات تطوير الويب باستخدام أحدث التقنيات وأفضل الممارسات البرمجية.'),
('إدارة المشاريع البرمجية', 'د. عمر الفاروق', 'إدارة الأعمال', 60, 'مدرج د. علي', 'pm.jpg', 'تعلم كيف تنظم مشاريعك البرمجية وتدير فرق العمل بفعالية باستخدام المنهجيات الحديثة.');