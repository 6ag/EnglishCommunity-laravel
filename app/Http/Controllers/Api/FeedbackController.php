<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;

class FeedbackController extends BaseController
{
    public function submitFeedback(Request $request)
    {
        $feedback = Feedback::create($request->only(['contact', 'content']));
        if ($feedback) {
            // success
        } else {
            // fail
        }
    }
}
