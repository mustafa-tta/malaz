<?php
require_once 'config.php';

$login_error = '';
$register_error = '';
$register_success = '';

if (isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $login_error = 'يرجى تعبئة جميع الحقول.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header('Location: index.php');
            exit;
        } else {
            $login_error = 'البريد الإلكتروني أو كلمة المرور غير صحيحة.';
        }
    }
}

if (isset($_POST['register'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        $register_error = 'جميع الحقول مطلوبة.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $register_error = 'البريد الإلكتروني غير صحيح.';
    } elseif (strlen($password) < 6) {
        $register_error = 'كلمة المرور يجب أن تكون 6 أحرف على الأقل.';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $register_error = 'هذا البريد الإلكتروني مسجل بالفعل.';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hashed]);
            $register_success = 'تم إنشاء الحساب بنجاح، يمكنك الآن تسجيل الدخول.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>دخول - منصة المحاضرات</title>
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
            <a href="contact.php">تواصل معنا</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="nav-cta">تسجيل خروج</a>
            <?php else: ?>
                <a href="login.php" class="nav-cta active">دخول</a>
            <?php endif; ?>
        </div>
        <div class="hamburger" id="hamburger">
            <span></span><span></span><span></span>
        </div>
    </nav>

    <div class="auth-page">
        <div class="auth-card">
            <h2 class="auth-logo">منصة <span>المحاضرات</span></h2>
            <p class="auth-subtitle">سجل دخولك أو أنشئ حساباً جديداً للوصول للمحاضرات</p>

            <div class="auth-tabs">
                <button class="auth-tab active" onclick="switchTab('login')">تسجيل الدخول</button>
                <button class="auth-tab" onclick="switchTab('register')">إنشاء حساب</button>
            </div>

            <div id="loginPanel">
                <?php if ($login_error): ?>
                    <div style="background:#f8d7da; color:#721c24; padding:10px; border-radius:8px; margin-bottom:16px;">❌ <?= htmlspecialchars($login_error) ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label>البريد الإلكتروني</label>
                        <input type="email" name="email" placeholder="example@domain.com" required />
                    </div>
                    <div class="form-group">
                        <label>كلمة المرور</label>
                        <input type="password" name="password" placeholder="••••••••" required />
                    </div>
                    <button type="submit" name="login" class="btn btn-primary" style="width:100%;">دخول</button>
                </form>
            </div>

            <div id="registerPanel" style="display:none;">
                <?php if ($register_error): ?>
                    <div style="background:#f8d7da; color:#721c24; padding:10px; border-radius:8px; margin-bottom:16px;">❌ <?= htmlspecialchars($register_error) ?></div>
                <?php endif; ?>
                <?php if ($register_success): ?>
                    <div style="background:#d4edda; color:#155724; padding:10px; border-radius:8px; margin-bottom:16px;">✅ <?= htmlspecialchars($register_success) ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label>الاسم</label>
                        <input type="text" name="name" placeholder="اسمك الكامل" required />
                    </div>
                    <div class="form-group">
                        <label>البريد الإلكتروني</label>
                        <input type="email" name="email" placeholder="example@domain.com" required />
                    </div>
                    <div class="form-group">
                        <label>كلمة المرور</label>
                        <input type="password" name="password" placeholder="••••••••" required />
                    </div>
                    <button type="submit" name="register" class="btn btn-primary" style="width:100%;">إنشاء حساب</button>
                </form>
            </div>

            <div class="auth-footer">
                © 2026 منصة المحاضرات
            </div>
        </div>
    </div>

    <footer class="footer" style="margin-top:40px;">
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