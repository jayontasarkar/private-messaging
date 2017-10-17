<?php

namespace App\Http\Controllers\Api;

use App\Conversation;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreConversationReplyFormRequest;
use App\Transformers\ConversationTransformer;
use Illuminate\Http\Request;

class ConversationReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(StoreConversationReplyFormRequest $request, Conversation $conversation)
    {
        $this->authorize('reply', $conversation);

        $reply = new Conversation;
        $reply->body = $request->body;
        $reply->user()->associate($request->user());

        $conversation->replies()->save($reply);
        $conversation->touchLastReply();

        return fractal()
            ->item($reply)
            ->parseIncludes(['user', 'parent', 'parent.user', 'parent.users'])
            ->transformWith(new ConversationTransformer)
            ->toArray();
    }
}
