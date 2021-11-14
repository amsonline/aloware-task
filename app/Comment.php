<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    protected $fillable = ['username', 'content'];

    public function parent() {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function newCollection(array $models = []) {
        return new CommentCollection($models);
    }

    public static function getComments() {
        return Comment::whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->get()
            ->threaded();
    }
}
