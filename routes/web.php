<?php

use App\Models\Student;
use Illuminate\Support\Facades\Route;
use App\Models\User;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function(){
    
    return redirect('/admin/login'); 
});





//Admin
Route::get('/', [HomeController::class, 'login']);
Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::post('/login_submit', [HomeController::class, 'login_submit']);


//Registeration Process
Route::get('/registration', function () {
    $students = Student::where('is_registered',0)->get();
    return view('registration',compact('students'));
})->name('registration');
Route::post('/submit-form', [StudentController::class, 'userRegistration'])->name('user.registration');
Route::get('/get-students-by-class/{class_id}/{campus}',[StudentController::class, 'getStudentsByClass']);
Route::get('students/download-pdf', [StudentController::class, 'downloadPdf'])->name('students.download-pdf');



Route::middleware(['auth'])->group(function () {
   

    Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout']);
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard']);
    //  Route::post('/admin/status', [App\Http\Controllers\Admin\DashboardController::class, 'status']);


    Route::get('/', function () {return view('dashboard');})->name('dashboard');

    Route::get('/storage-link', function () {
            Artisan::call('storage:link');
            return response()->json(['message' => 'Storage link created successfully!']);
        }); 

        Route::get('branches',[BranchController::class, 'index'])->name('branches.index');
        Route::get('branches/create',[BranchController::class, 'create'])->name('branches.create');
        Route::post('branches',[BranchController::class, 'store'])->name('branches.store');
        Route::get('branches/{id}/edit',[BranchController::class, 'edit'])->name('branches.edit');
        Route::put('branches/{id}',[BranchController::class, 'update'])->name('branches.update');
        Route::get('branches/{id}',[BranchController::class, 'destroy'])->name('branches.destroy');
    


        Route::get('students',[StudentController::class, 'index']);
        Route::get('students/create',[StudentController::class, 'create']);
        Route::post('students',[StudentController::class, 'store']);
        Route::get('students/{id}/edit',[StudentController::class, 'edit']);
        Route::put('students/{id}',[StudentController::class, 'update']);
        Route::delete('students/{id}',[StudentController::class, 'destroy']);
        Route::get('students/{id}',[StudentController::class, 'show']);
        Route::post('students/import', [StudentController::class, 'import']);



        Route::get('students-registration',[RegistrationController::class, 'students_registration']);
        Route::post('/students/handle-selected',[RegistrationController::class,'handleSelectedStudents']);
        Route::get('class-list',[RegistrationController::class,'classList']);
        Route::delete('students/delete-registration/{id}',[RegistrationController::class, 'deleteRegistration']);
    



 

   
     
     


});

// Auth::routes();

Route::fallback(function () {
    return redirect('/'); 
});