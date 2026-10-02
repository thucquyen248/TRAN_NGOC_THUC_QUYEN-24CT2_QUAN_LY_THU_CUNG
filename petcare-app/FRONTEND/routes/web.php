<?php

use Illuminate\Support\Facades\Route;

// 1. Vào trang gốc -> Tự chuyển sang /login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Trang Đăng nhập
Route::get('/login', function () {
    return view('login');
})->name('login');

// 3. Trang chính Khách hàng
Route::get('/home', function () {
    return view('index');
})->name('home');

// 4. Trang Quản trị nội bộ (Admin, Bác sĩ, Nhân viên)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// --- CÁC ROUTE DỰ PHÒNG CHỐNG LỖI 404 KHI BẤM ĐĂNG XUẤT HOẶC TRUY CẬP TÊN CŨ ---
Route::get('/1.login.html', function () {
    return redirect()->route('login');
});
Route::get('/2.index.html', function () {
    return redirect()->route('home');
});
Route::get('/3.dashboard.html', function () {
    return redirect()->route('dashboard');
});