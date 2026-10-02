<?php

use Illuminate\Support\Facades\Route;
use App\Models\Pet;

// 1. Trang gốc -> chuyển sang login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Trang Đăng nhập
Route::get('/login', function () {
    return view('login');
})->name('login');

// 3. Trang chính Khách hàng (hiển thị thú cưng)
Route::get('/home', function () {
    $pets = Pet::all();
    return view('index', compact('pets')); // resources/views/index.blade.php
})->name('home');

// 4. Trang Quản trị nội bộ (Admin, Bác sĩ, Nhân viên)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// --- Các route dự phòng chống lỗi 404 ---
Route::get('/1.login.html', function () {
    return redirect()->route('login');
});
Route::get('/2.index.html', function () {
    return redirect()->route('home');
});
Route::get('/3.dashboard.html', function () {
    return redirect()->route('dashboard');
});
