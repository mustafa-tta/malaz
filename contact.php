<?php
require_once 'config.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $error = 'جميع الحقول مطلوبة.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'البريد الإلكتروني غير صحيح.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $message]);
            $success = true;
        } catch (PDOException $e) {
            $error = 'حدث خطأ أثناء الإرسال، حاول مرة أخرى.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تواصل معنا - منصة المحاضرات</title>
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
            <a href="lectures.php">المحاضرات</a>
            <a href="contact.php" class="active">تواصل معنا</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="nav-cta">تسجيل خروج</a>
            <?php else: ?>
                <a href="login.php" class="nav-cta">دخول</a>
            <?php endif; ?>
        </div>
        <div class="hamburger" id="hamburger">
            <span></span><span></span><span></span>
        </div>
    </nav>

    <div class="page-hero">
        <h1>📞 تواصل مع إدارة المنصة</h1>
        <p>نحن هنا للرد على كافة أسئلتك واقتراحاتك حول المحاضرات</p>
    </div>

    <section class="section section-light">
        <div class="container">
            <div class="contact-form-card">
                <h3>أرسل استفسارك</h3>
                <?php if ($success): ?>
                    <div style="background:#d4edda; color:#155724; padding:12px; border-radius:8px; margin-bottom:16px;">✅ تم إرسال رسالتك بنجاح، سنرد عليك قريباً.</div>
                <?php elseif ($error): ?>
                    <div style="background:#f8d7da; color:#721c24; padding:12px; border-radius:8px; margin-bottom:16px;">❌ <?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label>الاسم الكامل</label>
                        <input type="text" name="name" placeholder="اسمك الكامل" required />
                    </div>
                    <div class="form-group">
                        <label>البريد الإلكتروني</label>
                        <input type="email" name="email" placeholder="example@domain.com" required />
                    </div>
                    <div class="form-group">
                        <label>الرسالة / الاستفسار</label>
                        <textarea name="message" rows="4" placeholder="اكتب استفسارك هنا..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;">📤 إرسال الرسالة</button>
                </form>
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