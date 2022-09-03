<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachmentable extends Model
{
    use HasFactory;

    protected $table = 'attachmentable';

    protected $fillable = [
        'attachment_id',
        'attachmentable_id',
    ];

    public function attachment() {
        return $this->belongsTo(Attachment::class, 'attachment_id', 'id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'attachmentable_id');
    }
}
