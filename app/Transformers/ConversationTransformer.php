<?php

namespace App\Transformers;

use App\Conversation;
use League\Fractal\TransformerAbstract;

class ConversationTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'replies', 'user', 'users', 'parent'
    ];

    public function transform(Conversation $conversation)
    {
        return [
            'id'   => $conversation->id,
            'body' => $conversation->body,
            'created_at_human'  => $conversation->created_at->diffForHumans(),
            'last_reply_human'  => $conversation->last_reply ? $conversation->last_reply->diffForHumans() : null,
            'participant_count' => $conversation->usersExceptCurrentlyAuthenticated()->count(),
        ];
    }

    public function includeReplies(Conversation $conversation)
    {
        return $this->collection($conversation->replies, new ConversationTransformer);
    }

    public function includeParent(Conversation $conversation)
    {
        return $this->item($conversation->parent, new ConversationTransformer);
    }

    public function includeUser(Conversation $conversation)
    {
        return $this->item($conversation->user, new UserTransformer);
    }

    public function includeUsers(Conversation $conversation)
    {
        return $this->collection($conversation->users, new UserTransformer);
    }
}
