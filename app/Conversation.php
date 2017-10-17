<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $dates = [
        'last_reply'
    ];

    /**
     * Conversation belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * All users who particaptes in a conversation
     *
     * @return [type] [description]
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * All users except currently authenticated
     * who participates in conversation
     *
     * @return [type] [description]
     */
    public function usersExceptCurrentlyAuthenticated()
    {
        return $this->users()->where('user_id', '!=', \Auth::user()->id);
    }

    /**
     * Conversation has many Replies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Conversation::class, 'parent_id')
            ->latestFirst();
    }

    /**
     * Conversation belongs to Parent conversation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Conversation::class, 'parent_id');
    }

    public function touchLastReply()
    {
        $this->last_reply = \Carbon\Carbon::now();
        $this->save();
    }

    public function isReply()
    {
        return $this->parent_id != null ? true : false;
    }

    /**
     * Query scope LatestFirst.
     *
     * @param  \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
