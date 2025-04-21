<?php

use App\Livewire\WithdrawalRequests as EmployeeWithdrawalRequests;
use App\Livewire\Admin\WithdrawalRequests as AdminWithdrawalRequests;
use App\Livewire\Admin\EmployeesList;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//Route::view('/', 'welcome');

Route::get('/', function () {
    $component = Auth::user()->roleName === 'admin' 
        ? AdminWithdrawalRequests::class 
        : EmployeeWithdrawalRequests::class;

    return view('dashboard', compact('component'));
})->middleware(['auth', 'verified'])->name('dashboard');
/*Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/withdrawals', AdminWithdrawalRequests::class)->name('admin.withdrawals');
    Route::get('/admin/employees', EmployeesList::class)
        ->middleware(['auth', 'verified'])
        ->name('admin.employees');
        
});

Route::post('/logout', function (Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

use Illuminate\Support\Facades\Mail;
/*
Route::get('/send-test-email', function () {
    $to = 'abdeldjabar.ahmeidi@gmail.com';  // Replace with the recipient's email address.
    
    Mail::raw('Test email body', function ($message) use ($to) {
        $message->to($to)
                ->subject('Test Email');
    });
    
    return 'Email Sent';
});*/

require __DIR__.'/auth.php';

