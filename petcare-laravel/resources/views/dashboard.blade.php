<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare Pro - Cổng Quản Trị & Chuyên Môn</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
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

    <!-- KHUNG CHAT TƯ VẤN DÀNH CHO NHÂN VIÊN TƯ VẤN TIẾP NHẬN TIN NHẮN TỪ KHÁCH HÀNG -->
    <div id="advisor-live-chat-panel" class="advisor-chat-dock" style="display:none;">
        <div class="advisor-chat-header">
            <h4><i class="fas fa-headset"></i> Kênh Tiếp Nhận Tư Vấn Khách Hàng</h4>
            <span class="badge badge-success">Trực tuyến</span>
        </div>
        <div id="advisor-chat-stream" class="advisor-chat-body">
            <!-- Tin nhắn từ khách hàng hiển thị tại đây -->
        </div>
        <div class="advisor-chat-footer">
            <input type="text" id="advisor-reply-input" placeholder="Nhập câu trả lời tư vấn cho khách..." onkeypress="if(event.key==='Enter') sendAdvisorChatMessage()">
            <button class="btn-action btn-save" style="width:auto; margin:0;" onclick="sendAdvisorChatMessage()"><i class="fas fa-reply"></i> Gửi</button>
        </div>
    </div>

    <div id="main-page" class="page active">
        <aside class="sidebar holo-glass-sidebar">
            <h2 style="color: var(--primary); margin-bottom: 20px;"><i class="fas fa-shield-alt"></i> PETCARE PORTAL</h2>
            
            <div class="user-greeting-box">
                <img id="sidebar-user-avatar" src="https://i.pravatar.cc/100?img=11" class="user-greeting-avatar">
                <div class="user-greeting-text">
                    <!-- Chỉ hiển thị chức danh chuyên môn theo đúng yêu cầu -->
                    <h4 id="sidebar-greeting-name">Nhân viên chăm sóc</h4>
                    <small id="sidebar-user-role-badge">Bộ Phận Chuyên Trách</small>
                </div>
            </div>

            <!-- ================= CÁC BỘ MENU PHÂN QUYỀN RIÊNG BIỆT ================= -->

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
                    <li class="submenu-item" onclick="switchTab('adv-quick-quote', this)"><i class="fas fa-calculator"></i> Tạo báo giá nhanh cho khách</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-adv-appts', this)">
                    <i class="fas fa-calendar-check"></i> Lịch hẹn
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-adv-appts" class="submenu">
                    <li class="submenu-item" onclick="switchTab('adv-view-appts', this)"><i class="fas fa-calendar-alt"></i> Xem lịch hẹn của khách</li>
                    <li class="submenu-item" onclick="switchTab('adv-create-appt', this)"><i class="fas fa-plus-circle"></i> Đặt lịch mới theo yêu cầu</li>
                    <li class="submenu-item" onclick="switchTab('adv-update-appt-status', this)"><i class="fas fa-tasks"></i> Cập nhật trạng thái lịch hẹn</li>
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
            </div>

            <!-- 2. VAI TRÒ: NHÂN VIÊN CHĂM SÓC (STAFF SPA/GROOMING) -->
            <div data-role="staff" style="display:none;">
                <li class="nav-item" onclick="toggleSubmenu('sub-care-pets', this)">
                    <i class="fas fa-folder-open"></i> Hồ sơ thú cưng
                    <i class="fas fa-chevron-down arrow-icon rotate"></i>
                </li>
                <ul id="sub-care-pets" class="submenu open">
                    <li class="submenu-item active" onclick="switchTab('care-view-pets', this)"><i class="fas fa-search"></i> Xem hồ sơ khách mang đến</li>
                    <li class="submenu-item" onclick="switchTab('care-health-notes', this)"><i class="fas fa-notes-medical"></i> Cập nhật tình trạng sau chăm sóc</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-care-appts', this)">
                    <i class="fas fa-calendar-check"></i> Lịch hẹn
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-care-appts" class="submenu">
                    <li class="submenu-item" onclick="switchTab('care-daily-appts', this)"><i class="fas fa-tasks"></i> Danh sách hẹn spa trong ngày</li>
                </ul>

                <li class="nav-item" onclick="toggleSubmenu('sub-care-services', this)">
                    <i class="fas fa-cut"></i> Dịch vụ chăm sóc
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-care-services" class="submenu">
                    <li class="submenu-item" onclick="switchTab('care-spa-action', this)"><i class="fas fa-bath"></i> Spa thú cưng (tắm, sấy)</li>
                    <li class="submenu-item" onclick="switchTab('care-grooming-action', this)"><i class="fas fa-cut"></i> Grooming (cắt móng, tỉa lông)</li>
                    <li class="submenu-item" onclick="switchTab('care-hotel-action', this)"><i class="fas fa-hotel"></i> Khách sạn thú cưng</li>
                </ul>

                <!-- Bán hàng chia Tại quầy & Online -->
                <li class="nav-item" onclick="toggleSubmenu('sub-care-sales', this)">
                    <i class="fas fa-cash-register"></i> Bán hàng
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-care-sales" class="submenu">
                    <li class="submenu-item" onclick="switchTab('care-sales-pos', this)"><i class="fas fa-store"></i> Tại quầy</li>
                    <li class="submenu-item" onclick="switchTab('care-sales-online', this)"><i class="fas fa-globe"></i> Online</li>
                </ul>

                <!-- Kho chia Kiểm tra hàng tồn & Báo cáo hàng tổng -->
                <li class="nav-item" onclick="toggleSubmenu('sub-care-inventory', this)">
                    <i class="fas fa-warehouse"></i> Kho & vật tư
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-care-inventory" class="submenu">
                    <li class="submenu-item" onclick="switchTab('care-stock-check', this)"><i class="fas fa-boxes"></i> Kiểm tra hàng tồn</li>
                    <li class="submenu-item" onclick="switchTab('care-stock-report', this)"><i class="fas fa-file-invoice"></i> Báo cáo hàng tổng</li>
                </ul>

                <!-- Đánh giá: Có icon chấm đỏ số lượng -->
                <li class="nav-item" onclick="toggleSubmenu('sub-care-kpi', this)">
                    <i class="fas fa-chart-line"></i> Báo cáo cá nhân
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-care-kpi" class="submenu">
                    <li class="submenu-item" onclick="switchTab('care-my-kpi', this)"><i class="fas fa-user-check"></i> Số lượng ca đã thực hiện</li>
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

                <li class="nav-item" onclick="toggleSubmenu('sub-adm-fin', this)">
                    <i class="fas fa-coins"></i> Kho, QR & Doanh thu
                    <i class="fas fa-chevron-down arrow-icon rotate"></i>
                </li>
                <ul id="sub-adm-fin" class="submenu open">
                    <li class="submenu-item active" onclick="switchTab('adm-tab-inventory', this)"><i class="fas fa-warehouse"></i> Kho hàng</li>
                    <li class="submenu-item" onclick="switchTab('adm-tab-qr', this)"><i class="fas fa-qrcode"></i> QR và thanh toán</li>
                    <li class="submenu-item" onclick="switchTab('adm-tab-revenue', this)"><i class="fas fa-chart-line"></i> Doanh thu thực tế</li>
                </ul>

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
            <!-- 1. Quản lý tài khoản -->
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

            <!-- 2. Quản lý dịch vụ & sản phẩm -->
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

            <!-- 3A. Kho hàng -->
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

            <!-- 4A. Khuyến mãi -->
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

            <!-- 4B. Tin tức -->
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

            <!-- 6. Hộp thư -->
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

            <!-- 7. Check-in / Check-out -->
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
                            - Đi trễ sau 08:00: <strong>Tự động trừ 1.000 VNĐ / phút</strong><br>
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
            <section id="adv-cust-list" class="view-section">
                <h2>Danh sách khách hàng đang quản lý (Tư vấn viên)</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Mã KH</th><th>Tên khách hàng</th><th>Số điện thoại</th><th>Email</th><th>Bé thú cưng</th><th>Thao tác</th></tr></thead>
                        <tbody>
                            <tr>
                                <td>#KH101</td>
                                <td><strong>Nguyễn Văn A</strong></td>
                                <td>0901 234 567</td>
                                <td>khachhang@petcare.com</td>
                                <td>Bé Lu (Corgi)</td>
                                <td><button class="btn-action" style="background:#e8f0fe; color:var(--primary);" onclick="openMiniChatFromAdvisor('Nguyễn Văn A')"><i class="fas fa-comment"></i> Nhắn tin</button></td>
                            </tr>
                            <tr>
                                <td>#KH102</td>
                                <td><strong>Trần Hương</strong></td>
                                <td>0908 765 432</td>
                                <td>huongtran@gmail.com</td>
                                <td>Bé Miu (Mèo Anh Lông Ngắn)</td>
                                <td><button class="btn-action" style="background:#e8f0fe; color:var(--primary);" onclick="openMiniChatFromAdvisor('Trần Hương')"><i class="fas fa-comment"></i> Nhắn tin</button></td>
                            </tr>
                        </tbody>
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

            <section id="adv-history" class="view-section">
                <h2>Lịch sử dịch vụ khách đã dùng</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Thời gian</th><th>Khách hàng</th><th>Bé thú cưng</th><th>Dịch vụ đã thực hiện</th><th>Đánh giá</th></tr></thead>
                        <tbody>
                            <tr>
                                <td>15/05/2026</td>
                                <td>Nguyễn Văn A</td>
                                <td>Bé Lu</td>
                                <td>Gói Tắm Thảo Dược & Khám da liễu</td>
                                <td>⭐⭐⭐⭐⭐</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="adv-suggest-pkg" class="view-section">
                <h2>Gợi ý gói dịch vụ phù hợp cho khách</h2><br>
                <div class="card-grid">
                    <div class="pet-card">
                        <h3>Gói Toàn Diện Cún Con</h3>
                        <p style="color:var(--primary); font-weight:bold; margin:8px 0;">450.000 VNĐ</p>
                        <p style="font-size:13px; color:#666;">Tiêm phòng 7 bệnh + Tẩy giun + Tắm thảo mộc khử khuẩn</p>
                        <button class="btn-action btn-save" onclick="showToast('Đã gửi báo giá gói Cún con tới khách hàng!')">Gửi tư vấn</button>
                    </div>
                    <div class="pet-card">
                        <h3>Gói Chăm Sóc Da & Lông Mèo</h3>
                        <p style="color:var(--primary); font-weight:bold; margin:8px 0;">380.000 VNĐ</p>
                        <p style="font-size:13px; color:#666;">Ủ bùn phục hồi nang lông + Vệ sinh tai nấm + Tỉa móng</p>
                        <button class="btn-action btn-save" onclick="showToast('Đã gửi báo giá gói Chăm sóc da mèo!')">Gửi tư vấn</button>
                    </div>
                </div>
            </section>

            <section id="adv-petshop-intro" class="view-section">
                <h2>Giới thiệu sản phẩm Pet Shop (Thức ăn, phụ kiện, thuốc)</h2><br>
                <div class="card-grid" id="adv-products-grid"></div>
            </section>

            <section id="adv-quick-quote" class="view-section">
                <h2>Tạo báo giá nhanh cho khách hàng</h2><br>
                <div class="table-container" style="max-width:550px;">
                    <div class="input-group"><label>Tên khách hàng</label><input type="text" id="quote-cust-name" placeholder="Nguyễn Văn A"></div>
                    <div class="input-group"><label>Dịch vụ / Sản phẩm chọn lựa</label><input type="text" id="quote-services" placeholder="Gói tắm + 1 bao hạt Royal Canin"></div>
                    <div class="input-group"><label>Tổng chi phí ước tính (VNĐ)</label><input type="number" id="quote-total" placeholder="470000"></div>
                    <button class="btn-login" onclick="showToast('Báo giá đã được tạo và gửi vào tin nhắn của khách!')">XUẤT BÁO GIÁ NHANH</button>
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
                    <div class="input-group"><label>Khách hàng</label><input type="text" placeholder="Nguyễn Văn A"></div>
                    <div class="input-group"><label>Dịch vụ yêu cầu</label><input type="text" placeholder="Spa & Cắt tỉa lông"></div>
                    <div class="input-group"><label>Thời gian hẹn</label><input type="datetime-local"></div>
                    <button class="btn-login" onclick="showToast('Đã tạo lịch hẹn thành công cho khách!')">LƯU LỊCH HẸN</button>
                </div>
            </section>

            <section id="adv-update-appt-status" class="view-section">
                <h2>Cập nhật trạng thái lịch hẹn khách hàng</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Mã hẹn</th><th>Bé</th><th>Dịch vụ</th><th>Đổi trạng thái</th></tr></thead>
                        <tbody id="adv-status-appts-tbody"></tbody>
                    </table>
                </div>
            </section>

            <section id="adv-orders-track" class="view-section">
                <h2>Theo dõi đơn hàng khách đặt</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Mã đơn</th><th>Sản phẩm</th><th>Tổng tiền</th><th>Thanh toán</th><th>Trạng thái giao</th></tr></thead>
                        <tbody id="adv-orders-tbody"></tbody>
                    </table>
                </div>
            </section>

            <section id="adv-payment-support" class="view-section">
                <h2>Hỗ trợ thanh toán & Xác nhận giao dịch</h2><br>
                <div class="table-container">
                    <p><i class="fas fa-check-circle" style="color:var(--success);"></i> Tất cả các giao dịch quét mã QR được đồng bộ tự động tới tài khoản ngân hàng của phòng khám.</p>
                </div>
            </section>

            <section id="adv-report-clients" class="view-section">
                <h2>Số lượng khách đã tư vấn trong tháng</h2><br>
                <div class="card-grid">
                    <div class="pet-card">
                        <h3>Tổng lượt tư vấn</h3>
                        <p style="font-size:28px; color:var(--primary); font-weight:bold; margin:10px 0;">86 lượt</p>
                        <small>Qua khung chat và hotline</small>
                    </div>
                </div>
            </section>

            <section id="adv-report-rate" class="view-section">
                <h2>Hiệu quả tư vấn (Tỷ lệ chốt dịch vụ)</h2><br>
                <div class="card-grid">
                    <div class="pet-card">
                        <h3>Tỷ lệ đặt lịch thành công</h3>
                        <div class="pie-chart-circle" style="background: conic-gradient(var(--success) 0% 78%, #eee 78% 100%);">
                            <span class="pie-chart-val">78%</span>
                        </div>
                        <small>78% khách tư vấn sử dụng dịch vụ</small>
                    </div>
                </div>
            </section>

            <section id="adv-report-reviews" class="view-section">
                <h2>Đánh giá từ khách hàng dành cho tư vấn viên</h2><br>
                <div class="table-container">
                    <p>⭐⭐⭐⭐⭐ - "Bạn tư vấn viên hỗ trợ rất nhiệt tình, hướng dẫn chọn phòng khách sạn chu đáo!"</p>
                </div>
            </section>

            <section id="adv-promos-update" class="view-section">
                <h2>Cập nhật ưu đãi & Gói dịch vụ mới để tư vấn khách</h2><br>
                <div class="card-grid" id="adv-promos-grid"></div>
            </section>

            <section id="adv-member-club" class="view-section">
                <h2>Chính sách Khách Hàng Thân Thiết (4 Hạng thẻ)</h2><br>
                <div class="table-container">
                    <p>4 Hạng thẻ áp dụng tích lũy: <strong>Đồng (0đ)</strong> - <strong>Bạc (2tr)</strong> - <strong>Vàng (5tr)</strong> - <strong>Đen Vàng (10tr)</strong>.</p>
                </div>
            </section>

            <!-- ================= CÁC SECTION DÀNH CHO NHÂN VIÊN CHĂM SÓC (STAFF) ================= -->
            <section id="care-view-pets" class="view-section">
                <h2>Hồ sơ khách mang đến hôm nay (Nhân viên chăm sóc)</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Ảnh</th><th>Tên thú cưng</th><th>Giống loài</th><th>Chủ nuôi</th><th>Thao tác</th></tr></thead>
                        <tbody id="staff-pets-tbody"></tbody>
                    </table>
                </div>
            </section>

            <section id="care-health-notes" class="view-section">
                <h2>Cập nhật tình trạng sau khi chăm sóc</h2><br>
                <div class="table-container" style="max-width:600px;">
                    <div class="input-group"><label>Bé thú cưng</label><input type="text" placeholder="Bé Lu"></div>
                    <div class="input-group"><label>Tình trạng da lông sau tắm/tỉa</label><textarea rows="3" placeholder="Lông mềm mượt, da sạch gàu, vắt tuyến hôi hoàn tất."></textarea></div>
                    <button class="btn-login" onclick="showToast('Đã lưu ghi chú sau chăm sóc!')">GHI NHẬN HỒ SƠ</button>
                </div>
            </section>

            <section id="care-daily-appts" class="view-section">
                <h2>Danh sách lịch hẹn Spa / Grooming trong ngày</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Mã hẹn</th><th>Bé thú cưng</th><th>Dịch vụ</th><th>Thời gian</th><th>Đổi trạng thái</th></tr></thead>
                        <tbody id="care-appts-tbody"></tbody>
                    </table>
                </div>
            </section>

            <section id="care-spa-action" class="view-section">
                <h2>Quy trình Spa thú cưng (Tắm thảo dược, sấy, vắt tuyến hôi)</h2><br>
                <div class="table-container">
                    <p><i class="fas fa-bath" style="color:var(--primary);"></i> Kiểm tra nhiệt độ nước ấm 37°C, pha loãng sữa tắm hữu cơ và massage nhẹ nhàng.</p>
                </div>
            </section>

            <section id="care-grooming-action" class="view-section">
                <h2>Quy trình Grooming (Cắt móng, vệ sinh tai, tạo kiểu)</h2><br>
                <div class="table-container">
                    <p><i class="fas fa-cut" style="color:var(--primary);"></i> Vô trùng kéo cắt trước khi tỉa form teddy/mông trái tim cho bé.</p>
                </div>
            </section>

            <section id="care-hotel-action" class="view-section">
                <h2>Chăm sóc khách sạn thú cưng lưu trú</h2><br>
                <div class="table-container">
                    <p><i class="fas fa-hotel" style="color:var(--primary);"></i> Cho bé ăn ngày 2 bữa đúng giờ, dắt đi dạo sân cỏ và vệ sinh khay cát/buồng đệm.</p>
                </div>
            </section>

            <!-- Bán hàng chia Tại quầy & Online -->
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
                <h2>Kiểm tra hàng tồn (Dụng cụ, mỹ phẩm spa, thức ăn)</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Tên mặt hàng</th><th>Tồn kho</th><th>Đơn vị</th><th>Tình trạng</th></tr></thead>
                        <tbody id="care-stock-tbody"></tbody>
                    </table>
                </div>
            </section>

            <section id="care-stock-report" class="view-section">
                <h2>Báo cáo hàng tổng & Đề xuất nhập thêm</h2><br>
                <div class="table-container" style="max-width:550px;">
                    <div class="input-group"><label>Mặt hàng cần bổ sung</label><input type="text" id="care-rep-item" placeholder="Sữa tắm hữu cơ / Hạt Corgi"></div>
                    <div class="input-group"><label>Số lượng đề xuất</label><input type="number" id="care-rep-qty" value="10"></div>
                    <div class="input-group"><label>Lý do</label><input type="text" id="care-rep-note" placeholder="Dưới định mức an toàn"></div>
                    <button class="btn-login" onclick="submitCareStockReport()">GỬI BÁO CÁO HÀNG TỔNG CHO QUẢN LÝ</button>
                </div>
            </section>

            <!-- Báo cáo cá nhân & Trả lời đánh giá có chấm đỏ -->
            <section id="care-my-kpi" class="view-section">
                <h2>Số lượng ca chăm sóc đã thực hiện</h2><br>
                <div class="card-grid">
                    <div class="pet-card">
                        <h3>Ca hoàn tất trong tháng</h3>
                        <p style="font-size:28px; color:var(--primary); font-weight:bold; margin:10px 0;">34 ca</p>
                        <small>Spa, cắt tỉa và lưu trú khách sạn</small>
                    </div>
                </div>
            </section>

            <section id="care-reviews-reply" class="view-section">
                <h2><i class="fas fa-reply-all" style="color:var(--primary);"></i> Phản Hồi Đánh Giá Khách Hàng (Nhân viên chăm sóc)</h2>
                <p style="color:#777; margin:5px 0 20px;">Lắng nghe và gửi lời cảm ơn/giải đáp đến khách hàng sau ca dịch vụ</p>
                <div id="staff-reviews-reply-container" style="display:flex; flex-direction:column; gap:16px;"></div>
            </section>

            <section id="care-performance" class="view-section">
                <h2>Hiệu quả công việc cá nhân</h2><br>
                <div class="table-container">
                    <p><i class="fas fa-award" style="color:var(--success);"></i> Đạt 98% mức độ hài lòng từ khách hàng sau dịch vụ grooming.</p>
                </div>
            </section>

            <section id="care-promos-view" class="view-section">
                <h2>Chương trình ưu đãi Spa / Grooming đang áp dụng</h2><br>
                <div class="card-grid" id="care-promos-grid"></div>
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
                    <div class="input-group"><label>Triệu chứng & Khám lâm sàng</label><textarea rows="3" placeholder="Thân nhiệt 38.5°C, da vùng bụng bớt đỏ, không có ký sinh trùng ngoài da."></textarea></div>
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
                    <div class="input-group"><label>Phác đồ điều trị</label><textarea rows="3" placeholder="Kháng sinh, bôi Bio-Derma ngày 2 lần, kiêng tắm xà phòng hóa chất..."></textarea></div>
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
                    <div class="input-group"><label>Chỉ định xét nghiệm</label><input type="text" placeholder="Soi kính hiển vi tìm nấm móng"></div>
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

    <!-- MODAL THÊM / SỬA USER (Admin) -->
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

    <!-- MODAL THÊM / SỬA MẶT HÀNG HOẶC DỊCH VỤ -->
    <div id="admin-item-modal" class="modal-overlay">
        <div class="modal-content">
            <h3 id="admin-item-modal-title" style="margin-bottom: 20px;">Chỉnh sửa Mặt hàng / Dịch vụ</h3>
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

    <!-- <script src="js/script.js"></script> -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const currentRole = localStorage.getItem('pc_logged_role') || 'admin';
            
            if (currentRole === 'customer') {
                window.location.replace("2.index.html");
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
            window.location.replace("1.login.html");
        }
    </script>
</body>
</html>