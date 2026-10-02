<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare Pro - Cổng Quản Trị & Chuyên Môn</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="hologram-fluid-body">

    <div id="toast-box" class="toast-container"></div>

    <div id="success-center-popup" class="success-center-modal">
        <div class="success-center-card ppt-zoom-in">
            <div class="success-icon-circle"><i class="fas fa-check"></i></div>
            <h2 style="color: var(--primary); margin-bottom: 10px;">Thành Công!</h2>
            <p id="success-center-desc" style="color: #666; font-size: 14.5px; line-height: 1.6; margin-bottom: 25px;"></p>
            <button class="btn-login" style="margin-top:0;" onclick="closeCenterSuccessPopup()">ĐÓNG</button>
        </div>
    </div>

    <!-- KHUNG CHAT TIẾP NHẬN TƯ VẤN KHÁCH HÀNG (DÀNH CHO TƯ VẤN VIÊN) -->
    <div id="advisor-live-chat-panel" class="advisor-chat-dock" style="display:none;">
        <div class="advisor-chat-header">
            <div style="display:flex; align-items:center; gap:8px;">
                <i class="fas fa-headset"></i>
                <div>
                    <h4 style="margin:0; font-size:13.5px;" id="adv-chat-client-title">Tiếp nhận: Khách hàng chờ tư vấn</h4>
                    <small style="font-size:11px; opacity:0.9;" id="adv-chat-client-status">Trạng thái: Đang kết nối</small>
                </div>
            </div>
            <div style="display:flex; gap:10px; align-items:center;">
                <span class="badge badge-success">Online</span>
                <!-- Nút hạ khung chat xuống -->
                <button onclick="minimizeAdvisorChat()" title="Hạ khung chat" style="background:none; border:none; color:#fff; font-size:16px; cursor:pointer;"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div id="advisor-chat-stream" class="advisor-chat-body">
            <!-- Tin nhắn từ khách hàng hiển thị bên trái, tư vấn trả lời bên phải -->
        </div>
        <div class="advisor-chat-footer">
            <input type="text" id="advisor-reply-input" placeholder="Nhập câu trả lời tư vấn cho khách..." onkeypress="if(event.key==='Enter') sendAdvisorChatMessage()">
            <button class="btn-action btn-save" style="width:auto; margin:0;" onclick="sendAdvisorChatMessage()"><i class="fas fa-reply"></i> Gửi</button>
        </div>
    </div>

    <!-- NÚT BẬT LẠI KHUNG CHAT KHI ĐÃ HẠ XUỐNG GÓC PHẢI -->
    <button id="advisor-chat-restore-btn" class="chat-bubble-btn" style="display:none; position:fixed; bottom:20px; right:20px; z-index:9991;" onclick="restoreAdvisorChat()">
        <i class="fas fa-comments fa-2x"></i>
        <span class="red-counter-badge" id="adv-unread-badge" style="position:absolute; top:-5px; right:-5px; display:none;">0</span>
    </button>

    <div id="main-page" class="page active">
        <aside class="sidebar holo-glass-sidebar">
            <h2 style="color: var(--primary); margin-bottom: 20px;"><i class="fas fa-shield-alt"></i> PETCARE PORTAL</h2>
            
            <div class="user-greeting-box">
                <img id="sidebar-user-avatar" src="https://i.pravatar.cc/100?img=11" class="user-greeting-avatar">
                <div class="user-greeting-text">
                    <!-- Chỉ hiển thị đúng chức danh chuyên môn -->
                    <h4 id="sidebar-greeting-name">Nhân viên chăm sóc</h4>
                    <small id="sidebar-user-role-badge">Bộ Phận Chuyên Trách</small>
                </div>
            </div>

            <!-- ================= CÁC BỘ MENU PHÂN QUYỀN ================= -->

            <!-- 1. VAI TRÒ: NHÂN VIÊN TƯ VẤN (ADVISOR) -->
            <div data-role="advisor" style="display:none;">
                <li class="nav-item" onclick="toggleSubmenu('sub-adv-cust', this)">
                    <i class="fas fa-users"></i> Khách hàng
                    <i class="fas fa-chevron-down arrow-icon rotate"></i>
                </li>
                <ul id="sub-adv-cust" class="submenu open">
                    <li class="submenu-item active" onclick="switchTab('adv-cust-list', this)"><i class="fas fa-address-book"></i> Danh sách khách hàng</li>
                    <li class="submenu-item" onclick="switchTab('adv-pet-profiles', this)"><i class="fas fa-paw"></i> Thông tin hồ sơ thú cưng</li>
                    <li class="submenu-item" onclick="switchTab('adv-history', this)"><i class="fas fa-history"></i> Lịch sử dịch vụ đã dùng</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-adv-consult', this)">
                    <i class="fas fa-comments-dollar"></i> Tư vấn dịch vụ
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-adv-consult" class="submenu">
                    <li class="submenu-item" onclick="switchTab('adv-suggest-pkg', this)"><i class="fas fa-hand-holding-heart"></i> Gợi ý gói phù hợp</li>
                    <li class="submenu-item" onclick="switchTab('adv-petshop-intro', this)"><i class="fas fa-box-open"></i> Giới thiệu sản phẩm Pet Shop</li>
                    <li class="submenu-item" onclick="switchTab('adv-quick-quote', this)"><i class="fas fa-calculator"></i> Lên đơn nhanh & Hóa đơn VAT</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-adv-appts', this)">
                    <i class="fas fa-calendar-check"></i> Lịch hẹn
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-adv-appts" class="submenu">
                    <li class="submenu-item" onclick="switchTab('adv-view-appts', this)"><i class="fas fa-calendar-alt"></i> Xem lịch hẹn của khách</li>
                    <li class="submenu-item" onclick="switchTab('adv-create-appt', this)"><i class="fas fa-plus-circle"></i> Đặt lịch mới theo yêu cầu</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-adv-orders', this)">
                    <i class="fas fa-receipt"></i> Đơn hàng & giao dịch
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-adv-orders" class="submenu">
                    <li class="submenu-item" onclick="switchTab('adv-orders-track', this)"><i class="fas fa-shopping-cart"></i> Theo dõi đơn hàng khách đặt</li>
                    <li class="submenu-item" onclick="switchTab('adv-payment-support', this)"><i class="fas fa-credit-card"></i> Hỗ trợ TT, xác nhận GD</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-adv-kpi', this)">
                    <i class="fas fa-user-tie"></i> Báo cáo cá nhân
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-adv-kpi" class="submenu">
                    <li class="submenu-item" onclick="switchTab('adv-report-clients', this)"><i class="fas fa-user-check"></i> Số lượng khách đã tư vấn</li>
                    <li class="submenu-item" onclick="switchTab('adv-report-rate', this)"><i class="fas fa-percentage"></i> Hiệu quả tư vấn</li>
                    <li class="submenu-item" onclick="switchTab('adv-report-reviews', this)"><i class="fas fa-star"></i> Đánh giá từ khách hàng</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-adv-news', this)">
                    <i class="fas fa-bullhorn"></i> Tin tức & Khuyến mãi
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-adv-news" class="submenu">
                    <li class="submenu-item" onclick="switchTab('adv-promos-update', this)"><i class="fas fa-tags"></i> Cập nhật ưu đãi, gói mới</li>
                    <li class="submenu-item" onclick="switchTab('adv-member-club', this)"><i class="fas fa-crown"></i> Chương trình KH thân thiết</li>
                </ul>

                <li class="nav-item" onclick="switchTab('adv-attendance', this)">
                    <i class="fas fa-user-clock"></i> Check-in / Check-out
                </li>
            </div>

            <!-- 2. VAI TRÒ: NHÂN VIÊN CHĂM SÓC (STAFF SPA/GROOMING) -->
            <div data-role="staff" style="display:none;">
                <li class="nav-item" onclick="toggleSubmenu('sub-care-pets', this)">
                    <i class="fas fa-folder-open"></i> Hồ sơ thú cưng
                    <i class="fas fa-chevron-down arrow-icon rotate"></i>
                </li>
                <ul id="sub-care-pets" class="submenu open">
                    <li class="submenu-item active" onclick="switchTab('care-view-pets', this)"><i class="fas fa-search"></i> Xem thông tin hồ sơ khách</li>
                    <li class="submenu-item" onclick="switchTab('care-health-notes', this)"><i class="fas fa-notes-medical"></i> Cập nhật tình trạng sau chăm sóc</li>
                </ul>

                <!-- GỘP LỊCH HẸN VÀO HỒ SƠ CHỜ DUYỆT -->
                <li class="nav-item" onclick="switchTab('care-appts-pending', this)">
                    <i class="fas fa-clipboard-check"></i> Hồ sơ chờ duyệt
                    <span class="red-counter-badge" id="care-pending-badge">2</span>
                </li>

                <li class="nav-item" onclick="toggleSubmenu('sub-care-services', this)">
                    <i class="fas fa-cut"></i> Dịch vụ chăm sóc
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-care-services" class="submenu">
                    <li class="submenu-item" onclick="switchTab('care-spa-action', this)"><i class="fas fa-bath"></i> Spa thú cưng</li>
                    <li class="submenu-item" onclick="switchTab('care-grooming-action', this)"><i class="fas fa-cut"></i> Grooming & Cắt tỉa lông</li>
                    <li class="submenu-item" onclick="switchTab('care-hotel-action', this)"><i class="fas fa-hotel"></i> Khách sạn thú cưng</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-care-sales', this)">
                    <i class="fas fa-cash-register"></i> Bán hàng
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-care-sales" class="submenu">
                    <li class="submenu-item" onclick="switchTab('care-sales-pos', this)"><i class="fas fa-store"></i> Tại quầy</li>
                    <li class="submenu-item" onclick="switchTab('care-sales-online', this)"><i class="fas fa-globe"></i> Online</li>
                </ul>

                <!-- TÁCH RIÊNG 2 MENU CON KHO -->
                <li class="nav-item" onclick="toggleSubmenu('sub-care-inventory', this)">
                    <i class="fas fa-warehouse"></i> Kho & vật tư
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-care-inventory" class="submenu">
                    <li class="submenu-item" onclick="switchTab('care-stock-check', this)"><i class="fas fa-boxes"></i> Kiểm tra hàng tồn</li>
                    <li class="submenu-item" onclick="switchTab('care-stock-report', this)"><i class="fas fa-file-invoice"></i> Báo cáo hàng tổng</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-care-kpi', this)">
                    <i class="fas fa-chart-line"></i> Báo cáo cá nhân
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-care-kpi" class="submenu">
                    <li class="submenu-item" onclick="switchTab('care-my-kpi', this)"><i class="fas fa-user-check"></i> Số lượng ca đã hoàn thành</li>
                    <li class="submenu-item" onclick="switchTab('care-reviews-reply', this)">
                        <i class="fas fa-star" style="color:var(--warning)"></i> Trả lời đánh giá 
                        <span class="red-counter-badge" id="care-review-badge">1</span>
                    </li>
                    <li class="submenu-item" onclick="switchTab('care-performance', this)"><i class="fas fa-award"></i> Hiệu quả công việc</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-care-news', this)">
                    <i class="fas fa-bullhorn"></i> Tin tức & Khuyến mãi
                    <span class="red-counter-badge" id="care-promo-badge">1</span>
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-care-news" class="submenu">
                    <li class="submenu-item" onclick="switchTab('care-promos-view', this)"><i class="fas fa-tags"></i> Chương trình ưu đãi khách</li>
                </ul>

                <li class="nav-item" onclick="switchTab('care-attendance', this)">
                    <i class="fas fa-user-clock"></i> Check-in / Check-out
                </li>
            </div>

            <!-- 3. VAI TRÒ: BÁC SĨ TRỰC THUỘC (DOCTOR) -->
            <div data-role="doctor" style="display:none;">
                <li class="nav-item" onclick="toggleSubmenu('sub-doc-exam', this)">
                    <i class="fas fa-stethoscope"></i> Khám bệnh
                    <i class="fas fa-chevron-down arrow-icon rotate"></i>
                </li>
                <ul id="sub-doc-exam" class="submenu open">
                    <li class="submenu-item active" onclick="switchTab('doc-daily-exams', this)"><i class="fas fa-calendar-day"></i> Danh sách hẹn khám trong ngày</li>
                    <li class="submenu-item" onclick="switchTab('doc-execute-exam', this)"><i class="fas fa-notes-medical"></i> Khám và ghi nhận kết quả</li>
                    <li class="submenu-item" onclick="switchTab('doc-health-update', this)"><i class="fas fa-heartbeat"></i> Cập nhật tình trạng sức khoẻ</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-doc-emr', this)">
                    <i class="fas fa-file-medical"></i> Bệnh án điện tử
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-doc-emr" class="submenu">
                    <li class="submenu-item" onclick="switchTab('doc-create-emr', this)"><i class="fas fa-plus"></i> Tạo mới bệnh án</li>
                    <li class="submenu-item" onclick="switchTab('doc-view-emr', this)"><i class="fas fa-book-medical"></i> Xem và chỉnh sửa bệnh án cũ</li>
                    <li class="submenu-item" onclick="switchTab('doc-prescriptions', this)"><i class="fas fa-pills"></i> Kê đơn thuốc, chỉ định xét nghiệm</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-doc-appts', this)">
                    <i class="fas fa-user-clock"></i> Lịch hẹn
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-doc-appts" class="submenu">
                    <li class="submenu-item" onclick="switchTab('doc-my-appts', this)"><i class="fas fa-calendar-alt"></i> Xem lịch hẹn cá nhân</li>
                    <li class="submenu-item" onclick="switchTab('doc-re-exam', this)"><i class="fas fa-calendar-plus"></i> Đặt lịch tái khám</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-doc-tests', this)">
                    <i class="fas fa-vials"></i> Xét nghiệm & Tiêm phòng
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-doc-tests" class="submenu">
                    <li class="submenu-item" onclick="switchTab('doc-tests-mgr', this)"><i class="fas fa-microscope"></i> Quản lý danh sách xét nghiệm</li>
                    <li class="submenu-item" onclick="switchTab('doc-vaccine-tracker', this)"><i class="fas fa-syringe"></i> Theo dõi lịch tiêm phòng</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-doc-kpi', this)">
                    <i class="fas fa-chart-line"></i> Báo cáo cá nhân
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-doc-kpi" class="submenu">
                    <li class="submenu-item" onclick="switchTab('doc-report-cases', this)"><i class="fas fa-check-circle"></i> Số ca khám đã thực hiện</li>
                    <li class="submenu-item" onclick="switchTab('doc-report-rate', this)"><i class="fas fa-percentage"></i> Hiệu quả điều trị</li>
                    <li class="submenu-item" onclick="switchTab('doc-report-reviews', this)"><i class="fas fa-star"></i> Đánh giá từ khách hàng</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-doc-news', this)">
                    <i class="fas fa-book"></i> Tin tức chuyên môn
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-doc-news" class="submenu">
                    <li class="submenu-item" onclick="switchTab('doc-protocols', this)"><i class="fas fa-shield-virus"></i> Hướng dẫn & Quy trình y tế</li>
                    <li class="submenu-item" onclick="switchTab('doc-internal-notice', this)"><i class="fas fa-bell"></i> Thông báo nội bộ phòng khám</li>
                </ul>
            </div>

            <!-- 4. VAI TRÒ: QUẢN LÝ CỬA HÀNG (MANAGER) -->
            <div data-role="manager" style="display:none;">
                <li class="nav-item" onclick="toggleSubmenu('sub-mgr-hr', this)">
                    <i class="fas fa-users-cog"></i> Quản lý nhân sự
                    <i class="fas fa-chevron-down arrow-icon rotate"></i>
                </li>
                <ul id="sub-mgr-hr" class="submenu open">
                    <li class="submenu-item active" onclick="switchTab('mgr-staff-list', this)"><i class="fas fa-id-badge"></i> Danh sách nhân viên</li>
                    <li class="submenu-item" onclick="switchTab('mgr-shifts', this)"><i class="fas fa-calendar-alt"></i> Phân công ca làm việc</li>
                    <li class="submenu-item" onclick="switchTab('mgr-kpi-track', this)"><i class="fas fa-chart-bar"></i> Theo dõi hiệu quả công việc</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-mgr-clients', this)">
                    <i class="fas fa-folder-open"></i> Khách hàng & Hồ sơ
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-mgr-clients" class="submenu">
                    <li class="submenu-item" onclick="switchTab('mgr-approve-pets', this)"><i class="fas fa-check-double"></i> Duyệt hồ sơ thú cưng</li>
                    <li class="submenu-item" onclick="switchTab('mgr-emr-view', this)"><i class="fas fa-file-medical"></i> Xem bệnh án điện tử</li>
                    <li class="submenu-item" onclick="switchTab('mgr-history-view', this)"><i class="fas fa-history"></i> Theo dõi lịch sử dịch vụ</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-mgr-appts', this)">
                    <i class="fas fa-calendar-check"></i> Lịch hẹn & Dịch vụ
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-mgr-appts" class="submenu">
                    <li class="submenu-item" onclick="switchTab('mgr-general-appts', this)"><i class="fas fa-tasks"></i> Quản lý lịch hẹn chung</li>
                    <li class="submenu-item" onclick="switchTab('mgr-dispatch', this)"><i class="fas fa-user-friends"></i> Điều phối bác sĩ / nhân viên</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-mgr-inventory', this)">
                    <i class="fas fa-boxes"></i> Kho & Sản phẩm
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-mgr-inventory" class="submenu">
                    <li class="submenu-item" onclick="switchTab('mgr-stock-check', this)"><i class="fas fa-warehouse"></i> Kiểm tra tồn kho cơ bản</li>
                    <li class="submenu-item" onclick="switchTab('mgr-stock-alerts', this)"><i class="fas fa-exclamation-triangle"></i> Báo cáo hết hàng, đề xuất nhập</li>
                    <li class="submenu-item" onclick="switchTab('mgr-petshop-products', this)"><i class="fas fa-store"></i> Quản lý sản phẩm Pet Shop</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-mgr-finance', this)">
                    <i class="fas fa-coins"></i> Tài chính cơ bản
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-mgr-finance" class="submenu">
                    <li class="submenu-item" onclick="switchTab('mgr-revenue-summary', this)"><i class="fas fa-chart-line"></i> Báo cáo doanh thu ngày/tuần/tháng</li>
                    <li class="submenu-item" onclick="switchTab('mgr-invoices', this)"><i class="fas fa-receipt"></i> Theo dõi hóa đơn, thanh toán</li>
                    <li class="submenu-item" onclick="switchTab('mgr-service-costs', this)"><i class="fas fa-wallet"></i> Báo cáo chi phí dịch vụ</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-mgr-stats', this)">
                    <i class="fas fa-chart-pie"></i> Báo cáo & Thống kê
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-mgr-stats" class="submenu">
                    <li class="submenu-item" onclick="switchTab('mgr-stats-clients', this)"><i class="fas fa-paw"></i> Số lượng khách & thú cưng</li>
                    <li class="submenu-item" onclick="switchTab('mgr-stats-services', this)"><i class="fas fa-star"></i> Dịch vụ sử dụng nhiều nhất</li>
                    <li class="submenu-item" onclick="switchTab('mgr-stats-staff-kpi', this)"><i class="fas fa-user-check"></i> Hiệu quả nhân viên</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-mgr-promos', this)">
                    <i class="fas fa-bullhorn"></i> Tin tức & Khuyến mãi
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-mgr-promos" class="submenu">
                    <li class="submenu-item" onclick="switchTab('mgr-promos-update', this)"><i class="fas fa-tags"></i> Cập nhật chương trình ưu đãi</li>
                    <li class="submenu-item" onclick="switchTab('mgr-internal-news', this)"><i class="fas fa-newspaper"></i> Thông báo nội bộ</li>
                </ul>
            </div>

            <!-- 5. VAI TRÒ: QUẢN TRỊ VIÊN CẤP CAO (ADMIN) -->
            <div data-role="admin" style="display:none;">
                <li class="nav-item" onclick="switchTab('adm-users', this)">
                    <i class="fas fa-users-cog"></i> Quản lý tài khoản
                </li>

                <li class="nav-item" onclick="switchTab('adm-services-products', this)">
                    <i class="fas fa-boxes"></i> Quản lý dịch vụ & sản phẩm
                </li>

                <!-- Tách riêng 3 menu con Kho, QR, Doanh thu -->
                <li class="nav-item" onclick="toggleSubmenu('sub-adm-fin', this)">
                    <i class="fas fa-coins"></i> Kho, QR & Doanh thu
                    <i class="fas fa-chevron-down arrow-icon rotate"></i>
                </li>
                <ul id="sub-adm-fin" class="submenu open">
                    <li class="submenu-item active" onclick="switchTab('adm-tab-inventory', this)"><i class="fas fa-warehouse"></i> Kho hàng</li>
                    <li class="submenu-item" onclick="switchTab('adm-tab-qr', this)"><i class="fas fa-qrcode"></i> QR và thanh toán</li>
                    <li class="submenu-item" onclick="switchTab('adm-tab-revenue', this)"><i class="fas fa-chart-line"></i> Doanh thu thực tế</li>
                </ul>

                <!-- Tách riêng 2 menu con Khuyến mãi, Tin tức -->
                <li class="nav-item" onclick="toggleSubmenu('sub-adm-marketing', this)">
                    <i class="fas fa-bullhorn"></i> Khuyến mãi & Tin tức
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-adm-marketing" class="submenu">
                    <li class="submenu-item" onclick="switchTab('adm-tab-promos', this)"><i class="fas fa-tags"></i> Khuyến mãi</li>
                    <li class="submenu-item" onclick="switchTab('adm-tab-news', this)"><i class="fas fa-newspaper"></i> Tin tức</li>
                </ul>

                <li class="nav-item" onclick="switchTab('adm-statistics', this)">
                    <i class="fas fa-chart-pie"></i> Báo cáo & thống kê định kỳ
                </li>

                <li class="nav-item" onclick="switchTab('adm-inbox', this)">
                    <i class="fas fa-envelope"></i> Hộp thư
                    <span class="red-counter-badge" id="adm-inbox-badge">1</span>
                </li>

                <li class="nav-item" onclick="switchTab('adm-attendance', this)">
                    <i class="fas fa-user-clock"></i> Check-in / Check-out
                </li>
            </div>

            <li class="nav-item" onclick="logoutToAuth()" style="margin-top: auto; color: var(--accent);"><i class="fas fa-sign-out-alt"></i> Đăng xuất</li>
        </aside>

        <main class="content-area holo-content-area">

            <!-- ================= CÁC SECTION DÀNH CHO ADMIN ================= -->

            <!-- 1. Quản lý tài khoản (Đổi nút thành Chỉnh sửa, duyệt cán bộ mới) -->
            <section id="adm-users" class="view-section active">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
                    <h2>Quản lý tài khoản</h2>
                    <button class="btn-action btn-save" style="width:auto;" onclick="openAdminUserModal()"><i class="fas fa-user-plus"></i> Thêm tài khoản</button>
                </div>

                <div class="table-container" style="margin-bottom:25px; border-left:5px solid var(--accent);">
                    <h3 style="color:var(--accent);"><i class="fas fa-user-check"></i> Yêu cầu phê duyệt tài khoản Cán bộ & Admin mới</h3>
                    <p style="color:#777; font-size:13px; margin:5px 0 15px;">Duyệt quyền truy cập cho Bác sĩ, Nhân viên và Quản trị viên mới tuyển dụng</p>
                    <table>
                        <thead><tr><th>Họ và tên</th><th>Email công vụ</th><th>Chức danh đề xuất</th><th>Thời gian gửi</th><th>Hành động</th></tr></thead>
                        <tbody id="adm-pending-users-tbody">
                            <tr>
                                <td><strong>BS. Hoàng Kim Yến</strong></td>
                                <td>dr.yenhoang@petcare.com</td>
                                <td><span class="badge badge-info">Bác Sĩ Thú Y</span></td>
                                <td>Hôm nay 08:15</td>
                                <td>
                                    <button class="btn-action" style="background:#e8f8f5; color:var(--success);" onclick="approveStaffAccount('BS. Hoàng Kim Yến')"><i class="fas fa-check"></i> Phê duyệt</button>
                                    <button class="btn-action" style="background:#ffebeb; color:var(--accent);" onclick="rejectStaffAccount(this)"><i class="fas fa-times"></i> Từ chối</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-container">
                    <h3>Danh sách tài khoản trong hệ thống</h3><br>
                    <table>
                        <thead><tr><th>Ảnh</th><th>Họ và tên</th><th>Email</th><th>Vai trò</th><th>Hành động gần nhất</th><th>Chỉnh sửa</th></tr></thead>
                        <tbody id="user-table"></tbody>
                    </table>
                </div>
            </section>

            <!-- 2. Quản lý dịch vụ & sản phẩm (Đổi thành Chỉnh sửa, hiện lượt bán/đặt lịch) -->
            <section id="adm-services-products" class="view-section">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
                    <h2>Quản lý dịch vụ & sản phẩm</h2>
                    <button class="btn-action btn-save" style="width:auto;" onclick="openItemModal()"><i class="fas fa-plus"></i> Thêm mục mới</button>
                </div>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Tên mặt hàng / Dịch vụ</th><th>Phân loại</th><th>Đơn giá</th><th>Lượt bán / Đặt lịch</th><th>Chỉnh sửa</th></tr></thead>
                        <tbody id="adm-items-table"></tbody>
                    </table>
                </div>
            </section>

            <!-- 3A. Kho hàng nâng cao (Sản phẩm, mỹ phẩm riêng, hàng tồn riêng, tỷ lệ % tròn) -->
            <section id="adm-tab-inventory" class="view-section">
                <h2><i class="fas fa-warehouse" style="color:var(--primary);"></i> Quản Trị Kho Hàng Nâng Cao</h2><br>

                <div class="card-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom:25px;">
                    <div class="pet-card">
                        <h3>Tỷ lệ bán được</h3>
                        <div class="pie-chart-circle" style="background: conic-gradient(var(--success) 0% 68%, #eee 68% 100%);">
                            <span class="pie-chart-val">68%</span>
                        </div>
                        <small style="color:#777;">Hàng hóa lưu thông tốt</small>
                    </div>
                    <div class="pet-card">
                        <h3>Còn trong kho</h3>
                        <div class="pie-chart-circle" style="background: conic-gradient(var(--primary) 0% 74%, #eee 74% 100%);">
                            <span class="pie-chart-val">74%</span>
                        </div>
                        <small style="color:#777;">Sẵn sàng phục vụ & bán</small>
                    </div>
                    <div class="pet-card">
                        <h3>Tồn kho cảnh báo</h3>
                        <div class="pie-chart-circle" style="background: conic-gradient(var(--accent) 0% 18%, #eee 18% 100%);">
                            <span class="pie-chart-val">18%</span>
                        </div>
                        <small style="color:#777;">Cần kiểm soát hạn dùng</small>
                    </div>
                </div>

                <div class="table-container" style="margin-bottom:25px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                        <h3><i class="fas fa-box"></i> Sản phẩm bán Pet Shop (Thức ăn, Phụ kiện, Thuốc)</h3>
                        <button class="btn-action btn-save" style="width:auto; padding:6px 14px;" onclick="openItemModal()"><i class="fas fa-plus"></i> Nhập SP mới</button>
                    </div>
                    <table>
                        <thead><tr><th>Mã SP</th><th>Tên sản phẩm</th><th>Tồn kho</th><th>Đơn vị</th><th>Cập nhật kho (Tick)</th><th>Chỉnh sửa</th></tr></thead>
                        <tbody id="adm-stock-products-tbody"></tbody>
                    </table>
                </div>

                <div class="table-container" style="margin-bottom:25px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                        <h3><i class="fas fa-pump-soap"></i> Mỹ phẩm & Dụng cụ chuyên dụng Spa/Grooming</h3>
                        <button class="btn-action btn-save" style="width:auto; padding:6px 14px;" onclick="openItemModal()"><i class="fas fa-plus"></i> Nhập mỹ phẩm</button>
                    </div>
                    <table>
                        <thead><tr><th>Mã MP</th><th>Tên mỹ phẩm / Dụng cụ</th><th>Số lượng</th><th>Quy cách</th><th>Cập nhật kho (Tick)</th><th>Chỉnh sửa</th></tr></thead>
                        <tbody id="adm-stock-cosmetics-tbody"></tbody>
                    </table>
                </div>

                <div class="table-container">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                        <h3 style="color:var(--accent);"><i class="fas fa-archive"></i> Khu Vực Quản Khắc Phục Hàng Tồn Kho</h3>
                        <span class="badge badge-danger">Kiểm soát nghiêm ngặt</span>
                    </div>
                    
                    <div style="display:flex; gap:20px; align-items:center; flex-wrap:wrap; margin-bottom:15px; background:rgba(255,118,117,0.08); padding:15px; border-radius:14px;">
                        <div style="text-align:center;">
                            <div class="pie-chart-circle" style="width:80px; height:80px; background: conic-gradient(#e74c3c 0% 45%, #f39c12 45% 75%, #2ecc71 75% 100%);">
                                <span class="pie-chart-val" style="font-size:12px;">Tồn Kho</span>
                            </div>
                        </div>
                        <div style="flex:1; font-size:13px; line-height:1.8;">
                            <p><i class="fas fa-circle" style="color:#e74c3c;"></i> <strong>Gần hết date (45%):</strong> Cần áp dụng mã xả kho giảm 40%</p>
                            <p><i class="fas fa-circle" style="color:#f39c12;"></i> <strong>Bán chậm (30%):</strong> Cần nhân viên tư vấn đẩy mạnh giới thiệu</p>
                            <p><i class="fas fa-circle" style="color:#2ecc71;"></i> <strong>Mới nhập tồn ổn định (25%):</strong> Hạn dùng trên 18 tháng</p>
                        </div>
                    </div>

                    <table>
                        <thead><tr><th>Mặt hàng tồn</th><th>Số lượng</th><th>Tình trạng tồn</th><th>Biện pháp xử lý</th><th>Thao tác</th></tr></thead>
                        <tbody id="adm-dead-stock-tbody"></tbody>
                    </table>
                </div>
            </section>

            <!-- 3B. QR và thanh toán -->
            <section id="adm-tab-qr" class="view-section">
                <h2><i class="fas fa-qrcode" style="color:var(--primary);"></i> Cấu Hình Mã QR Ngân Hàng & Thanh Toán</h2><br>
                <div class="table-container" style="max-width: 680px;">
                    <p style="color: #777; font-size: 13.5px; margin-bottom: 15px;">Mã QR tĩnh này hiển thị trực tiếp cho khách hàng quét thanh toán.</p>
                    
                    <div style="display: flex; gap: 20px; align-items: center; flex-wrap: wrap;">
                        <div style="text-align: center;">
                            <img id="admin-qr-preview" src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=PETCARE_PAYMENT_ADMIN" style="width: 150px; height: 150px; border: 2px solid #ddd; border-radius: 14px; padding: 6px; background: white; object-fit: contain;">
                            <label class="btn-upload" style="margin-top: 10px; display: block;">
                                <i class="fas fa-upload"></i> Tải ảnh QR mới
                                <input type="file" accept="image/*" style="display: none;" onchange="previewImage(this, 'admin-qr-preview')">
                            </label>
                        </div>
                        <div style="flex: 1; min-width: 260px;">
                            <div class="input-group"><label>Ngân hàng nhận</label><input type="text" id="adm-bank-name" value="MB Bank (Ngân hàng Quân Đội)"></div>
                            <div class="input-group"><label>Số tài khoản</label><input type="text" id="adm-bank-number" value="0901 234 567"></div>
                            <div class="input-group"><label>Chủ tài khoản</label><input type="text" id="adm-bank-holder" value="PHONG KHAM PETCARE PRO"></div>
                            <button class="btn-action btn-save" style="margin: 0;" onclick="saveAdminQRConfig()"><i class="fas fa-check"></i> Lưu cấu hình QR</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 3C. Doanh thu thực tế -->
            <section id="adm-tab-revenue" class="view-section">
                <h2><i class="fas fa-chart-line" style="color:var(--success);"></i> Quản Trị Doanh Thu Thực Tế</h2><br>
                <div class="card-grid">
                    <div class="pet-card">
                        <h3 id="adm-current-month-label">Doanh thu tháng (Thời gian thực)</h3>
                        <p id="disp-adm-realtime-rev" style="font-size:28px; color:var(--success); font-weight:bold; margin: 10px 0;">0 VNĐ</p>
                        <small style="color:#777;">Cập nhật tự động theo mọi đơn mua & ca dịch vụ hoàn tất</small>
                    </div>
                    <div class="pet-card">
                        <h3>Doanh thu bán tại Pet Shop</h3>
                        <p id="disp-adm-shop-rev" style="font-size:28px; color:var(--primary); font-weight:bold; margin: 10px 0;">0 VNĐ</p>
                        <small style="color:#777;">Từ sản phẩm, phụ kiện và thuốc</small>
                    </div>
                </div>
            </section>

            <!-- 4A. Khuyến mãi (Tách riêng menu con) -->
            <section id="adm-tab-promos" class="view-section">
                <h2><i class="fas fa-tags" style="color:var(--accent);"></i> Quản Lý & Phát Hành Khuyến Mãi</h2>
                <p style="color:#777; margin:5px 0 20px;">Khi tạo khuyến mãi mới, hệ thống tự động bật Banner hình vuông cho khách và tăng icon chấm đỏ số lượng cho nhân viên</p>
                
                <div class="table-container" style="max-width: 650px; margin-bottom: 25px;">
                    <h3>Thêm chương trình khuyến mãi mới</h3><br>
                    <div class="input-group"><label>Tiêu đề ưu đãi</label><input type="text" id="adm-promo-title" placeholder="VD: Giảm 20% Spa Đầu Tuần"></div>
                    <div class="input-group"><label>Mã Voucher</label><input type="text" id="adm-promo-code" placeholder="VD: SPA20"></div>
                    <div class="input-group"><label>Nội dung chi tiết & hướng dẫn tư vấn cho nhân viên</label><textarea id="adm-promo-desc" rows="3" placeholder="Nhân viên tư vấn cần nhấn mạnh giảm 20% áp dụng cho khách đặt từ T2 đến T4..."></textarea></div>
                    <button class="btn-action btn-save" onclick="addAdminPromo()"><i class="fas fa-bullhorn"></i> ĐĂNG & PHÁT HÀNH TOÀN HỆ THỐNG</button>
                </div>

                <div class="table-container">
                    <h3>Các chương trình khuyến mãi đang chạy</h3><br>
                    <table>
                        <thead><tr><th>Mã</th><th>Tên chương trình</th><th>Nội dung tư vấn</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
                        <tbody id="adm-active-promos-tbody"></tbody>
                    </table>
                </div>
            </section>

            <!-- 4B. Tin tức (Tách riêng menu con) -->
            <section id="adm-tab-news" class="view-section">
                <h2><i class="fas fa-newspaper" style="color:var(--primary);"></i> Quản Lý Tin Tức & Dịch Bệnh Thú Y Chính Thống</h2>
                <p style="color:#777; margin:5px 0 20px;">Đưa các bài viết từ Cục Thú y và cơ quan chuyên môn đến trang chủ khách hàng</p>
                
                <div class="table-container" style="max-width: 750px; margin-bottom: 25px;">
                    <h3>Đăng bài báo thú y mới</h3><br>
                    <div class="input-group"><label>Tiêu đề bài báo</label><input type="text" id="adm-news-title" placeholder="VD: Cảnh báo virus Parvo và cúm mùa mưa trên chó mèo"></div>
                    <div class="input-group">
                        <label>Phân loại tin tức</label>
                        <select id="adm-news-tag">
                            <option value="Cảnh Báo Dịch Bệnh">Cảnh Báo Dịch Bệnh (Khẩn cấp)</option>
                            <option value="Kiến Thức Y Tế">Kiến Thức Y Tế Chính Thống</option>
                            <option value="Bản Tin PetCare">Bản Tin PetCare</option>
                        </select>
                    </div>
                    <div class="input-group"><label>Nội dung chi tiết bài báo</label><textarea id="adm-news-content" rows="6" placeholder="Nhập phác đồ, triệu chứng, khuyến cáo của bác sĩ thú y..."></textarea></div>
                    <button class="btn-action btn-save" onclick="addAdminNews()"><i class="fas fa-upload"></i> ĐĂNG BÀI BÁO LÊN TRANG CHỦ</button>
                </div>

                <div class="table-container">
                    <h3>Danh sách bài báo đã đăng</h3><br>
                    <table>
                        <thead><tr><th>Ngày đăng</th><th>Phân loại</th><th>Tiêu đề bài báo</th><th>Thao tác</th></tr></thead>
                        <tbody id="adm-published-news-tbody"></tbody>
                    </table>
                </div>
            </section>

            <!-- 5. Báo cáo & thống kê định kỳ -->
            <section id="adm-statistics" class="view-section">
                <h2>Báo Cáo & Thống Kê Định Kỳ Theo Tháng</h2>
                <p style="color:#777; margin:5px 0 20px;">Tổng hợp số lượt khách, doanh thu và các vấn đề quan trọng cần giải quyết trong ngày</p>
                
                <div class="table-container" style="margin-bottom:25px; border-left:5px solid var(--accent);">
                    <h3 style="color:var(--accent);"><i class="fas fa-exclamation-circle"></i> Vấn đề quan trọng Admin cần xử lý trong ngày:</h3>
                    <ul style="padding-left:20px; color:#444; font-size:14px; line-height:2; margin-top:10px;">
                        <li><span class="badge badge-danger">Kho hàng</span> 2 mặt hàng (Vòng cổ phản quang, Thuốc bôi da Bio-Derma) đã xuống dưới định mức an toàn, cần ký duyệt nhập.</li>
                        <li><span class="badge badge-pending">Nhân sự</span> Phê duyệt tài khoản Bác sĩ mới: BS. Hoàng Kim Yến vào hệ thống.</li>
                        <li><span class="badge badge-info">Khách hàng</span> 3 lượt đặt phòng khách sạn VIP dịp cuối tuần cần kiểm tra camera buồng lưu.</li>
                    </ul>
                </div>

                <div class="card-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom:25px;">
                    <div class="pet-card">
                        <h3>Cơ cấu Dịch vụ Spa (45%)</h3>
                        <div class="pie-chart-circle" style="background: conic-gradient(var(--primary) 0% 45%, #eee 45% 100%);">
                            <span class="pie-chart-val">45%</span>
                        </div>
                        <small style="color:#777;">Đóng góp doanh thu cao nhất</small>
                    </div>
                    <div class="pet-card">
                        <h3>Cơ cấu Y tế & Khám (35%)</h3>
                        <div class="pie-chart-circle" style="background: conic-gradient(var(--secondary) 0% 35%, #eee 35% 100%);">
                            <span class="pie-chart-val">35%</span>
                        </div>
                        <small style="color:#777;">Tỷ lệ tái khám đạt 85%</small>
                    </div>
                    <div class="pet-card">
                        <h3>Bán lẻ Pet Shop (20%)</h3>
                        <div class="pie-chart-circle" style="background: conic-gradient(var(--warning) 0% 20%, #eee 20% 100%);">
                            <span class="pie-chart-val">20%</span>
                        </div>
                        <small style="color:#777;">Hạt & Phụ kiện bán lẻ</small>
                    </div>
                </div>

                <div class="table-container">
                    <h3>Thống kê lượt khách & Doanh thu dịch vụ định kỳ</h3><br>
                    <table>
                        <thead><tr><th>Tháng / Năm</th><th>Số lượt khách dùng dịch vụ</th><th>Số đơn mua sắm</th><th>Doanh thu dịch vụ</th><th>Tổng doanh thu</th></tr></thead>
                        <tbody id="adm-monthly-stats-tbody"></tbody>
                    </table>
                </div>
            </section>

            <!-- 6. Hộp thư (Mặc định chưa đọc, có nút đánh dấu đã đọc) -->
            <section id="adm-inbox" class="view-section">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                    <h2><i class="fas fa-envelope-open-text" style="color:var(--primary);"></i> Hộp Thư Thông Báo Khẩn Cấp</h2>
                    <button class="btn-action" style="background:#e8f0fe; color:var(--primary);" onclick="markAllNotificationsAsRead()"><i class="fas fa-check-double"></i> Đánh dấu tất cả đã đọc</button>
                </div>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Thời gian</th><th>Loại sự kiện</th><th>Nội dung thông báo</th><th>Trạng thái</th><th>Hành động</th></tr></thead>
                        <tbody id="adm-inbox-table-tbody"></tbody>
                    </table>
                </div>
            </section>

            <!-- 7. Check-in / Check-out (Tách riêng) -->
            <section id="adm-attendance" class="view-section">
                <h2><i class="fas fa-user-clock" style="color:var(--primary);"></i> Chấm Công Check-in / Check-out & Giám Sát Ca Làm</h2><br>
                
                <div class="card-grid">
                    <div class="pet-card">
                        <i class="fas fa-business-time fa-2x" style="color:var(--primary); margin-bottom:8px;"></i>
                        <h3>Trạng thái ca làm việc</h3>
                        <p id="adm-checkin-status" style="font-size:22px; color:var(--success); font-weight:bold; margin: 10px 0;">ĐÃ CHECK-IN</p>
                        <small id="adm-checkin-time-display">Giờ vào: 08:00:00</small>
                        <p id="adm-late-fine-display" style="color:var(--accent); font-weight:bold; font-size:13px; margin-top:6px;"></p>
                        <div style="margin-top:15px;">
                            <button class="btn-action" style="background:#ffebeb; color:var(--accent);" onclick="checkoutAdminManual()"><i class="fas fa-sign-out-alt"></i> CHECK-OUT KẾT THÚC CA</button>
                        </div>
                    </div>

                    <div class="pet-card">
                        <i class="fas fa-shield-alt fa-2x" style="color:var(--secondary); margin-bottom:8px;"></i>
                        <h3>Quy định chấm công PetCare</h3>
                        <p style="color:#555; font-size:13.5px; line-height:1.7; margin-top:10px;">
                            - Ca làm việc chuẩn: <strong>08:00 - 17:00</strong><br>
                            - Đi trễ sau 08:00: <strong>Tự động trừ 1.000 VNĐ / phút (Demo)</strong><br>
                            - Dữ liệu check-in/out được lưu trữ an toàn.
                        </p>
                    </div>
                </div>

                <div class="table-container" style="margin-top: 25px;">
                    <h3>Lịch sử chấm công & Địa chỉ IP truy cập</h3><br>
                    <table>
                        <thead><tr><th>Thời gian</th><th>Tài khoản cán bộ</th><th>Hành động</th><th>Địa chỉ IP</th><th>Chi tiết</th></tr></thead>
                        <tbody id="adm-security-logs-tbody"></tbody>
                    </table>
                </div>
            </section>

            <!-- ================= CÁC SECTION DÀNH CHO NHÂN VIÊN TƯ VẤN (ADVISOR) ================= -->
            
            <!-- Danh sách khách hàng: Cấp cứu -> Khẩn cấp -> Bình thường -->
            <section id="adv-cust-list" class="view-section">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
                    <h2><i class="fas fa-users-line" style="color:var(--primary);"></i> Danh Sách Khách Hàng Chờ Tư Vấn</h2>
                    <span class="badge badge-info"><i class="fas fa-sort-amount-down"></i> Thứ tự ưu tiên: Cấp cứu $\rightarrow$ Khẩn cấp $\rightarrow$ Khách thường</span>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Mức độ ưu tiên</th>
                                <th>Khách hàng</th>
                                <th>Số điện thoại</th>
                                <th>Bé cưng</th>
                                <th>Vấn đề cần tư vấn</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="adv-priority-clients-tbody"></tbody>
                    </table>
                </div>
            </section>

            <section id="adv-pet-profiles" class="view-section">
                <h2>Thông tin hồ sơ thú cưng khách hàng</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Tên bé</th><th>Giống loài</th><th>Chủ nuôi</th><th>Đặc điểm / Dị ứng</th><th>Tình trạng sức khỏe</th></tr></thead>
                        <tbody>
                            <tr>
                                <td><strong>Bé Lu</strong></td>
                                <td>Corgi</td>
                                <td>Nguyễn Văn A</td>
                                <td>Dị ứng thức ăn có bột mì, nhát người lạ</td>
                                <td><span class="badge badge-success">Khỏe mạnh</span></td>
                            </tr>
                            <tr>
                                <td><strong>Bé Miu</strong></td>
                                <td>Mèo Anh Lông Ngắn</td>
                                <td>Trần Hương</td>
                                <td>Hay bị nấm kẽ móng</td>
                                <td><span class="badge badge-pending">Đang theo dõi</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Lịch sử dịch vụ: Đánh giá không bắt buộc -->
            <section id="adv-history" class="view-section">
                <h2>Lịch sử dịch vụ khách đã dùng</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Thời gian</th><th>Khách hàng</th><th>Bé thú cưng</th><th>Dịch vụ đã thực hiện</th><th>Ghi chú</th><th>Đánh giá của khách</th></tr></thead>
                        <tbody id="adv-history-tbody"></tbody>
                    </table>
                </div>
            </section>

            <!-- Gợi ý gói (Bấm nút gửi vào chat) -->
            <section id="adv-suggest-pkg" class="view-section">
                <h2>Gợi ý gói dịch vụ phù hợp cho khách</h2><br>
                <div class="card-grid">
                    <div class="pet-card">
                        <h3>Gói Toàn Diện Cún Con</h3>
                        <p style="color:var(--primary); font-weight:bold; margin:8px 0;">450.000 VNĐ</p>
                        <p style="font-size:13px; color:#666;">Tiêm phòng 7 bệnh + Tẩy giun + Tắm thảo mộc khử khuẩn</p>
                        <button class="btn-action btn-save" onclick="sendServiceToChat('Gói Toàn Diện Cún Con', 450000)"><i class="fas fa-paper-plane"></i> Gửi Gói Này Vào Chat</button>
                    </div>
                    <div class="pet-card">
                        <h3>Gói Chăm Sóc Da & Lông Mèo</h3>
                        <p style="color:var(--primary); font-weight:bold; margin:8px 0;">380.000 VNĐ</p>
                        <p style="font-size:13px; color:#666;">Ủ bùn phục hồi nang lông + Vệ sinh tai nấm + Tỉa móng</p>
                        <button class="btn-action btn-save" onclick="sendServiceToChat('Gói Chăm Sóc Da & Lông Mèo', 380000)"><i class="fas fa-paper-plane"></i> Gửi Gói Này Vào Chat</button>
                    </div>
                </div>
            </section>

            <!-- Giới thiệu sản phẩm (Bấm nút gửi vào chat) -->
            <section id="adv-petshop-intro" class="view-section">
                <h2>Giới thiệu sản phẩm Pet Shop (Bấm gửi vào Khung Chat)</h2><br>
                <div class="card-grid" id="adv-petshop-intro-grid"></div>
            </section>

            <!-- Tạo đơn nhanh & Xuất hóa đơn VAT -->
            <section id="adv-quick-quote" class="view-section">
                <h2><i class="fas fa-file-invoice-dollar" style="color:var(--success);"></i> Lên Đơn Hàng Nhanh & Xuất Hóa Đơn VAT</h2><br>
                <div class="table-container" style="max-width:700px; margin:0 auto;">
                    <div class="input-group">
                        <label>Khách hàng nhận đơn</label>
                        <input type="text" id="order-cust-name" value="Nguyễn Văn A">
                    </div>
                    <div class="input-group">
                        <label>Chọn sản phẩm / dịch vụ</label>
                        <select id="order-item-select" onchange="calcVatTotal()">
                            <option value="Hạt Royal Canin Corgi" data-price="320000">Hạt Royal Canin Corgi - 320.000 VNĐ</option>
                            <option value="Gói Cắt tỉa tạo kiểu lông" data-price="300000">Gói Cắt tỉa tạo kiểu lông - 300.000 VNĐ</option>
                            <option value="Xịt khử mùi Bio-Clean" data-price="110000">Xịt khử mùi Bio-Clean - 110.000 VNĐ</option>
                        </select>
                    </div>
                    <div style="display:flex; gap:15px;">
                        <div class="input-group" style="flex:1;">
                            <label>Số lượng</label>
                            <input type="number" id="order-qty" value="1" min="1" onchange="calcVatTotal()">
                        </div>
                        <div class="input-group" style="flex:1;">
                            <label>Thuế suất VAT (%)</label>
                            <select id="order-vat-rate" onchange="calcVatTotal()">
                                <option value="0.08">8% (Thuế suất ưu đãi)</option>
                                <option value="0.10">10% (Thuế suất chuẩn)</option>
                            </select>
                        </div>
                    </div>

                    <div class="vat-invoice-preview" style="background:#faf9ff; border:1px dashed var(--primary); border-radius:12px; padding:15px; margin-bottom:15px; font-size:13.5px; line-height:1.7;">
                        <p>Tiền hàng trước thuế: <strong id="inv-subtotal">320.000 VNĐ</strong></p>
                        <p>Tiền thuế VAT: <strong id="inv-vat-amount" style="color:var(--accent);">25.600 VNĐ</strong></p>
                        <p style="font-size:16px;">Tổng cộng thanh toán (VAT): <strong id="inv-grand-total" style="color:var(--primary);">345.600 VNĐ</strong></p>
                    </div>

                    <div style="display:flex; gap:10px;">
                        <button class="btn-action" style="background:#e8f0fe; color:var(--primary); flex:1;" onclick="printVatInvoice()"><i class="fas fa-print"></i> In Hóa Đơn VAT</button>
                        <button class="btn-action btn-save" style="flex:2; margin:0;" onclick="submitFastOrderWithVat()"><i class="fas fa-paper-plane"></i> Tạo Đơn & Bắn Thông Báo</button>
                    </div>
                </div>
            </section>

            <section id="adv-view-appts" class="view-section">
                <h2>Lịch hẹn khách hàng đặt (Tư vấn theo dõi)</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Mã hẹn</th><th>Khách hàng</th><th>Dịch vụ</th><th>Thời gian</th><th>Trạng thái</th></tr></thead>
                        <tbody id="adv-appts-tbody"></tbody>
                    </table>
                </div>
            </section>

            <section id="adv-create-appt" class="view-section">
                <h2>Đặt lịch mới theo yêu cầu của khách</h2><br>
                <div class="table-container" style="max-width:550px;">
                    <div class="input-group"><label>Khách hàng</label><input type="text" id="adv-book-cust" placeholder="Nguyễn Văn A"></div>
                    <div class="input-group"><label>Dịch vụ yêu cầu</label><input type="text" id="adv-book-svc" placeholder="Spa & Cắt tỉa lông"></div>
                    <div class="input-group"><label>Thời gian hẹn</label><input type="datetime-local" id="adv-book-time"></div>
                    <button class="btn-login" onclick="submitAdvisorBookingForClient()">LƯU LỊCH HẸN & BÁO CHĂM SÓC</button>
                </div>
            </section>

            <section id="adv-orders-track" class="view-section">
                <h2>Theo dõi đơn hàng khách đặt</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Mã đơn</th><th>Khách hàng</th><th>Sản phẩm</th><th>Tổng tiền</th><th>Thanh toán</th><th>Trạng thái giao</th></tr></thead>
                        <tbody id="adv-orders-tbody"></tbody>
                    </table>
                </div>
            </section>

            <section id="adv-payment-support" class="view-section">
                <h2>Hỗ trợ thanh toán & Xác nhận giao dịch (Thu ngân)</h2><br>
                <div class="table-container">
                    <p><i class="fas fa-check-circle" style="color:var(--success);"></i> Nhân viên tư vấn kiêm nhiệm thu ngân có thể tra cứu nhanh toàn bộ biến động tiền mặt & quét mã QR.</p>
                </div>
            </section>

            <!-- Báo cáo: Cần tư vấn -> Đang tư vấn -> Đã tư vấn -->
            <section id="adv-report-clients" class="view-section">
                <h2>Báo cáo số lượng khách hàng tư vấn trong ngày</h2><br>
                <div class="card-grid" style="grid-template-columns: repeat(3, 1fr);">
                    <div class="pet-card">
                        <h3>Khách cần tư vấn</h3>
                        <p id="kpi-adv-need" style="font-size:28px; color:var(--accent); font-weight:bold; margin:10px 0;">3 khách</p>
                        <small>Cấp cứu & Khẩn cấp ưu tiên</small>
                    </div>
                    <div class="pet-card">
                        <h3>Đang được tư vấn</h3>
                        <p id="kpi-adv-doing" style="font-size:28px; color:var(--primary); font-weight:bold; margin:10px 0;">1 khách</p>
                        <small>Đang mở khung chat</small>
                    </div>
                    <div class="pet-card">
                        <h3>Đã hoàn tất tư vấn</h3>
                        <p id="kpi-adv-done" style="font-size:28px; color:var(--success); font-weight:bold; margin:10px 0;">18 khách</p>
                        <small>Khách đã bấm kết thúc</small>
                    </div>
                </div>
            </section>

            <section id="adv-report-rate" class="view-section">
                <h2>Hiệu quả tư vấn & Tỷ lệ chốt dịch vụ</h2><br>
                <div class="card-grid" style="grid-template-columns: repeat(3, 1fr);">
                    <div class="pet-card">
                        <h3>Tỷ lệ tư vấn thành công</h3>
                        <div class="pie-chart-circle" style="background: conic-gradient(var(--success) 0% 84%, #eee 84% 100%);">
                            <span class="pie-chart-val">84%</span>
                        </div>
                    </div>
                    <div class="pet-card">
                        <h3>Tỷ lệ đặt lịch</h3>
                        <div class="pie-chart-circle" style="background: conic-gradient(var(--primary) 0% 65%, #eee 65% 100%);">
                            <span class="pie-chart-val">65%</span>
                        </div>
                    </div>
                    <div class="pet-card">
                        <h3>Tỷ lệ đặt mua hàng</h3>
                        <div class="pie-chart-circle" style="background: conic-gradient(var(--warning) 0% 48%, #eee 48% 100%);">
                            <span class="pie-chart-val">48%</span>
                        </div>
                    </div>
                </div>
            </section>

            <section id="adv-report-reviews" class="view-section">
                <h2>Đánh giá từ khách hàng & Trả lời tự động</h2><br>
                <div class="table-container">
                    <div style="background:#fffdf5; padding:12px; border-radius:10px; margin-bottom:15px; border-left:4px solid var(--warning);">
                        <i class="fas fa-robot"></i> <strong>Tính năng trả lời tự động:</strong> Khi tư vấn viên bận, hệ thống tự động gửi lời cảm ơn khách hàng.
                    </div>
                    <div id="adv-reviews-reply-container"></div>
                </div>
            </section>

            <section id="adv-promos-update" class="view-section">
                <h2>Cập nhật ưu đãi & Gói dịch vụ mới để tư vấn</h2><br>
                <div class="card-grid" id="adv-promos-grid"></div>
            </section>

            <section id="adv-member-club" class="view-section">
                <h2>Chính sách Khách Hàng Thân Thiết (4 Hạng thẻ)</h2><br>
                <div class="table-container">
                    <p>4 Hạng thẻ: <strong>Đồng (0đ)</strong> - <strong>Bạc (2tr)</strong> - <strong>Vàng (5tr)</strong> - <strong>Đen Vàng (10tr)</strong>.</p>
                </div>
            </section>

            <section id="adv-attendance" class="view-section">
                <h2>Chấm Công Check-in / Check-out (Tư vấn viên)</h2><br>
                <div class="card-grid">
                    <div class="pet-card">
                        <h3>Trạng thái ca làm việc</h3>
                        <p id="adv-checkin-status" style="font-size:22px; color:var(--success); font-weight:bold; margin:10px 0;">ĐÃ CHECK-IN</p>
                        <small id="adv-checkin-time-display">Giờ vào: 08:00:00</small>
                        <p id="adv-late-fine-display" style="color:var(--accent); font-weight:bold; font-size:13px; margin-top:6px;"></p>
                    </div>
                </div>
            </section>

            <!-- ================= CÁC SECTION DÀNH CHO NHÂN VIÊN CHĂM SÓC (STAFF) ================= -->
            
            <section id="care-view-pets" class="view-section">
                <h2>Hồ sơ khách mang đến hôm nay (Nhân viên chăm sóc)</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Ảnh</th><th>Tên thú cưng</th><th>Giống loài</th><th>Chủ nuôi</th><th>Số điện thoại</th><th>Xem chi tiết</th></tr></thead>
                        <tbody id="staff-pets-tbody"></tbody>
                    </table>
                </div>
            </section>

            <!-- HỒ SƠ CHỜ DUYỆT (Gộp Lịch hẹn & Đơn hàng, 4 trạng thái, thông báo khách) -->
            <section id="care-appts-pending" class="view-section">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                    <h2><i class="fas fa-clipboard-check" style="color:var(--primary);"></i> Hồ Sơ Chờ Duyệt (Lịch Hẹn & Đơn Hàng)</h2>
                    <span class="badge badge-info">Thông báo tự động gửi về khách hàng khi đổi trạng thái</span>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Mã HS</th>
                                <th>Nguồn tiếp nhận</th>
                                <th>Bé cưng (Chủ nuôi)</th>
                                <th>Nội dung yêu cầu</th>
                                <th>Thời gian hẹn</th>
                                <th>Trạng thái hồ sơ</th>
                                <th>Cập nhật trạng thái</th>
                            </tr>
                        </thead>
                        <tbody id="care-pending-records-tbody"></tbody>
                    </table>
                </div>
            </section>

            <!-- Cập nhật tình trạng sau chăm sóc (Tự động điền chủ & liên lạc theo bé) -->
            <section id="care-health-notes" class="view-section">
                <h2><i class="fas fa-notes-medical" style="color:var(--primary);"></i> Cập Nhật Tình Trạng Sau Chăm Sóc</h2><br>
                <div class="table-container" style="max-width:650px; margin:0 auto;">
                    <div class="input-group">
                        <label>Chọn bé thú cưng (Từ danh sách đã duyệt)</label>
                        <select id="care-select-pet" onchange="autoFillOwnerInfo()">
                            <!-- Nạp qua JS -->
                        </select>
                    </div>
                    <div style="display:flex; gap:15px;">
                        <div class="input-group" style="flex:1;">
                            <label>Chủ nuôi</label>
                            <input type="text" id="care-owner-name" readonly style="background:#f4f7f6;">
                        </div>
                        <div class="input-group" style="flex:1;">
                            <label>Số điện thoại liên lạc</label>
                            <input type="text" id="care-owner-phone" readonly style="background:#f4f7f6;">
                        </div>
                    </div>
                    <div class="input-group">
                        <label>Tình trạng thể trạng sau ca chăm sóc</label>
                        <textarea id="care-result-note" rows="3" placeholder="Lông sạch tơi thơm tho, tai khô thoáng, mài móng bo tròn..."></textarea>
                    </div>
                    <div class="input-group">
                        <label>Lịch hẹn thăm khám / Chăm sóc lần sau (Nếu còn bệnh/cần tái khám)</label>
                        <input type="date" id="care-next-date">
                    </div>
                    <button class="btn-login" onclick="saveCareResultRecord()"><i class="fas fa-save"></i> LƯU & BẮN THÔNG BÁO CHO CHỦ</button>
                </div>
            </section>

            <!-- 3 phân luồng dịch vụ -->
            <section id="care-spa-action" class="view-section">
                <h2><i class="fas fa-bath" style="color:var(--primary);"></i> Phân Luồng Dịch Vụ Spa Thú Cưng</h2><br>
                <div class="table-container">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                        <h3>Danh sách bé chờ Spa hôm nay</h3>
                        <button class="btn-action" style="background:#ffebeb; color:var(--accent);" onclick="callEmergencySpa()"><i class="fas fa-phone-volume"></i> Gọi KTV Spa Khẩn Cấp</button>
                    </div>
                    <table>
                        <thead><tr><th>Bé cưng</th><th>Gói Spa</th><th>Ghi chú chú ý đặc biệt cho KTV</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
                        <tbody id="care-spa-records-tbody"></tbody>
                    </table>
                </div>
            </section>

            <section id="care-grooming-action" class="view-section">
                <h2><i class="fas fa-cut" style="color:var(--primary);"></i> Phân Luồng Cắt Tỉa & Grooming</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Bé cưng</th><th>Yêu cầu tạo kiểu của khách</th><th>Lưu ý khi cắt tỉa</th><th>Hoàn thành</th></tr></thead>
                        <tbody id="care-grooming-records-tbody"></tbody>
                    </table>
                </div>
            </section>

            <section id="care-hotel-action" class="view-section">
                <h2><i class="fas fa-hotel" style="color:var(--primary);"></i> Quản Lý Lưu Trú Khách Sạn Thú Cưng (Liên Kết Ngoài)</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Bé cưng</th><th>Hạng phòng</th><th>Lịch trình gói</th><th>Lễ tân khách sạn phụ trách</th><th>Trạng thái phòng</th></tr></thead>
                        <tbody id="care-hotel-records-tbody"></tbody>
                    </table>
                </div>
            </section>

            <!-- Bán hàng: Tại quầy & Online -->
            <section id="care-sales-pos" class="view-section">
                <h2>Bán hàng tại quầy Pet Shop</h2><br>
                <div class="table-container" style="max-width:600px;">
                    <div class="input-group"><label>Chọn sản phẩm</label><select id="pos-product-select" onchange="calcPosTotal()"></select></div>
                    <div class="input-group"><label>Số lượng</label><input type="number" id="pos-qty" min="1" value="1" onchange="calcPosTotal()"></div>
                    <div class="input-group"><label>Hình thức thanh toán</label><select id="pos-payment-method"><option>Tiền mặt</option><option>Chuyển khoản QR</option></select></div>
                    <p style="margin:10px 0;">Tổng tiền: <strong id="pos-total-display" style="color:var(--primary); font-size:20px;">0 VNĐ</strong></p>
                    <button class="btn-login" onclick="createStaffOrder()"><i class="fas fa-cart-arrow-down"></i> TẠO ĐƠN TẠI QUẦY</button>
                </div>
            </section>

            <section id="care-sales-online" class="view-section">
                <h2>Danh sách đơn hàng đặt Online của khách</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Mã đơn</th><th>Khách hàng</th><th>Mặt hàng</th><th>Tổng tiền</th><th>Trạng thái</th></tr></thead>
                        <tbody id="care-online-orders-tbody"></tbody>
                    </table>
                </div>
            </section>

            <!-- Kho chia Kiểm tra hàng tồn & Báo cáo hàng tổng -->
            <section id="care-stock-check" class="view-section">
                <h2><i class="fas fa-boxes" style="color:var(--primary);"></i> Kiểm Tra Hàng Tồn Kho Thực Tế</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Tên mặt hàng</th><th>Số lượng tồn</th><th>Đơn vị</th><th>Cập nhật số lượng</th><th>Tình trạng</th><th>Lưu</th></tr></thead>
                        <tbody id="care-editable-stock-tbody"></tbody>
                    </table>
                </div>
            </section>

            <section id="care-stock-report" class="view-section">
                <h2><i class="fas fa-file-signature" style="color:var(--primary);"></i> Báo Cáo Hàng Tổng & Đề Xuất Bổ Sung</h2><br>
                <div style="display:flex; gap:20px; flex-wrap:wrap;">
                    <div class="table-container" style="flex:1; min-width:320px;">
                        <h3>Báo cáo mặt hàng đã đầy đủ (Chưa cần nhập)</h3><br>
                        <table>
                            <thead><tr><th>Mặt hàng</th><th>Số lượng</th><th>Trạng thái</th></tr></thead>
                            <tbody id="care-full-stock-tbody"></tbody>
                        </table>
                    </div>
                    <div class="table-container" style="flex:1; min-width:320px;">
                        <h3><i class="fas fa-bell" style="color:var(--accent);"></i> Đề xuất nhập thêm hàng (Messenger Alert)</h3><br>
                        <div class="input-group"><label>Mặt hàng cần nhập</label><input type="text" id="care-prop-name" placeholder="Ví dụ: Bùn khoáng nóng Spa"></div>
                        <div class="input-group"><label>Số lượng đề xuất</label><input type="number" id="care-prop-qty" value="10"></div>
                        <div class="input-group"><label>Lý do cấp bách</label><input type="text" id="care-prop-reason" placeholder="Khách đặt kín lịch tuần sau"></div>
                        <button class="btn-action btn-save" onclick="sendStockAlertToManager()"><i class="fas fa-paper-plane"></i> Gửi Đề Xuất (Bắn Thông Báo)</button>
                    </div>
                </div>
            </section>

            <!-- Báo cáo cá nhân: Xem chi tiết dịch vụ & lịch tái khám -->
            <section id="care-my-kpi" class="view-section">
                <h2>Số lượng ca chăm sóc đã hoàn thành</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Mã ca</th><th>Bé thú cưng</th><th>Chủ nuôi</th><th>Dịch vụ hoàn thành</th><th>Thời gian</th><th>Có lịch tái khám tiếp?</th></tr></thead>
                        <tbody id="care-completed-details-tbody"></tbody>
                    </table>
                </div>
            </section>

            <section id="care-reviews-reply" class="view-section">
                <h2><i class="fas fa-reply-all" style="color:var(--primary);"></i> Phản Hồi Đánh Giá Khách Hàng (Nhân viên chăm sóc)</h2>
                <p style="color:#777; margin:5px 0 20px;">Lắng nghe và gửi lời cảm ơn/giải đáp đến khách hàng sau ca dịch vụ</p>
                <div id="staff-reviews-reply-container" style="display:flex; flex-direction:column; gap:16px;"></div>
            </section>

            <!-- Hiệu quả công việc thống kê 1 tháng, tự động đổi tháng mới -->
            <section id="care-performance" class="view-section">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                    <h2><i class="fas fa-chart-line" style="color:var(--success);"></i> Bảng Hiệu Quả Công Việc (Tự Động Đổi Theo Tháng)</h2>
                    <span class="badge badge-info" id="care-current-month-badge">Tháng 9/2026</span>
                </div>
                <div class="card-grid" style="grid-template-columns: repeat(5, 1fr); margin-bottom:25px;">
                    <div class="pet-card">
                        <h4>Lượt Dịch Vụ</h4>
                        <p style="font-size:24px; color:var(--primary); font-weight:bold; margin:6px 0;" id="kpi-spa-count">48</p>
                        <small style="color:var(--success);"><i class="fas fa-arrow-up"></i> +12%</small>
                    </div>
                    <div class="pet-card">
                        <h4>Lượt Khách Sạn</h4>
                        <p style="font-size:24px; color:var(--secondary); font-weight:bold; margin:6px 0;" id="kpi-hotel-count">19</p>
                        <small style="color:var(--success);"><i class="fas fa-arrow-up"></i> +5%</small>
                    </div>
                    <div class="pet-card">
                        <h4>Bán Pet Shop</h4>
                        <p style="font-size:24px; color:var(--warning); font-weight:bold; margin:6px 0;" id="kpi-sales-count">62</p>
                        <small style="color:var(--success);"><i class="fas fa-arrow-up"></i> +18%</small>
                    </div>
                    <div class="pet-card">
                        <h4>Lượt Đánh Giá</h4>
                        <p style="font-size:24px; color:#e17055; font-weight:bold; margin:6px 0;" id="kpi-review-count">35</p>
                        <small>⭐⭐⭐⭐⭐</small>
                    </div>
                    <div class="pet-card">
                        <h4>Lượt Ghé Thăm</h4>
                        <p style="font-size:24px; color:#0984e3; font-weight:bold; margin:6px 0;" id="kpi-visit-count">154</p>
                        <small style="color:var(--success);"><i class="fas fa-arrow-up"></i> +25%</small>
                    </div>
                </div>
            </section>

            <section id="care-promos-view" class="view-section">
                <h2>Chương trình ưu đãi Spa / Grooming đang áp dụng</h2><br>
                <div class="card-grid" id="care-promos-grid"></div>
            </section>

            <section id="care-attendance" class="view-section">
                <h2>Chấm Công Check-in / Check-out (Nhân viên chăm sóc)</h2><br>
                <div class="card-grid">
                    <div class="pet-card">
                        <h3>Trạng thái ca làm việc</h3>
                        <p id="care-checkin-status" style="font-size:22px; color:var(--success); font-weight:bold; margin:10px 0;">ĐÃ CHECK-IN</p>
                        <small id="care-checkin-time-display">Giờ vào: 08:00:00</small>
                        <p id="care-late-fine-display" style="color:var(--accent); font-weight:bold; font-size:13px; margin-top:6px;"></p>
                    </div>
                </div>
            </section>

            <!-- ================= CÁC SECTION DÀNH CHO BÁC SĨ TRỰC THUỘC (DOCTOR) ================= -->
            <section id="doc-daily-exams" class="view-section">
                <h2>Danh sách lịch hẹn khám trong ngày (Bác sĩ thú y)</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Mã hẹn</th><th>Bé</th><th>Chủ nuôi</th><th>Thời gian</th><th>Lý do khám</th><th>Thao tác</th></tr></thead>
                        <tbody>
                            <tr>
                                <td>#LH201</td>
                                <td><strong>Bé Lu</strong></td>
                                <td>Nguyễn Văn A</td>
                                <td>09:30</td>
                                <td>Tái khám dị ứng da</td>
                                <td><button class="btn-action btn-save" onclick="switchTab('doc-execute-exam', null)">Tiến hành khám</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="doc-execute-exam" class="view-section">
                <h2>Thực hiện khám & Ghi nhận kết quả lâm sàng</h2><br>
                <div class="table-container" style="max-width:650px;">
                    <div class="input-group"><label>Bé khám</label><input type="text" value="Bé Lu (Corgi)"></div>
                    <div class="input-group"><label>Triệu chứng & Khám lâm sàng</label><textarea rows="3" placeholder="Thân nhiệt 38.5°C, da vùng bụng bớt đỏ, không có ve rận."></textarea></div>
                    <div class="input-group"><label>Chẩn đoán xác định</label><input type="text" placeholder="Viêm da tiếp xúc giai đoạn hồi phục"></div>
                    <button class="btn-login" onclick="showToast('Đã lưu kết quả khám lâm sàng!')">LƯU KẾT QUẢ KHÁM</button>
                </div>
            </section>

            <section id="doc-health-update" class="view-section">
                <h2>Cập nhật tình trạng sức khoẻ thú cưng</h2><br>
                <div class="table-container" style="max-width:550px;">
                    <div class="input-group"><label>Cân nặng (kg)</label><input type="number" step="0.1" value="11.5"></div>
                    <div class="input-group"><label>Thân nhiệt (°C)</label><input type="number" step="0.1" value="38.5"></div>
                    <button class="btn-login" onclick="showToast('Đã cập nhật thể trạng của bé!')">CẬP NHẬT THỂ TRẠNG</button>
                </div>
            </section>

            <section id="doc-create-emr" class="view-section">
                <h2>Tạo mới bệnh án điện tử</h2><br>
                <div class="table-container" style="max-width:650px;">
                    <div class="input-group"><label>Mã bệnh án</label><input type="text" value="BA-2026-089" readonly></div>
                    <div class="input-group"><label>Tên bé cưng</label><input type="text" placeholder="Bé Lu"></div>
                    <div class="input-group"><label>Phác đồ điều trị</label><textarea rows="3" placeholder="Bôi Bio-Derma ngày 2 lần, kiêng tắm xà phòng hóa chất..."></textarea></div>
                    <button class="btn-login" onclick="showToast('Đã tạo mới bệnh án điện tử thành công!')">LƯU BỆNH ÁN</button>
                </div>
            </section>

            <section id="doc-view-emr" class="view-section">
                <h2>Xem và chỉnh sửa bệnh án cũ</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Mã BA</th><th>Bé</th><th>Ngày tạo</th><th>Bác sĩ</th><th>Chẩn đoán</th><th>Thao tác</th></tr></thead>
                        <tbody><tr><td>BA-2026-088</td><td>Bé Lu</td><td>15/05/2026</td><td>BS. Trần Nam</td><td>Viêm da dị ứng nhẹ</td><td><button class="btn-action" style="background:#e8f0fe; color:var(--primary);">Xem chi tiết</button></td></tr></tbody>
                    </table>
                </div>
            </section>

            <section id="doc-prescriptions" class="view-section">
                <h2>Kê đơn thuốc & Chỉ định xét nghiệm, tiêm phòng</h2><br>
                <div class="table-container" style="max-width:650px;">
                    <div class="input-group"><label>Đơn thuốc kê</label><input type="text" placeholder="Thuốc bôi Bio-Derma (x1 tuýp), Kháng histamine (x10 viên)"></div>
                    <div class="input-group"><label>Chỉ định xét nghiệm</label><input type="text" placeholder="Soi kính hiển vi tìm nấm da"></div>
                    <button class="btn-login" onclick="showToast('Đơn thuốc và chỉ định đã được lưu vào hồ sơ bé!')">XUẤT ĐƠN THUỐC</button>
                </div>
            </section>

            <section id="doc-my-appts" class="view-section">
                <h2>Xem lịch hẹn cá nhân của Bác sĩ</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Giờ hẹn</th><th>Bé thú cưng</th><th>Chủ nuôi</th><th>Loại ca</th></tr></thead>
                        <tbody><tr><td>14:00 Hôm nay</td><td>Bé Lu</td><td>Nguyễn Văn A</td><td>Tái khám định kỳ</td></tr></tbody>
                    </table>
                </div>
            </section>

            <section id="doc-re-exam" class="view-section">
                <h2>Đặt lịch tái khám cho thú cưng</h2><br>
                <div class="table-container" style="max-width:550px;">
                    <div class="input-group"><label>Bé thú cưng</label><input type="text" value="Bé Lu"></div>
                    <div class="input-group"><label>Ngày hẹn tái khám</label><input type="date"></div>
                    <div class="input-group"><label>Lời dặn</label><input type="text" placeholder="Nhớ mang theo sổ tiêm chủng"></div>
                    <button class="btn-login" onclick="showToast('Đã lên lịch tái khám cho bé thành công!')">LƯU LỊCH TÁI KHÁM</button>
                </div>
            </section>

            <section id="doc-tests-mgr" class="view-section">
                <h2>Quản lý danh sách xét nghiệm</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Mã XN</th><th>Bé</th><th>Loại xét nghiệm</th><th>Kết quả</th><th>Bác sĩ duyệt</th></tr></thead>
                        <tbody><tr><td>#XN09</td><td>Bé Lu</td><td>Soi nang lông da</td><td>Âm tính với ve rận</td><td>BS. Trần Nam</td></tr></tbody>
                    </table>
                </div>
            </section>

            <section id="doc-vaccine-tracker" class="view-section">
                <h2>Theo dõi lịch tiêm phòng vắc-xin</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Bé thú cưng</th><th>Loại vắc-xin</th><th>Mũi tiêm</th><th>Ngày tiêm</th><th>Ngày nhắc mũi tiếp</th></tr></thead>
                        <tbody><tr><td>Bé Lu</td><td>Vắc-xin 7 bệnh ngừa dại</td><td>Mũi 3</td><td>10/01/2026</td><td>10/01/2027</td></tr></tbody>
                    </table>
                </div>
            </section>

            <section id="doc-report-cases" class="view-section">
                <h2>Số ca khám đã thực hiện</h2><br>
                <div class="card-grid">
                    <div class="pet-card">
                        <h3>Ca khám tháng này</h3>
                        <p style="font-size:28px; color:var(--primary); font-weight:bold; margin:10px 0;">42 ca</p>
                        <small>Điều trị nội trú và ngoại trú</small>
                    </div>
                </div>
            </section>

            <section id="doc-report-rate" class="view-section">
                <h2>Hiệu quả điều trị khỏi bệnh</h2><br>
                <div class="card-grid">
                    <div class="pet-card">
                        <h3>Tỷ lệ khỏi bệnh dứt điểm</h3>
                        <div class="pie-chart-circle" style="background: conic-gradient(var(--success) 0% 92%, #eee 92% 100%);">
                            <span class="pie-chart-val">92%</span>
                        </div>
                    </div>
                </div>
            </section>

            <section id="doc-report-reviews" class="view-section">
                <h2>Đánh giá từ khách hàng dành cho bác sĩ</h2><br>
                <div class="table-container">
                    <p>⭐⭐⭐⭐⭐ - "Bác sĩ giải thích phác đồ rất cẩn thận, bé nhà mình hợp thuốc nên da hồi phục rất nhanh!"</p>
                </div>
            </section>

            <section id="doc-protocols" class="view-section">
                <h2>Hướng dẫn & Quy trình y tế tiêu chuẩn</h2><br>
                <div class="table-container">
                    <p><i class="fas fa-book-medical" style="color:var(--primary);"></i> Quy trình khử khuẩn đèn cực tím, vô trùng phòng mổ và bảo quản vắc-xin ở nhiệt độ 2 - 8°C.</p>
                </div>
            </section>

            <section id="doc-internal-notice" class="view-section">
                <h2>Thông báo nội bộ phòng khám</h2><br>
                <div class="table-container">
                    <p><i class="fas fa-bell" style="color:var(--accent);"></i> Lưu ý ca trực hội chẩn các ca bệnh hô hấp vào 16:30 Thứ Sáu hàng tuần.</p>
                </div>
            </section>

            <!-- ================= CÁC SECTION DÀNH CHO QUẢN LÝ CỬA HÀNG (MANAGER) ================= -->
            <section id="mgr-staff-list" class="view-section">
                <h2>Danh sách nhân viên cửa hàng</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Họ và tên</th><th>Vị trí</th><th>Email</th><th>Trạng thái ca</th></tr></thead>
                        <tbody>
                            <tr><td>Trần Thị Tư Vấn</td><td>Nhân Viên Tư Vấn</td><td>tuvan@petcare.com</td><td><span class="badge badge-success">Đang làm việc</span></td></tr>
                            <tr><td>Lê Văn Chăm Sóc</td><td>Nhân Viên Chăm Sóc</td><td>chamsoc@petcare.com</td><td><span class="badge badge-success">Đang làm việc</span></td></tr>
                            <tr><td>BS. Trần Nam</td><td>Bác Sĩ Trực Thuộc</td><td>bacsi@petcare.com</td><td><span class="badge badge-success">Đang làm việc</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="mgr-shifts" class="view-section">
                <h2>Phân công ca làm việc (08:00 - 17:00)</h2><br>
                <div class="table-container">
                    <p>Ca trực cố định 8h sáng đến 17h chiều. Hệ thống tự động chấm công phạt trễ 1.000đ/phút.</p>
                </div>
            </section>

            <section id="mgr-kpi-track" class="view-section">
                <h2>Theo dõi hiệu quả công việc nhân viên</h2><br>
                <div class="card-grid">
                    <div class="pet-card"><h3>Hiệu suất toàn cửa hàng</h3><p style="font-size:26px; color:var(--success); font-weight:bold; margin:10px 0;">95.4%</p></div>
                </div>
            </section>

            <section id="mgr-approve-pets" class="view-section">
                <h2>Duyệt hồ sơ thú cưng mới</h2><br>
                <div class="table-container">
                    <p><i class="fas fa-check-double" style="color:var(--success);"></i> Tất cả hồ sơ bé được duyệt tự động khi chủ nuôi hoàn tất đăng ký.</p>
                </div>
            </section>

            <section id="mgr-emr-view" class="view-section">
                <h2>Xem bệnh án điện tử toàn chi nhánh</h2><br>
                <div class="table-container">
                    <p>Quản lý có thể tra cứu nhanh bệnh án của mọi bé cưng điều trị tại cửa hàng.</p>
                </div>
            </section>

            <section id="mgr-history-view" class="view-section">
                <h2>Theo dõi lịch sử dịch vụ</h2><br>
                <div class="table-container">
                    <p>Lưu trữ đầy đủ hóa đơn và lịch sử spa, khám chữa bệnh 12 tháng gần nhất.</p>
                </div>
            </section>

            <section id="mgr-general-appts" class="view-section">
                <h2>Quản lý lịch hẹn chung của cửa hàng</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Mã hẹn</th><th>Bé</th><th>Dịch vụ</th><th>Thời gian</th><th>Điều phối</th></tr></thead>
                        <tbody id="mgr-appts-tbody"></tbody>
                    </table>
                </div>
            </section>

            <section id="mgr-dispatch" class="view-section">
                <h2>Điều phối Bác sĩ & Nhân viên chăm sóc</h2><br>
                <div class="table-container" style="max-width:550px;">
                    <div class="input-group"><label>Ca hẹn cần phân công</label><input type="text" value="#LH1029 - Cắt tỉa Teddy Bear"></div>
                    <div class="input-group"><label>Giao cho cán bộ</label><select><option>Lê Văn Chăm Sóc (KTV Grooming)</option><option>BS. Trần Nam (Bác Sĩ)</option></select></div>
                    <button class="btn-login" onclick="showToast('Đã điều phối nhân sự thành công!')">XÁC NHẬN PHÂN CÔNG</button>
                </div>
            </section>

            <section id="mgr-stock-check" class="view-section">
                <h2>Kiểm tra tồn kho cơ bản</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Mặt hàng</th><th>Tồn kho</th><th>Đơn vị</th><th>Cảnh báo</th></tr></thead>
                        <tbody id="mgr-stock-tbody"></tbody>
                    </table>
                </div>
            </section>

            <section id="mgr-stock-alerts" class="view-section">
                <h2>Báo cáo hết hàng & Đề xuất nhập thêm</h2><br>
                <div class="table-container">
                    <p><i class="fas fa-exclamation-triangle" style="color:var(--accent);"></i> 2 mặt hàng sắp hết: Vòng cổ phản quang (còn 6 cái), Thuốc Bio-Derma (còn 4 tuýp).</p>
                </div>
            </section>

            <section id="mgr-petshop-products" class="view-section">
                <h2>Quản lý sản phẩm Pet Shop</h2><br>
                <div class="table-container">
                    <p>Sản phẩm Pet Shop được đồng bộ trực tiếp từ kho trung tâm của Admin.</p>
                </div>
            </section>

            <section id="mgr-revenue-summary" class="view-section">
                <h2>Báo cáo doanh thu Ngày / Tuần / Tháng</h2><br>
                <div class="card-grid">
                    <div class="pet-card"><h3>Doanh thu hôm nay</h3><p style="font-size:26px; color:var(--success); font-weight:bold; margin:10px 0;">3.850.000 VNĐ</p></div>
                    <div class="pet-card"><h3>Doanh thu tuần này</h3><p style="font-size:26px; color:var(--primary); font-weight:bold; margin:10px 0;">24.200.000 VNĐ</p></div>
                </div>
            </section>

            <section id="mgr-invoices" class="view-section">
                <h2>Theo dõi hóa đơn & Thanh toán</h2><br>
                <div class="table-container">
                    <p>Tất cả hóa đơn thanh toán tiền mặt và chuyển khoản QR được lưu trữ số hóa.</p>
                </div>
            </section>

            <section id="mgr-service-costs" class="view-section">
                <h2>Báo cáo chi phí dịch vụ</h2><br>
                <div class="table-container">
                    <p>Chi phí điện lạnh, vật tư tiêu hao spa chiếm 18% tổng doanh thu.</p>
                </div>
            </section>

            <section id="mgr-stats-clients" class="view-section">
                <h2>Thống kê số lượng khách hàng & Thú cưng</h2><br>
                <div class="card-grid">
                    <div class="pet-card"><h3>Tổng chủ nuôi</h3><p style="font-size:26px; color:var(--primary); font-weight:bold; margin:10px 0;">185 khách</p></div>
                    <div class="pet-card"><h3>Tổng thú cưng</h3><p style="font-size:26px; color:var(--success); font-weight:bold; margin:10px 0;">240 bé</p></div>
                </div>
            </section>

            <section id="mgr-stats-services" class="view-section">
                <h2>Dịch vụ sử dụng nhiều nhất</h2><br>
                <div class="table-container">
                    <p><i class="fas fa-trophy" style="color:#f1c40f;"></i> Top 1: Cắt tỉa tạo kiểu Teddy Bear (chiếm 42% lượt đặt).</p>
                </div>
            </section>

            <section id="mgr-stats-staff-kpi" class="view-section">
                <h2>Hiệu quả nhân viên</h2><br>
                <div class="table-container">
                    <p>Đội ngũ cán bộ đạt tỷ lệ hoàn thành ca trực đúng giờ 98.5%.</p>
                </div>
            </section>

            <section id="mgr-promos-update" class="view-section">
                <h2>Cập nhật chương trình ưu đãi</h2><br>
                <div class="table-container">
                    <p>Xem và phổ biến chương trình khuyến mãi tháng của Admin cho nhân viên.</p>
                </div>
            </section>

            <section id="mgr-internal-news" class="view-section">
                <h2>Thông báo nội bộ cửa hàng</h2><br>
                <div class="table-container">
                    <p><i class="fas fa-bell" style="color:var(--primary);"></i> Nhắc nhở vệ sinh buồng sấy và kiểm kê kho vào cuối mỗi ca trực.</p>
                </div>
            </section>
        </main>
    </div>

    <!-- ==================== CÁC MODAL HỆ THỐNG ==================== -->

    <!-- MODAL 1: XEM CHI TIẾT HỒ SƠ BÉ KÈM CHỦ NUÔI & SĐT CHO NHÂN VIÊN CHĂM SÓC -->
    <div id="care-pet-detail-modal" class="modal-overlay">
        <div class="modal-content" style="max-width: 500px; text-align:center;">
            <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #eee; padding-bottom:10px; margin-bottom:15px;">
                <h3 style="color:var(--primary); margin:0;"><i class="fas fa-id-card"></i> Chi Tiết Hồ Sơ Bé Cưng</h3>
                <button onclick="closeModal('care-pet-detail-modal')" style="background:none; border:none; font-size:22px; cursor:pointer;">&times;</button>
            </div>
            
            <img id="detail-modal-pet-img" src="" style="width:100px; height:100px; border-radius:50%; object-fit:cover; border:3px solid var(--primary); margin-bottom:12px;">
            <h3 id="detail-modal-pet-name" style="margin-bottom:4px; font-size:20px;"></h3>
            <p id="detail-modal-pet-breed" style="color:#777; font-size:13.5px; margin-bottom:15px;"></p>

            <div style="background:#faf9ff; border:1px dashed var(--primary); border-radius:14px; padding:15px; text-align:left; font-size:13.5px; line-height:1.8; margin-bottom:20px;">
                <p><i class="fas fa-user" style="color:var(--primary); width:20px;"></i> <strong>Họ tên chủ nuôi:</strong> <span id="detail-modal-owner-name"></span></p>
                <p><i class="fas fa-phone-alt" style="color:var(--primary); width:20px;"></i> <strong>Số điện thoại:</strong> <span id="detail-modal-owner-phone" style="color:var(--accent); font-weight:bold;"></span></p>
                <p><i class="fas fa-history" style="color:var(--primary); width:20px;"></i> <strong>Dịch vụ gần nhất:</strong> <span id="detail-modal-last-service">Tắm sấy khử khuẩn thảo mộc</span></p>
                <p><i class="fas fa-exclamation-circle" style="color:var(--accent); width:20px;"></i> <strong>Lưu ý đặc biệt:</strong> <span id="detail-modal-notes">Bé nhát người lạ, cần thao tác nhẹ nhàng</span></p>
            </div>

            <div style="display:flex; gap:10px;">
                <button class="btn-action" style="flex:1;" onclick="closeModal('care-pet-detail-modal')">Đóng</button>
                <button class="btn-action btn-save" style="flex:1; margin:0;" onclick="callOwnerDirect()"><i class="fas fa-phone"></i> Gọi điện cho chủ</button>
            </div>
        </div>
    </div>

    <!-- MODAL 2: THÊM / SỬA TÀI KHOẢN (Admin) -->
    <div id="admin-user-modal" class="modal-overlay">
        <div class="modal-content">
            <h3 id="admin-user-modal-title" style="margin-bottom: 20px;">Cập nhật tài khoản</h3>
            <input type="hidden" id="adm-user-id">
            <div class="input-group"><label>Họ và tên</label><input type="text" id="adm-user-name"></div>
            <div class="input-group"><label>Email</label><input type="email" id="adm-user-email"></div>
            <div class="input-group">
                <label>Phân quyền vai trò</label>
                <select id="adm-user-role">
                    <option value="advisor">Nhân Viên Tư Vấn</option>
                    <option value="staff">Nhân Viên Chăm Sóc</option>
                    <option value="doctor">Bác Sĩ Trực Thuộc</option>
                    <option value="manager">Quản Lý Cửa Hàng</option>
                    <option value="admin">Quản Trị Viên (Admin)</option>
                </select>
            </div>
            <div style="display: flex; gap: 10px;">
                <button class="btn-action" style="flex:1" onclick="closeModal('admin-user-modal')">Hủy</button>
                <button class="btn-action btn-save" style="flex:2; margin:0" onclick="saveAdminUser()">Lưu thay đổi</button>
            </div>
        </div>
    </div>

    <!-- MODAL 3: THÊM / SỬA MẶT HÀNG HOẶC DỊCH VỤ -->
    <div id="admin-item-modal" class="modal-overlay">
        <div class="modal-content">
            <h3 id="admin-item-modal-title" style="margin-bottom: 20px;">Chỉnh sửa Mục</h3>
            <input type="hidden" id="adm-item-id">
            <div class="input-group"><label>Tên mục</label><input type="text" id="adm-item-name"></div>
            <div class="input-group">
                <label>Phân loại</label>
                <select id="adm-item-category">
                    <option value="Sản phẩm">Sản phẩm Pet Shop</option>
                    <option value="Mỹ phẩm">Mỹ phẩm Spa/Grooming</option>
                    <option value="Dịch vụ Spa">Dịch vụ Spa</option>
                    <option value="Khách sạn">Khách sạn thú cưng</option>
                </select>
            </div>
            <div class="input-group"><label>Đơn giá (VNĐ)</label><input type="number" id="adm-item-price"></div>
            <div style="display: flex; gap: 10px;">
                <button class="btn-action" style="flex:1" onclick="closeModal('admin-item-modal')">Hủy</button>
                <button class="btn-action btn-save" style="flex:2; margin:0" onclick="saveAdminItem()">Cập nhật</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const currentRole = localStorage.getItem('pc_logged_role') || 'admin';
            
            if (currentRole === 'customer') {
                window.location.replace("{{ url('/home') }}");
                return;
            }

            document.body.className = currentRole + '-mode hologram-fluid-body';

            if (localStorage.getItem('pc_show_login_success') === 'true') {
                showToast("Đăng nhập thành công vào bàn làm việc!");
                localStorage.removeItem('pc_show_login_success');
            }

            setupRoleDisplay(currentRole);
            refreshAllUI();
        });

        function logoutToAuth() {
            localStorage.removeItem('pc_logged_role');
            window.location.replace("{{ url('/login') }}");
        }
    </script>
</body>
</html>