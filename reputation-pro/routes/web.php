<?php
use App\Http\Controllers\ReputationController;
use Illuminate\Support\Facades\Route;

// عرض الصفحة الرئيسية (الواجهة)
Route::get('/', [ReputationController::class, 'index']);

// استقبال التعليق من الجافاسكريبت ومعالجته ثم إعادة النتيجة
Route::post('/process-comment', [ReputationController::class, 'process']);