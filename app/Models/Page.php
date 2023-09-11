<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'name',
        'slug',
        'user_id',
        'more_18',
        'cloned_from',
        'whatsapp_show',
        'whatsapp_number',
        'whatsapp_message',
        'cookie',
        'head_top',
        'head_bottom',
        'body_top',
        'body_bottom',
    ];

    protected $casts = [
        'whatsapp_show' => 'boolean',
        'more_18'       => 'boolean',
    ];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
