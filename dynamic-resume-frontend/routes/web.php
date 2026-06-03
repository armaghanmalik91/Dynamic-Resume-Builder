<?php 

use Illuminate\Support\Facades\Route; 

Route::get('/', function () { 
    return view('welcome'); 
}); 

// Dono routes ek hi view load karenge jahan JS se toggle handle ho raha hai 
Route::get('/login', function () { 
    return view('auth.auth'); 
}); 

Route::get('/register', function () { 
    return view('auth.auth'); 
}); 

// Naye Routes (Dashboard view aur Settings) 
Route::get('/dashboard', function () { 
    return view('dashboard'); 
}); 

Route::get('/settings', function () { 
    return view('settings'); 
}); 

// Naya Route: Builder ka Intro Page 
Route::get('/builder-intro', function () { 
    return view('builder_intro'); 
}); 

// Naye Frontend Flow Routes 
Route::get('/experience-level', function () { 
    return view('onboarding.experience'); 
}); 

Route::get('/student-status', function () { 
    return view('onboarding.student'); 
}); 

// Naye Routes (Templates aur Upload) 
Route::get('/templates', function () { 
    return view('onboarding.templates'); 
}); 

Route::get('/upload-or-scratch', function () { 
    return view('onboarding.upload_or_scratch'); 
}); 

// Builder ka pehla step (Contact Info)
Route::get('/builder/contact', function () { 
    return view('builder.contact'); 
}); 

// Builder ka second step (Education)
Route::get('/builder/education', function () { 
    return view('builder.education'); 
});

// Builder ka third step (Work History)
Route::get('/builder/work-history', function () {
    return view('builder.work_history');
});

// Naya Route: Jobs listing page ke liye
Route::get('/jobs', function () {
    return view('jobs.index');
});

Route::get('/admin-dashboard', function () {
    return view('admin_dashboard');
});

// Naya Route: Single page for Terms, Privacy, Accessibility, Contact 
Route::get('/legal', function () { 
    return view('legal'); 
});