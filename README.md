# TRAN_NGOC_THUC_QUYEN-24CT2_QUAN_LY_THU_CUNG
## Kiến trúc hệ thống & Cơ sở dữ liệu (System Architecture)

- **Database (Cơ sở dữ liệu)**: MySQL / SQL Server (`PetCare Database`)
  - Bảng dữ liệu: `users`, `owners`, `pets`, `appointments`, `services`
  - Eloquent Models (`Pet.php`, `Owner.php`, `Appointment.php`, `User.php`) kết nối trực tiếp và thực thi truy vấn SQL xuống Database.
- **Controllers & Endpoints**:
  - `PetController.php`: Xử lý API quản lý thú cưng.
  - `OwnerController.php`: Xử lý API thông tin chủ nuôi.
  - `AppointmentController.php`: Xử lý API đặt lịch hẹn.