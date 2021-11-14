<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Comment;

class Levels implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Root comments should pass
        if ($value == null) {
            return true;
        }

        $comment = Comment::find($value);

        // If reply ID is invalid, we don't have anything to do
        if ($comment == null) {
            return true;
        }

        // First level reply should pass
        if ($comment->parent == null) {
            return true;
        }

        // Second level reply should pass, too
        if ($comment->parent->parent == null) {
            return true;
        }

        // Third level reply should NOT pass
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This comment cannot be replied.';
    }
}
