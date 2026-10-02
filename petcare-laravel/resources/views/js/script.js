/* ==========================================================================
   PETCARE PRO - JAVASCRIPT CORE LOGIC (js/script.js)
   Dùng chung cho: 1.login.html, 2.index.html, 3.dashboard.html
   ========================================================================== */

/* --- 1. LOCALSTORAGE HELPER & TỰ ĐỘNG SAO LƯU DỮ LIỆU --- */
function loadData(key, def) {
    const val = localStorage.getItem(key);
    return val ? JSON.parse(val) : def;
}

function saveData(key, val) {
    localStorage.setItem(key, JSON.stringify(val));
    autoBackupSystem();
}

function autoBackupSystem() {
    const now = new Date();
    const timestamp = now.toLocaleTimeString('vi-VN') + " " + now.toLocaleDateString('vi-VN');
    localStorage.setItem('pc_last_backup_time', timestamp);
    const backupLabel = document.getElementById('adm-last-backup-time');
    if (backupLabel) backupLabel.innerText = "Sao lưu gần nhất: " + timestamp;
}

/* --- 2. DỮ LIỆU CỐT LÕI (STATE & STORAGE) --- */
let userProfile = loadData('pc_current_profile', {
    name: "Nguyễn Văn A",
    dob: "1998-08-15",
    phone: "0901 234 567",
    email: "khachhang@petcare.com",
    address: "Quận 1, TP. Hồ Chí Minh",
    avatar: "https://i.pravatar.cc/100?img=12",
    isVip: true,
    vipTier: "ĐỒNG",
    vipCardColor: "bronze",
    vipCardId: "PC-MEMBER-88992",
    totalSpent: 850000
});

let favoriteIds = loadData('pc_favorites', [1, 3]);

let pets = loadData('pc_pets', [
    { id: 1, name: "Bé Lu", breed: "Corgi", owner: "Nguyễn Văn A", img: "https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=200" }
]);

let appointments = loadData('pc_appts', [
    { id: 'LH1029', pet: 'Bé Lu', service: 'Cắt tỉa tạo kiểu Teddy Bear', time: '14:00 - 20/09/2026', method: 'Chuyển khoản QR', status: 'Đang chờ duyệt' }
]);

// Danh sách sản phẩm Pet Shop
let products = loadData('pc_prods', [
    { id: 1, name: "Hạt Royal Canin Corgi", price: 320000, img: "https://images.unsplash.com/photo-1568640347023-a616a30bc3bd?w=100", stock: 35, sold: 58, unit: "Bao", status: "Mới" },
    { id: 2, name: "Vòng cổ phản quang phát sáng", price: 85000, img: "https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=100", stock: 6, sold: 12, unit: "Cái", status: "Bán chậm" },
    { id: 3, name: "Xịt khử mùi Bio-Clean", price: 110000, img: "https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=100", stock: 22, sold: 45, unit: "Chai", status: "Mới" },
    { id: 4, name: "Thuốc bôi da Bio-Derma", price: 95000, img: "https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=100", stock: 4, sold: 8, unit: "Tuýp", status: "Gần hết date" }
]);

// Danh sách mỹ phẩm & dụng cụ Spa/Grooming
let cosmetics = loadData('pc_cosmetics', [
    { id: 101, name: "Sữa tắm thảo dược hữu cơ Yú", qty: 15, unit: "Chai 500ml", status: "Mới" },
    { id: 102, name: "Bùn khoáng ủ phục hồi lông hư tổn", qty: 8, unit: "Hũ 1kg", status: "Đã xuất" },
    { id: 103, name: "Dung dịch vệ sinh tai Oti-Clean", qty: 3, unit: "Chai 100ml", status: "Hết hàng" }
]);

let orders = loadData('pc_orders', [
    { id: 'DH882', item: 'Hạt Royal Canin Corgi (x1)', method: 'Chuyển khoản QR', total: 320000, date: '12/09/2026', status: 'Đã thanh toán QR' }
]);

let expenseRecords = loadData('pc_expenses', [
    { id: 1, date: "02/09/2026", title: "Khám sức khỏe tổng quát", category: "Y tế", method: "Tiền mặt", amount: 250000, isCurrentMonth: true },
    { id: 2, date: "15/09/2026", title: "Gói Tắm Thảo Dược Cơ Bản", category: "Dịch vụ Spa", method: "Chuyển khoản QR", amount: 150000, isCurrentMonth: true }
]);

let remindersList = loadData('pc_reminders_list', [
    { id: 1, title: "Lịch uống thuốc tẩy giun định kỳ", pet: "Bé Lu (Corgi)", time: "09:00 - Thứ Hai tuần tới", note: "Uống thuốc sau khi ăn no 30 phút, theo dõi phân trong 24h." },
    { id: 2, title: "Tái khám kiểm tra da dị ứng", pet: "Bé Lu (Corgi)", time: "14:30 - 18/09/2026", note: "Bác sĩ Nam hẹn kiểm tra độ hồi phục nang lông sau đợt bôi Bio-Derma." }
]);

let notificationsList = loadData('pc_notifications_list', [
    { id: 1, title: "Đặt hàng thành công đơn #DH882", content: "Đơn hàng Hạt Royal Canin đã được xác nhận thanh toán QR.", time: "Hôm nay 09:15" },
    { id: 2, title: "Lịch hẹn #LH1029 đã được tiếp nhận", content: "Kỹ thuật viên đang chuẩn bị đón bé vào khung giờ đã đặt.", time: "Hôm qua 14:00" }
]);

let promotionsList = loadData('pc_promos', [
    { 
        id: 1, 
        title: "Giảm 20% gói Spa Cắt Tỉa đầu tuần", 
        code: "SPA20", 
        desc: "Áp dụng giảm 20% cho tất cả dịch vụ cắt tỉa tạo kiểu lông tại Spa từ Thứ 2 đến Thứ 4.",
        expiry: "31/12/2026",
        usage: "Nhập mã SPA20 khi đặt lịch trực tuyến hoặc đưa mã cho nhân viên thu ngân khi thanh toán."
    },
    { 
        id: 2, 
        title: "Tặng đồ chơi gặm sạch răng đơn từ 500k", 
        code: "TOYFREE", 
        desc: "Tặng kèm 1 đồ chơi xương gặm sạch răng sinh học cho đơn hàng thức ăn từ 500.000 VNĐ.",
        expiry: "30/11/2026",
        usage: "Áp dụng tự động tại quầy thu ngân Pet Shop khi mua đủ hạn mức giỏ hàng."
    }
]);

// Tin tức bài báo chính thống thú y
let newsList = loadData('pc_news', [
    {
        id: 1,
        tag: "CẢNH BÁO DỊCH BỆNH",
        title: "Cảnh báo bùng phát dịch cúm và viêm phổi trên chó mèo mùa mưa lũ",
        date: "04/09/2026",
        content: "Theo cảnh báo mới nhất từ Chi cục Thú y, thời tiết giao mùa ẩm ướt là điều kiện thuận lợi cho các chủng virus Parvovirus, Care và cúm truyền nhiễm bùng phát mạnh mẽ.\n\nCác triệu chứng ban đầu bao gồm: bé ủ rũ, sốt cao trên 39.5°C, chảy nước mũi dịch nhầy đặc, nôn mửa hoặc bỏ ăn. Bác sĩ khuyến cáo các chủ nuôi tuyệt đối không tự ý cho bé uống thuốc hạ sốt của người (Paracetamol cực độc với mèo). Cần đưa bé đến phòng khám thú y gần nhất để làm test nhanh sinh học trong 24 giờ đầu để nâng cao tỷ lệ sống."
    },
    {
        id: 2,
        tag: "KIẾN THỨC Y TẾ",
        title: "Phác đồ phòng chống ve rận và bệnh ký sinh trùng đường máu",
        date: "01/09/2026",
        content: "Ve rận không chỉ gây ngứa ngáy, viêm da dị ứng mà còn là vật chủ trung gian truyền ký sinh trùng đường máu (Babesia) nguy hiểm gây suy tủy và tử vong.\n\nBiện pháp phòng ngừa chuẩn khoa học:\n1. Nhỏ gáy hoặc cho bé nhai viên chống ve định kỳ đúng cân nặng.\n2. Vệ sinh môi trường sống, xịt khử khuẩn nệm nằm của thú cưng.\n3. Khi phát hiện ve bám nhiều, không dùng tay giật mạnh vì vòi hút của ve đứt lại sẽ gây ổ áp xe mủ dưới da."
    }
]);

let adminConfig = loadData('pc_admin_config', {
    qrImg: "https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=PETCARE_PAYMENT_ADMIN",
    bank: "MB Bank (Ngân hàng Quân Đội)",
    number: "0901 234 567",
    holder: "PHONG KHAM PETCARE PRO"
});

let staffNotes = loadData('pc_staff_notes', [
    { id: 1, time: "09:30 - Hôm nay", pet: "Bé Lu", service: "Tắm & Cắt lông", note: "Bé rất ngoan, lông mềm mượt, da sạch không gàu", staff: "Nhân viên chăm sóc" }
]);

let adminUsers = loadData('pc_users', [
    { id: 1, name: "Nguyễn Văn A", email: "khachhang@petcare.com", role: "Khách hàng", img: "https://i.pravatar.cc/40?img=12", lastAction: "Đặt lịch spa" },
    { id: 2, name: "Trần Thị Tư Vấn", email: "tuvan@petcare.com", role: "Nhân Viên Tư Vấn", img: "https://i.pravatar.cc/40?img=5", lastAction: "Tư vấn gói khám" },
    { id: 3, name: "Lê Văn Chăm Sóc", email: "chamsoc@petcare.com", role: "Nhân Viên Chăm Sóc", img: "https://i.pravatar.cc/40?img=11", lastAction: "Hoàn tất ca tắm" },
    { id: 4, name: "BS. Trần Nam", email: "bacsi@petcare.com", role: "Bác Sĩ Trực Thuộc", img: "https://i.pravatar.cc/40?img=33", lastAction: "Kê đơn viêm da" },
    { id: 5, name: "Phạm Quản Lý", email: "quanly@petcare.com", role: "Quản Lý Cửa Hàng", img: "https://i.pravatar.cc/40?img=60", lastAction: "Kiểm kho định kỳ" },
    { id: 6, name: "Admin Quản Trị", email: "admin@petcare.com", role: "Quản Trị Viên", img: "https://i.pravatar.cc/40?img=68", lastAction: "Cập nhật mã QR" }
]);

let adminItems = loadData('pc_admin_items', [
    { id: 1, name: "Gói Tắm Thảo Dược Cơ Bản", category: "Dịch vụ Spa", price: 150000, salesCount: 142 },
    { id: 2, name: "Cắt Tỉa Tạo Kiểu Teddy Bear", category: "Dịch vụ Spa", price: 300000, salesCount: 215 },
    { id: 3, name: "Khách sạn - Phòng VIP", category: "Khách sạn", price: 400000, salesCount: 68 },
    { id: 4, name: "Hạt Royal Canin Corgi", category: "Sản phẩm", price: 320000, salesCount: 89 }
]);

let reviews = loadData('pc_reviews', [
    { 
        id: 1, 
        author: 'Trần Hương', 
        stars: 5, 
        recommend: 'Cắt tỉa tạo kiểu lông', 
        text: 'Bác sĩ và các bạn kỹ thuật viên rất có tâm! Bé nhà mình làm xong form teddy rất tròn và thơm.',
        img: 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=200',
        date: 'Hôm qua 15:40',
        staffReply: 'PetCare Pro xin cảm ơn chị Hương! Chúc bé cưng luôn mạnh khỏe và đáng yêu ạ.'
    }
]);

let chatMessages = loadData('pc_live_chat_messages', [
    { sender: "bot", text: "Chào bạn! Chuyên viên tư vấn PetCare Pro luôn sẵn sàng hỗ trợ. Bạn cần tư vấn dịch vụ hay kiểm tra sức khỏe gì cho bé ạ?", time: "08:30" }
]);

let adminNotifications = loadData('pc_admin_notifications', [
    { id: 1, time: "Hôm nay 08:30", type: "Hệ thống", message: "Hệ thống kiểm soát chấm công đã kích hoạt sẵn sàng.", status: "Chưa đọc" }
]);

let securityLogs = loadData('pc_security_logs', [
    { id: 1, time: "Hôm nay 08:00:15", user: "Admin", action: "Check-in hệ thống", ip: "192.168.1.1", detail: "Đúng giờ (08:00)" }
]);

let currentCheckout = { type: '', title: '', price: 0, method: 'COD', extra: null };
let currentSelectedVoucher = null;
let currentReviewImgData = "";
let isRecommendWanted = false;

/* --- 3. TOAST, MODAL & CHUYỂN TAB --- */
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-box');
    if (!container) return;
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    const icon = type === 'success' ? 'fa-check-circle' : (type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle');
    toast.innerHTML = `<i class="fas ${icon}" style="color:var(--${type === 'success' ? 'success' : 'primary'});"></i><span>${message}</span>`;
    container.appendChild(toast);
    setTimeout(() => { toast.remove(); }, 3200);
}

function showCenterSuccessPopup(message) {
    const popup = document.getElementById('success-center-popup');
    const desc = document.getElementById('success-center-desc');
    if (popup && desc) {
        desc.innerHTML = message;
        popup.style.display = 'flex';
    }
}

function closeCenterSuccessPopup() {
    const popup = document.getElementById('success-center-popup');
    if (popup) popup.style.display = 'none';
}

function closeModal(id) { 
    const modal = document.getElementById(id);
    if (modal) modal.style.display = 'none'; 
}

function toggleSubmenu(id, parentEl) {
    const submenu = document.getElementById(id);
    if (!submenu) return;
    const arrow = parentEl.querySelector('.arrow-icon');
    submenu.classList.toggle('open');
    if (arrow) arrow.classList.toggle('rotate');
}

function switchTab(id, el) {
    document.querySelectorAll('.view-section').forEach(v => v.classList.remove('active'));
    const target = document.getElementById(id);
    if (target) target.classList.add('active');

    document.querySelectorAll('.nav-item, .submenu-item').forEach(i => i.classList.remove('active'));
    if (el) el.classList.add('active');
}

/* --- 4. PREVIEW HÌNH ẢNH --- */
function previewImage(input, previewId) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const el = document.getElementById(previewId);
            if (el) el.src = e.target.result;
            if (previewId === 'admin-qr-preview') {
                adminConfig.qrImg = e.target.result;
                saveData('pc_admin_config', adminConfig);
            }
        };
        reader.readAsDataURL(file);
    }
}

function previewUserAvatar(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const prev = document.getElementById('user-avatar-preview');
            if (prev) prev.src = e.target.result;
            userProfile.avatar = e.target.result;
            saveData('pc_current_profile', userProfile);
        };
        reader.readAsDataURL(file);
    }
}

function previewReviewImage(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            currentReviewImgData = e.target.result;
            const prev = document.getElementById('review-img-preview');
            const note = document.getElementById('review-img-note');
            if (prev) {
                prev.src = e.target.result;
                prev.style.display = 'block';
            }
            if (note) note.innerText = file.name;
        };
        reader.readAsDataURL(file);
    }
}

/* --- 5. CHẤM CÔNG CHECK-IN / CHECK-OUT (8H - 17H, TRỄ PHẠT 1K/PHÚT) --- */
function processStaffCheckin(role) {
    const now = new Date();
    const hours = now.getHours();
    const minutes = now.getMinutes();

    let lateMinutes = 0;
    let lateFine = 0;

    if (hours > 8 || (hours === 8 && minutes > 0)) {
        lateMinutes = (hours - 8) * 60 + minutes;
        lateFine = lateMinutes * 1000;
    }

    const timeStr = now.toLocaleTimeString('vi-VN');
    localStorage.setItem('pc_checkin_time', timeStr);
    localStorage.setItem('pc_checkin_fine', lateFine);

    const logMsg = lateMinutes > 0 
        ? `Check-in trễ ${lateMinutes} phút (Phạt: ${lateFine.toLocaleString()} VNĐ)` 
        : `Check-in đúng giờ (${timeStr})`;

    logSystemActivity(logMsg, role);
}

function checkoutAdminManual() {
    const nowStr = new Date().toLocaleTimeString('vi-VN');
    logSystemActivity(`Check-out ca làm việc lúc ${nowStr}`, localStorage.getItem('pc_logged_role') || 'Admin');
    showToast(`Đã Check-out ca trực thành công lúc ${nowStr}!`);
    const statusEl = document.getElementById('adm-checkin-status');
    if (statusEl) {
        statusEl.innerText = "ĐÃ CHECK-OUT";
        statusEl.style.color = "var(--accent)";
    }
}

function logSystemActivity(action, user = "Admin") {
    const timeNow = new Date().toLocaleTimeString('vi-VN') + " - " + new Date().toLocaleDateString('vi-VN');
    securityLogs.unshift({
        id: Date.now(),
        time: timeNow,
        user: user,
        action: action,
        ip: "192.168.1." + Math.floor(10 + Math.random() * 80),
        detail: action
    });
    saveData('pc_security_logs', securityLogs);
    renderSecurityLogs();
}

function notifyAdmin(message, type = 'order') {
    const timeNow = new Date().toLocaleTimeString('vi-VN') + " - " + new Date().toLocaleDateString('vi-VN');
    adminNotifications.unshift({
        id: Date.now(),
        time: timeNow,
        type: type === 'order' ? 'Đơn hàng' : (type === 'urgent' ? 'Khẩn cấp' : 'Hệ thống'),
        message: message,
        status: 'Chưa đọc'
    });
    saveData('pc_admin_notifications', adminNotifications);
    renderAdminInbox();
}

function renderSecurityLogs() {
    const tbody = document.getElementById('adm-security-logs-tbody');
    if (tbody) {
        tbody.innerHTML = securityLogs.map(s => `
            <tr>
                <td><strong>${s.time}</strong></td>
                <td>${s.user}</td>
                <td><span class="badge badge-info">${s.action}</span></td>
                <td><code>${s.ip}</code></td>
                <td>${s.detail}</td>
            </tr>
        `).join('');
    }
}

function renderAdminInbox() {
    const tbody = document.getElementById('adm-inbox-table-tbody');
    const badge = document.getElementById('adm-inbox-badge');
    if (!tbody) return;

    const unreadCount = adminNotifications.filter(n => n.status === 'Chưa đọc').length;
    if (badge) badge.innerText = unreadCount;

    tbody.innerHTML = adminNotifications.map(n => `
        <tr>
            <td>${n.time}</td>
            <td><span class="badge ${n.type==='Khẩn cấp'?'badge-danger':(n.type==='Đơn hàng'?'badge-success':'badge-info')}">${n.type}</span></td>
            <td><strong>${n.message}</strong></td>
            <td><span class="badge ${n.status==='Chưa đọc'?'badge-pending':'badge-success'}">${n.status}</span></td>
            <td>
                ${n.status==='Chưa đọc' ? `<button class="btn-action" style="background:#e8f0fe; color:var(--primary);" onclick="markNotificationAsRead(${n.id})"><i class="fas fa-check"></i> Đã đọc</button>` : '<small style="color:#888;">Đã xem</small>'}
            </td>
        </tr>
    `).join('');
}

function markNotificationAsRead(id) {
    const noti = adminNotifications.find(n => n.id === id);
    if (noti) {
        noti.status = "Đã đọc";
        saveData('pc_admin_notifications', adminNotifications);
        renderAdminInbox();
    }
}

function markAllNotificationsAsRead() {
    adminNotifications.forEach(n => n.status = "Đã đọc");
    saveData('pc_admin_notifications', adminNotifications);
    renderAdminInbox();
    showToast("Đã đánh dấu tất cả hộp thư là đã đọc!");
}

/* --- 6. PHÂN QUYỀN GIAO DIỆN & TÊN NHÂN VIÊN --- */
function setupRoleDisplay(role) {
    document.querySelectorAll('[data-role]').forEach(el => {
        el.style.display = (el.getAttribute('data-role') === role) ? 'block' : 'none';
    });

    const greetingNameEl = document.getElementById('sidebar-greeting-name');
    const roleBadgeEl = document.getElementById('sidebar-user-role-badge');
    const avatarEl = document.getElementById('sidebar-user-avatar');

    const roleTitles = {
        advisor: "Nhân viên tư vấn",
        staff: "Nhân viên chăm sóc",
        doctor: "Bác sĩ thú y trực thuộc",
        manager: "Quản lý cửa hàng",
        admin: "Quản trị viên (Admin)"
    };

    if (greetingNameEl) greetingNameEl.innerText = roleTitles[role] || "Cán bộ chuyên môn";
    if (roleBadgeEl) roleBadgeEl.innerText = "Bộ Phận Chuyên Trách";

    const avatars = {
        advisor: "https://i.pravatar.cc/100?img=5",
        staff: "https://i.pravatar.cc/100?img=11",
        doctor: "https://i.pravatar.cc/100?img=33",
        manager: "https://i.pravatar.cc/100?img=60",
        admin: "https://i.pravatar.cc/100?img=68"
    };
    if (avatarEl) avatarEl.src = avatars[role] || "https://i.pravatar.cc/100?img=11";

    const chatDock = document.getElementById('advisor-live-chat-panel');
    if (chatDock) chatDock.style.display = (role === 'advisor') ? 'flex' : 'none';

    const checkinTimeEl = document.getElementById('adm-checkin-time-display');
    const lateFineEl = document.getElementById('adm-late-fine-display');
    const savedCheckin = localStorage.getItem('pc_checkin_time');
    const savedFine = parseInt(localStorage.getItem('pc_checkin_fine') || 0);

    if (checkinTimeEl && savedCheckin) checkinTimeEl.innerText = "Giờ vào: " + savedCheckin;
    if (lateFineEl) {
        lateFineEl.innerText = savedFine > 0 ? `Đi trễ: Phạt ${savedFine.toLocaleString()} VNĐ` : "Đúng giờ (Không phạt)";
        lateFineEl.style.color = savedFine > 0 ? "var(--accent)" : "var(--success)";
    }
}

function updateGreetingDisplay(role) {
    const greetingNameEl = document.getElementById('sidebar-greeting-name');
    const bannerGreeting = document.getElementById('cust-greeting-banner');
    const avatarEl = document.getElementById('sidebar-user-avatar');

    if (role === 'customer') {
        if (greetingNameEl) greetingNameEl.innerText = `Xin chào, ${userProfile.name}!`;
        if (bannerGreeting) bannerGreeting.innerText = `Xin chào, ${userProfile.name}!`;
        if (avatarEl) avatarEl.src = userProfile.avatar || 'https://i.pravatar.cc/100?img=12';
    }
}

/* --- 7. SLIDER DEMO 4 HẠNG THẺ TỰ ĐỘNG LƯỚT --- */
function startAutoCardSlider() {
    const track = document.getElementById('cards-track');
    if (!track) return;

    let currentIndex = 0;
    const totalCards = 4;
    const cardWidth = 290;

    setInterval(() => {
        currentIndex = (currentIndex + 1) % totalCards;
        track.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
    }, 3500);
}

function checkVipMemberStatus() {
    const cardWrap = document.getElementById('member-registered-info');
    const nameEl = document.getElementById('vip-card-name');
    const idEl = document.getElementById('vip-card-id');
    const tierEl = document.getElementById('vip-card-tier');
    const dobEl = document.getElementById('vip-card-dob');
    const avatarEl = document.getElementById('vip-card-avatar');
    const spendingEl = document.getElementById('vip-card-spending');
    const cardBox = document.getElementById('active-vip-card-box');

    if (userProfile.isVip && cardWrap) {
        cardWrap.style.display = 'block';

        const currentSpent = orders.reduce((sum, o) => sum + (o.total || 0), 0) + (userProfile.totalSpent || 0);
        let tier = "ĐỒNG";
        let color = "bronze";

        if (currentSpent >= 10000000) {
            tier = "ĐEN VÀNG"; color = "blackgold";
        } else if (currentSpent >= 5000000) {
            tier = "VÀNG"; color = "gold";
        } else if (currentSpent >= 2000000) {
            tier = "BẠC"; color = "silver";
        }

        userProfile.vipTier = tier;
        userProfile.vipCardColor = color;

        if (nameEl) nameEl.innerText = userProfile.name.toUpperCase();
        if (idEl) idEl.innerText = userProfile.vipCardId || "PC-MEMBER-88992";
        if (tierEl) tierEl.innerText = tier;
        if (dobEl) dobEl.innerText = "Sinh nhật: " + (userProfile.dob ? userProfile.dob.split('-').reverse().join('/') : "15/08/1998");
        if (avatarEl) avatarEl.src = userProfile.avatar || "https://i.pravatar.cc/100?img=12";
        if (spendingEl) spendingEl.innerText = "Tích lũy: " + currentSpent.toLocaleString() + " đ";

        if (cardBox) cardBox.className = "vip-card-preview card-" + color;
    }
}

/* --- 8. DANH MỤC ĐẶT LỊCH CỤ THỂ CHI TIẾT --- */
const bookingOptionsData = {
    kham: [
        "Khám sức khỏe tổng quát định kỳ",
        "Khám chuyên khoa Da liễu & Rụng lông",
        "Khám Tiêu hóa & Nội soi",
        "Khám Xương khớp & Phục hồi chức năng",
        "Tiêm phòng vắc xin 7 bệnh & ngừa dại",
        "Lấy máu xét nghiệm sinh hóa tự động"
    ],
    grooming: [
        "Grooming Vệ Sinh Toàn Diện (Cắt mài móng, nhổ lông tai)",
        "Cắt tỉa tạo kiểu Teddy Bear mặt tròn",
        "Cắt tỉa tạo kiểu Mông Quả Đào Trái Tim Corgi",
        "Cạo gọn thân mùa hè & tạo bờm cổ sư tử",
        "Nhuộm tai và đuôi thảo dược an toàn"
    ],
    hotel: [
        "Khách sạn thú cưng - Phòng Cơ Bản (Ăn ngày 2 bữa)",
        "Khách sạn thú cưng - Phòng Tiện Nghi (Máy lạnh ion âm, đồ chơi)",
        "Khách sạn thú cưng - Phòng VIP (Camera riêng 24/7, menu thịt bò tươi)"
    ]
};

function updateBookingDetailOptions() {
    const catSelect = document.getElementById('book-category');
    const specificSelect = document.getElementById('book-specific-service');
    if (!catSelect || !specificSelect) return;

    const cat = catSelect.value;
    const list = bookingOptionsData[cat] || [];
    specificSelect.innerHTML = list.map(item => `<option value="${item}">${item}</option>`).join('');
}

function openBookingFromService(serviceName, price) {
    const catSelect = document.getElementById('book-category');
    if (catSelect) {
        if (serviceName.includes("Tắm") || serviceName.includes("Spa")) catSelect.value = "grooming";
        else if (serviceName.includes("Cắt") || serviceName.includes("Grooming")) catSelect.value = "grooming";
        else if (serviceName.includes("Khách sạn")) catSelect.value = "hotel";
        else catSelect.value = "kham";

        updateBookingDetailOptions();
        const specificSelect = document.getElementById('book-specific-service');
        if (specificSelect) specificSelect.value = serviceName;
    }

    switchTab('cust-booking', document.querySelector('#sub-appointments .submenu-item'));
    showToast(`Đã chọn: ${serviceName}. Mời bạn chọn ngày giờ hẹn!`, 'info');
}

function submitBooking() {
    const specificSelect = document.getElementById('book-specific-service');
    const petSelect = document.getElementById('book-pet');
    const timeInput = document.getElementById('book-time');
    const noteInput = document.getElementById('book-note');

    const service = specificSelect ? specificSelect.value : "Khám tổng quát";
    const pet = petSelect ? petSelect.value : "Bé Lu";
    const time = timeInput ? timeInput.value : "";
    const note = noteInput ? noteInput.value : "";

    if (!time) return showToast("Vui lòng chọn ngày và giờ hẹn!", "warning");

    openPaymentModal({
        type: 'SPA',
        title: service,
        price: 250000,
        extra: { pet, time: time.replace('T', ' '), note }
    });
}

/* --- 9. BÀI BÁO TIN TỨC & CHI TIẾT NHẮC NHỞ --- */
function renderNewsArticles() {
    const newsBox = document.getElementById('news-list-customer');
    if (!newsBox) return;

    newsBox.innerHTML = newsList.map(n => `
        <div class="news-item-card ppt-fade-up" onclick="openNewsArticleModal(${n.id})">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <span class="badge badge-danger"><i class="fas fa-shield-virus"></i> ${n.tag}</span>
                <small style="color:#888;"><i class="fas fa-clock"></i> ${n.date}</small>
            </div>
            <h3 style="margin:10px 0 6px; font-size:17px; color:#2d3436;">${n.title}</h3>
            <p style="color:#666; font-size:13px; line-height:1.6; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                ${n.content}
            </p>
            <span style="color:var(--primary); font-size:12.5px; font-weight:700; margin-top:8px; display:inline-block;">
                Đọc toàn bộ bài báo <i class="fas fa-arrow-right"></i>
            </span>
        </div>
    `).join('');
}

function openNewsArticleModal(id) {
    const news = newsList.find(n => n.id === id);
    if (!news) return;

    document.getElementById('news-modal-tag').innerText = news.tag;
    document.getElementById('news-modal-title').innerText = news.title;
    document.getElementById('news-modal-date').innerText = news.date;
    document.getElementById('news-modal-body').innerText = news.content;

    document.getElementById('news-article-modal').style.display = 'flex';
}

function renderReminders() {
    const box = document.getElementById('reminders-container-box');
    if (!box) return;

    box.innerHTML = remindersList.map(r => `
        <div class="table-container" style="border-left:4px solid var(--warning); margin-bottom:12px; cursor:pointer; padding:15px;" onclick="openReminderDetailModal(${r.id})">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <strong style="color:#2d3436;"><i class="fas fa-bell" style="color:var(--warning);"></i> ${r.title}</strong>
                <span class="badge badge-pending">Nhấp xem chi tiết</span>
            </div>
            <p style="color:#777; font-size:13px; margin-top:5px;">Dành cho: <strong>${r.pet}</strong> | Thời gian: ${r.time}</p>
        </div>
    `).join('');
}

function openReminderDetailModal(id) {
    const rem = remindersList.find(r => r.id === id);
    if (!rem) return;

    document.getElementById('rem-modal-title').innerText = rem.title;
    document.getElementById('rem-modal-pet').innerText = rem.pet;
    document.getElementById('rem-modal-time').innerText = rem.time;
    document.getElementById('rem-modal-note').innerText = rem.note || "Bác sĩ căn dặn đưa bé đến đúng giờ.";

    document.getElementById('reminder-detail-modal').style.display = 'flex';
}

function renderNotifications() {
    const box = document.getElementById('notifications-container-box');
    if (!box) return;

    box.innerHTML = notificationsList.map(n => `
        <div class="table-container" style="border-left:4px solid var(--primary); margin-bottom:12px; padding:14px;">
            <div style="display:flex; justify-content:space-between;">
                <strong>${n.title}</strong>
                <small style="color:#999;">${n.time}</small>
            </div>
            <p style="color:#555; font-size:13px; margin-top:5px;">${n.content}</p>
        </div>
    `).join('');
}

/* --- 10. VOUCHER & BANNER KHUYẾN MÃI NỔI --- */
function renderVouchers() {
    const box = document.getElementById('promos-list-customer');
    if (!box) return;

    box.innerHTML = promotionsList.map(p => `
        <div class="voucher-interactive-card ppt-zoom-in" onclick="openVoucherModal(${p.id})">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                <span class="badge badge-pending">MÃ: ${p.code}</span>
                <small style="color:var(--accent); font-weight:700;"><i class="fas fa-clock"></i> HSD: ${p.expiry}</small>
            </div>
            <h3 style="font-size:16px; color:var(--primary); margin:6px 0;">${p.title}</h3>
            <p style="font-size:12.5px; color:#666; line-height:1.5;">${p.desc}</p>
            <div style="text-align:right; margin-top:10px;">
                <span style="font-size:12px; color:var(--primary); font-weight:700;">Xem chi tiết & Lấy mã <i class="fas fa-arrow-right"></i></span>
            </div>
        </div>
    `).join('');
}

function openVoucherModal(id) {
    const v = promotionsList.find(p => p.id === id);
    if (!v) return;
    currentSelectedVoucher = v;

    document.getElementById('v-modal-code').innerText = "MÃ: " + v.code;
    document.getElementById('v-modal-title').innerText = v.title;
    document.getElementById('v-modal-expiry').innerText = v.expiry;
    document.getElementById('v-modal-desc').innerText = v.desc;
    document.getElementById('v-modal-usage').innerText = v.usage;

    document.getElementById('voucher-detail-modal').style.display = 'flex';
}

function claimCurrentVoucher() {
    if (!currentSelectedVoucher) return;
    closeModal('voucher-detail-modal');

    if (navigator.clipboard) {
        navigator.clipboard.writeText(currentSelectedVoucher.code).catch(() => {});
    }

    showToast(`Đã lấy mã [${currentSelectedVoucher.code}] thành công! Mã đã được sao chép.`);
}

function checkPendingPromosForCustomer() {
    const banner = document.getElementById('promo-floating-banner');
    if (!banner) return;

    if (promotionsList.length > 0) {
        const promo = promotionsList[0];
        document.getElementById('square-promo-title').innerText = promo.title;
        document.getElementById('square-promo-desc').innerText = `Mã: ${promo.code} - ${promo.desc}`;
        banner.style.display = 'block';
    }
}

function closeSquarePromo() {
    const banner = document.getElementById('promo-floating-banner');
    if (banner) banner.style.display = 'none';
}

function viewPromoFromBanner() {
    closeSquarePromo();
    switchTab('cust-promos', document.querySelector('#sub-promotions .submenu-item'));
}

/* --- 11. KHUNG CHAT MINI TIẾP NHẬN TƯ VẤN TRỰC TIẾP --- */
function toggleMiniChat() {
    const box = document.getElementById('mini-chat-box');
    if (box) {
        box.style.display = (box.style.display === 'none' || !box.style.display) ? 'flex' : 'none';
    }
}

function sendClientChatMessage() {
    const input = document.getElementById('mini-chat-input');
    const text = input ? input.value.trim() : "";
    if (!text) return;

    const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    chatMessages.push({ sender: "user", text, time });
    saveData('pc_live_chat_messages', chatMessages);
    input.value = "";
    renderChatMessages();

    notifyAdmin(`Khách "${userProfile.name}" vừa nhắn tin cần tư vấn: "${text}"`, 'urgent');

    setTimeout(() => {
        chatMessages.push({
            sender: "bot",
            text: "Cảm ơn bạn! Tư vấn viên đang tiếp nhận câu hỏi và sẽ giải đáp chi tiết cho bạn ngay.",
            time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
        });
        saveData('pc_live_chat_messages', chatMessages);
        renderChatMessages();
    }, 1200);
}

function sendAdvisorChatMessage() {
    const input = document.getElementById('advisor-reply-input');
    const text = input ? input.value.trim() : "";
    if (!text) return;

    const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    chatMessages.push({ sender: "advisor", text: `[Tư vấn viên]: ${text}`, time });
    saveData('pc_live_chat_messages', chatMessages);
    input.value = "";
    renderChatMessages();
    showToast("Đã gửi tin nhắn tư vấn tới khách hàng!");
}

function renderChatMessages() {
    const clientBox = document.getElementById('mini-chat-messages');
    const advisorBox = document.getElementById('advisor-chat-stream');

    const html = chatMessages.map(m => `
        <div class="chat-msg ${m.sender === 'user' ? 'user-msg' : 'bot-msg'}">
            <p>${m.text}</p>
            <small>${m.time}</small>
        </div>
    `).join('');

    if (clientBox) {
        clientBox.innerHTML = html;
        clientBox.scrollTop = clientBox.scrollHeight;
    }
    if (advisorBox) {
        advisorBox.innerHTML = html;
        advisorBox.scrollTop = advisorBox.scrollHeight;
    }
}

function openMiniChatFromAdvisor(clientName) {
    showToast(`Đang kết nối tới khung chat của khách hàng: ${clientName}`);
    const dock = document.getElementById('advisor-live-chat-panel');
    if (dock) dock.style.display = 'flex';
}

/* --- 12. ĐÁNH GIÁ (CÓ NÚT HỎI RECOMMEND ĐỒNG Ý / KHÔNG) --- */
function setRecommendOption(agree) {
    isRecommendWanted = agree;
    const btnYes = document.getElementById('btn-rec-yes');
    const btnNo = document.getElementById('btn-rec-no');
    const selBox = document.getElementById('rec-selection-box');

    if (agree) {
        if (btnYes) { btnYes.style.background = "var(--primary)"; btnYes.style.color = "white"; }
        if (btnNo) { btnNo.style.background = "#f1f2f6"; btnNo.style.color = "#777"; }
        if (selBox) selBox.style.display = "block";
    } else {
        if (btnNo) { btnNo.style.background = "var(--accent)"; btnNo.style.color = "white"; }
        if (btnYes) { btnYes.style.background = "#f1f2f6"; btnYes.style.color = "#777"; }
        if (selBox) selBox.style.display = "none";
    }
}

function submitReview() {
    const textEl = document.getElementById('review-text');
    const starsEl = document.getElementById('review-stars');
    const recSelect = document.getElementById('review-recommend-select');

    const text = textEl ? textEl.value.trim() : "";
    const stars = starsEl ? parseInt(starsEl.value) : 5;
    const recommend = (isRecommendWanted && recSelect) ? recSelect.value : "";

    if (!text) return showToast("Vui lòng nhập cảm nhận đánh giá của bạn!", "warning");

    reviews.unshift({
        id: Date.now(),
        author: userProfile.name,
        stars,
        recommend,
        text,
        img: currentReviewImgData,
        date: "Vừa xong",
        staffReply: ""
    });

    saveData('pc_reviews', reviews);
    notifyAdmin(`Có đánh giá mới (${stars} sao) từ khách "${userProfile.name}"`, 'urgent');

    const careBadge = document.getElementById('care-review-badge');
    if (careBadge) careBadge.innerText = parseInt(careBadge.innerText || 0) + 1;

    renderReviews();
    renderStaffReviewsWithReply();

    if (textEl) textEl.value = "";
    setRecommendOption(false);
    const prev = document.getElementById('review-img-preview');
    const note = document.getElementById('review-img-note');
    if (prev) { prev.style.display = "none"; prev.src = ""; }
    if (note) note.innerText = "Chưa chọn ảnh";
    currentReviewImgData = "";

    showToast("Cảm ơn bạn đã gửi đánh giá dịch vụ!");
}

function renderReviews() {
    const box = document.getElementById('reviews-stream');
    if (!box) return;

    box.innerHTML = reviews.map(r => `
        <div class="table-container" style="border-left: 5px solid var(--primary); margin-bottom:15px; padding:18px;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <strong>${r.author}</strong>
                    <span style="margin-left:8px;">${'⭐'.repeat(r.stars)}</span>
                    ${r.recommend ? `<div style="margin:4px 0;"><span class="badge badge-info"><i class="fas fa-thumbs-up"></i> Gợi ý: ${r.recommend}</span></div>` : ''}
                </div>
                <small style="color:#888;">${r.date}</small>
            </div>
            <p style="color:#444; font-size:14px; margin: 10px 0;">${r.text}</p>
            ${r.img ? `<img src="${r.img}" style="width:100px; height:100px; object-fit:cover; border-radius:10px; margin-bottom:8px;">` : ''}
            ${r.staffReply ? `
                <div class="staff-reply-box">
                    <small style="color:var(--primary); font-weight:bold;"><i class="fas fa-reply"></i> Phản hồi từ Kỹ thuật viên PetCare:</small>
                    <p style="color:#333; font-size:13.5px; margin-top:3px;">${r.staffReply}</p>
                </div>
            ` : ''}
        </div>
    `).join('');
}

function renderStaffReviewsWithReply() {
    const container = document.getElementById('staff-reviews-reply-container');
    if (!container) return;

    container.innerHTML = reviews.map(r => `
        <div class="table-container" style="border-left: 5px solid var(--warning);">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <strong>${r.author}</strong>
                    <span style="margin-left:8px;">${'⭐'.repeat(r.stars)}</span>
                    ${r.recommend ? `<p style="color:#777; font-size:12px; margin-top:3px;"><i class="fas fa-thumbs-up"></i> Khách gợi ý: ${r.recommend}</p>` : ''}
                </div>
                <small style="color:#888;">${r.date}</small>
            </div>
            <p style="color:#444; font-size:14px; margin: 10px 0;">${r.text}</p>
            ${r.img ? `<img src="${r.img}" style="width:90px; height:90px; object-fit:cover; border-radius:10px; margin-bottom:10px;">` : ''}

            <div class="staff-reply-box">
                <small style="color:var(--primary); font-weight:bold;"><i class="fas fa-user-md"></i> Phản hồi hiện tại:</small>
                <p style="color:#333; font-size:13.5px; margin-top:4px;" id="reply-text-${r.id}">${r.staffReply || '<em>Chưa có phản hồi từ nhân viên.</em>'}</p>
            </div>

            <div style="display:flex; gap:10px; margin-top:12px;">
                <input type="text" id="input-reply-${r.id}" placeholder="Viết phản hồi cảm ơn hoặc giải đáp cho khách..." style="flex:1; padding:8px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px;">
                <button class="btn-action btn-save" style="width:auto; margin:0; padding:8px 15px;" onclick="submitStaffReply(${r.id})"><i class="fas fa-reply"></i> Gửi phản hồi</button>
            </div>
        </div>
    `).join('');
}

function submitStaffReply(reviewId) {
    const input = document.getElementById(`input-reply-${reviewId}`);
    if (!input || !input.value.trim()) return showToast("Vui lòng nhập nội dung phản hồi!", "warning");

    const rev = reviews.find(r => r.id === reviewId);
    if (rev) {
        rev.staffReply = input.value.trim();
        saveData('pc_reviews', reviews);
        showToast("Đã gửi phản hồi đánh giá tới khách hàng!");
        renderStaffReviewsWithReply();
        renderReviews();
    }
}

/* --- 13. KHO QUẢN TRỊ NÂNG CAO (SẢN PHẨM, MỸ PHẨM, HÀNG TỒN RIÊNG) --- */
function renderAdminInventoryAdvanced() {
    const prodTbody = document.getElementById('adm-stock-products-tbody');
    if (prodTbody) {
        prodTbody.innerHTML = products.map(p => `
            <tr>
                <td><strong>#SP${p.id}</strong></td>
                <td>${p.name}</td>
                <td style="font-weight:bold; color:${p.stock < 10 ? 'var(--accent)' : 'inherit'}">${p.stock}</td>
                <td>${p.unit}</td>
                <td>
                    <label style="margin-right:8px;"><input type="radio" name="st-p-${p.id}" ${p.status==='Mới'?'checked':''} onchange="updateItemStockTag('prod', ${p.id}, 'Mới')"> Mới</label>
                    <label style="margin-right:8px;"><input type="radio" name="st-p-${p.id}" ${p.status==='Đã xuất'?'checked':''} onchange="updateItemStockTag('prod', ${p.id}, 'Đã xuất')"> Đã xuất</label>
                    <label><input type="radio" name="st-p-${p.id}" ${p.stock<5?'checked':''} onchange="updateItemStockTag('prod', ${p.id}, 'Hết hàng')"> Hết hàng</label>
                </td>
                <td><button class="btn-action" style="background:#e8f0fe; color:var(--primary);" onclick="editAdminItem(${p.id})">Chỉnh sửa</button></td>
            </tr>
        `).join('');
    }

    const cosTbody = document.getElementById('adm-stock-cosmetics-tbody');
    if (cosTbody) {
        cosTbody.innerHTML = cosmetics.map(c => `
            <tr>
                <td><strong>#MP${c.id}</strong></td>
                <td>${c.name}</td>
                <td style="font-weight:bold; color:${c.qty < 5 ? 'var(--accent)' : 'inherit'}">${c.qty}</td>
                <td>${c.unit}</td>
                <td>
                    <label style="margin-right:8px;"><input type="radio" name="st-c-${c.id}" ${c.status==='Mới'?'checked':''} onchange="updateItemStockTag('cos', ${c.id}, 'Mới')"> Mới</label>
                    <label style="margin-right:8px;"><input type="radio" name="st-c-${c.id}" ${c.status==='Đã xuất'?'checked':''} onchange="updateItemStockTag('cos', ${c.id}, 'Đã xuất')"> Đã xuất</label>
                    <label><input type="radio" name="st-c-${c.id}" ${c.status==='Hết hàng'?'checked':''} onchange="updateItemStockTag('cos', ${c.id}, 'Hết hàng')"> Hết hàng</label>
                </td>
                <td><button class="btn-action" style="background:#e8f0fe; color:var(--primary);" onclick="editAdminItem(${c.id})">Chỉnh sửa</button></td>
            </tr>
        `).join('');
    }

    const deadTbody = document.getElementById('adm-dead-stock-tbody');
    if (deadTbody) {
        const deadItems = products.filter(p => p.stock < 10 || p.sold < 15);
        deadTbody.innerHTML = deadItems.map(d => `
            <tr>
                <td><strong>${d.name}</strong></td>
                <td>${d.stock} ${d.unit}</td>
                <td><span class="badge ${d.stock<5?'badge-danger':'badge-pending'}">${d.status || 'Bán chậm'}</span></td>
                <td>${d.stock<5 ? 'Tạo đề xuất nhập bổ sung kho' : 'Tạo voucher giảm giá xả tồn'}</td>
                <td><button class="btn-action" style="background:#ffebeb; color:var(--accent);" onclick="handleDeadStock(${d.id})">Xử lý tồn</button></td>
            </tr>
        `).join('');
    }

    const now = new Date();
    const currentMonth = now.getMonth() + 1;
    const currentYear = now.getFullYear();

    const monthLabelEl = document.getElementById('adm-current-month-label');
    if (monthLabelEl) monthLabelEl.innerText = `Doanh thu tháng ${currentMonth}/${currentYear} (Thời gian thực)`;

    const realtimeTotal = orders.reduce((sum, o) => sum + (o.total || 0), 0) + 12500000;
    const shopRev = orders.reduce((sum, o) => sum + (o.total || 0), 0);

    const revEl = document.getElementById('disp-adm-realtime-rev');
    const shopRevEl = document.getElementById('disp-adm-shop-rev');

    if (revEl) revEl.innerText = realtimeTotal.toLocaleString() + " VNĐ";
    if (shopRevEl) shopRevEl.innerText = shopRev.toLocaleString() + " VNĐ";

    const statsTbody = document.getElementById('adm-monthly-stats-tbody');
    if (statsTbody) {
        statsTbody.innerHTML = `
            <tr>
                <td><strong>Tháng ${currentMonth}/${currentYear} (Thời gian thực)</strong></td>
                <td><span class="badge badge-success">${appointments.length + 42} lượt khách</span></td>
                <td>${orders.length} đơn hàng</td>
                <td>12.500.000 VNĐ</td>
                <td style="color:var(--primary); font-weight:bold;">${realtimeTotal.toLocaleString()} VNĐ</td>
            </tr>
            <tr>
                <td>Tháng ${currentMonth - 1 > 0 ? currentMonth - 1 : 12}/${currentMonth - 1 > 0 ? currentYear : currentYear - 1}</td>
                <td><span class="badge badge-info">118 lượt khách</span></td>
                <td>56 đơn hàng</td>
                <td>28.400.000 VNĐ</td>
                <td style="color:var(--primary); font-weight:bold;">42.800.000 VNĐ</td>
            </tr>
        `;
    }
}

function updateItemStockTag(type, id, tag) {
    if (type === 'prod') {
        const p = products.find(i => i.id === id);
        if (p) p.status = tag;
        saveData('pc_prods', products);
    } else {
        const c = cosmetics.find(i => i.id === id);
        if (c) c.status = tag;
        saveData('pc_cosmetics', cosmetics);
    }
    showToast(`Đã tick cập nhật trạng thái kho: [${tag}]`);
}

function handleDeadStock(id) {
    showToast(`Đã chuyển mặt hàng sang danh sách ưu tiên giải phóng tồn kho!`);
}

/* --- 14. ADMIN: PHÊ DUYỆT TÀI KHOẢN & KHUYẾN MÃI / TIN TỨC --- */
function approveStaffAccount(name) {
    showToast(`Đã phê duyệt và kích hoạt tài khoản cán bộ: ${name}!`);
    const row = document.getElementById('adm-pending-users-tbody');
    if (row) row.innerHTML = '<tr><td colspan="5" style="text-align:center; color:#888;">Không còn yêu cầu phê duyệt mới.</td></tr>';
    notifyAdmin(`Quản trị viên đã phê duyệt tài khoản mới: ${name}`, 'system');
}

function rejectStaffAccount(btn) {
    if (confirm("Từ chối phê duyệt tài khoản này?")) {
        btn.closest('tr').remove();
        showToast("Đã từ chối tài khoản đề xuất!", "info");
    }
}

function addAdminPromo() {
    const title = document.getElementById('adm-promo-title').value.trim();
    const code = document.getElementById('adm-promo-code').value.trim();
    const desc = document.getElementById('adm-promo-desc').value.trim();

    if (!title || !code) return showToast("Vui lòng nhập đủ tên và mã ưu đãi!", "warning");

    promotionsList.unshift({
        id: Date.now(),
        title,
        code,
        desc: desc || "Ưu đãi độc quyền tại PetCare.",
        expiry: "31/12/2026",
        usage: `Nhập mã ${code} khi thanh toán để được giảm giá.`
    });
    saveData('pc_promos', promotionsList);

    const promoBadge = document.getElementById('care-promo-badge');
    if (promoBadge) promoBadge.innerText = parseInt(promoBadge.innerText || 0) + 1;

    notifyAdmin(`Admin vừa phát hành khuyến mãi mới: ${code} - ${title}`, 'system');
    showToast("Đã phát hành khuyến mãi toàn hệ thống thành công!");

    document.getElementById('adm-promo-title').value = "";
    document.getElementById('adm-promo-code').value = "";
    document.getElementById('adm-promo-desc').value = "";

    renderVouchers();
    renderAdminActivePromos();
}

function renderAdminActivePromos() {
    const tbody = document.getElementById('adm-active-promos-tbody');
    if (!tbody) return;

    tbody.innerHTML = promotionsList.map(p => `
        <tr>
            <td><span class="badge badge-pending">${p.code}</span></td>
            <td><strong>${p.title}</strong></td>
            <td>${p.desc}</td>
            <td><span class="badge badge-success">Đang chạy</span></td>
            <td><button class="btn-action" style="background:#ffebeb; color:var(--accent);" onclick="deletePromo(${p.id})">Hủy</button></td>
        </tr>
    `).join('');
}

function deletePromo(id) {
    if (confirm("Hủy chương trình khuyến mãi này?")) {
        promotionsList = promotionsList.filter(p => p.id !== id);
        saveData('pc_promos', promotionsList);
        renderVouchers();
        renderAdminActivePromos();
        showToast("Đã hủy khuyến mãi!");
    }
}

function addAdminNews() {
    const title = document.getElementById('adm-news-title').value.trim();
    const tag = document.getElementById('adm-news-tag').value;
    const content = document.getElementById('adm-news-content').value.trim();

    if (!title || !content) return showToast("Vui lòng nhập tiêu đề và nội dung bài báo!", "warning");

    const dateStr = new Date().toLocaleDateString('vi-VN');
    newsList.unshift({ id: Date.now(), tag, title, content, date: dateStr });
    saveData('pc_news', newsList);

    notifyAdmin(`Admin vừa đăng bài báo thú y: "${title}"`, 'urgent');
    showToast("Đã đăng bài báo chính thống thành công!");

    document.getElementById('adm-news-title').value = "";
    document.getElementById('adm-news-content').value = "";

    renderNewsArticles();
    renderAdminPublishedNews();
}

function renderAdminPublishedNews() {
    const tbody = document.getElementById('adm-published-news-tbody');
    if (!tbody) return;

    tbody.innerHTML = newsList.map(n => `
        <tr>
            <td>${n.date}</td>
            <td><span class="badge badge-danger">${n.tag}</span></td>
            <td><strong>${n.title}</strong></td>
            <td><button class="btn-action" style="background:#ffebeb; color:var(--accent);" onclick="deleteNews(${n.id})">Xóa</button></td>
        </tr>
    `).join('');
}

function deleteNews(id) {
    if (confirm("Xóa bài báo này?")) {
        newsList = newsList.filter(n => n.id !== id);
        saveData('pc_news', newsList);
        renderNewsArticles();
        renderAdminPublishedNews();
        showToast("Đã xóa bài báo!");
    }
}

/* --- 15. THANH TOÁN & ĐƠN HÀNG --- */
function buyProduct(id) {
    const prod = products.find(p => p.id === id);
    if (!prod) return;
    openPaymentModal({
        type: 'PRODUCT',
        title: prod.name,
        price: prod.price
    });
}

function openPaymentModal(data) {
    currentCheckout = { ...data, method: 'COD' };
    const nameEl = document.getElementById('pay-item-name');
    const priceEl = document.getElementById('pay-item-price');
    const modal = document.getElementById('payment-modal');

    if (nameEl) nameEl.innerText = currentCheckout.title;
    if (priceEl) priceEl.innerText = currentCheckout.price.toLocaleString() + ' VNĐ';

    selectPaymentMethod('COD');
    if (modal) modal.style.display = 'flex';
}

function selectPaymentMethod(method) {
    currentCheckout.method = method;
    const codPill = document.getElementById('pay-opt-cod');
    const qrPill = document.getElementById('pay-opt-qr');
    const qrBox = document.getElementById('qr-direct-box');
    const desc = document.getElementById('pay-method-desc');

    if (method === 'COD') {
        if (codPill) codPill.classList.add('active');
        if (qrPill) qrPill.classList.remove('active');
        if (qrBox) qrBox.style.display = 'none';
        if (desc) desc.innerText = "Bạn sẽ thanh toán tiền mặt trực tiếp khi nhận hàng hoặc hoàn thành dịch vụ.";
    } else {
        if (qrPill) qrPill.classList.add('active');
        if (codPill) codPill.classList.remove('active');
        if (qrBox) qrBox.style.display = 'block';
        if (desc) desc.innerText = "Mở App ngân hàng quét mã QR trên. Sau khi quét bạn chỉ cần bấm Đặt hàng ngay.";

        const qrImg = document.getElementById('direct-qr-image');
        const bankName = document.getElementById('direct-qr-bank');
        const bankNum = document.getElementById('direct-qr-num');
        const bankHolder = document.getElementById('direct-qr-holder');
        const bankMemo = document.getElementById('direct-qr-memo');

        if (qrImg) qrImg.src = adminConfig.qrImg;
        if (bankName) bankName.innerText = adminConfig.bank;
        if (bankNum) bankNum.innerText = adminConfig.number;
        if (bankHolder) bankHolder.innerText = adminConfig.holder;
        if (bankMemo) bankMemo.innerText = "PETCARE " + Math.floor(100 + Math.random() * 900);
    }
}

function submitOrderProcess() {
    closeModal('payment-modal');
    const dateNow = new Date().toLocaleDateString('vi-VN');
    const methodLabel = currentCheckout.method === 'COD' ? 'Tiền mặt' : 'Chuyển khoản QR';

    if (currentCheckout.type === 'PRODUCT') {
        const orderId = 'DH' + Math.floor(100 + Math.random() * 900);
        orders.unshift({
            id: orderId,
            item: currentCheckout.title,
            method: methodLabel,
            total: currentCheckout.price,
            date: dateNow,
            status: methodLabel === 'Tiền mặt' ? 'Chờ thanh toán khi nhận' : 'Đã thanh toán QR'
        });
        saveData('pc_orders', orders);
        renderOrders();

        expenseRecords.unshift({
            id: Date.now(),
            date: dateNow,
            title: `Mua ${currentCheckout.title}`,
            category: "Mua sắm",
            method: methodLabel,
            amount: currentCheckout.price,
            isCurrentMonth: true
        });
        saveData('pc_expenses', expenseRecords);

        notifyAdmin(`Khách đặt đơn hàng #${orderId} (${currentCheckout.title}) - ${currentCheckout.price.toLocaleString()} VNĐ`, 'order');
        notificationsList.unshift({
            id: Date.now(),
            title: `Đặt hàng thành công #${orderId}`,
            content: `Bạn đã đặt ${currentCheckout.title} thành công qua hình thức ${methodLabel}.`,
            time: "Vừa xong"
        });
        saveData('pc_notifications_list', notificationsList);
        renderNotifications();

        showCenterSuccessPopup(`Mã đơn hàng <strong>#${orderId}</strong> (${methodLabel}) trị giá <strong>${currentCheckout.price.toLocaleString()} VNĐ</strong> đã được xác nhận thành công!`);
    } else if (currentCheckout.type === 'SPA') {
        const appId = 'LH' + Math.floor(1000 + Math.random() * 9000);
        appointments.unshift({
            id: appId,
            pet: currentCheckout.extra.pet,
            service: currentCheckout.title,
            time: currentCheckout.extra.time,
            method: methodLabel,
            status: 'Đang chờ duyệt'
        });
        saveData('pc_appts', appointments);
        renderAppointments();

        expenseRecords.unshift({
            id: Date.now(),
            date: dateNow,
            title: currentCheckout.title,
            category: "Dịch vụ",
            method: methodLabel,
            amount: currentCheckout.price,
            isCurrentMonth: true
        });
        saveData('pc_expenses', expenseRecords);

        notifyAdmin(`Lịch hẹn mới #${appId} cho bé ${currentCheckout.extra.pet} (${currentCheckout.title})`, 'order');
        notificationsList.unshift({
            id: Date.now(),
            title: `Đặt lịch thành công #${appId}`,
            content: `Lịch hẹn cho bé ${currentCheckout.extra.pet} vào lúc ${currentCheckout.extra.time} đã được lưu.`,
            time: "Vừa xong"
        });
        saveData('pc_notifications_list', notificationsList);
        renderNotifications();

        showCenterSuccessPopup(`Lịch hẹn dịch vụ <strong>#${appId}</strong> cho bé <strong>${currentCheckout.extra.pet}</strong> đã được đặt thành công (${methodLabel})!`);
    }

    renderExpenses('month');
    checkVipMemberStatus();
    renderAdminInventoryAdvanced();
}

/* --- 16. CÁC HÀM CRUD & REFRESH GIAO DIỆN CHUNG --- */
function renderCustomerProducts() {
    const box = document.getElementById('product-list-customer');
    if (!box) return;
    box.innerHTML = products.map(p => {
        const isFav = favoriteIds.includes(p.id);
        return `
        <div class="pet-card">
            <button class="btn-fav ${isFav ? 'active' : ''}" onclick="toggleFavorite(${p.id}, event)" title="Yêu thích">
                <i class="fas fa-heart"></i>
            </button>
            <img src="${p.img}" style="border-radius:10px;">
            <h3>${p.name}</h3>
            <p style="color:var(--primary); font-weight:bold; margin: 10px 0;">${p.price.toLocaleString()} VNĐ</p>
            <button class="btn-action btn-save" style="margin:0; padding:10px;" onclick="buyProduct(${p.id})"><i class="fas fa-shopping-cart"></i> Mua ngay</button>
        </div>`;
    }).join('');
}

function toggleFavorite(prodId, event) {
    if (event) event.stopPropagation();
    const index = favoriteIds.indexOf(prodId);
    if (index === -1) {
        favoriteIds.push(prodId);
        showToast("Đã thêm vào mục Yêu thích! ❤️");
    } else {
        favoriteIds.splice(index, 1);
        showToast("Đã bỏ khỏi mục Yêu thích!", "info");
    }
    saveData('pc_favorites', favoriteIds);
    renderCustomerProducts();
    renderFavorites();
}

function renderFavorites() {
    const box = document.getElementById('favorites-list-customer');
    if (!box) return;
    const favProducts = products.filter(p => favoriteIds.includes(p.id));

    if (favProducts.length === 0) {
        box.innerHTML = `
            <div style="grid-column: 1/-1; text-align:center; padding:40px; background:white; border-radius:20px;">
                <i class="far fa-heart fa-3x" style="color:#ddd; margin-bottom:12px;"></i>
                <p style="color:#888;">Bạn chưa có sản phẩm yêu thích nào. Hãy bấm icon tim ❤️ ở danh mục mua sắm nhé!</p>
            </div>`;
        return;
    }

    box.innerHTML = favProducts.map(p => `
        <div class="pet-card">
            <button class="btn-fav active" onclick="toggleFavorite(${p.id}, event)"><i class="fas fa-heart"></i></button>
            <img src="${p.img}" style="border-radius:12px;">
            <h3>${p.name}</h3>
            <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">${p.price.toLocaleString()} VNĐ</p>
            <button class="btn-action btn-save" style="margin:0;" onclick="buyProduct(${p.id})"><i class="fas fa-shopping-cart"></i> Mua ngay</button>
        </div>
    `).join('');
}

function renderOrders() {
    const tbody = document.getElementById('orders-table-body');
    if (!tbody) return;
    tbody.innerHTML = orders.map((o, idx) => `
        <tr class="${idx === 0 ? 'row-updated' : ''}">
            <td><strong>#${o.id}</strong></td>
            <td>${o.item}</td>
            <td><span class="badge ${o.method === 'Tiền mặt' ? 'badge-pending' : 'badge-info'}">${o.method}</span></td>
            <td>${o.total.toLocaleString()} VNĐ</td>
            <td>${o.date}</td>
            <td><span class="badge badge-success">${o.status}</span></td>
        </tr>
    `).join('');
}

function renderAppointments() {
    const tbody = document.getElementById('appointment-table-body');
    if (!tbody) return;
    tbody.innerHTML = appointments.map((a, idx) => `
        <tr class="${idx === 0 ? 'row-updated' : ''}">
            <td><strong>#${a.id}</strong></td>
            <td>${a.pet}</td>
            <td>${a.service}</td>
            <td>${a.time}</td>
            <td><span class="badge ${a.method === 'Tiền mặt' ? 'badge-pending' : 'badge-info'}">${a.method}</span></td>
            <td><span class="badge ${a.status === 'Đã hoàn thành' ? 'badge-success' : 'badge-pending'}">${a.status}</span></td>
            <td><button class="btn-action" style="background:#ffebeb; color:var(--accent);" onclick="cancelAppointment('${a.id}')">Hủy</button></td>
        </tr>
    `).join('');
}

function cancelAppointment(id) {
    appointments = appointments.filter(a => a.id !== id);
    saveData('pc_appts', appointments);
    renderAppointments();
    showToast("Đã hủy lịch hẹn #" + id, "info");
}

function showExpenseDetail(type) {
    const monthCard = document.getElementById('card-month-exp');
    const yearCard = document.getElementById('card-year-exp');

    if (monthCard && yearCard) {
        if (type === 'month') {
            monthCard.classList.add('selected');
            yearCard.classList.remove('selected');
        } else {
            yearCard.classList.add('selected');
            monthCard.classList.remove('selected');
        }
    }
    renderExpenses(type);
}

function renderExpenses(type = 'month') {
    const titleEl = document.getElementById('expense-detail-title');
    const tbody = document.getElementById('expense-table-body');
    if (!tbody) return;

    const filtered = type === 'month' 
        ? expenseRecords.filter(r => r.isCurrentMonth)
        : expenseRecords;

    if (titleEl) {
        titleEl.innerHTML = type === 'month'
            ? `<i class="fas fa-calendar-check"></i> Chi tiết các khoản chi tiêu TRONG THÁNG NÀY`
            : `<i class="fas fa-history"></i> Chi tiết toàn bộ khoản chi tiêu TRONG 1 NĂM VỪA QUA`;
    }

    tbody.innerHTML = filtered.map(r => `
        <tr>
            <td><strong>${r.date}</strong></td>
            <td>${r.title}</td>
            <td><span class="badge badge-info">${r.category}</span></td>
            <td><span class="badge ${r.method === 'Tiền mặt' ? 'badge-pending' : 'badge-success'}">${r.method}</span></td>
            <td style="color:var(--primary); font-weight:bold;">${r.amount.toLocaleString()} VNĐ</td>
        </tr>
    `).join('');

    const mTotal = expenseRecords.filter(r => r.isCurrentMonth).reduce((a,c) => a + c.amount, 0);
    const yTotal = expenseRecords.reduce((a,c) => a + c.amount, 0);
    const mDisp = document.getElementById('disp-month-expense');
    const yDisp = document.getElementById('disp-year-expense');

    if (mDisp) mDisp.innerText = mTotal.toLocaleString() + ' VNĐ';
    if (yDisp) yDisp.innerText = yTotal.toLocaleString() + ' VNĐ';
}

function renderPets() {
    const list = document.getElementById('pet-list');
    if (list) {
        list.innerHTML = pets.map(p => `
            <div class="pet-card">
                <img src="${p.img}">
                <h3>${p.name}</h3>
                <p style="color:#888">${p.breed}</p><br>
                <button class="btn-action" style="background:#e8f0fe; color:var(--primary)" onclick="editPet(${p.id})">Sửa</button>
                <button class="btn-action" style="background:#ffebeb; color:var(--accent)" onclick="deletePet(${p.id})">Xóa</button>
            </div>
        `).join('');
    }
}

function savePet() {
    const id = document.getElementById('pet-id').value;
    const name = document.getElementById('pet-name').value.trim();
    const breed = document.getElementById('pet-breed').value.trim();
    const imgEl = document.getElementById('pet-preview');
    const img = imgEl ? imgEl.src : "https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=200";

    if (!name) return showToast("Vui lòng nhập tên bé!", "warning");

    if (id) {
        const index = pets.findIndex(p => p.id == id);
        pets[index] = { ...pets[index], name, breed, img };
        showToast("Cập nhật thông tin bé thành công!");
    } else {
        pets.push({ id: Date.now(), name, breed, img, owner: userProfile.name });
        showToast("Đã thêm bé mới vào hồ sơ!");
    }
    saveData('pc_pets', pets);
    closeModal('pet-modal');
    renderPets();
}

function editPet(id) {
    const p = pets.find(x => x.id == id);
    if (!p) return;
    document.getElementById('pet-id').value = p.id;
    document.getElementById('pet-name').value = p.name;
    document.getElementById('pet-breed').value = p.breed;
    document.getElementById('pet-preview').src = p.img;
    document.getElementById('pet-modal').style.display = 'flex';
}

function deletePet(id) {
    if (confirm('Xóa bé này khỏi danh sách?')) {
        pets = pets.filter(p => p.id != id);
        saveData('pc_pets', pets);
        renderPets();
        showToast("Đã xóa bé khỏi danh sách!", "info");
    }
}

function openPetModal() {
    document.getElementById('pet-id').value = "";
    document.getElementById('pet-name').value = "";
    document.getElementById('pet-breed').value = "";
    document.getElementById('pet-preview').src = "https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=200";
    document.getElementById('pet-modal').style.display = 'flex';
}

function logHealthData() {
    const wEl = document.getElementById('input-weight');
    const tEl = document.getElementById('input-temp');
    const dispW = document.getElementById('disp-weight');
    const dispT = document.getElementById('disp-temp');

    if (wEl && dispW && wEl.value) dispW.innerText = wEl.value + ' kg';
    if (tEl && dispT && tEl.value) dispT.innerText = tEl.value + ' °C';

    showToast("Đã lưu chỉ số thể trạng hôm nay!");
    if (wEl) wEl.value = '';
    if (tEl) tEl.value = '';
}

function loadUserProfileToUI() {
    const fn = document.getElementById('user-fullname');
    const ph = document.getElementById('user-phone');
    const em = document.getElementById('user-email');
    const ad = document.getElementById('user-address');
    const av = document.getElementById('user-avatar-preview');

    if (fn) fn.value = userProfile.name;
    if (ph) ph.value = userProfile.phone;
    if (em) em.value = userProfile.email;
    if (ad) ad.value = userProfile.address;
    if (av) av.src = userProfile.avatar || "https://i.pravatar.cc/100?img=12";
}

function updateCustomerProfile() {
    const fn = document.getElementById('user-fullname');
    const ph = document.getElementById('user-phone');
    const em = document.getElementById('user-email');
    const ad = document.getElementById('user-address');

    if (fn) userProfile.name = fn.value.trim() || userProfile.name;
    if (ph) userProfile.phone = ph.value.trim();
    if (em) userProfile.email = em.value.trim();
    if (ad) userProfile.address = ad.value.trim();

    saveData('pc_current_profile', userProfile);
    loadUserProfileToUI();
    updateGreetingDisplay('customer');
    checkVipMemberStatus();
    showToast(`Cập nhật hồ sơ của "${userProfile.name}" thành công!`);
}

function renderUsers() {
    const table = document.getElementById('user-table');
    if (!table) return;
    table.innerHTML = adminUsers.map(u => `
        <tr>
            <td><img src="${u.img}" style="border-radius:50%; width:38px; height:38px; object-fit:cover;"></td>
            <td><strong>${u.name}</strong></td>
            <td>${u.email}</td>
            <td><span class="badge badge-info">${u.role}</span></td>
            <td><small style="color:#666;">${u.lastAction || 'Đăng nhập'}</small></td>
            <td><button class="btn-action" style="background:#e8f0fe; color:var(--primary);" onclick="editAdminUser(${u.id})"><i class="fas fa-edit"></i> Chỉnh sửa</button></td>
        </tr>
    `).join('');
}

function openAdminUserModal() {
    document.getElementById('admin-user-modal-title').innerText = "Thêm tài khoản cán bộ";
    document.getElementById('adm-user-id').value = "";
    document.getElementById('adm-user-name').value = "";
    document.getElementById('adm-user-email').value = "";
    document.getElementById('admin-user-modal').style.display = 'flex';
}

function editAdminUser(id) {
    const user = adminUsers.find(u => u.id === id);
    if (!user) return;
    document.getElementById('admin-user-modal-title').innerText = "Chỉnh sửa tài khoản";
    document.getElementById('adm-user-id').value = user.id;
    document.getElementById('adm-user-name').value = user.name;
    document.getElementById('adm-user-email').value = user.email;
    document.getElementById('adm-user-role').value = user.role;
    document.getElementById('admin-user-modal').style.display = 'flex';
}

function saveAdminUser() {
    const id = document.getElementById('adm-user-id').value;
    const name = document.getElementById('adm-user-name').value.trim();
    const email = document.getElementById('adm-user-email').value.trim();
    const roleSelect = document.getElementById('adm-user-role');
    const role = roleSelect ? roleSelect.options[roleSelect.selectedIndex].text : "Nhân viên";

    if (!name || !email) return showToast("Vui lòng điền đủ họ tên và email!", "warning");

    if (id) {
        const idx = adminUsers.findIndex(u => u.id === parseInt(id));
        if (idx !== -1) adminUsers[idx] = { ...adminUsers[idx], name, email, role };
        showToast(`Đã chỉnh sửa tài khoản "${name}"!`);
    } else {
        adminUsers.push({ id: Date.now(), name, email, role, img: "https://i.pravatar.cc/40?img=15", lastAction: "Mới tạo" });
        showToast(`Đã thêm mới tài khoản "${name}"!`);
    }

    saveData('pc_users', adminUsers);
    closeModal('admin-user-modal');
    renderUsers();
}

function renderAdminItems() {
    const tbody = document.getElementById('adm-items-table');
    if (!tbody) return;
    tbody.innerHTML = adminItems.map(item => `
        <tr>
            <td><strong>${item.name}</strong></td>
            <td><span class="badge badge-info">${item.category}</span></td>
            <td>${item.price.toLocaleString()} VNĐ</td>
            <td><strong style="color:var(--success);">${item.salesCount || 0} lượt</strong></td>
            <td><button class="btn-action" style="background:#e8f0fe; color:var(--primary);" onclick="editAdminItem(${item.id})"><i class="fas fa-edit"></i> Chỉnh sửa</button></td>
        </tr>
    `).join('');
}

function openItemModal() {
    document.getElementById('admin-item-modal-title').innerText = "Thêm Dịch vụ / Mặt hàng";
    document.getElementById('adm-item-id').value = "";
    document.getElementById('adm-item-name').value = "";
    document.getElementById('adm-item-price').value = "";
    document.getElementById('admin-item-modal').style.display = 'flex';
}

function editAdminItem(id) {
    const item = adminItems.find(i => i.id === id);
    if (!item) return;
    document.getElementById('admin-item-modal-title').innerText = "Chỉnh sửa Dịch vụ / Mặt hàng";
    document.getElementById('adm-item-id').value = item.id;
    document.getElementById('adm-item-name').value = item.name;
    document.getElementById('adm-item-category').value = item.category;
    document.getElementById('adm-item-price').value = item.price;
    document.getElementById('admin-item-modal').style.display = 'flex';
}

function saveAdminItem() {
    const id = document.getElementById('adm-item-id').value;
    const name = document.getElementById('adm-item-name').value.trim();
    const category = document.getElementById('adm-item-category').value;
    const price = parseInt(document.getElementById('adm-item-price').value);

    if (!name || isNaN(price)) return showToast("Vui lòng nhập tên và giá hợp lệ!", "warning");

    if (id) {
        const idx = adminItems.findIndex(i => i.id === parseInt(id));
        if (idx !== -1) adminItems[idx] = { ...adminItems[idx], name, category, price };
        showToast(`Đã chỉnh sửa "${name}"!`);
    } else {
        adminItems.push({ id: Date.now(), name, category, price, salesCount: 0 });
        showToast(`Đã thêm mới "${name}"!`);
    }

    saveData('pc_admin_items', adminItems);
    closeModal('admin-item-modal');
    renderAdminItems();
}

function saveAdminQRConfig() {
    adminConfig.bank = document.getElementById('adm-bank-name').value;
    adminConfig.number = document.getElementById('adm-bank-number').value;
    adminConfig.holder = document.getElementById('adm-bank-holder').value;

    saveData('pc_admin_config', adminConfig);
    notifyAdmin("Cấu hình QR thanh toán ngân hàng vừa được cập nhật!", "system");
    showToast("Đã lưu cấu hình QR thành công! Đồng bộ tức thời tới khách hàng.");
}

/* --- 17. CÁC HÀM RENDER NỘI BỘ DÀNH CHO NHÂN VIÊN & QUẢN LÝ --- */
function renderInternalRolesData() {
    // 1. Advisor views
    const advProducts = document.getElementById('adv-products-grid');
    if (advProducts) {
        advProducts.innerHTML = products.map(p => `
            <div class="pet-card">
                <img src="${p.img}">
                <h3>${p.name}</h3>
                <p style="color:var(--primary); font-weight:bold;">${p.price.toLocaleString()} VNĐ</p>
                <small style="color:#777;">Tồn kho: ${p.stock} ${p.unit}</small><br>
                <button class="btn-action btn-save" style="margin-top:8px;" onclick="showToast('Đã sao chép link tư vấn sản phẩm!')">Tư vấn sản phẩm</button>
            </div>
        `).join('');
    }

    const advAppts = document.getElementById('adv-appts-tbody');
    if (advAppts) {
        advAppts.innerHTML = appointments.map(a => `
            <tr>
                <td>#${a.id}</td>
                <td>${userProfile.name}</td>
                <td>${a.service}</td>
                <td>${a.time}</td>
                <td><span class="badge badge-info">${a.status}</span></td>
            </tr>
        `).join('');
    }

    const advStatusAppts = document.getElementById('adv-status-appts-tbody');
    if (advStatusAppts) {
        advStatusAppts.innerHTML = appointments.map(a => `
            <tr>
                <td>#${a.id}</td>
                <td>${a.pet}</td>
                <td>${a.service}</td>
                <td>
                    <select onchange="updateAppointmentStatus('${a.id}', this.value)" style="padding:5px; border-radius:8px;">
                        <option ${a.status==='Đang chờ duyệt'?'selected':''}>Đang chờ duyệt</option>
                        <option ${a.status==='Đang thực hiện'?'selected':''}>Đang thực hiện</option>
                        <option ${a.status==='Đã hoàn thành'?'selected':''}>Đã hoàn thành</option>
                    </select>
                </td>
            </tr>
        `).join('');
    }

    const advOrders = document.getElementById('adv-orders-tbody');
    if (advOrders) {
        advOrders.innerHTML = orders.map(o => `
            <tr>
                <td>#${o.id}</td>
                <td>${o.item}</td>
                <td>${o.total.toLocaleString()} VNĐ</td>
                <td><span class="badge badge-success">${o.status}</span></td>
                <td><span class="badge badge-info">Đang vận chuyển</span></td>
            </tr>
        `).join('');
    }

    const advPromos = document.getElementById('adv-promos-grid');
    if (advPromos) {
        advPromos.innerHTML = promotionsList.map(p => `
            <div class="pet-card" style="text-align:left;">
                <span class="badge badge-pending">MÃ: ${p.code}</span>
                <h4 style="margin:8px 0;">${p.title}</h4>
                <p style="font-size:12.5px; color:#666;">${p.desc}</p>
            </div>
        `).join('');
    }

    // 2. Care views
    const staffPets = document.getElementById('staff-pets-tbody');
    if (staffPets) {
        staffPets.innerHTML = pets.map(p => `
            <tr>
                <td><img src="${p.img}" style="width:38px; height:38px; border-radius:50%; object-fit:cover;"></td>
                <td><strong>${p.name}</strong></td>
                <td>${p.breed}</td>
                <td>${p.owner}</td>
                <td><button class="btn-action" style="background:#e8f0fe; color:var(--primary);" onclick="editPet(${p.id})">Xem hồ sơ</button></td>
            </tr>
        `).join('');
    }

    const careAppts = document.getElementById('care-appts-tbody');
    if (careAppts) {
        careAppts.innerHTML = appointments.map(a => `
            <tr>
                <td>#${a.id}</td>
                <td>${a.pet}</td>
                <td>${a.service}</td>
                <td>${a.time}</td>
                <td>
                    <select onchange="updateAppointmentStatus('${a.id}', this.value)" style="padding:5px; border-radius:8px;">
                        <option ${a.status==='Đang chờ duyệt'?'selected':''}>Đang chờ duyệt</option>
                        <option ${a.status==='Đang thực hiện'?'selected':''}>Đang thực hiện</option>
                        <option ${a.status==='Đã hoàn thành'?'selected':''}>Đã hoàn thành</option>
                    </select>
                </td>
            </tr>
        `).join('');
    }

    const careOnlineOrders = document.getElementById('care-online-orders-tbody');
    if (careOnlineOrders) {
        careOnlineOrders.innerHTML = orders.map(o => `
            <tr>
                <td>#${o.id}</td>
                <td>${userProfile.name}</td>
                <td>${o.item}</td>
                <td>${o.total.toLocaleString()} VNĐ</td>
                <td><span class="badge badge-success">${o.status}</span></td>
            </tr>
        `).join('');
    }

    const careStock = document.getElementById('care-stock-tbody');
    if (careStock) {
        careStock.innerHTML = products.map(p => `
            <tr>
                <td>${p.name}</td>
                <td style="font-weight:bold; color:${p.stock<10?'var(--accent)':'inherit'}">${p.stock}</td>
                <td>${p.unit}</td>
                <td><span class="badge ${p.stock<10?'badge-danger':'badge-success'}">${p.stock<10?'Cần bổ sung':'Đầy đủ'}</span></td>
            </tr>
        `).join('');
    }

    const carePromos = document.getElementById('care-promos-grid');
    if (carePromos) {
        carePromos.innerHTML = promotionsList.map(p => `
            <div class="pet-card" style="text-align:left;">
                <span class="badge badge-pending">ƯU ĐÃI: ${p.code}</span>
                <h4 style="margin:8px 0;">${p.title}</h4>
                <p style="font-size:12.5px; color:#666;">${p.desc}</p>
            </div>
        `).join('');
    }

    // 3. Manager views
    const mgrAppts = document.getElementById('mgr-appts-tbody');
    if (mgrAppts) {
        mgrAppts.innerHTML = appointments.map(a => `
            <tr>
                <td>#${a.id}</td>
                <td>${a.pet}</td>
                <td>${a.service}</td>
                <td>${a.time}</td>
                <td><button class="btn-action" style="background:#e8f0fe; color:var(--primary);" onclick="showToast('Đã chuyển điều phối ca!')">Phân công</button></td>
            </tr>
        `).join('');
    }

    const mgrStock = document.getElementById('mgr-stock-tbody');
    if (mgrStock) {
        mgrStock.innerHTML = products.map(p => `
            <tr>
                <td>${p.name}</td>
                <td>${p.stock}</td>
                <td>${p.unit}</td>
                <td><span class="badge ${p.stock<10?'badge-danger':'badge-success'}">${p.stock<10?'Sắp hết':'Ổn định'}</span></td>
            </tr>
        `).join('');
    }

    // POS selector for Staff
    const posSel = document.getElementById('pos-product-select');
    if (posSel) {
        posSel.innerHTML = products.map(p => `<option value="${p.id}" data-price="${p.price}">${p.name} - ${p.price.toLocaleString()} VNĐ (Còn: ${p.stock})</option>`).join('');
        calcPosTotal();
    }
}

function updateAppointmentStatus(appId, newStatus) {
    const a = appointments.find(i => i.id === appId);
    if (a) {
        a.status = newStatus;
        saveData('pc_appts', appointments);
        renderAppointments();
        renderInternalRolesData();
        showToast(`Đã đổi trạng thái lịch #${appId} sang [${newStatus}]`);
    }
}

function calcPosTotal() {
    const sel = document.getElementById('pos-product-select');
    const qtyEl = document.getElementById('pos-qty');
    const dispEl = document.getElementById('pos-total-display');
    if (!sel || !sel.selectedOptions[0] || !dispEl) return;

    const price = parseInt(sel.selectedOptions[0].getAttribute('data-price') || 0);
    const qty = parseInt(qtyEl ? qtyEl.value : 1) || 1;
    dispEl.innerText = (price * qty).toLocaleString() + " VNĐ";
}

function createStaffOrder() {
    const sel = document.getElementById('pos-product-select');
    const qtyEl = document.getElementById('pos-qty');
    const methodEl = document.getElementById('pos-payment-method');

    if (!sel) return;
    const prodId = parseInt(sel.value);
    const prod = products.find(p => p.id === prodId);
    const qty = parseInt(qtyEl ? qtyEl.value : 1) || 1;
    const method = methodEl ? methodEl.value : "Tiền mặt";
    const total = prod.price * qty;

    if (prod.stock < qty) return showToast("Số lượng tồn kho không đủ để bán!", "warning");

    prod.stock -= qty;
    prod.sold = (prod.sold || 0) + qty;
    saveData('pc_prods', products);

    const orderId = 'DH' + Math.floor(100 + Math.random() * 900);
    orders.unshift({
        id: orderId,
        item: `${prod.name} (x${qty})`,
        method: method,
        total: total,
        date: new Date().toLocaleDateString('vi-VN'),
        status: 'Đã thanh toán (Tại quầy)'
    });
    saveData('pc_orders', orders);

    notifyAdmin(`Đơn bán tại quầy #${orderId} (${total.toLocaleString()} VNĐ)`, 'order');
    renderOrders();
    renderInternalRolesData();
    renderAdminInventoryAdvanced();
    showCenterSuccessPopup(`Tạo đơn hàng tại quầy <strong>#${orderId}</strong> trị giá <strong>${total.toLocaleString()} VNĐ</strong> thành công!`);
}

function submitCareStockReport() {
    const item = document.getElementById('care-rep-item').value.trim();
    const qty = document.getElementById('care-rep-qty').value;
    const note = document.getElementById('care-rep-note').value.trim();

    if (!item) return showToast("Vui lòng nhập tên mặt hàng cần nhập!", "warning");

    notifyAdmin(`Nhân viên chăm sóc báo cáo cần nhập: ${item} (x${qty}) - ${note}`, 'urgent');
    showToast("Đã gửi báo cáo hàng tổng cho Quản lý & Admin thành công!");

    document.getElementById('care-rep-item').value = "";
    document.getElementById('care-rep-note').value = "";
}

/* --- 18. KHỞI TẠO TỔNG THỂ --- */
function refreshAllUI() {
    renderPets();
    renderCustomerProducts();
    renderFavorites();
    renderOrders();
    renderAppointments();
    renderReviews();
    renderReminders();
    renderNotifications();
    renderVouchers();
    renderNewsArticles();
    renderExpenses('month');
    loadUserProfileToUI();
    renderChatMessages();

    // Dành cho Cán bộ & Admin
    renderUsers();
    renderAdminItems();
    renderStaffReviewsWithReply();
    renderAdminInventoryAdvanced();
    renderAdminActivePromos();
    renderAdminPublishedNews();
    renderAdminInbox();
    renderSecurityLogs();
    renderInternalRolesData();
    autoBackupSystem();
}

// Chạy slider hình nền ở trang đăng nhập
if (document.querySelector('.bg-slider')) {
    setInterval(() => {
        const slides = document.querySelectorAll('.slide');
        if (!slides.length) return;
        let active = [...slides].findIndex(s => s.classList.contains('active'));
        slides[active].classList.remove('active');
        slides[(active + 1) % slides.length].classList.add('active');
    }, 5000);
}