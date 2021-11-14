<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $comments = Comment::getComments();
        return view('posts.index', compact('comments'));
    }
}
