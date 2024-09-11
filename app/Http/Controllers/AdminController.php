<?php

namespace App\Http\Controllers;

use App\Models\Api\Quiz;
use App\Models\Api\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalQuizzes = Quiz::count();
        $totalCategory = Category::count();

        return view('admin.dashboard', compact('totalQuizzes','totalCategory'));

    }
}
