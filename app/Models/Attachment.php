<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $table = 'attachments';

    protected $fillable = [
        'name',
        'size',
        'sort',
        'description',
        'alt',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
