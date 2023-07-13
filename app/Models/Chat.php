<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'chats';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

     protected $guarded = [];
    protected $fillable = [
        'sender',
        'receiver',
        'message_type',
        'payload',
        'timestamp',
    ];

    protected $casts = [
        'payload' => 'json',
        'timestamp' => 'datetime',
    ];

    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        $model->id = Str::uuid()->toString();
    });

} 
    
}
