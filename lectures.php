<?php
require_once 'config.php';

$stmt = $pdo->query("SELECT * FROM lectures ORDER BY id DESC");
$allLectures = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>المحاضرات - منصة المحاضرات</title>
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
        <h1>🎓 جميع المحاضرات المتاحة</h1>
        <p>تصفح الجدول الدراسي واختر المحاضرات التي تود حضورها</p>
    </div>

    <section class="section section-light">
        <div class="container">
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1): ?>
                <div style="text-align:left; margin-bottom:24px;">
                    <a href="add_lecture.php" class="btn btn-primary">➕ إضافة محاضرة جديدة</a>
                </div>
            <?php else: ?>
                <div style="text-align:left; margin-bottom:24px;">
                    <button class="btn btn-primary" onclick="showAddLectureMessage()">➕ إضافة محاضرة جديدة</button>
                </div>
            <?php endif; ?>

            <div class="cars-grid" id="lecturesGrid">
                <?php foreach ($allLectures as $lecture): ?>
                    <div class="car-card">
                        <div class="car-card-image">
                            <img src="images/<?= htmlspecialchars($lecture['image']) ?>" alt="<?= htmlspecialchars($lecture['title']) ?>"
                                 onerror="this.style.display='none'; this.parentElement.innerHTML='<span style=\\'font-size:4rem;\\'>🎓</span>';" />
                        </div>
                        <div class="car-card-body">
                            <div class="car-name"><?= htmlspecialchars($lecture['title']) ?></div>
                            <div class="car-meta">
                                <span>👨‍🏫 <?= htmlspecialchars($lecture['instructor']) ?></span>
                                <span>📍 <?= htmlspecialchars($lecture['location']) ?></span>
                            </div>
                            <div class="car-price">المادة: <?= htmlspecialchars($lecture['subject']) ?></div>
                            <button class="btn btn-primary" onclick="openDetail(<?= $lecture['id'] ?>)">📋 عرض التفاصيل</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- نافذة التفاصيل (Modal) -->
    <div class="modal-overlay" id="detailModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="detailTitle">تفاصيل المحاضرة</h3>
                <button class="modal-close" onclick="closeModal()">✕</button>
            </div>
            <div id="detailContent"></div>
        </div>
    </div>

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

    <script>
        const lecturesData = <?= json_encode($allLectures, JSON_UNESCAPED_UNICODE) ?>;
    </script>
    <script src="js/script.js"></script>
</body>
</html>