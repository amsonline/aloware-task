<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        return view('posts.index');
    }
}
