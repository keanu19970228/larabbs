<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(ReplyRequest $request, Reply $reply)
	{
	    $reply->topic_id = $request->topic_id;
	    $reply->user_id = Auth::id();
	    $reply->content = $request->content;
	    $reply->save();

		return redirect()->route('topics.show', $reply->topic_id)->with('success', '评论回复成功。');
	}

	public function destroy(Reply $reply)
	{
		$this->authorize('destroy', $reply);
		$reply->delete();

		return redirect()->route('replies.index')->with('message', 'Deleted successfully.');
	}
}
