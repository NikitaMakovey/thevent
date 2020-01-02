<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title', 'short_description', 'image',
        'full_description', 'user_id', 'status',
        'event_date', 'start_at', 'end_at',
        'address', 'topic_id'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'event_date' => 'date',
        'start_at' => 'time',
        'end_at' => 'time',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function characters()
    {
        return $this->hasMany(Character::class);
    }
}
