<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    /**
     * @var null
     */
    protected $primaryKey = null;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'role_id', 'user_id', 'event_id',
        'status', 'comment'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => 'boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
