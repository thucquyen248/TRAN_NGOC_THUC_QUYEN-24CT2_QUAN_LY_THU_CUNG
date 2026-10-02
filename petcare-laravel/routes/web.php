Route::get('/', function () {
    return view('login');
});
Route::get('/index', function () {
    return view('index'); 
});

Route::get('/dashboard', function () {
    return view('dashboard');
});
