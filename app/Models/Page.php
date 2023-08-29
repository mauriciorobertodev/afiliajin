<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cloned_from',
        'slug',
        'user_id',
        'whatsapp_number',
        'whatsapp_message',
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
