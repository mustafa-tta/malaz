// القائمة التفاعلية للموبايل (Responsive Navbar)
const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('navLinks');

if (hamburger) {
    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
}

// التبديل بين التبويبات في صفحة تسجيل الدخول/إنشاء حساب
function switchTab(tab) {
    const loginPanel = document.getElementById('loginPanel');
    const registerPanel = document.getElementById('registerPanel');
    const tabs = document.querySelectorAll('.auth-tab');

    if (tab === 'login') {
        loginPanel.style.display = 'block';
        registerPanel.style.display = 'none';
        tabs[0].classList.add('active');
        tabs[1].classList.remove('active');
    } else {
        loginPanel.style.display = 'none';
        registerPanel.style.display = 'block';
        tabs[0].classList.remove('active');
        tabs[1].classList.add('active');
    }
}

// فتح نافذة تفاصيل المحاضرة (Modal)
function openDetail(id) {
    if (typeof lecturesData === 'undefined') return;

    const lecture = lecturesData.find(item => item.id == id);
    if (!lecture) return;

    const modal = document.getElementById('detailModal');
    const title = document.getElementById('detailTitle');
    const content = document.getElementById('detailContent');

    title.innerText = lecture.title;
    content.innerHTML = `
        <p style="margin-bottom: 8px;"><strong>المحاضر:</strong> ${lecture.instructor}</p>
        <p style="margin-bottom: 8px;"><strong>المادة:</strong> ${lecture.subject}</p>
        <p style="margin-bottom: 8px;"><strong>المدة:</strong> ${lecture.duration} دقيقة</p>
        <p style="margin-bottom: 8px;"><strong>المكان:</strong> ${lecture.location}</p>
        <hr style="margin: 12px 0; border: 0; border-top: 1px solid #e2e8f0;">
        <p style="color: #64748b;"><strong>الوصف:</strong> ${lecture.description ? lecture.description : 'لا يوجد وصف إضافي.'}</p>
    `;

    modal.style.display = 'flex';
}

// إغلاق نافذة التفاصيل
function closeModal() {
    const modal = document.getElementById('detailModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// تنبيه للمستخدم غير المصرح له بالتعديل
function showAddLectureMessage() {
    alert('عذراً، يجب تسجيل الدخول بالحساب الإداري لإضافة محاضرات جديدة.');
}

// إغلاق النافذة المنبثقة عند النقر خارجها
window.onclick = function(event) {
    const modal = document.getElementById('detailModal');
    if (event.target === modal) {
        closeModal();
    }
}