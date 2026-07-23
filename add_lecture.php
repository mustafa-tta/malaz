<?php
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header('Location: lectures.php');
    exit;
}

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $instructor = trim($_POST['instructor'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $duration = (int)($_POST['duration'] ?? 0);
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image'] ?? '');

    if (empty($title) || empty($instructor) || empty($subject) || $duration <= 0 || empty($location)) {
        $error = 'جميع الحقول مطلوبة وبصيغة صحيحة.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO lectures (title, instructor, subject, duration, location, image, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $instructor, $subject, $duration, $location, $image, $description]);
            $success = true;
        } catch (PDOException $e) {
            $error = 'حدث خطأ أثناء الإضافة.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>إضافة محاضرة - منصة المحاضرات</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>

    <nav class="navbar">
        <div class="nav-logo">
            منصة <span>المحاضرات</span>
        </div>
        <div class="nav-links" id="navLinks">
            <a href="index.php">الرئيسية</a>
            <a href="lectures.php" class="active">المحاضرات</a>
            <a href="contact.php">تواصل معنا</a>
            <a href="logout.php" class="nav-cta">تسجيل خروج</a>
        </div>
        <div class="hamburger" id="hamburger">
            <span></span><span></span><span></span>
        </div>
    </nav>

    <div class="page-hero">
        <h1>➕ إضافة محاضرة جديدة</h1>
        <p>أدخل بيانات المحاضرة والأستاذ المحاضر</p>
    </div>

    <section class="section section-light">
        <div class="container" style="max-width:600px;">
            <div style="background:white; border-radius:16px; padding:30px; box-shadow:var(--shadow);">
                <?php if ($success): ?>
                    <div style="background:#d4edda; color:#155724; padding:12px; border-radius:8px; margin-bottom:16px;">✅ تمت إضافة المحاضرة بنجاح.</div>
                <?php elseif ($error): ?>
                    <div style="background:#f8d7da; color:#721c24; padding:12px; border-radius:8px; margin-bottom:16px;">❌ <?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label>عنوان المحاضرة</label>
                        <input type="text" name="title" placeholder="مثل: مقدمة في الذكاء الاصطناعي" required />
                    </div>
                    <div class="form-group">
                        <label>اسم المحاضر</label>
                        <input type="text" name="instructor" placeholder="مثل: د. أحمد سليمان" required />
                    </div>
                    <div class="form-group">
                        <label>اسم المادة</label>
                        <input type="text" name="subject" placeholder="مثل: علوم الحاسوب" required />
                    </div>
                    <div class="form-group">
                        <label>المدة (بالدقائق)</label>
                        <input type="number" name="duration" placeholder="مثل: 90" required />
                    </div>
                    <div class="form-group">
                        <label>مكان الانعقاد / القاعة</label>
                        <input type="text" name="location" placeholder="مثل: قاعة 101 - كلية العلوم" required />
                    </div>
                    <div class="form-group">
                        <label>اسم ملف الصورة (في مجلد images)</label>
                        <input type="text" name="image" placeholder="مثل: ai.jpg" />
                    </div>
                    <div class="form-group">
                        <label>الوصف وتفاصيل المحاضرة</label>
                        <textarea name="description" rows="4" placeholder="اكتب وصفاً مختصراً عن المحاضرة..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;">💾 حفظ المحاضرة</button>
                </form>
                <div style="margin-top:16px; text-align:center;">
                    <a href="lectures.php" class="btn" style="background:#e2e8f0; color:#0A1628;">🔙 العودة للجدول</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-brand">منصة <span>المحاضرات</span></div>
            <p>منصتك الموثوقة لتنظيم ومتابعة المحاضرات التعليمية</p>
            
            <div class="social-icons">
                <a href="https://github.com" target="_blank" aria-label="GitHub"><i class="fab fa-github"></i></a>
                <a href="https://twitter.com" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="https://youtube.com" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            </div>

            <div class="footer-bottom">
                <span>© 2026 منصة المحاضرات. جميع الحقوق محفوظة.</span>
                <span>🇸🇩 السودان</span>
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>