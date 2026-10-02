<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare Pro - Cổng Khách Hàng</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="customer-mode hologram-fluid-body">

    <div id="toast-box" class="toast-container"></div>

    <!-- POPUP THÀNH CÔNG GIỮA TRANG -->
    <div id="success-center-popup" class="success-center-modal">
        <div class="success-center-card ppt-zoom-in">
            <div class="success-icon-circle"><i class="fas fa-check"></i></div>
            <h2 style="color: var(--primary); margin-bottom: 10px;">Đặt Hàng Thành Công!</h2>
            <p id="success-center-desc" style="color: #666; font-size: 14.5px; line-height: 1.6; margin-bottom: 25px;"></p>
            <button class="btn-login" style="margin-top:0;" onclick="closeCenterSuccessPopup()">TUYỆT VỜI, XEM TIẾP</button>
        </div>
    </div>

    <!-- BANNER KHUYẾN MÃI HÌNH VUÔNG NỔI BẬT (Có nút X thoát) -->
    <div id="promo-floating-banner" class="promo-floating-square" style="display:none;">
        <button class="close-square-btn" onclick="closeSquarePromo()">&times;</button>
        <img id="square-promo-img" src="https://images.unsplash.com/photo-1548767797-d8c844163c4c?w=300" alt="Khuyến mãi">
        <div class="square-promo-body">
            <span class="badge badge-danger">HOT PROMO</span>
            <h4 id="square-promo-title">Giảm 20% Spa Đầu Tuần</h4>
            <p id="square-promo-desc">Mã: SPA20 - Đặt lịch ngay nhận ưu đãi!</p>
            <button class="btn-action btn-save" style="padding:6px 12px; font-size:12px; margin-top:5px;" onclick="viewPromoFromBanner()">Xem Ngay</button>
        </div>
    </div>

    <!-- KHUNG CHAT MINI NẰM GÓC DƯỚI BÊN TRÁI (Kết nối với Nhân viên tư vấn) -->
    <div class="chat-mini-anchor-left">
        <button id="chat-toggle-btn" class="chat-bubble-btn" onclick="toggleMiniChat()">
            <i class="fas fa-comment-dots fa-2x"></i>
            <span class="chat-online-dot"></span>
        </button>
        
        <div id="mini-chat-box" class="mini-chat-window" style="display:none;">
            <div class="mini-chat-header">
                <div style="display:flex; align-items:center; gap:10px;">
                    <img src="https://i.pravatar.cc/100?img=5" style="width:38px; height:38px; border-radius:50%; object-fit:cover; border:2px solid #fff;">
                    <div>
                        <h4 style="font-size:13.5px; margin:0; color:#fff;">NV Tư Vấn: Trần Thị Tư Vấn</h4>
                        <small style="color:#e8f8f5; font-size:11px;"><i class="fas fa-circle" style="color:#2ecc71; font-size:8px;"></i> Đang trong ca trực hỗ trợ</small>
                    </div>
                </div>
                <button onclick="toggleMiniChat()" style="background:none; border:none; color:#fff; font-size:20px; cursor:pointer;">&times;</button>
            </div>
            
            <div id="mini-chat-messages" class="mini-chat-body">
                <!-- Tin nhắn hiển thị 2 chiều tại đây -->
            </div>

            <div class="mini-chat-footer">
                <input type="text" id="mini-chat-input" placeholder="Nhập câu hỏi cần tư vấn..." onkeypress="if(event.key==='Enter') sendClientChatMessage()">
                <button onclick="sendClientChatMessage()"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>

    <div id="main-page" class="page active">
        <aside class="sidebar holo-glass-sidebar">
            <h2 style="color: var(--primary); margin-bottom: 20px;"><i class="fas fa-heartbeat"></i> PETCARE</h2>
            
            <div class="user-greeting-box">
                <img id="sidebar-user-avatar" src="https://i.pravatar.cc/100?img=12" class="user-greeting-avatar">
                <div class="user-greeting-text">
                    <h4 id="sidebar-greeting-name">Xin chào, Bạn!</h4>
                    <small id="sidebar-user-role-badge">Khách hàng thành viên</small>
                </div>
            </div>

            <!-- MENU KHÁCH HÀNG -->
            <div>
                <!-- 1. Về chúng tôi -->
                <li class="nav-item" onclick="switchTab('cust-about', this)">
                    <i class="fas fa-info-circle"></i> Về chúng tôi
                </li>

                <!-- 2. Hồ sơ -->
                <li class="nav-item" onclick="toggleSubmenu('sub-profile', this)">
                    <i class="fas fa-id-card"></i> Hồ sơ
                    <i class="fas fa-chevron-down arrow-icon rotate"></i>
                </li>
                <ul id="sub-profile" class="submenu open">
                    <li class="submenu-item active" onclick="switchTab('cust-pets', this)"><i class="fas fa-paw"></i> Hồ sơ bé</li>
                    <li class="submenu-item" onclick="switchTab('cust-profile-update', this)"><i class="fas fa-user-astronaut"></i> Cập nhật thông tin</li>
                </ul>

                <!-- 3. Lịch sử -->
                <li class="nav-item" onclick="toggleSubmenu('sub-history', this)">
                    <i class="fas fa-file-medical-alt"></i> Lịch sử
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-history" class="submenu">
                    <li class="submenu-item" onclick="switchTab('cust-records', this)"><i class="fas fa-prescription-bottle-alt"></i> Bệnh án, đơn thuốc</li>
                    <li class="submenu-item" onclick="switchTab('cust-vaccines', this)"><i class="fas fa-syringe"></i> Tiêm phòng, xét nghiệm</li>
                </ul>

                <!-- 4. Sức khoẻ -->
                <li class="nav-item" onclick="toggleSubmenu('sub-health', this)">
                    <i class="fas fa-heartbeat"></i> Sức khoẻ
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-health" class="submenu">
                    <li class="submenu-item" onclick="switchTab('cust-health-overview', this)"><i class="fas fa-chart-line"></i> Theo dõi tổng quan</li>
                </ul>

                <!-- 5. Đặt lịch (Chỉ ghi Đặt lịch theo yêu cầu) -->
                <li class="nav-item" onclick="toggleSubmenu('sub-appointments', this)">
                    <i class="fas fa-calendar-alt"></i> Đặt lịch
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-appointments" class="submenu">
                    <li class="submenu-item" onclick="switchTab('cust-booking', this)"><i class="fas fa-calendar-plus"></i> Đặt lịch</li>
                    <li class="submenu-item" onclick="switchTab('cust-reminders-separate', this)"><i class="fas fa-clock"></i> Nhắc nhở</li>
                    <li class="submenu-item" onclick="switchTab('cust-notifications-separate', this)"><i class="fas fa-bell"></i> Thông báo</li>
                    <li class="submenu-item" onclick="switchTab('cust-appointment-status', this)"><i class="fas fa-clipboard-check"></i> Trạng thái lịch hẹn</li>
                </ul>

                <!-- 6. Dịch vụ: Tách riêng Spa, Grooming, Khách sạn -->
                <li class="nav-item" onclick="toggleSubmenu('sub-services', this)">
                    <i class="fas fa-concierge-bell"></i> Dịch vụ
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-services" class="submenu">
                    <li class="submenu-item" onclick="switchTab('cust-svc-spa', this)"><i class="fas fa-bath"></i> Spa thú cưng</li>
                    <li class="submenu-item" onclick="switchTab('cust-svc-grooming', this)"><i class="fas fa-cut"></i> Grooming & Cắt tỉa lông</li>
                    <li class="submenu-item" onclick="switchTab('cust-svc-hotel', this)"><i class="fas fa-hotel"></i> Khách sạn thú cưng</li>
                </ul>

                <!-- 7. Mua sắm -->
                <li class="nav-item" onclick="toggleSubmenu('sub-shopping', this)">
                    <i class="fas fa-shopping-bag"></i> Mua sắm
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-shopping" class="submenu">
                    <li class="submenu-item" onclick="switchTab('cust-products', this)"><i class="fas fa-store"></i> Thức ăn, phụ kiện, thuốc</li>
                    <li class="submenu-item" onclick="switchTab('cust-favorites', this)"><i class="fas fa-heart" style="color:#ff4757;"></i> Yêu thích</li>
                    <li class="submenu-item" onclick="switchTab('cust-orders', this)"><i class="fas fa-receipt"></i> Đơn hàng & giao dịch</li>
                </ul>

                <!-- 8. Báo cáo chi phí -->
                <li class="nav-item" onclick="switchTab('cust-expenses', this)">
                    <i class="fas fa-wallet"></i> Báo cáo chi phí
                </li>

                <!-- 9. Ưu đãi & Tin tức -->
                <li class="nav-item" onclick="toggleSubmenu('sub-promotions', this)">
                    <i class="fas fa-tags"></i> Ưu đãi & Tin tức
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-promotions" class="submenu">
                    <li class="submenu-item" onclick="switchTab('cust-promos', this)"><i class="fas fa-ticket-alt"></i> Khuyến mãi & Voucher</li>
                    <li class="submenu-item" onclick="switchTab('cust-news', this)"><i class="fas fa-newspaper"></i> Tin tức</li>
                    <li class="submenu-item" onclick="switchTab('cust-reviews-section', this)"><i class="fas fa-star" style="color:var(--warning);"></i> Đánh giá dịch vụ</li>
                </ul>
            </div>

            <li class="nav-item" onclick="logoutToAuth()" style="margin-top: auto; color: var(--accent);"><i class="fas fa-sign-out-alt"></i> Đăng xuất</li>
        </aside>

        <main class="content-area holo-content-area">
            
            <!-- SECTION 1: VỀ CHÚNG TÔI (Căn giữa cân đối, trang trọng) -->
            <section id="cust-about" class="view-section">
                <div class="content-center-container ppt-slide-in">
                    <div class="table-container holo-card-border" style="max-width: 900px; margin: 0 auto; text-align: center;">
                        <h2 style="color: var(--primary); font-size: 26px; margin-bottom: 12px;"><i class="fas fa-heartbeat"></i> VỀ CHÚNG TÔI - PETCARE PRO</h2>
                        <p style="color: #666; font-size: 15px; line-height: 1.8; margin-bottom: 25px;">
                            PetCare Pro tự hào là trung tâm y tế, thẩm mỹ spa và khách sạn thú cưng cao cấp. Với tôn chỉ "Yêu thương trọn vẹn như thành viên gia đình", chúng tôi luôn cam kết đem lại cho bé cưng một môi trường chăm sóc an toàn, hiện đại và chuẩn mực y khoa quốc tế.
                        </p>

                        <div class="card-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 30px;">
                            <div class="pet-card">
                                <i class="fas fa-user-md fa-3x" style="color:var(--primary); margin-bottom:12px;"></i>
                                <h3>Đội ngũ Bác sĩ</h3>
                                <p style="font-size:13px; color:#777; margin-top:8px;">100% bác sĩ chính quy ngành Thú y, giàu kinh nghiệm lâm sàng và luôn lắng nghe thú cưng.</p>
                            </div>
                            <div class="pet-card">
                                <i class="fas fa-shield-alt fa-3x" style="color:var(--success); margin-bottom:12px;"></i>
                                <h3>Thiết bị an toàn</h3>
                                <p style="font-size:13px; color:#777; margin-top:8px;">Máy siêu âm màu, máy xét nghiệm sinh hóa tự động, buồng sấy ion âm chống hoảng sợ, phòng lưu máy lạnh 24/7.</p>
                            </div>
                            <div class="pet-card">
                                <i class="fas fa-spa fa-3x" style="color:var(--secondary); margin-bottom:12px;"></i>
                                <h3>Spa & Mỹ phẩm</h3>
                                <p style="font-size:13px; color:#777; margin-top:8px;">Mỹ phẩm 100% thảo mộc hữu cơ nhập khẩu, kéo tỉa chuyên dụng vô trùng tuyệt đối, an toàn cho da nhạy cảm.</p>
                            </div>
                        </div>

                        <div style="background: rgba(108, 92, 231, 0.08); padding: 20px; border-radius: 16px; text-align: left;">
                            <h4 style="color: var(--primary); margin-bottom: 8px;"><i class="fas fa-check-circle"></i> Tiêu chuẩn chất lượng vàng tại PetCare:</h4>
                            <ul style="padding-left: 20px; color: #555; font-size: 13.5px; line-height: 1.8;">
                                <li>Phác đồ điều trị rõ ràng, minh bạch chi phí trước khi thực hiện.</li>
                                <li>Phòng lưu trú khử trùng bằng tia cực tím hàng ngày, không lây nhiễm chéo.</li>
                                <li>Chủ nuôi có thể theo dõi camera trực tuyến 24/7 khi gửi bé tại khách sạn.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- SECTION 2: HỒ SƠ BÉ & SLIDER DEMO 4 HẠNG THẺ (Đồng - Bạc - Vàng - Đen Vàng) -->
            <section id="cust-pets" class="view-section active">
                
                <!-- SLIDER DEMO 4 HẠNG THẺ TỰ ĐỘNG LƯỚT -->
                <div class="member-auto-slider-container ppt-fade-up">
                    <div class="slider-header-info">
                        <h3><i class="fas fa-crown" style="color:#f1c40f;"></i> ĐẶC QUYỀN HẠNG THẺ THÀNH VIÊN</h3>
                        <p>Hệ thống tự động nâng hạng theo hạn mức chi tiêu tích lũy của bạn</p>
                    </div>

                    <div class="cards-carousel-wrapper">
                        <div class="cards-carousel-track" id="cards-track">
                            <!-- Thẻ Đồng -->
                            <div class="carousel-card card-bronze">
                                <div class="c-card-top">
                                    <span>PETCARE MEMBER</span>
                                    <span class="c-badge">ĐỒNG</span>
                                </div>
                                <div class="c-card-body">
                                    <i class="fas fa-award fa-2x"></i>
                                    <h4>HẠNG ĐỒNG</h4>
                                    <small>Chi tiêu tích lũy: Từ 0 đ</small>
                                </div>
                                <div class="c-card-bottom">Ưu đãi giảm 5% dịch vụ khám định kỳ</div>
                            </div>
                            <!-- Thẻ Bạc -->
                            <div class="carousel-card card-silver">
                                <div class="c-card-top">
                                    <span>PETCARE MEMBER</span>
                                    <span class="c-badge">BẠC</span>
                                </div>
                                <div class="c-card-body">
                                    <i class="fas fa-medal fa-2x"></i>
                                    <h4>HẠNG BẠC</h4>
                                    <small>Chi tiêu tích lũy: Từ 2.000.000 đ</small>
                                </div>
                                <div class="c-card-bottom">Giảm 10% Spa & Tặng cắt móng vệ sinh tai</div>
                            </div>
                            <!-- Thẻ Vàng -->
                            <div class="carousel-card card-gold">
                                <div class="c-card-top">
                                    <span>PETCARE MEMBER</span>
                                    <span class="c-badge">VÀNG</span>
                                </div>
                                <div class="c-card-body">
                                    <i class="fas fa-crown fa-2x"></i>
                                    <h4>HẠNG VÀNG</h4>
                                    <small>Chi tiêu tích lũy: Từ 5.000.000 đ</small>
                                </div>
                                <div class="c-card-bottom">Giảm 15% tất cả dịch vụ + Ưu tiên lịch hẹn</div>
                            </div>
                            <!-- Thẻ Đen Vàng -->
                            <div class="carousel-card card-blackgold">
                                <div class="c-card-top">
                                    <span>PETCARE VIP CLUB</span>
                                    <span class="c-badge">ĐEN VÀNG</span>
                                </div>
                                <div class="c-card-body">
                                    <i class="fas fa-gem fa-2x"></i>
                                    <h4>HẠNG ĐEN VÀNG</h4>
                                    <small>Chi tiêu tích lũy: Từ 10.000.000 đ</small>
                                </div>
                                <div class="c-card-bottom">Giảm 20% trọn đời + Phòng VIP Khách sạn miễn phí 1 ngày</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thẻ cá nhân hiển thị nếu đã đăng ký -->
                <div id="member-registered-info" style="display:none; max-width:400px; margin: 15px auto;">
                    <div class="vip-card-preview card-bronze" id="active-vip-card-box">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <strong><i class="fas fa-paw"></i> THẺ THÀNH VIÊN</strong>
                            <span class="vip-tier-badge" id="vip-card-tier">ĐỒNG</span>
                        </div>
                        <div style="display:flex; gap:14px; align-items:center; margin:15px 0 10px;">
                            <img id="vip-card-avatar" src="https://i.pravatar.cc/100?img=12" style="width:50px; height:50px; border-radius:50%; object-fit:cover; border:2px solid #fff;">
                            <div>
                                <h3 id="vip-card-name" style="font-size:18px; text-transform:uppercase; margin-bottom:2px;">NGUYỄN VĂN A</h3>
                                <small style="opacity:0.85;" id="vip-card-dob">Sinh nhật: 15/08/1998</small>
                            </div>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:flex-end;">
                            <p style="font-size:12px; letter-spacing:2px; font-family:monospace;" id="vip-card-id">PC-MEMBER-88992</p>
                            <small id="vip-card-spending" style="font-weight:bold; background:rgba(0,0,0,0.3); padding:3px 8px; border-radius:6px;">Tích lũy: 0 đ</small>
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin: 25px 0 15px;">
                    <div>
                        <h2 id="cust-greeting-banner">Xin chào, Khách hàng!</h2>
                        <p style="color:#777; margin-top:4px;">Danh sách các bé thú cưng trong hồ sơ của bạn</p>
                    </div>
                    <button class="btn-action btn-save" style="width: auto;" onclick="openPetModal()"><i class="fas fa-plus"></i> Thêm bé mới</button>
                </div>
                <div class="card-grid" id="pet-list"></div>
            </section>

            <!-- SECTION 3: CẬP NHẬT THÔNG TIN TÀI KHOẢN (Hologram Loang Căn Giữa) -->
            <section id="cust-profile-update" class="view-section">
                <div class="hologram-profile-wrapper ppt-zoom-in">
                    <div class="hologram-stars"></div>
                    <div class="holo-floating-pet" style="top: 8%; left: 10%;"><i class="fas fa-dog" style="color:#a29bfe;"></i></div>
                    <div class="holo-floating-pet" style="bottom: 12%; left: 8%; animation-delay: 1.5s;"><i class="fas fa-cat" style="color:#81ecec;"></i></div>
                    <div class="holo-floating-pet" style="top: 15%; right: 12%; animation-delay: 2.5s;"><i class="fas fa-paw" style="color:#fab1a0;"></i></div>
                    <div class="holo-floating-pet" style="bottom: 10%; right: 10%; animation-delay: 3.5s;"><i class="fas fa-bone" style="color:#ffeaa7;"></i></div>
                    <div class="holo-floating-pet" style="top: 50%; left: 4%; animation-delay: 4.5s;"><i class="fas fa-meteor" style="color:#ff7675;"></i></div>

                    <div class="hologram-profile-card">
                        <h2 style="color: var(--primary); margin-bottom: 6px;"><i class="fas fa-user-astronaut"></i> Cập Nhật Tài Khoản</h2>
                        <p style="color:#666; font-size: 13.5px; margin-bottom: 20px;">Tùy chỉnh thông tin & đổi ảnh đại diện cá nhân</p>

                        <div class="image-picker-container" style="background: rgba(240, 243, 255, 0.7);">
                            <img id="user-avatar-preview" src="https://i.pravatar.cc/100?img=12" class="img-preview" style="border: 3px solid var(--primary);">
                            <label class="btn-upload">
                                <i class="fas fa-camera"></i> Đổi ảnh đại diện
                                <input type="file" accept="image/*" style="display: none;" onchange="previewUserAvatar(this)">
                            </label>
                        </div>

                        <div style="text-align: left;">
                            <div class="input-group"><label>Họ và tên của bạn</label><input type="text" id="user-fullname" value="Nguyễn Văn A"></div>
                            <div class="input-group"><label>Số điện thoại liên hệ</label><input type="text" id="user-phone" value="0901 234 567"></div>
                            <div class="input-group"><label>Email</label><input type="email" id="user-email" value="khachhang@petcare.com"></div>
                            <div class="input-group"><label>Địa chỉ</label><input type="text" id="user-address" value="Quận 1, TP. Hồ Chí Minh"></div>
                        </div>
                        <button class="btn-login" style="margin-top: 10px;" onclick="updateCustomerProfile()"><i class="fas fa-save"></i> LƯU THAY ĐỔI</button>
                    </div>
                </div>
            </section>

            <!-- SECTION 4: BỆNH ÁN & ĐƠN THUỐC -->
            <section id="cust-records" class="view-section">
                <h2>Bệnh án & Đơn thuốc</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Ngày khám</th><th>Bé cưng</th><th>Chẩn đoán</th><th>Bác sĩ điều trị</th><th>Đơn thuốc</th></tr></thead>
                        <tbody><tr><td>15/05/2026</td><td>Bé Lu</td><td>Viêm da dị ứng nhẹ</td><td>BS. Trần Nam</td><td>Thuốc bôi da Bio-Derma</td></tr></tbody>
                    </table>
                </div>
            </section>

            <!-- SECTION 5: TIÊM PHÒNG & XÉT NGHIỆM -->
            <section id="cust-vaccines" class="view-section">
                <h2>Lịch sử tiêm phòng & Xét nghiệm</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Ngày tiêm</th><th>Bé cưng</th><th>Loại vắc xin</th><th>Ngày nhắc tiêm</th><th>Trạng thái</th></tr></thead>
                        <tbody><tr><td>10/01/2026</td><td>Bé Lu</td><td>Vắc xin 7 bệnh ngừa dại</td><td>10/01/2027</td><td><span class="badge badge-success">Đã hoàn thành</span></td></tr></tbody>
                    </table>
                </div>
            </section>

            <!-- SECTION 6: SỨC KHOẺ TỔNG QUAN -->
            <section id="cust-health-overview" class="view-section">
                <h2>Theo dõi sức khoẻ tổng quan</h2><br>
                <div class="card-grid">
                    <div class="pet-card"><h3>Cân nặng gần nhất</h3><p id="disp-weight" style="font-size: 28px; color: var(--primary); font-weight: bold; margin-top: 10px;">11.5 kg</p></div>
                    <div class="pet-card"><h3>Nhiệt độ cơ thể</h3><p id="disp-temp" style="font-size: 28px; color: var(--success); font-weight: bold; margin-top: 10px;">38.5 °C</p></div>
                    <div class="pet-card"><h3>Tình trạng dinh dưỡng</h3><p id="disp-nutri" style="font-size: 20px; color: #555; margin-top: 10px;">Rất tốt - Khỏe mạnh</p></div>
                </div>

                <div class="table-container" style="margin-top: 25px; max-width: 600px; margin-left:auto; margin-right:auto;">
                    <h3 style="margin-bottom: 15px;"><i class="fas fa-edit"></i> Ghi nhận chỉ số thể trạng hôm nay</h3>
                    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                        <div class="input-group" style="flex:1;"><label>Cân nặng (kg)</label><input type="number" step="0.1" id="input-weight" placeholder="VD: 11.8"></div>
                        <div class="input-group" style="flex:1;"><label>Thân nhiệt (°C)</label><input type="number" step="0.1" id="input-temp" placeholder="VD: 38.6"></div>
                    </div>
                    <button class="btn-action btn-save" style="margin-top: 5px;" onclick="logHealthData()">Lưu chỉ số mới</button>
                </div>
            </section>

            <!-- SECTION 7: ĐẶT LỊCH (Danh mục chi tiết cụ thể) -->
            <section id="cust-booking" class="view-section">
                <div class="content-center-container">
                    <div class="table-container holo-card-border" style="max-width: 620px; margin:0 auto;">
                        <h2 style="color: var(--primary); margin-bottom: 6px;"><i class="fas fa-calendar-plus"></i> ĐẶT LỊCH DỊCH VỤ</h2>
                        <p style="color:#777; font-size:13.5px; margin-bottom: 20px;">Vui lòng chọn loại dịch vụ chi tiết theo nhu cầu của bé</p>
                        
                        <div class="input-group">
                            <label><i class="fas fa-stethoscope"></i> Danh mục dịch vụ chính</label>
                            <select id="book-category" onchange="updateBookingDetailOptions()">
                                <option value="kham">Khám sức khoẻ</option>
                                <option value="grooming">Grooming & Cắt tỉa lông</option>
                                <option value="hotel">Khách sạn thú cưng</option>
                            </select>
                        </div>

                        <!-- Gói cụ thể theo danh mục đã chọn -->
                        <div class="input-group">
                            <label><i class="fas fa-list-ul"></i> Dịch vụ cụ thể</label>
                            <select id="book-specific-service">
                                <!-- Tự động nạp bằng JS -->
                            </select>
                        </div>

                        <div class="input-group">
                            <label><i class="fas fa-paw"></i> Bé thú cưng</label>
                            <select id="book-pet">
                                <option>Bé Lu (Corgi)</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label><i class="fas fa-clock"></i> Ngày & Giờ hẹn mong muốn</label>
                            <input type="datetime-local" id="book-time">
                        </div>

                        <div class="input-group">
                            <label><i class="fas fa-comment-alt"></i> Ghi chú thêm cho bác sĩ / KTV</label>
                            <input type="text" id="book-note" placeholder="Ví dụ: Bé hơi nhát người lạ, da tai đang ngứa...">
                        </div>

                        <button class="btn-login" onclick="submitBooking()"><i class="fas fa-check-circle"></i> XÁC NHẬN ĐẶT LỊCH</button>
                    </div>
                </div>
            </section>

            <!-- SECTION 8: NHẮC NHỞ (Bấm vào xem popup chi tiết) -->
            <section id="cust-reminders-separate" class="view-section">
                <h2><i class="fas fa-clock" style="color:var(--warning);"></i> Nhắc nhở lịch dịch vụ & Y tế</h2>
                <p style="color:#777; margin:5px 0 20px;">Bấm trực tiếp vào từng thẻ nhắc nhở bên dưới để xem thông tin chi tiết</p>
                <div class="table-container" id="reminders-container-box"></div>
            </section>

            <!-- SECTION 9: THÔNG BÁO GIAO DỊCH & ĐƠN HÀNG (Không có thông báo voucher) -->
            <section id="cust-notifications-separate" class="view-section">
                <h2><i class="fas fa-bell" style="color:var(--primary);"></i> Thông báo giao dịch & Đơn hàng</h2>
                <p style="color:#777; margin:5px 0 20px;">Theo dõi tiến trình đơn mua sắm, trạng thái lịch hẹn và giao dịch thanh toán</p>
                <div class="table-container" id="notifications-container-box"></div>
            </section>

            <!-- SECTION 10: TRẠNG THÁI LỊCH HẸN -->
            <section id="cust-appointment-status" class="view-section">
                <h2>Trạng thái lịch hẹn của bạn</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Mã hẹn</th><th>Bé</th><th>Dịch vụ cụ thể</th><th>Thời gian</th><th>Thanh toán</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
                        <tbody id="appointment-table-body"></tbody>
                    </table>
                </div>
            </section>

            <!-- SECTION 11: SPA THÚ CƯNG (Tách riêng) -->
            <section id="cust-svc-spa" class="view-section">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 10px;">
                    <h2><i class="fas fa-bath" style="color:var(--primary);"></i> Dịch Vụ Spa Thư Giãn Thú Cưng</h2>
                    <span class="badge badge-info">100% Thảo Mộc Hữu Cơ</span>
                </div>
                <p style="color:#777; margin-bottom:20px;">Liệu trình tắm sấy khử mùi hôi, massage thư giãn gân cốt và dưỡng lông óng mượt</p>
                <div class="card-grid">
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?w=200">
                        <h3>Gói Tắm Thảo Dược Cơ Bản</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">150.000 VNĐ</p>
                        <p style="color:#777; font-size:13px; margin-bottom:15px;">Vắt tuyến hôi, tắm sấy thơm tho, nhổ lông tai</p>
                        <button class="btn-action btn-save" onclick="openBookingFromService('Tắm Thảo Dược Cơ Bản', 150000)">Tham khảo & Đặt lịch</button>
                    </div>
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1548767797-d8c844163c4c?w=200">
                        <h3>Gói Spa Bùn Khoáng Phục Hồi Da</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">250.000 VNĐ</p>
                        <p style="color:#777; font-size:13px; margin-bottom:15px;">Ủ bùn khoáng nóng, phục hồi viêm nang lông, giảm rụng lông</p>
                        <button class="btn-action btn-save" onclick="openBookingFromService('Spa Bùn Khoáng Phục Hồi', 250000)">Tham khảo & Đặt lịch</button>
                    </div>
                </div>
            </section>

            <!-- SECTION 12: GROOMING & CẮT TỈA (Tách riêng, nút Tham khảo & Đặt lịch) -->
            <section id="cust-svc-grooming" class="view-section">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 10px;">
                    <h2><i class="fas fa-cut" style="color:var(--primary);"></i> Dịch Vụ Grooming & Cắt Tỉa Tạo Kiểu</h2>
                    <span class="badge badge-success">Thợ Cắt Chuyên Nghiệp</span>
                </div>
                <p style="color:#777; margin-bottom:20px;">Tạo kiểu theo yêu cầu: Teddy Bear tròn xoe, Mông quả đào Corgi, Bờm sư tử quý phái</p>
                <div class="card-grid">
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=200">
                        <h3>Cắt Tỉa Tạo Kiểu Teddy Bear</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">300.000 VNĐ</p>
                        <p style="color:#777; font-size:13px; margin-bottom:15px;">Form mặt tròn gấu bông bồng bềnh siêu cưng</p>
                        <button class="btn-action btn-save" onclick="openBookingFromService('Cắt tỉa Teddy Bear', 300000)">Tham khảo & Đặt lịch</button>
                    </div>
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=200">
                        <h3>Cắt Tỉa Mông Quả Đào Trái Tim</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">320.000 VNĐ</p>
                        <p style="color:#777; font-size:13px; margin-bottom:15px;">Tỉa mông quả đào độc quyền dáng Corgi và Poodle</p>
                        <button class="btn-action btn-save" onclick="openBookingFromService('Cắt tỉa Mông Trái Tim', 320000)">Tham khảo & Đặt lịch</button>
                    </div>
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1537151625747-768eb6cf92b2?w=200">
                        <h3>Vệ Sinh Toàn Diện (Cắt móng, Vệ sinh tai)</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">100.000 VNĐ</p>
                        <p style="color:#777; font-size:13px; margin-bottom:15px;">Mài móng bo tròn không xước, làm sạch ráy tai sâu</p>
                        <button class="btn-action btn-save" onclick="openBookingFromService('Grooming Vệ Sinh Toàn Diện', 100000)">Tham khảo & Đặt lịch</button>
                    </div>
                </div>
            </section>

            <!-- SECTION 13: KHÁCH SẠN THÚ CƯNG (Tách riêng: Phòng cơ bản, Tiện nghi, VIP) -->
            <section id="cust-svc-hotel" class="view-section">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 10px;">
                    <h2><i class="fas fa-hotel" style="color:var(--primary);"></i> Khách Sạn Thú Cưng Máy Lạnh 5 Sao</h2>
                    <span class="badge badge-pending">Camera 24/7</span>
                </div>
                <p style="color:#777; margin-bottom:20px;">Lưu trú tiêu chuẩn: Phòng thông thoáng, điều hòa nhiệt độ ổn định, dắt đi dạo 2 lần/ngày</p>
                <div class="card-grid">
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1541599540903-216a46ca1dc0?w=200">
                        <h3>Khách Sạn - Phòng Cơ Bản</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">150.000 VNĐ / ngày</p>
                        <p style="color:#777; font-size:13px; margin-bottom:15px;">Không gian sạch sẽ, nệm êm, ăn ngày 2 bữa chuẩn dinh dưỡng</p>
                        <button class="btn-action btn-save" onclick="openBookingFromService('Khách sạn - Phòng cơ bản', 150000)">Tham khảo & Đặt lịch</button>
                    </div>
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1601758228041-f3b2795255f1?w=200">
                        <h3>Khách Sạn - Phòng Tiện Nghi</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">250.000 VNĐ / ngày</p>
                        <p style="color:#777; font-size:13px; margin-bottom:15px;">Máy lạnh lọc ion âm, đồ chơi gặm, dạo sân cỏ 30 phút/ngày</p>
                        <button class="btn-action btn-save" onclick="openBookingFromService('Khách sạn - Phòng tiện nghi', 250000)">Tham khảo & Đặt lịch</button>
                    </div>
                    <div class="pet-card" style="border: 2px solid #f1c40f;">
                        <span class="badge badge-pending" style="position:absolute; top:12px; left:12px;">VIP LUXURY</span>
                        <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=200">
                        <h3>Khách Sạn - Phòng VIP</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">400.000 VNĐ / ngày</p>
                        <p style="color:#777; font-size:13px; margin-bottom:15px;">Camera trực tuyến riêng cho chủ xem trên App, menu thịt bò tươi</p>
                        <button class="btn-action btn-save" onclick="openBookingFromService('Khách sạn - Phòng VIP', 400000)">Tham khảo & Đặt lịch</button>
                    </div>
                </div>
            </section>

            <!-- SECTION 14: MUA SẮM SẢN PHẨM -->
            <section id="cust-products" class="view-section">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                    <h2>Thức ăn, Phụ kiện & Thuốc</h2>
                    <span style="font-size:13px; color:#666;">Bấm <i class="fas fa-heart" style="color:#ff4757;"></i> để thêm vào danh sách Yêu thích</span>
                </div>
                <div class="card-grid" id="product-list-customer"></div>
            </section>

            <!-- SECTION 15: SẢN PHẨM YÊU THÍCH -->
            <section id="cust-favorites" class="view-section">
                <h2><i class="fas fa-heart" style="color:#ff4757;"></i> Sản phẩm bạn yêu thích</h2>
                <p style="color:#777; margin:5px 0 20px;">Danh sách các món đồ bạn đã lưu để mua sắm thuận tiện</p>
                <div class="card-grid" id="favorites-list-customer"></div>
            </section>

            <!-- SECTION 16: ĐƠN HÀNG -->
            <section id="cust-orders" class="view-section">
                <h2>Đơn hàng & Giao dịch</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Mã đơn</th><th>Sản phẩm</th><th>Hình thức TT</th><th>Tổng tiền</th><th>Ngày mua</th><th>Thanh toán</th></tr></thead>
                        <tbody id="orders-table-body"></tbody>
                    </table>
                </div>
            </section>

            <!-- SECTION 17: BÁO CÁO CHI PHÍ -->
            <section id="cust-expenses" class="view-section">
                <h2>Báo cáo chi phí chăm sóc</h2>
                <div class="card-grid">
                    <div id="card-month-exp" class="pet-card clickable-card selected" onclick="showExpenseDetail('month')">
                        <i class="fas fa-calendar-alt fa-2x" style="color: var(--primary); margin-bottom: 8px;"></i>
                        <h3>Chi phí tháng này</h3>
                        <p id="disp-month-expense" style="font-size:26px; color:var(--primary); font-weight:bold; margin: 10px 0;">0 VNĐ</p>
                    </div>
                    <div id="card-year-exp" class="pet-card clickable-card" onclick="showExpenseDetail('year')">
                        <i class="fas fa-chart-pie fa-2x" style="color: var(--accent); margin-bottom: 8px;"></i>
                        <h3>Tổng chi tiêu năm</h3>
                        <p id="disp-year-expense" style="font-size:26px; color:var(--accent); font-weight:bold; margin: 10px 0;">0 VNĐ</p>
                    </div>
                </div>

                <div class="table-container" style="margin-top: 25px;">
                    <h3 id="expense-detail-title"><i class="fas fa-receipt"></i> Chi tiết chi phí</h3><br>
                    <table>
                        <thead><tr><th>Ngày chi</th><th>Nội dung</th><th>Phân loại</th><th>Phương thức</th><th>Số tiền</th></tr></thead>
                        <tbody id="expense-table-body"></tbody>
                    </table>
                </div>
            </section>

            <!-- SECTION 18: KHUYẾN MÃI & VOUCHER (Click vào voucher mở modal chi tiết) -->
            <section id="cust-promos" class="view-section">
                <h2><i class="fas fa-ticket-alt" style="color:var(--accent);"></i> Khuyến mãi & Voucher giảm giá</h2>
                <p style="color:#777; margin:5px 0 20px;">Bấm trực tiếp vào từng voucher để xem thông tin, hạn dùng và lấy mã ưu đãi</p>
                <div class="card-grid" id="promos-list-customer"></div>
            </section>

            <!-- SECTION 19: TIN TỨC (Menu con chỉ ghi Tin tức, click vào mở bài báo) -->
            <section id="cust-news" class="view-section">
                <h2><i class="fas fa-newspaper" style="color:var(--primary);"></i> Tin tức</h2>
                <p style="color:#777; margin:5px 0 20px;">Tổng hợp tin tức chính thống, phác đồ phòng dịch từ cơ quan Thú y</p>
                <div class="news-list-grid" id="news-list-customer"></div>
            </section>

            <!-- SECTION 20: ĐÁNH GIÁ (Có nút hỏi recommend, nút Đồng ý & Không) -->
            <section id="cust-reviews-section" class="view-section">
                <div class="content-center-container">
                    <div class="table-container holo-card-border" style="max-width: 680px; margin:0 auto 30px;">
                        <h2 style="color: var(--primary); margin-bottom: 15px;"><i class="fas fa-edit"></i> Đánh giá dịch vụ</h2>
                        
                        <div class="input-group">
                            <label>Đánh giá số sao</label>
                            <select id="review-stars">
                                <option value="5">⭐⭐⭐⭐⭐ (5 sao - Tuyệt vời)</option>
                                <option value="4">⭐⭐⭐⭐ (4 sao - Rất tốt)</option>
                                <option value="3">⭐⭐⭐ (3 sao - Tạm ổn)</option>
                                <option value="2">⭐⭐ (2 sao - Cần cải thiện)</option>
                                <option value="1">⭐ (1 sao - Không hài lòng)</option>
                            </select>
                        </div>

                        <!-- KHỐI HỎI RECOMMEND CÓ NÚT ĐỒNG Ý / KHÔNG -->
                        <div style="background: rgba(108, 92, 231, 0.06); padding: 15px; border-radius: 12px; margin-bottom: 15px;">
                            <label style="font-weight:600; color:#444; display:block; margin-bottom:8px;">
                                <i class="fas fa-question-circle" style="color:var(--primary);"></i> Bạn có muốn recommend / giới thiệu dịch vụ nào cho khách hàng khác không?
                            </label>
                            <div style="display:flex; gap:12px; margin-bottom:10px;">
                                <button type="button" id="btn-rec-yes" class="btn-action" style="background:#e8f0fe; color:var(--primary);" onclick="setRecommendOption(true)">Đồng ý giới thiệu</button>
                                <button type="button" id="btn-rec-no" class="btn-action" style="background:#f1f2f6; color:#777;" onclick="setRecommendOption(false)">Không, cảm ơn</button>
                            </div>

                            <div id="rec-selection-box" style="display:none; margin-top:10px;">
                                <label style="font-size:13px; font-weight:600; color:#555;">Chọn dịch vụ bạn muốn gợi ý:</label>
                                <select id="review-recommend-select" style="margin-top:5px;">
                                    <option value="Cắt tỉa tạo kiểu lông">Cắt tỉa tạo kiểu lông</option>
                                    <option value="Spa tắm thảo mộc">Spa tắm thảo mộc</option>
                                    <option value="Khách sạn thú cưng phòng VIP">Khách sạn thú cưng phòng VIP</option>
                                    <option value="Khám sức khỏe tổng quát">Khám sức khỏe tổng quát</option>
                                </select>
                            </div>
                        </div>

                        <div class="input-group">
                            <label>Hình ảnh chụp trải nghiệm thực tế (Tùy chọn)</label>
                            <div style="display:flex; gap:12px; align-items:center;">
                                <img id="review-img-preview" src="" style="width:60px; height:60px; border-radius:10px; object-fit:cover; display:none; border:2px solid var(--primary);">
                                <label class="btn-upload" style="margin:0;">
                                    <i class="fas fa-image"></i> Chọn ảnh
                                    <input type="file" accept="image/*" style="display:none;" onchange="previewReviewImage(this)">
                                </label>
                                <small id="review-img-note" style="color:#888;">Chưa chọn ảnh</small>
                            </div>
                        </div>

                        <div class="input-group">
                            <label>Nhận xét và cảm nhận của bạn</label>
                            <textarea id="review-text" rows="3" placeholder="Chia sẻ cảm nhận về thái độ phục vụ, tay nghề bác sĩ/KTV..."></textarea>
                        </div>

                        <button class="btn-login" onclick="submitReview()"><i class="fas fa-paper-plane"></i> ĐĂNG BÀI ĐÁNH GIÁ</button>
                    </div>
                </div>

                <h3 style="text-align:center;">Đánh giá từ cộng đồng khách hàng</h3><br>
                <div id="reviews-stream" style="display:flex; flex-direction:column; gap:15px; max-width:750px; margin:0 auto;"></div>
            </section>
        </main>
    </div>

    <!-- ==================== CÁC MODAL HIỂN THỊ ==================== -->

    <!-- MODAL 1: BÀI BÁO TIN TỨC CHÍNH THỐNG (Click vào xem như bài báo) -->
    <div id="news-article-modal" class="modal-overlay">
        <div class="modal-content" style="max-width: 650px;">
            <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #eee; padding-bottom:10px; margin-bottom:15px;">
                <span class="badge badge-danger" id="news-modal-tag">BÁO THÚ Y CHÍNH THỐNG</span>
                <button onclick="closeModal('news-article-modal')" style="background:none; border:none; font-size:22px; cursor:pointer;">&times;</button>
            </div>
            <h2 id="news-modal-title" style="font-size:22px; color:#2d3436; margin-bottom:8px; line-height:1.4;"></h2>
            <small style="color:#888; display:block; margin-bottom:15px;"><i class="fas fa-clock"></i> <span id="news-modal-date"></span> | Nguồn: Cục Thú y & Bác sĩ PetCare Pro</small>
            
            <div id="news-modal-body" style="color:#444; font-size:14.5px; line-height:1.8; text-align:justify; max-height:55vh; overflow-y:auto;">
            </div>
            
            <div style="margin-top:20px; text-align:right;">
                <button class="btn-action btn-save" style="width:auto; padding:10px 24px;" onclick="closeModal('news-article-modal')">Đóng bài báo</button>
            </div>
        </div>
    </div>

    <!-- MODAL 2: CHI TIẾT NHẮC NHỞ (Click vào hiện thông tin chi tiết) -->
    <div id="reminder-detail-modal" class="modal-overlay">
        <div class="modal-content" style="max-width: 450px; text-align:center;">
            <i class="fas fa-clock fa-3x" style="color:var(--warning); margin-bottom:15px;"></i>
            <h3 id="rem-modal-title" style="color:#2d3436; margin-bottom:10px;"></h3>
            <div style="background:#fffdf5; border:1px dashed var(--warning); border-radius:12px; padding:15px; text-align:left; font-size:14px; line-height:1.8; margin-bottom:20px;">
                <p><i class="fas fa-paw" style="color:var(--primary); width:20px;"></i> <strong>Bé thú cưng:</strong> <span id="rem-modal-pet"></span></p>
                <p><i class="fas fa-calendar-alt" style="color:var(--primary); width:20px;"></i> <strong>Thời gian thực hiện:</strong> <span id="rem-modal-time"></span></p>
                <p><i class="fas fa-notes-medical" style="color:var(--primary); width:20px;"></i> <strong>Ghi chú bác sĩ:</strong> <span id="rem-modal-note"></span></p>
            </div>
            <button class="btn-login" style="margin:0;" onclick="closeModal('reminder-detail-modal')">ĐÃ HIỂU THÔNG TIN</button>
        </div>
    </div>

    <!-- MODAL 3: CHI TIẾT VOUCHER & NÚT LẤY MÃ -->
    <div id="voucher-detail-modal" class="modal-overlay">
        <div class="modal-content" style="max-width: 480px; text-align: center;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <span class="badge badge-pending" style="font-size:13px;" id="v-modal-code">MÃ: SPA20</span>
                <button onclick="closeModal('voucher-detail-modal')" style="background:none; border:none; font-size:22px; cursor:pointer; color:#888;">&times;</button>
            </div>

            <i class="fas fa-ticket-alt fa-3x" style="color: var(--accent); margin: 15px 0 10px;"></i>
            <h3 id="v-modal-title" style="color:#2d3436; margin-bottom:10px;">Ưu đãi PetCare</h3>
            
            <div style="background:#faf9ff; border:1px dashed var(--primary); border-radius:14px; padding:15px; text-align:left; font-size:13.5px; line-height:1.7; margin-bottom:20px;">
                <p><i class="fas fa-calendar-alt" style="color:var(--primary); width:20px;"></i> <strong>Hạn sử dụng:</strong> <span id="v-modal-expiry">31/12/2026</span></p>
                <p><i class="fas fa-gift" style="color:var(--primary); width:20px;"></i> <strong>Thông tin ưu đãi:</strong> <span id="v-modal-desc"></span></p>
                <p><i class="fas fa-info-circle" style="color:var(--primary); width:20px;"></i> <strong>Cách sử dụng:</strong> <span id="v-modal-usage"></span></p>
            </div>

            <button class="btn-login" style="margin-top:0;" onclick="claimCurrentVoucher()">
                <i class="fas fa-download"></i> LẤY VOUCHER NGAY
            </button>
        </div>
    </div>

    <!-- MODAL 4: THÊM / SỬA BÉ -->
    <div id="pet-modal" class="modal-overlay">
        <div class="modal-content">
            <h3 style="margin-bottom: 20px;">Thông tin bé thú cưng</h3>
            <div class="image-picker-container">
                <img id="pet-preview" src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=200" class="img-preview">
                <label class="btn-upload">
                    <i class="fas fa-camera"></i> Chọn ảnh bé
                    <input type="file" accept="image/*" style="display: none;" onchange="previewImage(this, 'pet-preview')">
                </label>
            </div>
            <input type="hidden" id="pet-id">
            <div class="input-group"><label>Tên bé</label><input type="text" id="pet-name" placeholder="Ví dụ: Bé Lu"></div>
            <div class="input-group"><label>Giống loài</label><input type="text" id="pet-breed" placeholder="Ví dụ: Corgi, Poodle..."></div>
            <div style="display: flex; gap: 10px;">
                <button class="btn-action" style="flex:1" onclick="closeModal('pet-modal')">Đóng</button>
                <button class="btn-action btn-save" style="flex:2; margin:0" onclick="savePet()">Lưu thông tin</button>
            </div>
        </div>
    </div>

    <!-- MODAL 5: THANH TOÁN (TIỀN MẶT HOẶC QUÉT QR TRỰC TIẾP) -->
    <div id="payment-modal" class="modal-overlay">
        <div class="modal-content" style="max-width: 460px;">
            <h3 style="margin-bottom: 10px;"><i class="fas fa-wallet"></i> Thanh toán đơn hàng</h3>
            <div style="background:#f8f9fa; padding:12px; border-radius:12px; margin-bottom:15px;">
                <p>Mặt hàng / Dịch vụ: <strong id="pay-item-name">Hạt Royal Canin</strong></p>
                <p>Số tiền thanh toán: <strong id="pay-item-price" style="color:var(--primary); font-size:18px;">320.000 VNĐ</strong></p>
            </div>

            <label style="font-weight:600; font-size:14px;">Chọn hình thức thanh toán:</label>
            <div class="payment-method-box">
                <div id="pay-opt-cod" class="payment-pill active" onclick="selectPaymentMethod('COD')">
                    <i class="fas fa-money-bill-wave"></i> Tiền mặt
                </div>
                <div id="pay-opt-qr" class="payment-pill" onclick="selectPaymentMethod('QR')">
                    <i class="fas fa-qrcode"></i> Quét mã QR
                </div>
            </div>

            <div id="qr-direct-box" style="display:none; text-align:center; padding:15px; border:2px dashed var(--primary); border-radius:16px; margin-bottom:15px; background:#faf9ff;">
                <p style="font-size:13px; color:#555; margin-bottom:10px;"><i class="fas fa-camera"></i> Quét mã QR bên dưới bằng ứng dụng ngân hàng:</p>
                <img id="direct-qr-image" src="" style="width:170px; height:170px; border-radius:10px; background:white; padding:5px; object-fit:contain; border:1px solid #ddd;">
                <div style="text-align:left; font-size:13px; margin-top:10px; line-height:1.6; background:white; padding:10px; border-radius:10px;">
                    <p>Ngân hàng: <strong id="direct-qr-bank">MB Bank</strong></p>
                    <p>STK: <strong id="direct-qr-num" style="color:var(--primary);">0901 234 567</strong></p>
                    <p>Chủ TK: <strong id="direct-qr-holder">PHONG KHAM PETCARE PRO</strong></p>
                    <p>Nội dung CK: <strong id="direct-qr-memo" style="color:var(--accent);">PETCARE 882</strong></p>
                </div>
            </div>

            <p id="pay-method-desc" style="font-size:13px; color:#666; margin-bottom:15px;">
                Bạn sẽ thanh toán trực tiếp bằng tiền mặt khi nhận hàng hoặc hoàn thành dịch vụ.
            </p>

            <div style="display: flex; gap: 10px;">
                <button class="btn-action" style="flex:1" onclick="closeModal('payment-modal')">Hủy</button>
                <button class="btn-action btn-save" style="flex:2; margin:0" onclick="submitOrderProcess()">
                    <i class="fas fa-shopping-bag"></i> Đặt hàng ngay
                </button>
            </div>
        </div>
    </div>

    <!-- <script src="js/script.js"></script> -->
    <script src="{{ asset('js/script.js') }}"></script>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            document.body.className = 'customer-mode hologram-fluid-body';
            
            if (localStorage.getItem('pc_show_login_success') === 'true') {
                showToast("Đăng nhập thành công! Chào mừng bạn.");
                localStorage.removeItem('pc_show_login_success');
            }

            updateGreetingDisplay('customer');
            refreshAllUI();
            checkVipMemberStatus();
            updateBookingDetailOptions();
            startAutoCardSlider();
            checkPendingPromosForCustomer();
        });

        function logoutToAuth() {
            localStorage.removeItem('pc_logged_role');
            window.location.replace("1.login.html");
        }
    </script>
</body>
</html>