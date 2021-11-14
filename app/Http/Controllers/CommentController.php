<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiJsonResponse;
use App\Rules\Levels;
use App\Comment;

class CommentController extends Controller
{

    use ApiJsonResponse;

    public function index() {
        $comment = new Comment;
        return $this->successResponse("Success", $comment->orderBy('created_at', 'desc')->get()->threaded());
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'username'      => 'required',
            'content'       => 'required',
            'parent_id'     => ['nullable', 'exists:App\Comment,id', new Levels]
        ], [
            'username.required'     => "We need to know your name.",
            'content.required'      => "Comments cannot be empty.",
            'parent_id.exists'      => "Comment reply is invalid."
        ]);

        if ($validator->fails()) {
            return response()->json($this->errorResponse("Comment cannot be added.", $validator->errors()->all()), 400);
        }

        try {
            $comment = new Comment;
            $comment->username = $request->get('username');
            $comment->content = $request->get('content');
            $comment->parent_id = $request->get('parent_id', null);
            $comment->save();
        }catch (Exception $e) {
            return response()->json($this->errorResponse("An error occured on adding the comment.", $e), 500);
        }

        return $this->successResponse("Comment was added successfully!", $comment->orderBy('created_at', 'desc')->get()->threaded());
    }
}
