const express = require('express');
const cors = require('cors');
const sql = require('mssql');

const app = express();
app.use(cors()); // Cho phép React truy cập
app.use(express.json());

// Cấu hình tài khoản đăng nhập SQL Server của bạn
const dbConfig = {
    user: 'sa',                      // Tài khoản SQL Server của bạn
    password: 'Bao04092006@',        // Mật khẩu SQL Server của bạn
    server: 'localhost',             // Hoặc '127.0.0.1'
    database: 'PetCare',             // Tên Database vừa tạo
    options: {
        encrypt: false,              // Để false nếu chạy localhost
        trustServerCertificate: true // Chấp nhận chứng chỉ nội bộ
    },
    port: 1433
};

// 1. API Lấy danh sách thú cưng
app.get('/api/thucung', async (req, res) => {
    try {
        let pool = await sql.connect(dbConfig);
        let result = await pool.request().query(`
            SELECT tc.MaTC, tc.TenTC, tc.GiongLoai, tc.Tuoi, tc.CanNang, tc.TinhTrangSucKhoe, kh.HoTen AS TenChu
            FROM ThuCung tc
            LEFT JOIN Khach_Hang kh ON tc.MaKH = kh.MaKH
        `);
        res.json(result.recordset); // Trả dữ liệu JSON về cho React
    } catch (err) {
        console.error("Lỗi truy vấn SQL:", err);
        res.status(500).send(err.message);
    }
});

// 2. API Lấy danh sách dịch vụ
app.get('/api/dichvu', async (req, res) => {
    try {
        let pool = await sql.connect(dbConfig);
        let result = await pool.request().query('SELECT * FROM DichVu');
        res.json(result.recordset);
    } catch (err) {
        res.status(500).send(err.message);
    }
});

// 3. API Thêm thú cưng mới (POST)
app.post('/api/thucung', async (req, res) => {
    const { tenTC, giongLoai, tuoi, canNang, tinhTrang, maKH } = req.body;
    try {
        let pool = await sql.connect(dbConfig);
        await pool.request()
            .input('ten', sql.NVarChar, tenTC)
            .input('giong', sql.NVarChar, giongLoai)
            .input('tuoi', sql.Int, tuoi)
            .input('nang', sql.Float, canNang)
            .input('tt', sql.NVarChar, tinhTrang)
            .input('makh', sql.Int, maKH)
            .query(`INSERT INTO ThuCung (TenTC, GiongLoai, Tuoi, CanNang, TinhTrangSucKhoe, MaKH)
                    VALUES (@ten, @giong, @tuoi, @nang, @tt, @makh)`);
        
        res.json({ message: "Thêm thành công!" });
    } catch (err) {
        res.status(500).send(err.message);
    }
});

// Chạy server tại cổng 5000
const PORT = 5000;
app.listen(PORT, () => {
    console.log(`Server Backend đang chạy tại: http://localhost:${PORT}`);
});